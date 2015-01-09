<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls access to all cron jobs through the UI.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 12/04/2013
 */
class Jobs extends CI_Controller 
{
	
	#Show the cron jobs dashboard
	public function dashboard()
	{
		$data = filter_forwarded_data($this);
		
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('cron/jobs/jobs_dashboard', $data);
	}
	
	
	
	
}


/* End of controller file */