<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls showing user scores.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 11/26/2013
 */
class Score extends CI_Controller 
{
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
        $this->load->model('scoring');
    }
	
	
	
	
	#Show a score's origins
	public function show_score_origins()
	{
		$data = filter_forwarded_data($this);
		
		#Parameters for getting the score details: userId, [storeId], level, variable, scoreType
		#level 0 just returns the user's recalculated score
		$data['userId'] = decrypt_value($data['u']);
		$data['storeId'] = !empty($data['s'])?decrypt_value($data['s']): "";
		$data['level'] = decrypt_value($data['l']);
		$data['variable'] = decrypt_value($data['v']);
		$data['scoreType'] = !empty($data['t'])?decrypt_value($data['t']): "";
		
		
		#Get the score details based on what is required
		$data['scoreDetails'] = $this->scoring->get_score_origins($data['userId'], $data['level'], $data['variable'], $data['scoreType'], $data['storeId']);
		
		#Show the links that are available for display
		if($data['scoreType'] == 'clout_score')
		{
			$data['availableLinks'] = array('number_of_surveys_answered_in_last90days', 'number_of_direct_referrals_last180days', 'number_of_direct_referrals_last360days', 'total_direct_referrals', 'number_of_network_referrals_last180days', 'total_network_referrals', 'spending_of_direct_referrals_last180days', 'spending_of_direct_referrals_last360days', 'total_spending_of_direct_referrals', 'spending_of_network_referrals_last180days', 'spending_of_network_referrals_last360days', 'total_spending_of_network_referrals', 'spending_last180days', 'spending_last360days', 'spending_total', 'ad_spending_last180days', 'ad_spending_last360days', 'ad_spending_total', 'average_cash_balance_last24months', 'average_credit_balance_last24months'); 
		}
		else if($data['scoreType'] == 'store_score')
		{
			$data['availableLinks'] = array('my_store_spending_last90days', 'my_store_spending_last12months', 'my_store_spending_lifetime', 'my_direct_competitors_spending_last90days', 'my_direct_competitors_spending_last12months', 'my_direct_competitors_spending_lifetime', 'my_category_spending_last90days', 'my_category_spending_last12months', 'my_category_spending_lifetime', 'related_categories_spending_last90days', 'related_categories_spending_last12months', 'related_categories_spending_lifetime', 'average_cash_balance_last24months', 'average_credit_balance_last24months'); 
		}
		else if($data['scoreType'] == 'merchant_score')
		{
			$data['availableLinks'] = array('direct_referrals_last30days', 'direct_referrals_last180days', 'direct_referrals_total', 'network_referrals_last30days', 'network_referrals_last180days', 'network_referrals_total', 'customer_spending_last30days', 'customer_spending_last180days', 'customer_spending_total', 'customer_promo_related_spending_last30days', 'customer_promo_related_spending_last180days', 'customer_promo_related_spending_total'); 
		}
		
		#Set a title of the view if it is the second level
		if($data['level'] == '2')
		{
			$title = $this->scoring->get_criteria_by_keys(array($data['variable']));
			$data['title'] = $title[0]['description'];
		}
		
		#Determine the area and the view to show the results
		$data['area'] = 'level_'.$data['level'].'_area';
		$view = $data['scoreType'].'_origins';
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/addons/'.$view, $data);
	}
	
	
	#Update score criteria values as instructed
	public function update_score_criteria()
	{
		$data = filter_forwarded_data($this);
		
		#Parameters for updating a score value
		$code = decrypt_value($data['c']);
		$field = decrypt_value($data['f']);
		$fieldPart = decrypt_value($data['p']);
		
		#Update the criteria value
		$data['updateResult'] = $this->db->query($this->query_reader->get_query_by_code('update_criteria_score_value', array('code'=>$code, 'field_name'=>$field, 'field_value'=>$data[$fieldPart.$code] )));
		
		$data['area'] = 'score_update_area';
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/addons/result_view', $data);
	}
	
	
	
	
	#View score settings
	public function score_settings()
	{
		$data = filter_forwarded_data($this);
		
		#The score type we are dealing with
		$data['scoreType'] = !empty($data['t'])?decrypt_value($data['t']): 'clout_score';
		
		#Get any user's cached row to pick the score parameters using the DUMMY values. 
		if($data['scoreType'] == 'clout_score')
		{
			$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_cache', array('user_id'=>DUMMY_USER_ID)))->row_array();
		}
		else if($data['scoreType'] == 'store_score')
		{
			$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_a_user_store_score_cache', array('user_id'=>DUMMY_USER_ID)))->row_array();
		}
		else if($data['scoreType'] == 'merchant_score')
		{
			$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_merchant_score_cache', array('user_id'=>DUMMY_USER_ID)))->row_array();
		}
		
		$data['criteriaList'] = $this->scoring->get_criteria_by_keys(array_keys($scoreDetails), " ORDER BY description ");
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/settings/score_settings', $data);
	}
	
	
	
	
	#View the store score actions
	public function show_store_score_actions()
	{
		$data = filter_forwarded_data($this);
		$data['userId'] = decrypt_value($data['u']);
		$data['storeId'] = $data['storelist'];#Passed from selection and not encrypted
		
		$data['scoreDetails'] = $this->db->query($this->query_reader->get_query_by_code('get_store_score_cache', array('user_id'=>$data['userId'], 'store_id'=>$data['storeId'])))->row_array();
		
		
		$data['area'] = 'store_score_actions';
		$this->load->view('web/addons/score_addons', $data);
	}
	
	
	#Function to show score explanations
	public function score_explanation()
	{
		$data = filter_forwarded_data($this);
		$data['userId'] = decrypt_value($data['u']);
		$data['scoreType'] = decrypt_value($data['t']);
		
		#All the score section title codes
		$allTitles = array('in_store_spending', 'competitor_spending', 'category_spending', 'related_category_spending', 'overall_spending', 'linked_accounts', 'reviews_preferences');
		#Eliminate the section whose explanation you are showing
		$data['typeTitles'] = array_diff($allTitles, array($data['scoreType']));
		
		$data['area'] = 'score_explanation';
		$this->load->view('web/addons/score_addons', $data);
	}
	
	
	
	
	
	
	
	
	
}

/* End of controller file */