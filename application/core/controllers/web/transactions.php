<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls showing user scores.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 12/13/2013
 */
class Transactions extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
        $this->load->model('data_import');
		$this->load->model('plaid_data_import');
		$this->load->model('account_manager');
		$this->load->model('transaction_manager');
	}
	
	
	
	
	#Get the transaction data
	public function dashboard()
	{
		$data = filter_forwarded_data($this);
		
		$data['transactionList'] = $this->plaid_data_import->get_live_transactions(array(), array('itemsPerPage'=>20));
		
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/transactions/transactions_home', $data);
	}
	
	
	
	
	#Load list without reloading the page
	public function load_transaction_list()
	{
		$data = filter_forwarded_data($this);
		
		$data = add_msg_if_any($this, $data);
		$data['area'] = "transactions_list"; 
		$this->load->view('web/addons/list_addons', $data);
	}
	
	
	
	
	
	
	#Import data from the specified source
	public function import_data()
	{
		$data = filter_forwarded_data($this);
		
		#User has sent import instructions
		if(!empty($data['datatype']))
		{
			if($data['datatype'] == 'institutions')
			{
				redirect(base_url().'web/transactions/pull_institution_data');
			}
			
		}
		
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/transactions/import_data', $data);
	}
	
	
	#Pull institution data
	public function pull_institution_data()
	{
		$data = filter_forwarded_data($this);
		$this->load->helper('intuit_agg_cat_helper');
		#Get the Auth tokens for the connection
		$oauthTokens = IntuitAggCatHelpers::GetOAuthTokens();
		
		#Get the data from the intuit API
		$data['xmlObj'] = $this->data_import->get_data_by_api($oauthTokens, FINANCIAL_FEED_URL .'v1/institutions', 600, '', 'institutions'); 
		
	
		$data['area'] = "institution_results";
		$this->load->view('web/addons/import_data_view', $data);
	}
	
	
	#Import institution data
	public function import_institution_data()
	{
		$result = $this->data_import->move_raw_data('institutions');
		$data['msg'] = $result? "The institutions have been imported": "ERROR: There were issues with the data import.";
		
		$data['area'] = "import_results";
		$this->load->view('web/addons/result_view', $data);
	}
	
	
	#Get the accounts for the given user
	public function get_accounts()
	{
		$data = filter_forwarded_data($this);
		$data['xmlObj'] = array();
		
		#The user is pulling their details
		if(!empty($data['bankid']) && !empty($data['username']))
		{
			$data['userId'] = decrypt_value($data['u']);
			$this->load->helper('intuit_agg_cat_helper');
			#Get the Auth tokens for the connection
			#TEMPORARILY DISABLED TO AVOID CONTACTING THE API. REMOVE COMMENT WHEN GOING LIVE.
			$oauthTokens = array();#IntuitAggCatHelpers::GetOAuthTokens();
			
			#Genrate XML from the submitted info
			$xml =  $this->data_import->generate_intuit_api_xml('login', array('action_url'=>SCHEMA_FEED_URL."institutionlogin/v1", 'username'=>$data['username'], 'bankid'=>$data['bankid'], 'user_password'=>$data['userpassword']));
			
			#Get the data from the intuit API
			$data['xmlObj'] = $this->data_import->get_data_by_api($oauthTokens, FINANCIAL_FEED_URL .'v1/institutions/100000/logins', 600, $xml, 'discover_and_add_accounts');
			
			#The discovery returned accounts. Hence get all of them
			if(!empty($data['xmlObj']['AccountList']))
			{
				$data['xmlObj'] = $this->data_import->get_data_by_api($oauthTokens, FINANCIAL_FEED_URL .'v1/accounts', 600, $xml, 'get_customer_accounts');
				
				if(!empty($data['xmlObj']['AccountList']))
				{
					#Save all the imported account raw data
					$data['result'] = $this->data_import->save_imported_data($data['xmlObj'], 'account_list', $data['userId']);
					
					$data['msg'] = $data['result']? "All accounts have been successfully imported. Please select the ones you wish to link to Clout.": "ERROR: One or more accounts were not imported.";
					#Get the currently saved user accounts
					$data['currentAccountIds'] = $this->account_manager->get_user_bank_accounts($data['userId'], 'saved_ids');
					#Get the raw user accounts
					$data['rawAccounts'] = $this->account_manager->get_user_bank_accounts($data['userId'], 'raw');
					
					$data['area'] = "account_list";
				}
				else
				{
					$data['area'] = "import_error";
				}
			}
			#The discovery returned a challenge. Ask for more information from the user
			else if(!empty($data['xmlObj']['Challenges']))
			{
				
				
				$data['area'] = "user_challenge";
			}
			#There was an error 
			else
			{
				
				$data['area'] = "import_error";
			}
		}
		
		$data['area'] = !empty($data['area'])? $data['area']: "account_results";
		$this->load->view('web/addons/result_view', $data);
	}
	
	
	
	
	
	#Function to link user accounts to the system
	public function link_accounts()
	{
		$data = filter_forwarded_data($this);
		$data['userId'] = decrypt_value($data['u']);
			
		if(!empty($data['selectedaccounts']))
		{
			$accountList = explode(',', restore_bad_chars($data['selectedaccounts']));
			$result = $this->account_manager->link_bank_accounts($accountList, $data['userId']);
			
			$data['msg'] = $result? "The selected accounts have been linked.": "ERROR: There was a problem linking one or more of the selected accounts.";
		}
		else
		{
			$data['msg'] = "ERROR: The selected account data could not be resolved.";
		}
		#Get the currently saved user accounts
		$data['currentAccountIds'] = $this->account_manager->get_user_bank_accounts($data['userId'], 'saved_ids');
		#Get the raw user accounts
		$data['rawAccounts'] = $this->account_manager->get_user_bank_accounts($data['userId'], 'raw');
					
		
		$data['area'] = "account_list";
		$this->load->view('web/addons/result_view', $data);
	}
	
	
	
	
	public function download_transactions()
	{
		$data = filter_forwarded_data($this);
		$data['userId'] = decrypt_value($data['u']);
			
			
		if(!empty($data['checkedaccounts']))
		{
			$accountList = explode(',', restore_bad_chars($data['checkedaccounts']));
			$this->load->helper('intuit_agg_cat_helper');
			#Get the Auth tokens for the connection
			#TEMPORARILY DISABLED TO AVOID CONTACTING THE API. REMOVE COMMENT WHEN GOING LIVE.
			$oauthTokens = array();#IntuitAggCatHelpers::GetOAuthTokens();
			
			$result = $this->data_import->import_transaction_data($oauthTokens, $accountList, $data['userId'], array('start_date'=>date('Y-m-d', strtotime('- 2 years')), 'end_date'=>date('Y-m-d') ));
			
			$data['msg'] = $result? "The selected accounts have been synced.": "ERROR: There was a problem syncing one or more of the selected accounts.";
		}
		else
		{
			$data['msg'] = "ERROR: The selected account data could not be resolved.";
		}
		
		
		$data['area'] = "transaction_list";
		$this->load->view('web/addons/result_view', $data);
	}
	
	
	
	#Function to connect to the Plaid API
	public function connect_to_plaid()
	{
		$data = filter_forwarded_data($this);
		$credentials = $postData = array();
		
		
		#TODO: Remove when live
		#WELLSFARGO: 'bank_id'=>'16989' no MFA
		#US BANK: 'bank_id'=>'301' question-based MFA
		#BANK OF AMERICA: 'bank_id'=>'283' question/code-based MFA
		#CHASE: 'bank_id'=>'16818' code-based MFA
		#$credentials = array('user_name'=>'plaid_test', 'password'=>'plaid_good');
		#Plaid code for test: 1234
		#print_r($data); echo "==="; print_r($_POST);
		#=====================================
		
		#The user is requires more login credentials
		if(!empty($data['a']))
		{
			#First get the user's details, if available
			$userEmail = (!empty($data['e']))? decrypt_value($data['e']): $this->native_session->get('email_address');
			$userDetails = (!empty($userEmail))? $this->db->query($this->query_reader->get_query_by_code('get_users_by_field_value', array('field_name'=>'email_address', 'field_value'=>$userEmail)))->row_array(): array();
			$credentials['user_id'] = !empty($userDetails['id'])? $userDetails['id']: '';
			
			#RESPONDING WHEN:
			#------------------------------------------------------
			#a) API returned an error after login
			if($data['a'] == 'display_error')
			{
				$credentials['user_name'] = $_POST['username'];
				$credentials['password'] = $_POST['bankpassword'];
				if(!empty($_POST['bankpin']))
				{
					$credentials['bank_pin'] = $_POST['bankpin'];
				}
				$postData = array('bank_id'=>$this->native_session->get('login_institution_id'), 'email_address'=>$userEmail);
			}
			#b) API required extra information after login
			else if($data['a'] == 'display_question' || $data['a'] == 'display_code')
			{
				$credentials['mfa'] = $_POST['questionanswer'];
				$postData = array('bank_id'=>$this->native_session->get('login_institution_id'), 'email_address'=>$userEmail);
			}
			#c) API requested to choose a delivery option for a code after login
			else if($data['a'] == 'display_options')
			{
				$credentials['mfa'] = $_POST['questionanswer'];
				$credentials['send_method'] = $_POST['questionanswer'];
				$postData = array('bank_id'=>$this->native_session->get('login_institution_id'), 'email_address'=>$userEmail);
			}
			
			#Initiate communication with API with relevant data collected
			$data['response'] = $this->plaid_data_import->initiate_communication_via_url($credentials, $postData);
			
			#Check if there was a successful response and generate the accounts list
			if(!empty($data['response']['action']) && $data['response']['action'] == 'success')
			{
				$data['userId'] = $credentials['user_id'];
				
				$data['currentBanks'] = $this->db->query($this->query_reader->get_query_by_code('get_user_banks', array('user_id'=>$credentials['user_id'], 'is_verified_list'=>"'Y'")))->result_array();
			}
			
		}
		else
		{
			$data['response'] = $this->plaid_data_import->format_extra_login_for_display(array('code'=>'initiate'));
			$data['response']['resolve'] = "ERROR: No action could be resolved";
		}
		
		$data['area'] = (!empty($data['response']['action']) && $data['response']['action'] == 'success')? "show_success_steps": "connection_result";
		$this->load->view('web/addons/account_views', $data);
	}
	
	
	
	
	#Show the list of qualified accounts for Clout
	function show_qualified_accounts()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['i']))
		{
			$data['currentBanks'] = $this->db->query($this->query_reader->get_query_by_code('get_user_banks', array('user_id'=>decrypt_value($data['i']), 'is_verified_list'=>"'Y'")))->result_array();
		}
		
		$data['area'] = 'qualified_accounts_list';
		$this->load->view('web/addons/account_views', $data);
	}
	
	
	
	#Carry out a simple list action
	function simple_list_action()
	{
		$data = filter_forwarded_data($this);
		
		#Only process if the action is specified
		if(!empty($data['a']))
		{
			$result = $this->transaction_manager->process_simple_list_action(decrypt_value($data['a']), $_POST);
			$data['msg'] = $result['msg'];
		}
		else
		{
			$data['msg'] = "ERROR: An action could not be resolved";
		}
		
		$data['area'] = 'basic_msg';
		$this->load->view('web/addons/basic_addons', $data);
	}
	
}

/* End of controller file */