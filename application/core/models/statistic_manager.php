<?php

/**
 * This class manages system statistics.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 03/12/2014
 */
class Statistic_manager extends CI_Model
{
	#user id
	private $userId;
	#store id
	private $storeId;
	#a variable to hold a user's current clout score info for use in more than one stat calls
    private $cloutScore=array();
	#a variable to hold a user's current clout score level 2 details for use in more than one stat calls
    private $cloutScoreData=array();
	#Holds user's clout score level
	private $cloutScoreLevel;
	#a variable to hold a user's current store score info for use in more than one stat calls
    private $storeScore=array();
	#a variable to hold a user's current store score details for use in more than one stat calls
    private $storeScoreData=array();
	#Holds user's store score level
	private $storeScoreLevel;
	#Holds user's store score level
	private $storeScoreLevelData;
	#a variable to hold a user's current merchant score details for use in more than one stat calls
    private $merchantScoreData=array();
	#a variable to hold a count of the number of referrals at each network level for a given user
    private $networkLevelCount=array();
	#a variable to hold a user's network referral IDs by level
    private $networkLevelIds=array();
	#a variable to hold a user's invite count including that of their referrals
    private $networkInviteCount=array();
	#a variable to hold a user's network earnings separated by level
    private $networkEarnings=array();
	#the description of the Clout score keys
	private $cloutScoreKeyDescription=array();
	#the description of the Store score keys
	private $storeScoreKeyDescription=array();
	#the breakdown for the store score
	private $storeScoreBreakdown=array();
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('scoring');
    }
	
	#Function to get the user statistic
	public function get_user_statistic($userId, $statCode, $storeId='')
	{
		switch($statCode) 
		{
    		case 'last_time_user_joined_my_direct_network':
        		return $this->get_last_time_user_joined_my_direct_network($userId);
			break;
			
			case 'last_time_invite_was_sent':
        		return $this->get_last_time_invite_was_sent($userId);
			break;
			
			case 'last_time_commission_was_earned':
        		return $this->get_last_time_commission_was_earned($userId);
			break;
			
    		case 'total_users_in_my_network':
        		return (!empty($this->cloutScoreData)? $this->cloutScoreData['total_network_referrals']: $this->get_total_users_in_my_network($userId));
       		break;
			
			case 'total_direct_referrals_in_my_network':
        		return (!empty($this->cloutScoreData)? $this->cloutScoreData['total_direct_referrals']: $this->get_total_direct_users_in_my_network($userId));
       		break;
			
			case 'total_level_2_referrals_in_my_network':
        		return (!empty($this->networkLevelCount)? $this->networkLevelCount['level2']: $this->get_network_level_count($userId, 'level2'));
       		break;
			
			case 'total_level_3_referrals_in_my_network':
        		return (!empty($this->networkLevelCount)? $this->networkLevelCount['level3']: $this->get_network_level_count($userId, 'level3'));
       		break;
			
			case 'total_level_4_referrals_in_my_network':
        		return (!empty($this->networkLevelCount)? $this->networkLevelCount['level4']: $this->get_network_level_count($userId, 'level4'));
       		break;
			
			case 'total_invites_in_my_network':
        		return (!empty($this->networkInviteCount)? $this->networkInviteCount['all']: $this->get_network_invite_count($userId));
       		break;
			
			case 'total_direct_invites_in_my_network':
        		return (!empty($this->networkInviteCount)? $this->networkInviteCount['level1']: $this->get_network_invite_count($userId, 'level1'));
       		break;
			
			case 'total_level_2_invites_in_my_network':
        		return (!empty($this->networkInviteCount)? $this->networkInviteCount['level2']: $this->get_network_invite_count($userId, 'level2'));
       		break;
			
			case 'total_level_3_invites_in_my_network':
        		return (!empty($this->networkInviteCount)? $this->networkInviteCount['level3']: $this->get_network_invite_count($userId, 'level3'));
       		break;
			
			case 'total_level_4_invites_in_my_network':
        		return (!empty($this->networkInviteCount)? $this->networkInviteCount['level4']: $this->get_network_invite_count($userId, 'level4'));
       		break;
			
			case 'total_earnings_in_my_network':
        		return (!empty($this->networkEarnings)? $this->networkEarnings['all']: $this->get_network_earnings($userId));
       		break;
			
			case 'total_direct_earnings_in_my_network':
        		return (!empty($this->networkEarnings)? $this->networkEarnings['level1']: $this->get_network_earnings($userId, 'level1'));
       		break;
			
			case 'total_level_2_earnings_in_my_network':
        		return (!empty($this->networkEarnings)? $this->networkEarnings['level2']: $this->get_network_earnings($userId, 'level2'));
       		break;
			
			case 'total_level_3_earnings_in_my_network':
        		return (!empty($this->networkEarnings)? $this->networkEarnings['level3']: $this->get_network_earnings($userId, 'level3'));
       		break;
			
			case 'total_level_4_earnings_in_my_network':
        		return (!empty($this->networkEarnings)? $this->networkEarnings['level4']: $this->get_network_earnings($userId, 'level4'));
       		break;
			
			case 'my_current_commission':
				return $this->get_user_commission_details($userId);
			break;
			
			case 'clout_score':
				return (!empty($this->cloutScore)? $this->cloutScore['total_score']: $this->get_score($userId, 'clout_score'));
			break;
			
			case 'clout_score_details':
				return (!empty($this->cloutScore)? $this->cloutScore: $this->get_score($userId, 'clout_score_details'));
			break;
			
			case 'clout_score_breakdown':
				return (!empty($this->cloutScoreFragments)? $this->cloutScoreFragments: $this->get_clout_score_breakdown($userId));
			break;
			
			case 'clout_score_level':
				return (!empty($this->cloutScoreLevel)? $this->cloutScoreLevel: $this->get_score_level($userId, 'clout_score'));
			break;
			
			case 'clout_score_key_description':
				$scoreDetails = $this->get_user_statistic($userId, 'clout_score_details');
				return (!empty($this->cloutScoreKeyDescription)? $this->cloutScoreKeyDescription: $this->get_score_key_description($scoreDetails));
			break;
			
			case 'store_score':
				return (!empty($this->storeScore)? $this->storeScore['store_score']: $this->get_score($userId, 'store_score', $storeId));
			break;
			
			case 'store_score_details':
				return (!empty($this->storeScore)? $this->storeScore: $this->get_score($userId, 'store_score_details'));
			break;
			
			case 'store_score_level':
				return ((!empty($this->storeScoreLevel) && $storeId == $this->storeId)? $this->storeScoreLevel: $this->get_score_level($userId, 'store_score', $storeId)); 
			break;
			
			case 'store_score_level_data':
				return ((!empty($this->storeScoreLevelData) && $storeId == $this->storeId)? $this->storeScoreLevelData: $this->get_score_level_data($userId, 'store_score', $storeId)); 
			break;
			
			case 'store_score_key_description':
				$scoreDetails = $this->get_user_statistic($userId, 'store_score_details');
				return (!empty($this->storeScoreKeyDescription)? $this->storeScoreKeyDescription: $this->get_score_key_description($scoreDetails));
			break;
			
			case 'store_score_breakdown':
				return (!empty($this->storeScoreBreakdown)? $this->storeScoreBreakdown: $this->get_score_breakdown($userId, 'store_score', $storeId));
			break;
			
			
			default:
				return "ERROR: code not recognized.";
			break;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	#Function to get a score's key description
	private function get_score_key_description($scoreDetails)
	{
		$keyDescription = $this->scoring->get_criteria_by_keys(array_keys($scoreDetails), '', 'array');
		$this->scoreKeyDescription = !empty($keyDescription)? $keyDescription: array();
		
		return $this->scoreKeyDescription;
	}
	
	
	
	
	
	
	#Function to return the user's clout score level
	private function get_score_level($userId, $scoreType='clout_score', $storeId='')
	{
		$theScore = $this->get_score($userId, $scoreType, $storeId);
		$levelDetails = $this->db->query($this->query_reader->get_query_by_code('get_score_level', array('score'=>$theScore)))->row_array();
		
		$level = !empty($levelDetails['level'])? $levelDetails['level']: '0';
		#Store the levels in the global class variable
		if($scoreType=='store_score')
		{
			$this->cloutScoreLevel = $level;
		}
		elseif($scoreType=='clout_score')
		{
			$this->storeScoreLevel = $level;
		}
		
		return $level;
	}
	
	
	
	#function to get a breakdown of the clout score in the provided categories
	public function get_clout_score_breakdown($userId, $fragmentation = array())
	{
		#use the default fragmentation, if it is not given
		if(empty($fragmentation))
		{
			$fragmentation['clout_score_profile_setup'] = array('facebook_connected','email_verified','mobile_verified','profile_photo_added','location_services_activated','push_notifications_activated');
			$fragmentation['clout_score_activity'] = array('first_payment_success','member_processed_payment_last7days','first_adrelated_payment_success','member_processed_promo_payment_last7days','has_first_public_checkin_success','has_public_checkin_last7days','has_answered_survey_in_last90days','number_of_surveys_answered_in_last90days');
			$fragmentation['clout_score_overall_spending'] = array('spending_last180days','spending_last360days','spending_total');
			$fragmentation['clout_score_ad_related_spending'] = array('ad_spending_last180days','ad_spending_last360days','ad_spending_total');
			$fragmentation['clout_score_linked_accounts'] = array('bank_verified_and_active','credit_verified_and_active','cash_balance_today','average_cash_balance_last24months','credit_balance_today','average_credit_balance_last24months');
			$fragmentation['clout_score_network_size_growth'] = array('number_of_direct_referrals_last180days','number_of_direct_referrals_last360days','total_direct_referrals','number_of_network_referrals_last180days','total_network_referrals');
			$fragmentation['clout_score_network_spending'] = array('spending_of_direct_referrals_last180days','spending_of_direct_referrals_last360days','total_spending_of_direct_referrals','spending_of_network_referrals_last180days','spending_of_network_referrals_last360days','total_spending_of_network_referrals');
		}
		
		#Categorise as desired
		$scoreFragments = $this->scoring->get_clout_score_explanation($userId,$fragmentation);
		$this->cloutScoreFragments = !empty($scoreFragments)? $scoreFragments: array();
		
		return $scoreFragments;	
	}
	
	
	
	
	
	
	
	
	#Function to return the user's clout score information and origins
	public function get_score($userId, $reportDetail, $storeId='')
	{
		#Get the clout score if not available
		if(strpos($reportDetail, 'clout_score') !== FALSE)
		{
			$this->cloutScore = !empty($this->cloutScore)? $this->cloutScore: $this->scoring->get_cached_score($userId, 'clout_score', $storeId, 'raw');
		
			if($reportDetail == 'clout_score')
			{
				return $this->cloutScore['total_score'];
			}
			else if($reportDetail == 'clout_score_details')
			{
				return $this->cloutScore;
			}
		}
		else
		{
			$this->storeScore = !empty($this->storeScore)? $this->storeScore: $this->scoring->get_cached_score($userId, 'store_score', $storeId, 'raw');
			
			if($reportDetail == 'store_score')
			{
				return $this->storeScore['total_score'];
			}
			else if($reportDetail == 'store_score_details')
			{
				return $this->storeScore;
			}
		}
	
	}
	
	
	#Function to get the commission details about a user
	public function get_user_commission_details($userId, $returnType='percent')
	{
		$commission = $this->db->query($this->query_reader->get_query_by_code('get_user_score_details', array('user_id'=>$userId, 'score_type'=>'clout', 'store_id'=>'')))->row_array(); 
		
		if($returnType=='percent')
		{
			$result = !empty($commission['commission'])?$commission['commission']:'0.00';
		}
		else
		{
			$result = $commission;
		}
		
		return $result;
	}
	
	
	
	#Function to return earnings from the network
	public function get_network_earnings($userId, $networkLevel='all')
	{
		$earnings = 0;
		
		if(!empty($this->networkEarnings))
		{
			$earnings = !empty($this->networkEarnings[$networkLevel])?$this->networkEarnings[$networkLevel]: $earnings;
		}
		else
		{
			#1. Get the IDS for all referrals at each level
			$this->networkLevelIds = !empty($this->networkLevelIds)? $this->networkLevelIds: $this->scoring->get_user_referrals($userId, 'network_level_ids');
			
			#2. Get the amount of earnings by the user at each level
			$earningsArray = array();
			$earningsArray['level1'] = $this->get_network_earning_details($userId, $this->networkLevelIds['level1']);
			$earningsArray['level2'] = $this->get_network_earning_details($userId, $this->networkLevelIds['level2']);
			$earningsArray['level3'] = $this->get_network_earning_details($userId, $this->networkLevelIds['level3']);
			$earningsArray['level4'] = $this->get_network_earning_details($userId, $this->networkLevelIds['level4']);
			
			$earningsArray['all'] = $earningsArray['level1'] + $earningsArray['level2'] + $earningsArray['level3'] + $earningsArray['level4'];
			
			#3. Assign to global variables and prepare the return values
			$this->networkEarnings = $earningsArray;
			
			$earnings = !empty($this->networkEarnings[$networkLevel])?$this->networkEarnings[$networkLevel]: $earnings;
		}
		
		return $earnings;
	}
	
	
	
	
	
	#Get the network earning details
	public function get_network_earning_details($userId, $networkIds, $earliestDate='', $refresh=FALSE) 
	{
		$earningTotal = 0;
		$dateCondition = !empty($earliestDate)? " AND UNIX_TIMESTAMP(T.start_date) >= UNIX_TIMESTAMP('".$earliestDate."') ": "";
		#1. Get user level change history
		$levelHistory = $this->db->query($this->query_reader->get_query_by_code('get_user_score_tracking', array('user_id'=>$userId, 'score_type'=>'clout', 'date_condition'=>$dateCondition)))->result_array();
		
		#Return the cached earning values
		#Recommended for quick results and for situations where the global score reward settings have been changed for any level
		if(!$refresh)
		{
			#2. Go through each user's transaction history in the network and collect the earnings of this user
			#based on the date
			foreach($networkIds AS $networkUser)
			{
				#Determine the reward amount from the transactions for the given dates
				foreach($levelHistory AS $row)
				{
					$amount = $this->db->query($this->query_reader->get_query_by_code('get_cached_reward_amount', array('user_id'=>$userId, 'referral'=>$networkUser, 'start_date'=>$row['start_date'], 'end_date_condition'=>($row['end_date'] != '0000-00-00 00:00:00'? " AND UNIX_TIMESTAMP(pay_date) <= UNIX_TIMESTAMP('".$row['end_date']."') ": ""), 'source_list'=>"'network_commission'"     )))->row_array();
					$earningTotal += $amount['reward_total'];
				}
			}
			
		}
		#Recalculate the network earning details.
		#Slower option. For use in recalculating intial values or for use by cron jobs in generating cached values
		else
		{
			#2. Go through each user's transaction history in the network and collect the earnings of this user
			#based on the date
			foreach($networkIds AS $networkUser)
			{
				#Determine the reward amount from the transactions for the given dates
				foreach($levelHistory AS $row)
				{
					$amount = $this->db->query($this->query_reader->get_query_by_code('get_reward_amount', array('user_id'=>$networkUser, 'start_date'=>$row['start_date'], 'end_date_condition'=>($row['end_date'] != '0000-00-00 00:00:00'? " AND UNIX_TIMESTAMP(start_date) <= UNIX_TIMESTAMP('".$row['end_date']."') ": ""), 'pay_rate'=>$row['commission']     )))->row_array();
					$earningTotal += $amount['reward_total'];
				}
			}
		}
		
		return $earningTotal;
	}
	
	
	
	
	
	
	#Function to return a count of the network invites as requested
	public function get_network_invite_count($userId, $networkLevel='all')
	{
		$inviteCount = 0;
		
		if(!empty($this->networkInviteCount))
		{
			$inviteCount = !empty($this->networkInviteCount[$networkLevel])?$this->networkInviteCount[$networkLevel]: $inviteCount;
		}
		else
		{
			#1. Get the IDS for all referrals at each level
			$this->networkLevelIds = !empty($this->networkLevelIds)? $this->networkLevelIds: $this->scoring->get_user_referrals($userId, 'network_level_ids');
			
			#2. Get the count of all invites sent by users at each level
			$inviteArray = array();
			$level1 = $this->db->query($this->query_reader->get_query_by_code('get_number_of_invites', array('user_id'=>$userId)))->row_array();
			$inviteArray['level1'] = $level1['invite_count'];
			
			$level2count = 0;
			foreach($this->networkLevelIds['level2'] AS $networkUserId)
			{
				$level2 = $this->db->query($this->query_reader->get_query_by_code('get_number_of_invites', array('user_id'=>$networkUserId)))->row_array();
				$level2count += $level2['invite_count'];
			}
			$inviteArray['level2'] = $level2count;
			
			$level3count = 0;
			foreach($this->networkLevelIds['level3'] AS $networkUserId)
			{
				$level3 = $this->db->query($this->query_reader->get_query_by_code('get_number_of_invites', array('user_id'=>$networkUserId)))->row_array();
				$level3count += $level3['invite_count'];
			}
			$inviteArray['level3'] = $level3count;
			
			$level4count = 0;
			foreach($this->networkLevelIds['level4'] AS $networkUserId)
			{
				$level4 = $this->db->query($this->query_reader->get_query_by_code('get_number_of_invites', array('user_id'=>$networkUserId)))->row_array();
				$level4count += $level4['invite_count'];
			}
			$inviteArray['level4'] = $level4count;
			
			$inviteArray['all'] = $inviteArray['level1'] + $level2count + $level3count + $level4count;
			
			#3. Assign to global variables and prepare the return values
			$this->networkInviteCount = $inviteArray;
			
			$inviteCount = !empty($this->networkInviteCount[$networkLevel])?$this->networkInviteCount[$networkLevel]: $inviteCount;
		}
		
		return $inviteCount;
	}
	
	
	
	
	#Function to get the network level counts
	#level1 = Direct referrals
	public function get_network_level_count($userId, $networkLevel='level1')
	{
		$levelCount = 0;
		$this->networkLevelCount = $this->scoring->get_user_referrals($userId, 'network_level_count');
		
		$levelCount = !empty($this->networkLevelCount[$networkLevel])? $this->networkLevelCount[$networkLevel]: $levelCount;
		
		return $levelCount;
	}
	
	
	#Function to get the total users in my network
	public function get_total_users_in_my_network($userId, $refresh=FALSE)
	{
		$totalReferrals = 0;
		
		#The cached value will do.
		if(!$refresh)
		{
			$cloutScoreCache = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_cache', array('user_id'=>$userId)))->row_array();
			if(!empty($cloutScoreCache))
			{
				$this->cloutScoreData = $cloutScoreCache;
				$totalReferrals = $cloutScoreCache['total_network_referrals'];
			}
		}
		#recalculate the total users value. This option will take longer
		else
		{
			$totalReferrals = $this->scoring->get_user_referrals($userId, 'count') + $this->scoring->get_user_referrals($userId, 'network_count');
		}
		
		return $totalReferrals;
	}
	
	
	#Function to get the total direct users in my network
	public function get_total_direct_users_in_my_network($userId, $refresh=FALSE)
	{
		$totalDirectReferrals = 0;
		
		#The cached value will do.
		if(!$refresh)
		{
			$cloutScoreCache = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_cache', array('user_id'=>$userId)))->row_array();
			if(!empty($cloutScoreCache))
			{
				$this->cloutScoreData = $cloutScoreCache;
				$totalDirectReferrals = $cloutScoreCache['total_direct_referrals'];
			}
		}
		#recalculate the total users value. This option will take longer
		else
		{
			$totalDirectReferrals = $this->scoring->get_user_referrals($userId, 'count');
		}
		
		return $totalDirectReferrals;
	}
	
	
	
	#Function to get the last time a commission was earned
	private function get_last_time_commission_was_earned($userId)
	{
		$earnDetails = $this->db->query($this->query_reader->get_query_by_code('get_last_time_commission_was_earned', array('user_id'=>$userId)))->row_array();
		
		return !empty($earnDetails['last_earn_date'])? $earnDetails['last_earn_date']: '';
	}
	
	
	#Function to get the last time an invite was sent
	private function get_last_time_invite_was_sent($userId)
	{
		$sentDetails = $this->db->query($this->query_reader->get_query_by_code('get_last_time_an_invite_was_sent', array('user_id'=>$userId)))->row_array();
		
		return !empty($sentDetails['last_sent_date'])? $sentDetails['last_sent_date']: '';
	}
	
	
	#Function to get the last time a user joined my clout network
	private function get_last_time_user_joined_my_direct_network($userId)
	{
		$joinedDetails = $this->db->query($this->query_reader->get_query_by_code('get_last_time_user_joined_my_direct_network', array('user_id'=>$userId)))->row_array();
		
		return !empty($joinedDetails['last_join_date'])? $joinedDetails['last_join_date']: '';
	}
	
	
	
	#Function to get the user statistic by group
	public function get_user_statistic_by_group($userId, $statCodeArray, $storeId='')
	{
		$statValues = array();
		$this->set_store_id($storeId);
		$this->set_user_id($userId);
		
		foreach($statCodeArray AS $statCode)
		{
			$statValues[$statCode] = $this->get_user_statistic($userId, $statCode, $storeId);
		}
		
		return $statValues;
	}
	
	
	
	
	#Get score level data
	public function get_score_level_data($userId, $scoreType='store_score', $storeId='')
	{
		$scoreData = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_criteria', array('condition'=>'', 'order_by'=>" ORDER BY 0+level ASC ")))->result_array();
		
		#Then add the offer range for each score
		foreach($scoreData AS $key=>$data)
		{
			$range = $this->get_cash_back_range($storeId, $data['low_end_score']);
			$scoreData[$key]['min_cashback'] = $range['min'];
			$scoreData[$key]['max_cashback'] = $range['max'];
		}
		
		return $scoreData;
	}
	
	
	
	#Get range of cash_back for a given score
	public function get_cash_back_range($storeId, $score)
	{
		$range = array('min'=>0, 'max'=>0);
		$promotionsList = $this->db->query($this->query_reader->get_query_by_code('get_promotions_within_score_range', array('score'=>(!empty($score)?$score:0),  'store_id'=>$storeId, 'promotion_types'=>"'cash_back'", 'additional_conditions'=>" AND status='active' ", 'order_condition'=>" ORDER BY promotion_amount DESC ", 'limit_text'=>"")))->result_array();
		
		$promoCashbacks = array();
		
		foreach($promotionsList AS $promotionRow)
		{
			array_push($promoCashbacks, $promotionRow['promotion_amount']);
		}
		
		$range['min'] = !empty($promoCashbacks)? min($promoCashbacks): 0;
		$range['max'] = !empty($promoCashbacks)? max($promoCashbacks): 0;
		
		return $range;
	}
	
	
	
	
	
	
	#Set the store ID
	private function set_store_id($storeId)
	{
		$this->storeId = $storeId;
	}
	
	
	#Set the user ID
	private function set_user_id($userId)
	{
		$this->userId = $userId;
	}
	
	
	
	#Get the score breakdown points per item
	public function get_score_breakdown($userId, $scoreType, $storeId='', $fragmentation=array())
	{
		if($scoreType == 'store_score')
		{
			#Clout score
			$fragmentation=array();
			$fragmentation['clout_score_overall_spending'] = array('spending_last180days','spending_last360days','spending_total');
			$fragmentation['clout_score_linked_accounts'] = array('bank_verified_and_active','credit_verified_and_active','cash_balance_today','average_cash_balance_last24months','credit_balance_today','average_credit_balance_last24months');
			$fragmentationKeys = array_keys($fragmentation);
			$cloutScoreBreakdown = (!empty($this->cloutScoreBreakdown) && $this->userId==$userId && count(array_diff($fragmentationKeys, array_keys($this->cloutScoreBreakdown))) > 0)? $this->cloutScoreBreakdown: $this->scoring->get_clout_score_explanation($userId, $fragmentation);
			
			#Store score
			$fragmentation=array();
			$fragmentation['store_score_in_store_spending'] = array('my_store_spending_last90days', 'my_store_spending_last12months', 'my_store_spending_lifetime');
			$fragmentation['store_score_competitor_spending'] = array('my_direct_competitors_spending_last90days', 'my_direct_competitors_spending_last12months', 'my_direct_competitors_spending_lifetime');
			$fragmentation['store_score_category_spending'] = array('my_category_spending_last90days', 'my_category_spending_last12months', 'my_category_spending_lifetime');
			$fragmentation['store_score_related_category_spending'] = array('related_categories_spending_last90days', 'related_categories_spending_last12months', 'related_categories_spending_lifetime');
			$fragmentation['store_score_reviews_preferences'] = array('did_store_survey_last90days', 'did_competitor_store_survey_last90days', 'did_my_category_survey_last90days', 'did_related_categories_survey_last90days');
			$fragmentationKeys = array_keys($fragmentation);
			
			$storeScoreBreakdown = (!empty($this->storeScoreBreakdown) && $this->userId==$userId && $this->storeId==$storeId && in_array($fragmentationKeys, array_keys($this->storeScoreBreakdown)))? $this->storeScoreBreakdown: $this->scoring->get_store_score_explanation($userId, $storeId, $fragmentation);
			
			return array_merge($cloutScoreBreakdown, $storeScoreBreakdown);
			
		}
		else if($scoreType == 'clout_score')
		{
			return $this->get_user_statistic($userId, 'clout_score_breakdown');
		}
		else
		{
			return array();
		}
	}
	
	
	
	
	
	
}