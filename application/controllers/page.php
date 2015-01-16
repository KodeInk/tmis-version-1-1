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
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->helper('form');
	}
		
	
	#The home page
	function index()
	{
		$data = filter_forwarded_data($this);
		$this->load->view('home', $data);
	}
	
	
	#Function to show the full image details
	function view_image_details()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['u']))
		{
			$data['url'] = base_url()."assets/uploads/images/".decrypt_value($data['u']);
		}
		
		$data['area'] = "show_bigger_image";
		$this->load->view('addons/basic_addons', $data);
	}
	
	
	#Function to show the system about us page
	function about_us()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('page/about_us', $data);
	}
	
	#Function to show the system terms of reference
	function terms_of_use()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('page/terms_of_use', $data);
	}
	
	
	
	#Function to show the system privacy policy
	function privacy_policy()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('page/privacy_policy', $data);
	}
	
	
	
	#Function to show the system FAQs
	function faqs()
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
	function refresh_session()
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
	
	
	
	#Function to handle contact us page submissions
	function contact_us()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('page/contact_us', $data);
	}
	
	
	# Show the address field form
	function address_field_form()
	{
		$data = filter_forwarded_data($this);
		
		$data['area'] = "address_field_form";
		$this->load->view('addons/basic_addons', $data);
	}
	
	
	# Copy address data from one field to another
	function copy_address_data()
	{
		$data = filter_forwarded_data($this);
		# copy over the address data
		$result = !empty($data['from']) && !empty($data['to'])? copy_address($this, $data):false;
		
		$data['area'] = "address_field_form";
		$this->load->view('addons/basic_addons', $data);
	}
	
	
	# Remove address data from a field
	function remove_address_data()
	{
		$data = filter_forwarded_data($this);
		# remove address data
		$result = !empty($data['field_id'])? remove_address($this, $data):false;
		
		$data['area'] = "address_field_form";
		$this->load->view('addons/basic_addons', $data);
	}
	
	
	# Get a customized drop down list
	function get_custom_drop_list()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['type'])){
			$data['list'] =  get_option_list($this, $data['type'], 'div');
		}
		
		$data['area'] = "dropdown_list";
		$this->load->view('addons/basic_addons', $data);
	}
	
	
	# Get values filled in by a form layer and put them in a session for layer use
	function get_layer_form_values()
	{
		$data = filter_forwarded_data($this);
		
		switch($data['type'])
		{
			case 'address':
				$data = !empty($_POST)? array_merge($data, $_POST): $data;
				#Placeholder function
				#WARNING: this has security issues
				process_fields($this, $data);
			break;
			
			default:
			break;
		}
		
		$data['msg'] = "data added";
		$data['area'] = "basic_msg";
		$this->load->view('addons/basic_addons', $data);
	}
}

/* End of controller file */