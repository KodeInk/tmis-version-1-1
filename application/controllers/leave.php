<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing leave pages on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Leave extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: View leave lists
	function lists()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_leave_applications');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Cancel a leave application
	function cancel()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'cancel_leave_application');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Verify leave application
	function verify()
	{
		$data = filter_forwarded_data($this);
		$instructions['level'] = array('county'=>'verify_leave_at_county_level', 'ministry'=>'verify_leave_at_ministry_level');
		check_access($this, get_access_code($data, $instructions));
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Send letter in response to leave application
	function send_letter()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'prepare_leave_verification_letter');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Apply for leave
	function apply()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'apply_for_leave');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
}

/* End of controller file */