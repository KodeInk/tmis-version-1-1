<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls login access for the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */

class Account extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('validator');
	}
	
	
	#The login page
	public function login()
	{
		$data = filter_forwarded_data($this);
		$this->load->model('permission');
		
		if(!empty($_POST))
		{
			#Is form verified?
			if($this->input->post('verified'))
			{
				#Is user verified?
				$results = $this->validator->is_valid_account(array('login_name'=>trim($this->input->post('loginusername')), 'login_password'=>trim($this->input->post('loginpassword')) ));
				if($results['boolean'])
				{
					#If so, assign permissions and redirect to their respective dashboard
					$this->native_session->set('permissions', $this->permission->get_user_permission_list($results['user_id']));
					#Log sign-in event
					$this->logger->add_event(array('log_code'=>'user_login', 'result'=>'success', 'details'=>"username=".trim($this->input->post('loginusername')) ));
					
					# Go to the user dashboard
					redirect(get_user_dashboard($this, $results['user_id']));
				}
				# Invalid credentials
				else
				{
					$this->logger->add_event(array('log_code'=>'user_login', 'result'=>'fail', 'details'=>"username=".trim($this->input->post('loginusername')) ));
					$data['msg'] = "WARNING: Invalid login details.";
				}
			}
			else
			{
				$data['msg'] = "ERROR: Your submission could not be verified.";
			}
		}
		# If already logged in, log out of current session
		else if($this->native_session->get('user_id'))
		{
			$this->logout($this->native_session->get('user_id'));
			$data['msg'] = "You have been logged out.";
		}
		
		$this->load->view('account/login', $data);
	}
		
		
	
	# Log out a user
	function logout($userId)
	{
		$isLoggedOut = false;
		
		#Log sign-out event
		$userId = $this->native_session->get('user_id')? $this->native_session->get('user_id'): "";
		$email = $this->native_session->get('email_address')? $this->native_session->get('email_address'): "";
		$this->logger->add_event(array('log_code'=>'user_logout', 'result'=>'success', 'details'=>"userid=".$userId."|email=".$email ));
					
		#Remove any set session variables
		$this->native_session->delete_all();
		
		# Set appropriate message - reason for log out.
		$data['msg'] = $this->native_session->get('msg')? get_session_msg($this): "You have been logged out.";
		$this->load->view('account/login', $data);
	}
	
}

/* End of controller file */