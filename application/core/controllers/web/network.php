<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls showing information related to a user network.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 01/16/2014
 */
class Network extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('referral_manager');
		$this->load->model('statistic_manager');
    }
	
	
	
	
	#Function to show the network home
	public function show_network_home()
	{
		access_control($this);
		$this->load->model('account_manager');
		$data = filter_forwarded_data($this);
		
		#Get all starts ready for network home display
		$statCodes = array('last_time_user_joined_my_direct_network', 'last_time_invite_was_sent', 'last_time_commission_was_earned', 'total_users_in_my_network', 'total_direct_referrals_in_my_network', 'total_level_2_referrals_in_my_network', 'total_level_3_referrals_in_my_network', 'total_level_4_referrals_in_my_network', 'total_invites_in_my_network', 'total_direct_invites_in_my_network', 'total_level_2_invites_in_my_network', 'total_level_3_invites_in_my_network', 'total_level_4_invites_in_my_network', 'total_earnings_in_my_network', 'total_direct_earnings_in_my_network', 'total_level_2_earnings_in_my_network', 'total_level_3_earnings_in_my_network', 'total_level_4_earnings_in_my_network', 'clout_score', 'my_current_commission', 'clout_score_details','clout_score_breakdown','clout_score_level', 'clout_score_key_description');
		$data['pageStats'] = $this->statistic_manager->get_user_statistic_by_group($this->native_session->get('userId'), $statCodes);
		
		#Score level information
		$scoreLevelData = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_criteria', array('condition'=>'', 'order_by'=>" ORDER BY 0+level DESC ")))->result_array();
		$data['cloutScoreDetails'] = array('cloutScore'=>$data['pageStats']['clout_score'], 'currentCommission'=>$data['pageStats']['my_current_commission'], 'cloutScoreDetails'=>$data['pageStats']['clout_score_details'], 'cloutScoreBreakdown'=>$data['pageStats']['clout_score_breakdown'], 'cloutScoreLevel'=>$data['pageStats']['clout_score_level'], 'scoreLevelData'=>$scoreLevelData, 'keyDescription'=>$data['pageStats']['clout_score_key_description']);
		
		#For the network list section
		$data['networkSectionList'] = $this->referral_manager->get_section_list($this->native_session->get('userId'), 'network', array('referral_level'=>'1', 'lower_limit'=>'0', 'upper_limit'=>(!empty($data['n'])? $data['n']: 5) ));
		$data['networkItemCount'] = $this->referral_manager->get_section_list($this->native_session->get('userId'), 'network', array('referral_level'=>'1', 'action'=>'item_count'));
		
		#For the invite list section
		$data['inviteSectionList'] = $this->referral_manager->get_section_list($this->native_session->get('userId'), 'invites', array('referral_level'=>'1', 'lower_limit'=>'0', 'upper_limit'=>(!empty($data['n'])? $data['n']: 5) ));
		$data['inviteItemCount'] = $this->referral_manager->get_section_list($this->native_session->get('userId'), 'invites', array('referral_level'=>'1', 'action'=>'item_count'));
		
		#Get the user's referral URLS
		$data['referralUrls'] = $this->account_manager->get_user_referral_url_ids($this->native_session->get('userId'), TRUE);
		$data['cloutId'] = $this->native_session->get('cloutId')? $this->native_session->get('cloutId'): '';
		
		#Prepare any messages for the screen
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/network/network_home', $data);
	}
	
	
	
	
	
	
	
	#Function to get gmail contacts
	public function get_gmail_contacts()
	{
		$data = filter_forwarded_data($this);
		include_once HOME_URL.'external_libraries/gmail/GmailOath.php';

		$data['oauth'] = new GmailOath(GOOGLE_CONSUMER_KEY, GOOGLE_CONSUMER_SECRET, '', '', GOOGLE_CALLBACK_URI);
		$data['service'] = 'GMAIL';
		
		#After the user logs into their GMAIL account
		if(!empty($data['r']))
		{
			$getcontact_access=new GmailGetContacts();
    		$request_token=$data['oauth']->rfc3986_decode($_GET['oauth_token']);
   			$request_token_secret=$data['oauth']->rfc3986_decode($_SESSION['oauth_token_secret']);
    		$oauth_verifier= $data['oauth']->rfc3986_decode($_GET['oauth_verifier']);
    		$contact_access = $getcontact_access->get_access_token($data['oauth'],$request_token, $request_token_secret,$oauth_verifier, false, true, true);
    		$access_token = !empty($contact_access['oauth_token'])? $data['oauth']->rfc3986_decode($contact_access['oauth_token']):'';
    		$access_token_secret = !empty($contact_access['oauth_token_secret'])?$data['oauth']->rfc3986_decode($contact_access['oauth_token_secret']):'';
    		$contacts= $getcontact_access->GetContacts($data['oauth'], $access_token, $access_token_secret, false, true,MAX_EMAIL_BATCH_COUNT);

    		#Now organize the emails into a contact list
			$data['finalContactsList'] = array();
			
			if(!empty($contacts))
			{
				foreach($contacts AS $key => $contactItem)
   				{
        			#Extract the contact name
					$name = !empty($contactItem['title']['$t'])? $contactItem['title']['$t']: '';
					$emailList = end($contactItem);
        			foreach($emailList AS $email)
        			{
           		 		#Add the contact info into the DB and display it
						$contactArray = array('owner_user_id'=>$_SESSION['userId'], 'source'=>'GMAIL', 'name'=>$name, 'email_address'=>str_replace("'", "", $email["address"]));
						$addResponse = $this->referral_manager->add_new_contact($contactArray);
						$contactArray = array_merge($contactArray,$addResponse); 
						array_push($data['finalContactsList'], $contactArray);
					}
    			}
			}
			
		}
		#User is loading to go get the contacts
		else
		{
			#Initialize the GMail authantication object and generate the access tokens
			$getContactObj = new GmailGetContacts();
			$data['accessToken'] = $getContactObj->get_request_token($data['oauth'], false, true, true);
			$_SESSION['oauth_token'] = $data['accessToken']['oauth_token'];
			$_SESSION['oauth_token_secret'] = $data['accessToken']['oauth_token_secret'];
		}
		
		$this->load->view('web/network/invite_contacts', $data);
	}
	
	
	
	
	
	
	
	#Function to send invitations to contacts
	public function send_invitations()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($_POST['contacts']))
		{
			#TODO: Add scheduling of email sending to prevent marking clout emails as spam
			$contactsList = $this->db->query($this->query_reader->get_query_by_code('get_imported_contacts', array('condition'=>" AND C.email_address IN ('".implode("','", $_POST['contacts'])."') ", 'limit_text'=>"", 'min_send_cycle'=>MIN_SEND_CYCLE)))->result_array();
			$results = array();
			foreach($contactsList AS $contact)
			{
				$result = $this->referral_manager->send_invitation($contact);
				array_push($results, $result);
			}
			
			$data['msg'] = get_decision($results)? "The invitations have been sent.": "WARNING: Invitations to some selected contacts could not be sent. Please check your invitation list.";
		}
		else
		{
			$data['msg'] = "WARNING: No contacts could be resolved. No invitations were sent out.";
		}
		
		#Determine where to go after sending the emails
		if(!empty($data['r']) && $data['r'] == 'internal')
		{
			$this->native_session->set('imsg', $data['msg']);
			$extraMsg = "";
			if(!empty($data['t']) && $data['t'] == 'imap_email')
			{
				$extraMsg = "<a href=\"javascript:updateFieldLayer('".base_url()."web/network/import_by_imap/m/imsg','','','imap_email_field','')\" class='bluebold'>Start New Import</a>";
			}
			else if(!empty($data['t']) && $data['t'] == 'file_email')
			{
				$extraMsg = "<a href=\"javascript:updateFieldLayer('".base_url()."web/network/import_from_file/m/imsg','','file_email_field','csv_form_div','')\" class='bluebold'>Start New Import</a>";
			}
			
			$data['msg'] = $data['msg']."<BR><BR>".$extraMsg;
			$data['area'] = 'basic_msg';
			$this->load->view('web/addons/basic_addons', $data);
		}
		#Coming from a popup
		else
		{
			$this->native_session->set('imsg', $data['msg']);
			echo "<script>window.opener.location.href='".base_url()."web/network/show_network_home/m/imsg';window.close();</script>";
		}
	}
	
	
	
	
	
	#Function to confirm that the email invite has been read
	public function email_invite_confirmation()
	{
		$data = filter_forwarded_data($this);
		
		#Record the read confirmation
		if(!empty($data['e']))
		{
			$result = $this->db->query($this->query_reader->get_query_by_code('update_invitation_status', array('email_address'=>decrypt_value($data['e']), 'message_status'=>'read', 'read_ip_address'=>get_ip_address() ))); 
		}
		
		return base_url()."assets/images/spacer.gif";
	}
	
	
	
	
	#Function to get yahoo contacts
	#With help from http://nullinfo.wordpress.com/oauth-yahoo/
	public function get_yahoo_contacts()
	{
		$data = filter_forwarded_data($this);
		$this->load->helper('oauth_helper');
		$data['service'] = 'YAHOO';
		
		
		if(!empty($data['r']))
		{
			#The verifier should not be taken away
			$_SESSION['oauth_verifier'] = $_GET['oauth_verifier'];
			// Get the access token using HTTP GET and HMAC-SHA1 signature
			$retarr = get_access_token(YAHOO_CONSUMER_KEY, YAHOO_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'], $_SESSION['oauth_verifier'], false, true, true);
			
			if (! empty($retarr)) 
			{
 			 	list($info, $headers, $body, $body_parsed) = $retarr;
  				if ($info['http_code'] == 200 && !empty($body)) 
				{
      				
					$_SESSION['access_oauth_token'] = rfc3986_decode($body_parsed['oauth_token']);
					$_SESSION['access_oauth_token_secret'] =  rfc3986_decode($body_parsed['oauth_token_secret']);
					$_SESSION['oauth_session_handle'] =  rfc3986_decode($body_parsed['oauth_session_handle']);
					$_SESSION['oauth_authorization_expires_in'] =  $body_parsed['oauth_authorization_expires_in'];
					$_SESSION['xoauth_yahoo_guid'] =  !empty($body_parsed['xoauth_yahoo_guid'])?rfc3986_decode($body_parsed['xoauth_yahoo_guid']): '';
					
					
					#Call contact API and get the contacts
					$contacts = callcontact(YAHOO_CONSUMER_KEY, YAHOO_CONSUMER_SECRET, $_SESSION['xoauth_yahoo_guid'], $_SESSION['access_oauth_token'], $_SESSION['access_oauth_token_secret'], false, true);
					
					
					$data['finalContactsList'] = array();
					if(!empty($contacts))
					{
						foreach($contacts AS $key => $contactItem)
   						{
        					#Extract the contact name
							$name = (!empty($contactItem['email']) && !empty($contactItem['name']['givenName']) && $contactItem['name']['givenName'] != $contactItem['email'])? $contactItem['name']['prefix']." ".$contactItem['name']['givenName']." ".$contactItem['name']['middleName']." ".$contactItem['name']['familyName']." ".$contactItem['name']['suffix']: '';
							
        					#Add the contact info into the DB and display it
							$contactArray = array('owner_user_id'=>$_SESSION['userId'], 'source'=>'YAHOO', 'name'=>trim($name), 'email_address'=>remove_quotes($contactItem['email']));
							$addResponse = $this->referral_manager->add_new_contact($contactArray);
							$contactArray = array_merge($contactArray,$addResponse); 
							array_push($data['finalContactsList'], $contactArray);
    					}
					}
					
				}
			}


		}
		else
		{
			# Get the request token using HTTP GET and HMAC-SHA1 signature
			$retarr = get_request_token(YAHOO_CONSUMER_KEY, YAHOO_CONSUMER_SECRET, YAHOO_CALLBACK_URI, false, true, true);#'oob';
		
			if (!empty($retarr)) 
			{
  				list($info, $headers, $body, $body_parsed) = $retarr;
  				#The token request was successful
				if ($info['http_code'] == 200 && !empty($body)) 
				{
     				$_SESSION['oauth_token'] = rfc3986_decode($body_parsed['oauth_token']);
				 	$_SESSION['oauth_token_secret'] = rfc3986_decode($body_parsed['oauth_token_secret']);
				 
				 	redirect(rfc3986_decode($body_parsed['xoauth_request_auth_url']));
 				}
				#Notify the user of the fail
				else
				{
					$data['msg'] = "ERROR: The access token could not be verified.";
				}
			}
		
		}
		
		$this->load->view('web/network/invite_contacts', $data);
	}
	
	
	
	
	#Function to get facebook contacts
	public function get_facebook_contacts()
	{
		/*require_once(HOME_URL.'external_libraries/facebook/facebook.php');
		
		$data = filter_forwarded_data($this);
		$data['service'] = 'FACEBOOK';
		
		$config = array(
    		'appId' => FACEBOOK_APP_KEY,
    		'secret' => FACEBOOK_APP_SECRET,
    		'cookie' => true,
		);

		$facebook = new Facebook($config);

		$user = $facebook->getUser();
		if($user) {
   			try {
        		$friends = $facebook->api('/me', 'GET');
    		} catch (FacebookApiException $e) {
        		$user = null;
    		}
		}
#print_r($user);
		
		#User is logged in
		if(!empty($user)) 
		{
   			try
    		{
        		$fql    =   "SELECT uid, name, pic_square FROM user WHERE uid = me()
                     		OR uid IN (SELECT uid2 FROM friend WHERE uid1 = me())";
        		$param  =   array(
            		'method'    => 'fql.query',
            		'query'     => $fql,
            		'callback'  => ''
        		);
        		$fqlResult   =   $facebook->api($param);
		
				print_r($fqlResult);
    		}
    		catch(Exception $o)
    		{
        		$data['msg'] = format_notice('ERROR: Could not obtain the user friend records.');
				d($o);
    		}
		}
		#Ask user to login if they are not signed up to give Clout permission to get the contacts
		else
		{
			#Actually returning from the facebook website but the user could not be resolved
			if(!empty($_GET['code']))
			{
				$data['msg'] = format_notice('ERROR: Could not resolve facebook user record.');
			}
			else
			{
				$args = array('scope' => 'email');
    			redirect($facebook->getLoginUrl($args));
			}
		}
		
		echo !empty($data['msg'])?$data['msg']:'';*/
		#$this->load->view('web/network/invite_contacts', $data);
		
		
		echo "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />".format_notice('WARNING: This feature is coming soon.');
	}
	
	
	
	
	
	#Function to get linkedin contacts
	public function get_linkedin_contacts()
	{
		require_once(HOME_URL.'external_libraries/linkedin/linkedin_3.2.0.class.php');
		
		$data = filter_forwarded_data($this);
		$data['service'] = 'LINKEDIN';
		
		
		$apiConfig = array('appKey' =>LINKEDIN_APP_KEY, 'appSecret'=>LINKEDIN_APP_SECRET, 'callbackUrl'=>NULL);
		#Get the correct http protocol (i.e. is this script being served via http or https)
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')? 'https': 'http';
		
		#Set the callback URL
		$apiConfig['callbackUrl'] = $protocol . '://' . $_SERVER['SERVER_NAME'] . ((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':' . $_SERVER['SERVER_PORT'] : '') . $_SERVER['PHP_SELF'] . '?' .  LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
      	$linkedinObj = new LinkedIn($apiConfig);
      	
		
      	#Check for response from LinkedIn
      	$_GET[LINKEDIN::_GET_RESPONSE] = (isset($_GET[LINKEDIN::_GET_RESPONSE])) ? $_GET[LINKEDIN::_GET_RESPONSE] : '';
     	if(!$_GET[LINKEDIN::_GET_RESPONSE]) 
		{
        	#LinkedIn hasn't sent us a response, the user is initiating the connection
        	#send a request for a LinkedIn access token
        	$response = $linkedinObj->retrieveTokenRequest();
        	if($response['success'] === TRUE) 
			{
          		#Store the request token
         		$this->native_session->set('oauth_request',$response['linkedin']);
				
          		#redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
          		header('Location: ' . LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
        	} 
			#bad token request
			else 
			{
          		$data['msg'] = "ERROR: Request token retrieval failed".(ENVIRONMENT != 'production'?":<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($linkedinObj, TRUE) . "</pre>":"");
       		}
		}
		else 
		{
        	#LinkedIn has sent a response, user has granted permission, take the temp access token, the user's secret and the verifier to request the user's real secret key
        	$prevResponse = $this->native_session->get('oauth_request');
			$response = $linkedinObj->retrieveTokenAccess($prevResponse['oauth_token'], $prevResponse['oauth_token_secret'], $_GET['oauth_verifier']);
        	if($response['success'] === TRUE) 
			{
          		#the request went through without an error, gather user's 'access' tokens
          		$this->native_session->set('oauth_access',$response['linkedin']);
          		#set the user as authorized for future quick reference
          		$this->native_session->set('oauth_authorized',TRUE);
				
				
            	#Show the contacts area
				$data['connectionApproved'] = true;
				
				$data['response'] = $linkedinObj->connections('~/connections:(id,first-name,last-name,picture-url)?start=0&count='.MAX_EMAIL_BATCH_COUNT);
        	}
          	#bad token access	 
			else 
			{
          		$data['msg'] = "ERROR: Access token retrieval failed".(ENVIRONMENT != 'production'?":<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($linkedinObj, TRUE) . "</pre>":"");
        	}
      	}
		
		
		$this->load->view('web/network/invite_social_contacts', $data);
	}
	
	
	
	
	#Function to send the linkedin message
	public function send_linkedin_message()
	{
		require_once(HOME_URL.'external_libraries/linkedin/linkedin_3.2.0.class.php');
		
		$data = filter_forwarded_data($this);
		$data['service'] = 'LINKEDIN';
		
		#Start the session if its available
  		if(!@session_start()) 
		{
    		throw new LinkedInException('This script requires session support, which appears to be disabled.');
 		}
		
		$apiConfig = array('appKey' =>LINKEDIN_APP_KEY, 'appSecret'=>LINKEDIN_APP_SECRET, 'callbackUrl'=>NULL);
		#Get the correct http protocol (i.e. is this script being served via http or https)
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')? 'https': 'http';
		
		#Set the callback URL
		$apiConfig['callbackUrl'] = $protocol . '://' . $_SERVER['SERVER_NAME'] . ((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':' . $_SERVER['SERVER_PORT'] : '') . $_SERVER['PHP_SELF'] . '?' .  LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
      	$linkedinObj = new LinkedIn($apiConfig);
		
		
		
		
		#Show the contacts area
		$data['connectionApproved'] = true;
		if(!empty($_POST['connections']))
		{
			#Check to make sure the oauth session is still active
        	if(!$this->native_session->get('oauth_access')) 
			{
          		throw new LinkedInException('Your LinkedIn system session expired. Please close this window and start again.');
        	}
			
        	$linkedinObj->setTokenAccess($this->native_session->get('oauth_access'));
        	$sendMeACopy = !empty($_POST['sendmecopy'])? TRUE: FALSE;
				
			$invitationMsg = get_confirmation_messages($this, array('emailaddress'=>"", 'firstname'=>'', 'fromname'=>$_SESSION['first_name']." ".$_SESSION['last_name'], 'fromemail'=>$_SESSION['email_address']), 'user_invitation');
        	#Send the connections the message
			$response = $linkedinObj->message($_POST['connections'], $invitationMsg['subject'], $invitationMsg['message'], $sendMeACopy);
        	#Message was a success
			if(!empty($response['success']) && $response['success'] === TRUE) 
			{
          		#TODO: Add scheduling of email sending to prevent marking clout emails as spam
				$contactsList = $this->db->query($this->query_reader->get_query_by_code('get_imported_contacts', array('condition'=>" AND C.email_address IN ('".implode("@linkedin.com','", $_POST['connections'])."@linkedin.com') ", 'limit_text'=>"", 'min_send_cycle'=>MAX_EMAIL_BATCH_COUNT)))->result_array();
				$results = array();
				foreach($contactsList AS $contact)
				{
					$result = $this->referral_manager->send_invitation($contact, TRUE);
					array_push($results, $result);
				}
				
				$this->native_session->set('imsg', "Your invitation has been sent to your connections.");
				echo "<script>window.opener.location.href='".base_url()."web/network/show_network_home/m/imsg';window.close();</script>";
        	} 
			# an error occured while sending
			else 
			{
          		$data['msg'] = "ERROR: Error sending messages".(ENVIRONMENT != 'production'?":<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($linkedinObj, TRUE) . "</pre>":"");
        	}
		}
		else
		{
			$data['msg'] = "WARNING: You must select at least one connection.";
		}
		
		$this->load->view('web/network/invite_social_contacts', $data);
	}
	
	
	
	
	
	
	#Function to get outlook contacts
	public function get_outlook_contacts()
	{
		echo "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />".format_notice('WARNING: This feature is coming soon.');
	}
	
	
	#Function to import by IMAP
	public function import_by_imap()
	{
		$data = filter_forwarded_data($this);
		
		#The user has submitted all required info to get the contacts
		if($this->input->post('yourpass'))
		{
			$mailHost = $this->input->post('emailhost')? $this->input->post('emailhost'): '';
			$response = $this->referral_manager->import_imap_email_contacts($this->input->post('youremail'), $this->input->post('yourpass'), $mailHost);
			
			if(!empty($response['result']) && $response['result'])
			{
				$data['finalContactsList'] = array();
				#Go through and add more info about each contact
				foreach($response['contacts'] AS $contactArray)
				{
					#Add the contact info into the DB and display it
					$addResponse = $this->referral_manager->add_new_contact($contactArray);
					$contactArray = array_merge($contactArray,$addResponse); 
					array_push($data['finalContactsList'], $contactArray);
				}
				
			}
			else
			{
				$this->native_session->set('imsg', "ERROR: There was a problem connecting to your email account.");
				$data['msg'] = "ERROR: There was a problem connecting to your email account. <br>Check your email and password and <a href=\"javascript:updateFieldLayer('".base_url()."web/network/import_by_imap/m/imsg','','','imap_email_field','')\">try again</a>.";
			}
			$data['r'] = 'imap_email';
			$this->load->view('web/network/invite_contacts', $data);
		}
		#Just submitted the email
		else
		{
			#The user has entered a valid phone
			if(!empty($data['youremail']) && is_valid_email(restore_bad_chars($data['youremail'])))
			{
				$data['youremail'] = restore_bad_chars($data['youremail']);
				$response = $this->referral_manager->import_imap_email_contacts($data['youremail'],'','', 'GET_HOST');
				
				$data['getHost'] = (!empty($response['instruction']) && $response['instruction'] == 'GET_HOST')? TRUE: FALSE;
				$data['msg'] = $response['message'];
			}
			else
			{
				$data['getEmail'] = TRUE;
				$data['msg'] = !empty($data['m'])? $this->native_session->get($data['m']): "WARNING: Please enter a valid email.";
			}
		
		
			$data['area'] = "imap_import_details";
			$this->load->view('web/addons/basic_addons', $data);
		}
	}
	
	
	
	
	
	#Import contacts from a CSV file
	public function import_from_file()
	{
		#Load required models
		$this->load->model('sys_file', 'sysfile');
		$this->load->model('csv_account_processor', 'contact_processor');
		
		$data = filter_forwarded_data($this);
		$this->native_session->set('local_allowed_extensions', array('.csv', '.xls', '.xlsx', '.txt'));
		$data['allowedExtensions'] = $this->native_session->get('local_allowed_extensions');
		
		#Only upload if all the form info is submitted.
		if(!empty($_POST['csv_file_format']) && !empty($_FILES['csvuploadfile']['name']) && !empty($_SESSION['email_address'])) 
		{
			#File extension
			$fileExt = strtolower(strrchr($_FILES['csvuploadfile']['name'],"."));
			if(!empty($fileExt) && in_array($fileExt, $data['allowedExtensions'])) 
			{
				#Upload and store a copy for retrying in case the upload failed the first time, or the contacts were not finished in the first run.
				#TODO: Add a cron job to complete processing and/or clean out old uploaded files
				$documentUrl = !empty($_FILES['csvuploadfile']['name'])? $this->sysfile->local_file_upload($_FILES['csvuploadfile'], "file_".strtotime('now'), 'documents', 'filename'): '';
				$uploadFileFullPath = !empty($documentUrl)?UPLOAD_DIRECTORY.'documents/'.$documentUrl:'';
				
				#Import the raw cotant emails from the file provided
				$rawContacts = $this->contact_processor->get_contacts_through_file($this->native_session->get('userId'), $uploadFileFullPath, $_POST['csv_file_format']);
				
				
				if(!empty($rawContacts['result']) && $rawContacts['result'])
				{
					$data['finalContactsList'] = $rawContacts['data'];
				}
				else
				{
					$this->native_session->set('imsg', "WARNING: There was a problem importing contacts from the format given.");
					$data['msg'] = "WARNING: ".$rawContacts['message'].". <br>Please check your file and <a href=\"javascript:updateFieldLayer('".base_url()."web/network/import_from_file/m/imsg','','','csv_form_div','')\" class='bluebold'>try again</a>.";
				}
				$data['r'] = 'file_email';
				$this->load->view('web/network/invite_contacts', $data);
			}
			else
			{
				$data['msg'] = "WARNING: Invalid file format. Please <a href=\"javascript:updateFieldLayer('".base_url()."web/network/import_from_file/m/imsg','','','csv_form_div','')\" class='bluebold'>try again</a>.";
				
				$data['area'] = "import_from_file";
				$this->load->view('web/addons/basic_addons', $data);
			}
		}
		else
		{
			if(empty($_SESSION['email_address']))
			{
				$data['msg'] = "WARNING: Your session expired. Please login and try again.";
			}
			else
			{
				$data['msg'] = "WARNING: All fields are required. <br>Allowed extensions are: ".implode(', ', $data['allowedExtensions']);
			}
			
			$data['area'] = "import_from_file";
			$this->load->view('web/addons/basic_addons', $data);
		}
		
	}
	
	
	
	
	
	
	#Function to check whether a new URL id is valid
	public function check_new_url_validity()
	{
		$data = filter_forwarded_data($this);
		
		#1. Check whether the URL has minimum 5 characters and does not contain special characters
		if(!empty($data['newurlid']))
		{
			$checkUrlCount = $this->db->query($this->query_reader->get_query_by_code('check_number_of_referral_ids', array('user_id'=>$this->native_session->get('userId'))))->row_array();
			
			$newUrlId = restore_bad_chars($data['newurlid']);
			
			if(strlen($newUrlId) >= MIN_REFERRAL_ID_LENGTH && !does_string_contain_special_characters($newUrlId) && $checkUrlCount['id_count'] < MAX_REFERRAL_LINKS)
			{
				#2. Check whether the URL is not taken 
				$result = $this->db->query($this->query_reader->get_query_by_code('check_referral_url_ids', array('url_id'=>$newUrlId)))->row_array();
				
				$data['canSave'] = !empty($result)? "NO": "YES";
			}
			else
			{
				if($checkUrlCount['id_count'] >= MAX_REFERRAL_LINKS)
				{
					$data['msg'] = "WARNING: Maximum allowed IDs reached.";
				}
				else
				{
					$data['msg'] = "WARNING: Invalid ID";
				}
			}
		}
		else
		{
			$data['msg'] = "WARNING: ID IS EMPTY";
		}
		
		$data['area'] = "add_new_url_id";
		$this->load->view('web/addons/network_addons', $data);
	}
	
	
	
	#Function to show current referral links of a user
	public function current_referral_links()
	{
		$data = filter_forwarded_data($this);
		$data['referralUrls'] = $this->db->query($this->query_reader->get_query_by_code('get_referral_url_ids', array('user_id'=>$this->native_session->get('userId'), 'conditions'=>'')))->result_array();
		
		$data['area'] = "current_referral_links";
		$this->load->view('web/addons/network_addons', $data);
	}
	
	
	
	
	#Function to save a new URL id
	public function save_new_url_id()
	{
		$data = filter_forwarded_data($this);
		#1. Check whether the URL has minimum 5 characters and does not contain special characters
		if(!empty($data['newurlid']))
		{
			$result = $this->db->query($this->query_reader->get_query_by_code('save_url_id', array('user_id'=>$this->native_session->get('userId'), 'url_id'=>$data['newurlid'])));
			$data['msg'] = $result? "ID has been added": "ERROR: Could not add ID";
		}
		else
		{
			$data['msg'] = "WARNING: ID IS EMPTY";
		}
		
		$data['area'] = "basic_msg";
		$this->load->view('web/addons/basic_addons', $data);
			
	}
	
	
	#Function to send email from pasted values
	public function send_from_paste()
	{
		$data = filter_forwarded_data($this);
		
		if($this->input->post('emailpastevalues'))
		{
			$emailContacts = explode('|', $this->input->post('emailpastevalues'));
			//Add the final email entered if it is a valid email
			if(filter_var($this->input->post('newemail'), FILTER_VALIDATE_EMAIL ))
			{
				array_push($emailContacts, $this->input->post('newemail'));
			}
			//Remove duplicates
			$emailContacts = array_unique($emailContacts);
			
			
			$data['finalContactsList'] = array();
			#Go through and add more info about each contact
			foreach($emailContacts AS $contact)
			{
				#Add the contact info into the DB and display it
				$addResponse = $this->referral_manager->add_new_contact( array('email_address'=>$contact));
				$contactArray = array_merge(array('email_address'=>$contact, 'name'=>''),$addResponse); 
				array_push($data['finalContactsList'], $contactArray);
			}
		}
		else
		{
			$data['msg'] = "WARNING: There was a problem processing contacts.";
		}
		$data['r'] = 'paste_email';
		$this->load->view('web/network/invite_contacts', $data);
	}
	
	
	
	#Show part of a section list
	public function show_part_of_network_list()
	{
		$data = filter_forwarded_data($this);
		#Number of entries per list
		#Pick from the entire list if the user is updating this part
		$passedKeys = array_keys($data);
		foreach($passedKeys AS $key)
		{
			if(strpos($key, '_noofentries') !== FALSE)
			{
				$data['n'] = $data[$key];
				$changedListNumber = TRUE;
			}
		}
		
		$data['noPerPage'] = !empty($data['n'])? $data['n']: 5;
		$data['currentPage'] = !empty($data['p'])? $data['p']: 1;
		$lowerLimit = ($data['currentPage']-1)*$data['noPerPage'];
		
		#Determine which network list type is desired
		if(!empty($data['t']) && $data['t'] == 'invites')
		{
			$data['sectionList'] = $this->referral_manager->get_section_list($this->native_session->get('userId'), 'invites', array('referral_level'=>'1', 'lower_limit'=>$lowerLimit, 'upper_limit'=>$data['noPerPage']));
			$data['itemCount'] = $this->referral_manager->get_section_list($this->native_session->get('userId'), 'invites', array('referral_level'=>'1', 'action'=>'item_count'));
			$data['noOfPages'] = ceil($data['itemCount']/$data['noPerPage']);
		
			$data['sectionType'] = 'invites';
			$data['sectionArea'] = empty($changedListNumber)?'invites_list':'';
		}
		else
		{
			$data['sectionList'] = $this->referral_manager->get_section_list($this->native_session->get('userId'), 'network', array('referral_level'=>'1', 'lower_limit'=>$lowerLimit, 'upper_limit'=>$data['noPerPage']));
			$data['itemCount'] = $this->referral_manager->get_section_list($this->native_session->get('userId'), 'network', array('referral_level'=>'1', 'action'=>'item_count'));
			$data['noOfPages'] = ceil($data['itemCount']/$data['noPerPage']);
		
			$data['sectionType'] = 'network';
			$data['sectionArea'] = empty($changedListNumber)?'network_list':'';
		}
		
		$this->load->view('web/network/network_list', $data);	
	}
}

/* End of controller file */