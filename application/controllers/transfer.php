<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing transfer pages on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Transfer extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: View transfer lists
	function lists()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_transfer_applications');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Cancel a transfer application
	function cancel()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'cancel_transfer_application');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Verify transfer application
	function verify()
	{
		$data = filter_forwarded_data($this);
		$instructions['level'] = array('institution'=>'verify_transfer_at_institution_level', 'county'=>'verify_transfer_at_county_level', 'ministry'=>'verify_transfer_at_ministry_level');
		check_access($this, get_access_code($data, $instructions));
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Submit transfer PCA
	function submit_pca()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'submit_transfer_pca');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Apply for transfer
	function apply()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'apply_for_transfer');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
}

/* End of controller file */