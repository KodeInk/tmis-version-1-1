<?php

/**
 * This class manages account information, access and use.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 11/26/2013
 */
class Account_manager extends CI_Model
{
	#the account's application status
    private $applicationStatus=array();
	
	
	
	
	
	#Creates a new user
	public function create_new_user($userData, $sendConfirmationEmail=TRUE)
	{
		$response = array('user_id'=>'', 'user_created'=>FALSE, 'message_sent'=>FALSE, 'error_msg'=>'');
		
		$userDetails = $this->db->query($this->query_reader->get_query_by_code('get_users_by_field_value', array('field_name'=>'email_address', 'field_value'=>strtolower($userData['emailaddress']) )))->row_array();
		#Create the initial user record if a user with the email address given does not exist
		if(empty($userDetails))
		{
			$response['user_created'] = $this->db->query($this->query_reader->get_query_by_code('add_new_user', array(
				'user_type'=>'normal', #(!empty($userData['usertype'])? $userData['usertype']: 'normal'),
				'user_label'=>(!empty($userData['usertype'])? $userData['usertype']: 'normal'),
				'first_name'=>(!empty($userData['firstname'])? $userData['firstname']: ''),
				'middle_name'=>(!empty($userData['middlename'])? $userData['middlename']: ''),
				'last_name'=>(!empty($userData['lastname'])? $userData['lastname']: ''),
				'password'=>(!empty($userData['yourpassword'])? sha1($userData['yourpassword']): ''),
				'gender'=>(!empty($userData['gender'])? $userData['gender']: 'unknown'),
				'birthday'=>(!empty($userData['birthday'])? date('Y-m-d', strtotime($userData['birthday'])): '0000-00-00'),
				'email_address'=>(!empty($userData['emailaddress'])? strtolower($userData['emailaddress']): ''),
				'email_verified'=>'N',
				'user_status'=>'pending')));
		
			$userDetails = $this->db->query($this->query_reader->get_query_by_code('get_users_by_field_value', array('field_name'=>'email_address', 'field_value'=>strtolower($userData['emailaddress']) )))->row_array();
			$response['user_id'] = $userDetails['id'];
			#Now send the confirmation message if the instructions do not block this requirement
			if($response['user_created'] && $sendConfirmationEmail)
			{
				$confirmationResponse = $this->send_user_an_activation_link(array('from_email'=>NOREPLY_EMAIL, 'from_name'=>SITE_GENERAL_NAME, 'to_email'=>$userData['emailaddress'], 'first_name'=>$userData['firstname'], 'clout_id'=>generate_system_id($this,$response['user_id']), 'user_id'=>$response['user_id'], 'message_type'=>'signup_confirmation'));
				$response['message_sent'] = $confirmationResponse['message_sent'];
			}
		}
		else
		{
			$response['error_msg'] = "WARNING: A user with that email address already exists. <a href='".base_url()."web/account/forgot_password' class='bluebold'>Click here</a> to recover your password";
		}
		
		return $response;
	}
	
	
	#Send a user an activation link
	public function send_user_an_activation_link($messageDetails, $userType='normal')
	{
		$response = array('message_sent'=>FALSE, 'record_updated'=>FALSE);
		$messageDetails['message_type'] = !empty($messageDetails['message_type'])? $messageDetails['message_type']: 'signup_confirmation';
		
		#Sending an activation link for a merchant
		if($userType=='merchant')
		{
			$response['message_sent'] = $this->sys_email->email_form_data(array('fromemail'=>$messageDetails['from_email'], 'fromname'=>$messageDetails['from_name']), get_confirmation_messages($this, array('emailaddress'=>$messageDetails['to_email'], 'firstname'=>$messageDetails['first_name'], 'cloutid'=>$messageDetails['clout_id'], 'businessname'=>htmlentities($messageDetails['business_name']), 'contactemail'=>$messageDetails['contact_email']), $messageDetails['message_type'])); 
				
			$response['record_updated'] = $this->db->query($this->query_reader->get_query_by_code('update_store_value', array('store_id'=>$messageDetails['store_id'], 'field_name'=>'submission_notice_sent', 'field_value'=>date('Y-m-d H:i:s'))));
		}
		#Sending for a normal user
		else
		{
			$response['message_sent'] = $this->sys_email->email_form_data(array('fromemail'=>$messageDetails['from_email'], 'fromname'=>$messageDetails['from_name']), get_confirmation_messages($this, array('emailaddress'=>$messageDetails['to_email'], 'firstname'=>$messageDetails['first_name'], 'cloutid'=>$messageDetails['clout_id']), $messageDetails['message_type'])); 
				
			$response['record_updated'] = $this->db->query($this->query_reader->get_query_by_code('update_user_value', array('user_id'=>$messageDetails['user_id'], 'field_name'=>'activation_email_sent', 'field_value'=>date('Y-m-d H:i:s'))));
		}
		
		return $response;
	}
	
	
	
	
	
	#Creates a new merchant
	public function create_new_merchant($storeData, $sendConfirmationEmail=TRUE)
	{
		$response = array('merchant_id'=>($this->native_session->get('merchantId')? $this->native_session->get('merchantId'): ''), 
			'merchant_created'=>FALSE, 
			'message_sent'=>FALSE, 
			'error_msg'=>'');
		
		if($this->native_session->get('userId'))
		{
			#Create the initial user record if a user with the email address given does not exist
			#TODO: REview the process for handling duplicate records if the same user submits more than one application
			if($this->native_session->get('merchantId'))
			{
				$response['merchant_created'] = $this->db->query($this->query_reader->get_query_by_code('update_store_data', array(
				'name'=>htmlentities($storeData['businessname']),
				'email_address'=>strtolower($storeData['emailaddress']),
				'address_line_1'=>$storeData['addressline1'],
				'city'=>$storeData['city'],
				'state'=>$storeData['statecode'],
				'zipcode'=>$storeData['zipcode'],
				'website'=>$storeData['businesswebsite'],
				'country'=>$storeData['countrycode'],
				'phone_number'=>remove_string_special_characters($storeData['telephone']),
				'employee_number'=>remove_string_special_characters($storeData['employeeno']),
				'estimated_annual_revenue'=>$storeData['annualrevenue'],
				'price_range'=>$storeData['pricerange'],
				'primary_contact_name'=>htmlentities($storeData['contactname']),
				'primary_contact_title'=>htmlentities($storeData['contacttitle']),
				'primary_contact_phone'=>remove_string_special_characters($storeData['contacttelephone']),
				'primary_contact_email'=>strtolower($storeData['contactemailaddress']),
				'claimed_company_id'=>(!empty($storeData['businessnameclaimid'])? $storeData['businessnameclaimid'] : ''),
				'store_id'=>$this->native_session->get('merchantId') )));
			}
			else
			{
				$response['merchant_created'] = $this->db->query($this->query_reader->get_query_by_code('add_new_store', array(
				'name'=>htmlentities($storeData['businessname']),
				'email_address'=>strtolower($storeData['emailaddress']),
				'merchant_id'=>$this->native_session->get('userId'),
				'status'=>'pending',
				'address_line_1'=>$storeData['addressline1'],
				'city'=>$storeData['city'],
				'state'=>$storeData['statecode'],
				'zipcode'=>$storeData['zipcode'],
				'website'=>$storeData['businesswebsite'],
				'country'=>$storeData['countrycode'],
				'phone_number'=>remove_string_special_characters($storeData['telephone']),
				'employee_number'=>remove_string_special_characters($storeData['employeeno']),
				'estimated_annual_revenue'=>$storeData['annualrevenue'],
				'price_range'=>$storeData['pricerange'],
				'primary_contact_name'=>htmlentities($storeData['contactname']),
				'primary_contact_title'=>htmlentities($storeData['contacttitle']),
				'primary_contact_phone'=>remove_string_special_characters($storeData['contacttelephone']),
				'primary_contact_email'=>strtolower($storeData['contactemailaddress']),
				'claimed_company_id'=>(!empty($storeData['businessnameclaimid'])?$storeData['businessnameclaimid']:''),
				'additional_fields'=>'',
				'additional_field_values'=>'')));
		
				$response['merchant_id'] = $this->db->insert_id();
			}
			
		}
		
		#Now send the confirmation message if the instructions do not block this requirement
		if($response['merchant_created'] && $sendConfirmationEmail)
		{
			$confirmationResponse = $this->send_user_an_activation_link(array('from_email'=>NOREPLY_EMAIL, 'from_name'=>SITE_GENERAL_NAME, 'to_email'=>$storeData['emailaddress'], 'first_name'=>$storeData['contactname'], 'clout_id'=>generate_system_id($this,$response['merchant_id'],'merchant'), 'merchant_id'=>$response['merchant_id'], 'business_name'=>$storeData['businessname'], 'contact_email'=>$storeData['contactemailaddress'], 'message_type'=>'signup_submission_notification')); 
			$response['message_sent'] = $confirmationResponse['message_sent'];
		}
		
		return $response;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	#Check whether a user with passed details exists in the database
	#Return user details from the database
	public function validate_user_login($queryData, $queryFlag='')
	{	
		#Encrypt to a format in the database
		$queryData['password'] = !empty($queryData['password'])? sha1($queryData['password']): '';
		
		if($queryFlag == 'ignore_active_flag')
		{
			$query = $this->query_reader->get_query_by_code('user_login_ignore_active', $queryData);
		}
		else if($queryFlag == 'user_data_by_email')
		{
			$query = $this->query_reader->get_query_by_code('get_user_list', array('search_string'=>" AND email_address='".$queryData['emailaddress']."' ", 'limittext'=>''));
		}
		else
		{ 
			$query = $this->query_reader->get_query_by_code('user_login', $queryData);
		}
		
		return $this->db->query($query)->row_array();
	}
	
	
	
	
	#Function to determine the user dashboard based on their type
	public function get_dashboard()
	{
		#The user type exists
		if(!empty($_SESSION['user_type']))
		{
			if($_SESSION['user_type'] == 'admin')
			{
				return base_url().'web/account/admin_dashboard';
			}
			else if($_SESSION['user_type'] == 'merchant')
			{
				return base_url().'web/account/merchant_dashboard';
			}
			else
			{
				return base_url().'web/account/normal_dashboard';
			}
		}
		#User type is not set
		else
		{
			$_SESSION['pmsg'] = "WARNING: You do not have priviledges to access this page.";
			return base_url().'web/account/logout/m/pmsg';
		}
	}
	
	
	
	#Function to get special pages to redirect a user based on their info and required page code
	public function get_special_route($routeCode, $userId='')
	{
		switch($routeCode) 
		{
    		case 'confirm_merchant':
        		return base_url().'web/account/merchant_signup/t/'.encrypt_value('confirm_merchant');
			break;
			
			
			
			default:
				return base_url();
			break;
		}
	}
	
	
	
	
	#Get a comment to show to the user about a special login route
	public function get_special_route_comment($routeCode, $userId='')
	{
		switch($routeCode) 
		{
    		case 'confirm_merchant':
        		return "Please login below to start your merchant account setup process.";
			break;
			
			
			
			default:
				return '';
			break;
		}
	}
	
	
	
	
	
	#Function to get the merchant details
	public function get_merchant_details($userId)
	{
		return $this->db->query($this->query_reader->get_query_by_code('get_merchant_by_user_id', array('user_id'=>$userId)))->row_array();
	}
	
	
	#Function to unset all variables sent in an array from the session
	public function unset_user_data($dataArray)
	{
		foreach($dataArray AS $key)
		{
			unset($_SESSION[$key]);
		}
	}
	
	
	
	#Function to get user bank accounts
	public function get_user_bank_accounts($userId, $accountType='saved', $accountStatus=array('active', 'pending'))
	{
		#Raw account data
		if($accountType == 'raw')
		{
			$bankAccounts = $this->db->query($this->query_reader->get_query_by_code('get_raw_account_list', array('raw_table_name'=>'raw_bank_accounts', 'user_id'=>$userId, 'query_part'=>"")))->result_array();
			$creditAccounts = $this->db->query($this->query_reader->get_query_by_code('get_raw_account_list', array('raw_table_name'=>'raw_credit_accounts', 'user_id'=>$userId, 'query_part'=>"")))->result_array();
			$investmentAccounts = $this->db->query($this->query_reader->get_query_by_code('get_raw_account_list', array('raw_table_name'=>'raw_investment_accounts', 'user_id'=>$userId, 'query_part'=>"")))->result_array();
			$loanAccounts = $this->db->query($this->query_reader->get_query_by_code('get_raw_account_list', array('raw_table_name'=>'raw_loan_accounts', 'user_id'=>$userId, 'query_part'=>"")))->result_array();
			$rewardAccounts = $this->db->query($this->query_reader->get_query_by_code('get_raw_account_list', array('raw_table_name'=>'raw_reward_accounts', 'user_id'=>$userId, 'query_part'=>"")))->result_array();
			
			return array('bank_account'=>$bankAccounts, 'credit_account'=>$creditAccounts, 'investment_account'=>$investmentAccounts, 'loan_account'=>$loanAccounts, 'reward_account'=>$rewardAccounts);
		}
		
		
		#Just the account IDs for the saved accounts
		else if($accountType  == 'saved_ids')
		{
			$accountList = $this->db->query($this->query_reader->get_query_by_code('get_user_bank_account', array('user_id'=>$userId, 'query_part'=>" AND status IN ('".implode("','", $accountStatus)."') ")))->result_array();
			$accountIds = array();
			
			#Collect the bank account IDs
			foreach($accountList AS $row)
			{
				array_push($accountIds, $row['account_id']);
			}
			
			return $accountIds;
		}
		
		#DEFAULT: The saved user bank data
		else 
		{
			return $this->db->query($this->query_reader->get_query_by_code('get_user_bank_account', array('user_id'=>$userId, 'query_part'=>" AND  status IN ('".implode("','", $accountStatus)."') ")))->result_array();
		}
	}
	
	
	
	
	
	#Function to link bank accounts by getting a summary of the account information needed to 
	#generate scores and link to other engines of the system
	public function link_bank_accounts($accountList, $userId)
	{
		$resultArray = array();
		
		#Now pull all raw data and process it to get a summary for the user account
		foreach($accountList AS $accountId)
		{
			$account = explode('_', $accountId);
			if($account[1] == 'bank' || $account[1] == 'other')
			{
				$details = $this->db->query($this->query_reader->get_query_by_code('get_raw_account_list', array('raw_table_name'=>'raw_bank_accounts', 'user_id'=>$userId, 'query_part'=>" AND account_id='".$account[0]."' ")))->row_array();
			}
			else if($account[1] == 'investment')
			{
				$details = $this->db->query($this->query_reader->get_query_by_code('get_raw_account_list', array('raw_table_name'=>'raw_investment_accounts', 'user_id'=>$userId, 'query_part'=>" AND account_id='".$account[0]."' ")))->row_array();
			}
			else if($account[1] == 'credit')
			{
				$details = $this->db->query($this->query_reader->get_query_by_code('get_raw_account_list', array('raw_table_name'=>'raw_credit_accounts', 'user_id'=>$userId, 'query_part'=>" AND account_id='".$account[0]."' ")))->row_array();
			}
			else if($account[1] == 'loan')
			{
				$details = $this->db->query($this->query_reader->get_query_by_code('get_raw_account_list', array('raw_table_name'=>'raw_loan_accounts', 'user_id'=>$userId, 'query_part'=>" AND account_id='".$account[0]."' ")))->row_array();
			}
			else if($account[1] == 'reward')
			{
				$details = $this->db->query($this->query_reader->get_query_by_code('get_raw_account_list', array('raw_table_name'=>'raw_reward_accounts', 'user_id'=>$userId, 'query_part'=>" AND account_id='".$account[0]."' ")))->row_array();
			}
			
			#Get the user's full name
			$user = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$userId)))->row_array();
			$userName = $user['first_name']." ".(!empty($user['middle_name'])? $user['middle_name']." ": '').$user['last_name'];
			
			#Get the account type in expected format
			if($account[1] == 'bank' || $account[1] == 'other')
			{
				$accountType = (!empty($details['banking_account_type']))? strtolower($details['banking_account_type']): 'other';
			}
			else
			{
				$accountType = $account[1];
			}
			
			#Add new bank account row to the summary bank account table
			$saveResult = $this->db->query($this->query_reader->get_query_by_code('add_bank_account', array('user_id'=>$userId, 'account_type'=>$accountType, 'account_id'=>$details['account_id'], 'account_number'=>$details['account_number'], 'bank_id'=>$details['institution_id'], 'issue_bank_name'=>$details['institution_name'], 'card_holder_full_name'=>$userName, 'account_nickname'=>$details['account_nickname'], 'currency_code'=>$details['currency_code'] )));
			
			array_push($resultArray, $saveResult);
		}
		
		
		
		
		return get_decision($resultArray, FALSE);
	}
	
	
	
	
	#Function to switch accounts between users
	public function switch_user_accounts($userId, $desiredAccount)
	{
		$newDashboard = "";
		
		#Check if the user's information can be pulled/pull linked accounts
		$currentUserDetails  = (!empty($_SESSION['email_address']))? $this->validate_user_login(array('emailaddress'=>$_SESSION['email_address']), 'user_data_by_email'): array();
		$linkedAccounts = (!empty($currentUserDetails['linkedaccounts']))? explode(",", $currentUserDetails['linkedaccounts']): array();
		
		#If the desired account exists
		if((!empty($linkedAccounts) && in_array($desiredAccount, $linkedAccounts)) || !empty($desiredAccount))
		{
			#Get the desired account information
			$desiredAccountDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$desiredAccount)))->row_array();
			
			if(!empty($desiredAccountDetails))
			{
				#Logout of current account
				if($this->remote_logout())
				{
					#login into desired account
					$loginResult = $this->remote_login($desiredAccountDetails);
				}
			}
		}
		
		$newDashboard = $this->get_dashboard();
		
		return $newDashboard;
	}
	
	
	#Function to login into a new account without UI/Controller access
	private function remote_login($accountDetails)
	{
		#These session keys should not be used for anything else while the user is active
		$forbiddenSessionKeys = array_keys($accountDetails);
					
		#Pick some more useful info for merchant/store user types
		if($accountDetails['user_type'] == 'merchant')
		{
			$merchantDetails = $this->get_merchant_details($accountDetails['userId']);
						
			$this->native_session->set('merchant_details', $merchantDetails);
			$forbiddenSessionKeys = array_merge($forbiddenSessionKeys, array_keys($merchantDetails));
		}
					
		#Add the user details to the session
		$this->native_session->set_array($accountDetails);
		$this->native_session->set('forbidden_session_keys', $forbiddenSessionKeys);
					
		#TODO: Log that the user successfully logged in
		
		return (!empty($_SESSION['userId'])? TRUE: FALSE);
	}
	
	#Function to log out of current account without UI/Controller access
	private function remote_logout()
	{
		$forbiddenSessionKeys = !empty($_SESSION['forbidden_session_keys'])? $_SESSION['forbidden_session_keys']: array();
		$this->unset_user_data($forbiddenSessionKeys);
		
		#TODO: Log that the user successfully logged out
		return (!empty($_SESSION['userId'])? FALSE: TRUE);
	}
	
	
	
	#Function to get the user referral URL IDs
	public function get_user_referral_url_ids($userId, $setCloutId=FALSE)
	{
		#URLS that the user can use to refer their friends
		$referralUrls = $this->db->query($this->query_reader->get_query_by_code('get_referral_url_ids', array('user_id'=>$userId, 'conditions'=>'')))->result_array();
		
		#Generate default referral URL if user has no URL
		if(empty($referralUrls) && $setCloutId)
		{
			#The generate system id function also indirectly updates the referral URLs database so that we can have a referral url for the user
			$cloutId = generate_system_id($this,$userId);
			$this->native_session->set('cloutId', $cloutId);
			#Try again to fetch the URLs
			$referralUrls = $this->db->query($this->query_reader->get_query_by_code('get_referral_url_ids', array('user_id'=>$userId, 'conditions'=>'')))->result_array();
		}
		
		return $referralUrls;
	}
	
	
	#Get the account application status
	public function get_application_status($applicationType, $referenceId)
	{
		switch($applicationType)
		{
			case 'merchant':
				if(empty($this->applicationStatus['merchant']))
				{
					$merchantStatus = $this->db->query($this->query_reader->get_query_by_code('get_merchant_application_status', array('merchant_id'=>$referenceId)))->row_array();
					$this->applicationStatus['merchant'] = !empty($merchantStatus)? $merchantStatus: array();
				}
				return $this->applicationStatus['merchant'];
			break;
			
			default:
				return array();
			break;
		}
	}
	
	
	
	
	
	
	#Check if a user has applied to become a merchant
	public function has_user_applied_to_become_merchant($userId, $status='pending')
	{
		$response = FALSE;
		
		$merchant = $this->db->query($this->query_reader->get_query_by_code('get_store_by_attributes', array('query_part'=>" S.merchant_id='".$userId."' " )))->row_array();
		$staff = $this->db->query($this->query_reader->get_query_by_code('get_staff_record', array('user_id'=>$userId, 'staff_status'=>$status, 'more_conditions'=>" AND S.store_id='".(!empty($merchant['id'])?$merchant['id']:'')."' " )))->row_array();
		
		if(!empty($staff))
		{
			$this->native_session->set('pending_merchant_application', 'Y');
			#Does the user have a saved record?
			if(!empty($merchant['id'])) 
			{
				$this->native_session->set('merchantId', $merchant['id']);
				$this->native_session->set('has_submitted_account', 'Y');
			}
			$response = TRUE;
		}
		
		return $response;
	}
	
	
	
	
	#Processes instructions sent through the redirections
	public function handle_redirection_instructions($data, $userId, $useSessions='N')
	{
		$results = array();
		#User wants to skip account linking
		if(($useSessions=='N' && !empty($data['skip_link_check'])) || ($useSessions=='Y' && $this->native_session->get('skip_link_check')) )
		{
			$results[0] = $this->db->query($this->query_reader->get_query_by_code('update_user_value', array('field_name'=>'skip_linking_account', 'field_value'=>'Y', 'user_id'=>$userId )));
			#Remove the session variable
			if($useSessions=='Y') $this->native_session->delete('skip_link_check');
		}
		
		#User requests addition of a bank
		if(($useSessions=='N' && !empty($data['bank_not_listed'])) || ($useSessions=='Y' && $this->native_session->get('bank_not_listed')) )
		{
			#Record the bank suggestion in the database
			$bankName = ($useSessions=='N' && !empty($data['bank_not_listed']) && !empty($data['bank_not_listed']))? $data['bank_not_listed']: ($useSessions=='Y' && $this->native_session->get('bank_not_listed')? $this->native_session->get('bank_not_listed'): '');
			
			$bankName = htmlentities(restore_bad_chars($bankName), ENT_QUOTES);
			$results[1] = $this->db->query($this->query_reader->get_query_by_code('add_institution_suggestion', array('name'=>$bankName, 'requested_by'=>$userId, 'request_notes'=>'' )));
			
			#Now send the email notificaiton to the admin user
			$userDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$userId )))->row_array();
			$results[2] = $this->sys_email->email_form_data(array('fromemail'=>$userDetails['email_address'], 'fromname'=>$userDetails['name']), get_confirmation_messages($this, array('emailaddress'=>SITE_ADMIN_MAIL, 'from_email'=>$userDetails['email_address'], 'from_name'=>$userDetails['name'], 'bank_name'=>$bankName), 'bank_suggestion')); 
		}
		
		
		return get_decision($results, FALSE);
	}
	
}


?>