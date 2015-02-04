<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing retirement pages on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Retirement extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	# STUB: View retirement application list
	function lists()
	{
		$data = filter_forwarded_data($this);
		if(empty($data['action'])) $data['action'] = 'view';
		$instructions['action'] = array('view'=>'view_retirement_applications', 'report'=>'view_retirements');
		check_access($this, get_access_code($data, $instructions));
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Cancel a retirement application
	function cancel()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'cancel_retirement_application');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Verify a retirement application
	function verify()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'verify_retirement_application');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Apply for retirement
	function apply()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'apply_to_retire');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
}

/* End of controller file */