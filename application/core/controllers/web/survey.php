<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls showing information related to a survey.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 01/16/2014
 */
class Survey extends CI_Controller 
{
	#Function to show a store survey
	public function show_store_survey()
	{
		$data = filter_forwarded_data($this);
		
		#Which step to show
		$data['step'] = !empty($data['s'])? decrypt_value($data['s'])+1: '1';
		$this->load->view('web/survey/store_survey', $data);
	}
	
	
	
	
	
}

/* End of controller file */