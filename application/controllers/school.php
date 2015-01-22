<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing schools on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class School extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: View current school where this teacher works
	function view_current()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_current_school');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View previous schools where the teacher has worked before
	function view_previous()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_previous_schools');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
}

/* End of controller file */