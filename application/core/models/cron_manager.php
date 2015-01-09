<?php

/**
 * This class specifies manages the system cron jobs.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 12/03/2013
 */
class Cron_manager extends CI_Model
{
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
        $this->load->model('scoring');
	}
	
	
	
	
	
	
	
	
	
	#Function to update a user's cached score field
	public function update_score_field_cache_value($userId, $fieldCode, $scoreType='clout_score', $storeId='')
	{
		$result = FALSE;
		
		#Get the user details if the fieldCode is any of the following
		if(in_array($fieldCode, array('email_verified', 'mobile_verified', 'profile_photo_added', 'location_services_activated', 'push_notifications_activated', 'first_payment_success', 'first_adrelated_payment_success', 'has_first_public_checkin_success')))
		{
			$userDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$userId)))->row_array();
		}
		
		
		#Get the merchant details if the fieldCode is any of the following
		if(in_array($fieldCode, array('is_merchant_account_verified', 'has_merchant_ran_first_promo', 'offers_store_score_discount', 'processed_first_payment', 'is_pos_linked', 'accepts_bonus_cash', 'has_processed_payment_last24hours', 'has_processed_promo_payment_last24hours', 'number_of_public_checkins', 'direct_referrals_last30days', 'direct_referrals_last180days', 'direct_referrals_total', 'network_referrals_last30days', 'network_referrals_last180days', 'network_referrals_total', 'customer_spending_last30days', 'customer_spending_last180days', 'customer_spending_total', 'customer_promo_related_spending_last30days', 'customer_promo_related_spending_last180days', 'customer_promo_related_spending_total')))
		{
			$merchantDetails = $this->db->query($this->query_reader->get_query_by_code('get_merchant_by_user_id', array('user_id'=>$userId)))->row_array();
		}
		
		
		
		#Update the value based on the specified field code
		if($fieldCode == 'facebook_connected')
		{
			$facebookConnected = $this->scoring->does_user_have_social_network($userId, 'Facebook', 'verified');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($facebookConnected? 'Y': 'N')  )));
		}
		
		#Basic user ON/OFF flags from the user details
		else if(in_array($fieldCode, array('email_verified', 'mobile_verified', 'location_services_activated', 'push_notifications_activated', 'first_payment_success', 'first_adrelated_payment_success', 'has_first_public_checkin_success')))
		{
			#Maps the field code to the actual DB column name in the users table
			$fieldToDbArray = array('email_verified'=>'email_verified', 'mobile_verified'=>'mobile_verified',  'location_services_activated'=>'location_services_on', 'push_notifications_activated'=>'push_notifications_on', 'first_payment_success'=>'made_first_payment', 'first_adrelated_payment_success'=>'made_first_promo_payment', 'has_first_public_checkin_success'=>'made_public_checkin');
			
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$userDetails[$fieldToDbArray[$fieldCode]])));
		}
		
		
		#Basic merchant ON/OFF flags from the merchant details
		else if(in_array($fieldCode, array('is_merchant_account_verified', 'has_merchant_ran_first_promo', 'offers_store_score_discount', 'processed_first_payment', 'is_pos_linked', 'accepts_bonus_cash')))
		{
			#Maps the field code to the actual DB column name in the users table
			$fieldToDbArray = array('is_merchant_account_verified'=>'is_account_verified', 'has_merchant_ran_first_promo'=>'has_ran_first_promo', 'offers_store_score_discount'=>'offers_store_discount', 'processed_first_payment'=>'has_processed_first_payment', 'is_pos_linked'=>'pos_system_clout_connected', 'accepts_bonus_cash'=>'accepts_bonus_cash');
			
			$result = $this->db->query($this->query_reader->get_query_by_code('update_merchant_score_cache_value', array('merchant_id'=>$merchantDetails['merchant_id'], 'field_name'=>$fieldCode, 'field_value'=>$merchantDetails[$fieldToDbArray[$fieldCode]])));
		}
		
		else if($fieldCode == 'profile_photo_added')
		{
			$profilePhotoAdded = !empty($userDetails['photo_url'])? 'Y': 'N';
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$profilePhotoAdded)));
		}
		
		else if($fieldCode == 'bank_verified_and_active')
		{
			$bankVerifiedAndActive = $this->scoring->does_user_have_bank_account($userId, 'is_verified', 'active');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($bankVerifiedAndActive? 'Y': 'N')  )));
		}
		
		else if($fieldCode == 'credit_verified_and_active')
		{
			$creditVerifiedAndActive = $this->scoring->get_user_credit($userId, 'check');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($creditVerifiedAndActive? 'Y': 'N')  )));
		}
		
		else if($fieldCode == 'member_processed_payment_last7days')
		{
			$memberProcessedPaymentLast7Days = $this->scoring->get_user_transactions($userId, 'check', array('start_date'=>date('Y-m-d', strtotime('-7 days')), 'end_date'=>date('Y-m-d'))); 
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($memberProcessedPaymentLast7Days? 'Y': 'N')  )));
		}
		
		else if($fieldCode == 'member_processed_promo_payment_last7days')
		{
			$memberProcessedPromoPaymentLast7Days = $this->scoring->get_user_transactions($userId, 'promo_check', array('start_date'=>date('Y-m-d', strtotime('-7 days')), 'end_date'=>date('Y-m-d'))); 
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($memberProcessedPromoPaymentLast7Days? 'Y': 'N')  )));
		}
		
		else if($fieldCode == 'has_public_checkin_last7days')
		{
			$hasPublicCheckinLast7Days = $this->scoring->get_user_checkins($userId, 'check', array('start_date'=>date('Y-m-d', strtotime('-7 days')), 'end_date'=>date('Y-m-d'))); 
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($hasPublicCheckinLast7Days? 'Y': 'N')  )));
		}
		
		else if($fieldCode == 'has_answered_survey_in_last90days')
		{
			$hasAnsweredSurveyLast90Days = $this->scoring->get_user_surveys($userId, 'check', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d'))); 
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($hasAnsweredSurveyLast90Days? 'Y': 'N')  )));
		}
		
		else if($fieldCode == 'number_of_surveys_answered_in_last90days')
		{
			$numberOfSurveysAnsweredInLast90Days = $this->scoring->get_user_surveys($userId, 'count', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d')));
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$numberOfSurveysAnsweredInLast90Days)));
		}
		
		else if($fieldCode == 'number_of_direct_referrals_last180days')
		{
			$numberOfDirectReferralsLast180Days = $this->scoring->get_user_referrals($userId, 'count', array('start_date'=>date('Y-m-d', strtotime('-180 days')), 'end_date'=>date('Y-m-d')));
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$numberOfDirectReferralsLast180Days)));
		}
		
		else if($fieldCode == 'number_of_direct_referrals_last360days')
		{
			$numberOfDirectReferralsLast360Days = $this->scoring->get_user_referrals($userId, 'count', array('start_date'=>date('Y-m-d', strtotime('-360 days')), 'end_date'=>date('Y-m-d')));
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$numberOfDirectReferralsLast360Days)));
		}
		
		else if($fieldCode == 'total_direct_referrals')
		{
			$totalDirectReferrals = $this->scoring->get_user_referrals($userId, 'count');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$totalDirectReferrals)));
		}
		
		else if($fieldCode == 'number_of_network_referrals_last180days')
		{
			$numberOfNetworkReferralsLast180Days = $this->scoring->get_user_referrals($userId, 'network_count', array('start_date'=>date('Y-m-d', strtotime('-180 days')), 'end_date'=>date('Y-m-d')));
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$numberOfNetworkReferralsLast180Days)));
		}
		
		else if($fieldCode == 'total_network_referrals')
		{
			$totalNetworkReferrals = $this->scoring->get_user_referrals($userId, 'network_count');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$totalNetworkReferrals)));
		}
		
		else if($fieldCode == 'spending_of_direct_referrals_last180days')
		{
			$spendingOfDirectReferralsLast180Days = $this->scoring->get_referral_spending($userId, 'list', array('start_date'=>date('Y-m-d', strtotime('-180 days')), 'end_date'=>date('Y-m-d')), 'totals');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$spendingOfDirectReferralsLast180Days)));
		}
		
		else if($fieldCode == 'spending_of_direct_referrals_last360days')
		{
			$spendingOfDirectReferralsLast360Days = $this->scoring->get_referral_spending($userId, 'list', array('start_date'=>date('Y-m-d', strtotime('-360 days')), 'end_date'=>date('Y-m-d')), 'totals');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$spendingOfDirectReferralsLast360Days)));
		}
		
		else if($fieldCode == 'total_spending_of_direct_referrals')
		{
			$totalSpendingOfDirectReferrals = $this->scoring->get_referral_spending($userId, 'list', array(), 'totals');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$totalSpendingOfDirectReferrals)));
		}
		
		else if($fieldCode == 'spending_of_network_referrals_last180days')
		{
			$spendingOfNetworkReferralsLast180Days = $this->scoring->get_referral_spending($userId, 'network_list', array('start_date'=>date('Y-m-d', strtotime('-180 days')), 'end_date'=>date('Y-m-d')), 'totals');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$spendingOfNetworkReferralsLast180Days)));
		}
		
		else if($fieldCode == 'spending_of_network_referrals_last360days')
		{
			$spendingOfNetworkReferralsLast360Days = $this->scoring->get_referral_spending($userId, 'network_list', array('start_date'=>date('Y-m-d', strtotime('-360 days')), 'end_date'=>date('Y-m-d')), 'totals');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$spendingOfNetworkReferralsLast360Days)));
		}
		
		else if($fieldCode == 'total_spending_of_network_referrals')
		{
			$totalSpendingOfNetworkReferrals = $this->scoring->get_referral_spending($userId, 'network_list', array(), 'totals');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$totalSpendingOfNetworkReferrals)));
		}
		
		else if($fieldCode == 'spending_last180days')
		{
			$spendingLast180Days = $this->scoring->get_user_transactions($userId, 'totals', array('start_date'=>date('Y-m-d', strtotime('-180 days')), 'end_date'=>date('Y-m-d')));
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$spendingLast180Days)));
		}
		
		else if($fieldCode == 'spending_last360days')
		{
			$spendingLast360Days = $this->scoring->get_user_transactions($userId, 'totals', array('start_date'=>date('Y-m-d', strtotime('-360 days')), 'end_date'=>date('Y-m-d')));
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$spendingLast360Days)));
		}
		
		else if($fieldCode == 'spending_total')
		{
			$spendingTotal = $this->scoring->get_user_transactions($userId, 'totals');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$spendingTotal)));
		}
		
		else if($fieldCode == 'ad_spending_last180days')
		{
			$adSpendingLast180Days = $this->scoring->get_user_transactions($userId, 'promo_totals', array('start_date'=>date('Y-m-d', strtotime('-180 days')), 'end_date'=>date('Y-m-d')));
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$adSpendingLast180Days)));
		}
		
		else if($fieldCode == 'ad_spending_last360days')
		{
			$adSpendingLast360Days = $this->scoring->get_user_transactions($userId, 'promo_totals', array('start_date'=>date('Y-m-d', strtotime('-360 days')), 'end_date'=>date('Y-m-d')));
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$adSpendingLast360Days)));
		}
		
		else if($fieldCode == 'ad_spending_total')
		{
			$adSpendingTotal = $this->scoring->get_user_transactions($userId, 'promo_totals');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$adSpendingTotal)));
		}
		
		else if($fieldCode == 'cash_balance_today')
		{
			$cashBalanceToday = $this->scoring->get_user_cash($userId, 'latest');
			if($scoreType == 'clout_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$cashBalanceToday['cash_amount'])));
			}
			else if($scoreType == 'store_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'store_id'=>$storeId, 'field_name'=>$fieldCode, 'field_value'=>$cashBalanceToday['cash_amount']))); 
			}
		}
		
		else if($fieldCode == 'average_cash_balance_last24months')
		{
			$averageCashBalanceLast24Months = $this->scoring->get_user_cash($userId, 'average', array('start_date'=>date('Y-m-d', strtotime('-24 months')), 'end_date'=>date('Y-m-d')));
			
			if($scoreType == 'clout_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$averageCashBalanceLast24Months)));
			}
			else if($scoreType == 'store_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'store_id'=>$storeId, 'field_name'=>$fieldCode, 'field_value'=>$averageCashBalanceLast24Months)));
			}
		}
		
		else if($fieldCode == 'credit_balance_today')
		{
			$creditBalanceToday = $this->scoring->get_user_credit($userId, 'latest');
			
			if($scoreType == 'clout_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$creditBalanceToday['credit_amount'])));
			}
			else if($scoreType == 'store_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'store_id'=>$storeId, 'field_name'=>$fieldCode, 'field_value'=>$creditBalanceToday['credit_amount'])));
			}
		}
		
		else if($fieldCode == 'average_credit_balance_last24months')
		{
			$averageCreditBalanceLast24Months = $this->scoring->get_user_credit($userId, 'average', array('start_date'=>date('Y-m-d', strtotime('-24 months')), 'end_date'=>date('Y-m-d')));
			
			if($scoreType == 'clout_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$averageCreditBalanceLast24Months)));
			}
			else if($scoreType == 'store_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'store_id'=>$storeId, 'field_name'=>$fieldCode, 'field_value'=>$averageCreditBalanceLast24Months)));
			}
		}
		
		else if($fieldCode == 'did_store_survey_last90days')
		{
			$didStoreSurveyLast90Days = $this->scoring->get_user_surveys($userId, 'check', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d')), $storeId);
			
			$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($didStoreSurveyLast90Days? 'Y':'N'), 'store_id'=>$storeId)));
		}
		
		else if($fieldCode == 'did_competitor_store_survey_last90days')
		{
			$didCompetitorStoreSurveyLast90Days = $this->scoring->get_user_surveys($userId, 'competitor_check', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d')), $storeId);
			
			$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($didCompetitorStoreSurveyLast90Days? 'Y':'N'), 'store_id'=>$storeId)));
		}
		
		else if($fieldCode == 'did_my_category_survey_last90days')
		{
			$didMyCategorySurveyLast90Days = $this->scoring->get_user_surveys($userId, 'category_check', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d')), $storeId);
			
			$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($didMyCategorySurveyLast90Days? 'Y':'N'), 'store_id'=>$storeId)));
		}
		
		else if($fieldCode == 'did_related_categories_survey_last90days')
		{
			$didRelatedCategorySurveyLast90Days = $this->scoring->get_user_surveys($userId, 'related_category_check', array('start_date'=>date('Y-m-d', strtotime('-90 days')), 'end_date'=>date('Y-m-d')), $storeId);
			
			$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>($didRelatedCategorySurveyLast90Days? 'Y':'N'), 'store_id'=>$storeId)));
		}
		
		else if(in_array($fieldCode, array('my_store_spending_last90days', 'my_store_spending_last12months', 'my_store_spending_lifetime', 'my_direct_competitors_spending_last90days', 'my_direct_competitors_spending_last12months', 'my_direct_competitors_spending_lifetime')))
		{
			$action = (strpos($fieldCode, 'competitors_') !== FALSE)? 'competitor_total': 'total';
			$storeSpending = $this->scoring->get_store_spending($userId, $action, array('start_date'=>$this->scoring->format_date_on_clue($fieldCode), 'end_date'=>date('Y-m-d')), $storeId);
			
			$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$storeSpending, 'store_id'=>$storeId)));
		}
		
		else if(in_array($fieldCode, array('my_category_spending_last90days', 'my_category_spending_last12months', 'my_category_spending_lifetime', 'related_categories_spending_last90days', 'related_categories_spending_last12months', 'related_categories_spending_lifetime')))
		{
			$action = (strpos($fieldCode, 'related_categories_') !== FALSE)? 'related_category_total': 'total';
			$categorySpending = $this->scoring->get_category_spending($userId, $action, array('start_date'=>$this->scoring->format_date_on_clue($fieldCode), 'end_date'=>date('Y-m-d')), $storeId);
			
			$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'field_name'=>$fieldCode, 'field_value'=>$categorySpending, 'store_id'=>$storeId)));
		}
		
		else if(in_array($fieldCode, array('has_processed_payment_last24hours', 'has_processed_promo_payment_last24hours')))
		{
			$action = (strpos($fieldCode, 'promo_') !== FALSE)? 'promo_check': 'check';
			$hasProcessedPaymentLast24Hours = $this->scoring->get_store_transactions($userId, $action, array('start_date'=>date('Y-m-d H:i:s', strtotime('-24 hours')), 'end_date'=>date('Y-m-d')));
			
			$result = $this->db->query($this->query_reader->get_query_by_code('update_merchant_score_cache_value', array('merchant_id'=>$merchantDetails['merchant_id'], 'field_name'=>$fieldCode, 'field_value'=>($hasProcessedPaymentLast24Hours? 'Y':'N') )));
		}
		
		else if($fieldCode == 'number_of_public_checkins')
		{
			$numberOfPublicCheckins = $this->scoring->get_user_checkins($userId, 'total', array(), 'merchant');
			$result = $this->db->query($this->query_reader->get_query_by_code('update_merchant_score_cache_value', array('merchant_id'=>$merchantDetails['merchant_id'], 'field_name'=>$fieldCode, 'field_value'=>$numberOfPublicCheckins)));
		}
		
		else if(in_array($fieldCode, array('direct_referrals_last30days', 'direct_referrals_last180days', 'direct_referrals_total', 'network_referrals_last30days', 'network_referrals_last180days', 'network_referrals_total')))
		{
			$action = (strpos($fieldCode, 'network_') !== FALSE)? 'network_count': 'count';
			$numberOfReferrals = $this->scoring->get_user_referrals($userId, $action, array('start_date'=>$this->scoring->format_date_on_clue($fieldCode), 'end_date'=>date('Y-m-d')));
			$result = $this->db->query($this->query_reader->get_query_by_code('update_merchant_score_cache_value', array('merchant_id'=>$merchantDetails['merchant_id'], 'field_name'=>$fieldCode, 'field_value'=>$numberOfReferrals)));
		}
		
		else if(in_array($fieldCode, array('customer_spending_last30days', 'customer_spending_last180days', 'customer_spending_total', 'customer_promo_related_spending_last30days', 'customer_promo_related_spending_last180days', 'customer_promo_related_spending_total')))
		{
			$action = (strpos($fieldCode, 'promo_') !== FALSE)? 'promo_totals': 'totals';
			$customerSpending = $this->scoring->get_store_transactions($userId, $action, array('start_date'=>$this->scoring->format_date_on_clue($fieldCode), 'end_date'=>date('Y-m-d')));
			$result = $this->db->query($this->query_reader->get_query_by_code('update_merchant_score_cache_value', array('merchant_id'=>$merchantDetails['merchant_id'], 'field_name'=>$fieldCode, 'field_value'=>$customerSpending)));
		}
		
		
		
		
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
}


?>