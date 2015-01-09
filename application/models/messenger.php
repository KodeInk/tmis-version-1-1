<?php

/**
 * This class manages formatting and sending of messages.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
 
class Messenger extends CI_Model {
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->library('email');
    }
	
	
	
	#function to get the recipients of a given message
	function get_message_recipients($msgId)
	{
		$recipients = array();
		$receivedBy = $this->db->query($this->Query_reader->get_query_by_code('get_recipients_for_msg', array('messageid'=>$msgId )));
		$recipientsRows = $receivedBy->result_array();
		foreach($recipientsRows AS $row)
		{
			array_push($recipients, $row['userid']);
		}
			
		return $recipients;
	}
	
	
	
	
	# STUB: Send email message
	function send_email_message($userId, $messageDetails)
	{
		$isSent = false;
		
		return $isSent;
	}
		
	
	
	# STUB: Send an SMS to the specified user
	function send_sms_message($userId, $messageDetails)
	{
		$isSent = false;
		
		
		return $isSent;
	}	
			
	
	
	# STUB: Send a system message to the specified user
	function send_system_message($userId, $messageDetails)
	{
		$isSent = false;
		
		
		return $isSent;
	}	
			
	
	
	# STUB: Get a template of the message given its code
	function get_template_by_code($code)
	{
		$template = "";
		
		
		return $template;
	}	
				
	
	
	# STUB: Populate the template to generate the actual message
	function populate_template($template, $values=array())
	{
		$message = "";
		
		
		return $message;
	}
					
	
	
	# STUB: Archive the message so that it can no longer be viewed in the active message list
	function archive_message($template, $values=array())
	{
		$message = "";
		
		
		return $message;
	}
						
	
	
	# STUB: Get list of messages for the given user a list parameters
	function get_message_list($userId, $listParameters)
	{
		$list = array();
		
		
		return $list;
	}
	
	




}

?>