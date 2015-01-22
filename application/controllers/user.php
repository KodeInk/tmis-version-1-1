<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing user pages on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class User extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: View user applications
	function applications()
	{
		$data = filter_forwarded_data($this);
		$instructions['action'] = array('view'=>'view_user_applications', 'verify'=>'verify_user_applications');
		check_access($this, get_access_code($data, $instructions));
		
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Add a new user
	function add()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'add_new_user');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Set user permissions
	function set_permissions()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'set_user_permissions');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Update user status
	function update_status()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'change_user_status');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Change other users' passwords
	function change_password()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'change_other_user_passwords');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
}

/* End of controller file */