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
		$this->load->model('_person');
	}
	
	
	#STUB: View user applications
	function applications()
	{
		$data = filter_forwarded_data($this);
		$instructions['action'] = array('view'=>'view_user_applications', 'verify'=>'verify_user_applications');
		check_access($this, get_access_code($data, $instructions));
		
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	# Add a new user
	function add()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'add_new_user');
		
		# If user has posted the form for processing
		if(!empty($_POST))
		{
			#Pass these details to the person object to handle with XSS filter turned on
			$data['result'] = $this->_person->add_profile($this->input->post(NULL, TRUE));
			$data['msg'] = $data['result']['boolean'] && empty($data['result']['msg'])? "The user account has been created.": $data['result']['msg'];
			if($data['result']['boolean']){
				$this->native_session->delete_all(array('person_id'=>'', 'firstname'=>'', 'lastname'=>'', 'role__roles'=>'', 'emailaddress'=>'', 'telephone'=>''));
				$this->native_session->set('msg', $data['msg']);
				redirect(base_url().'user/update_status');
			}
		}
		
		$this->load->view('user/new_user', $data); 
	}
	
	
	# Set user permissions
	function set_permissions()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'set_user_permissions');
		
		# User is setting the permission
		if(!empty($data['set_id']))
		{
			$check = array_key_contains('userpermission_', $data);
			if($check['boolean'])
			{
				$result = $this->_user->change_role($data['set_id'], $data[$check['key']]);
				$data['msg'] = $result? 'User role updated': 'ERROR: User not updated.';
			}
			else
			{
				$data['msg'] = 'ERROR: User ID not resolved.';
			}
			$data['area'] = 'basic_msg';
			$this->load->view('addons/basic_addons', $data);
		}
		else
		{
			$data['action'] = 'setpermission';
			$data['list'] = $this->_user->get_list(array('action'=>'setpermission'));
			$this->load->view('user/list_users', $data);
		}
	}
	
	
	
	# Update user status
	function update_status()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'change_user_status');
		
		$data['action'] = 'update';
		$data['list'] = $this->_user->get_list(array('action'=>'update'));
		$this->load->view('user/list_users', $data); 
	}
	
	
	#STUB: Change other users' passwords
	function change_password()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'change_other_user_passwords');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	# Verify the user (all actions: approve, reject, block, etc)
	function verify()
	{
		$data = filter_forwarded_data($this);
		if(!empty($_POST))
		{
			# Approve or reject a user
			$result = $this->_user->verify($_POST);
			
			$actionPart = current(explode("_", $_POST['action']));
			$actions = array('approve'=>'approved', 'reject'=>'rejected', 'block'=>'blocked', 'archive'=>'archived', 'restore'=>'restored', 'publish'=>'published');
			$actionWord = !empty($actions[$actionPart])? $actions[$actionPart]: 'made';
			$this->native_session->set('msg', ($result['boolean']? "The user has been ".$actionWord: (!empty($result['msg'])? $result['msg']: "ERROR: The user could not be ".$actionWord) ));
		}
		else
		{
			# Get list type
			$data['list_type'] = current(explode("_", $data['action']));
			$data['area'] = 'verify_user';
			$this->load->view('addons/basic_addons', $data);
		}
	}
	
	
}

/* End of controller file */