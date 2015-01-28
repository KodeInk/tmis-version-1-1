<?php

/**
 * This class manages formatting and sending of messages.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
 
class _messenger extends CI_Model {
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->library('email');
    }
	
	
	
	# Notify a user by sending a message to their email, sms and in the system
	# $required - makes sure that the sending formats required were successful, although the other formats are still attempted
	function send($userId, $message, $required=array('system'))
	{
		$results['email'] = $this->send_email_message($userId, $message);
		$results['sms'] = $this->send_sms_message($userId, $message);
		$results['system'] = $this->send_system_message($userId, $message);
		
		#If the sending format required passed then return the result as successful even if the others may have failed
		$considered = array();
		foreach($results AS $key=>$value) if(in_array($key, $required)) array_push($considered, $value);
		
		return get_decision($considered);
	}
	
	
	
	# Send email message
	function send_email_message($userId, $messageDetails)
	{
		$isSent = false;
		
		# 1. If email address is not provided, then fetch it using the user id
		if(!empty($userId))
		{
			$user = $this->_query_reader->get_row_as_array('get_user_profile', array('user_id'=>$userId));
			if(!empty($user))
			{
				$emailaddress = $user['email_address'];
				$messageDetails['firstname'] = !empty($messageDetails['firstname'])? $messageDetails['firstname']: $user['first_name'];
			}
		}
		
		$emailTo = !empty($messageDetails['emailaddress'])? $messageDetails['emailaddress']: (!empty($emailaddress)? $emailaddress: "");
		
		if(!empty($emailTo))
		{
			# 2. Fetch the message template and populate the necessary details
			$template = $this->get_template_by_code($messageDetails['code']);
			$emailMessage = $this->populate_template($template, $messageDetails);
			# 3. Send message
			if(!empty($emailMessage['details']))
			{
				$this->email->to($emailTo);
				$this->email->from($messageDetails['email_from'], $messageDetails['from_name']);
				$this->email->reply_to($messageDetails['email_from'], $messageDetails['from_name']);
				if($template['copy_admin'] == 'Y') $this->email->bcc(SITE_ADMIN_MAIL);
			
				$this->email->subject($emailMessage['subject']);
				$this->email->message($emailMessage['details']);
			
				if(isset($messageDetails['fileurl']) && trim($messageDetails['fileurl']) != '')
				{
					$this->email->attach($messageDetails['fileurl']);
				}
				
				# Use this line to test sending of email without actually sending it
				# echo $this->email->print_debugger();
		
				$isSent = $this->email->send();
				
				#Record messsage exchange if sent
				if($isSent) $result = $this->_query_reader->run('record_message_exchange', array('code'=>$messageDetails['code'], 'send_format'=>'email', 'details'=>$emailMessage['details'], 'subject'=>$emailMessage['subject'], 'recipient_id'=>$userId, 'sender'=>$messageDetails['email_from']));
			}
		}
		
		return $isSent;
	}
	
	
	
	# Send an SMS to the specified user
	function send_sms_message($userId, $messageDetails)
	{
		$isSent = false;
		if(!empty($userId))
		{
			$user = $this->_query_reader->get_row_as_array('get_user_profile', array('user_id'=>$userId));
			if(!empty($user['telephone']))
			{
				$this->load->model('_carrier');
				
				$carrierEmailDomain = $this->_carrier->get_email_domain($user['telephone']);
				if(!empty($carrierEmailDomain))
				{
					$template = $this->get_template_by_code($messageDetails['code']);
					$smsMessage = $this->populate_template($template, $messageDetails);
				
					$this->email->to($user['telephone'].'@'.$carrierEmailDomain);
					$this->email->from($messageDetails['email_from'], $messageDetails['from_name']);
					$this->email->reply_to($messageDetails['email_from'], $messageDetails['from_name']);
					if($template['copy_admin'] == 'Y') $this->email->bcc(SITE_ADMIN_MAIL);
			
					$this->email->subject($smsMessage['subject']);
					$this->email->message($smsMessage['sms']);
				
					$isSent = $this->email->send();
					
					#Record messsage exchange if sent
					if($isSent) $result = $this->_query_reader->run('record_message_exchange', array('code'=>$messageDetails['code'], 'send_format'=>'sms', 'details'=>$smsMessage['sms'], 'subject'=>$smsMessage['subject'], 'recipient_id'=>$userId, 'sender'=>$messageDetails['email_from']));
				}
			}
		}
		
		return $isSent;
	}	
			
	
	
	# Send a system message to the specified user
	function send_system_message($userId, $messageDetails)
	{
		# 1. Fetch the message template and populate the necessary details
		$template = $this->get_template_by_code($messageDetails['code']);
		$systemMessage = $this->populate_template($template, $messageDetails);
		
		# 2. Record the message exchange to be accessed by the recipient in their inbox
		return $this->_query_reader->run('record_message_exchange', array('code'=>$messageDetails['code'], 'send_format'=>'system', 'details'=>$systemMessage['details'], 'subject'=>$systemMessage['subject'], 'recipient_id'=>$userId, 'sender'=>$messageDetails['email_from']));
	}	
			
	
	
	# Get a template of the message given its code
	function get_template_by_code($code)
	{
		return $this->_query_reader->get_row_as_array('get_message_template', array('message_type'=>$code));
	}	
				
	
	
	# Populate the template to generate the actual message
	function populate_template($template, $values=array(), $type='email')
	{
		# Order keys by length - longest first
		array_multisort(array_map('strlen', array_keys($values)), SORT_DESC, $values);
		
		# SMS message
		if($type == 'sms' && !empty($template['sms']))
		{
			foreach($values AS $key=>$value)
			{
				$template['subject'] = str_replace('_'.strtoupper($key).'_', html_entity_decode($value, ENT_QUOTES), $template['subject']);
				$template['sms'] = str_replace('_'.strtoupper($key).'_', html_entity_decode($value, ENT_QUOTES), $template['sms']);
			}
		}
		
		# Email or system message
		else if(in_array($type, array('email','system')) && !empty($template['subject']) && !empty($template['details']))
		{
			# Go through all passed values and replace where they appear in the template text
			foreach($values AS $key=>$value)
			{
				$template['subject'] = str_replace('_'.strtoupper($key).'_', html_entity_decode($value, ENT_QUOTES), $template['subject']);
				$template['details'] = str_replace('_'.strtoupper($key).'_', html_entity_decode($value, ENT_QUOTES), $template['details']);
			}
		}
		
		return $template;
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