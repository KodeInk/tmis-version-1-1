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
	
	
	
	
	
	# Send email message
	function send_email_message($userId, $messageDetails)
	{
		$isSent = false;
		
		# 1. If email address is not provided, then fetch it using the user id
		if(empty($messageDetails['emailaddress'])) $email = $this->query_reader->get_row_as_array('get_user_email', array('user_id'=>$userId));
		$emailTo = !empty($messageDetails['emailaddress'])? $messageDetails['emailaddress']: (!empty($email['emailaddress'])? $email['emailaddress']: "");
		
		if(!empty($emailTo))
		{
			# 2. Fetch the message template and populate the necessary details
			$template = $this->get_template_by_code($messageDetails['code']);
			$emailMessage = $this->populate_template($template, $messageDetails);
			# 3. Send message
			if(!empty($emailMessage['details']))
			{
				$this->email->from($messageDetails['email_from'], $messageDetails['from_name']);
				$this->email->reply_to($messageDetails['email_from'], $messageDetails['from_name']);
				if($template['copy_admin'] == 'Y') $this->email->bcc(SITE_ADMIN_MAIL);
			
				$this->email->subject($emailMessage['subject']);
				$this->email->message($emailMessage['details']);
			
				if(isset($messageDetails['fileurl']) && trim($messageDetails['fileurl']) != '')
				{
					$this->email->attach($messageDetails['fileurl']);
				}
				#Use this line to test sending of email without actually sending it
				#echo $this->email->print_debugger();
		
				$isSent = $this->email->send();
			}
		}
		
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
			
	
	
	# Get a template of the message given its code
	function get_template_by_code($code)
	{
		return $this->query_reader->get_row_as_array('get_message_template', array('message_type'=>$code));
	}	
				
	
	
	# Populate the template to generate the actual message
	function populate_template($template, $values=array())
	{
		$message = array();
		if(!empty($template['subject']) && !empty($template['details']))
		{
			# Order keys by length - longest first
			array_multisort(array_map('strlen', array_keys($values)), SORT_DESC, $values);
			
			# go through all passed values and replace where they appear in the template text
			foreach($values AS $key=>$value)
			{
				$template['subject'] = str_replace('_'.strtoupper($key).'_', html_entity_decode($value, ENT_QUOTES), $template['subject']);
				$template['details'] = str_replace('_'.strtoupper($key).'_', html_entity_decode($value, ENT_QUOTES), $template['details']);
			}
			$message = array('subject'=>$template['subject'], 'details'=>$template['details']);
		}
		
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