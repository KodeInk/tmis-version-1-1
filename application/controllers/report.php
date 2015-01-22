<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing reports on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Report extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: View log data
	function logs()
	{
		$data = filter_forwarded_data($this);
		$instructions['type'] = array('user'=>'view_user_log', 'system'=>'view_system_log');
		check_access($this, get_access_code($data, $instructions));
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View users
	function users()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_users');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: View schools
	function schools()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_schools');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View teachers
	function teachers()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_teachers');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: View job applications
	function job_applications()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_job_applications');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: View jobs
	function jobs()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_jobs');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: View retirements
	function retirements()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_retirements');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
}

/* End of controller file */