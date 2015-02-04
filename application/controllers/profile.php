<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing profile pages on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Profile extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: Update teacher profile
	function teacher_data()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'update_my_teacher_profile');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	# Update user profile
	function user_data()
	{
		$data = filter_forwarded_data($this);
		# Log out the user if the session is not available
		if($this->native_session->get('__user_id'))
		{
			if(!empty($_POST))
			{
				# Process the signature file if one has been uploaded
				if(file_exists($_FILES['signature__fileurl']['tmp_name']))
				{
					$this->load->model('_document');
					$upload = $this->_document->upload($_FILES['signature__fileurl'], array('type'=>'image'));
					
					$_POST['signature__fileurl'] = $upload['file'];
				}
				
				$data['result'] = $this->_user->update($this->native_session->get('__user_id'), $this->input->post(NULL, TRUE));
				$data['msg'] = $data['result']['boolean'] && empty($data['result']['msg'])? "Please check your email for a confirmation code to proceed.": $data['result']['msg'];
			}
			
			$this->_user->populate_session($this->native_session->get('__user_id'),true);
			$this->load->view('profile/user_data', $data); 
		}
		else
		{
			redirect(base_url()."account/logout");
		}
	}
	
	
	
	
}

/* End of controller file */