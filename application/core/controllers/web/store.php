<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls showing information related to a store.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 01/14/2014
 */
class Store extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('promotion_manager');
		$this->load->model('store_manager');
	}
	
	
	#Function to show a store offer explanation
	public function offer_explanation()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['u']) && !empty($data['t']))
		{
			$data['userId'] = decrypt_value($data['u']);
			$data['offerId'] = decrypt_value($data['t']);
			
			$divListAll = $this->native_session->get('all_divs');
			unset($divListAll[array_search($data['offerId'], $divListAll)]);
			
			$data['divList'] = $divListAll;
			$data['offerDetails'] = $this->db->query($this->query_reader->get_query_by_code('get_promotion_by_id', array('promotion_id'=>$data['offerId'])))->row_array();
			
			#Get other details from rules 
			$data['offerDetails']['extra_conditions'] = $this->promotion_manager->display_extra_offer_conditions($data['offerId']);
			$data['offerDetails']['requires_scheduling'] = $this->promotion_manager->does_promotion_have_rule($data['offerId'], 'requires_scheduling');
		}
		else
		{
			$data['msg'] = "ERROR: Offer can not be resolved.";
		}
		
		$data['area'] = 'offer_explanation';
		$this->load->view('web/addons/store_addons', $data);
	}



	
	
	#Function to get the offer list for the supplied level
	public function get_offer_list()
	{
		$data = filter_forwarded_data($this);
		
		#Get the offer level
		if(!empty($data['l']))
		{
			$layerNameParts = explode('_', $data['l']);
			$level = $layerNameParts[1];
		}
		else
		{
			$level = 0;
		}
		
		#Get the extra level details
		if(!empty($data['e']))
		{
			$extraInfo = explode('__', $data['e']);
			$data['currentLevel'] = $extraInfo[1];
			$data['viewedLevel'] = $level;
			$data['remainingPoints'] = !empty($extraInfo[2])?$extraInfo[2]:'';
			
			#Pass the StoreId and Level
			if($level == $extraInfo[1])
			{
				$data['offers']['cash_back'] = $this->promotion_manager->which_promotions_does_score_qualify_for($extraInfo[0], $this->native_session->get('userId'), array('cash_back'));
				$data['offers']['perks'] = $this->promotion_manager->which_promotions_does_score_qualify_for($extraInfo[0], $this->native_session->get('userId'), array('perk'));
				$data['isCurrentLevel'] = TRUE;
			} 
			else
			{
				$data['offers'] = $this->promotion_manager->get_offers_at_level($extraInfo[0], $this->native_session->get('userId'), $level);
			}
		}
		
		$data['area'] = 'offer_list';
		$this->load->view('web/addons/store_addons', $data);
	}
	
	
	
	
	
	#Checkin a user
	public function checkin_user()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['f']) && !empty($data['u']))
		{
			$data['result'] = $this->store_manager->checkin_user_on_offer(decrypt_value($data['u']), decrypt_value($data['f']));
		}
		$data['area'] = 'checkin_result';
		$this->load->view('web/addons/store_addons', $data);
	}
	
	
	
	
	
	#Function to send a schedule request
	public function send_schedule_request()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['u']) && !empty($data['t']))
		{
			$data['userId'] = decrypt_value($data['u']);
			$data['offerId'] = decrypt_value($data['t']);
		
			$data['result'] = $this->store_manager->send_schedule_request($data['userId'], $data['offerId'], $_POST);
		}
		
		$data['area'] = 'scheduler_result';
		$this->load->view('web/addons/store_addons', $data);
	}
	
	
	
	
	
	#Send a store suggestion
	function suggest_store_by_public()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($_POST))
		{
			#If the user is suggested
			$userId = !empty($data['u'])? decrypt_value($data['u']): '';
			
			$_POST = array_merge($_POST, array('user_id'=>$userId));
			$data['result'] = $this->store_manager->suggest_store($_POST);
		}
		
		$data['area'] = 'suggest_store';
		$this->load->view('web/addons/store_addons', $data);
	}
	
	
	
}

/* End of controller file */