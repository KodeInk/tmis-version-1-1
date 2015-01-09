<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls user account access.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 11/26/2013
 */
class Account extends CI_Controller 
{
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
        $this->load->model('scoring');
		$this->load->model('file_upload','libfileobj');
        $this->load->model('sys_file','sysfile');
		$this->load->model('search_manager');
		$this->load->model('account_manager');
		$this->load->model('plaid_data_import');
    }
	
	#Index Page for this controller.
	public function index()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this,array());
		
		$this->load->view('web/home', $data);
	}
	
	
	
	#Handles the login redirection for the system
	public function login()
	{
		$data = filter_forwarded_data($this, array(), array('c'));
		
		#Set a session variable for a URL instruction
		if(!empty($data['skip_link_check'])) $this->native_session->set('skip_link_check', 'Y');
		if(!empty($data['bank_not_listed'])) $this->native_session->set('bank_not_listed', $data['bank_not_listed']);
		
		#Get actual referrerid if the user was referred
		if(!empty($data['c']))
		{
			$userId = get_user_id_from_system_id($data['c']);
			$userDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$userId)))->row_array();
			
			#Activate the user if they are available
			if(!empty($userDetails))
			{
				if(!empty($userDetails['activation_email_sent']) && (strtotime('now') - strtotime($userDetails['activation_email_sent'])) < EXPIRY_PERIOD_FOR_EMAIL_LINK)
				{
					$result1 = $this->db->query($this->query_reader->get_query_by_code('update_user_value', array('user_id'=>$userDetails['id'], 'field_name'=>'email_verified', 'field_value'=>'Y')));
					$result2 = $this->db->query($this->query_reader->get_query_by_code('update_user_value', array('user_id'=>$userDetails['id'], 'field_name'=>'user_status', 'field_value'=>'active')));
					$result = get_decision(array($result1, $result2));
					#Remove details of this login if the user has successfully signed up
					if($result && !empty($_SESSION['registration']))
					{
						unset($_SESSION['registration']);
						#Now take the user to their dashboard
						redirect(switch_user_accounts($userDetails['id'], $userDetails['id']));
					}
				}
				else
				{
					$data['msg'] = "WARNING: Your activation link expired. Please <a href='javascript:;' onClick=\"updateFieldLayer('".base_url()."web/account/resend_activation_link/u/".encrypt_value($userDetails['id'])."','','','msg_div','')\" class='bluebold'>click here</a> to resend.";
				}
			}
			
			#formulate the message to show the user
			$data['msg'] = !empty($data['msg'])?$data['msg']:(!empty($result) && $result)? "Your account has been activated. Please login to continue":"ERROR: Your account could not be activated. <br>Please check the link and try again or contact us.";
		}
		
		#This is a merchant attempting to signup
		$data['msg'] = !empty($data['msg'])? $data['msg']: (!empty($data['t'])? $this->account_manager->get_special_route_comment(decrypt_value($data['t'])): '');
		
		
		#Process the login if the user submitted from the form
		if($this->input->post('login'))
		{
			$requiredFields = array('username*EMAIL_FORMAT', 'password');
			$_POST = clean_form_data($_POST);
			$validationResults = validate_form('', $_POST, $requiredFields);
			
			#Proceed if there were no errors during validation.
			#TODO: Add fail for multiple login attempts
			if($validationResults['bool'])
			{
				$userDetails = $this->account_manager->validate_user_login(array('emailaddress'=>$this->input->post('username'), 'password'=>$this->input->post('password') ));
				
				#If the user exists, populate the user details and forward to the appropriate page based on the user type
				if(!empty($userDetails))
				{
					#These session keys should not be used for anything else while the user is active
					$forbiddenSessionKeys = array_keys($userDetails);
					
					#Pick some more useful info for merchant/store user types
					if($userDetails['user_type'] == 'merchant')
					{
						$merchantDetails = $this->account_manager->get_merchant_details($userDetails['userId']);
						
						$this->native_session->set('merchant_details', $merchantDetails);
						$forbiddenSessionKeys = array_merge($forbiddenSessionKeys, array_keys($merchantDetails));
					}
					
					
					
					#Add the user details to the session
					$this->native_session->set_array($userDetails);
					$this->native_session->set('forbidden_session_keys', $forbiddenSessionKeys);
					
					$result = $this->account_manager->handle_redirection_instructions($data, $this->native_session->get('userId'), 'Y');
					
					#Determine where the user wants to go
					#Special actions require redirecting to specific pages besides the user dashboard
					if($this->input->post('specialaction'))
					{
						redirect($this->account_manager->get_special_route($this->input->post('specialaction')));
					}
					else
					{
						#Check if the user already has accounts or they need to pass by the linking accounts section
						$currentAccounts = $this->account_manager->get_user_bank_accounts($this->native_session->get('userId'));
						$fowardUrl = (!empty($currentAccounts) || ($_SESSION['user_type'] == 'admin') || (!empty($_SESSION['skip_linking_account']) && $_SESSION['skip_linking_account'] == 'Y'))? $this->account_manager->get_dashboard(): base_url().'web/account/link_accounts';
					}
					
					redirect($fowardUrl);
				}
				#There were errors during validation
				else
				{
					$data['msg'] = "WARNING: Please enter a valid email and password.";
					#TODO: For security, log user failed logins to prevent more than X guesses
				}
			}
			
			$data['msg'] = !empty($data['msg'])? $data['msg']: "WARNING: Please enter the fields highlighted to continue.";
			
			$data['requiredFields'] = $validationResults['requiredfields'];
			$data['formData'] = $_POST;
		}
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/account/login', $data);
	}
	
	
	
	
	#Function to resend the activation link
	public function resend_activation_link()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['u']))
		{
			$userData = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>decrypt_value($data['u']) )))->row_array();
			if(!empty($userData))
			{
				$response = $this->account_manager->send_user_an_activation_link(array('from_email'=>NOREPLY_EMAIL, 'from_name'=>SITE_GENERAL_NAME, 'to_email'=>$userData['email_address'], 'first_name'=>$userData['first_name'], 'clout_id'=>$userData['clout_id'], 'user_id'=>$userData['id']));
			}
			
			$data['msg'] = (!empty($response['message_sent']) && $response['message_sent'])? "The activation link has been resent.": "ERROR: The activation link could not be resent.";
		}
		else
		{
			$data['msg'] = "ERROR: The user account could not be found.<br>Please check the link and try again or contact us.";
		}
		
		$data['area'] = 'basic_msg';
		$this->load->view('web/addons/basic_addons', $data);
	}
	
	
	
	
	# Clears the current user's session and redirects to the login page
	public function logout()
	{	
		$data = filter_forwarded_data($this,array('i'));
		#TODO: Log that the user successfully logged out
		
		#Add a message if it does not already exist
		if(!empty($data['m']) && !empty($_SESSION[$data['m']]))
		{
			$data['msg'] = $_SESSION[$data['m']];
		}
		else
		{
			$data['msg'] = 'You have logged out.';
		}
		
		# Clear key session variables
		$forbiddenSessionKeys = !empty($_SESSION['forbidden_session_keys'])? $_SESSION['forbidden_session_keys']: array();
		$this->account_manager->unset_user_data($forbiddenSessionKeys);
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/account/login', $data);
	}
	
	
	
	#Redirect the normal user's dashboard
	public function normal_dashboard()
	{
		access_control($this);
		$data = filter_forwarded_data($this,array());
		
		$result = $this->account_manager->handle_redirection_instructions($data, $this->native_session->get('userId') );
		$searchHomeUrl = base_url().'web/search/show_search_home'.(!empty($data['m'])? '/m/'.$data['m']: '');
		redirect(get_slow_link_url($searchHomeUrl, 'Search', 'Refreshing store scores..'));
	}
	
	
	
	#Redirect the merchant user's dashboard
	public function merchant_dashboard()
	{
		access_control($this);
		$data = filter_forwarded_data($this,array());
		$result = $this->account_manager->handle_redirection_instructions($data, $this->native_session->get('userId') );
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/account/merchant_dashboard', $data);
	}
	
	
	#Redirect the admin user's dashboard
	public function admin_dashboard()
	{
		access_control($this, array('admin'));
		$data = filter_forwarded_data($this);
		
		redirect(base_url().'web/transactions/dashboard');
	}
	
	
	
	
	
	#Sign up as a new user
	public function signup()
	{
		# Get the passed details into the url data array if any
		#The third option is for handling re-routed data info
		$data = filter_forwarded_data($this, array(), array('u','t'));
		
		#Get actual referrerid if the user was referred
		if(!empty($data['u']))
		{
			$referrer = $this->db->query($this->query_reader->get_query_by_code('get_user_given_url_id', array('url_id'=>decrypt_value($data['u']) )))->row_array();
			
			if(!empty($referrer['user_id']))
			{
				$_SESSION['registration']['referrerid'] = $referrer['user_id'];
			}
		}
		
		#If a merchant is signing up
		if((!empty($data['t']) && $data['t'] == 'merchant') || ($this->native_session->get('in_signup') && $this->native_session->get('in_signup') == 'merchant'))
		{
			$_POST['usertype'] = "merchant";
		} 
		else
		{
			$_POST['usertype'] = "normal";
		}
		
		
				
		$_SESSION['registration']['emailaddress'] = !empty($data['email'])? restore_bad_chars($data['email']): '';
		
		#Create an account and confirm user details
		if($this->input->post('createaccount'))
		{
			$requiredFields = array('firstname', 'lastname', 'yourpassword*PASSWORD', 'emailaddress*EMAIL_FORMAT', 'gender', 'dateofbirth', 'zipcode');
			$_POST['dateofbirth'] = (!empty($_POST['month']) && !empty($_POST['day']) && !empty($_POST['year']))? $_POST['month']."/".$_POST['day']."/".$_POST['year']: '';
			$_POST = clean_form_data($_POST);
			$validationResults = validate_form('', $_POST, $requiredFields);
			
			#Proceed if there were no errors during validation.
			if($validationResults['bool'])
			{
				#Add values entered to session for future reference
				$_SESSION['registration']['firstname'] = $_POST['firstname'];
				$_SESSION['registration']['lastname'] = $_POST['lastname'];
				$_SESSION['registration']['yourpassword'] = sha1($_POST['yourpassword']);
				$_SESSION['registration']['emailaddress'] = $_POST['emailaddress'];
				$_SESSION['registration']['gender'] = $_POST['gender'];
				$_SESSION['registration']['dateofbirth'] = $_POST['dateofbirth'];
				$_SESSION['registration']['zipcode'] = $_POST['zipcode'];
				$_SESSION['registration']['usertype'] = $_POST['usertype'];
				
				#Save the registration data
				#Send confirmation email to the user's registered email address
				$result = $this->account_manager->create_new_user($_POST);
				$data['userId'] = $result['user_id'];
				
				if(!empty($data['userId']) && $_POST['usertype'] == 'merchant') 
				{
					$merchantResult = $this->db->query($this->query_reader->get_query_by_code('add_staff_member', array('user_id'=>$data['userId'], 'store_id'=>'', 'first_name'=>htmlentities($_POST['firstname']), 'middle_name'=>'', 'last_name'=>htmlentities($_POST['lastname']),'email_address'=>strtolower($_POST['emailaddress']), 'phone_number'=>'', 'department'=>'', 'hire_date'=>'', 'activation_date'=>date('Y-m-d H:i:s', strtotime('now')), 'permission_group'=>'2', 'end_date'=>'' )));
				}
				
				#Show the confirmation page
				$data['signup_confirmation'] = "RECEIVED";
				
				#If there was an error the user needs to address, show that instead
				if(!empty($result['error_msg']))
				{
					$data['signupError'] = "signup_error";
					$data['msg'] = $result['error_msg'];
				}
				else
				{	
					#Show the confirmation message if all went well
					$data['msg'] = $result['user_created']? "Your user account has been created.": "ERROR: Your user account could not be created.";
					$data['msg'] .= $result['message_sent']? "": "<BR><span class='error'>However, an activation link could not be sent to your email.</span>";
				}
			}
			else
			{
				$data['msg'] = "WARNING: Please enter the fields highlighted to continue.";
			
				$data['requiredFields'] = $validationResults['requiredfields'];
				if(!empty($data['requiredFields']) && !in_array('yourpassword', $data['requiredFields']))
				{
					array_push($data['requiredFields'], 'yourpassword');
				}
				$data['formData'] = $_POST;
			}
			
		}
		
		$this->load->view('web/account/signup', $data);
	}
	
	
	
	
	#Signs up new merchant users
	public function merchant_signup()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		$this->native_session->set('in_signup', 'merchant');
		$data['applicationStatus'] = $this->native_session->get('merchantId')? $this->account_manager->get_application_status('merchant', $this->native_session->get('merchantId')): array();
		
		#The merchant has signed up with an account and they are ready to start registration
		if(!empty($data['t']))
		{
			#From first step of merchant registration process
			if($this->input->post('gotostep2'))
			{
				$requiredFields = array('businessname', 'addressline1', 'city', 'zipcode', 'state', 'country', 'telephone', 'emailaddress*EMAIL_FORMAT', 'employeeno', 'annualrevenue', 'contactname', 'contacttitle', 'contacttelephone', 'contactemailaddress*EMAIL_FORMAT');
				if(empty($_POST['howdoyousell'])) array_push($requiredFields, 'howdoyousell');
				if(empty($_POST['categories'])) array_push($requiredFields, 'typeofbusiness');
				
				$_POST = clean_form_data($_POST);
				$validationResults = validate_form('', $_POST, $requiredFields);
			
				#Proceed if there were no errors during validation.
				if($validationResults['bool'])
				{
					#Save the merchant registration data
					$registrationResult = $this->account_manager->create_new_merchant($_POST);
					
					$data['merchantId'] = $registrationResult['merchant_id'];
					$this->native_session->set('merchantId', $data['merchantId']);
					
					
					#If the merchant ID is given, then add the merchant sales channels
					if(!empty($registrationResult['merchant_id']) && !empty($_POST['howdoyousell']))
					{
						foreach($_POST['howdoyousell'] AS $salesChannel)
						{
							$howMany = !empty($_POST[$salesChannel.'_howmany'])? $_POST[$salesChannel.'_howmany']: '0';
							$result = $this->db->query($this->query_reader->get_query_by_code('add_store_sales_channel', array('merchant_id'=>$registrationResult['merchant_id'], 'sales_channel'=>$salesChannel, 'how_many'=>$howMany, 'portion_of_sales'=>(!empty($_POST[$salesChannel.'_percentofsales'])? $_POST[$salesChannel.'_percentofsales']: '0'), 'is_confirmed'=>'N')));
							
							#Update the store to reflect that the store has multiple locations
							if($howMany > 1)
							{
								$result = $this->db->query($this->query_reader->get_query_by_code('update_store_value', array('field_name'=>'has_multiple_locations', 'field_value'=>'Y', 'store_id'=>$registrationResult['merchant_id'])));
							}
							#Note that this is an online only merchant
							if($salesChannel == 'online' && !empty($_POST[$salesChannel.'_percentofsales']) && $_POST[$salesChannel.'_percentofsales'] == '100')
							{
								$result = $this->db->query($this->query_reader->get_query_by_code('update_store_value', array('field_name'=>'online_only', 'field_value'=>'Y', 'store_id'=>$registrationResult['merchant_id'])));
							}
						}
					}
					#If the merchant ID is given, then add the merchant's categories
					if(!empty($registrationResult['merchant_id']) && !empty($_POST['categories']))
					{
						$merchantAdded = $systemAdded = array();
						#categorize the merchants based on the type of category
						foreach($_POST['categories'] AS $category)
						{
							$categoryDetails = explode('<>', html_entity_decode($category)); 
							if(!empty($categoryDetails[2]) || $categoryDetails[2] == '0')
							{
								array_push($systemAdded, $categoryDetails[2]);
							}
							else
							{
								array_push($merchantAdded, $categoryDetails[0].'<>'.$categoryDetails[1]);
							}
						}
						#Update with the new search tags
						$result1 = $this->db->query($this->query_reader->get_query_by_code('update_store_value', array('field_name'=>'system_category_tags', 'field_value'=>implode(',', $systemAdded), 'store_id'=>$registrationResult['merchant_id'] )));
						$result2 = $this->db->query($this->query_reader->get_query_by_code('update_store_value', array('field_name'=>'user_category_tags', 'field_value'=>implode('|', $merchantAdded), 'store_id'=>$registrationResult['merchant_id'] )));
					}
					
					
					#If there was an error the user needs to address, show that instead
					if(!empty($registrationResult['error_msg']))
					{
						$data['signupError'] = "signup_error";
						$data['msg'] = $registrationResult['error_msg'];
					}
					else
					{	
						#Show the confirmation message if all went well
						$data['msg'] = $registrationResult['merchant_created']? "Your merchant account has been created.": "ERROR: Your merchant account could not be created.";
						$data['msg'] .= $registrationResult['message_sent']? "": ($registrationResult['merchant_created']?"<BR><span class='error'>However, an activation link could not be sent to your email.</span>":'');
						#The merchant is created. Continue to the next step
						if($registrationResult['merchant_created'])
						{
							#Now reflect that they created their account
							$this->native_session->set('has_submitted_account', 'Y');
							$this->native_session->set('merchantId', $registrationResult['merchant_id']);
							#..and also update their staff record
							$result3 = $this->db->query($this->query_reader->get_query_by_code('update_staff_value', array('field_name'=>'store_id', 'field_value'=>$registrationResult['merchant_id'], 'user_id'=>$this->native_session->get('userId') )));
							
							
							$this->native_session->set('mmsg', $data['msg']);
							redirect(base_url().'web/account/'.((!empty($_POST['instore_howmany']) && ($_POST['instore_howmany']+0) > 1)? 'add_store_locations/n/'.encrypt_value($_POST['instore_howmany']): 'add_store_competitors')."/m/mmsg");
						}
					}
				}
				
				$data['msg'] = empty($data['msg'])?"WARNING: Please enter the fields highlighted to continue.":$data['msg'];
			
				$data['requiredFields'] = $validationResults['requiredfields'];
				$data['formData'] = $_POST;
			}
			
			#Merchant saved the profile. Get it.
			else if($this->native_session->get('has_submitted_account') && !empty($data['t']) && decrypt_value($data['t']) == 'saved_profile')
			{
				$data['formData'] = array();
				
				#Store profile
				$store = $this->db->query($this->query_reader->get_query_by_code('get_store_by_attributes', array('query_part'=>" S.id ='".$this->native_session->get('merchantId')."' " )))->row_array();
				$data['formData']['businessname'] = $store['name'];
				$data['formData']['emailaddress'] = $store['email_address'];
				$data['formData']['addressline1'] = $store['address_line_1'];
				$data['formData']['city'] = $store['city'];
				$data['formData']['businesswebsite'] = $store['website'];
				$data['formData']['statecode'] = $store['state'];
				$data['formData']['state'] = $store['state_name'];
				$data['formData']['zipcode'] = $store['zipcode'];
				$data['formData']['countrycode'] = $store['country'];
				$data['formData']['country'] = $store['country_name'];
				$data['formData']['telephone'] = format_phone_number($store['phone_number']);
				$data['formData']['employeeno'] = $store['employee_number'];
				$data['formData']['annualrevenue'] = $store['estimated_annual_revenue'];
				$data['formData']['pricerange'] = $store['price_range'];
				$data['formData']['contactname'] = $store['primary_contact_name'];
				$data['formData']['contacttitle'] = $store['primary_contact_title'];
				$data['formData']['contacttelephone'] = format_phone_number($store['primary_contact_phone']);
				$data['formData']['contactemailaddress'] = $store['primary_contact_email'];
				$data['formData']['businessnameclaimid'] = $store['claimed_company_id'];
				
				#Store sales channels
				$channels = $this->db->query($this->query_reader->get_query_by_code('get_store_sales_channels', array('merchant_id'=>$this->native_session->get('merchantId') )))->result_array();
				$data['formData']['howdoyousell'] = array();
				foreach($channels AS $row)
				{
					array_push($data['formData']['howdoyousell'], $row['sales_channel']);
					$data['formData'][$row['sales_channel']."_howmany"] = $row['how_many'];
					$data['formData'][$row['sales_channel']."_percentofsales"] = $row['portion_of_sales'];
				}
				
				#Add the sub categories
				$subCategoriesTags = array();
				#SYSTEM TAGS
				if(!empty($store['system_category_tags']))
				{
					$subCategories = $this->db->query($this->query_reader->get_query_by_code('get_sub_categories', array('category_ids'=>"'".implode("','", explode(',', $store['system_category_tags']))."'" )))->result_array();
					foreach($subCategories AS $categoryRow)
					{
						array_push($subCategoriesTags, array('category'=>$categoryRow['category'], 'subcategory'=>$categoryRow['subcategory'], 'subcategoryid'=>$categoryRow['id']));
					}
				}
				
				#USER TAGS
				if(!empty($store['user_category_tags']))
				{
					$userTags = explode('|', $store['user_category_tags']);
					foreach($userTags AS $tag)
					{
						$tagParts = explode('<>', $tag);
						array_push($subCategoriesTags, array('category'=>$tagParts[0], 'subcategory'=>$tagParts[1], 'subcategoryid'=>''));
					}
					
				}
				#Add the subcategories to the session
				$this->native_session->set('new_business_category', $subCategoriesTags);
			}
			
			
			
			$this->load->view('web/account/merchant_signup', $data);
		}
		#Just come to the merchant signup page
		else
		{
			redirect(base_url().'web/account/signup/t/merchant');
		}
	}
	
	
	
	
	#Function to add store locations
	public function add_store_locations()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		
		#Add the address and temporarily show the added locations
		if(!empty($data['a']) && $data['a'] == 'add_one')
		{
			$locationList = $this->native_session->get('location_list')? $this->native_session->get('location_list'): array();
			#Add the new location address
			array_push($locationList, array('storename'=>$data['storename'], 'storeid'=>(!empty($data['storeid'])?$data['storeid']:''), 'addressline1'=>$data['addressline1'] , 'city'=>$data['city'] , 'zipcode'=>$data['zipcode'], 'state'=>$data['state'], 'statecode'=>$data['statecode'], 'country'=>$data['country'], 'countrycode'=>$data['countrycode'], 'telephone'=>$data['telephone'], 'emailaddress'=>$data['emailaddress']    ));
			$data['locationList'] = $locationList;
			$this->native_session->set('location_list', $locationList);
			$data['msg'] = 'The location has been added.';
			
			$data['area'] = "show_store_location_list";
			$view = 'web/addons/basic_addons';
		}
		#Set the number of stores to track the locations added
		if(!empty($data['n']))
		{
			$this->native_session->set('locations_count', decrypt_value($data['n']));
		}
		
		#If the user has already saved the application
		if($this->native_session->get('has_submitted_account'))
		{
			$storeLocations = $this->db->query($this->query_reader->get_query_by_code('get_store_location_by_attribute', array('field_name'=>'owner_merchant_id', 'field_value'=>$this->native_session->get('merchantId') )))->result_array();
			
			$locationList = array();
			foreach($storeLocations AS $data)
			{
				array_push($locationList, array('storename'=>html_entity_decode($data['store_name'], ENT_QUOTES), 'storeid'=>(!empty($data['display_store_id'])?$data['display_store_id']:''), 'addressline1'=>$data['address'] , 'city'=>html_entity_decode($data['city'], ENT_QUOTES) , 'zipcode'=>$data['zipcode'], 'state'=>html_entity_decode($data['state_name'], ENT_QUOTES), 'statecode'=>$data['state'], 'country'=>html_entity_decode($data['country_name'], ENT_QUOTES), 'countrycode'=>$data['country'], 'telephone'=>format_phone_number($data['telephone']), 'emailaddress'=>$data['emailaddress']    ));
			}
			$this->native_session->set('location_list', $locationList);
		}
		
		$data['applicationStatus'] = $this->native_session->get('merchantId')? $this->account_manager->get_application_status('merchant', $this->native_session->get('merchantId')): array();
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view(!empty($view)? $view: 'web/account/store_locations', $data);
	}
	
	
	
	#Function to remove location address
	public function remove_location_address()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		
		$locationList = $this->native_session->get('location_list')? $this->native_session->get('location_list'): array();
		
		if(!empty($data['l']) && $data['l'] == 'all')
		{
			$this->native_session->set('location_list', array());
			$data['locationList'] = array();
			$data['msg'] = 'All locations have been removed.';
		}
		#Remove the selected location address
		else
		{
			unset($locationList[$data['l']]);
			$this->native_session->set('location_list', $locationList);
			$data['locationList'] = $locationList;
			$data['msg'] = 'The location has been removed.';
		}
		
		$data['area'] = "basic_msg";
		$this->load->view('web/addons/basic_addons', $data); 
	}
	
	
	
	
	
	
	#The link accounts page
	public function link_accounts()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		
		$data['featuredBanks'] = $this->db->query($this->query_reader->get_query_by_code('get_featured_banks', array('limit_text'=>" LIMIT 0, 20;")))->result_array();
		$data['currentBanks'] = $this->db->query($this->query_reader->get_query_by_code('get_user_banks', array('user_id'=>$this->native_session->get('userId'), 'is_verified_list'=>"'Y'")))->result_array();
		
		$data['userDashboard'] = $this->account_manager->get_dashboard();
		
		$this->load->view('web/account/link_accounts', $data);
	}
	
	
	
	#The network page
	public function network()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/account/network', $data);
	}
	
	
	
	#The tools page
	public function tools()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/account/tools', $data);
	}
	
	
	
	#The profile page
	public function profile()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/account/profile', $data);
	}
	
	
	
	
	
	#Forgot password
	public function forgot_password()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this, array(), array('p'));
		
		#Send link to user's registered email if they exist in the system
		if($this->input->post('sendlink'))
		{
			 $email = $this->input->post('emailaddress');
			 if(filter_var($email, FILTER_VALIDATE_EMAIL))
			 {
				 $userData = $this->db->query($this->query_reader->get_query_by_code('get_users_by_field_value', array('field_name'=>'email_address', 'field_value'=>$email) ))->row_array();
				 
				 if(!empty($userData))
				 {
					 $result = $this->account_manager->send_user_an_activation_link(array('from_email'=>NOREPLY_EMAIL, 'from_name'=>SITE_GENERAL_NAME, 'to_email'=>$userData['email_address'], 'first_name'=>$userData['first_name'], 'clout_id'=>generate_system_id($this,$userData['id']), 'user_id'=>$userData['id'], 'message_type'=>'forgot_password_link'));
					 
					 if($result['message_sent'])
					 {
						 $data['msg'] = "A password recovery link has been sent to your email address. Please click on it to set a new password.<br>This link will expire in 1 hour.";
					 }
					 else
					 {
						 $data['msg'] = "ERROR: There was an error sending to your email address. Please try again or contact us.";
					 }
				 }
				 else
				 {
					 $data['msg'] = "WARNING: There is no user registered with that email address.";
				 }
			 }
			 else
			 {
				 $data['msg'] = "WARNING: Invalid email address.";
			 }
		}
		
		
		#User has just come back from their email to update the password
		if(!empty($data['p']))
		{
			$data['msg'] = "Please enter your new password in the fields below.";
			$data['linkIsSent'] = TRUE;
			$data['cloutId'] = trim($data['p']);
		}
		
		
		#The user is attempting to update their password
		if($this->input->post('updatepassword'))
		{
			$requiredFields = array('newpassword*PASSWORD', 'repeatpassword*SAME<>newpassword');
			$_POST = clean_form_data($_POST);
			$validationResults = validate_form('', $_POST, $requiredFields);
			$data['linkIsSent'] = TRUE;
			$data['cloutId'] = $_POST['cloutid'];
			
			#Proceed if there were no errors during validation.
			if($validationResults['bool'])
			{
				#Update password using the user's ID
				$result = $this->db->query($this->query_reader->get_query_by_code('update_user_value', array('field_name'=>'password', 'field_value'=>sha1($_POST['newpassword']), 'user_id'=>get_user_id_from_system_id($_POST['cloutid'])) ));
				
				if($result)
				{
					$_SESSION['lmsg'] = "Your password update was successful. Please login below to continue.";
					redirect(base_url()."web/account/login/m/lmsg");
				} 
				else
				{
					$data['msg'] = "WARNING: The password could not be updated.";
				}
			}
			else
			{
				$data['msg'] = "WARNING: Please enter the fields highlighted to continue.";
			
				$data['requiredFields'] = array('newpassword','repeatpassword');
				$data['formData'] = $_POST;
			}
			
		}
		
		$this->load->view('web/account/forgot_password', $data);
	}
	
	
	#The show the bank login form
	public function show_bank_login()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this,array());
		
		if(!empty($data['n'])) $this->native_session->set('login_institution', decrypt_value($data['n']));
		if(!empty($data['i'])) $this->native_session->set('login_institution_id', decrypt_value($data['i']));
		if(!empty($data['c'])) $this->native_session->set('login_institution_code', decrypt_value($data['c']));
		
		$data['response'] = $this->plaid_data_import->format_extra_login_for_display(array('code'=>'initiate'));
		$data['area'] = "connection_result";
		$this->load->view('web/addons/account_views', $data);
	}
	
	
	#Submit the bank details for processing
	public function submit_bank_details()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this,array());
		
		$userName = restore_bad_chars($data['username']);
		$password = restore_bad_chars($data['bankpassword']);
		$bankName = decrypt_value($data['bn']);
		
		$this->load->helper('intuit_agg_cat_helper');
		#Get the Auth tokens for the connection
		#$oauthTokens = IntuitAggCatHelpers::GetOAuthTokens();
		
		#TODO:
		#1. a) Generate the XML for the sending the credentials
		#1. b) Handle further security checks
		
		#2. Process the response
		
		#3. Get all the accounts based on the login details
		
		#4. Prepare the accounts for display
		
		#REMOVE THIS: For demo purposes only
		if(!empty($data['b']) && in_array(decrypt_value($data['b']), array('14007', '23284')))
		{
			$data['bankid'] = decrypt_value($data['b']);
			$accounts['14007'] = array('bank_name'=>'Bank of America', 'account_list'=>array(
									array('account_nickname'=>'My Savings', 'account_number'=>'5012298756111', 'account_number_real'=>'05012298756111'),
									array('account_nickname'=>'My Checking Only', 'account_number'=>'5012298794512', 'account_number_real'=>''),
									array('account_nickname'=>'Joint Checking For Family', 'account_number'=>'1501229818457', 'account_number_real'=>'')
								));
								
			$accounts['23284'] = array('bank_name'=>'Wells Fargo', 'account_list'=>array(
									array('account_nickname'=>'Personal Business', 'account_number'=>'50122987569008', 'account_number_real'=>''),
									array('account_nickname'=>'Kids Spending Account', 'account_number'=>'1501229800195', 'account_number_real'=>'')
								));
								
			$bankAccounts = $accounts[$data['bankid']];
			
		}
		#-----------------------END OF REMOVE--------------------------------
		
		#unset($_SESSION['current_accounts']);
		#unset($_SESSION['added_banks']);
		#Add any accounts verified to the list
		$fullAccountList = (!empty($_SESSION['current_accounts']))? $_SESSION['current_accounts']: array();
		$addedBanks = (!empty($_SESSION['added_banks']))? $_SESSION['added_banks']: array();
		
		if(!empty($bankAccounts) && !in_array($data['bankid'], $addedBanks))
		{
			array_unshift($fullAccountList, $bankAccounts);
			array_push($addedBanks, $data['bankid']);
			
			#Update the session array
			$_SESSION['current_accounts'] = $fullAccountList;
			$_SESSION['added_banks'] = $addedBanks;
		}
		else
		{
			$data['msg'] = (!empty($data['bankid']) && in_array($data['bankid'], $addedBanks))? "WARNING: This bank's accounts have already been added.": "ERROR: No accounts could be verified with ".html_entity_decode($bankName);
		}
		#print_r($fullAccountList);
		
		$data['area'] = "qualified_accounts_list";
		$this->load->view('web/addons/account_views', $data);
	}
	
	
	
	
	#Function to switch accounts for a given user
	public function switch_my_account()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		$desiredAccount = decrypt_value($data['a']);
		$newDashboard = $this->account_manager->switch_user_accounts($_SESSION['userId'], $desiredAccount);
		
		#Switch was successful
		if(!empty($newDashboard))
		{
			redirect($newDashboard);
		}
		else
		{
			$_SESSION['fmsg'] = "ERROR: Account details could not be resolved.";
			redirect($this->account_manager->get_dashboard()."/m/fmsg");
		}
	} 
	
	
	
	#Function to add a category (in session) for a merchant user signing up
	public function add_merchant_category()
	{
		$data = filter_forwarded_data($this);
		#Recreate the category list session variable if it is not available
		$data['categories'] = $this->native_session->get('new_business_category')? $this->native_session->get('new_business_category'): array();
		
		#user is deleting the category
		if(!empty($data['a']) && $data['a'] == 'remove' && (!empty($data['c']) || $data['c'] == '0'))
		{
			unset($data['categories'][$data['c']]);
			$data['msg'] = "Business category removed";
		}
		#user is adding a new category
		else if(!empty($data['businesscategory']) && !empty($data['businesssubcategory']))
		{
			array_push($data['categories'], array('category'=>$data['businesscategory'], 'subcategory'=>$data['businesssubcategory'], 'subcategoryid'=>(!empty($data['businesssubcategory__id'])?$data['businesssubcategory__id'] :'') ));
			$data['msg'] = "Business category added";
		}
		
		$this->native_session->set('new_business_category',$data['categories']);
		
		$data['area'] = 'temporary_category_list';
		$this->load->view('web/addons/basic_addons', $data);
	}
	
	
	
	
	#Function to load locations from a file
	public function load_locations_from_file()
	{
		$data = filter_forwarded_data($this);
		$this->native_session->set('local_allowed_extensions', array('.csv'));
		
		#Continue to upload if a file was actually uploaded
		if(!empty($_FILES) && !empty($data['s']))
		{
			$fileFolder = (!empty($data['f'])? $data['f']: 'documents');
			$newFileName = 'upload_'.strtotime('now');
			$documentUrl = !empty($_FILES[$data['s']]['name'])? $this->sysfile->local_file_upload($_FILES[$data['s']], $newFileName, $fileFolder, 'filename'): '';
			$finalArray = array();
			$fieldList = array('storename', 'storeid', 'addressline1', 'city', 'zipcode', 'state', 'country', 'telephone', 'emailaddress');
			
			#Now pick the locations from the file
			$fileUrl = UPLOAD_DIRECTORY.$fileFolder."/".$newFileName.'.csv';
			if(($handle = fopen($fileUrl, "r")) !== FALSE) 
			{
				#Pick locations one at a time
				$counter = 0;
				while (($data = fgetcsv($handle, 0, ",")) !== FALSE) 
				{
        			#Skip the first row and only enter values where fields are properly formatted
					$numberOfFields = count($data);
					if($counter > 0 && $numberOfFields == 9)
					{
						$rowArray = array();
						for ($i=0; $i < $numberOfFields; $i++) 
						{
            				$rowArray[$fieldList[$i]] = $data[$i];
							if($fieldList[$i] == 'state') $rowArray['statecode'] = $data[$i];
							if($fieldList[$i] == 'country') $rowArray['countrycode'] = $data[$i];
       					}
						array_push($finalArray, $rowArray);
					}
					
					$counter++;
    			}
    			fclose($handle);
			}
			
			if(!empty($finalArray))
			{
				$this->native_session->set('location_list', $finalArray);
			}
			$data['locationList'] = $finalArray;
		}
		#format the return message
		$data['msg'] = !empty($documentUrl)? "Document uploaded":"WARNING: Invalid document Format.";
		$data['area'] = 'show_store_location_list';
		$this->load->view('web/addons/basic_addons', $data);
	}
	
	
	
	
	
	
	
	#Function to remove location address
	public function add_store_competitors()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		$data['applicationStatus'] = $this->native_session->get('merchantId')? $this->account_manager->get_application_status('merchant', $this->native_session->get('merchantId')): array();
		
		#Record any entered location details if the user is not skipping the previous step
		if(empty($data['t']) && $this->native_session->get('location_list'))
		{
			$locations = $this->native_session->get('location_list');
			
			#First remove the previous locations
			$result = $this->db->query($this->query_reader->get_query_by_code('remove_store_locations', array('owner_user_id'=>$this->native_session->get('userId'), 'owner_merchant_id'=>$this->native_session->get('merchantId') )));
			
			foreach($locations AS $location)
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('add_store_location', array('owner_user_id'=>$this->native_session->get('userId'), 'owner_merchant_id'=>$this->native_session->get('merchantId'), 'display_store_id'=>(!empty($location['storeid'])? htmlentities($location['storeid'], ENT_QUOTES): ''), 'store_name'=>htmlentities($location['storename'], ENT_QUOTES), 'address'=>htmlentities($location['addressline1'], ENT_QUOTES), 'city'=>htmlentities($location['city'], ENT_QUOTES), 'state'=>$location['statecode'], 'country'=>$location['countrycode'], 'zipcode'=>remove_string_special_characters($location['zipcode']), 'telephone'=>remove_string_special_characters($location['telephone']), 'emailaddress'=>$location['emailaddress'], 'status'=>'pending' ))); 
			}
			
			$this->native_session->delete('location_list');
		}
		#Skip the saving of competitors
		else if(!empty($data['t']) && decrypt_value($data['t']) == 'skip_to_dashboard')
		{
			$this->native_session->set('smsg', 'Your merchant application has been submitted for approval.');
			redirect($this->account_manager->get_dashboard().'/m/smsg');
		}
		
		#The user is saving the competitors
		if(!empty($_POST['competitor_ids']))
		{
			#First remove the previous competitors
			$result = $this->db->query($this->query_reader->get_query_by_code('remove_store_competitors', array('store_id'=>$this->native_session->get('merchantId') )));
			
			$results = array();
			foreach($_POST['competitor_ids'] AS $id)
			{
				array_push($results, $this->db->query($this->query_reader->get_query_by_code('add_competitor_from_store', array('store_id'=>$this->native_session->get('merchantId'), 'competitor_id'=>$id, 'price_level'=>(!empty($_POST['competitor_price_'.$id])? $_POST['competitor_price_'.$id]: '0') ))) );
			}
			
			$msg = get_decision($results)? 'Your merchant application has been submitted for approval.': 'ERROR: There was a problem saving the competitors. Your application was still submitted.<br>You will have a chance to resubmit them if your application is approved.';
			$this->native_session->set('smsg', $msg);
			redirect($this->account_manager->get_dashboard().'/m/smsg');
		}
		
		
		#The saved competitors for the current company
		$data['currentCompetitors'] = $this->db->query($this->query_reader->get_query_by_code('get_store_competitors', array('store_id'=>$this->native_session->get('merchantId') )))->result_array();
		
		#Get the store potential competitors
		$data['competitors'] = $this->search_manager->get_store_competitors($this->native_session->get('merchantId'), $this->search_manager->collectListAttribute('competitor_id', $data['currentCompetitors']) );
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/account/add_store_competitors', $data);
	}
	
	
	
	#Remove store competitor
	public function remove_competitor()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		
		if(!empty($data['d']) && $this->native_session->get('competitor_list'))
		{
			$competitors = $this->native_session->get('competitor_list');
			unset($competitors[decrypt_value($data['d'])]);
			$this->native_session->set('competitor_list', $competitors);
			
			$data['msg'] = "Competitor has been removed";
		}
		
		
		$data = add_msg_if_any($this, $data); 
		$data['area'] = 'application_competitor_list';
		$this->load->view('web/addons/basic_addons', $data);
	}
	
	
	
	
	
	
	#Start from where the user stopped while filing a merchant application
	public function complete_merchant_application()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		#Determine where to start the merchant applicant: Adding locations or Competitors
		if($this->native_session->get('has_submitted_account') && $this->native_session->get('merchantId'))
		{
			$locationNumber = $this->db->query($this->query_reader->get_query_by_code('get_number_of_store_locations', array('merchant_id'=>$this->native_session->get('merchantId') )))->row_array();
			$storeLocations = $this->db->query($this->query_reader->get_query_by_code('get_store_location_by_attribute', array('field_name'=>'owner_merchant_id', 'field_value'=>$this->native_session->get('merchantId') )))->result_array();
			
			if(!empty($locationNumber['number']) && $locationNumber['number'] > 1 && $locationNumber['number'] > count($storeLocations))
			{
				redirect(base_url().'web/account/add_store_locations');
			}
			else
			{
				redirect(base_url().'web/account/add_store_competitors');
			}
		}
		#Start from the first profile page
		else
		{
			redirect(base_url().'web/account/merchant_signup/t/'.encrypt_value('start_application'));
		}
		
		#Take them back to the dashboard if everything else failed
		redirect($this->account_manager->get_dashboard());
	}
	
	
	
	
	#Function to suggest a bank addition
	public function suggest_bank_addition()
	{
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		
		#Now record the bank addition
		$data['result'] = $this->account_manager->handle_redirection_instructions($data, $this->native_session->get('userId'));
		
		$data['area'] = 'suggestion_result';
		$this->load->view('web/addons/basic_addons', $data);
	}
	
}

/* End of controller file */