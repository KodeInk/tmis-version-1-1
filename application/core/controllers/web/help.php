<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls showing user help.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 01/07/2013
 */
class Help extends CI_Controller 
{
	#Function to show frequently asked questions
	public function faqs()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/help/faqs', $data);
	}
	
	
	#Function to show the intro to the system
	public function intro()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['s']))
		{
			$data['step'] = decrypt_value($data['s']);
			
			if($data['step'] == 4)
			{
				redirect(base_url()."web/account/normal_dashboard");
			}
		}
		
		$this->load->view('web/help/intro', $data);
	}
	
	
	
}

/* End of controller file */