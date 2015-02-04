<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing vacancy pages on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Vacancy extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('_vacancy');
	}
	
	
	#STUB: View relevant jobs for the given user
	function relevant_list()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_relevant_jobs');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: shortlist a user for a given vacancy
	function shortlist()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'set_vacancy_shortlist');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Apply for a job
	function apply()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'apply_for_job');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: View my saved jobs
	function saved()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_my_saved_jobs');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View status of my saved jobs
	function status()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_job_application_status');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#Verify the vacancy before proceeding to the next stage
	function verify()
	{
		$data = filter_forwarded_data($this);
		if(!empty($_POST))
		{
			# Approve or reject a vacancy
			$result = $this->_vacancy->verify($_POST);
			
			$actionPart = current(explode("_", $_POST['action']));
			$actions = array('approve'=>'approved', 'reject'=>'rejected', 'archive'=>'archived', 'restore'=>'restored', 'publish'=>'published');
			$actionWord = !empty($actions[$actionPart])? $actions[$actionPart]: 'made';
			$this->native_session->set('msg', ($result['boolean']? "The vacancy has been ".$actionWord: (!empty($result['msg'])? $result['msg']: "ERROR: The vacancy could not be ".$actionWord) ));
		}
		else
		{
			# Get list type
			$data['list_type'] = current(explode("_", $data['action']));
			$data['area'] = 'verify_vacancy';
			$this->load->view('addons/basic_addons', $data);
		}
	}
	
	# Add a new job
	function add()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'add_new_job');
		# Remove any session variables if still in the session.
		$this->_vacancy->clear_session();
		
		# If the user has posted the vacancy details
		if(!empty($_POST))
		{
			# Editing vacancy
			if($this->input->post('vacancyid'))
			{
				$data['result'] = $this->_vacancy->update($this->input->post('vacancyid'), $this->input->post(NULL, TRUE));
			}
			# New vacancy
			else 
			{
				$data['result'] = $this->_vacancy->add_new($this->input->post(NULL, TRUE));
			}
			
			$data['vacancy_id'] = !empty($data['result']['id'])? $data['result']['id']: '';
			$data['msg'] = $data['result']['boolean'] && empty($data['result']['msg'])? "Your job details have been saved.": $data['result']['msg'];
			# Redirect to appropriate page if successful
			$this->native_session->set('msg', $data['msg']);
			if($data['result']['boolean'] && $this->input->post('forwardurl')) redirect(base_url().$this->input->post('forwardurl'));
		}
		
		#If editing, load the id details into the session for the first time 
		if(!empty($data['id']) && empty($_POST)) $this->_vacancy->populate_session($data['id']);
		$this->load->view('vacancy/new_vacancy', $data); 
	}
	
	
	
	# View a job list
	function lists()
	{
		$data = filter_forwarded_data($this);
		$instructions['action'] = array('publish'=>'publish_job_notices', 'verify'=>'verify_job_notices', 'archive'=>'archive_job_notices', 'report'=>'view_jobs');
		check_access($this, get_access_code($data, $instructions));
		
		$data['list'] = $this->_vacancy->get_list($data);
		$this->load->view('vacancy/list_vacancies', $data); 
	}
	
	
	
	# View a job's details
	function details()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['id']))
		{
			$data['details'] = $this->_vacancy->get_details($data['id']);
		}
		else
		{
			$data['msg'] = "ERROR: We could not find the vacancy details.";
		}
		
		$this->load->view('vacancy/details', $data); 
	}
	
}

/* End of controller file */