<?php

/**
 * This class handles data import for Plaid
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 04/29/2014
 */
class Plaid_data_import extends CI_Model
{
	private $connectionUrl = '';
	private $accessToken = '';
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
        $this->load->model('scoring');
		$this->connectionUrl = (ENVIRONMENT=='production'? PLAID_PRODUCTION_API_URL: PLAID_DEV_API_URL);
	}
	
	
	
	
	#Function to initiate an API call for a new user
	public function initiate_communication_via_url($signatures, $postData)
	{
		#1. Initiate login process
		$response = $this->login_new_user_into_api(array_merge($signatures, $postData));
		$response = !empty($response)? $response: array();
		$userId = !empty($postData['user_id'])? $postData['user_id']: $this->native_session->get('userId');
		$bankId = !empty($postData['bank_id'])? $postData['bank_id']: '';
		
		#Attempt getting the bank ID
		$bankCode = !empty($postData['bank_id'])? $this->get_bank_code($postData['bank_id']): '';
		#Attempt getting the access token
		$this->accessToken = !empty($postData['email_address'])? $this->get_user_access_token($postData['email_address'], $bankCode): '';
		
		#Record user access token for next access if it is not already recorded
		if(empty($this->accessToken) && !empty($response['access_token']) && !empty($bankCode)) 
		{
			$this->db->query($this->query_reader->get_query_by_code('add_plaid_access_token', array('user_id'=>$userId, 'bank_code'=>$bankCode, 'access_token'=>$response['access_token'], 'is_active'=>'Y')));
			$this->accessToken = $response['access_token'];
		}
		
		#Extra steps are required for Login
		if(array_key_exists('type', $response))
		{
			#This adds a table modified to fit the login table with extra information required displayed
			$response = $this->format_extra_login_for_display($response);
		}
		#2 Login was successful
		else if(array_key_exists('accounts', $response))
		{
			$response['action'] = 'success';
			
			$importAccountResult = $this->import_account_data($response['accounts'], $userId, $bankId);
			$importTransactionResult = array_key_exists('transactions', $response)? $this->import_transaction_data($response['transactions'], $userId, $bankId): false;
			
			$processResult = $this->save_imported_data($userId, $bankId);
			
			#Was the import successful?
			$response['import_result'] = get_decision(array($importAccountResult, $importTransactionResult, $processResult));
			#TODO: Log user import result
			
		} 
		#There was an error in the process
		else if(array_key_exists('code', $response))
		{
			$response = $this->format_extra_login_for_display($response);
			#TODO: Record error in log
		}
		
		#Update Cron Schedule to pull more user data later
		$response['cron_result'] = $this->db->query($this->query_reader->get_query_by_code('add_to_cron_schedule', array('cron_value'=>$userId, 'activity_code'=>'pull_all_user_transactions')));
		
		return $response;
	}
	
	
	
	
	
	#Function to import account data
	public function import_account_data($response, $userId, $bankId) 
	{
		$resultArray = array();
		$userDetails = $this->db->query($this->query_reader->get_query_by_code('get_users_by_field_value', array('field_name'=>'id', 'field_value'=>$userId)))->row_array();
		
		#Go through all accounts sent and record each based on type
		foreach($response AS $row)
		{
			#Does similar record already exist?
			if($row['type'] == 'depository')
			{
				$variableData = array('account_id'=>$row['_id'], 'user_id'=>$userId, 'status'=>'', 'account_number'=>$row['_item'], 'account_number_real'=>$row['meta']['number'], 'account_nickname'=>$row['meta']['name'], 'display_position'=>'', 'institution_id'=>$bankId, 'description'=>'PLAID - ', 'registered_user_name'=>(!empty($userDetails['first_name'])?$userDetails['first_name'].' '.$userDetails['last_name']:''), 'balance_amount'=>$row['balance']['current'], 'balance_date'=>date('Y-m-d H:i:s'), 'balance_previous_amount'=>'', 'last_transaction_date'=>'0000-00-00 00:00:00', 'aggr_success_date'=>'0000-00-00 00:00:00', 'aggr_attempt_date'=>'0000-00-00 00:00:00', 'aggr_status_code'=>'', 'currency_code'=>'USD', 'bank_id'=>'',  	'institution_login_id'=>'', 'banking_account_type'=>'', 'posted_date'=>'0000-00-00 00:00:00', 'available_balance_amount'=>(!empty($row['balance']['available'])?$row['balance']['available']:'0.0'), 'interest_type'=>'', 'origination_date'=>'0000-00-00 00:00:00', 'open_date'=>'0000-00-00 00:00:00', 'period_interest_rate'=>'0.0', 'period_deposit_amount'=>'0.0', 'period_interest_amount'=>'0.0', 'interest_amount_ytd'=>'0.0', 'interest_prior_amount_ytd'=>'0.0', 'maturity_date'=>'0000-00-00 00:00:00', 'maturity_amount'=>'0.0', 'raw_table_name'=>'raw_bank_accounts');
				
				$checkRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_account', $variableData))->row_array();
				array_push($resultArray, $this->db->query($this->query_reader->get_query_by_code((!empty($checkRecord)?'update_raw_bank_account': 'save_raw_bank_account'), $variableData)));
			}
			else if($row['type'] == 'credit')
			{
				$variableData = array('account_id'=>$row['_id'], 'user_id'=>$userId, 'status'=>'', 'account_number'=>$row['_item'], 'account_number_real'=>$row['meta']['number'], 'account_nickname'=>htmlentities($row['meta']['name'], ENT_QUOTES), 'display_position'=>'', 'institution_id'=>$bankId, 'description'=>'PLAID - ', 'registered_user_name'=>(!empty($userDetails['first_name'])?$userDetails['first_name'].' '.$userDetails['last_name']:''), 'balance_amount'=>$row['balance']['current'], 'balance_date'=>date('Y-m-d H:i:s'), 'balance_previous_amount'=>'', 'last_transaction_date'=>'0000-00-00 00:00:00', 'aggr_success_date'=>'0000-00-00 00:00:00', 'aggr_attempt_date'=>'0000-00-00 00:00:00', 'aggr_status_code'=>'', 'currency_code'=>'USD', 'bank_id'=>'',  	'institution_login_id'=>'', 'credit_account_type'=>'', 'detailed_description'=>'', 'interest_rate'=>'0.0', 'credit_available_amount'=>(!empty($row['balance']['available'])?$row['balance']['available']:'0.0'), 'credit_max_amount'=>(!empty($row['meta']['limit'])?$row['meta']['limit']:'0.0'), 'cash_advance_available_amount'=>'0.0', 'cash_advance_max_amount'=>'0.0', 'cash_advance_balance'=>'0.0', 'cash_advance_interest_rate'=>'0.0', 'current_balance'=>'0.0', 'payment_min_amount'=>'0.0', 'payment_due_date'=>'0000-00-00 00:00:00', 'previous_balance'=>'0.0', 'statement_end_date'=>'0000-00-00 00:00:00', 'statement_purchase_amount'=>'0.0', 'statement_finance_amount'=>'0.0', 'past_due_amount'=>'0.0', 'last_payment_amount'=>'0.0', 'last_payment_date'=>'0000-00-00 00:00:00', 'statement_close_balance'=>'0.0', 'statement_late_fee_amount'=>'0.0', 'raw_table_name'=>'raw_credit_accounts'    );
				
				$checkRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_account', $variableData))->row_array();
				array_push($resultArray,  $this->db->query($this->query_reader->get_query_by_code((!empty($checkRecord)?'update_raw_credit_account': 'save_raw_credit_account'), $variableData)));
			}
		}
		
		return get_decision($resultArray, FALSE);
	}
	
	
	
	
	#Function to import transaction data
	public function import_transaction_data($response, $userId, $bankId) 
	{
		$resultArray = array();
		$userDetails = $this->db->query($this->query_reader->get_query_by_code('get_users_by_field_value', array('field_name'=>'id', 'field_value'=>$userId)))->row_array();
		
		#Go through all transactions sent and record each based on type
		foreach($response AS $row)
		{
			#Generate the list of variables for saving
			$variableData = array('transaction_id'=>$row['_id'], 'transaction_type'=>'banking', 'currency_type'=>'USD', 'institution_transaction_id'=>'PLAID-'.$row['_id'], 'correct_institution_transaction_id'=>'', 'correct_action'=>'', 'server_transaction_id'=>'', 'check_number'=>'', 'ref_number'=>'', 'confirmation_number'=>'', 'payee_id'=>$row['_entity'], 'payee_name'=>htmlentities($row['name'], ENT_QUOTES), 'extended_payee_name'=>htmlentities($row['name'], ENT_QUOTES), 'memo'=>'', 'type'=>(!empty($row['type']['primary'])?$row['type']['primary']:''), 'value_type'=>'', 'currency_rate'=>'1', 'original_currency'=>'', 'posted_date'=>(!empty($row['date'])?date('Y-m-d H:i:s', strtotime($row['date'])):'0000-00-00 00:00:00'), 'user_date'=>'0000-00-00 00:00:00', 'available_date'=>date('Y-m-d H:i:s'), 'amount'=>(!empty($row['amount'])?$row['amount']:'0.0'), 'running_balance_amount'=>'', 'pending'=>'', 'latitude'=>(!empty($row['meta']['location']['coordinates']['lat'])? $row['meta']['location']['coordinates']['lat']: ''), 'longitude'=>(!empty($row['meta']['location']['coordinates']['lng'])? $row['meta']['location']['coordinates']['lng']: ''), 'zipcode'=>(!empty($row['meta']['location']['zip'])? $row['meta']['location']['zip']: ''), 'state'=>(!empty($row['meta']['location']['state'])? $row['meta']['location']['state']: ''), 'city'=>(!empty($row['meta']['location']['city'])? $row['meta']['location']['city']: ''), 'address'=>(!empty($row['meta']['location']['address'])? htmlentities($row['meta']['location']['address'], ENT_QUOTES): ''), 'sub_category_id'=>(!empty($row['category_id'])? $row['category_id']: ''), 'contact_telephone'=>(!empty($row['meta']['contact']['telephone'])? remove_string_special_characters($row['meta']['contact']['telephone']): ''), 'website'=>(!empty($row['meta']['contact']['website'])? $row['meta']['contact']['website']: ''), 'confidence_level'=>$row['score']['master'], 'place_type'=>(!empty($row['type']['primary'])? $row['type']['primary']: ''),
			
			
			#Transaction categorization attributes
			'normalized_payee_name'=>htmlentities($row['name'], ENT_QUOTES), 'merchant'=>$row['_entity'], 'sic'=>'', 'source'=>'plaid', 'user_id'=>$userId, 'bank_id'=>$bankId, 'api_account'=>$row['_account'], 
			
			'category_name'=>(!empty($row['category'][0])? (!empty($row['category'][1])? (!empty($row['category'][2])? $row['category'][0].':'.$row['category'][1].':'.$row['category'][2]: $row['category'][0].':'.$row['category'][1]): $row['category'][0]): ''), 
			
			'context_type'=>'', 'schedule_c'=>'', 
			'banking_transaction_type'=>'', 'subaccount_fund_type'=>'', 'banking_401k_source_type'=>'', 
			'principal_amount'=>'', 'interest_amount'=>'', 'escrow_total_amount'=>'', 'escrow_tax_amount'=>'', 'escrow_insurance_amount'=>'', 'escrow_pmi_amount'=>'', 'escrow_fees_amount'=>'', 'escrow_other_amount'=>'',
			'query_part'=>" AND is_saved='N' ");
			
			#Does similar record already exist (if the transaction is still PENDING when it was first added)?
			$checkPendingRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_transaction', $variableData))->row_array();
			$checkRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_transaction', array('transaction_id'=>$row['_id'], 'query_part'=>" AND is_saved='Y' ")))->row_array();
			
			#Go here if the transaction has not been saved yet
			if(empty($checkRecord))
			{
				$result = $this->db->query($this->query_reader->get_query_by_code((!empty($checkPendingRecord)?'update_raw_transaction': 'save_raw_transaction'), $variableData));
				array_push($resultArray, $result);
			}
		}
		
		
		return get_decision($resultArray, FALSE);
	}
	
	
	
	
	
	#Function to clean up and process the imported data for use by the system
	public function save_imported_data($userId, $bankId, $restrictions=array())
	{
		#1. Move Account data
		$moveAccountResult = $this->move_account_data($userId, $bankId, $restrictions);
		
		#2. Move transaction data
		$moveTransactionResult = $this->move_transaction_data($userId, $bankId, $restrictions);
		
		return get_decision(array($moveAccountResult, $moveTransactionResult), FALSE);
	}
	
	
	
	
	#Function to move unprocessed transaction data for a given user
	public function move_transaction_data($userId, $bankId, $restrictions=array())
	{
		$resultArray = array();
		$limitText = "";
		$conditions = " AND T.user_id='".$userId."' AND T.bank_id='".$bankId."' ";
		
		#Check if there are restrictions 
		$limitText .= (!empty($restrictions['limit'])? " LIMIT 0,".$restrictions['limit'].";":"");
		$conditions .= (!empty($restrictions['min_date'])? " AND DATE(T.posted_date) >= DATE('".date('Y-m-d H:i:s', strtotime($restrictions['min_date']))."')": "");
		#TODO: Add more restrictions
		
		
		#Do the following for each transaction
		$transactions = $this->db->query($this->query_reader->get_query_by_code('get_unprocessed_transactions', array('is_saved'=>"'N'", 'table_name'=>'raw_bank_transactions', 'more_conditions'=>$conditions, 'limit_text'=>$limitText )))->result_array();
		#Now go through each transaction and add them to the Clout account list for the user
		foreach($transactions AS $row)
		{
			#Get details of the purchased item
			$item = $this->get_transaction_item_details($row['id']);
			$store = $this->get_transaction_store_details($row['id']);
			
			$result = $this->db->query($this->query_reader->get_query_by_code('save_clout_transaction', array('transaction_type'=>($row['amount'] < 0? 'deposit': 'buy'), 'user_id'=>$row['user_id'], 'store_id'=>$store['id'], 'status'=>($row['pending']=='true'? 'pending': 'complete'), 'transaction_currency'=>$row['currency_type'], 'currency_rate'=>$row['currency_rate'], 'amount'=>$row['amount'], 'related_transaction_id'=>$row['id'], 'start_date'=>$row['posted_date'], 'end_date'=>$row['available_date'], 'source_account_id'=>$row['api_account'], 'item_id'=>$item['id'], 'item_name'=>$item['name'], 'item_value'=>$row['principal_amount'], 'transaction_tax'=>$row['escrow_tax_amount'], 'merchant_transaction_number'=>$row['server_transaction_id'], 'payment_gateway_id'=>$row['api_account'], 'payment_gateway_fees'=>'0.0', 'terminal_id'=>'', 'cashier_id'=>'', 'item_quantity'=>'', 'transaction_description'=>$row['schedule_c'], 'is_security_risk'=>(($row['confidence_level'] >= 0.5)? 'N': 'Y')   )));
			
			#Update the store categories if they do not have the transaction category already
			$result1 = $this->update_store_categories($store['id'], $row['id'], 'bank');
				
			#Update that the account has been saved in the raw account records
			$result2 = $this->db->query($this->query_reader->get_query_by_code('update_transaction_as_saved', array('is_saved'=>($result?'Y': 'N'), 'id'=>$row['id'])));
			array_push($resultArray, $result, $result1, $result2);
		}
		
		#Update the transaction totals for the user - scoring
		array_push($resultArray, $this->update_user_transaction_totals(array(),$userId));
		
		return get_decision($resultArray);
	}
	
	
	
	
	
	
	#function to update the user transaction totals for user scoring
	public function update_user_transaction_totals($scope, $userId, $storeId='')
	{
		$resultArray = array();
		
		#The fields in the score to update
		$fieldsToUpdate = !empty($scope['fields'])? $scope['fields']: array('spending_last180days', 'spending_last360days', 'spending_total');
		$scoreType = !empty($scope['type'])? $scope['type']: 'clout';
		
		$dateRange['start_date'] = !empty($scope['start_date'])? $scope['start_date']: '';
		$dateRange['end_date'] = !empty($scope['end_date'])? $scope['end_date']: '';
		#Get total expenditures for the user
		$total = $this->scoring->get_user_transactions($userId, 'totals', $dateRange);
		
		foreach($fieldsToUpdate AS $field)
		{
			#You are adding to the current cached value
			if(!empty($dateRange['start_date']))
			{
				$currentScoreCache = $this->db->query($this->query_reader->get_query_by_code('get_'.$scoreType.'_score_cache', array('user_id'=>$userId, 'store_id'=>$storeId)))->row_array();
				$amount = $total+(!empty($currentScoreCache[$field])? $currentScoreCache[$field]: 0);
			}
			#You are replacing the total value
			else
			{
				$amount = $total;
			}
			
			#Update the total appropriately
			$result = $this->scoring->update_score_cache($scoreType.'_score', array('field_name'=>$field, 'score_value'=>$amount), $userId, $storeId);
			array_push($resultArray, $result);
		}
		
		return get_decision($resultArray, FALSE);
	}
	
	
	
	
	
	
	
	#Update the categories attached to a store given a raw transaction as reference
	public function update_store_categories($storeId, $rawTransactionId, $transactionType)
	{
		#1. Get the store details and the raw transaction details
		$store = $this->db->query($this->query_reader->get_query_by_code('get_store_by_parameter', array('field_name'=>'id', 'field_value'=>$storeId)))->row_array();
		$transaction = $this->db->query($this->query_reader->get_query_by_code('get_unprocessed_transactions', array('table_name'=>'raw_'.$transactionType.'_transactions', 'is_saved'=>"'Y','N'", 'more_conditions'=>" AND id='".$rawTransactionId."' ", 'limit_text'=>' LIMIT 0,1; ')))->row_array();
		
		#2. Get the matching categories for the transaction based on its API category ID
		$categories = $this->db->query($this->query_reader->get_query_by_code('get_matching_clout_categories', array('id_value'=>$transaction['sub_category_id'], 'id_field'=>'plaid_sub_category_id')))->row_array();
		$currentStoreCategories = !empty($store['system_category_tags'])? explode(',',$store['system_category_tags']): array();
		$categoriesFromTransaction = !empty($categories['clout_sub_category_ids'])? explode(',',$categories['clout_sub_category_ids']): array();
		
		#3. Check the current sub-category IDs if any is missing and then add it to the sub-categories for that store
		$difference = array_diff($categoriesFromTransaction, $currentStoreCategories);
		$result = !empty($difference)? $this->db->query($this->query_reader->get_query_by_code('update_store_value', array('field_name'=>'system_category_tags', 'field_value'=>$store['system_category_tags'].",".implode(',',$categoriesFromTransaction), 'store_id'=>$storeId))): TRUE;
		
		
		return $result;
	}
	
	
	
	
	
	#Function to move unprocessed account data for a given user to their Clout account data
	public function move_account_data($userId, $bankId, $restrictions=array())
	{
		$resultArray = array();
		$limitText = "";
		$conditions = " AND A.user_id='".$userId."' AND A.institution_id='".$bankId."' ";
		
		#Check if there are restrictions 
		$limitText .= (!empty($restrictions['limit'])? " LIMIT 0,".$restrictions['limit'].";":"");
		$conditions .= (!empty($restrictions['min_date'])? " DATE(A.last_updated) >= DATE('".date('Y-m-d H:i:s', strtotime($restrictions['min_date']))."')": "");
		#TODO: Add more restrictions
		
		$accountTypes = array('bank', 'credit', 'investment', 'loan', 'reward');
		$accountBalances = array('bank'=>0, 'credit'=>0, 'investment'=>0, 'loan'=>0, 'reward'=>0);
		$balanceFields = array('bank'=>'balance_amount', 'credit'=>'balance_amount', 'investment'=>'current_balance', 'loan'=>'balance_amount', 'reward'=>'current_balance');
		
		#Do the following for each investment account
		foreach($accountTypes AS $type)
		{
			$accounts = $this->db->query($this->query_reader->get_query_by_code('get_unprocessed_accounts', array('table_name'=>'raw_'.$type.'_accounts', 'more_conditions'=>$conditions, 'limit_text'=>$limitText )))->result_array();
			
			#Now go through each transaction and add them to the Clout account list for the user
			foreach($accounts AS $row)
			{
				#Track the balances of the user's accounts by type
				$accountBalances[$type] += $row[$balanceFields[$type]];
				$result = $this->db->query($this->query_reader->get_query_by_code('add_bank_account', array('user_id'=>$userId, 'account_type'=>$type, 'account_id'=>$row['account_id'], 'account_number'=>$row['account_number_real'], 'bank_id'=>$bankId, 'issue_bank_name'=>$this->get_bank_name($bankId), 'card_holder_full_name'=>$row['registered_user_name'], 'account_nickname'=>$row['account_nickname'], 'currency_code'=>$row['currency_code']   )));
				
				$result2 = $this->db->query($this->query_reader->get_query_by_code('mark_bank_account_as_verified', array('id'=>$this->db->insert_id() )));
				
				#Update that the account has been saved in the raw account records
				$result3 = $this->db->query($this->query_reader->get_query_by_code('update_account_as_saved', array('account_table_name'=>'raw_'.$type.'_accounts', 'is_saved'=>($result?'Y': 'N'), 'id'=>$row['id'])));
				array_push($resultArray, $result, $result2, $result3);
			}
		}
		
		#Update the account balance tracking when done
		if(!empty($resultArray))
		{
			$result = $this->update_user_account_balances($userId, $accountBalances);
		}
		
		return get_decision($resultArray, FALSE);
	}
	
	
	
	
	#Updates a user account balance
	public function update_user_account_balances($userId, $accountBalances)
	{
		$resultArray = array();
		
		#Combine the cash and reward balances
		$accountBalances['bank'] = $accountBalances['bank'] + $accountBalances['reward'];
		#Get the user's score cache
		$scoreCache = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_cache', array('user_id'=>$userId )))->row_array();
		
		foreach($accountBalances AS $type => $balance)
		{
			#TEMPORARY: Allow ONLY bank and credit balances beyond this point
			#Remove once loan and investment balances are being tracked
			if(in_array($type, array('bank', 'credit')))
			{
				#Now get the balances in the previous saved accounts
				$balance = $this->scoring->get_user_account_balance($userId, $type);
				
				#Hack for considering all bank types (saving and checking) account balances as cash.
				$type = ($type == 'bank')? 'cash': $type;
				$previousBalance = $this->db->query($this->query_reader->get_query_by_code('get_user_account_tracking', array('table_name'=>'user_'.$type.'_tracking', 'user_id'=>$userId, 'query_part'=>" AND is_latest='Y' " )))->row_array();
				
				#Just update the balance if the user is already in the system
				if(!empty($previousBalance))
				{
					#Add account tracking
					$result1 =  $this->db->query($this->query_reader->get_query_by_code('add_'.$type.'_tracking', array('user_id'=>$userId, $type.'_amount'=>$balance, 'read_date'=>date('Y-m-d H:i:s'), 'is_latest'=>'Y' )));
					#Now unflag the previous latest value
					$result2 = $this->db->query($this->query_reader->get_query_by_code('flag_latest_tracking', array('id'=>$previousBalance['id'], 'flag'=>'N', 'table_name'=>'user_'.$type.'_tracking' )));
				
					array_push($resultArray, $result1, $result2);
				}
				#Add a new balance
				else
				{
					$result1 =  $this->db->query($this->query_reader->get_query_by_code('add_'.$type.'_tracking', array('user_id'=>$userId, $type.'_amount'=>$balance, 'read_date'=>date('Y-m-d H:i:s'), 'is_latest'=>'Y' )));
					array_push($resultArray, $result1);
				}
				#TODO: Add investment (asset) and Loan tracking
				
				#Now update the scoring cache with these temporary values until the cron computes the full results
				$result3 = $this->scoring->update_score_cache('clout_score', array('field_name'=>$type.'_balance_today', 'score_value'=>$balance), $userId);
				$result4 = $this->scoring->update_score_cache('clout_score', array('field_name'=>'average_'.$type.'_balance_last24months', 'score_value'=>$balance), $userId);
				
				array_push($resultArray, $result3, $result4);
			}
		}
		
		return get_decision($resultArray, FALSE);
	}
	
	
	
	
	
	
	
	#Get details of an item based on the information given in a transaction
	public function get_transaction_item_details($rawTransactionId)
	{
		$item = array('id'=>'', 'name'=>'');
		
		#TODO: Add functionality to map items based on history and learned mappings
		
		return $item;
	}
	
	
	
	
	
	#Get details of an item based on the information given in a transaction
	public function get_transaction_store_details($rawTransactionId)
	{
		$store = array('id'=>'', 'name'=>'');
		
		$transaction = $this->db->query($this->query_reader->get_query_by_code('get_unprocessed_transactions', array('is_saved'=>"'N'", 'table_name'=>'raw_bank_transactions', 'more_conditions'=>" AND id='".$rawTransactionId."' ", 'limit_text'=>' LIMIT 0,1; ' )))->row_array();
		
		#1. Try getting store by id
		$try1 = $this->db->query($this->query_reader->get_query_by_code('get_store_by_parameter', array('field_name'=>'plaid_company_id', 'field_value'=>$transaction['payee_id'] )))->row_array();
		$store['id'] = !empty($try1['id'])? $try1['id']: '';
		$store['name'] = !empty($try1['name'])? $try1['name']: '';
		
		#2. If no success, check the store list by name
		if(empty($store['id']))
		{
			$try2 = $this->db->query($this->query_reader->get_query_by_code('get_store_by_parameter', array('field_name'=>'LOWER(`name`)', 'field_value'=>(!empty($transaction['payee_name'])? strtolower($transaction['payee_name']): '') )))->row_array();
			$store['id'] = !empty($try2['id'])? $try2['id']: '';
			$store['name'] = !empty($try2['name'])? $try2['name']: '';
		}
		
		#TODO: Add functionality to map stores based on history and learned mappings
		
		#3. If no success, just add the store as a pending record
		if(empty($store['id']))
		{
			$result = $this->db->query($this->query_reader->get_query_by_code('add_new_store', array('name'=>htmlentities($transaction['payee_name'], ENT_QUOTES), 'email_address'=>'', 'merchant_id'=>'', 'status'=>'pending', 'address_line_1'=>$transaction['address'], 'city'=>$transaction['city'], 'website'=>$transaction['website'], 'state'=>$transaction['state'], 'zipcode'=>$transaction['zipcode'], 'country'=>'USA', 'phone_number'=>$transaction['contact_telephone'], 'employee_number'=>'', 'estimated_annual_revenue'=>'', 'price_range'=>'', 'primary_contact_name'=>'', 'primary_contact_title'=>'', 'primary_contact_phone'=>'', 'primary_contact_email'=>'', 'claimed_company_id'=>'', 'additional_fields'=>', plaid_company_id', 'additional_field_values'=>", '".$transaction['payee_id']."' "  )));
			
			$store['id'] =  $this->db->insert_id();
			$store['name'] = (!empty($transaction['payee_name'])? strtolower($transaction['payee_name']): '');
		}
		
		return $store;
	}
	
	
	
	#Get bank name
	private function get_bank_name($bankId)
	{
		$bank = $this->db->query($this->query_reader->get_query_by_code('get_institution_list', array('search_string'=>" id='".$bankId."' ", 'limit_text'=>'')))->row_array();
		
		return (!empty($bank['institution_name'])? $bank['institution_name']: '');
	}
	
	
	
	
	
	#Function to import transaction data
	public function login_new_user_into_api($loginData) 
	{
		#The unique code for the bank organization with the API
		$bankCode = $this->get_bank_code($loginData['bank_id']);
		
		#Check if user is already registered with the API
		$plaidToken = $this->get_user_access_token($loginData['email_address'], $bankCode);
		
		#User already registered
		if(!empty($plaidToken) && !empty($loginData['mfa']))
		{
			$dataArray = array(
				'client_id'=>PLAID_CLIENT_ID, 
				'secret'=>PLAID_SECRET, 
				'type'=>$bankCode,
				'mfa'=>$loginData['mfa'], 
      			'access_token'=>$plaidToken
			);
			
			#If requires an access token sent to the device
			if(!empty($loginData['send_method'])) $dataArray['options'] = array('send_method'=>array('type'=>$loginData['send_method']));
			
			$url = $this->connectionUrl.'/connect/step';
		}
		#New user with the API
		else
		{
			$dataArray = array(
				'client_id'=>PLAID_CLIENT_ID, 
				'secret'=>PLAID_SECRET, 
				'credentials'=>array('username'=>$loginData['user_name'],'password'=>$loginData['password']), 
      			'type'=>$bankCode,
				'email'=>$loginData['email_address'],
				'list'=>true
			);
			#If requires a pin number too
			if(!empty($loginData['bank_pin'])) $dataArray['credentials']['pin'] = $loginData['bank_pin'];
			
			$url = $this->connectionUrl.'/connect';
		}
		
		return $this->run_on_api($url, $dataArray);
	}
	
	
	
	
	#Get the user's access token
	private function get_user_access_token($userEmail, $bankCode)
	{
		$tokenArray = !empty($this->accessToken)? array('access_token'=>$this->accessToken): $this->db->query($this->query_reader->get_query_by_code('get_plaid_access_token', array('user_email'=>$userEmail, 'bank_code'=>$bankCode)))->row_array();
		
		return !empty($tokenArray['access_token'])? $tokenArray['access_token']: '';
	}
	
	
	
	#Function to run desired data on API
	public function run_on_api($url, $data, $runType='POST', $returnType='array')
	{
		#Prepare for sending
		$string = json_encode($data);
		$shouldPost = ($runType == 'GET'? 0: 1);
		
		$ch = curl_init();
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($string)));
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    	curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $string);
       	curl_setopt($ch, CURLOPT_POST, $shouldPost);
   		$result = curl_exec($ch);
		
		#Show error
   		if (curl_errno($ch)) 
		{
        	$error = curl_error($ch); 
			$errorResult = array('code' => 404, 'message' => 'system error', 'resolve' => $error ); 
    	} 
		#Close the channel
		else 
		{
        	curl_close($ch);
    	}
		
		#Determine the type of data to return
		if($returnType == 'string')
		{
			return !empty($error)? $error: $result;
		}
		else
		{
			return !empty($errorResult)? $errorResult: json_decode($result, TRUE);
		}
	}
	
	
	
	#Function to determine the code of the bank to return 
	private function get_bank_code($bankId)
	{
		$bankDetails = $this->db->query($this->query_reader->get_query_by_code('get_institution_list', array('search_string'=>" id='".$bankId."' ", 'limit_text'=>" LIMIT 0,1; ")))->row_array();
		
		return (!empty($bankDetails['institution_code'])? $bankDetails['institution_code']: '');
	}
	
	
	
	
	
	
	#Format the API response for proper display to the user
	public function format_extra_login_for_display($response)
	{
		$institutionName = $this->native_session->get('login_institution')? $this->native_session->get('login_institution'): '';
		$institutionCode = $this->native_session->get('login_institution_code')? $this->native_session->get('login_institution_code'): '';
		$institutionId = $this->native_session->get('login_institution_id')? $this->native_session->get('login_institution_id'): '';
		
		$institutionDetails = $this->db->query($this->query_reader->get_query_by_code('get_institution_list', array('search_string'=>" id='".$institutionId."' ", 'limit_text'=>'')))->row_array();
			
		$response['clout_msg'] = "<div id='sync_accounts'>";
		#Format the response based on the code of the response
		if(!empty($response['type']) && $response['type'] == 'questions' && !empty($response['mfa']))
		{
			$response['clout_msg'] .= "<form id='bank_form' method='post' action='".base_url()."web/transactions/connect_to_plaid/a/display_question' onSubmit=\"return submitLayerForm('bank_form')\">
			<table border='0' cellpadding='5'  cellspacing='0'>
				".(!empty($institutionDetails['logo_url'])? "<tr><td style='text-align:center;'><img src='".base_url()."assets/uploads/images/".$institutionDetails['logo_url']."'></td></tr>": "<tr><td style='font-size:16px; font-weight: bold;'><b>".html_entity_decode($institutionName)."</b></td></tr>")."
		
		<tr><td style='font-size:16px;'><span style='font-weight: bold;'>Answer this question:</span><br>".addslashes($response['mfa'][0]['question'])."</td></tr>
		<tr><td><input name='questionanswer' type='password' class='textfield' id='questionanswer' placeholder='Your Answer' style='width:350px;'></td></tr>
		
		<tr><td style='text-align:center;'><input type='submit' name='submitanswer' id='submitanswer' class='bluebtn securebtn' style='width:368px;' value='Submit'></td></tr>
		<tr><td style='font-size:12px;'>
		<table width='100%' border='0' cellpadding='0'  cellspacing='0'>
		<tr><td style='text-align:left;'><img src='".base_url()."assets/images/trust_logos.png' style='height:40px;'></td><td style='text-align:right;'><a href='javascript:;' class='bluelink' style='font-size:12px;'>Privacy</a> | <a href='javascript:;' class='bluelink' style='font-size:12px;'>Terms</a></td></tr>
		</table>
		</td></tr>
		
		
		
	</table>
	<input type='hidden' name='bank_form_required' id='bank_form_required' value='questionanswer'>
	<input type='hidden' name='bank_form_required_msg' id='bank_form_required_msg' value='Your answer is required to continue'>
	<input type='hidden' name='bank_form_displaylayer' id='bank_form_displaylayer' value='sync_accounts'></form>";
			$response['action'] = 'display_question';
		}
		
		
		#There are multiple delivery options for MFA Code
		else if(!empty($response['type']) && $response['type'] == 'list' && !empty($response['mfa']))
		{
			$response['clout_msg'] .= "<form id='bank_form' method='post' action='".base_url()."web/transactions/connect_to_plaid/a/display_options' onSubmit=\"return submitLayerForm('bank_form')\">
			<table border='0' cellpadding='5'  cellspacing='0'>
									 ".(!empty($institutionDetails['logo_url'])? "<tr><td style='text-align:center;'><img src='".base_url()."assets/uploads/images/".$institutionDetails['logo_url']."'></td></tr>": "<tr><td style='font-size:16px; font-weight: bold;'><b>".html_entity_decode($institutionName)."</b></td></tr>")."
		
					<tr><td colspan='3' style='font-size:16px;'>Choose how to receive your access code:</td></tr>";
			foreach($response['mfa'] AS $receiveOption)
			{
				$response['clout_msg'] .= "<tr><td width='1%'><input type='radio' name='receiveoption' id='receive_".$receiveOption['type']."' onclick=\"passFormValue('receive_".$receiveOption['type']."', 'questionanswer', 'radio')\" value='".$receiveOption['type']."'></td><td width='1%'>".ucfirst($receiveOption['type'])."</td><td width='98%'>".$receiveOption['mask']."</td></tr>";
			}
					
			$response['clout_msg'] .= "<tr><td style='text-align:center;' colspan='3'><input type='submit' name='submitanswer' id='submitanswer' class='bluebtn securebtn' style='width:368px;' value='Submit'><input type='hidden' name='questionanswer' id='questionanswer' value='email'></td></tr>
		<tr><td style='font-size:12px;'>
		<table width='100%' border='0' cellpadding='0'  cellspacing='0'>
		<tr><td style='text-align:left;'><img src='".base_url()."assets/images/trust_logos.png' style='height:40px;'></td><td style='text-align:right;'><a href='javascript:;' class='bluelink' style='font-size:12px;'>Privacy</a> | <a href='javascript:;' class='bluelink' style='font-size:12px;'>Terms</a></td></tr>
		</table>
		</td></tr>
		
	</table>
	<input type='hidden' name='bank_form_required' id='bank_form_required' value='questionanswer'>
	<input type='hidden' name='bank_form_required_msg' id='bank_form_required_msg' value='Choose an option to continue'>
	<input type='hidden' name='bank_form_displaylayer' id='bank_form_displaylayer' value='sync_accounts'></form>";
			$response['action'] = 'display_options';
		}
		
		
		#The code has been sent
		else if(!empty($response['type']) && $response['type'] == 'device' && !empty($response['mfa']['message']))
		{
			$response['clout_msg'] .= "<form id='bank_form' method='post' action='".base_url()."web/transactions/connect_to_plaid/a/display_code' onSubmit=\"return submitLayerForm('bank_form')\">
			<table border='0' cellpadding='5'  cellspacing='0'>
				".(!empty($institutionDetails['logo_url'])? "<tr><td style='text-align:center;'><img src='".base_url()."assets/uploads/images/".$institutionDetails['logo_url']."'></td></tr>": "<tr><td style='font-size:16px; font-weight: bold;'><b>".html_entity_decode($institutionName)."</b></td></tr>")."
		
		<tr><td style='font-size:16px;'>".addslashes($response['mfa']['message'])."</td></tr>
		<tr><td><input name='questionanswer' type='password' class='textfield' id='questionanswer' placeholder='Your Code' style='width:350px;'></td></tr>
		
		<tr><td style='text-align:center;'><input type='submit' name='submitanswer' id='submitanswer' class='bluebtn securebtn' style='width:368px;' value='Submit'></td></tr>
		<tr><td style='font-size:12px;'>
		<table width='100%' border='0' cellpadding='0'  cellspacing='0'>
		<tr><td style='text-align:left;'><img src='".base_url()."assets/images/trust_logos.png' style='height:40px;'></td><td style='text-align:right;'><a href='javascript:;' class='bluelink' style='font-size:12px;'>Privacy</a> | <a href='javascript:;' class='bluelink' style='font-size:12px;'>Terms</a></td></tr>
		</table>
		</td></tr>
		
	</table>
	<input type='hidden' name='bank_form_required' id='bank_form_required' value='questionanswer'>
	<input type='hidden' name='bank_form_required_msg' id='bank_form_required_msg' value='Your answer is required to continue'>
	<input type='hidden' name='bank_form_displaylayer' id='bank_form_displaylayer' value='sync_accounts'></form>";
			$response['action'] = 'display_code';
		}
		
		
		#There was an error or this is the first time
		else if(!empty($response['code'])) 
		{
			$response['clout_msg'] .= "<form id='bank_form' method='post' action='".base_url()."web/transactions/connect_to_plaid/a/display_error' onSubmit=\"return submitLayerForm('bank_form')\">
			<table border='0' cellpadding='5'  cellspacing='0'>
			".(!empty($institutionDetails['logo_url'])? "<tr><td style='text-align:center;'><img src='".base_url()."assets/uploads/images/".$institutionDetails['logo_url']."'></td></tr>": "<tr><td style='font-size:16px; font-weight: bold;'><b>".html_entity_decode($institutionName)."</b></td></tr>")."
		
		".(!empty($response['resolve'])? "<tr><td>".format_notice("WARNING: ".$response['resolve'])."</td></tr>": "")."
		<tr><td><input name='username' type='text' class='textfield' id='username' placeholder='User Name' style='width:350px;'></td></tr>
		<tr><td><input name='bankpassword' type='password' class='textfield' id='bankpassword' placeholder='Password' style='width:350px;'></td></tr>
		
		".($institutionCode == 'usaa'? "<tr><td><input name='bankpin' type='password' class='textfield' id='bankpin' placeholder='PIN Number' style='width:350px;'></td></tr>": "")."
		
		<tr><td style='text-align:center;'><input type='submit' name='banklogin' id='banklogin' class='greenbtn securebtn' style='width:368px;' value='Link Account Securely'></td></tr>
		<tr><td style='font-size:12px;'>
		<table width='100%' border='0' cellpadding='0'  cellspacing='0'>
		<tr><td style='text-align:left;'><img src='".base_url()."assets/images/trust_logos.png' style='height:40px;'></td><td style='text-align:right;'><a href='javascript:;' class='bluelink' style='font-size:12px;'>Privacy</a> | <a href='javascript:;' class='bluelink' style='font-size:12px;'>Terms</a></td></tr>
		</table>
		</td></tr>
	</table>
	<input type='hidden' name='bank_form_required' id='bank_form_required' value='username<>bankpassword".($institutionCode == 'usaa'? '<>bankpin':'')."'>
	<input type='hidden' name='bank_form_required_msg' id='bank_form_required_msg' value='The user name and password are required to continue'>
	<input type='hidden' name='bank_form_displaylayer' id='bank_form_displaylayer' value='sync_accounts'></form>";
			$response['action'] = 'display_error';
		}
		$response['clout_msg'] .= "</div>";
		
		
		
		return $response;
	}
	
	
	
	
	#Get the user's imported transactions given the user ID
	public function get_live_transactions($userId, $listParameters=array())
	{
		$start = !empty($listParameters['start'])? $listParameters['start']: 0;
		$itemsPerPage = !empty($listParameters['itemsPerPage'])? $listParameters['itemsPerPage']: 10;
		
		$query = $this->query_reader->get_query_by_code('get_batch_user_transactions', array('query_part'=>" ORDER BY T.start_date DESC ", 'limit_text'=>" LIMIT ".$start.",".$itemsPerPage."; "));
		
		$this->native_session->set('transactions_cache_query', $query);
		return $this->db->query($query)->result_array();
	}
	
	
	
	
	
}