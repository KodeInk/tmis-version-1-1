<?php
/**
 * This class computes scores and also gets cached score details.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 11/27/2013
 */
class Scoring extends CI_Model
{
	#a variable to hold a user's current clout score fragmented info for use in more than one stat calls
    private $cloutScoreFragments=array();
	#store user details for reuse in this class
	private $userDetails=array();
	
	
	
	#Function to get the origins of a score based on different laues passed to it.
	public function get_score_origins($userId, $level, $variable, $scoreType, $storeId="")
	{
		$scoreDetails = array();
		
		#Level 0 re-computes the score for the passed user, updates the score in the cache and then returns the final value
		#NOTE: This assumes that the cached values for all the users have been updated
		if($level == "0")
		{
			#Compute the score based on type and return the final value
			#CLOUT SCORE
			if($scoreType == 'clout_score')
			{
				$scoreDetails = $this->compute_clout_score($userId);
				#Update the user record after recomputing
				$scoreDetails['update_user_result'] = $this->db->query($this->query_reader->get_query_by_code('update_user_value', array('user_id'=>$userId, 'field_name'=>'clout_score', 'field_value'=>(!empty($scoreDetails['score_value'])? number_format($scoreDetails['score_value'], 2, '.', ''): '0') ))); 
			}
			
			#STORE SCORE
			else if($scoreType == 'store_score')
			{
				$scoreDetails = $this->compute_store_score($userId, $storeId);
			}
			
			#MERCHANT SCORE
			else if($scoreType == 'merchant_score')
			{
				$scoreDetails = $this->compute_merchant_score($userId);
				$merchant = $this->db->query($this->query_reader->get_query_by_code('get_merchant_by_user_id', array('user_id'=>$userId)))->row_array();
				
				#Update the merchant record after recomputing
				$scoreDetails['update_merchant_result'] = $this->db->query($this->query_reader->get_query_by_code('update_merchant_value', array('merchant_id'=>$merchant['merchant_id'], 'field_name'=>'merchant_score', 'field_value'=>(!empty($scoreDetails['score_value'])? number_format($scoreDetails['score_value'], 2, '.', ''): '0') ))); 
			}
			
			#Update the database cache value after recomputing
			$scoreDetails['update_score_result'] = $this->update_score_cache($scoreType, $scoreDetails, $userId, $storeId);
		}
		
		#Level 1: Returns the top level score origins from the cache
		else if($level == "1")
		{
			$scoreDetails = $this->get_cached_score($userId, $scoreType, $storeId);
		}
		
		#Level 2: Returns the details of each score amount based on the code passed
		else if($level == "2")
		{
			$scoreDetails = $this->get_score_amout_details($userId, $variable, $scoreType, $storeId);
		}
		
		return $scoreDetails;
	}
	
	
	
	
	#Function to update the score cache value and if it is not available, create a cache record
	public function update_score_cache($scoreType, $scoreDetails, $userId, $storeId='')
	{
		$result = FALSE;
		$scoreValue = !empty($scoreDetails['score_value'])? number_format($scoreDetails['score_value'], 2, '.', ''): '0';
		$fieldName = !empty($scoreDetails['field_name'])? $scoreDetails['field_name']: 'total_score';
		
		#Update the cache score value based on the user details provided
		if($scoreType == 'clout_score')
		{
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldName, 'field_value'=>$scoreValue )));
			#Pick the score cache details to make sure the cache is updated
			$scoreCache = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_cache', array('user_id'=>$userId )))->row_array();
			
		}
		else if($scoreType == 'store_score')
		{
			$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'store_id'=>$storeId, 'field_name'=>$fieldName, 'field_value'=>$scoreValue )));
			#Pick the score cache details to make sure the cache is updated
			$scoreCache = $this->db->query($this->query_reader->get_query_by_code('get_store_score_cache', array('user_id'=>$userId, 'store_id'=>$storeId )))->row_array();
		}
		else if($scoreType == 'merchant_score')
		{
			$merchant = $this->db->query($this->query_reader->get_query_by_code('get_merchant_by_user_id', array('user_id'=>$userId)))->row_array();
			$result = $this->db->query($this->query_reader->get_query_by_code('update_merchant_score_cache_value', array('merchant_id'=>$merchant['merchant_id'], 'field_name'=>$fieldName, 'field_value'=>$scoreValue )));
			
			#Pick the score cache details to make sure the cache is updated
			$scoreCache = $this->db->query($this->query_reader->get_query_by_code('get_merchant_score_cache', array('user_id'=>$userId )))->row_array();
		}
		
		
		#However, if there is no record for the passed user details, then add a new one
		if(empty($scoreCache))
		{
			if($scoreType == 'clout_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('add_clout_score_cache', array('user_id'=>$userId, 'field_name'=>$fieldName, 'field_value'=>$scoreValue )));
			}
			else if($scoreType == 'store_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('add_store_score_cache', array('user_id'=>$userId, 'store_id'=>$storeId, 'field_name'=>$fieldName, 'field_value'=>$scoreValue )));
			}
			else if($scoreType == 'merchant_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('add_merchant_score_cache', array('merchant_id'=>$userId, 'field_name'=>$fieldName, 'field_value'=>$scoreValue )));
			}
		}
		
		
		
		return $result;
	}
	
	
	
	
	
	
	
	
	#Function to get the cached score of the passed user
	public function get_cached_score($userId, $scoreType, $storeId="", $reportType='detailed')
	{
		$scoreDetails = $finalScoreDetails = array();
		
		if($scoreType == 'clout_score')
		{
			$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_cache', array('user_id'=>$userId)))->row_array();
			
		}
		else if($scoreType == 'store_score')
		{
			$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_store_score_cache', array('user_id'=>$userId, 'store_id'=>$storeId)))->row_array();
		}
		else if($scoreType == 'merchant_score')
		{
			$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_merchant_score_cache', array('user_id'=>$userId)))->row_array();
		}
		
		#Regenerate the score if it is not available
		if(empty($scoreDetails) || $reportType == 'raw')
		{
			$this->get_score_origins($userId, '0', '', $scoreType, $storeId);
			
			#TODO: Add updating other cache values (with the cron manager)
			
			#Attempt collecting the score cache details again
			$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_'.$scoreType.'_cache', array('user_id'=>$userId, 'store_id'=>$storeId)))->row_array();
		}
		
		#Reformat the score details for display
		if(!empty($scoreDetails) && !empty($reportType) && $reportType == 'detailed')
		{
			$scoreCriteria = $this->get_criteria_by_keys(array_keys($scoreDetails)); 
			$keyDescription = $keyType = array();
			#Match the keys to the description
			foreach($scoreCriteria AS $row)
			{
				$keyDescription[$row['code']] = $row['description'];
				$keyType[$row['code']] = $row['parameter_type'];
			}
			
			#Now get all score keys matched to their values
			foreach($scoreDetails AS $key=>$value)
			{
				if(array_key_exists($key, $keyDescription))
				{
					$finalScoreDetails[$key] = array('description'=>$keyDescription[$key], 'value'=>$value, 'type'=>$keyType[$key]);
				}
			}
		}
		else
		{
			$finalScoreDetails = $scoreDetails;
		}
		
		return $finalScoreDetails;
	}
	
	
	
	#Function to compute and generate the clout score 
	public function compute_clout_score($userId)
	{
		#Get any user's cached row to pick the clout score parameters. 
		#In this case, we can use 1000000000000003, a default user ID 
		$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_cache', array('user_id'=>DUMMY_USER_ID)))->row_array();
		$scoreCriteria = $this->get_criteria_by_keys(array_keys($scoreDetails));
		#Tracks the final score for the user
		$finalScore = 0;
		
		$this->userDetails = !empty($this->userDetails)? $this->userDetails: $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$userId)))->row_array();
		$userDetails = $this->userDetails;
		
		foreach($scoreCriteria AS $row)
		{
			#CRITERIA TYPE: on_or_off
			if(in_array($row['code'], array('facebook_connected', 'email_verified', 'mobile_verified', 'profile_photo_added', 'bank_verified_and_active', 'credit_verified_and_active', 'location_services_activated', 'push_notifications_activated', 'first_payment_success', 'member_processed_payment_last7days', 'first_adrelated_payment_success', 'member_processed_promo_payment_last7days', 'has_first_public_checkin_success', 'has_public_checkin_last7days', 'has_answered_survey_in_last90days'))) 
			{
				#Is Facebook connected
				$finalScore += (($row['code'] == 'facebook_connected')? ($this->does_user_have_social_network($userId, 'Facebook', 'verified')? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0); 
				
				#Is email verified
				$finalScore += (($row['code'] == 'email_verified')? ($userDetails['email_verified'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Is mobile verified
				$finalScore += (($row['code'] == 'mobile_verified')? ($userDetails['mobile_verified'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Is profile photo added
				$finalScore += (($row['code'] == 'profile_photo_added')? (!empty($userDetails['photo_url'])? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Does the user have a verified and active bank account
				$finalScore += (($row['code'] == 'bank_verified_and_active')? ($this->does_user_have_bank_account($userId, 'is_verified', 'active')? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Is the user credit verified and active
				$finalScore += (($row['code'] == 'credit_verified_and_active')? ($this->get_user_credit($userId, 'check')? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Are location services activated
				$finalScore += (($row['code'] == 'location_services_activated')? ($userDetails['location_services_on'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Are push notifications activated
				$finalScore += (($row['code'] == 'push_notifications_activated')? ($userDetails['push_notifications_on'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has had first payment success?
				$finalScore += (($row['code'] == 'first_payment_success')? ($userDetails['made_first_payment'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has member processed payment in the last 7 days?
				$finalScore += (($row['code'] == 'member_processed_payment_last7days')? ($this->get_user_transactions($userId, 'check', array('start_date'=>date('Y-m-d', strtotime('-7 days')), 'end_date'=>date('Y-m-d')))? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has user made first ad-related payment success
				$finalScore += (($row['code'] == 'first_adrelated_payment_success')? ($userDetails['made_first_promo_payment'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has user made first ad-related payment success
				$finalScore += (($row['code'] == 'member_processed_promo_payment_last7days')? ($this->get_user_transactions($userId, 'promo_check', array('start_date'=>date('Y-m-d', strtotime('-7 days')), 'end_date'=>date('Y-m-d')))? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has user made first public checkin
				$finalScore += (($row['code'] == 'has_first_public_checkin_success')? ($userDetails['made_public_checkin'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has user made public checkin in the last 7 days?
				$finalScore += (($row['code'] == 'has_public_checkin_last7days')? ($this->get_user_checkins($userId, 'check', array('start_date'=>date('Y-m-d', strtotime('-7 days')), 'end_date'=>date('Y-m-d')))? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has the user answered a survey in the last 90 days
				$finalScore += (($row['code'] == 'has_answered_survey_in_last90days')? ($this->get_user_surveys($userId, 'check', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d')))? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
			}
			
			
			
			#Number of surveys answered in the last 90 days
			#CRITERIA TYPE: [amount]_per_[parameter]
			if($row['code'] == 'number_of_surveys_answered_in_last90days')
			{
				$surveyCount = $this->get_user_surveys($userId, 'count', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d')));
				$finalScore += $this->score_parameter($row, array($surveyCount));
			}
			
			
			#CRITERIA TYPE: rank
			if(in_array($row['code'], array('number_of_direct_referrals_last180days', 'number_of_direct_referrals_last360days', 'total_direct_referrals', 'number_of_network_referrals_last180days', 'total_network_referrals', 'spending_of_direct_referrals_last180days', 'spending_of_direct_referrals_last360days', 'total_spending_of_direct_referrals', 'spending_of_network_referrals_last180days', 'spending_of_network_referrals_last360days', 'total_spending_of_network_referrals', 'spending_last180days', 'spending_last360days', 'spending_total', 'ad_spending_last180days', 'ad_spending_last360days', 'ad_spending_total', 'cash_balance_today', 'average_cash_balance_last24months', 'credit_balance_today', 'average_credit_balance_last24months')))
			{
				$finalScore += $this->score_parameter($row, array($userId));
			}
			
			
		}
		
		#Also update the score tracking table in case the score has changed
		$result = $this->update_score_level_tracking('clout', $finalScore, $userId);
		
		
		return array('score_value'=>$finalScore);
	}
	
	
	
	
	
	#Updates the score tracking table in case the score has changed
	public function update_score_level_tracking($scoreType, $newScore, $userId, $storeId='')
	{
		$resultArray = array();
		#1. Determine level of the new score sent
		$newScoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_score_level', array('score'=>$newScore)))->row_array();
		
		#2. Check if the current level is still the same with the set parameters for the given user
		$currentScoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_score_details', array('score_type'=>$scoreType, 'user_id'=>$userId, 'store_id'=>$storeId)))->row_array();
		
		if((!empty($newScoreDetails['level']) && !empty($currentScoreDetails['level']) && $newScoreDetails['level'] != $currentScoreDetails['level']) || empty($currentScoreDetails['level']))
		{
			#3. if not, update the score tracking table
			$result1 = $this->db->query($this->query_reader->get_query_by_code('stop_score_tracking', array('user_id'=>$userId, 'store_id'=>$storeId, 'score_type'=>$scoreType, 'end_date'=>date('Y-m-d H:i:s') )));
			$result2 = $this->db->query($this->query_reader->get_query_by_code('add_score_tracking', array('user_id'=>$userId, 'store_id'=>$storeId, 'score_level'=>$newScoreDetails['level'], 'score_type'=>$scoreType, 'start_date'=>date('Y-m-d H:i:s'), 'end_date'=>'0000-00-00 00:00:00')));
			
			array_push($resultArray, $result1, $result2);
		}
		
		#Update the score cache table 
		$result = $this->db->query($this->query_reader->get_query_by_code('update_'.$scoreType.'_score_cache_value', array('user_id'=>$userId, 'store_id'=>$storeId, 'merchant_id'=>$userId, 'field_name'=>'total_score', 'field_value'=>$newScore )));
		array_push($resultArray, $result);
		
		
		#return results of this process
		return get_decision($resultArray, FALSE);
	}
	
	
	
	
	
	#Function to compute and generate the merchant score 
	public function compute_merchant_score($userId)
	{
		#Get any user's cached row to pick the clout score parameters. 
		#In this case, we can use 1000000000000003, a default user ID 
		$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_merchant_score_cache', array('user_id'=>DUMMY_USER_ID)))->row_array();
		$scoreCriteria = $this->get_criteria_by_keys(array_keys($scoreDetails));
		
		$merchantDetails = $this->db->query($this->query_reader->get_query_by_code('get_merchant_by_user_id', array('user_id'=>$userId)))->row_array();
		
		#Tracks the final score for the user
		$finalScore = 0;
		
		foreach($scoreCriteria AS $row)
		{
			$before = $finalScore;
			
			#CRITERIA TYPE: on_or_off
			if(in_array($row['code'], array('is_merchant_account_verified', 'has_merchant_ran_first_promo', 'offers_store_score_discount', 'processed_first_payment', 'is_pos_linked', 'accepts_bonus_cash', 'has_processed_payment_last24hours', 'has_processed_promo_payment_last24hours'))) 
			{
				
				#Is account verified
				$finalScore += (($row['code'] == 'is_merchant_account_verified')? ($merchantDetails['is_account_verified'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has merchant ran first promo
				$finalScore += (($row['code'] == 'has_merchant_ran_first_promo')? ($merchantDetails['has_ran_first_promo'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Does merchant offer store score discount?
				$finalScore += (($row['code'] == 'offers_store_score_discount')? ($merchantDetails['offers_store_discount'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has merchant processed first payment?
				$finalScore += (($row['code'] == 'processed_first_payment')? ($merchantDetails['has_processed_first_payment'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Is a POS linked at the merchant's location?
				$finalScore += (($row['code'] == 'is_pos_linked')? ($merchantDetails['pos_system_clout_connected'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Does merchant accept bonus cash?
				$finalScore += (($row['code'] == 'accepts_bonus_cash')? ($merchantDetails['accepts_bonus_cash'] == 'Y'? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has merchant processed a clout related transaction in the last 24 hours
				$finalScore += (($row['code'] == 'has_processed_payment_last24hours')? ($this->get_store_transactions($userId, 'check', array('start_date'=>date('Y-m-d H:i:s', strtotime('-24 hours')), 'end_date'=>date('Y-m-d')))? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
				#Has merchant processed a clout promo related transaction in the last 24 hours
				$finalScore += (($row['code'] == 'has_processed_promo_payment_last24hours')? ($this->get_store_transactions($userId, 'promo_check', array('start_date'=>date('Y-m-d H:i:s', strtotime('-24 hours')), 'end_date'=>date('Y-m-d')))? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0);
				
			}
			
			
			
			#CRITERIA TYPE: rank
			if(in_array($row['code'], array('number_of_public_checkins', 'direct_referrals_last30days', 'direct_referrals_last180days', 'direct_referrals_total', 'network_referrals_last30days', 'network_referrals_last180days', 'network_referrals_total', 'customer_spending_last30days', 'customer_spending_last180days', 'customer_spending_total', 'customer_promo_related_spending_last30days', 'customer_promo_related_spending_last180days', 'customer_promo_related_spending_total')))
			{
				$finalScore += $this->score_parameter($row, array($userId), 'merchant_score');
			}
			
			
		}
		
		
		#Also update the score tracking table in case the score has changed
		$result = $this->update_score_level_tracking('merchant', $finalScore, $userId);
		
		return array('score_value'=>$finalScore);
	}
	
	
	
	
	
	#Score a parameter based on its criteria and also on any additional info passed
	public function score_parameter($criteriaDetails, $additionalInfo=array(), $scoreType='clout_score')
	{
		#Should we refresh the score cache
		#TODO: Activate the score caching here
		#if(!empty($criteriaDetails['refresh']) && $criteriaDetails['refresh'] == 'Y') $this->cron_manager->update_score_field_cache_value($additionalInfo[0], $criteriaDetails['code'], $scoreType, (!empty($additionalInfo[1])? $additionalInfo[1]: ''));
		
		$score = 0;
		if($criteriaDetails['criteria'] == 'on_or_off')
		{
			$score = ($additionalInfo[0] == 'high')? $criteriaDetails['high_range']: $criteriaDetails['low_range'];
		}
		#e.g., 10_per_survey
		else if(strpos($criteriaDetails['criteria'], '_per_') !== FALSE)
		{
			$criteria = explode('_', $criteriaDetails['criteria']);
			#Multiply the amount to what each item (such as survey) represents
			$tempScore = !empty($additionalInfo[0])? $additionalInfo[0]*$criteria[0]: $criteriaDetails['low_range'];
			$score = ($tempScore > $criteriaDetails['high_range'])? $criteriaDetails['high_range']: $tempScore;
		}
		#In this case, additionalInfo is used to pass the necessary IDs
		else if($criteriaDetails['criteria'] == 'rank')
		{
			if($scoreType == 'clout_score')
			{
				#Pick the percent rank from the database for the criteria code
				$percentRank = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_percent_rank', array('user_id'=>$additionalInfo[0], 'criteria_code'=>$criteriaDetails['code'], 'criteria_high'=>$criteriaDetails['high_range'])))->row_array();
				
			}
			else if($scoreType == 'store_score')
			{
				#Get the store score code
				#TEMPORARY. Remove this line when above cache functionality is reviewed and working fine 
				$result = $this->compute_store_score_code($additionalInfo[0], $additionalInfo[1], $criteriaDetails['code'], (!empty($criteriaDetails['refresh'])? $criteriaDetails['refresh']: 'N'));
				
				#Pick the percent rank from the database for the criteria code
				$percentRank = $this->db->query($this->query_reader->get_query_by_code('get_store_score_percent_rank', array('user_id'=>$additionalInfo[0], 'store_id'=>$additionalInfo[1], 'criteria_code'=>$criteriaDetails['code'], 'criteria_high'=>$criteriaDetails['high_range'])))->row_array();
			}
			else if($scoreType == 'merchant_score')
			{
				#Pick the percent rank from the database for the criteria code
				$percentRank = $this->db->query($this->query_reader->get_query_by_code('get_merchant_score_percent_rank', array('user_id'=>$additionalInfo[0], 'criteria_code'=>$criteriaDetails['code'], 'criteria_high'=>$criteriaDetails['high_range'])))->row_array();
			}
			
			$percentRank['score_value'] = (empty($percentRank['total_others']))? (empty($percentRank['code_value']) && empty($percentRank['total_others'])? 0: $criteriaDetails['high_range']): $percentRank['score_value'];
			$score = !empty($percentRank['score_value'])? $percentRank['score_value']: 0;
		}
		
		return $score;
	}
	
	
	
	
	#Compute the store score code if not available
	public function compute_store_score_code($userId, $storeId, $criteriaCode, $refreshFlag='N')
	{
		$resultArray = array();
		
		#1. Attempt to get the store cache
		$storeScoreCache = $this->db->query($this->query_reader->get_query_by_code('get_store_score_cache', array('user_id'=>$userId, 'store_id'=>$storeId)))->row_array();
		
		#2. Compute the store score code value if still default
		if($refreshFlag == 'N' && !empty($storeScoreCache[$criteriaCode]))
		{
			$codeValue = $storeScoreCache[$criteriaCode];
		}
		#Recompute the store score value
		else
		{
			$codeValue = $this->generate_score_value($userId, $storeId, $criteriaCode);
			$updateScoreCache = TRUE;
		}
		
		#3. If cache is not available, create it
		if(!empty($updateScoreCache))
		{
			$result =  $this->db->query($this->query_reader->get_query_by_code((!empty($storeScoreCache)? 'update_store_score_cache_value': 'add_store_score_cache'), array('user_id'=>$userId, 'store_id'=>$storeId, 'field_name'=>$criteriaCode, 'field_value'=>$codeValue)));
		}
		
		#4. If $resultArray still empty, just return true and move on
		return get_decision($resultArray);
	}
	
	
	
	
	
	#Generate a score value given the code and score type
	public function generate_score_value($userId, $storeId, $criteriaCode, $scoreType='store_score')
	{
		
		switch($criteriaCode)
		{
			case 'my_store_spending_last90days';
				$value = $this->get_store_transactions($userId, 'totals', array('start_date'=>date('Y-m-d H:i:s', strtotime('-90 days'))), $storeId);
			break;
			
			case 'my_store_spending_last12months':
				$value = $this->get_store_transactions($userId, 'totals', array('start_date'=>date('Y-m-d H:i:s', strtotime('-12 months'))), $storeId);
			break;
			
			case 'my_store_spending_lifetime':
				$value = $this->get_store_transactions($userId, 'totals', array(), $storeId);
			break;
			
			case 'did_store_survey_last90days':
				$value = $this->get_user_surveys($userId, 'check', array('start_date'=>date('Y-m-d H:i:s', strtotime('-90 days')), 'end_date'=>date('Y-m-d')), $storeId)? 'Y': 'N';
			break;
			
			case 'my_direct_competitors_spending_last90days':
				$value = $this->get_store_spending($userId, 'competitor_total', array('start_date'=>date('Y-m-d H:i:s', strtotime('-90 days'))), $storeId);
			break;
			
			case 'my_direct_competitors_spending_last12months':
				$value = $this->get_store_spending($userId, 'competitor_total', array('start_date'=>date('Y-m-d H:i:s', strtotime('-12 months'))), $storeId);
			break;
			
			case 'my_direct_competitors_spending_lifetime':
				$value = $this->get_store_spending($userId, 'competitor_total', array(), $storeId);
			break;
			
			case 'did_competitor_store_survey_last90days':
				$value = $this->get_user_surveys($userId, 'competitor_check', array('start_date'=>date('Y-m-d H:i:s', strtotime('-90 days')), 'end_date'=>date('Y-m-d')), $storeId)? 'Y': 'N';
			break;
			
			case 'my_category_spending_last90days':
				$value = $this->get_category_spending($userId, 'my_category_total', array('start_date'=>date('Y-m-d H:i:s', strtotime('-90 days'))), $storeId);
			break;
			
			case 'my_category_spending_last12months':
				$value = $this->get_category_spending($userId, 'my_category_total', array('start_date'=>date('Y-m-d H:i:s', strtotime('-12 months'))), $storeId);
			break;
			
			case 'my_category_spending_lifetime':
				$value = $this->get_category_spending($userId, 'my_category_total', array(), $storeId);
			break;
			
			case 'did_my_category_survey_last90days':
				$value = $this->get_user_surveys($userId, 'category_check', array('start_date'=>date('Y-m-d H:i:s', strtotime('-90 days'))), $storeId)? 'Y': 'N';
			break;
			
			case 'related_categories_spending_last90days':
				$value = $this->get_category_spending($userId, 'related_category_total', array('start_date'=>date('Y-m-d H:i:s', strtotime('-90 days')), 'end_date'=>date('Y-m-d')), $storeId);
			break;
			
			case 'related_categories_spending_last12months':
				$value = $this->get_category_spending($userId, 'related_category_total', array('start_date'=>date('Y-m-d H:i:s', strtotime('-12 months')), 'end_date'=>date('Y-m-d')), $storeId);
			break;
			
			case 'related_categories_spending_lifetime':
				$value = $this->get_category_spending($userId, 'related_category_total', array(), $storeId);
			break;
			
			case 'did_related_categories_survey_last90days':
				$value = $this->get_user_surveys($userId, 'related_category_check', array('start_date'=>date('Y-m-d H:i:s', strtotime('-90 days'))), $storeId)? 'Y': 'N'; 
			break;
			
			case 'cash_balance_today':
				$value = $this->get_user_account_balance($userId, 'cash');
			break;
			
			case 'average_cash_balance_last24months':
				$value = $this->get_user_account_balance($userId, 'cash', array('start_date'=>date('Y-m-d H:i:s', strtotime('-24 months')), 'end_date'=>date('Y-m-d H:i:s')) );
			break;
			
			case 'credit_balance_today':
				$value = $this->get_user_account_balance($userId, 'credit');
			break;
			
			case 'average_credit_balance_last24months':
				$value = $this->get_user_account_balance($userId, 'credit', array('start_date'=>date('Y-m-d H:i:s', strtotime('-24 months')), 'end_date'=>date('Y-m-d H:i:s')) );
			break;
			
			
			
			
			default:
				$value = "";
			break;
		}
		
		return $value;
	}
	
	
	
	
	
	
	
	#Function to get details of a score amount
	public function get_score_amout_details($userId, $scoreCode, $scoreType, $storeId='')
	{
		$scoreDetails = array();
		
		#Cash balance
		if($scoreCode == 'average_cash_balance_last24months')
		{
			$scoreDetails = $this->get_user_cash($userId, 'list', array('start_date'=>date('Y-m-d', strtotime('-24 months')), 'end_date'=>date('Y-m-d')), 'monthly'); 
		}
		
		#Credit
		else if($scoreCode == 'average_credit_balance_last24months')
		{
			$scoreDetails = $this->get_user_credit($userId, 'list', array('start_date'=>date('Y-m-d', strtotime('-24 months')), 'end_date'=>date('Y-m-d')), 'monthly'); 
		}
		
		#Surveys
		else if($scoreCode == 'number_of_surveys_answered_in_last90days')
		{
			$scoreDetails = $this->get_user_surveys($userId, 'list', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d')), ''); 
		}
		
		#User Spending
		else if(in_array($scoreCode,array('spending_last180days', 'spending_last360days', 'spending_total', 'ad_spending_last180days', 'ad_spending_last360days', 'ad_spending_total')))
		{
			#All spending or only ad-related spending?
			$listType = (strpos($scoreCode, 'ad_') !== FALSE || strpos($scoreCode, 'promo_') !== FALSE)? 'promo_list': 'list';
			$startDate = $this->format_date_on_clue($scoreCode);
			
			#Now get the details of the score item
			$scoreDetails = $this->get_user_transactions($userId, $listType, array('start_date'=>$startDate, 'end_date'=>date('Y-m-d')), $scoreCode); 
		}
		
		
		#Store/Merchant related spending
		else if(in_array($scoreCode,array('customer_spending_last30days', 'customer_spending_last180days', 'customer_spending_total', 'customer_promo_related_spending_last30days', 'customer_promo_related_spending_last180days', 'customer_promo_related_spending_total')))
		{
			#All spending or only ad-related spending?
			$listType = (strpos($scoreCode, 'promo_') !== FALSE)? 'promo_list': 'list';
			$startDate = $this->format_date_on_clue($scoreCode);
			
			#Now get the details of the score item
			$scoreDetails = $this->get_store_transactions($userId, $listType, array('start_date'=>$startDate, 'end_date'=>date('Y-m-d')), $storeId); 
		}
		
		
		#Referral data
		#'direct_referrals_last30days' and so on are MERCHANT VARIABLES
		else if(in_array($scoreCode,array('number_of_direct_referrals_last180days', 'number_of_direct_referrals_last360days', 'total_direct_referrals', 'number_of_network_referrals_last180days', 'total_network_referrals',           'direct_referrals_last30days', 'direct_referrals_last180days', 'direct_referrals_total', 'network_referrals_last30days', 'network_referrals_last180days', 'network_referrals_total')))
		{
			$startDate = $this->format_date_on_clue($scoreCode);
			#Direct or network
			$listType = (strpos($scoreCode, 'network_') !== FALSE)? 'network_list': 'list';
			
			$scoreDetails = $this->get_user_referrals($userId, $listType, array('start_date'=>$startDate, 'end_date'=>date('Y-m-d')), $scoreCode); 
		}
		
		
		#Spending of referrals
		else if(in_array($scoreCode,array('spending_of_direct_referrals_last180days', 'spending_of_direct_referrals_last360days', 'total_spending_of_direct_referrals', 'spending_of_network_referrals_last180days', 'spending_of_network_referrals_last360days', 'total_spending_of_network_referrals')))
		{
			$startDate = $this->format_date_on_clue($scoreCode);
			#Direct or network
			$listType = (strpos($scoreCode, 'network_') !== FALSE)? 'network_list': 'list';
			
			$scoreDetails = $this->get_referral_spending($userId, $listType, array('start_date'=>$startDate, 'end_date'=>date('Y-m-d')), $scoreCode); 
		}
		
		#My store spending
		else if(in_array($scoreCode,array('my_store_spending_last90days', 'my_store_spending_last12months', 'my_store_spending_lifetime', 'my_direct_competitors_spending_last90days', 'my_direct_competitors_spending_last12months', 'my_direct_competitors_spending_lifetime')))
		{
			$startDate = $this->format_date_on_clue($scoreCode);
			#my store or direct competitor's
			$listType = (strpos($scoreCode, 'direct_competitors_') !== FALSE)? 'competitor_list': 'list';
			
			$scoreDetails = $this->get_store_spending($userId, $listType, array('start_date'=>$startDate, 'end_date'=>date('Y-m-d')), $storeId);
		}
		
		#Spending in my store category
		else if(in_array($scoreCode,array('my_category_spending_last90days', 'my_category_spending_last12months', 'my_category_spending_lifetime', 'related_categories_spending_last90days', 'related_categories_spending_last12months', 'related_categories_spending_lifetime')))
		{
			$startDate = $this->format_date_on_clue($scoreCode);
			#my category or related categories
			$listType = (strpos($scoreCode, 'related_categories_') !== FALSE)? 'related_category_list': 'list';
			
			$scoreDetails = $this->get_category_spending($userId, $listType, array('start_date'=>$startDate, 'end_date'=>date('Y-m-d')), $storeId);
		}
		
		#Return the score details
		return $scoreDetails;
	}
	
	
	#Check if the user has the specified social network and if it is verified or not
	public function does_user_have_social_network($userId, $socialNetwork, $status='')
	{
		$result = FALSE;
		
		#Attempt getting a record of the social network
		$socialRecord = $this->db->query($this->query_reader->get_query_by_code('get_user_social_network', array('user_id'=>$userId, 'social_network'=>$socialNetwork)))->row_array();
		
		#Check if the social network record exists and return true if the status meets the required status
		if(!empty($socialRecord) && ((!empty($status) && $socialRecord['status'] == $status) || empty($status)))
		{
			$result = TRUE;
		}
		
		return $result;
	}
	
	
	#Function to determine if a user has a bank account, verified or matching a given status
	public function does_user_have_bank_account($userId, $isVerified='', $status='')
	{
		$queryPart = '';
		#Add any requirements if included
		if(!empty($isVerified))
		{
			$queryPart .= " AND is_verified='Y' ";
		}
		
		if(!empty($status))
		{
			$queryPart .= " AND status='".$status."' "; 
		}
		
		#Attempt getting a record of the bank account
		$bankAccount = $this->db->query($this->query_reader->get_query_by_code('get_user_bank_account', array('user_id'=>$userId, 'query_part'=>$queryPart)))->row_array();
		
		#Check if a bank account with the desired parameters exists
		$result = !empty($bankAccount)? TRUE: FALSE;
		
		return $result;
	}
	
	
	#Get the user credit tracking
	public function get_user_credit($userId, $action, $dateRange=array(), $summarizeBy='')
	{
		#Just checking if we are tracking the user credit
		if($action == 'check' || $action == 'latest')
		{
			$userCredit = $this->db->query($this->query_reader->get_query_by_code('get_user_balance_tracking', array('table_name'=>'user_credit_tracking', 'user_id'=>$userId, 'query_part'=>" AND is_latest='Y' ")))->row_array();
			
			if($action == 'latest')
			{
				$result = !empty($userCredit['credit_amount'])?$userCredit['credit_amount']:0;
			}
			else if($action == 'check')
			{
				$result = !empty($userCredit)? TRUE: FALSE;
			}
			
		}
		
		else if($action == 'average')
		{
			$userCredit = $this->db->query($this->query_reader->get_query_by_code('get_user_average_credit', array('user_id'=>$userId, 'query_part'=>" AND DATEDIFF(DATE(read_date), DATE('".$dateRange['start_date']."')) >= 0 AND DATEDIFF(DATE('".$dateRange['end_date']."'), DATE(read_date)) >= 0 ")))->row_array();
			
			$result = $userCredit['average_balance'];
		
		}
		
		else if($action == 'list')
		{
			$userCredit = $this->db->query($this->query_reader->get_query_by_code('get_user_credit_tracking', array('user_id'=>$userId, 'query_part'=>" AND DATEDIFF(DATE(read_date), DATE('".$dateRange['start_date']."')) >= 0 AND DATEDIFF(DATE('".$dateRange['end_date']."'), DATE(read_date)) >= 0 ")))->result_array();
			
			$result = $userCredit;
			
			#TODO: Add summarizing by month/day using $summarizeBy variable
		}
		
		return $result;
	}
	
	
	#Get the user cash tracking
	public function get_user_cash($userId, $action, $dateRange=array(), $summarizeBy='')
	{
		#Just checking if we are tracking the user cash
		if($action == 'check' || $action == 'latest')
		{
			$userCash = $this->db->query($this->query_reader->get_query_by_code('get_user_balance_tracking', array('table_name'=>'user_cash_tracking', 'user_id'=>$userId, 'query_part'=>" AND is_latest='Y' ")))->row_array();
			
			if($action == 'latest')
			{
				$result = !empty($userCash['cash_amount'])? $userCash['cash_amount']: 0;
			}
			else if($action == 'check')
			{
				$result = !empty($userCash)? TRUE: FALSE;
			}
			
		}
		
		else if($action == 'average')
		{
			$userCash = $this->db->query($this->query_reader->get_query_by_code('get_user_average_cash', array('user_id'=>$userId, 'query_part'=>" AND DATEDIFF(DATE(read_date), DATE('".$dateRange['start_date']."')) >= 0 AND DATEDIFF(DATE('".$dateRange['end_date']."'), DATE(read_date)) >= 0 ")))->row_array();
			
			$result = $userCash['average_balance'];
		
		}
		
		else if($action == 'list')
		{
			$userCash = $this->db->query($this->query_reader->get_query_by_code('get_user_cash_tracking', array('user_id'=>$userId, 'query_part'=>" AND DATEDIFF(DATE(read_date), DATE('".$dateRange['start_date']."')) >= 0 AND DATEDIFF(DATE('".$dateRange['end_date']."'), DATE(read_date)) >= 0 ")))->result_array();
			
			$result = $userCash;
			
			#TODO: Add summarizing by month/day using $summarizeBy variable
			
		}
		
		return $result;
	}
	
	
	
	
	#Get the user geo tracking
	public function get_user_checkins($userId, $action, $dateRange=array(), $summarizeBy='', $storeId='')
	{
		#Just checking if we are tracking the user credit
		if($action == 'check')
		{
			$userCheckins = $this->db->query($this->query_reader->get_query_by_code('get_user_checkins', array('user_id'=>$userId, 'query_part'=>" AND DATEDIFF(DATE(tracking_time), DATE('".$dateRange['start_date']."')) >= 0 AND DATEDIFF(DATE('".$dateRange['end_date']."'), DATE(tracking_time)) >= 0  LIMIT 0,1; ")))->row_array();
			
			$result = !empty($userCheckins)? TRUE: FALSE;
			
		}
		else if($action == 'list')
		{
			$result = $this->db->query($this->query_reader->get_query_by_code('get_user_checkins', array('user_id'=>$userId, 'query_part'=>" AND DATEDIFF(DATE(tracking_time), DATE('".$dateRange['start_date']."')) >= 0 AND DATEDIFF(DATE('".$dateRange['end_date']."'), DATE(tracking_time)) >= 0 ")))->result_array();
		}
		
		else if($action == 'total')
		{
			$trackingCondition = !empty($dateRange['start_date'])? " AND DATEDIFF(DATE(T.tracking_time), DATE('".$dateRange['start_date']."')) >= 0 AND DATEDIFF(DATE('".$dateRange['end_date']."'), DATE(T.tracking_time)) >= 0 ": "";
			$transactionCondition = !empty($dateRange['start_date'])? " AND DATEDIFF(DATE(start_date), DATE('".$dateRange['start_date']."')) >= 0 AND DATEDIFF(DATE('".$dateRange['end_date']."'), DATE(start_date)) >= 0 ": "";
			
			#TODO: Add condition for pulling tracking by store
			$otherCondition = "";
			
			if($summarizeBy == 'merchant')
			{
				$trackingTotals = $this->db->query($this->query_reader->get_query_by_code('get_user_merchant_checkin_total', array('user_id'=>$userId, 'tracking_date_condition'=>$trackingCondition, 'transaction_date_condition'=>$transactionCondition, 'other_condition'=>$otherCondition)))->row_array();
				$result = $trackingTotals['checkin_count'];
			}
		}
		
		return $result;
	}
	
	
	
	
	#Get the user surveys
	public function get_user_surveys($userId, $action, $dateRange=array(), $storeId='')
	{
		$additionalQuery = " AND DATEDIFF(DATE(R.response_date), DATE('".$dateRange['start_date']."')) >= 0 AND DATEDIFF(DATE('".$dateRange['end_date']."'), DATE(R.response_date)) >= 0 ";
		
		#Just checking if the user answered a survey
		if($action == 'check' || $action == 'competitor_check' || $action == 'category_check' || $action == 'related_category_check')
		{
			#You are checking by the store
			if(!empty($storeId))
			{
				if($action == 'competitor_check')
				{
					$userSurveys = $this->db->query($this->query_reader->get_query_by_code('get_user_competitor_store_surveys', array('user_id'=>$userId, 'store_id'=>$storeId, 'query_part'=>$additionalQuery)))->row_array();
				}
				else if($action == 'category_check' || $action == 'related_category_check')
				{
					#First get the store categories
					$myCategories = $this->db->query($this->query_reader->get_query_by_code('get_my_store_categories', array('store_id'=>$storeId)))->row_array();
					$categories = !empty($myCategories['my_categories'])? explode(",", $myCategories['my_categories']): array();
					
					#Get related categories
					if($action == 'related_category_check')
					{
						$categories = $this->db->query($this->query_reader->get_query_by_code('get_related_categories', array('store_categories'=>"'".implode("','", $categories)."'")))->result_array();
					}
					
					#Go through the store categories until you hit a user's survey
					foreach($categories AS $category)
					{
						#Extract the category code for checking for user surveys
						$code = ($action == 'related_category_check')? $category['code']: $category;
						$userSurveys = $this->db->query($this->query_reader->get_query_by_code('get_user_category_system_surveys', array('user_id'=>$userId, 'code'=>$code, 'query_part'=>$additionalQuery)))->row_array();
						#Just checking if there are any records
						if(!empty($userSurveys))
						{
							break;
						}
					}
				}
				else 
				{
					$userSurveys = $this->db->query($this->query_reader->get_query_by_code('get_user_store_surveys', array('user_id'=>$userId, 'store_id'=>$storeId, 'query_part'=>$additionalQuery)))->row_array(); 
				}
			}
			else
			{
				$userSurveys = $this->db->query($this->query_reader->get_query_by_code('get_user_surveys', array('user_id'=>$userId, 'query_part'=>$additionalQuery)))->row_array();
			}
			
			$result = !empty($userSurveys)? TRUE: FALSE;
		}
		#Just count the number of surveys done
		else if($action == 'count')
		{
			$survey = $this->db->query($this->query_reader->get_query_by_code('count_user_surveys', array('user_id'=>$userId, 'query_part'=>$additionalQuery)))->row_array();
			
			$result = $survey['survey_count'];
		}
		#Return a list (with details) of the surveys done
		else if($action == 'list')
		{
			$result = $this->db->query($this->query_reader->get_query_by_code('get_user_surveys', array('user_id'=>$userId, 'query_part'=>$additionalQuery)))->result_array();
		}
		
		return $result;
	}
	
	
	
	
	
	
	
	
	#Get criteria info given a list of keys
	public function get_criteria_by_keys($keysList, $queryPart='', $returnType='raw')
	{
		$scoreCriteria = $this->db->query($this->query_reader->get_query_by_code('get_score_criteria_description', array('criteria_list'=>"'".implode("','", $keysList)."'", 'query_part'=>$queryPart)))->result_array();
		
		if($returnType == 'array')
		{
			$criteria = array();
			#Make DB result associative array so that the details are easier to retrieve
			foreach($scoreCriteria AS $criteriaDetails)
			{
				$criteria[$criteriaDetails['code']] = $criteriaDetails;
			}
			return $criteria;
		}
		else
		{
			return $scoreCriteria;
		}
		
	}
	
		
	
	#Get transactions for a given user
	public function get_user_transactions($userId, $action, $dateRange=array(), $summarizeBy='')
	{
		$result = FALSE;
		
		#Just checking
		if($action == 'check' || $action == 'promo_check')
		{
			$additionalQuery = ($action == 'promo_check')? " AND T.related_ad_id != '' ": "";
			
			$userTransactions = $this->db->query($this->query_reader->get_query_by_code('get_user_transactions', array('user_id'=>$userId, 'query_part'=>" AND DATEDIFF(DATE(T.start_date), DATE('".$dateRange['start_date']."')) >= 0 ".$additionalQuery." LIMIT 0,1; ")))->result_array();
			
			$result = !empty($userTransactions)? TRUE: FALSE;
			
		}
		#getting lists
		else if($action == 'list' || $action == 'promo_list')
		{
			#Add more conditions based on the required data list
			$firstAdditionalQuery = ($action == 'promo_list')? " AND T.related_ad_id != '' ": "";
			$secondAdditionalQuery = (!empty($dateRange['start_date']))? " AND DATEDIFF(DATE(T.start_date), DATE('".$dateRange['start_date']."')) >= 0 ": "";
			$secondAdditionalQuery .= (!empty($dateRange['end_date']))? " AND DATEDIFF(DATE(start_date), DATE('".$dateRange['end_date']."')) <= 0 ": "";
			$finalAdditionalQuery = ($action == 'promo_list')? $secondAdditionalQuery.$firstAdditionalQuery: $secondAdditionalQuery;
			
			#Now collect the data from the database
			$userTransactions = $this->db->query($this->query_reader->get_query_by_code('get_user_transactions', array('user_id'=>$userId, 'query_part'=>$finalAdditionalQuery." ORDER BY T.start_date DESC ")))->result_array();
			
			$result = $userTransactions;
		}
		#getting totals
		else if($action == 'totals' || $action == 'promo_totals')
		{
			#Add more conditions based on the required data list
			$firstAdditionalQuery = ($action == 'promo_totals')? " AND related_ad_id != '' ": "";
			$secondAdditionalQuery = (!empty($dateRange['start_date']))? " AND DATEDIFF(DATE(start_date), DATE('".$dateRange['start_date']."')) >= 0 ": "";
			$secondAdditionalQuery .= (!empty($dateRange['end_date']))? " AND DATEDIFF(DATE(start_date), DATE('".$dateRange['end_date']."')) <= 0 ": "";
			$finalAdditionalQuery = ($action == 'promo_totals')? $secondAdditionalQuery.$firstAdditionalQuery: $secondAdditionalQuery;
			
			#Now collect the data from the database
			$userTransactions = $this->db->query($this->query_reader->get_query_by_code('get_user_transaction_totals', array('user_id'=>$userId, 'query_part'=>$finalAdditionalQuery)))->row_array();
			
			$result = $userTransactions['spending_total'];
		}
		
		return $result;
	}
	
	
	
	
	
		
	
	#Get transactions for a given merchant/store (identified by the owner ID)
	public function get_store_transactions($userId, $action, $dateRange=array(), $storeId='')
	{
		$result = FALSE;
		#Just checking
		if($action == 'check' || $action == 'promo_check')
		{
			$additionalQuery = ($action == 'promo_check')? " AND T.related_ad_id != '' ": "";
			
			$userTransactions = $this->db->query($this->query_reader->get_query_by_code('get_merchant_transactions', array('user_id'=>$userId, 'query_part'=>" AND TIMESTAMPDIFF(HOUR,'".$dateRange['start_date']."', T.start_date) >= 0 ".$additionalQuery." LIMIT 0,1; ")))->result_array();
			
			$result = !empty($userTransactions)? TRUE: FALSE;
			
		}
		else if($action == 'list' || $action == 'promo_list')
		{
			#Add more conditions based on the passed data list
			$firstAdditionalQuery = ($action == 'promo_list')? " AND T.related_ad_id != '' ": "";
			$secondAdditionalQuery = (!empty($dateRange['start_date']))? " AND DATEDIFF(DATE(T.start_date), DATE('".$dateRange['start_date']."')) >= 0 ": "";
			$thirdAdditionalQuery = (!empty($storeId))? " AND T.store_id = '".$storeId."' ": "";
			$finalAdditionalQuery = ($action == 'promo_list')? $secondAdditionalQuery.$firstAdditionalQuery: $secondAdditionalQuery;
			
			#Now collect the data from the database
			$userTransactions = $this->db->query($this->query_reader->get_query_by_code('get_merchant_transactions', array('user_id'=>$userId, 'query_part'=>$finalAdditionalQuery.$thirdAdditionalQuery." ORDER BY T.start_date DESC ")))->result_array();
			
			$result = $userTransactions;
		}
		
		else if($action == 'totals' || $action == 'promo_totals')
		{
			#Add more conditions based on the required data list
			$firstAdditionalQuery = ($action == 'promo_totals')? " AND T.related_ad_id != '' ": "";
			$secondAdditionalQuery = (!empty($dateRange['start_date']))? " AND DATEDIFF(DATE(T.start_date), DATE('".$dateRange['start_date']."')) >= 0 ": "";
			$thirdAdditionalQuery = (!empty($storeId))? " AND T.store_id = '".$storeId."' ": "";
			$finalAdditionalQuery = ($action == 'promo_totals')? $secondAdditionalQuery.$firstAdditionalQuery: $secondAdditionalQuery;
			
			#Now collect the data from the database
			$userTransactions = $this->db->query($this->query_reader->get_query_by_code('get_merchant_transaction_totals', array('user_id'=>$userId, 'query_part'=>$finalAdditionalQuery.$thirdAdditionalQuery)))->row_array();
			
			$result = $userTransactions['spending_total'];
		}
		
		return $result;
	}
	
	
	
	#Function to get the user's referrals given the user ID
	public function get_user_referrals($userId, $action, $dateRange=array(), $summarizeBy=array())
	{
		#getting direct referrals
		if($action == 'list' || $action == 'count' || $action == 'list_ids')
		{
			#Add more conditions based on the required data list
			$additionalQuery = (!empty($dateRange['start_date']))? " AND DATEDIFF(DATE(R.activation_date), DATE('".$dateRange['start_date']."')) >= 0 ": "";
			
			if($action == 'count')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('get_user_referrals', array('user_id'=>$userId, 'query_part'=>$additionalQuery)))->num_rows();
			}
			else if($action == 'list_ids')
			{
				$directReferralIds = $this->db->query($this->query_reader->get_query_by_code('get_referral_ids', array('user_id'=>$userId, 'query_part'=>$additionalQuery)))->result_array();
				$result = array();
				
				foreach($directReferralIds AS $referralIds)
				{
					array_push($result, $referralIds['user_id']);
				}
				
			}
			else if($action == 'list')
			{
				#Now collect the data from the database
				$userReferrals = $this->db->query($this->query_reader->get_query_by_code('get_user_referrals', array('user_id'=>$userId, 'query_part'=>$additionalQuery)))->result_array();
			
				$result = $userReferrals;
			}
			
		}
		
		#getting network referrals
		else if($action == 'network_list' || $action == 'network_count' || $action == 'network_list_ids' || $action == 'network_level_count' || $action == 'network_level_ids')
		{
			#Add more conditions based on the required data list
			$additionalQuery = (!empty($dateRange['start_date']))? " AND DATEDIFF(DATE(R.activation_date), DATE('".$dateRange['start_date']."')) >= 0 ": "";
			
			#For tracking the list of referrals
			$secondLevelReferrals = $thirdLevelReferrals = $fourthLevelReferrals = array();
			
			#First get the direct referrals
			$directReferrals = $this->db->query($this->query_reader->get_query_by_code('get_referral_ids', array('user_id'=>$userId, 'query_part'=>'')))->result_array();
			
			foreach($directReferrals AS $level1Row)
			{
				#Get the second level referrals using the direct referrals
				$secondLevel = $this->db->query($this->query_reader->get_query_by_code('get_referral_ids', array('user_id'=>$level1Row['user_id'], 'query_part'=>$additionalQuery)))->result_array();
				
				foreach($secondLevel AS $level2Row)
				{
					$thirdLevel = $this->db->query($this->query_reader->get_query_by_code('get_referral_ids', array('user_id'=>$level2Row['user_id'], 'query_part'=>$additionalQuery)))->result_array();
					
					#Keep track of the referrals
					array_push($secondLevelReferrals, $level2Row['user_id']);
					
					foreach($thirdLevel AS $level3Row)
					{
						$fourthLevel = $this->db->query($this->query_reader->get_query_by_code('get_referral_ids', array('user_id'=>$level3Row['user_id'], 'query_part'=>$additionalQuery)))->result_array();
					
						#Keep track of the referrals
						array_push($thirdLevelReferrals, $level3Row['user_id']);
						
						foreach($fourthLevel AS $level4Row)
						{
							#Keep track of the referrals
							array_push($fourthLevelReferrals, $level4Row['user_id']);
						}#End fourth level
					}#End third level
				}#End second level
			}#End direct level
			
			
			#Collect all the referral user IDs
			$networkReferralIds = array_merge($secondLevelReferrals, $thirdLevelReferrals, $fourthLevelReferrals);
			$levelTrack = array('2'=>$secondLevelReferrals, '3'=>$thirdLevelReferrals, '4'=>$fourthLevelReferrals);
			
			if($action == 'network_count')
			{
				$result = count($networkReferralIds);
			}
			else if($action == 'network_list_ids')
			{
				$result = $networkReferralIds;
			}
			else if($action == 'network_list')
			{
				#Now get all network referrals data
				if(!empty($summarizeBy))
				{
					$referralIds = (array_key_exists('referral_level', $summarizeBy))? ($summarizeBy['referral_level']=='1'? $this->get_user_referrals($userId, 'list_ids'): $levelTrack[$summarizeBy['referral_level']]): $networkReferralIds;
				}
				else
				{
					$referralIds = $networkReferralIds;
				}
				$minLimit = array_key_exists('lower_limit', $summarizeBy)? $summarizeBy['lower_limit']: '0';
				$maxLimit = array_key_exists('upper_limit', $summarizeBy)? $summarizeBy['upper_limit']: '50';
					
				#The limit is flexible to be set by the user
				$networkReferrals = $this->db->query($this->query_reader->get_query_by_code('get_user_network_referrals', array('user_id_list'=>"'".implode("','", $referralIds)."'", 'query_part'=>" LIMIT ".$minLimit.", ".$maxLimit.";")))->result_array();
				$result = array('list'=>$networkReferrals, 'levels'=>$levelTrack);
			}
			else if($action == 'network_level_count')
			{
				$levelCount = array('level1'=>0, 'level2'=>0, 'level3'=>0, 'level4'=>0);
				$levelCount['level1'] = $this->db->query($this->query_reader->get_query_by_code('get_user_referrals', array('user_id'=>$userId, 'query_part'=>$additionalQuery)))->num_rows();
				$levelCount['level2'] = count($levelTrack['2']);
				$levelCount['level3'] = count($levelTrack['3']);
				$levelCount['level4'] = count($levelTrack['4']);
				
				
				$result = $levelCount;
			}
			else if($action == 'network_level_ids')
			{
				$levelIds = array('level1'=>array(), 'level2'=>array(), 'level3'=>array(), 'level4'=>array());
				$levelIds['level1'] = $this->get_user_referrals($userId, 'list_ids');
				$levelIds['level2'] = $levelTrack['2'];
				$levelIds['level3'] = $levelTrack['3'];
				$levelIds['level4'] = $levelTrack['4'];
				
				
				$result = $levelIds;
			}
			
			
		}
		
		return $result;
	}
	
	
	
	
	#Function to get the spending data for a user's referrals given the user ID
	#The $summarizeBy variable is used to determine the format of the data returned
	public function get_referral_spending($userId, $action, $dateRange=array(), $summarizeBy='')
	{
		$result = 0;
		#Get the ids of all the user's direct referrals
		$referrals = $this->get_user_referrals($userId, $action."_ids", array());
		
		
		if(!empty($referrals))
		{	
			#Add more conditions based on the required data list
			$additionalQuery = (!empty($dateRange['start_date']))? " AND DATEDIFF(DATE(C.start_date), DATE('".$dateRange['start_date']."')) >= 0 ": "";
			
			if($summarizeBy == 'totals')
			{
				#Get the total spending instead
				$spendingTotals = $result = $this->db->query($this->query_reader->get_query_by_code('get_user_spending_totals', array('user_id_list'=>"'".implode("','", $referrals)."'", 'query_part'=>$additionalQuery)))->row_array();
				$result = $spendingTotals['total_spending'];
			}
			else
			{
				#Get the spending for the refferrals with the above IDs
				$result = $this->db->query($this->query_reader->get_query_by_code('get_user_spending', array('user_id_list'=>"'".implode("','", $referrals)."'", 'query_part'=>$additionalQuery)))->result_array();
			}
		}
		
		return $result;
	}
	
	
	
	
	#Function to format a start date based on a clue from the code
	public function format_date_on_clue($scoreCode)
	{
		$startDate = "";
		if(strpos($scoreCode, '_last24hours') !== FALSE)
		{
			$startDate = date('Y-m-d', strtotime('-24 hours'));
		}
		else if(strpos($scoreCode, '_last7days') !== FALSE)
		{
			$startDate = date('Y-m-d', strtotime('-7 days'));
		}
		else if(strpos($scoreCode, '_last30days') !== FALSE)
		{
			$startDate = date('Y-m-d', strtotime('-30 days'));
		}
		else if(strpos($scoreCode, '_last90days') !== FALSE)
		{
			$startDate = date('Y-m-d', strtotime('-90 days'));
		}
		else if(strpos($scoreCode, '_last180days') !== FALSE)
		{
			$startDate = date('Y-m-d', strtotime('-180 days'));
		}
		else if(strpos($scoreCode, '_last360days') !== FALSE)
		{
			$startDate = date('Y-m-d', strtotime('-360 days'));
		}
		else if(strpos($scoreCode, '_last12months') !== FALSE)
		{
			$startDate = date('Y-m-d', strtotime('-12 months'));
		}
		else if(strpos($scoreCode, '_last24months') !== FALSE)
		{
			$startDate = date('Y-m-d', strtotime('-24 months'));
		}
		
			
		return $startDate;
	}
	
	
	
	
	
	#Function to get the spending data for a user for a given store or its competitors given the user ID
	public function get_store_spending($userId, $action, $dateRange=array(), $storeId)
	{
		$result = 0;
		
		#Add condition based on the start date
		$additionalQuery = (!empty($dateRange['start_date']))? " AND DATEDIFF(DATE(T.start_date), DATE('".$dateRange['start_date']."')) >= 0 ": "";
		
		#Transactions for competitors
		if(strpos($action, 'competitor_') !== FALSE)
		{
			#Get the ids of all the store's competitors
			$competitors = $this->get_store_competitors($storeId, 'id_list');
			
			if(strpos($action, 'list') !== FALSE)
			{
				#Now collect the data from the database
				$result = $this->db->query($this->query_reader->get_query_by_code('get_user_transactions', array('user_id'=>$userId, 'query_part'=>$additionalQuery." AND T.store_id IN ('".implode("','", $competitors)."')  ORDER BY T.start_date DESC ")))->result_array();
			}
			else if(strpos($action, 'total') !== FALSE)
			{
				$transactionDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_transaction_totals', array('user_id'=>$userId, 'query_part'=>$additionalQuery." AND T.store_id IN ('".implode("','", $competitors)."')  ORDER BY T.start_date DESC ")))->row_array();
				$result = $transactionDetails['spending_total'];
			}
		}
		#My store transactions
		else 
		{
			if(strpos($action, 'list') !== FALSE)
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('get_user_transactions', array('user_id'=>$userId, 'query_part'=>$additionalQuery." AND T.store_id='".$storeId."' ORDER BY T.start_date DESC ")))->result_array();
				
			}
			else if(strpos($action, 'total') !== FALSE)
			{
				$transactionDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_transaction_totals', array('user_id'=>$userId, 'query_part'=>$additionalQuery." AND T.store_id='".$storeId."' ORDER BY T.start_date DESC ")))->row_array();
				$result = $transactionDetails['spending_total'];
			}
		}
		
		
		
		return $result;
	}
	
	
	
	#Get the store competitors for the given store
	public function get_store_competitors($storeId, $action) 
	{
		$competitors = array();
		
		if($action == 'list')
		{
			$competitors = $this->db->query($this->query_reader->get_query_by_code('get_store_competitors', array('store_id'=>$storeId)))->result_array();
			
		}
		else if($action == 'id_list')
		{
			$competitorsList = $this->db->query($this->query_reader->get_query_by_code('get_store_competitor_ids', array('store_id'=>$storeId)))->row_array();
			$competitors = explode(",", $competitorsList['id_list']);
		}
		
		return $competitors;
	}
	
	
	
	
	
	#Function to get the spending data for a user for a given category or related categories given the user ID
	public function get_category_spending($userId, $action, $dateRange=array(), $storeId)
	{
		$result = 0;
		
		#Add condition based on the start date
		$additionalQuery = (!empty($dateRange['start_date']))? " AND DATEDIFF(DATE(T.start_date), DATE('".$dateRange['start_date']."')) >= 0 ": "";
		
		#Get the ids of all the stores in the given type
		$listType = (strpos($action, 'related_category_') !== FALSE)? 'related_category': 'my_category';
		$stores = $this->get_category_stores($storeId, 'id_list', $listType);
		
		if(strpos($action, 'list') !== FALSE)
		{
			#Now collect the data from the database
			$result = $this->db->query($this->query_reader->get_query_by_code('get_user_transactions', array('user_id'=>$userId, 'query_part'=>$additionalQuery." AND T.store_id IN ('".implode("','", $stores)."')  ORDER BY T.start_date DESC ")))->result_array();
		}
		else if(strpos($action, 'total') !== FALSE)
		{
			$transactionDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_transaction_totals', array('user_id'=>$userId, 'query_part'=>$additionalQuery." AND T.store_id IN ('".implode("','", $stores)."')  ORDER BY T.start_date DESC ")))->row_array();
			$result = $transactionDetails['spending_total'];
		}
		
		return $result;
	}
	
	
	
	
	#Function to get stores of a given category or related categories
	public function get_category_stores($storeId, $action, $listType, $limit=10000)
	{
		$stores = array();
		
		$myCategories = $this->db->query($this->query_reader->get_query_by_code('get_my_store_categories', array('store_id'=>$storeId)))->row_array();
		$categories = explode(",", $myCategories['my_categories']);
		
		#Get the related categories
		if($listType == 'related_category')
		{
			$categories = $this->db->query($this->query_reader->get_query_by_code('get_related_categories', array('store_categories'=>"'".implode("','", $categories)."'")))->result_array();
		}
		
		
		$stores = array();
		foreach($categories AS $category)
		{
			$code = ($listType == 'related_category')? $category['code']: $category;
			#return what is required
			if($action == 'id_list')
			{
				$storesListResult = $this->db->query($this->query_reader->get_query_by_code('get_store_ids_in_category', array('code'=>$code)))->row_array();
				$storesList = !empty($storesListResult['id_list'])? explode(",", $storesListResult['id_list']): array();
			}
			else if($action == 'list')
			{
				$storesList = $this->db->query($this->query_reader->get_query_by_code('get_stores_in_category', array('code'=>$code)))->result_array();
			}
			
			#Join all the stores list together
			$stores = array_merge($stores, $storesList);	
			#Truncate to desired number and stop if it has reached the limit
			if(count($stores) >= $limit)
			{
				$stores = array_slice($stores, 0, $limit);
				break;
			}
		}
		
		return $stores;
	}
	
	
	
	#Function to get related categories of a given store
	public function get_related_categories($storeId)
	{
		$myCategories = $this->db->query($this->query_reader->get_query_by_code('get_my_store_categories', array('store_id'=>$storeId)))->row_array();
		$categories = explode(",", $myCategories['my_categories']);
		
		$relatedCategories = $this->db->query($this->query_reader->get_query_by_code('get_related_categories', array('store_categories'=>"'".implode("','", $categories)."'")))->result_array();
		
		return $relatedCategories;
	}
	
	
	
	
	
	
	
	
	
	
	#Function to compute the store score for a given user
	public function compute_store_score($userId, $storeId, $refreshCache='N')
	{
		#Get any user's cached row to pick the clout score parameters. 
		$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_a_user_store_score_cache', array('user_id'=>DUMMY_USER_ID, 'store_id'=>'')))->row_array();
		$scoreCriteria = $this->get_criteria_by_keys(array_keys($scoreDetails));
		#Tracks the final score for the user
		$finalScore = 0;
		
		foreach($scoreCriteria AS $row)
		{
			$startDate = $this->format_date_on_clue($row['code']);
			
			#CRITERIA TYPE: on_or_off
			if(!empty($row['code']) && in_array($row['code'], array('did_store_survey_last90days', 'did_competitor_store_survey_last90days', 'did_my_category_survey_last90days', 'did_related_categories_survey_last90days'))) 
			{
				#Did my store survey in the last 90 days
				$finalScore += (($row['code'] == 'did_store_survey_last90days')? ($this->get_user_surveys($userId, 'check', array('start_date'=>$startDate, 'end_date'=>date('Y-m-d')), $storeId)? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0); 
				
				#Did a competitor store survey in the last 90 days
				$finalScore += (($row['code'] == 'did_competitor_store_survey_last90days')? ($this->get_user_surveys($userId, 'competitor_check', array('start_date'=>$startDate, 'end_date'=>date('Y-m-d')), $storeId)? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0); 
				
				#Did my category survey in the last 90 days
				$finalScore += (($row['code'] == 'did_my_category_survey_last90days')? ($this->get_user_surveys($userId, 'category_check', array('start_date'=>$startDate, 'end_date'=>date('Y-m-d')), $storeId)? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0); 
				
				#Did related category survey in the last 90 days
				$finalScore += (($row['code'] == 'did_related_categories_survey_last90days')? ($this->get_user_surveys($userId, 'related_category_check', array('start_date'=>$startDate, 'end_date'=>date('Y-m-d')), $storeId)? $this->score_parameter($row, array('high')) : $this->score_parameter($row, array('low'))) : 0); 
				
			}
			
			
			
			#CRITERIA TYPE: rank
			else if(in_array($row['code'], array('my_store_spending_last90days', 'my_store_spending_last12months', 'my_store_spending_lifetime', 'my_direct_competitors_spending_last90days', 'my_direct_competitors_spending_last12months', 'my_direct_competitors_spending_lifetime', 'my_category_spending_last90days', 'my_category_spending_last12months', 'my_category_spending_lifetime', 'related_categories_spending_last90days', 'related_categories_spending_last12months', 'related_categories_spending_lifetime', 'cash_balance_today', 'average_cash_balance_last24months', 'credit_balance_today', 'average_credit_balance_last24months')))
			{
				$finalScore += $this->score_parameter(array_merge($row, array('refresh'=>$refreshCache)), array($userId, $storeId), 'store_score');
			}
			
		}
		
		
		
		#Also update the score tracking table in case the score has changed
		$result = $this->update_score_level_tracking('store', $finalScore, $userId, $storeId);
		
		return array('score_value'=>$finalScore);
	}
	
	
	
	
	
	#Get the category explanation keys
	public function get_category_explanation($scoreBreakdown)
	{
		$criteria = $categoryExplanation = array();
		$explanationKeys = array_keys($scoreBreakdown);
		#Determine the score type
		$firstKeyParts = !empty($explanationKeys[0])? explode('_', $explanationKeys[0]):array();
		$scoreType = (!empty($firstKeyParts[0]) && !empty($firstKeyParts[1]))? $firstKeyParts[0].'_'.$firstKeyParts[1]: 'clout_score';
		
		#Get any user's cached row to pick the clout score parameters. 
		#In this case, we can use 1000000000000003, a default user ID 
		$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_'.$scoreType.'_cache', array('user_id'=>DUMMY_USER_ID, 'store_id'=>DUMMY_STORE_ID)))->row_array();
		$scoreCriteria = $this->get_criteria_by_keys(array_keys($scoreDetails));
		
		#Make DB result associative array so that the details are easier to retrieve
		foreach($scoreCriteria AS $criteriaDetails)
		{
			$criteria[$criteriaDetails['code']] = $criteriaDetails;
		}
		
		#Setup the category explanation array for use in the summarization of the score
		$categoryExplanationRaw = $this->db->query($this->query_reader->get_query_by_code('get_content_explanation', array('code_list'=>"'".implode("','", $explanationKeys)."'")))->result_array();
		foreach($categoryExplanationRaw AS $categoryRow)
		{
			$categoryExplanation[$categoryRow['content_code']] = $categoryRow['content_details'];
		}
		
		return array('criteria'=>$criteria, 'explanation'=>$categoryExplanation);
	}
	
	
	
	
	
	
	#Function to obtain an explanation of the clout score based on the passed breakdown
	public function get_clout_score_explanation($userId, $scoreBreakdown) 
	{
		$criteria = $categoryExplanation = $categoryArray = array();
		#Get the user details for use in computation of some of the score details
		$userDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$userId)))->row_array();
		$explanation = $this->get_category_explanation($scoreBreakdown);
		
		$criteria = $explanation['criteria'];
		$categoryExplanation = $explanation['explanation'];
		
		#For each fragmentation, get the score info as desired
		foreach($scoreBreakdown AS $category=>$categoryItems)
		{
			#TODO: Add option to store and retrieve the previous averages for use in showing the user trend; Tracked using the 'previous_average_score' variable
			$categoryArray[$category] = array('description'=>(!empty($categoryExplanation[$category])?$categoryExplanation[$category]:''), 'total_score'=>0, 'max_total_score'=>0, 'codes'=>$categoryItems, 'code_scores'=>array(), 'previous_total_score'=>0);  
			$noOfItems = $maxTotal = $actualTotal = 0; 
			$codeScores = array();
			
			#Now bundle the codes and their scores by category
			foreach($categoryItems AS $scoreCode)
			{
				#Get the score by code for further explanation of the score - when needed
				switch($scoreCode)
				{
					#CRITERIA TYPE: on_or_off
					case 'facebook_connected':
        				$codeScores[$scoreCode] = ($this->does_user_have_social_network($userId, 'Facebook', 'verified')? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'email_verified':
						$codeScores[$scoreCode] = ($userDetails['email_verified'] == 'Y'? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'mobile_verified':
						$codeScores[$scoreCode] = ($userDetails['mobile_verified'] == 'Y'? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'profile_photo_added':
						$codeScores[$scoreCode] = (!empty($userDetails['photo_url'])? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'bank_verified_and_active':
						$codeScores[$scoreCode] = ($this->does_user_have_bank_account($userId, 'is_verified', 'active')? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'credit_verified_and_active':
						$codeScores[$scoreCode] = ($this->get_user_credit($userId, 'check')? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'location_services_activated':
						$codeScores[$scoreCode] = ($userDetails['location_services_on'] == 'Y'? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'push_notifications_activated':
						$codeScores[$scoreCode] = ($userDetails['push_notifications_on'] == 'Y'? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'first_payment_success':
						$codeScores[$scoreCode] = ($userDetails['made_first_payment'] == 'Y'? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'member_processed_payment_last7days':
						$codeScores[$scoreCode] = ($this->get_user_transactions($userId, 'check', array('start_date'=>date('Y-m-d', strtotime('-7 days')), 'end_date'=>date('Y-m-d')))? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'first_adrelated_payment_success':
						$codeScores[$scoreCode] = ($userDetails['made_first_promo_payment'] == 'Y'? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'member_processed_promo_payment_last7days':
						$codeScores[$scoreCode] = ($this->get_user_transactions($userId, 'promo_check', array('start_date'=>date('Y-m-d', strtotime('-7 days')), 'end_date'=>date('Y-m-d')))? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'has_first_public_checkin_success':
						$codeScores[$scoreCode] = ($userDetails['made_public_checkin'] == 'Y'? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'has_public_checkin_last7days':
						$codeScores[$scoreCode] = ($this->get_user_checkins($userId, 'check', array('start_date'=>date('Y-m-d', strtotime('-7 days')), 'end_date'=>date('Y-m-d')))? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					case 'has_answered_survey_in_last90days':
						$codeScores[$scoreCode] = ($this->get_user_surveys($userId, 'check', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d')))? $this->score_parameter($criteria[$scoreCode], array('high')) : $this->score_parameter($criteria[$scoreCode], array('low')));
					break;
					
					#CRITERIA TYPE: [amount]_per_[parameter]
					case 'number_of_surveys_answered_in_last90days':
						$surveyCount = $this->get_user_surveys($userId, 'count', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d')));
						$codeScores[$scoreCode] = $this->score_parameter($criteria[$scoreCode], array($surveyCount));
						$maxTotal += $criteria[$scoreCode]['high_range'];
					break;
					
					#CRITERIA TYPE: rank
					case 'number_of_direct_referrals_last180days': case 'number_of_direct_referrals_last360days': case 'total_direct_referrals': case 'number_of_network_referrals_last180days': case  'total_network_referrals': case 'spending_of_direct_referrals_last180days': case 'spending_of_direct_referrals_last360days': case 'total_spending_of_direct_referrals': case 'spending_of_network_referrals_last180days': case 'spending_of_network_referrals_last360days': case 'total_spending_of_network_referrals': case 'spending_last180days': case 'spending_last360days': case 'spending_total': case 'ad_spending_last180days': case 'ad_spending_last360days': case 'ad_spending_total': case 'cash_balance_today': case 'average_cash_balance_last24months': case 'credit_balance_today': case 'average_credit_balance_last24months':
						
						$codeScores[$scoreCode] = $this->score_parameter($criteria[$scoreCode], array($userId));
						$maxTotal += $criteria[$scoreCode]['high_range'];
					break;
					
					
					default:
						$codeScores[$scoreCode] = 0;
					break;
				}
				
				#Get the category total for the max possible score value
				#CRITERIA TYPE: on_or_off
				if(in_array($scoreCode, array('facebook_connected', 'email_verified', 'mobile_verified', 'profile_photo_added', 'bank_verified_and_active', 'credit_verified_and_active', 'location_services_activated', 'push_notifications_activated', 'first_payment_success', 'member_processed_payment_last7days', 'first_adrelated_payment_success', 'member_processed_promo_payment_last7days', 'has_first_public_checkin_success', 'has_public_checkin_last7days', 'has_answered_survey_in_last90days'))) 
				{
					$maxTotal += $this->score_parameter($criteria[$scoreCode], array('high'));
				}
				
				$actualTotal += $codeScores[$scoreCode];
			}
			
			
			#Now prepopulate the category array
			$categoryArray[$category]['code_scores'] = $codeScores;		
			$categoryArray[$category]['total_score'] = $actualTotal;
			$categoryArray[$category]['max_total_score'] = $maxTotal;
		}
		
		return $categoryArray;
	}
	
	
	
	
	
	#Get the user's account balance
	public function get_user_account_balance($userId, $type, $dateRange=array())
	{
		$balance = 0;
		$balanceFields = array('bank'=>'balance_amount', 'credit'=>'balance_amount', 'investment'=>'current_balance', 'loan'=>'balance_amount', 'reward'=>'current_balance');
		
		$accounts = $this->db->query($this->query_reader->get_query_by_code('get_user_bank_account', array('user_id'=>$userId, 'query_part'=>" AND account_type='".$type."' AND is_verified='Y' AND status='active' ")))->result_array();
		#Now go through all the accounts and get their latest imported balance accounts
		foreach($accounts AS $row)
		{
			$rawValueDetails = $this->db->query($this->query_reader->get_query_by_code('get_original_bank_account_balance', array('user_id'=>$userId, 'account_id'=>$row['account_id'], 'institution_id'=>$row['bank_id'], 'table_name'=>'raw_'.$type.'_accounts')))->row_array();
			
			$balance += !empty($rawValueDetails[$balanceFields[$type]])? $rawValueDetails[$balanceFields[$type]]: 0;
		}
		
		#Update the balance if there is a date range
		if(!empty($dateRange))
		{
			if($type == 'cash')
			{
				$averageBalance = $this->get_user_cash($userId, 'average', array('start_date'=>date('Y-m-d H:i:s', strtotime($dateRange['start_date'])), 'end_date'=>date('Y-m-d H:i:s', strtotime($dateRange['end_date']))) );
			}
			else if($type == 'credit')
			{
				$averageBalance = $this->get_user_credit($userId, 'average', array('start_date'=>date('Y-m-d H:i:s', strtotime($dateRange['start_date'])), 'end_date'=>date('Y-m-d H:i:s', strtotime($dateRange['end_date']))) );
			}
			$balance = !empty($averageBalance)? $averageBalance: $balance;
		}
		else
		{
			$latestBalance = $this->get_user_cash($userId, 'latest');
			$balance = empty($balance)? $latestBalance: $balance;
		}
		
		return $balance;
	}
	
	
	
	
	
	
	
	
	
	#Function to obtain an explanation of the store score based on the passed breakdown
	public function get_store_score_explanation($userId, $storeId, $scoreBreakdown) 
	{
		$criteria = $categoryExplanation = $categoryArray = array();
		$explanation = $this->get_category_explanation($scoreBreakdown);
		$criteria = $explanation['criteria'];
		$categoryExplanation = $explanation['explanation'];
		
		#Get the score breakdown
		foreach($scoreBreakdown AS $category=>$categoryItems)
		{
			#TODO: Add option to store and retrieve the previous averages for use in showing the user trend; Tracked using the 'previous_average_score' variable
			$categoryArray[$category] = array('description'=>(!empty($categoryExplanation[$category])?$categoryExplanation[$category]:''), 'total_score'=>0, 'max_total_score'=>0, 'codes'=>$categoryItems, 'code_scores'=>array(), 'previous_total_score'=>0);  
			$noOfItems = $maxTotal = $actualTotal = 0; 
			$codeScores = array();
			
			#Now bundle the codes and their scores by category
			foreach($categoryItems AS $scoreCode)
			{
				#Get the score by code for further explanation of the score - when needed
				if(in_array($scoreCode, array('my_store_spending_last90days', 'my_store_spending_last12months', 'my_store_spending_lifetime', 'my_direct_competitors_spending_last90days', 'my_direct_competitors_spending_last12months', 'my_direct_competitors_spending_lifetime', 'my_category_spending_last90days', 'my_category_spending_last12months', 'my_category_spending_lifetime', 'related_categories_spending_last90days', 'related_categories_spending_last12months', 'related_categories_spending_lifetime', 'did_store_survey_last90days', 'did_competitor_store_survey_last90days', 'did_my_category_survey_last90days', 'did_related_categories_survey_last90days')))
				{
					$codeScores[$scoreCode] = $this->score_parameter($criteria[$scoreCode], array($userId, $storeId), 'store_score'); 
					$maxTotal += $criteria[$scoreCode]['high_range'];	
				}
				
				$actualTotal += $codeScores[$scoreCode];
			}
			
			#Now prepopulate the category array
			$categoryArray[$category]['code_scores'] = $codeScores;		
			$categoryArray[$category]['total_score'] = $actualTotal;
			$categoryArray[$category]['max_total_score'] = $maxTotal;
		}
		
		return $categoryArray;
	}
	
	
	
	
	
	
	
	
	
	
	
	
}


?>