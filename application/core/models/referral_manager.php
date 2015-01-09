<?php

/**
 * This class manages referrals
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 02/18/2014
 */
class Referral_manager extends CI_Model
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('scoring');
    }
	
	#Adds a new contact from the contact list presented by the user
	public function add_new_contact($contactInfo)
	{
		$response = array('success'=>false, 'inDB'=>false, 'alreadyContacted'=>false, 'canContactAgain'=>true, 'lastContactDate'=>'');
		
		#1. process the name field
		#- Remove the name if it is the same as the email address
		$contactInfo['name'] = (empty($contactInfo['name']) || ($contactInfo['name'] == $contactInfo['email_address']))? '': $contactInfo['name'];
		#- Separate the name field details
		if(!empty($contactInfo['name']))
		{
			$name = explode(' ', $contactInfo['name']);
			$contactInfo['first_name'] = (count($name) > 0)? htmlentities($name[0], ENT_QUOTES): '';
			$theFirstName = array_shift($name);
			$contactInfo['last_name'] = (count($name) > 1)? htmlentities(implode(' ', $name), ENT_QUOTES): '';
		}
		else 
		{
			$contactInfo['first_name'] = '';
			$contactInfo['last_name'] = '';
		}
		
		#Fill in any possible ommissions
		$contactInfo['middle_name'] = !empty($contactInfo['middle_name'])? $contactInfo['middle_name']: '';
		$contactInfo['phone_number'] = !empty($contactInfo['phone_number'])? $contactInfo['phone_number']: '';
		$contactInfo['photo_url'] = !empty($contactInfo['photo_url'])? $contactInfo['photo_url']: '';
		
		#2. Check if the email already exists in the imported contacts list. If not, add it
		$importCheck = $this->db->query($this->query_reader->get_query_by_code('check_for_contact_in_imports', array('email_address'=>$contactInfo['email_address'])))->row_array();
		if(count($importCheck) > 0)
		{
			$response['inDB'] = true;
			#3. If the contact already exists, check if an invitation was already sent to the contact
			#TODO: Make MIN_SEND_CYCLE also dependent on user permissions
			$canSendCheck = $this->db->query($this->query_reader->get_query_by_code('check_for_invitation_sending', array('email_address'=>$contactInfo['email_address'], 'min_send_cycle'=>MIN_SEND_CYCLE)))->row_array();
			
			$response['alreadyContacted'] = !empty($canSendCheck)? true: false;
			$response['canContactAgain'] = (empty($canSendCheck) || (!empty($canSendCheck) && $canSendCheck['can_send'] == 'YES' && $canSendCheck['blocked_invitation'] == 'N'))? true: false;
			$responce['lastContactDate'] = !empty($canSendCheck['last_invitation_sent_on'])? $canSendCheck['last_invitation_sent_on']:'';
		}
		#This is a new contact - never been in the system
		else
		{
			$response['success'] = $this->db->query($this->query_reader->get_query_by_code('add_new_invitation_contact', $contactInfo));
		}
		
		return $response;
	}
	
	
	#Sends a contact an invitation
	public function send_invitation($contact, $justRecord=FALSE)
	{
		$invitationMethod = !empty($contact['invitation_method'])? $contact['invitation_method']: 'email';
		
		$thisUser = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$_SESSION['userId'])))->row_array();
		#If we just want to record the sending (e.g., for social networks)
		if(!$justRecord)
		{
			$sendResult = $this->sys_email->email_form_data(array('fromemail'=>$thisUser['email_address'], 'fromname'=>$thisUser['name']), get_confirmation_messages($this, array('emailaddress'=>$contact['email_address'], 'firstname'=>$contact['first_name'], 'fromname'=>$thisUser['name'], 'fromemail'=>$thisUser['email_address']), 'user_invitation')); 
		}
		else
		{
			$sendResult = TRUE;
		}
		
		#Record the email sending
		if($sendResult)
		{
			 $messageStatus = "sent";
			 $invitationNo = "1";
		}
		else
		{
			$messageStatus = "bounced";
			$invitationNo = "0";
		}
				
		#Is this a new send or a repeat send?
		#- Repeat send
		if(!empty($contact['last_invitation_sent_on']))
		{
			$updateQueryParts = array();
			if($sendResult) array_push($updateQueryParts, "number_of_invitations = (number_of_invitations+1)");
			if(!empty($contact['first_name'])) array_push($updateQueryParts, "first_name = '".$contact['first_name']."'");
			if(!empty($contact['last_name'])) array_push($updateQueryParts, "last_name = '".$contact['last_name']."'");
			if(!empty($contact['phone_number'])) array_push($updateQueryParts, "phone_number = '".$contact['phone_number']."'");
			array_push($updateQueryParts, "invite_message = '".(!empty($contact['invite_message'])?$contact['invite_message']:'STANDARD')."'");
			array_push($updateQueryParts, "method_used = '".$invitationMethod."'");
			array_push($updateQueryParts, "message_status = '".$messageStatus."'");
			array_push($updateQueryParts, "last_invitation_sent_on = NOW()");
			array_push($updateQueryParts, "sent_at_ip_address = '".get_ip_address()."'");
			array_push($updateQueryParts, "invitation_sent_by = '".$_SESSION['userId']."'");
			array_push($updateQueryParts, "message_status_date = NOW()");
			array_push($updateQueryParts, "referral_status_date = NOW()");
			
			$result = $this->db->query($this->query_reader->get_query_by_code('update_invitation_data', array('email_address'=>$contact['email_address'], 'update_fields_query'=>", ".implode(", ", $updateQueryParts) )));
		}
		#- New invitation
		else
		{
			$result = $this->db->query($this->query_reader->get_query_by_code('record_invitation_status', array('user_id'=>$_SESSION['userId'], 'first_name'=>$contact['first_name'], 'last_name'=>$contact['last_name'], 'invite_message'=>'STANDARD', 'email_address'=>$contact['email_address'], 'method_used'=>$invitationMethod, 'invitation_time'=>date('Y-m-d H:i:s', strtotime('now')), 'referral_status'=>'pending', 'message_status'=>'sent', 'number_of_invitations'=>'1', 'last_invitation_sent_on'=>date('Y-m-d H:i:s', strtotime('now')), 'sent_at_ip_address'=>get_ip_address(), 'invitation_sent_by'=>$_SESSION['userId'], 'message_status_date'=>date('Y-m-d H:i:s', strtotime('now')), 'referral_status_date'=>date('Y-m-d H:i:s', strtotime('now')) )));
		}
		
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	#Import email contacts by IMAP
	#TODO: Add option to import by date range
	public function import_imap_email_contacts($userEmail, $userPassword='', $mailHost='', $action='GET_CONTACTS', $emailLimit=MAX_EMAIL_BATCH_COUNT)
	{
		$response = array('result'=>FALSE, 'contacts'=>array(), 'message'=>'', 'instruction'=>'');
		$emailLimit=10;
		#Just get the host
		if($action == 'GET_HOST')
		{
			$host = $this->get_email_host($userEmail);
			$response['instruction'] = empty($host)? 'GET_HOST': '';
			$response['result'] = empty($host)? FALSE: TRUE;
			$response['contacts'] = empty($host)? '': $host;
		}
		#Get the actual email contacts
		else if($action == 'GET_CONTACTS' || $action == 'GET_EMAILS')
		{
			$host = $this->get_email_host($userEmail);
			$host = !empty($host)? $host: $mailHost;
			$source = strtoupper(substr(stristr($userEmail, '@'), 1));
			
			#$mailbox = imap_open($host,$userEmail,$userPassword) OR die("<br />\nFAILLED! ".imap_last_error());
			
			
			#Only search if the search passes
			if($mailbox = @imap_open($host,$userEmail,$userPassword))
			{
			$emailMessages = imap_search($mailbox,'ALL');
			rsort($emailMessages);
			$emails = $contacts = array();
			
			#Loop through the messages and pick the contacts
			foreach($emailMessages AS $message) 
			{
				#Fetch the headers of the emails and extract all the contact email addresses and the names
				#TODO: Add the option to get the messages by date range
				$overview = imap_rfc822_parse_headers(imap_fetchheader($mailbox,$message,0));
				
				#FROM
				foreach($overview->from AS $contactObj)
				{
					$fromEmail = $contactObj->mailbox.'@'.$contactObj->host;
					if(is_valid_email($fromEmail) && strtolower($userEmail) == strtolower($fromEmail))
					{
						$validFromEmail = strtolower($fromEmail);
					}
				}
				
				#Get emails to which the user actually responded to reduce spamming spammers
				if(!empty($validFromEmail))
				{
					#TO
					foreach($overview->to AS $contactObj)
					{
						$theEmail = strtolower((!empty($contactObj->mailbox) && !empty($contactObj->host))? $contactObj->mailbox.'@'.$contactObj->host:(!empty($contactObj->toaddress)? $contactObj->toaddress: ''));
						if(is_valid_email($theEmail))
						{
							array_push($emails, $theEmail);
							$contacts[$theEmail] = array('owner_user_id'=>$_SESSION['userId'], 'email_address'=>$theEmail, 'name'=>(!empty($contactObj->personal)? remove_commas($contactObj->personal):''), 'source'=>$source);
						}
					}
				
				
					#CC
					if(!empty($overview->cc))
					{
						foreach($overview->cc AS $contactObj)
						{
							$theEmail = strtolower($contactObj->mailbox.'@'.$contactObj->host);
							if(is_valid_email($theEmail))
							{
								array_push($emails, $theEmail);
								$contacts[$theEmail] = array('owner_user_id'=>$_SESSION['userId'], 'email_address'=>$theEmail, 'name'=>(!empty($contactObj->personal)? remove_commas($contactObj->personal):''), 'source'=>$source);
							}
						}
					}
				
				
					#BCC
					if(!empty($overview->bcc))
					{
						foreach($overview->bcc AS $contactObj)
						{
							$theEmail = strtolower($contactObj->mailbox.'@'.$contactObj->host);
							if(is_valid_email($theEmail))
							{
								array_push($emails, $theEmail);
								$contacts[$theEmail] = array('owner_user_id'=>$_SESSION['userId'], 'email_address'=>$theEmail, 'name'=>(!empty($contactObj->personal)? remove_commas($contactObj->personal):''), 'source'=>$source);
							}
						}
					}
				}
				
				
				#Remove any duplicates
				$emails = array_unique($emails);
				
				#Quit the loop if you have reached the fetch limit
				if((count($emails)+1) >= $emailLimit)
				{
					break;
				}
			}
			}
			else
			{
				$response['message'] = "WARNING: The login credentials could not verify.";
			}
			
			#Remove the owner's email address
			if(!empty($_SESSION['email_address']) && !empty($emails) && !empty($validFromEmail))
			{
				if(in_array($_SESSION['email_address'], $emails))
				{
					array_splice($emails, array_search($_SESSION['email_address'], $emails), 1);
				}
				if(in_array($validFromEmail, $emails))
				{
					array_splice($emails, array_search($validFromEmail, $emails), 1);
				}
				
				unset($contacts[$validFromEmail]);
			}
			
				
			#Emails were returned
			if(!empty($emails))
			{
				$response['contacts'] = ($action == 'GET_CONTACTS')? $contacts: $emails;
				$response['result'] = TRUE;
			}
			else
			{
				$response['message'] = "ERROR: No emails could be returned.";
			}
		}
		
		
		return $response;
	}
	
	
	#Function to get the email host provider
	public function get_email_host($userEmail, $returnType='actualUrl')
	{
		$emailHost = '';
		
		#First get the domain of the email 
		$emailDomain = strtolower(substr(stristr($userEmail, '@'), 1));
		
		#Search the known mail hosts
		$host = $this->db->query($this->query_reader->get_query_by_code('get_known_mail_host', array('domain'=>$emailDomain)))->row_array();
		if(!empty($host))
		{
			if($returnType == 'actualUrl')
			{
				if(!empty($host['actualurl']))
				{
					$emailHost = $host['actualurl'];
				}
				else
				{
					$emailHost = "{".$host['hosturl'].":".$host['port']."/imap/ssl}INBOX";
				}
			}
			else
			{
				$emailHost = $host['hosturl'];
			}
		}
		
		
		return $emailHost;
	}
	
	
	
	
	
	
	
	#Function to get a list of section
	public function get_section_list($userId, $listType, $restrictions=array())
	{
		switch($listType) {
    		case 'network':
        		return $this->get_network_list($userId, $restrictions);
			break;
			
			case 'invites':
        		return $this->get_invite_list($userId, $restrictions);
			break;
			
			
			
			default:
				return "ERROR: code not recognized.";
			break;
		}
	}
	
	
	
	
	#Gets the user's network based on preset specs
	#TODO: Add implementations for other users beyond the first generation
	private function get_network_list($userId, $restrictions)
	{
		if(array_key_exists('action', $restrictions) && $restrictions['action'] == 'item_count')
		{
			return $this->scoring->get_user_referrals($userId, 'count');
		}
		else
		{
			$minLimit = array_key_exists('lower_limit', $restrictions)? $restrictions['lower_limit']: '0';
			$maxLimit = array_key_exists('upper_limit', $restrictions)? $restrictions['upper_limit']: '5';
			$limitQuery = " LIMIT ".$minLimit.", ".$maxLimit.";";
				
			return $this->db->query($this->query_reader->get_query_by_code('get_network_user_summary', array('referrer_id'=>$userId, 'limit_query'=>$limitQuery)))->result_array();
		}
	}
	
	
	
	
	#Gets the user's invites based on preset specs
	private function get_invite_list($userId, $restrictions)
	{
		if(array_key_exists('action', $restrictions) && $restrictions['action'] == 'item_count')
		{
			$invitations = $this->db->query($this->query_reader->get_query_by_code('get_user_invite_count', array('user_id'=>$userId)))->row_array(); 
			return $invitations['invite_count'];
		}
		else
		{
			$minLimit = array_key_exists('lower_limit', $restrictions)? $restrictions['lower_limit']: '0';
			$maxLimit = array_key_exists('upper_limit', $restrictions)? $restrictions['upper_limit']: '5';
			$limitQuery = " LIMIT ".$minLimit.", ".$maxLimit.";";
			
			return $this->db->query($this->query_reader->get_query_by_code('get_invite_user_summary', array('referrer_id'=>$userId, 'limit_query'=>" ORDER BY I.last_invitation_sent_on DESC ".$limitQuery)))->result_array();
		}
	}
	
	
	
	
	
	
	
	
	
}

?>