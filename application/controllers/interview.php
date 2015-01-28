<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing interview pages on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Interview extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: Set interview date
	function set_date()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'set_interview_date');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Cancel an interview
	function cancel()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'cancel_interview');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Submit recommendation on an interview
	function submit_recommendation()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'submit_recommendation_for_job');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View recommendations on an interview
	function view_recommendations()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_recommendation_list');
		
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Add interview results
	function add_results()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'add_interview_results');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View interview results
	function view_results()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_interview_results');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
}

/* End of controller file */