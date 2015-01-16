<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls login for the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */

class Account extends CI_Controller 
{
	
	#The login page
	public function login()
	{
		$data = filter_forwarded_data($this);
		//print_r($_POST);
		$this->load->view('account/login', $data);
	}
	
	
}

/* End of controller file */