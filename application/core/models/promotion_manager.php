<?php

/**
 * This class manages promotion functionality in the system
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 04/14/2014
 */
class Promotion_manager extends CI_Model
{
	#a variable to hold the user ID
    private $userId;
	#a variable to hold the user's details
    private $userDetails;
	#the user location
    private $location=array();
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->library('geolite_ip');
		$this->load->model('scoring');
    }
	
	
	
	#Function to get the minimum and maximum cashback a user qualifies for
	public function compute_cashback_range($storeId, $userId, $returnType='array')
	{
		$this->userId = !empty($userId)? $userId: '';
		$cashbackDetails = array('min_cashback'=>0, 'max_cashback'=>0);
		
		$qualifyingPromotions = $this->which_promotions_does_score_qualify_for($storeId, $userId, array('cash_back'));
		$promoCashbacks = array();
		
		foreach($qualifyingPromotions AS $promotionRow)
		{
			array_push($promoCashbacks, $promotionRow['promotion_amount']);
		}
		
		$cashbackDetails['min_cashback'] = !empty($promoCashbacks)? min($promoCashbacks): 0;
		$cashbackDetails['max_cashback'] = !empty($promoCashbacks)? max($promoCashbacks): 0;
		
		if($returnType == 'string')
		{
			return "min=".$cashbackDetails['min_cashback']."|max=".$cashbackDetails['max_cashback'];
		}
		else
		{
			return $cashbackDetails;
		}
	}
	
	
	
	#Function to get promotions a given score can qualify for
	public function which_promotions_does_score_qualify_for($storeId, $userId, $promotionTypes=array('cash_back'), $limit=20)
	{
		$promotions = array();
		#1. Get the user's store score
		$cache = (!empty($userId) && !empty($storeId))? $this->db->query($this->query_reader->get_query_by_code('get_store_score_cache', array('user_id'=>$userId, 'store_id'=>$storeId)))->row_array(): array();
		$storeScore = !empty($cache['total_score'])? $cache['total_score']:0;
		
		#2. Get the promotions the user qualifies for
		return $this->get_promotions_by_score((!empty($storeScore['score_value'])?$storeScore['score_value']:0), $storeId, $userId, $promotionTypes, 20);
	}
	
	
	
	
	
	
	
	#Get the list of offers at a given level
	public function get_offers_at_level($storeId, $userId, $level=0)
	{
		#1. Get a score to use
		$scoreSettings = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_criteria', array('condition'=>" AND level='".$level."' ", 'order_by'=>"")))->row_array(); 
		
		#2. Get the promotions that meet the score level selected
		$promotions['cash_back'] = $this->get_promotions_by_score($scoreSettings['low_end_score'], $storeId, $userId, array('cash_back'), 20);
		$promotions['perks'] = $this->get_promotions_by_score($scoreSettings['low_end_score'], $storeId, $userId, array('perk'), 20);
		
		return $promotions;
	}
	
	
	
	
	#Function to get promotions for a given score
	public function get_promotions_by_score($score, $storeId, $userId, $promotionTypes=array('cash_back', 'perk'), $limit=20)
	{
		$promotions = array();
		
		$promotionsList = $this->db->query($this->query_reader->get_query_by_code('get_promotions_within_score_range', array('score'=>$score,  'store_id'=>$storeId, 'promotion_types'=>"'".implode("','", $promotionTypes)."'", 'additional_conditions'=>" AND status='active' ", 'order_condition'=>" ORDER BY promotion_amount DESC ", 'limit_text'=>" LIMIT 0,".$limit."; ")))->result_array(); 
		
		#Now apply the rule filters and pick out which ones the user actually qualifies for
		if(!empty($promotionsList))
		{
			foreach($promotionsList AS $promotion)
			{
				if($this->apply_promotion_rules($promotion['promotion_id'], $userId))
				{
					array_push($promotions, $promotion);
				}
			}
		}
		
		return $promotions;
	}
	
	
	
	
	
	
	#Function to apply promotion rules to a promotion to check if a user qualifies
	#By default, a user qualifies unless a rule excludes them
	private function apply_promotion_rules($promotionId, $userId, $extraInfo=array())
	{
		$response = TRUE;
		
		#1. Get all active rules of the promotion
		$promotionRules = $this->db->query($this->query_reader->get_query_by_code('get_promotion_rules', array('promotion_id'=>$promotionId)))->result_array();
		
		#2. Check each rule to make sure the qualifications of the user meet. If any of the rules are not met, break out of the loop.
		if(!empty($promotionRules))
		{
			#TODO: Complete the rule definitions
			foreach($promotionRules AS $rule)
			{
				$ruleDetails = explode('|', $rule['rule_amount']);
				if($rule['rule_type'] == 'schedule_available')
				{
					$response = $this->check_date_on_schedule($ruleDetails, $extraInfo, 'available');
				}
				else if($rule['rule_type'] == 'schedule_blackout')
				{
					$response = !$this->check_date_on_schedule($ruleDetails, $extraInfo, 'blackout');
				}
				else if($rule['rule_type'] == 'how_many_uses')
				{
					$response = !$this->has_user_reached_max_promo_uses($ruleDetails[0], $userId, $promotionId);
				}
				else if($rule['rule_type'] == 'distance_from_location')
				{
					$response = $this->is_user_within_desired_distance($ruleDetails, $userId, $promotionId);
				}
				else if($rule['rule_type'] == 'at_the_following_stores')
				{
					
				}
				else if($rule['rule_type'] == 'for_new_customers')
				{
					
				}
				else if($rule['rule_type'] == 'per_transaction_spending_greater_than')
				{
					
				}
				else if($rule['rule_type'] == 'life_time_spending_greater_than')
				{
				
				}
				else if($rule['rule_type'] == 'life_time_visits_greater_than')
				{
				
				}
				else if($rule['rule_type'] == 'last_visit_occurred')
				{
					
				}
				else if($rule['rule_type'] == 'only_those_who_visited_competitors')
				{
				
				}
				else if($rule['rule_type'] == 'accepted_gender')
				{
					$response = $this->check_user_profile_info($userId, 'gender', $ruleDetails);
				}
				else if($rule['rule_type'] == 'age_range')
				{
					$response = $this->check_user_profile_info($userId, 'age_range', $ruleDetails);
				}
				else if($rule['rule_type'] == 'network_size_greater_than')
				{
					
				}
			
				#Break if the user does not qualify for the rule that has just been run
				if(!$response) 
				{
					break;
				}
			}
		}
		
		#confirm if the user meets the rule requirements
		return $response;
	}
	
	
	
	
	
	
	#Display extra offer conditions in a mode a user can view
	public function display_extra_offer_conditions($promotionId, $returnType='array', $userId='')
	{
		$display = array();
		#1. Get all active rules of the promotion
		$promotionRules = $this->db->query($this->query_reader->get_query_by_code('get_promotion_rules', array('promotion_id'=>$promotionId)))->result_array();
		#2. Now format the rule into values readable by a user
		foreach($promotionRules AS $rule)
		{
			$amountBreakdown = explode('|', $rule['rule_amount']);
			$valueBreakdown = !empty($amountBreakdown[1])? explode('-', $amountBreakdown[1]): array();
			
			switch($rule['rule_type'])
			{
				case 'schedule_available':
					array_push($display, "On ".date('l', strtotime($amountBreakdown[0]))."s at ".date('g:ia', strtotime($valueBreakdown[0]))." to ".(!empty($valueBreakdown[1])? date('g:ia', strtotime($valueBreakdown[1])): 'Late'));
				break;
				
				case 'schedule_blackout':
					array_push($display, "Except On ".date('l', strtotime($amountBreakdown[0]))."s at ".date('g:ia', strtotime($valueBreakdown[0]))." to ".(!empty($valueBreakdown[1])? date('g:ia', strtotime($valueBreakdown[1])): 'Late'));
				break;
				
				case 'how_many_uses':
					array_push($display, "Max ".$amountBreakdown[0]." uses");
				break;
				
				case 'distance_from_location':
					array_push($display, "Atleast ".$amountBreakdown[0]." miles from ".$valueBreakdown[0]);
				break;
				
				case 'at_the_following_stores':
					$storeIdList = explode(',', $amountBreakdown[0]);
					$storeAddress = "";
					foreach($storeIdList AS $id)
					{
						$store = $this->db->query($this->query_reader->get_query_by_code('get_store_locations_by_id', array('store_id'=>$id, 'user_id'=>$userId)))->row_array();
						$storeAddress .= "<br>".$store['full_address'];
					}
					array_push($display, "At the following stores: ".$storeAddress);
				break;
				
				case 'for_new_customers':
					array_push($display, "New customers");
				break;
				
				case 'per_transaction_spending_greater_than':
					array_push($display, "For spending greater than ".$amountBreakdown[0]);
				break;
				
				case 'life_time_spending_greater_than':
					array_push($display, "For lifetime spending greater than ".$amountBreakdown[0]);
				break;
				
				case 'life_time_visits_greater_than':
					array_push($display, "For lifetime visits greater than ".$amountBreakdown[0]);
				break;
				
				case 'last_visit_occurred':
					array_push($display, "If last visit occured after ".date('m/d/Y', strtotime($amountBreakdown[0])));
				break;
				
				case 'only_those_who_visited_competitors':
					array_push($display, "If you visited our competitor");
				break;
				
				case 'accepted_gender':
					array_push($display, ucwords($amountBreakdown[0])."s only");
				break;
				
				case 'age_range':
					array_push($display, "Age ".implode('-', $amountBreakdown).'yrs');
				break;
				
				case 'network_size_greater_than':
					array_push($display, "If your network size is greater than ".$amountBreakdown[0]);
				break;
				
				default:
				break;
			}
		}
		
		return $display;
	}
	
	
	
	
	
	
	#Does promotion has a given rule attached to it
	public function does_promotion_have_rule($promotionId, $ruleCode)
	{
		$rule = $this->db->query($this->query_reader->get_query_by_code('get_rule_for_promotion', array('promotion_id'=>$promotionId, 'rule_type'=>$ruleCode)))->row_array();
		return !empty($rule)? TRUE: FALSE;
	}
	
	
	
	
	
	
	
	#Check user profile info
	public function check_user_profile_info($userId, $parameter, $ruleDetails)
	{
		$userDetails = !empty($this->userDetails)? $this->userDetails: $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$userId, 'limit_text'=>' LIMIT 0,1 ')))->row_array();
		$this->userDetails = $userDetails;
		
		if($parameter == 'age_range')
		{
			$userAge = compute_age_from_birthday($userDetails['birthday']);
			return (($ruleDetails[0] <= $userAge && $userAge <= $ruleDetails[1]) || $userAge == 0)? TRUE: FALSE; 
		}
		else if($parameter == 'gender')
		{
			return ($ruleDetails[0] == $userDetails['gender'])? TRUE: FALSE;
		}
	}
	
	
	
	
	
	#Function to check if a user is within the desired distance
	public function is_user_within_desired_distance($locationArray, $userId, $promotionId)
	{
		$distance = 0;
		$userLocation = $this->get_most_recent_location($userId);
		
		#Which distance is given?
		#Distance from zipcode array(max_distance, zip_code)
		if(count($locationArray) > 1)
		{
			$location = $this->db->query($this->query_reader->get_query_by_code('get_zip_code_details', array('zip_code'=>$locationArray[1], 'limit_text'=>' LIMIT 0,1 ')))->row_array();
			$businessLocation = !empty($location['longitude'])? array('latitude'=>$location['latitude'], 'longitude'=>$location['longitude']): array();
		}
		#Just get the business location from the promo
		#Distance given by array(max_distance)
		else
		{
			$businessLocation = $this->get_business_location_from_promotion($promotionId);
		}
		
		
		#Compute distance between current location and location of business
		if(!empty($userLocation['latitude']) && !empty($businessLocation['latitude']))
		{
			$distance = compute_distance_between_latitude_and_longitude($userLocation['latitude'], $userLocation['longitude'], $businessLocation['latitude'], $businessLocation['longitude']);
		}
		
		return ($distance > $locationArray[0]? FALSE: TRUE);
	}
	
	
	
	#Get the location of the business given the promotion
	public function get_business_location_from_promotion($promotionId, $returnType='longitude_latitude')
	{
		$locationArray = array();
		$location = $this->db->query($this->query_reader->get_query_by_code('get_store_location_from_promotion', array('promotion_id'=>$promotionId)))->row_array();
		
		if(!empty($location))
		{
			if($returnType == 'longitude_latitude')
			{
				$locationArray = array('longitude'=>$location['longitude'], 'latitude'=>$location['latitude']);
			}
			else if($returnType == 'zipcode')
			{
				$locationArray = array('zipcode'=>$location['zipcode']);
			}
			else if($returnType == 'address')
			{
				$locationArray = array('address_line_1'=>$location['address_line_1'], 'address_line_2'=>$location['address_line_2'], 'city'=>$location['city'], 'state'=>$location['state'], 'zipcode'=>$location['zipcode'], 'country'=>$location['country']);
			}
		}
		
		return $locationArray;
	}
	
	
	
	
	
	#Function to check if the user has exceeded a promotion's uses 
	private function has_user_reached_max_promo_uses($maxUses, $userId, $promotionId)
	{
		$promoCheck = $this->db->query($this->query_reader->get_query_by_code('compile_promo_uses', array('user_id'=>$userId, 'promotion_id'=>$promotionId)))->row_array();
		
		return (!empty($promoCheck['use_count']) && $promoCheck['use_count'] == $maxUses)? TRUE: FALSE;
	}
	
	
	
	
	
	
	
	#Function to check a date on a given schedule
	private function check_date_on_schedule($ruleDetails, $extraInfo=array(), $type='available')
	{
		$response = FALSE;
		
		$useDate = !empty($extraInfo['check_date'])? date('Y-m-d H:i:s', strtotime($extraInfo['check_date'])): date('Y-m-d H:i:s');
		$useHour = date('Hi', strtotime($useDate));
		
		#The schedule type
		if($type == 'blackout')
		{
			$response = (date('Y-m-d', strtotime($useDate)) == date('Y-m-d', strtotime($ruleDetails[0])))? TRUE: $response;
		}
		else if($type == 'available')
		{
			#get the hour range
			$hourRange = explode('-',$ruleDetails[1]);
			#Is the date correct?
			$response = (strtolower($ruleDetails[0]) == strtolower(date('D', strtotime($useDate))) )? TRUE: $response;
			#Is the time correct?
			$response = ($useHour >= $hourRange[0] && $useHour <= $hourRange[1] && $response)? TRUE: $response; 
		}
		
		return $response;
	}
	
	
	
	#Checks if a user qualifies for a perk
	public function does_user_qualify_for_perk($userId, $storeId, $returnType='bool')
	{
		$qualifyingPromotions = $this->which_promotions_does_score_qualify_for($storeId, $userId, array('perk'));
		
		if($returnType == 'string')
		{
			return (!empty($qualifyingPromotions)? 'Y': 'N');
		}
		else
		{
			return (!empty($qualifyingPromotions)? TRUE: FALSE);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	#Returns the most recent known location of the user (usually current  location)
	public function get_most_recent_location($userId, $returnType='longitude_latitude', $refresh='N')
	{
		if(!empty($this->location[$returnType]) && $refresh=='N')
		{
			$location = $this->location[$returnType];
		}
		else
		{
			$location = array();
			$user = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$userId)))->row_array(); 
			#Get the current location first
			#CAUTION: DO NOT CALL more than once for the same page or it will throw an error
			$geoDetails = $this->get_current_location_by_ip('zipcode_details');
			$this->native_session->set('current_location', $geoDetails);
		
			#If no value is returned, then get the latitude and longitude from the geo tracking table with the last tracked location
			if(empty($geoDetails['latitude']) || empty($geoDetails['longitude']))
			{
				#Check latitude and longitude of the user's most recent checkin
				$geoDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_geo_tracking', array('user_id'=>$userId)))->row_array(); 
			
				#If no geoDetails are returned, get them user's registered zip code and use that
				if(empty($geoDetails['latitude']) || empty($geoDetails['longitude']))
				{
					$zipCodeDetails = $this->db->query($this->query_reader->get_query_by_code('get_zip_code_details', array('zip_code'=>$user['zipcode'], 'limit_text'=>' LIMIT 0,1 ')))->row_array();
					$geoDetails['latitude'] = !empty($zipCodeDetails['latitude'])? $zipCodeDetails['latitude']: '';
					$geoDetails['longitude'] = !empty($zipCodeDetails['longitude'])? $zipCodeDetails['longitude']: '';
				}
			}
		
			#We need the latitude-longitude
			if($returnType == 'longitude_latitude')
			{
				$location['longitude'] = !empty($geoDetails['longitude'])? $geoDetails['longitude']: '0.000000';
				$location['latitude'] = !empty($geoDetails['latitude'])? $geoDetails['latitude']: '0.000000';
			}
			#We need the most recent zipcode.
			else if($returnType == 'zipcode')
			{
				#Return the registered zipcode if the user location has not been tracked yet
				$location = (!empty($geoDetails['latitude']) && !empty($geoDetails['longitude']))? $this->get_zipcode_from_longitude_and_latitude($geoDetails): $user['zipcode'];
			}
			else if($returnType == 'zipcode_details')
			{
				$location = $this->db->query($this->query_reader->get_query_by_code('get_zip_code_details', array('zip_code'=>$this->get_zipcode_from_longitude_and_latitude($geoDetails), 'limit_text'=>' LIMIT 0,1 ')))->row_array();
			}
		
			$this->location[$returnType] = $location;
		}
		
		
		return $location;
	}
	
	
	
	
	
	
	
	
	
	#Get current location by IP
	public function get_current_location_by_ip($returnType)
	{
		$location = array();
		#Match the return type to the ip location requirements
		$returnMatch = array(
			'longitude_latitude'=>array('latitude','longitude'), 
			'zipcode'=>array('zipcode'),
			'zipcode_details'=>array('latitude','longitude', 'zipcode', 'city', 'state_code', 'state', 'country_code', 'country_name')
		);
		
		return $this->geolite_ip->get_ip_location(get_ip_address(),$returnMatch[$returnType]);
	}
	
	
	
	
	#Returns adverts that meet restrictions
	public function get_adverts_that_meet_restrictions($parameters, $returnType='list_details')
	{
		$advertList = array();
		
		#Get the list specs
		$itemsPerPage = !empty($parameters['items_per_page'])? $parameters['items_per_page']: 10;
		$start = !empty($parameters['page'])? ($parameters['page']-1)*$itemsPerPage: 0;
		
		#TODO: Add ranking of adverts based on their promotion score
		#Get list of adverts based on distance from the user
		$advertList = $this->db->query($this->query_reader->get_query_by_code('get_advertisement_'.($returnType=='store_list_details'? 'store_': '').'list', array('latitude'=>$parameters['user_location']['latitude'], 'longitude'=>$parameters['user_location']['longitude'], 'promotion_types'=>"'advertisement'", 'extra_conditions'=>" AND P.status='active' ", 'order_condition'=>" ORDER BY distance, boost_enddate ASC ", 'max_distance'=>(!empty($parameters['max_distance'])?$parameters['max_distance']:10), 'limit_text'=>" LIMIT ".$start.",".$itemsPerPage."; ", 'user_id'=>$parameters['user_id'] )))->result_array();
		#How many are actually returned
		$adCount = count($advertList);
		
		#Check if the list shown is full, if not, pull some of the best deals nearby
		if(($adCount < $itemsPerPage) && ($adCount > 0 || $start == 0))
		{
			$dealsToAdd = $itemsPerPage - $adCount;
			$dealList = $this->db->query($this->query_reader->get_query_by_code('get_advertisement_'.($returnType=='store_list_details'? 'store_': '').'list', array('latitude'=>$parameters['user_location']['latitude'], 'longitude'=>$parameters['user_location']['longitude'], 'promotion_types'=>"'cashback','perk'", 'extra_conditions'=>" AND P.status='active' ", 'order_condition'=>" ORDER BY distance, boost_enddate ASC ", 'max_distance'=>(!empty($parameters['max_distance'])?$parameters['max_distance']:10), 'limit_text'=>" LIMIT 0,".$dealsToAdd."; ", 'user_id'=>$parameters['user_id'])))->result_array();
			
			$advertList = array_merge($advertList, $dealList);	
		}
		
		return $advertList;
	}
	
}

?>