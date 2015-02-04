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
				$messageDetails['first_name'] = !empty($messageDetails['firstname'])? $messageDetails['firstname']: $user['first_name'];
				$messageDetails['login_link'] = !empty($messageDetails['loginlink'])? $messageDetails['loginlink']: trim(base_url(), '/');
			}
		}
		
		$messageDetails['email_from'] = !empty($messageDetails['emailfrom'])? $messageDetails['emailfrom']: $this->native_session->get('__email_address');
		$messageDetails['from_name'] = !empty($messageDetails['fromname'])? $messageDetails['fromname']: $this->native_session->get('__last_name').' '.$this->native_session->get('__first_name');
					
		$emailTo = !empty($messageDetails['emailaddress'])? $messageDetails['emailaddress']: (!empty($emailaddress)? $emailaddress: "");
		
		if(!empty($emailTo))
		{
			# 2. Fetch the message template and populate the necessary details
			if(!empty($messageDetails['code']))
			{
				$template = $this->get_template_by_code($messageDetails['code']);
				$emailMessage = $this->populate_template($template, $messageDetails);
				$messageDetails['subject'] = $emailMessage['subject'];
				$messageDetails['details'] = $emailMessage['details'];
			}
			
			# 3. Send message
			if(!empty($emailMessage['details']))
			{
				$this->email->to($emailTo);
				$this->email->from($messageDetails['email_from'], $messageDetails['from_name']);
				$this->email->reply_to($messageDetails['email_from'], $messageDetails['from_name']);
				if(!empty($messageDetails['cc'])) $this->email->cc($messageDetails['cc']);
				if($template['copy_admin'] == 'Y') $this->email->bcc(SITE_ADMIN_MAIL);
			
				$this->email->subject($messageDetails['subject']);
				$this->email->message($messageDetails['details']);
			
				if(isset($messageDetails['fileurl']) && trim($messageDetails['fileurl']) != '')
				{
					$this->email->attach($messageDetails['fileurl']);
				}
				
				# Use this line to test sending of email without actually sending it
				# echo $this->email->print_debugger();
		
				$isSent = $this->email->send();
				
				#Record messsage exchange if sent
				if($isSent && !empty($userId)) $result = $this->_query_reader->run('record_message_exchange', array('code'=>(!empty($messageDetails['code'])? $messageDetails['code']: 'user_defined_message'), 'send_format'=>'log_email', 'attachment'=>(!empty($messageDetails['fileurl'])? $messageDetails['fileurl']: ''), 'details'=>$messageDetails['details'], 'subject'=>$messageDetails['subject'], 'recipient_id'=>$userId, 'sender'=>$messageDetails['email_from']));
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
					$messageDetails['email_from'] = !empty($messageDetails['emailfrom'])? $messageDetails['emailfrom']: $this->native_session->get('__email_address');
					$messageDetails['from_name'] = !empty($messageDetails['fromname'])? $messageDetails['fromname']: $this->native_session->get('__last_name').' '.$this->native_session->get('__first_name');
					
					#Populate the template if given the code
					if(!empty($messageDetails['code']))
					{
						$template = $this->get_template_by_code($messageDetails['code']);
						$smsMessage = $this->populate_template($template, $messageDetails);
						$messageDetails['subject'] = $smsMessage['subject'];
						$messageDetails['sms'] = $smsMessage['sms'];
					}
					
					$this->email->to($user['telephone'].'@'.$carrierEmailDomain);
					$this->email->from($messageDetails['email_from'], $messageDetails['from_name']);
					$this->email->reply_to($messageDetails['email_from'], $messageDetails['from_name']);
					if(!empty($template['copy_admin']) && $template['copy_admin'] == 'Y') $this->email->bcc(SITE_ADMIN_MAIL);
			
					$this->email->subject($messageDetails['subject']);
					$this->email->message($messageDetails['sms']);
				
					$isSent = $this->email->send();
					
					#Record messsage exchange if sent
					if($isSent && !empty($userId)) $result = $this->_query_reader->run('record_message_exchange', array('code'=>(!empty($messageDetails['code'])? $messageDetails['code']: 'user_defined_message'), 'send_format'=>'log_sms', 'details'=>$messageDetails['sms'], 'subject'=>$messageDetails['subject'], 'recipient_id'=>$userId, 'sender'=>$messageDetails['email_from']));
				}
			}
		}
		
		return $isSent;
	}	
			
	
	
	# Send a system message to the specified user
	function send_system_message($userId, $messageDetails)
	{
		if(!empty($userId))
		{
			$user = $this->_query_reader->get_row_as_array('get_user_profile', array('user_id'=>$userId));
			$messageDetails['first_name'] = !empty($messageDetails['firstname'])? $messageDetails['firstname']: $user['first_name'];
			$messageDetails['login_link'] = !empty($messageDetails['loginlink'])? $messageDetails['loginlink']: trim(base_url(), '/');
		}
		$messageDetails['email_from'] = !empty($messageDetails['emailfrom'])? $messageDetails['emailfrom']: $this->native_session->get('__email_address');
		$messageDetails['from_name'] = !empty($messageDetails['fromname'])? $messageDetails['fromname']: $this->native_session->get('__last_name').' '.$this->native_session->get('__first_name');
		
		
		# 1. Fetch the message template and populate the necessary details
		if(!empty($messageDetails['code']))
		{
			$template = $this->get_template_by_code($messageDetails['code']);
			$systemMessage = $this->populate_template($template, $messageDetails);
			$messageDetails['subject'] = $systemMessage['subject'];
			$messageDetails['details'] = $systemMessage['details'];
			
			if($template['copy_admin'] == 'Y') $this->_query_reader->run('record_message_exchange', array('code'=>(!empty($messageDetails['code'])? $messageDetails['code']: 'user_defined_message'), 'send_format'=>'system', 'details'=>$messageDetails['details'], 'attachment'=>(!empty($messageDetails['fileurl'])? $messageDetails['fileurl']: ''), 'subject'=>$messageDetails['subject'], 'recipient_id'=>implode("','", $this->get_admin_users()), 'sender'=>$messageDetails['email_from']));
		}
		
		# 2. Record the message exchange to be accessed by the recipient in their inbox
		return $this->_query_reader->run('record_message_exchange', array('code'=>(!empty($messageDetails['code'])? $messageDetails['code']: 'user_defined_message'), 'send_format'=>'system', 'details'=>$messageDetails['details'], 'attachment'=>(!empty($messageDetails['fileurl'])? $messageDetails['fileurl']: ''), 'subject'=>$messageDetails['subject'], 'recipient_id'=>$userId, 'sender'=>$messageDetails['email_from']));
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
	
	
	
	
	# Populate the session if the user is responding
	function populate_session($messageId)
	{
		$message = $this->_query_reader->get_row_as_array('get_message_by_id', array('message_id'=>$messageId));
		
		if(!empty($message))
		{
			$msgSeparator = '<br><br><br><br>-------------------------------<br>Received '.date('d-M-Y h:i:sA T').'<br><br>';
			$this->native_session->set('recipientname__users', $message['sender_name']);
			$this->native_session->set('recipientid', $message['sender_id']);
			$this->native_session->set('subject', (strtolower(substr($message['subject'], 0,3)) != 're:'? 'Re: ': '').$message['subject']);
			$this->native_session->set('message', ($message['send_format'] != 'sms'? $msgSeparator: '').$message['details']);
		}
	}
	


	# Clear a message session profile
	function clear_session()
	{
		$fields = array('recipientname__users'=>'', 'recipientid'=>'', 'subject'=>'', 'message'=>'');
		$this->native_session->delete_all($fields);
	}
						
	
	
	# Get list of messages for the given user a list parameters
	function get_list($instructions)
	{
		$searchString = " AND send_format IN ('system','sms','email') ";
		# If a search phrase is sent in the instructions
		if(!empty($instructions['searchstring']))
		{
			$searchString .= " AND ".$instructions['searchstring'];
		}
		
		$count = !empty($instructions['pagecount'])? $instructions['pagecount']: NUM_OF_ROWS_PER_PAGE;
		$start = !empty($instructions['page'])? ($instructions['page']-1)*$count: 0;
		
		if(!empty($instructions['action']) && $instructions['action'] == 'sent')
		{
			return $this->_query_reader->get_list('get_sent_message_list', array('sender_email'=>$this->native_session->get('__email_address'), 'search_query'=>$searchString, 'limit_text'=>$start.','.($count+1), 'order_by'=>" ORDER BY M.date_added DESC "));
		}
		else if(!empty($instructions['action']) && $instructions['action'] == 'archive')
		{
			return $this->_query_reader->get_list('get_message_list', array('recipient_id'=>$this->native_session->get('__user_id'), 'search_query'=>$searchString, 'limit_text'=>$start.','.($count+1), 'order_by'=>" HAVING status='archived' ORDER BY M.date_added DESC"));
		}
		else
		{
			return $this->_query_reader->get_list('get_message_list', array('recipient_id'=>$this->native_session->get('__user_id'), 'search_query'=>$searchString, 'limit_text'=>$start.','.($count+1), 'order_by'=>" HAVING status <> 'archived' ORDER BY M.date_added DESC"));
		}
	}
	
	


	# Send a message submitted from a form on the UI
	function send_from_form($messageType, $details) 
	{
		$boolean = false;
		$msg = '';
		
		if(!empty($details['userid']))
		{
			if(strtolower(trim($details['userid'])) == 'all')
			{
				$users = $this->_query_reader->get_list('get_active_users');
				$unsuccessful = array();
				foreach($users AS $row)
				{
					if($row['id'] != $this->native_session->get('__user_id'))
					{
						if($messageType == 'email')
						{
							$result = $this->send_email_message($row['id'], array('subject'=>$details['subject'], 'details'=>$details['message']));
						}
						else if($messageType == 'sms')
						{
							$result = $this->send_sms_message($row['id'], array('subject'=>'NONE: From '.($this->native_session->get('__last_name').' '.$this->native_session->get('__first_name')).' at '.date('d-M-Y h:i:sA T'), 'sms'=>$details['message']));
						}
						else 
						{
							$result = $this->send_system_message($row['id'], array('subject'=>$details['subject'], 'details'=>$details['message']));
						}
						if(!$result) array_push($unsuccessful, $row['id']);
					}
				}
				
				$msg = "The message has been sent to all. ";
				if(!empty($unsuccessful))
				{
					#Get the unsuccessful users' names
					$userNames = $this->_query_reader->get_single_column_as_array('get_user_names_by_list', 'name', array('user_ids'=>"'".implode("','", $unsuccessful)."'", 'limit_full_text'=>' LIMIT 10'));
					
					$msg .= "However, an error occurred for the following: ".implode(', ', $userNames).(count($userNames) == 10? ' ..and more.': '');
					$boolean = false;
				}
				else
				{
					$boolean = true;
				}
			}
			else
			{
				if($messageType == 'email')
				{
					$boolean = $this->send_email_message($details['userid'], array('subject'=>$details['subject'], 'details'=>$details['message']));
				}
				else if($messageType == 'sms')
				{
					$boolean = $this->send_sms_message($details['userid'], array('subject'=>'NONE', 'sms'=>$details['message']));
				}
				else 
				{
					$boolean = $this->send_system_message($details['userid'], array('subject'=>$details['subject'], 'details'=>$details['message']));
				}
				if(!$boolean) $msg = "ERROR: We could not send the message.";
			}
		}
		
		return array('boolean'=>$boolean, 'msg'=>$msg); 
	}




	# Verify a message? - just keeping the function consistency
	# This function archives and restores messages from the inbox
	function verify($instructions)
	{
		$result = array('boolean'=>false, 'msg'=>'ERROR: The message instructions could not be resolved.');
		
		if(!empty($instructions['action']))
		{
			switch($instructions['action'])
			{
				case 'archive':
					$result['boolean'] = $this->change_status($instructions['id'], 'archived');
				break;
				
				case 'restore':
					$result['boolean'] = $this->change_status($instructions['id'], 'read');
				break;
			}
			
			if(!empty($result['boolean'])) 
			{
				$result['msg'] = $result['boolean']? "The message status has been changed": "ERROR: The message status could not be changed.";
			}
		}
		
		return $result;
	}
					
	
	
	# Change status of message
	function change_status($exchangeId, $status)
	{
		return $this->_query_reader->run('add_message_status', array('message_exchange_id'=>$exchangeId, 'user_id'=>$this->native_session->get('__user_id'), 'status'=>$status));
	}
	
	
	
	
	# Get the details about a message given its ID
	function message_details($messageId)
	{
		return $this->_query_reader->get_row_as_array('get_message_by_id', array('message_id'=>$messageId));
	}
	
	
	# Returns admin user ids
	function get_admin_users()
	{
		return $this->_query_reader->get_single_column_as_array('get_users_in_group', 'user_id', array('group'=>'admin', 'condition'=>''));
	}
}

?>