<?php
/**
 * This file contains functions that are used in a number of classes or views.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 12/23/2013
 */



function get_api_response($dataType)
{
	$xml = "";
	
	
	#Institution details
	if($dataType == 'get_institution_details')
	{
		$xml = "<InstitutionDetail xmlns=\"http://schema.intuit.com/platform/fdatafeed/institution/v1\" xmlns:ns2=\"http://schema.intuit.com/platform/fdatafeed/common/v1\">

  <institutionId>100000</institutionId>

  <institutionName>CC Bank</institutionName>

  <homeUrl>http://www.intuit.com</homeUrl>

  <address>

    <ns2:country>USA</ns2:country>

  </address>

  <emailAddress>CustomerCentralBank@intuit.com</emailAddress>

  <specialText>Welcome to  Bank of Intuit</specialText>

  <currencyCode>USD</currencyCode>

  <keys>

    <key>

      <name>Banking Password</name>

      <status>Active</status>

      <valueLengthMin>1</valueLengthMin>

      <valueLengthMax>20</valueLengthMax>

      <displayFlag>true</displayFlag>

      <displayOrder>2</displayOrder>

      <mask>true</mask>

      <instructions>Enter banking password (go)</instructions>

      <description>Banking Password</description>

    </key>

    <key>

      <name>Banking Userid</name>

      <status>Active</status>

      <valueLengthMin>1</valueLengthMin>

      <valueLengthMax>20</valueLengthMax>

      <displayFlag>true</displayFlag>

      <displayOrder>1</displayOrder>

      <mask>false</mask>

      <instructions>Enter banking userid (demo)</instructions>

      <description>Banking Userid</description>

    </key>

  </keys>

</InstitutionDetail>";

	}
	
	
	
	
	#Maximum accounts
	else if($dataType == 'max_accounts')
	{
		$xml = "<Status xmlns=\"http://schema.intuit.com/platform/fdatafeed/common/v1\">

  <errorInfo>

    <errorType>APP_ERROR</errorType>

    <errorCode>api.max.accounts</errorCode>

    <errorMessage>The customer has reached the maximum number of accounts allowed.</errorMessage>

    <correlationId>gw-bbba05a0-4673-4f16-8c13-44b998d228a8</correlationId>

  </errorInfo>

</Status>";
	}
	
	
	
	
	#Discover and add accounts
	else if($dataType == 'discover_and_add_accounts')
	{
		$xml = '<ns8:AccountList xmlns="http://schema.intuit.com/platform/fdatafeed/account/v1" 
xmlns:ns2="http://schema.intuit.com/platform/fdatafeed/investmentaccount/v1" 
xmlns:ns3="http://schema.intuit.com/platform/fdatafeed/otheraccount/v1" 
xmlns:ns4="http://schema.intuit.com/platform/fdatafeed/bankingaccount/v1" 
xmlns:ns5="http://schema.intuit.com/platform/fdatafeed/creditaccount/v1" 
xmlns:ns6="http://schema.intuit.com/platform/fdatafeed/loanaccount/v1" 
xmlns:ns7="http://schema.intuit.com/platform/fdatafeed/rewardsaccount/v1" 
xmlns:ns8="http://schema.intuit.com/platform/fdatafeed/accountlist/v1">
   <ns3:OtherAccount>
      <accountId>000000000001</accountId>
      <accountNumber>000000000001</accountNumber>
      <accountNickname>My Savings</accountNickname>
      <displayPosition>13</displayPosition>
      <institutionId>0000001</institutionId>
      <aggrSuccessDate>2012-02-20T16:36:09.244-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-20T16:36:09.244-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>USD</currencyCode>
      <institutionLoginId>00000000001</institutionLoginId>
   </ns3:OtherAccount>
   <ns2:InvestmentAccount>
      <accountId>0000000000001</accountId>
      <accountNumber>0000000000</accountNumber>
      <accountNickname>My Brokerage</accountNickname>
      <displayPosition>15</displayPosition>
      <institutionId>000002</institutionId>
      <balanceAmount>220.36</balanceAmount>
      <aggrSuccessDate>2012-02-20T16:36:09.244-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-20T16:36:09.244-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>USD</currencyCode>
      <institutionLoginId>000000000002</institutionLoginId>
      <ns2:investmentAccountType>BROKERAGE</ns2:investmentAccountType>
      <ns2:currentBalance>220.36</ns2:currentBalance>
   </ns2:InvestmentAccount>
</ns8:AccountList>';
		
	}
	
	
	
	
	
	
	#Get customer accounts
	else if($dataType == 'get_customer_accounts')
	{
		$xml = "<ns8:AccountList xmlns=\"http://schema.intuit.com/platform/fdatafeed/account/v1\" xmlns:ns2=\"http://schema.intuit.com/platform/fdatafeed/creditaccount/v1\" 
xmlns:ns3=\"http://schema.intuit.com/platform/fdatafeed/rewardsaccount/v1\" 
xmlns:ns4=\"http://schema.intuit.com/platform/fdatafeed/bankingaccount/v1\" 
xmlns:ns5=\"http://schema.intuit.com/platform/fdatafeed/investmentaccount/v1\" 
xmlns:ns6=\"http://schema.intuit.com/platform/fdatafeed/otheraccount/v1\" 
xmlns:ns7=\"http://schema.intuit.com/platform/fdatafeed/loanaccount/v1\" 
xmlns:ns8=\"http://schema.intuit.com/platform/fdatafeed/accountlist/v1\">
   <ns7:LoanAccount>
      <accountId>75000033014</accountId>
      <accountNumber>9900009994</accountNumber>
      <accountNickname>My Military Loan</accountNickname>
      <displayPosition>5</displayPosition>
      <institutionId>11923</institutionId> 
	  <description>Description</description>
      <balanceAmount>90227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>USD</currencyCode>
      <ns7:loanType>MILITARY</ns7:loanType>
      <ns7:nextPayment>90227.2</ns7:nextPayment>
      <ns7:nextPaymentDate>2020-04-01T00:00:00-07:00</ns7:nextPaymentDate>
      <ns7:autopayEnrolled>true</ns7:autopayEnrolled>
      <ns7:collateral>90227.20</ns7:collateral>
      <ns7:currentSchool>Cur School</ns7:currentSchool>
      <ns7:firstPaymentDate>2020-04-01T00:00:00-07:00</ns7:firstPaymentDate>
      <ns7:guarantor>Guarantor</ns7:guarantor>
      <ns7:firstMortgage>false</ns7:firstMortgage>
      <ns7:loanPaymentFreq>MONTHLY</ns7:loanPaymentFreq>
      <ns7:paymentMinAmount>90227.2</ns7:paymentMinAmount>
      <ns7:originalSchool>Orig School</ns7:originalSchool>
      <ns7:recurringPaymentAmount>90227.2</ns7:recurringPaymentAmount>
      <ns7:lender>Lender</ns7:lender>
   </ns7:LoanAccount>
   <ns7:LoanAccount>
      <accountId>75000033009</accountId>
      <accountNumber>9900009991</accountNumber>
      <accountNickname>My Consumer Loan</accountNickname>
      <displayPosition>2</displayPosition>
      <institutionId>14007</institutionId>
      <description>Description</description>
      <balanceAmount>90227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>USD</currencyCode>
      <ns7:loanType>CONSUMER</ns7:loanType>
      <ns7:nextPayment>90227.2</ns7:nextPayment>
      <ns7:nextPaymentDate>2020-04-01T00:00:00-07:00</ns7:nextPaymentDate>
      <ns7:autopayEnrolled>true</ns7:autopayEnrolled>
      <ns7:collateral>90227.20</ns7:collateral>
      <ns7:currentSchool>Cur School</ns7:currentSchool>
      <ns7:firstPaymentDate>2020-04-01T00:00:00-07:00</ns7:firstPaymentDate>
      <ns7:guarantor>Guarantor</ns7:guarantor>
      <ns7:firstMortgage>false</ns7:firstMortgage>
      <ns7:loanPaymentFreq>MONTHLY</ns7:loanPaymentFreq>
      <ns7:paymentMinAmount>90227.2</ns7:paymentMinAmount>
      <ns7:originalSchool>Orig School</ns7:originalSchool>
      <ns7:recurringPaymentAmount>90227.2</ns7:recurringPaymentAmount>
      <ns7:lender>Lender</ns7:lender>
   </ns7:LoanAccount>
   <ns5:InvestmentAccount>
      <accountId>75000033017</accountId>
      <accountNumber>1110000003</accountNumber>
      <accountNickname>My KEOGH - My Retirement</accountNickname>
      <displayPosition>21</displayPosition>
      <institutionId>24601</institutionId>
      <balanceAmount>227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>KEOGH</ns5:investmentAccountType>
      <ns5:currentBalance>227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns5:InvestmentAccount>
      <accountId>75000032995</accountId>
      <accountNumber>1110000001</accountNumber>
      <accountNickname>My IRA - My Retirement</accountNickname>
      <displayPosition>19</displayPosition>
      <institutionId>5642</institutionId>
      <balanceAmount>-227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>BROKERAGE</ns5:investmentAccountType>
      <ns5:currentBalance>-227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns4:BankingAccount>
      <accountId>75000033013</accountId>
      <accountNumber>1000002222</accountNumber>
      <accountNickname>My Savings</accountNickname>
      <displayPosition>15</displayPosition>
      <institutionId>2514</institutionId>
      <balanceAmount>227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns4:bankingAccountType>SAVINGS</ns4:bankingAccountType>
   </ns4:BankingAccount>
   <ns4:BankingAccount>
      <accountId>75000033002</accountId>
      <accountNumber>1000001111</accountNumber>
      <accountNickname>My Checking</accountNickname>
      <displayPosition>12</displayPosition>
      <institutionId>2514</institutionId>
      <balanceAmount>227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns4:bankingAccountType>CHECKING</ns4:bankingAccountType>
   </ns4:BankingAccount>
   <ns5:InvestmentAccount>
      <accountId>75000033000</accountId>
      <accountNumber>1110000006</accountNumber>
      <accountNickname>My SIMPLE - My Retirement</accountNickname>
      <displayPosition>24</displayPosition>
      <institutionId>2514</institutionId>
      <balanceAmount>-227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>KEOGH</ns5:investmentAccountType>
      <ns5:currentBalance>-227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns5:InvestmentAccount>
      <accountId>75000033003</accountId>
      <accountNumber>1110000009</accountNumber>
      <accountNickname>My UGMA - My Retirement</accountNickname>
      <displayPosition>27</displayPosition>
      <institutionId>2514</institutionId>
      <balanceAmount>-227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>KEOGH</ns5:investmentAccountType>
      <ns5:currentBalance>-227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns5:InvestmentAccount>
      <accountId>75000033020</accountId>
      <accountNumber>1110000002</accountNumber>
      <accountNickname>My 403B - My Retirement</accountNickname>
      <displayPosition>20</displayPosition>
      <institutionId>2514</institutionId>
      <balanceAmount>-227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>BROKERAGE</ns5:investmentAccountType>
      <ns5:currentBalance>-227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns2:CreditAccount>
      <accountId>75000033010</accountId>
      <accountNumber>4100007777</accountNumber>
      <accountNickname>My Visa</accountNickname>
      <displayPosition>10</displayPosition>
      <institutionId>14008</institutionId>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns2:creditAccountType>CREDITCARD</ns2:creditAccountType>
      <ns2:currentBalance>-90227.2</ns2:currentBalance>
      <ns2:statementEndDate>2020-03-01T00:00:00-08:00</ns2:statementEndDate>
      <ns2:statementCloseBalance>-90227.2</ns2:statementCloseBalance>
   </ns2:CreditAccount>
   <ns5:InvestmentAccount>
      <accountId>75000033018</accountId>
      <accountNumber>1110000005</accountNumber>
      <accountNickname>My TDA - My Retirement</accountNickname>
      <displayPosition>23</displayPosition>
      <institutionId>23812</institutionId>
      <balanceAmount>-227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>KEOGH</ns5:investmentAccountType>
      <ns5:currentBalance>-227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns5:InvestmentAccount>
      <accountId>75000033007</accountId>
      <accountNumber>1110000007</accountNumber>
      <accountNickname>My NORMAL - My Retirement</accountNickname>
      <displayPosition>25</displayPosition>
      <institutionId>23812</institutionId>
      <balanceAmount>-227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>KEOGH</ns5:investmentAccountType>
      <ns5:currentBalance>-227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns6:OtherAccount>
      <accountId>75000033006</accountId>
      <accountNumber>1000001111</accountNumber>
      <accountNickname>My Rewards</accountNickname>
      <displayPosition>14</displayPosition>
      <institutionId>0</institutionId>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
   </ns6:OtherAccount>
   <ns6:OtherAccount>
      <accountId>75000033008</accountId>
      <accountNumber>1000001111</accountNumber>
      <accountNickname>My Unknown</accountNickname>
      <displayPosition>13</displayPosition>
      <institutionId>5697</institutionId>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
   </ns6:OtherAccount>
   <ns5:InvestmentAccount>
      <accountId>75000032998</accountId>
      <accountNumber>1110000008</accountNumber>
      <accountNickname>My SARSEP - My Retirement</accountNickname>
      <displayPosition>26</displayPosition>
      <institutionId>5697</institutionId>
      <balanceAmount>-227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>KEOGH</ns5:investmentAccountType>
      <ns5:currentBalance>-227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns7:LoanAccount>
      <accountId>75000033001</accountId>
      <accountNumber>9900009992</accountNumber>
      <accountNickname>My Commercial Loan</accountNickname>
      <displayPosition>3</displayPosition>
      <institutionId>3102</institutionId>
      <description>Description</description>
      <balanceAmount>90227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>USD</currencyCode>
      <ns7:loanType>COMMERCIAL</ns7:loanType>
      <ns7:nextPayment>90227.2</ns7:nextPayment>
      <ns7:nextPaymentDate>2020-04-01T00:00:00-07:00</ns7:nextPaymentDate>
      <ns7:autopayEnrolled>true</ns7:autopayEnrolled>
      <ns7:collateral>90227.20</ns7:collateral>
      <ns7:currentSchool>Cur School</ns7:currentSchool>
      <ns7:firstPaymentDate>2020-04-01T00:00:00-07:00</ns7:firstPaymentDate>
      <ns7:guarantor>Guarantor</ns7:guarantor>
      <ns7:firstMortgage>false</ns7:firstMortgage>
      <ns7:loanPaymentFreq>MONTHLY</ns7:loanPaymentFreq>
      <ns7:paymentMinAmount>90227.2</ns7:paymentMinAmount>
      <ns7:originalSchool>Orig School</ns7:originalSchool>
      <ns7:recurringPaymentAmount>90227.2</ns7:recurringPaymentAmount>
      <ns7:lender>Lender</ns7:lender>
   </ns7:LoanAccount>
   <ns4:BankingAccount>
      <accountId>75000033012</accountId>
      <accountNumber>2000005555</accountNumber>
      <accountNickname>My CD</accountNickname>
      <displayPosition>16</displayPosition>
      <institutionId>11923</institutionId>
      <balanceAmount>227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns4:bankingAccountType>CD</ns4:bankingAccountType>
   </ns4:BankingAccount>
   <ns7:LoanAccount>
      <accountId>75000033019</accountId>
      <accountNumber>9900009995</accountNumber>
      <accountNickname>My Small Business Loan</accountNickname>
      <displayPosition>7</displayPosition>
      <institutionId>11698</institutionId>
      <description>Description</description>
      <balanceAmount>90227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>USD</currencyCode>
      <ns7:loanType>SMB</ns7:loanType>
      <ns7:nextPayment>90227.2</ns7:nextPayment>
      <ns7:nextPaymentDate>2020-04-01T00:00:00-07:00</ns7:nextPaymentDate>
      <ns7:autopayEnrolled>true</ns7:autopayEnrolled>
      <ns7:collateral>90227.20</ns7:collateral>
      <ns7:currentSchool>Cur School</ns7:currentSchool>
      <ns7:firstPaymentDate>2020-04-01T00:00:00-07:00</ns7:firstPaymentDate>
      <ns7:guarantor>Guarantor</ns7:guarantor>
      <ns7:firstMortgage>false</ns7:firstMortgage>
      <ns7:loanPaymentFreq>MONTHLY</ns7:loanPaymentFreq>
      <ns7:paymentMinAmount>90227.2</ns7:paymentMinAmount>
      <ns7:originalSchool>Orig School</ns7:originalSchool>
      <ns7:recurringPaymentAmount>90227.2</ns7:recurringPaymentAmount>
      <ns7:lender>Lender</ns7:lender>
   </ns7:LoanAccount>
   <ns5:InvestmentAccount>
      <accountId>75000033016</accountId>
      <accountNumber>0000000001</accountNumber>
      <accountNickname>My Retirement</accountNickname>
      <displayPosition>18</displayPosition>
      <institutionId>11698</institutionId>
      <balanceAmount>-227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>BROKERAGE</ns5:investmentAccountType>
      <ns5:currentBalance>-227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns7:LoanAccount>
      <accountId>75000033015</accountId>
      <accountNumber>9900009997</accountNumber>
      <accountNickname>My Home Equity Line of Credit</accountNickname>
      <displayPosition>9</displayPosition>
      <institutionId>3102</institutionId>
      <description>Description</description>
      <balanceAmount>90227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>USD</currencyCode>
      <ns7:loanType>HOMEEQUITY</ns7:loanType>
      <ns7:nextPayment>90227.2</ns7:nextPayment>
      <ns7:nextPaymentDate>2020-04-01T00:00:00-07:00</ns7:nextPaymentDate>
      <ns7:autopayEnrolled>true</ns7:autopayEnrolled>
      <ns7:collateral>90227.20</ns7:collateral>
      <ns7:currentSchool>Cur School</ns7:currentSchool>
      <ns7:firstPaymentDate>2020-04-01T00:00:00-07:00</ns7:firstPaymentDate>
      <ns7:guarantor>Guarantor</ns7:guarantor>
      <ns7:firstMortgage>false</ns7:firstMortgage>
      <ns7:loanPaymentFreq>MONTHLY</ns7:loanPaymentFreq>
      <ns7:paymentMinAmount>90227.2</ns7:paymentMinAmount>
      <ns7:originalSchool>Orig School</ns7:originalSchool>
      <ns7:recurringPaymentAmount>90227.2</ns7:recurringPaymentAmount>
      <ns7:lender>Lender</ns7:lender>
   </ns7:LoanAccount>
   <ns4:BankingAccount>
      <accountId>75000032999</accountId>
      <accountNumber>1005500055</accountNumber>
      <accountNickname>Trade mark symbol tm - My Checking</accountNickname>
      <displayPosition>6</displayPosition>
      <institutionId>14007</institutionId>
      <balanceAmount>227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns4:bankingAccountType>CHECKING</ns4:bankingAccountType>
   </ns4:BankingAccount>
   <ns7:LoanAccount>
      <accountId>75000032997</accountId>
      <accountNumber>8000008888</accountNumber>
      <accountNickname>My Auto Loan</accountNickname>
      <displayPosition>1</displayPosition>
      <institutionId>14007</institutionId>
      <description>Description</description>
      <balanceAmount>90227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>USD</currencyCode>
      <ns7:loanType>AUTO</ns7:loanType>
      <ns7:nextPayment>90227.2</ns7:nextPayment>
      <ns7:nextPaymentDate>2020-04-01T00:00:00-07:00</ns7:nextPaymentDate>
      <ns7:autopayEnrolled>true</ns7:autopayEnrolled>
      <ns7:collateral>90227.20</ns7:collateral>
      <ns7:currentSchool>Cur School</ns7:currentSchool>
      <ns7:firstPaymentDate>2020-04-01T00:00:00-07:00</ns7:firstPaymentDate>
      <ns7:guarantor>Guarantor</ns7:guarantor>
      <ns7:firstMortgage>false</ns7:firstMortgage>
      <ns7:loanPaymentFreq>MONTHLY</ns7:loanPaymentFreq>
      <ns7:paymentMinAmount>90227.2</ns7:paymentMinAmount>
      <ns7:originalSchool>Orig School</ns7:originalSchool>
      <ns7:recurringPaymentAmount>90227.2</ns7:recurringPaymentAmount>
      <ns7:lender>Lender</ns7:lender>
   </ns7:LoanAccount>
   <ns5:InvestmentAccount>
      <accountId>75000032996</accountId>
      <accountNumber>1110000004</accountNumber>
      <accountNickname>My TRUST - My Retirement</accountNickname>
      <displayPosition>22</displayPosition>
      <institutionId>5697</institutionId>
      <balanceAmount>-227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>KEOGH</ns5:investmentAccountType>
      <ns5:currentBalance>-227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns7:LoanAccount>
      <accountId>75000033004</accountId>
      <accountNumber>9900009996</accountNumber>
      <accountNickname>My Construction Loan</accountNickname>
      <displayPosition>8</displayPosition>
      <institutionId>5697</institutionId>
      <description>Description</description>
      <balanceAmount>90227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>USD</currencyCode>
      <ns7:loanType>CONSTR</ns7:loanType>
      <ns7:nextPayment>90227.2</ns7:nextPayment>
      <ns7:nextPaymentDate>2020-04-01T00:00:00-07:00</ns7:nextPaymentDate>
      <ns7:autopayEnrolled>true</ns7:autopayEnrolled>
      <ns7:collateral>90227.20</ns7:collateral>
      <ns7:currentSchool>Cur School</ns7:currentSchool>
      <ns7:firstPaymentDate>2020-04-01T00:00:00-07:00</ns7:firstPaymentDate>
      <ns7:guarantor>Guarantor</ns7:guarantor>
      <ns7:firstMortgage>false</ns7:firstMortgage>
      <ns7:loanPaymentFreq>MONTHLY</ns7:loanPaymentFreq>
      <ns7:paymentMinAmount>90227.2</ns7:paymentMinAmount>
      <ns7:originalSchool>Orig School</ns7:originalSchool>
      <ns7:recurringPaymentAmount>90227.2</ns7:recurringPaymentAmount>
      <ns7:lender>Lender</ns7:lender>
   </ns7:LoanAccount>
   <ns2:CreditAccount>
      <accountId>75000033005</accountId>
      <accountNumber>8000006666</accountNumber>
      <accountNickname>My Line of Credit</accountNickname>
      <displayPosition>11</displayPosition>
      <institutionId>11335</institutionId>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns2:creditAccountType>LINEOFCREDIT</ns2:creditAccountType>
      <ns2:currentBalance>0</ns2:currentBalance>
   </ns2:CreditAccount>
   <ns5:InvestmentAccount>
      <accountId>75000033021</accountId>
      <accountNumber>0000000000</accountNumber>
      <accountNickname>My Brokerage</accountNickname>
      <displayPosition>17</displayPosition>
      <institutionId>5697</institutionId>
      <balanceAmount>227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>INR</currencyCode>
      <ns5:investmentAccountType>BROKERAGE</ns5:investmentAccountType>
      <ns5:currentBalance>227.2</ns5:currentBalance>
   </ns5:InvestmentAccount>
   <ns7:LoanAccount>
      <accountId>75000033011</accountId>
      <accountNumber>9900009993</accountNumber>
      <accountNickname>My Student Loan</accountNickname>
      <displayPosition>4</displayPosition>
      <institutionId>5697</institutionId>
      <description>Description</description>
      <balanceAmount>90227.2</balanceAmount>
      <aggrSuccessDate>2012-02-27T23:20:13.651-08:00</aggrSuccessDate>
      <aggrAttemptDate>2012-02-27T23:20:13.651-08:00</aggrAttemptDate>
      <aggrStatusCode>0</aggrStatusCode>
      <currencyCode>USD</currencyCode>
      <ns7:loanType>STUDENT</ns7:loanType>
      <ns7:nextPayment>90227.2</ns7:nextPayment>
      <ns7:nextPaymentDate>2020-04-01T00:00:00-07:00</ns7:nextPaymentDate>
      <ns7:autopayEnrolled>true</ns7:autopayEnrolled>
      <ns7:collateral>90227.20</ns7:collateral>
      <ns7:currentSchool>Cur School</ns7:currentSchool>
      <ns7:firstPaymentDate>2020-04-01T00:00:00-07:00</ns7:firstPaymentDate>
      <ns7:guarantor>Guarantor</ns7:guarantor>
      <ns7:firstMortgage>false</ns7:firstMortgage>
      <ns7:loanPaymentFreq>MONTHLY</ns7:loanPaymentFreq>
      <ns7:paymentMinAmount>90227.2</ns7:paymentMinAmount>
      <ns7:originalSchool>Orig School</ns7:originalSchool>
      <ns7:recurringPaymentAmount>90227.2</ns7:recurringPaymentAmount>
      <ns7:lender>Lender</ns7:lender>
   </ns7:LoanAccount>
</ns8:AccountList>";
	}
	
	
	
	
	
	#Account not found error
	else if($dataType == 'account_not_found_error')
	{
		$xml = '<Status xmlns="http://schema.intuit.com/platform/fdatafeed/common/v1">

  <errorInfo>

    <errorType>APP_ERROR</errorType>

    <errorCode>api.database.account.notfound</errorCode>

    <errorMessage>internal api error while processing the request</errorMessage>

    <correlationId>gw-0e2a9c59-92f0-4d20-9cd9-8b80ebae2063</correlationId>

  </errorInfo>

</Status>';
	}
	
	
	
	
	#Get customer accounts
	else if($dataType == 'get_account_transactions')
	{
		$xml = '<?xml version="1.0" ?>
<ns9:TransactionList xmlns="http://schema.intuit.com/platform/fdatafeed/transaction/v1" 
    xmlns:ns2="http://schema.intuit.com/platform/fdatafeed/bnktransaction/v1"
    xmlns:ns3="http://schema.intuit.com/platform/fdatafeed/cctransaction/v1"
    xmlns:ns4="http://schema.intuit.com/platform/fdatafeed/ibnktransaction/v1"
    xmlns:ns5="http://schema.intuit.com/platform/fdatafeed/loantransaction/v1"
    xmlns:ns6="http://schema.intuit.com/platform/fdatafeed/invtransaction/v1"
    xmlns:ns7="http://schema.intuit.com/platform/fdatafeed/securityinfo/v1"
    xmlns:ns8="http://schema.intuit.com/platform/fdatafeed/rewardstransaction/v1"
    xmlns:ns9="http://schema.intuit.com/platform/fdatafeed/transactionlist/v1">
  
  <ns3:CreditCardTransaction>
    <id>75000088503</id>
    <currencyType>USD</currencyType>
    <institutionTransactionId>INTUIT-75000088503</institutionTransactionId>
    <payeeName>Transaction 1.2</payeeName>
    <postedDate>2012-08-22T00:00:00-06:00</postedDate>
    <userDate>2012-08-22T00:00:00-06:00</userDate>
    <amount>111.22</amount>
    <pending>false</pending>
    <categorization>
        <common>
           <normalizedPayeeName>Priceline.com</normalizedPayeeName>
           <merchant>Priceline.com</merchant>
           <sic>9995</sic>
        </common>
        <context>
           <source>CAT</source>
           <categoryName>CATEGORY</categoryName>
           <contextType></contextType>
           <scheduleC>Travel,Meals,Entertainment</scheduleC>
        </context>
    </categorization>
  </ns3:CreditCardTransaction>
  
  
  <ns3:CreditCardTransaction>
    <id>7500008897150</id>
    <currencyType>USD</currencyType>
    <institutionTransactionId>WAL900236743234234</institutionTransactionId>
    <payeeId>197845</payeeId>
	<payeeName>Walmart Stores</payeeName>
    <postedDate>2013-12-15T00:00:00-06:00</postedDate>
    <userDate>2012-08-22T00:00:00-06:00</userDate>
    <amount>87.22</amount>
    <pending>false</pending>
    <categorization>
        <common>
           <normalizedPayeeName>Walmart Stores Inc.</normalizedPayeeName>
           <merchant>Walmart.com</merchant>
           <sic>87544</sic>
        </common>
        <context>
           <source>CAT</source>
           <categoryName>CATEGORY</categoryName>
           <contextType></contextType>
           <scheduleC>Clothing</scheduleC>
        </context>
    </categorization>
  </ns3:CreditCardTransaction>
  
  
  <ns2:BankingTransaction>
    <id>750000884580</id>
    <currencyType>USD</currencyType>
    <institutionTransactionId>INTUIT-750000852344</institutionTransactionId>
    <memo>Thanks for your trust</memo>
    <postedDate>2013-08-22T00:00:10-06:00</postedDate>
    <userDate>2013-08-21T00:00:15-06:00</userDate>
    <amount>21.50</amount>
    <pending>false</pending>
	<checkNumber>4101230</checkNumber>
	<payeeName>James Jones Sr.</payeeName>
    <categorization>
        <common>
           <normalizedPayeeName>Mr. James Jones Sr.</normalizedPayeeName>
           <merchant></merchant>
           <sic>41055</sic>
        </common>
        <context>
           <source>CAT</source>
           <categoryName>Financial</categoryName>
           <contextType></contextType>
           <scheduleC>Personal Loan</scheduleC>
        </context>
    </categorization>
  </ns2:BankingTransaction>

  
  
  <ns6:InvestmentTransaction>
    <id>350000884580</id>
    <currencyType>USD</currencyType>
    <institutionTransactionId>INTUIT-7500008520000</institutionTransactionId>
    <payeeName>Bank of America Wealth Management</payeeName>
	<payeeId>11280</payeeId>
	<extendedPayeeName>U.S. Trust, Bank of America Wealth Management</extendedPayeeName>
    <postedDate>2013-11-21T00:00:10-06:00</postedDate>
    <userDate>2013-11-21T00:00:09-07:30</userDate>
    <amount>1500500.00</amount>
    <pending>false</pending>
	<checkNumber>4101250</checkNumber>
	<description>FY 2013 Investment for Small Stock Portifolio No.4200123Y89K</description>
	<buyType>BUYTOCOVER</buyType>
	<tradeDate>2013-12-21T00:00:10-06:00</tradeDate>
	<settleDate>2013-12-21T00:00:10-06:00</settleDate>
	<purchaseDate>2013-12-22T00:00:10-06:00</purchaseDate>
	<sharesPerContract>500</sharesPerContract>
	<unitPrice>3001.00</unitPrice>
	<feesAmount>0.00</feesAmount>
  </ns6:InvestmentTransaction>
  
  
  
  <ns3:CreditCardTransaction>
    <id>750000890000</id>
    <currencyType>USD</currencyType>
    <institutionTransactionId>INTUIT-750000887777</institutionTransactionId>
    <payeeName>Trader Joes Inc.</payeeName>
    <postedDate>2013-08-21T00:00:00-06:00</postedDate>
    <userDate>2013-08-21T00:00:00-07:00</userDate>
    <amount>54.35</amount>
    <pending>false</pending>
    <categorization>
        <common>
           <normalizedPayeeName>Trader Joes LLC.</normalizedPayeeName>
           <merchant>Trader Joes LLC</merchant>
           <sic>90248</sic>
        </common>
        <context>
           <source>CAT</source>
           <categoryName>RETAIL</categoryName>
           <contextType>Industry</contextType>
           <scheduleC>Groceries</scheduleC>
        </context>
    </categorization>
  </ns3:CreditCardTransaction>
  
</ns9:TransactionList>';
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
		
	return $xml;
}





#Function to convert an XML string to an array
function xml_to_array($xml, $options = array()) 
{
    $defaults = array(
        'namespaceSeparator' => ':',//you may want this to be something other than a colon
        'attributePrefix' => '@',   //to distinguish between attributes and nodes with the same name
        'alwaysArray' => array(),   //array of xml tag names which should always become arrays
        'autoArray' => true,        //only create arrays for tags which appear more than once
        'textContent' => '$',       //key used for the text content of elements
        'autoText' => true,         //skip textContent key if node has no attributes or child nodes
        'keySearch' => false,       //optional search and replace on tag and attribute names
        'keyReplace' => false       //replace values for above search values (as passed to str_replace())
    );
    $options = array_merge($defaults, $options);
    $namespaces = $xml->getDocNamespaces();
    $namespaces[''] = null; //add base (empty) namespace
 
    #get attributes from all namespaces
    $attributesArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
            #replace characters in attribute name
            if ($options['keySearch']) $attributeName =
                    str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
            $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
            $attributesArray[$attributeKey] = (string)$attribute;
        }
    }
 
    #get child nodes from all namespaces
    $tagsArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->children($namespace) as $childXml) {
            #recurse into child nodes
            $childArray = xml_to_array($childXml, $options);
            list($childTagName, $childProperties) = each($childArray);
 
            #replace characters in tag name
            if ($options['keySearch']) $childTagName =
                    str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
            #add namespace prefix, if any
            if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
 
            if (!isset($tagsArray[$childTagName])) {
                #only entry with this key
                #test if tags of this type should always be arrays, no matter the element count
                $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                        ? array($childProperties) : $childProperties;
            } elseif (
                is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                === range(0, count($tagsArray[$childTagName]) - 1)
            ) {
                #key already exists and is integer indexed array
                $tagsArray[$childTagName][] = $childProperties;
            } else {
                #key exists so convert to integer indexed array with previous value in position 0
                $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
            }
        }
    }
 
    #get text content of node
    $textContentArray = array();
    $plainText = trim((string)$xml);
    if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;
 
    #stick it all together
    $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;
 
    #return node as array
    return array(
        $xml->getName() => $propertiesArray
    );
}

?>