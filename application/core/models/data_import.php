<?php

/**
 * This class handles data import
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 12/18/2013
 */
class Data_import extends CI_Model
{
	
	#Function to connect to the passed URL and return the data
	public function get_data_by_api($tokens, $accessUrl, $timeoutLimit, $xml='', $dataType='')
	{
		#THIS IS A TEMPORARY SOLUTION TO HANDLE PROCESSING FUNCTIONALITY
		if(in_array($dataType, array('institutions'))) #'accounts', 
		{
			#Set the time out limit for this function
			set_time_limit($timeoutLimit);
			#For authenticating the URL connection
			$signatures = $this->get_url_signatures($tokens);
 		
			return $this->initiate_communication_via_url($accessUrl, $signatures, $xml);
		}
		#Temporary option to return the XML in expected formart. This will be phased out as the API comes online.
		else
		{
			$r = get_api_response($dataType);
			$responseXML = substr($r, strpos($r, "<?xml"));
			
			return xml_to_array(simplexml_load_string($responseXML));
		}
	}
	
	
	
	#Function to send data to the API URL and collect response
	public function initiate_communication_via_url($url,  $signatures, $postData='')
	{
		$action = !empty($postData)?'POST':'GET';
		$signedUrl = $this->get_signed_url($url, $action, $signatures);
   		
   		#Send errors to our stream instead of STDERR (where it is shown on the screen)
   		if(ENVIRONMENT == 'production')
		{
			$curlError = @fopen('php://temp', 'rw+');
   			$options[CURLOPT_STDERR] = $curlError;
		}
		
		$options = array();
   		$options[CURLOPT_URL] = $signedUrl['signed_url'];
   		$options[CURLOPT_VERBOSE] = 1;
    	$options[CURLOPT_RETURNTRANSFER] = 1;
    	$options[CURLOPT_SSL_VERIFYPEER] = false;
		
		#Add these options if the user is posting data
		if (!empty($postData))
    	{	
       		#Define the header documents
   			$httpHeaders = array(
   		  		'Content-Type:application/xml',
   		   		'Content-Length:'.strlen($postData),
   		   		'Content-Language:en-US',
   		   		'Authorization:'. $signedUrl['header'],
   		   		'Host:'. FINANCIAL_FEED_HOST
   			);
			
			$options[CURLOPT_HTTPHEADER] = $httpHeaders;
			$options[CURLOPT_POST] = true;
			$options[CURLOPT_POSTFIELDS] = $postData;
			$options[CURLOPT_HEADER] = 1;
		}
		
		#Add the options to the CURL Channel for execution
		$ch = curl_init();
		curl_setopt_array($ch, $options);
    	
		#Run CURL
		$r = curl_exec($ch);
		curl_close($ch);
		parse_str($r, $returned_items);	
		$responseXML = substr($r, strpos($r, "<" . "?xml"));
		
		return json_decode(json_encode((array)simplexml_load_string($responseXML)), TRUE);
	}
	
	
	
	#Function to return a signed URL
	public function get_signed_url($url, $action, $signatures)
    {
        $oauthObject = new OAuthSimple();
        $oauthObject->setAction($action);
        $oauthObject->reset();

        $result = $oauthObject->sign(
        	array(
            	'path'      => $url,
            	'parameters'=> array
            	(
                 	'oauth_signature_method' => 'HMAC-SHA1',
                	 'Host'=> FINANCIAL_FEED_HOST
           		),
            	'signatures' => $signatures
          	)
      	);

    	return $result;
	}

	
	
	
	#Function to get the URL signature to authenticate the connection to the API
	public function get_url_signatures($tokens)
	{
		return array( 'consumer_key'     => OAUTH_CONSUMER_KEY,
                     'shared_secret'    => OAUTH_SHARED_SECRET,
                     'oauth_token'      => $tokens['oauth_token'],
                     'oauth_secret'     => $tokens['oauth_token_secret']);
	}

	
	
	
	#Convert XML object to array 
	public function get_heading_conversions($headingKey) 
	{
   		$headings = array('institutionId'=>'Institution ID', 'institutionName'=>'Institution Name', 'homeUrl'=>'Home URL', 'phoneNumber'=>'Phone Number', 'virtual'=>'Is Virtual');

   		return (!empty($headings[$headingKey])? $headings[$headingKey]: $headingKey);
	}
	
	
	#Function to move raw data to the system data
	public function move_raw_data($data_type)
	{
		$all_good = TRUE;
		
		if($data_type == 'institutions')
		{
			$raw_data = $this->db->query($this->query_reader->get_query_by_code('get_raw_institutions', array('query_part'=>'')))->result_array();
		
			#Now move each item one at a time
			foreach($raw_data AS $row)
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('conditional_add_new_institution', array('third_party_id'=>$row['institution_id'], 'institution_name'=>htmlentities($row['institution_name'], ENT_QUOTES), 'home_url'=>htmlentities($row['home_url'], ENT_QUOTES), 'phone_number'=>$row['phone_number'], 'is_virtual'=>$row['is_virtual'], 'third_party_status'=>$row['status'], 'address_line_1'=>$row['address'], 'email_address'=>$row['email_address'], 'special_text'=>htmlentities($row['special_text'], ENT_QUOTES), 'currency_code'=>$row['currency_code'], 'third_party_keys'=>htmlentities($row['keys'], ENT_QUOTES) )));
			
				$all_good = $result? TRUE: FALSE;
			}
		}
		
		return $all_good;
	}
	
	
	
	
	#Function to generate XML for communicating with the API
	public function generate_intuit_api_xml($action, $details=array())
	{
		$xml = "";
		if($action == 'login')
		{
			$keys = $this->db->query($this->query_reader->get_query_by_code('get_key_list', array('institution_id'=>$details['bankid'], 'key_type'=>'credentials', 'display_flags'=>"'true'")))->result_array();
			
			$xml .= "<InstitutionLogin xmlns=\"".$details['action_url']."\">
    					<credentials>";
			
			foreach($keys AS $row)
			{
				$xml .= "<credential> <name>".$row['name']."</name> <value>".(($this->get_key_type($row['name']) == 'username')? $details['username']: $details['user_password'])."</value>  </credential>";
			}
			
			$xml .= "	</credentials>
					</InstitutionLogin>";
		}
		
		return $xml;
	}
	
	
	
	#Function to check the key type
	public 	function get_key_type($keyName)
	{
		$keyMatches['username'] = array('Banking Userid', 'User Name');
		$keyMatches['userpassword'] = array('Banking Password', 'User Password', 'Password');
		
		if(in_array($keyName, $keyMatches['username']))
		{
			return 'username';
		}
		else if(in_array($keyName, $keyMatches['userpassword']))
		{
			return 'password';
		}
	}
	
	
	
	
	#Function to import transaction data
	public function import_transaction_data($oauthTokens, $accountList, $userId, $dateRange=array() ) 
	{
		$importResult = FALSE;
		$dateRange['start_date'] = !empty($dateRange['start_date'])? $dateRange['start_date']: date('Y-m-d');
		$dateRange['end_date'] = !empty($dateRange['end_date'])? $dateRange['end_date']: '';
		
		#1. Get all the user accounts in the submitted info
		$accountListDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_bank_account', array('user_id'=>$userId, 'query_part'=>" AND account_id IN ('".implode("','", $accountList)."') ORDER BY DATE(last_sync_date) ")))->result_array();
		
		#2. Determine the actual start days for each account
		foreach($accountListDetails AS $row)
		{
			$skipSync = "NO";#Should we skip syncing the data for this account?
			
			if(strtotime($row['last_sync_date']) > strtotime($dateRange['start_date']))
			{
				$dateRange['start_date'] = $row['last_sync_date'];
			}
			
			if(strtotime($row['last_sync_date']) > strtotime($dateRange['end_date']))
			{
				$skipSync = "YES";
			}
			
			if($skipSync == 'NO')
			{
				#3. Pull the transaction data
				$xmlData = $this->get_data_by_api($oauthTokens, FINANCIAL_FEED_URL .'v1/accounts/'.$row['account_id'].'/transactions?txnStartDate='.$dateRange['start_date'].(!empty($dateRange['end_date'])? "&txnEndDate=".$dateRange['end_date']: ""), 600, '', 'get_account_transactions');
				
				#print_r($xmlData);
				#echo "<BR><BR>";
				#4. Save the raw data and Update live transaction database info
				$result = $this->save_imported_data($xmlData, 'transaction_list', $userId);
				
			}
		}
		
		
		
		
		
		return $importResult;
	}
	
	
	
	
	
	#Fucntion to save imported data
	public function save_imported_data($xmlData, $dataType, $userId)
	{
		$saveResult = array();
		
		
		#==================================================
		#User Transactions
		#==================================================
		if($dataType == 'transaction_list')
		{
			foreach($xmlData['TransactionList'] AS $key=>$dataList)
			{
				$keyParts = explode(':',$key);
				$subKey = (count($keyParts) > 1)? $keyParts[0]: '';
				
				#If it is a single row, make it a multiple row array
				$transactions = isset($dataList['id'])? array($dataList): $dataList;
				
				#What is the type of transaction?
				if(strpos($key, 'CreditCardTransaction') !== FALSE) $transactionType = 'credit_card';
				else if(strpos($key, 'BankingTransaction') !== FALSE) $transactionType = 'banking';
				else if(strpos($key, 'InvestmentBankingTransaction') !== FALSE) $transactionType = 'investment_banking';
				else if(strpos($key, 'InvestmentTransaction') !== FALSE) $transactionType = 'investment';
				else if(strpos($key, 'LoanTransaction') !== FALSE) $transactionType = 'loan';
				else if(strpos($key, 'RewardsTransaction') !== FALSE) $transactionType = 'rewards';
				else $transactionType = 'other';
					
				#Add each transaction as you read it
				foreach($transactions AS $row)
				{
					#Generate the list of variables for saving
					$variableData = array('transaction_id'=>$row['id'], 'transaction_type'=>$transactionType, 'currency_type'=>$row['currencyType'], 'institution_transaction_id'=>$row['institutionTransactionId'], 'correct_institution_transaction_id'=>(!empty($row['correctInstitutionTransactionId'])?$row['correctInstitutionTransactionId']:''), 'correct_action'=>(!empty($row['correctAction'])?$row['correctAction']:''), 'server_transaction_id'=>(!empty($row['serverTransactionId'])?$row['serverTransactionId']:''), 'check_number'=>(!empty($row['checkNumber'])?$row['checkNumber']:''), 'ref_number'=>(!empty($row['refNumber'])?$row['refNumber']:''), 'confirmation_number'=>(!empty($row['confirmationNumber'])?$row['confirmationNumber']:''), 'payee_id'=>(!empty($row['payeeId'])?$row['payeeId']:''), 'payee_name'=>(!empty($row['payeeName'])?$row['payeeName']:''), 'extended_payee_name'=>(!empty($row['extendedPayeeName'])?$row['extendedPayeeName']:''), 'memo'=>(!empty($row['memo'])?$row['memo']:''), 'type'=>(!empty($row['type'])?$row['type']:''), 'value_type'=>(!empty($row['valueType'])?$row['valueType']:''), 'currency_rate'=>(!empty($row['currencyRate'])?$row['currencyRate']:''), 'original_currency'=>(!empty($row['originalCurrency'])?$row['originalCurrency']:''), 'posted_date'=>(!empty($row['postedDate'])?date('Y-m-d H:i:s', strtotime($row['postedDate'])):'0000-00-00 00:00:00'), 'user_date'=>(!empty($row['userDate'])?date('Y-m-d H:i:s', strtotime($row['userDate'])):'0000-00-00 00:00:00'), 'available_date'=>(!empty($row['availableDate'])?date('Y-m-d H:i:s', strtotime($row['availableDate'])):'0000-00-00 00:00:00'), 'amount'=>(!empty($row['amount'])?$row['amount']:''), 'running_balance_amount'=>(!empty($row['runningBalanceAmount'])?$row['runningBalanceAmount']:''), 'pending'=>(!empty($row['pending'])?$row['pending']:''), 'latitude'=>'', 'longitude'=>'', 'zipcode'=>'', 'state'=>'', 'city'=>'', 'address'=>'', 'sub_category_id'=>'', 'contact_telephone'=>'', 'website'=>'', 'confidence_level'=>'', 'place_type'=>'', 
					
					'user_id'=>$userId, 'bank_id'=>'', 'api_account'=>'', 
			
					#Transaction categorization attributes
					'normalized_payee_name'=>(!empty($row['categorization']['common']['normalizedPayeeName'])?$row['categorization']['common']['normalizedPayeeName']:''), 
					'merchant'=>(!empty($row['categorization']['common']['merchant'])?$row['categorization']['common']['merchant']:''), 
					'sic'=>(!empty($row['categorization']['common']['sic'])?$row['categorization']['common']['sic']:''), 
						
					'source'=>(!empty($row['categorization']['context']['source'])?$row['categorization']['context']['source']:'intuit'), 
					'category_name'=>(!empty($row['categorization']['context']['categoryName'])?$row['categorization']['context']['categoryName']:''), 
					'context_type'=>(!empty($row['categorization']['context']['contextType'])?$row['categorization']['context']['contextType']:''), 
					'schedule_c'=>(!empty($row['categorization']['context']['scheduleC'])?$row['categorization']['context']['scheduleC']:''), 
						
						
					#Investment Banking related transactions
					'banking_transaction_type'=>(!empty($row['bankingTransactionType'])?$row['bankingTransactionType']:''), 'subaccount_fund_type'=>(!empty($row['subaccountFundType'])?$row['subaccountFundType']:''), 'banking_401k_source_type'=>(!empty($row['banking401KSourceType'])?$row['banking401KSourceType']:''), 
						
						
					#Loan related transactions
					'principal_amount'=>(!empty($row['principalAmount'])?$row['principalAmount']:''), 'interest_amount'=>(!empty($row['interestAmount'])?$row['interestAmount']:''), 'escrow_total_amount'=>(!empty($row['escrowTotalAmount'])?$row['escrowTotalAmount']:''), 'escrow_tax_amount'=>(!empty($row['escrowTaxAmount'])?$row['escrowTaxAmount']:''), 'escrow_insurance_amount'=>(!empty($row['escrowInsuranceAmount'])?$row['escrowInsuranceAmount']:''), 'escrow_pmi_amount'=>(!empty($row['escrowPmiAmount'])?$row['escrowPmiAmount']:''), 'escrow_fees_amount'=>(!empty($row['escrowFeesAmount'])?$row['escrowFeesAmount']:''), 'escrow_other_amount'=>(!empty($row['escrowOtherAmount'])?$row['escrowOtherAmount']:''),
					
					'query_part'=>" AND pending='true' ");
						
					#Does similar record already exist (if the transaction is still PENDING when it was first added)?
					$checkPendingRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_transaction', $variableData))->row_array();
					$checkRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_transaction', array('transaction_id'=>$row['id'], 'query_part'=>" AND pending='false' ")))->row_array();
					#Go here if the transaction has not been saved yet
					if(!empty($checkPendingRecord) || empty($checkRecord))
					{
						$result = $this->db->query($this->query_reader->get_query_by_code((!empty($checkRecord)?'update_raw_transaction': 'save_raw_transaction'), $variableData));
						array_push($saveResult, $result);
					}
					
					
					
					#What is the transaction table ID
					$rawTransactionId = !empty($checkRecord)? $checkRecord['id']: (!empty($checkPendingRecord)? $checkPendingRecord['id']: $this->db->insert_id());
					
					#Save extra information for an investment transaction
					if(strpos($key, 'InvestmentTransaction') !== FALSE)
					{
						$variableData = array_merge($variableData, array('raw_transaction_id'=>$rawTransactionId, 'reveral_institution_transaction_id'=>(!empty($row['reveralInstitutionTransactionId'])?$row['reveralInstitutionTransactionId']:''), 'description'=>(!empty($row['description'])?$row['description']:''), 'buy_type'=>(!empty($row['buyType'])?$row['buyType']:''), 'income_type'=>(!empty($row['incomeType'])?$row['incomeType']:''), 'inv_401k_source'=>(!empty($row['inv401kSource'])?$row['inv401kSource']:''), 'loan_id'=>(!empty($row['loanId'])?$row['loanId']:''), 'options_action_type'=>(!empty($row['optionsActionType'])?$row['optionsActionType']:''), 'options_buy_type'=>(!empty($row['optionsBuyType'])?$row['optionsBuyType']:''), 'options_sell_type'=>(!empty($row['optionsSellType'])?$row['optionsSellType']:''), 'position_type'=>(!empty($row['positionType'])?$row['positionType']:''), 'related_institution_trade_id'=>(!empty($row['relatedInstitutionTradeId'])?$row['relatedInstitutionTradeId']:''), 'related_option_trans_type'=>(!empty($row['relatedOptionTransType'])?$row['relatedOptionTransType']:''), 'secured_type'=>(!empty($row['securedType'])?$row['securedType']:''), 'sell_reason'=>(!empty($row['sellReason'])?$row['sellReason']:''), 'sell_type'=>(!empty($row['sellType'])?$row['sellType']:''), 'sub_account_from_type'=>(!empty($row['subaccountFromType'])?$row['subaccountFromType']:''), 'sub_account_fund_type'=>(!empty($row['subaccountFundType'])?$row['subaccountFundType']:''), 'sub_account_security_type'=>(!empty($row['subaccountSecurityType'])?$row['subaccountSecurityType']:''), 'sub_account_to_type'=>(!empty($row['subaccountToType'])?$row['subaccountToType']:''), 'transfer_action'=>(!empty($row['transferAction'])?$row['transferAction']:''), 'unit_type'=>(!empty($row['unitType'])?$row['unitType']:''), 'cusip'=>(!empty($row['cusip'])?$row['cusip']:''), 'symbol'=>(!empty($row['symbol'])?$row['symbol']:''), 'unit_action'=>(!empty($row['unitAction'])?$row['unitAction']:''), 'options_security'=>(!empty($row['optionsSecurity'])?$row['optionsSecurity']:''), 'trade_date'=>(!empty($row['tradeDate'])?date('Y-m-d H:i:s', strtotime($row['tradeDate'])):'0000-00-00 00:00:00'), 'settle_date'=>(!empty($row['settleDate'])?date('Y-m-d H:i:s', strtotime($row['settleDate'])):'0000-00-00 00:00:00'), 'accrued_interest_amount'=>(!empty($row['accruedInterestAmount'])?$row['accruedInterestAmount']:''), 'average_cost_basis_amount'=>(!empty($row['averageCostBasisAmount'])?$row['averageCostBasisAmount']:''), 'commission_amount'=>(!empty($row['commisionAmount'])?$row['commisionAmount']:''), 'denominator'=>(!empty($row['denominator'])?$row['denominator']:''), 'payroll_date'=>(!empty($row['payrollDate'])?date('Y-m-d H:i:s', strtotime($row['payrollDate'])):'0000-00-00 00:00:00'), 'purchase_date'=>(!empty($row['purchaseDate'])?date('Y-m-d H:i:s', strtotime($row['purchaseDate'])):'0000-00-00 00:00:00'), 'gain_amount'=>(!empty($row['gainAmount'])?$row['gainAmount']:''), 'fees_amount'=>(!empty($row['feesAmount'])?$row['feesAmount']:''), 'fractional_units_cash_amount'=>(!empty($row['fractionalUnitsCashAmount'])?$row['fractionalUnitsCashAmount']:''), 'load_amount'=>(!empty($row['loadAmount'])?$row['loadAmount']:''), 'loan_interest_amount'=>(!empty($row['loanInterestAmount'])?$row['loanInterestAmount']:''), 'loan_principal_amount'=>(!empty($row['loanPrincipalAmount'])?$row['loanPrincipalAmount']:''), 'markdown_amount'=>(!empty($row['markdownAmount'])?$row['markdownAmount']:''), 'markup_amount'=>(!empty($row['markupAmount'])?$row['markupAmount']:''), 'new_units'=>(!empty($row['newUnits'])?$row['newUnits']:''), 'numerator'=>(!empty($row['numerator'])?$row['numerator']:''), 'old_units'=>(!empty($row['oldUnits'])?$row['oldUnits']:''), 'penalty_amount'=>(!empty($row['penaltyAmount'])?$row['penaltyAmount']:''), 'prior_year_contribution'=>(!empty($row['priorYearContribution'])?$row['priorYearContribution']:''), 'shares_per_contract'=>(!empty($row['sharesPerContract'])?$row['sharesPerContract']:''), 'state_withholding'=>(!empty($row['stateWithholding'])?$row['stateWithholding']:''), 'total_amount'=>(!empty($row['totalAmount'])?$row['totalAmount']:''), 'taxes_amount'=>(!empty($row['taxesAmount'])?$row['taxesAmount']:''), 'tax_exempt'=>(!empty($row['taxExempt'])?$row['taxExempt']:''), 'unit_price'=>(!empty($row['unitPrice'])?$row['unitPrice']:''), 'withholding_amount'=>(!empty($row['withholdingAmount'])?$row['withholdingAmount']:''), 'options_shares_per_contract'=>(!empty($row['optionsSharesPerContract'])?$row['optionsSharesPerContract']:'') ));
						
						$result = $this->db->query($this->query_reader->get_query_by_code((!empty($checkRecord)?'update_raw_investment_transaction': 'save_raw_investment_transaction'), $variableData));
						array_push($saveResult, $result);
					}
					
					
					#Update the system clout transaction
					#1. First get the store where they bought the item
					$storeDetails = $this->db->query($this->query_reader->get_query_by_code('get_store_by_attributes', array('query_part'=>" (S.third_party_id='".(!empty($row['payeeId'])?$row['payeeId']:'NONE')."' OR UPPER(S.name)= '".(!empty($row['payeeName'])? strtoupper($row['payeeName']): (!empty($row['normalizedPayeeName'])? strtoupper($row['normalizedPayeeName']): (!empty($row['extendedPayeeName'])? strtoupper($row['extendedPayeeName']): 'NONE') ))."') ")))->row_array();
					
					#2. Then get the start and end dates
					if(strpos($key, 'InvestmentTransaction') !== FALSE)
					{
						$startDate = (!empty($row['tradeDate'])? $row['tradeDate']: (!empty($row['purchaseDate'])? $row['purchaseDate']: (!empty($row['postedDate'])? $row['postedDate']: '') )); 
					}
					else
					{
						$startDate = (!empty($row['postedDate'])? $row['postedDate']: (!empty($row['userDate'])? $row['userDate']: ''));
					}
					
					if(strpos($key, 'InvestmentTransaction') !== FALSE)
					{
						$endDate = (!empty($row['settleDate'])? $row['settleDate']: (!empty($row['postedDate'])? $row['postedDate']: '' )); 
					}
					else
					{
						$endDate = (!empty($row['availableDate'])? $row['availableDate']: (!empty($row['userDate'])? $row['userDate']: (!empty($row['postedDate'])? $row['postedDate']: '')));
					}
					
					
					#Only save this if there is a store related to the product 
					if(!empty($storeDetails))
					{
						$checkSummaryRecord = $this->db->query($this->query_reader->get_query_by_code('get_user_transactions', array('query_part'=>" AND related_transaction_id='".$rawTransactionId."' ", 'user_id'=>$userId)))->row_array();
						
						$result = $this->db->query($this->query_reader->get_query_by_code((!empty($checkSummaryRecord)?'update_clout_transaction': 'save_clout_transaction'), array('transaction_type'=>(in_array($transactionType, array('banking', 'rewards', 'credit_card'))? ((!empty($row['amount']) && $row['amount'] < 0)? 'buy': 'sell'): 'other'), 
						'user_id'=>$userId, 
						'store_id'=>$storeDetails['id'], 
						'status'=>((!empty($row['pending']) && $row['pending']=='true')?'pending':'complete'), 
						'transaction_currency'=>$row['currencyType'], 
						'currency_rate'=>(!empty($row['currencyRate'])?$row['currencyRate']:'1'), 
						'amount'=>((strpos($key, 'LoanTransaction') !== FALSE && !empty($row['principalAmount']))?$row['principalAmount']:((strpos($key, 'InvestmentTransaction') !== FALSE && !empty($row['totalAmount']))?$row['totalAmount']:(!empty($row['amount'])?$row['amount']:''))), 
						'related_transaction_id'=>$rawTransactionId, 
						'start_date'=>(!empty($startDate)?date('Y-m-d H:i:s', strtotime($startDate)):date('Y-m-d H:i:s', strtotime('now'))), 
						'end_date'=>(!empty($endDate)?date('Y-m-d H:i:s', strtotime($endDate)):date('Y-m-d H:i:s', strtotime('now'))), 
						'source_account_id'=>'', 
						'item_id'=>(!empty($row['confirmationNumber'])? $row['confirmationNumber']: (!empty($row['refNumber'])? $row['refNumber']: '')), 
						'item_name'=>(!empty($row['categorization']['context']['scheduleC'])?$row['categorization']['context']['scheduleC']:(!empty($row['categorization']['context']['categoryName'])?$row['categorization']['context']['categoryName']:'')), 
						'item_value'=>(!empty($row['amount'])?$row['amount']:''), 
						'transaction_tax'=>((strpos($key, 'LoanTransaction') !== FALSE && !empty($row['escrowTaxAmount']))?$row['escrowTaxAmount']:((strpos($key, 'InvestmentTransaction') !== FALSE && !empty($row['taxesAmount']))?$row['taxesAmount']:'')), 
						'merchant_transaction_number'=>(!empty($row['correctInstitutionTransactionId'])? $row['correctInstitutionTransactionId']: (!empty($row['institutionTransactionId'])? $row['institutionTransactionId']: '')), 
						'payment_gateway_id'=>'', 
						'payment_gateway_fees'=>'', 
						'terminal_id'=>'', 
						'cashier_id'=>'', 
						'item_quantity'=>'1', 
						'transaction_description'=>(!empty($row['memo'])?$row['memo']:''), 
						'is_security_risk'=>'',
						'sub_category_id'=>''  )));
					
						array_push($saveResult, $result);
					}
					
				}
				
			}
		
		}
		
		
		
		
		#==================================================
		#User accounts 
		#==================================================
		else if($dataType == 'account_list')
		{
			foreach($xmlData['AccountList'] AS $key=>$dataList)
			{
				$keyParts = explode(':',$key);
				$subKey = (count($keyParts) > 1)? $keyParts[0]: '';
				
				#If it is a single row, make it a multiple row array
				$accountGroup = isset($dataList['accountId'])? array($dataList): $dataList;
					
				#Credit accounts
				if(strpos($key, 'CreditAccount') !== FALSE)
				{
					#Add each account to the raw data
					foreach($accountGroup AS $row)
					{
						$variableData = array('account_id'=>$row['accountId'], 'user_id'=>$userId, 'status'=>(!empty($row['status'])?$row['status']:''), 'account_number'=>$row['accountNumber'], 'account_number_real'=>(!empty($row['accountNumberReal'])?$row['accountNumberReal']:''), 'account_nickname'=>$row['accountNickname'], 'display_position'=>$row['displayPosition'], 'institution_id'=>$row['institutionId'], 'description'=>(!empty($row['description'])?$row['description']:''), 'registered_user_name'=>(!empty($row['registeredUserName'])?$row['registeredUserName']:''), 'balance_amount'=>(!empty($row['balanceAmount'])?$row['balanceAmount']:''), 'balance_date'=>(!empty($row['balanceDate'])?date('Y-m-d H:i:s', strtotime($row['balanceDate'])):'0000-00-00 00:00:00'), 'balance_previous_amount'=>(!empty($row['balancePreviousAmount'])?$row['balancePreviousAmount']:''), 'last_transaction_date'=>(!empty($row['lastTxnDate'])?date('Y-m-d H:i:s', strtotime($row['lastTxnDate'])):'0000-00-00 00:00:00'), 'aggr_success_date'=>(!empty($row['aggrSuccessDate'])?date('Y-m-d H:i:s', strtotime($row['aggrSuccessDate'])):'0000-00-00 00:00:00'), 'aggr_attempt_date'=>(!empty($row['aggrAttemptDate'])?date('Y-m-d H:i:s', strtotime($row['aggrAttemptDate'])):'0000-00-00 00:00:00'), 'aggr_status_code'=>(!empty($row['aggrStatusCode'])?$row['aggrStatusCode']:''), 'currency_code'=>$row['currencyCode'], 'bank_id'=>(!empty($row['bankId'])?$row['bankId']:''),  	'institution_login_id'=>(!empty($row['institutionLoginId'])?$row['institutionLoginId']:''), 'credit_account_type'=>(!empty($row[$subKey.':creditAccountType'])?$row[$subKey.':creditAccountType']:''), 'detailed_description'=>(!empty($row[$subKey.':detailedDescription'])?$row[$subKey.':detailedDescription']:''), 'interest_rate'=>(!empty($row[$subKey.':interestRate'])?$row[$subKey.':interestRate']:'0.0'), 'credit_available_amount'=>(!empty($row[$subKey.':creditAvailableAmount'])?$row[$subKey.':creditAvailableAmount']:'0.0'), 'credit_max_amount'=>(!empty($row[$subKey.':creditMaxAmount'])?$row[$subKey.':creditMaxAmount']:'0.0'), 'cash_advance_available_amount'=>(!empty($row[$subKey.':cashAdvanceAvailableAmount'])?$row[$subKey.':cashAdvanceAvailableAmount']:'0.0'), 'cash_advance_max_amount'=>(!empty($row[$subKey.':cashAdvanceMaxAmount'])?$row[$subKey.':cashAdvanceMaxAmount']:'0.0'), 'cash_advance_balance'=>(!empty($row[$subKey.':cashAdvanceBalance'])?$row[$subKey.':cashAdvanceBalance']:'0.0'), 'cash_advance_interest_rate'=>(!empty($row[$subKey.':cashAdvanceInterestRate'])?$row[$subKey.':cashAdvanceInterestRate']:'0.0'), 'current_balance'=>(!empty($row[$subKey.':currentBalance'])?$row[$subKey.':currentBalance']:'0.0'), 'payment_min_amount'=>(!empty($row[$subKey.':paymentMinAmount'])?$row[$subKey.':paymentMinAmount']:'0.0'), 'payment_due_date'=>(!empty($row[$subKey.':paymentDueDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':paymentDueDate'])):'0000-00-00 00:00:00'), 'previous_balance'=>(!empty($row[$subKey.':previousBalance'])?$row[$subKey.':previousBalance']:'0.0'), 'statement_end_date'=>(!empty($row[$subKey.':statementEndDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':statementEndDate'])):'0000-00-00 00:00:00'), 'statement_purchase_amount'=>(!empty($row[$subKey.':statementPurchaseAmount'])?$row[$subKey.':statementPurchaseAmount']:'0.0'), 'statement_finance_amount'=>(!empty($row[$subKey.':statementFinanceAmount'])?$row[$subKey.':statementFinanceAmount']:'0.0'), 'past_due_amount'=>(!empty($row[$subKey.':pastDueAmount'])?$row[$subKey.':pastDueAmount']:'0.0'), 'last_payment_amount'=>(!empty($row[$subKey.':lastPaymentAmount'])?$row[$subKey.':lastPaymentAmount']:'0.0'), 'last_payment_date'=>(!empty($row[$subKey.':lastPaymentDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':lastPaymentDate'])):'0000-00-00 00:00:00'), 'statement_close_balance'=>(!empty($row[$subKey.':statementCloseBalance'])?$row[$subKey.':statementCloseBalance']:'0.0'), 'statement_late_fee_amount'=>(!empty($row[$subKey.':statementLateFeeAmount'])?$row[$subKey.':statementLateFeeAmount']:'0.0'), 'raw_table_name'=>'raw_credit_accounts'    );
						
						#Does similar record already exist?
						$checkRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_account', $variableData))->row_array();
						$result = $this->db->query($this->query_reader->get_query_by_code((!empty($checkRecord)?'update_raw_credit_account': 'save_raw_credit_account'), $variableData));
						
						array_push($saveResult, $result);
					}
				}
				
				
				
				#Banking accounts (Normal) or Other accounts
				else if(strpos($key, 'BankingAccount') !== FALSE || strpos($key, 'OtherAccount') !== FALSE)
				{
					#Add each account to the raw data
					foreach($accountGroup AS $row)
					{
						$variableData = array('account_id'=>$row['accountId'], 'user_id'=>$userId, 'status'=>(!empty($row['status'])?$row['status']:''), 'account_number'=>$row['accountNumber'], 'account_number_real'=>(!empty($row['accountNumberReal'])?$row['accountNumberReal']:''), 'account_nickname'=>$row['accountNickname'], 'display_position'=>$row['displayPosition'], 'institution_id'=>$row['institutionId'], 'description'=>"INTUIT - ".(!empty($row['description'])?$row['description']:''), 'registered_user_name'=>(!empty($row['registeredUserName'])?$row['registeredUserName']:''), 'balance_amount'=>(!empty($row['balanceAmount'])?$row['balanceAmount']:''), 'balance_date'=>(!empty($row['balanceDate'])?date('Y-m-d H:i:s', strtotime($row['balanceDate'])):'0000-00-00 00:00:00'), 'balance_previous_amount'=>(!empty($row['balancePreviousAmount'])?$row['balancePreviousAmount']:''), 'last_transaction_date'=>(!empty($row['lastTxnDate'])?date('Y-m-d H:i:s', strtotime($row['lastTxnDate'])):'0000-00-00 00:00:00'), 'aggr_success_date'=>(!empty($row['aggrSuccessDate'])?date('Y-m-d H:i:s', strtotime($row['aggrSuccessDate'])):'0000-00-00 00:00:00'), 'aggr_attempt_date'=>(!empty($row['aggrAttemptDate'])?date('Y-m-d H:i:s', strtotime($row['aggrAttemptDate'])):'0000-00-00 00:00:00'), 'aggr_status_code'=>(!empty($row['aggrStatusCode'])?$row['aggrStatusCode']:''), 'currency_code'=>$row['currencyCode'], 'bank_id'=>(!empty($row['bankId'])?$row['bankId']:''),  	'institution_login_id'=>(!empty($row['institutionLoginId'])?$row['institutionLoginId']:''), 'banking_account_type'=>(!empty($row[$subKey.':bankingAccountType'])?$row[$subKey.':bankingAccountType']:''), 'posted_date'=>(!empty($row[$subKey.':postedDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':postedDate'])):'0000-00-00 00:00:00'), 'available_balance_amount'=>(!empty($row[$subKey.':availableBalanceAmount'])?$row[$subKey.':availableBalanceAmount']:'0.0'), 'interest_type'=>(!empty($row[$subKey.':interestType'])?$row[$subKey.':interestType']:''), 'origination_date'=>(!empty($row[$subKey.':originationDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':originationDate'])):'0000-00-00 00:00:00'), 'open_date'=>(!empty($row[$subKey.':openDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':openDate'])):'0000-00-00 00:00:00'), 'period_interest_rate'=>(!empty($row[$subKey.':periodInterestRate'])?$row[$subKey.':periodInterestRate']:'0.0'), 'period_deposit_amount'=>(!empty($row[$subKey.':periodDepositAmount'])?$row[$subKey.':periodDepositAmount']:'0.0'), 'period_interest_amount'=>(!empty($row[$subKey.':periodInterestAmount'])?$row[$subKey.':periodInterestAmount']:'0.0'), 'interest_amount_ytd'=>(!empty($row[$subKey.':interestAmountYtd'])?$row[$subKey.':interestAmountYtd']:'0.0'), 'interest_prior_amount_ytd'=>(!empty($row[$subKey.':interestPriorAmountYtd'])?$row[$subKey.':interestPriorAmountYtd']:'0.0'), 'maturity_date'=>(!empty($row[$subKey.':maturityDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':maturityDate'])):'0000-00-00 00:00:00'), 'maturity_amount'=>(!empty($row[$subKey.':maturityAmount'])?$row[$subKey.':maturityAmount']:'0.0'), 'raw_table_name'=>'raw_bank_accounts'   );
						
						
						#Does similar record already exist?
						$checkRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_account', $variableData))->row_array();
						$result = $this->db->query($this->query_reader->get_query_by_code((!empty($checkRecord)?'update_raw_bank_account': 'save_raw_bank_account'), $variableData));
						
						array_push($saveResult, $result);
					}
				}
				
				
				
				#Investment accounts
				else if(strpos($key, 'InvestmentAccount') !== FALSE)
				{
					#Add each account to the raw data
					foreach($accountGroup AS $row)
					{
						$variableData = array('account_id'=>$row['accountId'], 'user_id'=>$userId, 'status'=>(!empty($row['status'])?$row['status']:''), 'account_number'=>$row['accountNumber'], 'account_number_real'=>(!empty($row['accountNumberReal'])?$row['accountNumberReal']:''), 'account_nickname'=>$row['accountNickname'], 'display_position'=>$row['displayPosition'], 'institution_id'=>$row['institutionId'], 'description'=>"INTUIT - ".(!empty($row['description'])?$row['description']:''), 'registered_user_name'=>(!empty($row['registeredUserName'])?$row['registeredUserName']:''), 'balance_amount'=>(!empty($row['balanceAmount'])?$row['balanceAmount']:''), 'balance_date'=>(!empty($row['balanceDate'])?date('Y-m-d H:i:s', strtotime($row['balanceDate'])):'0000-00-00 00:00:00'), 'balance_previous_amount'=>(!empty($row['balancePreviousAmount'])?$row['balancePreviousAmount']:''), 'last_transaction_date'=>(!empty($row['lastTxnDate'])?date('Y-m-d H:i:s', strtotime($row['lastTxnDate'])):'0000-00-00 00:00:00'), 'aggr_success_date'=>(!empty($row['aggrSuccessDate'])?date('Y-m-d H:i:s', strtotime($row['aggrSuccessDate'])):'0000-00-00 00:00:00'), 'aggr_attempt_date'=>(!empty($row['aggrAttemptDate'])?date('Y-m-d H:i:s', strtotime($row['aggrAttemptDate'])):'0000-00-00 00:00:00'), 'aggr_status_code'=>(!empty($row['aggrStatusCode'])?$row['aggrStatusCode']:''), 'currency_code'=>$row['currencyCode'], 'bank_id'=>(!empty($row['bankId'])?$row['bankId']:''),  	'institution_login_id'=>(!empty($row['institutionLoginId'])?$row['institutionLoginId']:''),'investment_account_type'=>(!empty($row[$subKey.':investmentAccountType'])?$row[$subKey.':investmentAccountType']:''), 'interest_margin_balance'=>(!empty($row[$subKey.':interestMarginBalance'])?$row[$subKey.':interestMarginBalance']:'0.0'), 'short_balance'=>(!empty($row[$subKey.':shortBalance'])?$row[$subKey.':shortBalance']:'0.0'), 'available_cash_balance'=>(!empty($row[$subKey.':availableCashBalance'])?$row[$subKey.':availableCashBalance']:'0.0'), 'current_balance'=>(!empty($row[$subKey.':currentBalance'])?$row[$subKey.':currentBalance']:'0.0'), 'maturity_value_amount'=>(!empty($row[$subKey.':maturityValueAmount'])?$row[$subKey.':maturityValueAmount']:'0.0'), 'unvested_balance'=>(!empty($row[$subKey.':unvestedBalance'])?$row[$subKey.':unvestedBalance']:'0.0'), 'vested_balance'=>(!empty($row[$subKey.':vestedBalance'])?$row[$subKey.':vestedBalance']:'0.0'), 'employee_match_defer_amount'=>(!empty($row[$subKey.':empMatchDeferAmount'])?$row[$subKey.':empMatchDeferAmount']:'0.0'), 'employee_match_defer_amount_ytd'=>(!empty($row[$subKey.':empMatchDeferAmountYtd'])?$row[$subKey.':empMatchDeferAmountYtd']:'0.0'), 'employee_match_amount'=>(!empty($row[$subKey.':empMatchAmount'])?$row[$subKey.':empMatchAmount']:'0.0'), 'employee_match_amount_ytd'=>(!empty($row[$subKey.':empMatchAmountYtd'])?$row[$subKey.':empMatchAmountYtd']:'0.0'), 'employee_pretax_contribution_amount'=>(!empty($row[$subKey.':empPretaxContribAmount'])?$row[$subKey.':empPretaxContribAmount']:'0.0'), 'employee_pretax_contribution_amount_ytd'=>(!empty($row[$subKey.':empPretaxContribAmountYtd'])?$row[$subKey.':empPretaxContribAmountYtd']:'0.0'), 'rollover_itd'=>(!empty($row[$subKey.':rolloverItd'])?$row[$subKey.':rolloverItd']:''), 'cash_balance_amount'=>(!empty($row[$subKey.':cashBalanceAmount'])?$row[$subKey.':cashBalanceAmount']:'0.0'), 'initial_loan_balance'=>(!empty($row[$subKey.':initialLoanBalance'])?$row[$subKey.':initialLoanBalance']:'0.0'), 'loan_start_date'=>(!empty($row[$subKey.':loanStartDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':loanStartDate'])):'0000-00-00 00:00:00'), 'current_loan_balance'=>(!empty($row[$subKey.':currentLoanBalance'])?$row[$subKey.':currentLoanBalance']:'0.0'), 'loan_rate'=>(!empty($row[$subKey.':loanRate'])?$row[$subKey.':loanRate']:'0.0'), 'raw_table_name'=>'raw_investment_accounts' );
						
						
						#Does similar record already exist?
						$checkRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_account', $variableData))->row_array();
						$result = $this->db->query($this->query_reader->get_query_by_code((!empty($checkRecord)?'update_raw_investment_account': 'save_raw_investment_account'), $variableData));
						
						array_push($saveResult, $result);
					}
				}
				
				
				
				#Loan accounts
				else if(strpos($key, 'LoanAccount') !== FALSE)
				{
					#Add each account to the raw data
					foreach($accountGroup AS $row)
					{
						$variableData = array('account_id'=>$row['accountId'], 'user_id'=>$userId, 'status'=>(!empty($row['status'])?$row['status']:''), 'account_number'=>$row['accountNumber'], 'account_number_real'=>(!empty($row['accountNumberReal'])?$row['accountNumberReal']:''), 'account_nickname'=>$row['accountNickname'], 'display_position'=>$row['displayPosition'], 'institution_id'=>$row['institutionId'], 'description'=>(!empty($row['description'])?$row['description']:''), 'registered_user_name'=>(!empty($row['registeredUserName'])?$row['registeredUserName']:''), 'balance_amount'=>(!empty($row['balanceAmount'])?$row['balanceAmount']:''), 'balance_date'=>(!empty($row['balanceDate'])?date('Y-m-d H:i:s', strtotime($row['balanceDate'])):'0000-00-00 00:00:00'), 'balance_previous_amount'=>(!empty($row['balancePreviousAmount'])?$row['balancePreviousAmount']:''), 'last_transaction_date'=>(!empty($row['lastTxnDate'])?date('Y-m-d H:i:s', strtotime($row['lastTxnDate'])):'0000-00-00 00:00:00'), 'aggr_success_date'=>(!empty($row['aggrSuccessDate'])?date('Y-m-d H:i:s', strtotime($row['aggrSuccessDate'])):'0000-00-00 00:00:00'), 'aggr_attempt_date'=>(!empty($row['aggrAttemptDate'])?date('Y-m-d H:i:s', strtotime($row['aggrAttemptDate'])):'0000-00-00 00:00:00'), 'aggr_status_code'=>(!empty($row['aggrStatusCode'])?$row['aggrStatusCode']:''), 'currency_code'=>$row['currencyCode'], 'bank_id'=>(!empty($row['bankId'])?$row['bankId']:''),  	'institution_login_id'=>(!empty($row['institutionLoginId'])?$row['institutionLoginId']:''),'loan_description'=>(!empty($row[$subKey.':loanDescription'])?$row[$subKey.':loanDescription']:''), 'loan_type'=>(!empty($row[$subKey.':loanType'])?$row[$subKey.':loanType']:''), 'posted_date'=>(!empty($row[$subKey.':postedDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':postedDate'])):'0000-00-00 00:00:00'), 'term'=>(!empty($row[$subKey.':term'])?$row[$subKey.':term']:''), 'holder_name'=>(!empty($row[$subKey.':holderName'])?$row[$subKey.':holderName']:''), 'late_fee_amount'=>(!empty($row[$subKey.':lateFeeAmount'])?$row[$subKey.':lateFeeAmount']:'0.0'), 'payoff_amount'=>(!empty($row[$subKey.':payoffAmount'])?$row[$subKey.':payoffAmount']:'0.0'), 'payoff_amount_date'=>(!empty($row[$subKey.':payoffAmountDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':payoffAmountDate'])):'0000-00-00 00:00:00'), 'reference_number'=>(!empty($row[$subKey.':referenceNumber'])?$row[$subKey.':referenceNumber']:''), 'original_maturity_date'=>(!empty($row[$subKey.':originalMaturityDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':originalMaturityDate'])):'0000-00-00 00:00:00'), 'tax_payee_name'=>(!empty($row[$subKey.':taxPayeeName'])?$row[$subKey.':taxPayeeName']:''), 'principal_balance'=>(!empty($row[$subKey.':principalBalance'])?$row[$subKey.':principalBalance']:'0.0'), 'escrow_balance'=>(!empty($row[$subKey.':escrowBalance'])?$row[$subKey.':escrowBalance']:'0.0'), 'interest_rate'=>(!empty($row[$subKey.':interestRate'])?$row[$subKey.':interestRate']:'0.0'), 'interest_period'=>(!empty($row[$subKey.':interestPeriod'])?$row[$subKey.':interestPeriod']:''), 'initial_amount'=>(!empty($row[$subKey.':initialAmount'])?$row[$subKey.':initialAmount']:'0.0'), 'initial_date'=>(!empty($row[$subKey.':initialDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':initialDate'])):'0000-00-00 00:00:00'), 'next_payment_principal_amount'=>(!empty($row[$subKey.':nextPaymentPrincipalAmount'])?$row[$subKey.':nextPaymentPrincipalAmount']:'0.0'), 'next_payment_interest_amount'=>(!empty($row[$subKey.':nextPaymentInterestAmount'])?$row[$subKey.':nextPaymentInterestAmount']:'0.0'), 'next_payment'=>(!empty($row[$subKey.':nextPayment'])?$row[$subKey.':nextPayment']:'0.0'), 'next_payment_date'=>(!empty($row[$subKey.':nextPaymentDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':nextPaymentDate'])):'0000-00-00 00:00:00'), 'last_payment_due_date'=>(!empty($row[$subKey.':lastPaymentDueDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':lastPaymentDueDate'])):'0000-00-00 00:00:00'), 'last_payment_receive_date'=>(!empty($row[$subKey.':lastPaymentReceiveDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':lastPaymentReceiveDate'])):'0000-00-00 00:00:00'), 'last_payment_amount'=>(!empty($row[$subKey.':lastPaymentAmount'])?$row[$subKey.':lastPaymentAmount']:'0.0'), 'last_payment_principal_amount'=>(!empty($row[$subKey.':lastPaymentPrincipalAmount'])?$row[$subKey.':lastPaymentPrincipalAmount']:'0.0'), 'last_payment_interest_amount'=>(!empty($row[$subKey.':lastPaymentInterestAmount'])?$row[$subKey.':lastPaymentInterestAmount']:'0.0'), 'last_payment_escrow_amount'=>(!empty($row[$subKey.':lastPaymentEscrowAmount'])?$row[$subKey.':lastPaymentEscrowAmount']:'0.0'), 'last_payment_last_fee_amount'=>(!empty($row[$subKey.':lastPaymentLastFeeAmount'])?$row[$subKey.':lastPaymentLastFeeAmount']:'0.0'), 'last_payment_late_charge'=>(!empty($row[$subKey.':lastPaymentLateCharge'])?$row[$subKey.':lastPaymentLateCharge']:'0.0'), 'principal_paid_ytd'=>(!empty($row[$subKey.':principalPaidYTD'])?$row[$subKey.':principalPaidYTD']:'0.0'), 'interest_paid_ytd'=>(!empty($row[$subKey.':interestPaidYTD'])?$row[$subKey.':interestPaidYTD']:'0.0'), 'insurance_paid_ytd'=>(!empty($row[$subKey.':insurancePaidYTD'])?$row[$subKey.':insurancePaidYTD']:'0.0'), 'tax_paid_ytd'=>(!empty($row[$subKey.':taxPaidYTD'])?$row[$subKey.':taxPaidYTD']:'0.0'), 'auto_pay_enrolled'=>(!empty($row[$subKey.':autoPayEnrolled'])?$row[$subKey.':autoPayEnrolled']:'false'), 'collateral'=>(!empty($row[$subKey.':collateral'])?$row[$subKey.':collateral']:''), 'current_school'=>(!empty($row[$subKey.':currentSchool'])?$row[$subKey.':currentSchool']:''), 'first_payment_date'=>(!empty($row[$subKey.':firstPaymentDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':firstPaymentDate'])):'0000-00-00 00:00:00'), 'guarantor'=>(!empty($row[$subKey.':guarantor'])?$row[$subKey.':guarantor']:''), 'first_mortgage'=>(!empty($row[$subKey.':firstMortgage'])?$row[$subKey.':firstMortgage']:''), 'loan_payment_freq'=>(!empty($row[$subKey.':loanPaymentFreq'])?$row[$subKey.':loanPaymentFreq']:''), 'payment_min_amount'=>(!empty($row[$subKey.':paymentMinAmount'])?$row[$subKey.':paymentMinAmount']:'0.0'), 'original_school'=>(!empty($row[$subKey.':originalSchool'])?$row[$subKey.':originalSchool']:''), 'recurring_payment_amount'=>(!empty($row[$subKey.':recurringPaymentAmount'])?$row[$subKey.':recurringPaymentAmount']:'0.0'), 'lender'=>(!empty($row[$subKey.':lender'])?$row[$subKey.':lender']:''), 'ending_balance_amount'=>(!empty($row[$subKey.':endingBalanceAmount'])?$row[$subKey.':endingBalanceAmount']:'0.0'), 'available_balance_amount'=>(!empty($row[$subKey.':availableBalanceAmount'])?$row[$subKey.':availableBalanceAmount']:'0.0'), 'loan_term_type'=>(!empty($row[$subKey.':loanTermType'])?$row[$subKey.':loanTermType']:''), 'no_of_payments'=>(!empty($row[$subKey.':noOfPayments'])?$row[$subKey.':noOfPayments']:''), 'balloon_amount'=>(!empty($row[$subKey.':balloonAmount'])?$row[$subKey.':balloonAmount']:''), 'projected_interest'=>(!empty($row[$subKey.':projectedInterest'])?$row[$subKey.':projectedInterest']:''), 'interest_paid_ltd'=>(!empty($row[$subKey.':interestPaidLtd'])?$row[$subKey.':interestPaidLtd']:''), 'interest_rate_type'=>(!empty($row[$subKey.':interestRateType'])?$row[$subKey.':interestRateType']:''), 'loan_payment_type'=>(!empty($row[$subKey.':loanPaymentType'])?$row[$subKey.':loanPaymentType']:''), 'remaining_payments'=>(!empty($row[$subKey.':remainingPayments'])?$row[$subKey.':remainingPayments']:''), 'raw_table_name'=>'raw_loan_accounts'   );
						
						
						#Does similar record already exist?
						$checkRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_account', $variableData))->row_array();
						$result = $this->db->query($this->query_reader->get_query_by_code((!empty($checkRecord)?'update_raw_loan_account': 'save_raw_loan_account'), $variableData));
						
						array_push($saveResult, $result);
					}
				
				}
				
				
				
				#Reward accounts
				else if(strpos($key, 'RewardAccount') !== FALSE)
				{
					#Add each account to the raw data
					foreach($accountGroup AS $row)
					{
						$variableData = array('account_id'=>$row['accountId'], 'user_id'=>$userId, 'status'=>(!empty($row['status'])?$row['status']:''), 'account_number'=>$row['accountNumber'], 'account_number_real'=>(!empty($row['accountNumberReal'])?$row['accountNumberReal']:''), 'account_nickname'=>$row['accountNickname'], 'display_position'=>$row['displayPosition'], 'institution_id'=>$row['institutionId'], 'description'=>(!empty($row['description'])?$row['description']:''), 'registered_user_name'=>(!empty($row['registeredUserName'])?$row['registeredUserName']:''), 'balance_amount'=>(!empty($row['balanceAmount'])?$row['balanceAmount']:''), 'balance_date'=>(!empty($row['balanceDate'])?date('Y-m-d H:i:s', strtotime($row['balanceDate'])):'0000-00-00 00:00:00'), 'balance_previous_amount'=>(!empty($row['balancePreviousAmount'])?$row['balancePreviousAmount']:''), 'last_transaction_date'=>(!empty($row['lastTxnDate'])?date('Y-m-d H:i:s', strtotime($row['lastTxnDate'])):'0000-00-00 00:00:00'), 'aggr_success_date'=>(!empty($row['aggrSuccessDate'])?date('Y-m-d H:i:s', strtotime($row['aggrSuccessDate'])):'0000-00-00 00:00:00'), 'aggr_attempt_date'=>(!empty($row['aggrAttemptDate'])?date('Y-m-d H:i:s', strtotime($row['aggrAttemptDate'])):'0000-00-00 00:00:00'), 'aggr_status_code'=>(!empty($row['aggrStatusCode'])?$row['aggrStatusCode']:''), 'currency_code'=>$row['currencyCode'], 'bank_id'=>(!empty($row['bankId'])?$row['bankId']:''),  	'institution_login_id'=>(!empty($row['institutionLoginId'])?$row['institutionLoginId']:''),'posted_date'=>(!empty($row[$subKey.':postedDate'])?date('Y-m-d H:i:s', strtotime($row[$subKey.':postedDate'])):'0000-00-00 00:00:00'), 'program_type'=>(!empty($row[$subKey.':programType'])?$row[$subKey.':programType']:''), 'original_balance'=>(!empty($row[$subKey.':originalBalance'])?$row[$subKey.':originalBalance']:'0.0'), 'current_balance'=>(!empty($row[$subKey.':currentBalance'])?$row[$subKey.':currentBalance']:'0.0'), 'reward_qualify_amount_ytd'=>(!empty($row[$subKey.':rewardQualifyAmountYtd'])?$row[$subKey.':rewardQualifyAmountYtd']:'0.0'), 'reward_lifetime_earned'=>(!empty($row[$subKey.':rewardLifetimeEarned'])?$row[$subKey.':rewardLifetimeEarned']:'0.0'), 'segment_ytd'=>(!empty($row[$subKey.':segmentYtd'])?$row[$subKey.':segmentYtd']:'0.0'), 'raw_table_name'=>'raw_reward_accounts'   );
						
						
						#Does similar record already exist?
						$checkRecord = $this->db->query($this->query_reader->get_query_by_code('get_raw_account', $variableData))->row_array();
						$result = $this->db->query($this->query_reader->get_query_by_code((!empty($checkRecord)?'update_raw_reward_account': 'save_raw_reward_account'), $variableData));
						
						array_push($saveResult, $result);
					}
				
				}
				
			}
		}
		
		return get_decision($saveResult, FALSE);
	}
	
	
}