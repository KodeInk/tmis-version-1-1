<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing teachers on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/30/2015
 */

class Teacher extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('_teacher');
		$this->load->model('_person');
	}
	
	
	
	
	# Add a new teacher
	function add()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'add_new_teacher');
		# Remove any session variables if still in the session.
		if(empty($_POST) && empty($data['edit']) && !(!empty($data['urlaction']) && $data['urlaction'] == 'submit')) $this->_teacher->clear_session();
		
		# If user has posted the form for processing
		if(!empty($_POST))
		{
			# 1. Save or add the data to session?
			if($this->input->post('preview') || isset($_POST['preview'])) 
			{
				$response = $this->_teacher->add_to_session($this->input->post(NULL, TRUE));
				if($response['boolean']) $data['preview'] = "Y";
				else $data['msg'] = $response['msg'];
			}
			else 
			{
				if($this->input->post('userid'))
				{
					$result = $this->_teacher->update($this->input->post(NULL, TRUE));
					if($result['boolean']) 
					{
						$this->_person->add_education_and_qualifications($result['person_id'], $this->input->post(NULL, TRUE));
						$data['forward'] = base_url().'teacher/lists'.(!empty($action)? '/action/'.$action: '/action/view');
						$data['result'] = $result;
					}
				}
				else
				{
					$result = $this->_teacher->add_new($this->input->post(NULL, TRUE));
					if($result['boolean']) 
					{
						$this->_person->add_education_and_qualifications($result['person_id'], $this->input->post(NULL, TRUE));
						$this->_person->submit_application($result['person_id'], array('user_id'=>$result['id'], 'emailaddress'=>$this->native_session->get('emailaddress'), 'first_name'=>$this->native_session->get('firstname') ));
					}
				}
				
				
			}
			
			# 2. Show the appropriate message
			if(!empty($result)) $this->native_session->set('msg', (!empty($result['msg'])? $result['msg']: "The teacher data has been submitted for approval."));
			
			# 3. Redirect if saved successfully
			if(!empty($result['boolean']) && $result['boolean'] && empty($data['id'])) 
			{
				$this->_teacher->clear_session();
				redirect(base_url().'teacher/lists'.(!empty($action)? '/action/'.$action: '/action/view'));
			}
		}
		
		#If editing - and for the first time, load the id details into the session 
		if(!empty($data['id']) && empty($data['edit']) && empty($_POST)) $this->_teacher->populate_session($data['id']);
		if(!empty($data['action']) && $data['action'] == 'view') $data['preview'] = "Y";
		
		# This helps differentiate source of command for shared functions with the teacher's registration functionality
		$this->native_session->set('is_admin_adding_teacher', 'Y');
		
		$this->load->view('teacher/new_teacher', $data); 
	}
	
	
	
	
	# Add the teacher education info to the session
	function add_education()
	{
		$data = filter_forwarded_data($this);
		$data['response'] = $this->_person->add_education('', $this->input->post(NULL, TRUE));
		$data['area'] = "education_list";
		$this->load->view('addons/basic_addons', $data); 
	}
	
	
	
	
	# Add the teacher subject info to the session
	function add_subject()
	{
		$data = filter_forwarded_data($this);
		$data['response'] = $this->_person->add_subject_taught('', $this->input->post(NULL, TRUE));
		$data['area'] = "subject_list";
		$this->load->view('addons/basic_addons', $data); 
	}
	
	
	
	
	# View a teacher list
	function lists()
	{
		$data = filter_forwarded_data($this);
		if(empty($data['action'])) $data['action'] = 'report';
		$instructions['action'] = array('view'=>'view_teacher_data_changes', 'verify' => 'verify_teacher_application_at_hr_level', 'approve'=>'verify_teacher_application_at_instructor_level', 'report'=>'view_teachers');
		check_access($this, get_access_code($data, $instructions));
		
		$data['list'] = $this->_teacher->get_list($data);
		#Make sure the approver has a signature on file if they are going to generate a certificate
		if(!empty($data['list']) && !$this->native_session->get('__signature') && !empty($data['action']) && $data['action']=='approve')
		{
			 $data['msg'] = "WARNING: You need to <a href='".base_url()."profile/user_data'>upload a signature</a> to approve teacher certification.";
			 $this->native_session->set('__nosignature','Y');
		}
		$this->load->view('teacher/list_teachers', $data); 
	}
	
	
	
	
	# Cancel a teacher addition
	function cancel()
	{
		$data = filter_forwarded_data($this);
		
		$this->_teacher->clear_session();
		redirect(base_url().'teacher/lists'.(!empty($data['action'])? '/action/'.$data['action']: ''));
	}
	
	
	# Verify the teacher (all actions: approve, reject, etc)
	function verify()
	{
		$data = filter_forwarded_data($this);
		if(!empty($_POST))
		{
			# Approve or reject a teacher
			$result = $this->_teacher->verify($_POST);
			
			$actionPart = current(explode("_", $_POST['action']));
			$actions = array('approve'=>'approved', 'reject'=>'rejected', 'archive'=>'archived', 'restore'=>'restored');
			$actionWord = !empty($actions[$actionPart])? $actions[$actionPart]: 'made';
			$this->native_session->set('msg', ($result['boolean']? "The teacher has been ".$actionWord: (!empty($result['msg'])? $result['msg']: "ERROR: The teacher could not be ".$actionWord) ));
		}
		else
		{
			# Get list type
			$data['list_type'] = current(explode("_", $data['action']));
			$data['area'] = 'verify_teacher';
			$this->load->view('addons/basic_addons', $data);
		}
	}
	
	
}

/* End of controller file */