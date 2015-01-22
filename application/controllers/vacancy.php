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
	
	
	# Add a new job
	function add()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'add_new_job');
		
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
			$this->native_session->set('msg', $data['result']['msg']);
			if($data['result']['boolean'] && $this->input->post('forwardurl')) redirect(base_url().$this->input->post('forwardurl'));
		}
		
		#If editing, load the id for the first time
		if(!empty($data['id'])) $data['vacancy_id'] = decrypt_value($data['id']);
		
		$this->load->view('vacancy/new_vacancy', $data); 
	}
	
	
	
	# View a job list
	function lists()
	{
		$data = filter_forwarded_data($this);
		$instructions['action'] = array('publish'=>'publish_job_notices', 'verify'=>'verify_job_notices', 'archive'=>'archive_job_notices');
		check_access($this, get_access_code($data, $instructions));
		
		$data['list'] = $this->_vacancy->get_list($data);
		$this->load->view('vacancy/list_vacancies', $data); 
	}
	
	
}

/* End of controller file */