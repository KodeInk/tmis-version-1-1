<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing data on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Job extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: View list of job confirmation applications
	function confirmation_applications()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_job_confirmation_applications');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Issue a job confirmation letter
	function confirmation_letter()
	{
		$data = filter_forwarded_data($this);
		$instructions['action'] = array('issue'=>'issue_job_confirmation_letter', 'verify'=>'verify_job_confirmation_letter');
		check_access($this, get_access_code($data, $instructions));
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Post to a new job
	function post()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'post_to_new_position');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Request job confirmation
	function request_confirmation()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'request_job_confirmation');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Apply for job promotion
	function apply_for_promotion()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'apply_for_promotion');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Current job
	function view_current()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_current_job');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Previous job
	function view_previous()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_previous_jobs');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
}

/* End of controller file */