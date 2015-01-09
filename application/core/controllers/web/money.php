<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls showing information related to a user network.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 01/16/2014
 */
class Money extends CI_Controller 
{
	#Function to show the money home
	public function show_money_home()
	{
		access_control($this);
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/money/money_home', $data);
	}
	
	
	public function transfer_funds()
	{
		$data = filter_forwarded_data($this);
		$data['action'] = !empty($data['a'])? decrypt_value($data['a']): '';
		
		$this->load->view('web/money/transfer_funds', $data);
	}
	
	
}

/* End of controller file */