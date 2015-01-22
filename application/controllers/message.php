<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing messages on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/20/2015
 */

class Message extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
	}
	
	
	#STUB: Send new system message
	function send_new_system()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'send_system_message');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: Send new email message
	function send_new_email()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'send_email_message');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: Send new sms message
	function send_new_sms()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'send_sms_message');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	
	#STUB: View message inbox
	function inbox()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_message_inbox');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: View message archive
	function archive()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_archived_messages');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
	
	#STUB: View sent messages
	function sent()
	{
		$data = filter_forwarded_data($this);
		check_access($this, 'view_sent_messages');
		
		
		$this->load->view('page/under_construction', $data); 
	}
	
}

/* End of controller file */