<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing data on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Data extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: View list of schools
	function schools()
	{
		$data = filter_forwarded_data($this);
		$instructions['action'] = array('view'=>'view_school_data_changes', 'verify'=>'verify_school_data_updates');
		check_access($this, get_access_code($data, $instructions));
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View list of teachers
	function teachers()
	{
		$data = filter_forwarded_data($this);
		$instructions['action'] = array('view'=>'view_teacher_data_changes', 'verify'=>'verify_teacher_data_changes');
		check_access($this, get_access_code($data, $instructions));
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: View secrecy applications
	function secrecy_applications()
	{
		$data = filter_forwarded_data($this);
		$instructions['action'] = array('view'=>'view_data_secrecy_applications', 'verify'=>'verify_data_secrecy_applications');
		check_access($this, get_access_code($data, $instructions));
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View teacher census data
	function teacher_census()
	{
		$data = filter_forwarded_data($this);
		$instructions['action'] = array('view'=>'view_teacher_census_report', 'verify'=>'verify_teacher_census_submissions');
		check_access($this, get_access_code($data, $instructions));
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Add a new teacher
	function new_teacher()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'add_new_teacher');
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Add a new teacher census
	function new_teacher_census()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'submit_teacher_census_data');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Add a new school
	function new_school()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'add_new_school');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Apply for secrecy
	function apply_for_secrecy()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'request_data_secrecy');
		
		
		$this->load->view('page/under_construction', $data); 
	}
}

/* End of controller file */