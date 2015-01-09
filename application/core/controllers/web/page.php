<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing public pages.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 02/26/2014
 */
class Page extends CI_Controller 
{
	#Function to show the merchant home
	public function show_merchant_home()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/merchants/merchants_home', $data);
	}
	
	#Function to show the agent home
	public function show_agent_home()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/agents/agents_home', $data);
	}
	
	 
	#Function to show the affiliate home
	public function show_affiliate_home()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/affiliates/affiliates_home', $data);
	}
	
	
	#Function to show the full image details
	public function view_image_details()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['u']))
		{
			$data['url'] = base_url()."assets/uploads/images/".decrypt_value($data['u']);
		}
		
		$data['area'] = "show_bigger_image";
		$this->load->view('web/addons/basic_addons', $data);
	}
	
	
	#FUnction  to show the map to location
	public function map_to_location()
	{
		$data = filter_forwarded_data($this);
		if(!empty($data['a']))
		{
			$data['address'] = decrypt_value($data['a']);
		}
		else
		{
			format_notice('ERROR: Address could not be resolved.');
		}
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/addons/map_to_location', $data);
	}
	
	#Function to show the system terms of reference
	public function terms_of_reference()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/page/terms_home', $data);
	}
	
	#Function to show the system privacy policy
	public function privacy_policy()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/page/privacy_home', $data);
	}
	
	
	#Function to view a video based on the instruction set
	public function show_help_video()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['t']))
		{
			$data['videoDetails'] = $this->db->query($this->query_reader->get_query_by_code('get_asset_by_code', array('code'=>decrypt_value($data['t']), 'asset_type'=>'video' )))->row_array();
		}
		$data['area'] = "show_video_area";
		$this->load->view('web/addons/basic_addons', $data);
	}
	
	
	
	
	
	#Load a slow page and shwo a temporary message in the process
	function load_slow_page()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['p']) && !empty($data['t']))
		{
			$data['pageUrl'] = decrypt_value($data['p']);
			$data['pageTitle'] = SITE_TITLE.": ".decrypt_value($data['t']);
			$data['loadingMessage'] = !empty($data['m'])?decrypt_value($data['m']): 'Loading..';
		}
		else
		{
			$this->native_session->set('amsg', "WARNING: You do not have sufficient priviliges to access the desired page. <br>Please contact your administrator.");
			$data['pageUrl'] = base_url().'web/account/logout/m/amsg';
			$data['pageTitle'] = SITE_TITLE.": Logout";
			$data['loadingMessage'] = 'Loading..';
		}
		
		$this->load->view('web/page/loading', $data);
	}
}

/* End of controller file */