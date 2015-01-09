<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing public pages.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */

class Page extends CI_Controller 
{
	
	#The home page
	public function index()
	{
		$data = filter_forwarded_data($this);
		$this->load->view('home', $data);
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
		$this->load->view('addons/basic_addons', $data);
	}
	
	
	#Function to show the system terms of reference
	public function terms_of_reference()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('page/terms_home', $data);
	}
	
	
	
	#Function to show the system privacy policy
	public function privacy_policy()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('page/privacy_home', $data);
	}
	
	
	
	#Function to show the system FAQs
	public function faqs()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('page/faqs', $data);
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
			$data['pageUrl'] = base_url().'account/logout/m/amsg';
			$data['pageTitle'] = SITE_TITLE.": Logout";
			$data['loadingMessage'] = 'Loading..';
		}
		
		$this->load->view('page/loading', $data);
	}
	
	
	
	
	
	#Notify the user that their session is about to expire
	public function refresh_session()
	{
		$data = filter_forwarded_data($this);
		#Refresh the user session
		if(!empty($data['u']))
		{
			$this->native_session->set('userId', decrypt_value($data['u']));
			$data['area'] = "blank_area_msg";
			$this->load->view('addons/basic_addons', $data);
		}
		else 
		{
			$data['area'] = "notify_session_refresh";
			$this->load->view('addons/basic_addons', $data);
		}
	}
	
	
}

/* End of controller file */