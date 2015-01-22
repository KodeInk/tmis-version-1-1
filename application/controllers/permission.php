<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing permission pages on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Permission extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: View permission changes
	function changes()
	{
		$data = filter_forwarded_data($this);
		$instructions['action'] = array('verify'=>'verify_permission_change_requests');
		check_access($this, get_access_code($data, $instructions));
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View list of permissions
	function lists()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_permission_list');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: View list of permission groups
	function group_list()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_permission_group_list');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View list of users and their permissions
	function user_list()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_user_permissions');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Add a permission group
	function add_group()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'add_new_permission_group');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Update a group's permissions
	function update_group()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'change_group_permissions');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
}

/* End of controller file */