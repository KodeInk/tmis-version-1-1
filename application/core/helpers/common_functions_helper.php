<?php
/**
 * This file contains functions that are used in a number of classes or views.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 11/26/2013
 */




#A wrapping span to show a required field
function get_required_field_wrap($requiredFields, $fieldId, $fieldSide='start', $txtMsg='', $showDiv='N')
{
	if($showDiv == 'Y')
	{
		if($fieldSide == 'start'){
			return "<div class='required_fields' id='".$fieldId."__fwrap' style='padding:5px;'>";
		}
		else if($fieldSide == 'end')
		{
			return "</div>";
		}
	}
	else
	{
		$start = "<table border='0' cellspacing='0' cellpadding='5'>";
		if($txtMsg != ''){
			$start .= "<tr><td  style='font-weight: bold; color: #FF0000; background-color:#FFFF99;'>".$txtMsg."</td></tr>";
		}
	
		$start .= "<tr><td style='font-weight: bold; color:#000000; background-color:#FFFF99;' nowrap>";
		$end = "</td></tr></table>";
	
		if(in_array($fieldId, $requiredFields)){
			if($fieldSide == 'start'){
				return $start;
			}
			else if($fieldSide == 'end')
			{
				return $end;
			}
			else
			{
				return '';
			}
		}
		else
		{
			return '';
		}
	}
}


#Function to filter forwarded data to get only the passed variables
#In addition, it picks out all non-zero data from a URl array to be passed to a form
function filter_forwarded_data($obj, $urlDataArray=array(), $reroutedUrlDataArray=array(), $noOfPartsToIgnore=RETRIEVE_URL_DATA_IGNORE)
{
	# Get the passed details into the url data array if any
	$urlData = $obj->uri->uri_to_assoc($noOfPartsToIgnore, $urlDataArray);
	
	$dataArray = array();
	
	
	foreach($urlData AS $key=>$value)
	{
		if($value !== FALSE && trim($value) != '' && !array_key_exists($value, $urlData))
		{
			if($value == '_'){
				$dataArray[$key] = '';
			} else {
				$dataArray[$key] = $value;
			}
		}
	}
	
	#handle re-routed URL data
	if(!empty($reroutedUrlDataArray))
	{
		$urlInfo = $obj->uri->ruri_to_assoc(3);
		foreach($reroutedUrlDataArray AS $urlKey)
		{
			if(!empty($urlInfo[$urlKey]))
			{
				$dataArray[$urlKey] = $urlInfo[$urlKey];
			}
		}
	}
	
	return restore_bad_chars_in_array($dataArray);
}







# Goes through a row returned from a form escaping quotes and neutralising HTML insertions
function clean_form_data($formData)
{
	$cleanData = array();
	
	foreach($formData AS $key=>$value)
	{
		if(is_array($value))
		{
			foreach($value AS $subKey=>$subValue)
			{
				if(is_array($subValue))
				{
					foreach($subValue AS $subSubKey=>$subSubValue)
					{
						if(is_array($subSubValue))
						{
							foreach($subSubValue AS $subSubSubKey=>$subSubSubValue)
							{
								$cleanData[$key][$subKey][$subSubKey][$subSubSubKey] = htmlentities($subSubSubValue, ENT_QUOTES);
							}
						}
						else
						{
							$cleanData[$key][$subKey][$subSubKey] = htmlentities($subSubValue, ENT_QUOTES);
						}
					}
				}
				else
				{
					$cleanData[$key][$subKey] = htmlentities($subValue, ENT_QUOTES);
				}
			}
		}
		else
		{
			$cleanData[$key] = htmlentities($value, ENT_QUOTES);
		}
	}
	
	return $cleanData;
}








#Function to validate the passed form based on the entered data
function validate_form($formType, $formData, $requiredFields=array())
{
	$emptyFields = array();
	$boolResult = TRUE;
			
	foreach($requiredFields AS $required)
	{
		if(strpos($required, '*') !== FALSE){
			#This is a checkbox group
			if(strpos($required, 'CHECKBOXES') !== FALSE)
			{
				$fieldStr = explode('*', $required);
				if(empty($formData[$fieldStr[0]])){
					array_push($emptyFields, $fieldStr[0]);
				}
			}
			#This is a required row
			else if(strpos($required, 'ROW') !== FALSE)
			{
				$rowStr = explode('*', $required);
				$fieldArray = explode('<>', $rowStr[1]);
				$decision = FALSE;
						
				$rowcounter = 0;
				#Take one row field and use that to check the rest
				foreach($formData[$fieldArray[0]] AS $colField)
				{
					$rowDecision = TRUE;
					foreach($fieldArray AS $rowField){
						if(empty($formData[$rowField][$rowcounter])){
							$rowDecision = FALSE;
						}
					}
							
					if($rowDecision && !empty($colField)){
						$decision = TRUE;
						break;
					}
							
					$rowcounter++;
				}
						
				if(!$decision){
					array_push($emptyFields, $fieldArray);
				}
			}
			#This is a required radio with other options
			else if(strpos($required, 'RADIO') !== FALSE)
			{
				$rowStr = explode('*', $required);
						
				#The radio is not checked
				if(empty($formData[$rowStr[0]])){
					array_push($emptyFields, $rowStr[0]);
				}
				#if the radio is checked, check the other required fields
				else
				{
					if($formData[$rowStr[0]] == 'Y'){
						$fieldArray = explode('<>', $rowStr[1]);
						#Remove first RADIO field item which is not needed
						array_shift($fieldArray);
							
						foreach($fieldArray AS $radioField)
						{
							if(empty($formData[$radioField])){
								array_push($emptyFields, $radioField);
							}
						}
					}
				}
			}
			#This is ensuring that the fields specified are the same
			else if(strpos($required, 'SAME') !== FALSE)
			{
				$rowStr = explode('*', $required);
				$fieldArray = explode('<>', $rowStr[1]);
				
				if($formData[$rowStr[0]] != $formData[$fieldArray[1]]){
					array_push($emptyFields, $rowStr[0]);
				}
			}
			#This is ensuring that the email is the correct format
			else if(strpos($required, 'EMAILFORMAT') !== FALSE)
			{
				$rowStr = explode('*', $required);
				
				if(!is_valid_email($formData[$rowStr[0]]))
				{
					array_push($emptyFields, $rowStr[0]);
				}
			}
			#This is ensuring that the password is the correct format
			else if(strpos($required, 'PASSWORD') !== FALSE)
			{
				$rowStr = explode('*', $required);
				
				if(!is_valid_password($formData[$rowStr[0]]))
				{
					array_push($emptyFields, $rowStr[0]);
				}
			}
			#This is ensuring that the first field is less than the next field
			else if(strpos($required, 'LESSTHAN') !== FALSE)
			{
				$rowStr = explode('*', $required);
				$fieldArray = explode('<>', $rowStr[1]);
				
				if(!($formData[$rowStr[0]] < $formData[$fieldArray[1]] || $formData[$rowStr[0]] == '' || $formData[$fieldArray[1]] == '')){
					array_push($emptyFields, $rowStr[0]);
				}
			}
		}
				
		#Is a plain text field or other value field
		else
		{
			if(!(!empty($formData[$required]) || $formData[$required] == '0')){
				array_push($emptyFields, $required);
			}
		}
	}
		
	
	
	if(empty($emptyFields)){
		$boolResult = TRUE;
	}else{
		$boolResult = FALSE;
	}
	
	return array('bool'=>$boolResult, 'requiredfields'=>$emptyFields);
		
}




#Function to update form data from messages set in session
function add_msg_if_any($obj, $data)
{
	if(!empty($data['m']) && !empty($_SESSION[$data['m']])){
		$data['msg'] = $_SESSION[$data['m']];
		unset($_SESSION[$data['m']]);
	}
	
	return $data;
}




#Checks if a password is valid
function is_valid_password($password, $validationSettings=array())
{
	$isValid = true;
	$minLength = !empty($validationSettings['minLength'])? $validationSettings['minLength']: 8;
	$maxLength = !empty($validationSettings['maxLength'])? $validationSettings['maxLength']: 60;
	$needsChar = !empty($validationSettings['needsChar'])? $validationSettings['needsChar']: false;
	$needsNumber = !empty($validationSettings['needsNumber'])? $validationSettings['needsNumber']: false;
	
	if(empty($password))
	{
		$isValid = false;
	}
	else if(strlen($password) < $minLength)
	{
		$isValid = false;
	}
	else if(strlen($password) > $maxLength)
	{
		$isValid = false;
	}
	#TODO: Fix preg_match regexpression
	else if($needsChar && !preg_match('/[[:punct:]]/', $password))
	{
		$isValid = false;
	}
	#TODO: Fix preg_match regexpression
	else if($needsNumber && !preg_match('/^[0-9]+$/', $password))
	{
		$isValid = false;
	}
	
	return $isValid;
}







# Returns the passed message with the appropriate formating based on whether it is an error or not
function format_notice($msg)
{
	$style = "border-radius: 5px 5px 5px 5px;
	-moz-border-radius: 5px 5px 5px 5px;";
	
	if(is_array($msg))
	{
		$result = $msg['obj']->db->query($msg['obj']->query_reader->get_query_by_code('save_error_msg', array('msgcode'=>$msg['code'], 'details'=>$msg['details'], 'username'=>$msg['obj']->session->userdata('username'), 'ipaddress'=>$msg['obj']->input->ip_address() )));
	
		$msg = $msg['details'];
	}
    
	# Error message. look for "WARNING:" in the message
	if(strcasecmp(substr($msg, 0, 8), 'WARNING:') == 0)
	{
		$msgString = "<table width='100%' border='0' cellspacing='0' cellpadding='5' style=\"".$style."border:0px;\">".
						"<tr><td width='1%' class='error' style='border:0px;' nowrap>".str_replace("WARNING:", "<img src='".base_url()."assets/images/warning.png' border='0'/></td><td  class='error'  style='font-size:13px; color:#000;border:0px;' width='99%' valign='middle'>", $msg)."</td></tr>".
					  "</table>";
	}
	# Error message. look for "ERROR:" in the message
	else if(strcasecmp(substr($msg, 0, 6), 'ERROR:') == 0)
	{
		$msgString = "<table width='100%' border='0' cellspacing='0' cellpadding='5' style=\"".$style."border:0px;\">".
						"<tr><td class='error' style='border:0px;' width='1%' nowrap>".str_replace("ERROR:", "<img src='".base_url()."assets/images/error.png'  border='0'/></td><td  width='99%' class='error'  style='font-size:13px;border:0px;' valign='middle'>", $msg)."</td></tr>".
					  "</table>";
	}
	
	#Normal Message
	else
	{
		$msgString = "<table width='100%' border='0' cellspacing='0' cellpadding='5' style=\"".$style."border:0px;\">".
						"<tr><td class='message' style='border:0px;' nowrap>".$msg."</td></tr>".
					  "</table>";
	}
	
	return $msgString;
}





#Function to fomart a notice string to the appropriate color
function format_status($status)
{
	$statusString = $status;
	
	if(strtolower($status) == 'pending' || strtolower($status) == 'suspended' || strtolower($status) == 'inactive')
	{
		$statusString = "<span class='orange'>".$status."</span>";
	}
	elseif(strtolower($status) == 'joined' || strtolower($status) == 'active')
	{
		$statusString = "<span class='green'>".$status."</span>";
	}
	elseif(strtolower($status) == 'bounced' || strtolower($status) == 'blocked' || strtolower($status) == 'deleted')
	{
		$statusString = "<span class='red'>".$status."</span>";
	}
	elseif(strtolower($status) == 'read')
	{
		$statusString = "<span class='blue'>".$status."</span>";
	}
	
	return $statusString;
}





# Function that encrypts the entered values
function encrypt_value($value)
{
	$num = strlen($value);
	$numIndex = $num-1;
	$newValue="";
		
	#Reverse the order of characters
	for($x=0;$x<strlen($value);$x++){
		$newValue .= substr($value,$numIndex,1);
		$numIndex--;
	}
		
	#Encode the reversed value
	$newValue = base64_encode($newValue);
	return $newValue;
}
	
	
#Function that decrypts the entered values
function decrypt_value($dvalue)
{
	#Decode value
	$dvalue = base64_decode($dvalue);
		
	$dnum = strlen($dvalue);
	$dnumIndex = $dnum-1;
	$newDvalue = "";
		
	#Reverse the order of characters
	for($x=0;$x<strlen($dvalue);$x++){
		$newDvalue .= substr($dvalue,$dnumIndex,1);
		$dnumIndex--;
	}
	return $newDvalue;
}



# Function to replace placeholders for bad characters in a text passed in URL with their actual characters
function restore_bad_chars($goodString)
{
	$badString = '';
	$badChars = array("'", "\"", "\\", "(", ")", "/", "<", ">", "!", "#", "@", "%", "&", "?", "$", ",", " ", ":", ";", "=");
	$replaceChars = array("_QUOTE_", "_DOUBLEQUOTE_", "_BACKSLASH_", "_OPENPARENTHESIS_", "_CLOSEPARENTHESIS_", "_FORWARDSLASH_", "_OPENCODE_", "_CLOSECODE_", "_EXCLAMATION_", "_HASH_", "_EACH_", "_PERCENT_", "_AND_", "_QUESTION_", "_DOLLAR_", "_COMMA_", "_SPACE_", "_FULLCOLON_", "_SEMICOLON_", "_EQUAL_");
	
	foreach($replaceChars AS $pos => $charEquivalent)
	{
		$badString = str_replace($charEquivalent, $badChars[$pos], $goodString);
		$goodString = $badString;
	}
	
	return $badString;
}

# Function to replace bad characters before they are passed in a URL
function replace_bad_chars($badString)
{
	$badChars = array("'", "\"", "\\", "(", ")", "/", "<", ">", "!", "#", "@", "%", "&", "?", "$", ",", " ", ":", ";", "=");
	$replaceChars = array("_QUOTE_", "_DOUBLEQUOTE_", "_BACKSLASH_", "_OPENPARENTHESIS_", "_CLOSEPARENTHESIS_", "_FORWARDSLASH_", "_OPENCODE_", "_CLOSECODE_", "_EXCLAMATION_", "_HASH_", "_EACH_", "_PERCENT_", "_AND_", "_QUESTION_", "_DOLLAR_", "_COMMA_", "_SPACE_", "_FULLCOLON_", "_SEMICOLON_", "_EQUAL_");
	$goodString = '';
	
	foreach($badChars AS $pos => $char){
		$goodString = str_replace($char, $replaceChars[$pos], $badString);
		$badString = $goodString;
	}
	
	return $goodString;
}


# Restore bar chars in an array
function restore_bad_chars_in_array($goodArray)
{
	$badArray = array();
	
	foreach($goodArray AS $key=>$item)
	{
		$badArray[$key] = restore_bad_chars($item);
	}
	
	return $badArray;
}







# Returns the AJAX constructor to a page where needed
function get_ajax_constructor($needsAjax)
{
	$ajaxString = "";
	
	if(isset($needsAjax) && $needsAjax)
	{
		$ajaxString = "<script language=\"javascript\"  type=\"text/javascript\">".
							"var http = getHTTPObject();".
					  "</script>";
	}
	return $ajaxString;
}







# Returns the color you can assign to a row based on the passed counter
function get_row_color($counter, $noOfSteps, $rowBorders='', $darkColor='#EEEEEE', $lightColor='#FFFFFF', $colorOnly='N')
{
	if(($counter%$noOfSteps)==0) {
		if($rowBorders == 'row_borders')
		{
			if($colorOnly == 'Y'){
				$rowClass = $lightColor;
			} else {
				$rowClass = "background-color: ".$lightColor."; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: ".$darkColor.";";
			}
		}
		else
		{
			if($colorOnly == 'Y'){
				$rowClass = $lightColor;
			} else {
				$rowClass = "background-color: ".$lightColor.";";
			}
		}
	} else {
		if($rowBorders == 'row_borders')
		{
			if($colorOnly == 'Y'){
				$rowClass = $darkColor;
			} else {
				$rowClass = "background-color: ".$darkColor."; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: ".$lightColor.";";
			}
		} 
		else
		{
			if($colorOnly == 'Y'){
				$rowClass = $darkColor;
			} else {
				$rowClass = "background-color: ".$darkColor.";";
			}
		}
	}
	
	return $rowClass;
}



//Function to return a number with two decimal places and a comma after three places
function add_commas($number, $noDecimalPlaces=2)
{
	if(!isset($number) || $number == "" ||  $number <= 0)
	{
		return number_format('0.00', $noDecimalPlaces, '.', ',');
	} 
	else 
	{
		return number_format(remove_commas($number), $noDecimalPlaces, '.', ',');
	}
}
	
//Function to remove commas before saving to the database
function remove_commas($number)
{
	return clean_str(str_replace(",","",$number));
}

	
//Function to remove quotes before saving to the database
function remove_quotes($string)
{
	return str_replace('"', '', str_replace("'", '', $string));
}
	
//Function to clean user input so that it doesnt break the display functions
//This also helps disable hacker bugs
function clean_str($strInput)
{
	return htmlentities(trim($strInput));
}


	
	


#Function to get current user's IP address
function get_ip_address()
{
	$ip = "";
	if ( isset($_SERVER["REMOTE_ADDR"]) )    
	{
    	$ip = ''.$_SERVER["REMOTE_ADDR"];
	} 
	else if ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    
	{
    	$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} 
	else if ( isset($_SERVER["HTTP_CLIENT_IP"]) )
	{
    	$ip = $_SERVER["HTTP_CLIENT_IP"];
	}
	
	return (ENVIRONMENT == 'development' && strpos($_SERVER['HTTP_HOST'], 'localhost') !== FALSE)? '99.59.233.60': $ip;
}




/*#Function to determine where an IP is located
#Returns an array with geoip-infodata
function geoCheckIP($ip)
{
     #check, if the provided ip is valid
     if(!filter_var($ip, FILTER_VALIDATE_IP))
     {
         throw new InvalidArgumentException("IP is not valid");
     }

     #contact ip-server
     $response=@file_get_contents('http://www.netip.de/search?query='.$ip);
     if (empty($response))
     {
          throw new InvalidArgumentException("Error contacting Geo-IP-Server");
     }

     	#Array containing all regex-patterns necessary to extract ip-geoinfo from page
      	$patterns=array();
        $patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
        $patterns["country"] = '#Country: (.*?)&nbsp;#i';
        $patterns["state"] = '#State/Region: (.*?)<br#i';
        $patterns["town"] = '#City: (.*?)<br#i';

       #Array where results will be stored
       $ipInfo=array();

       #check response from ipserver for above patterns
       foreach ($patterns as $key => $pattern)
       {
              #store the result in array
              $ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
       }

       return $ipInfo;
}*/



#Function to paginate a list given its query and other data
function paginate_list($obj, $data, $queryCode, $variableArray=array(), $rowsPerPage=NUM_OF_ROWS_PER_PAGE)
{
	#determine the page to show
	if(!empty($data['p'])){
		$data['currentListPage'] = $data['p'];
	} else {
		#If it is an array of results
		if(is_array($queryCode))
		{
			$obj->session->set_userdata('search_total_results', count($queryCode));
		}
		#If it is a real query
		else
		{
			if(empty($variableArray['limittext']))
			{
				$variableArray['limittext'] = '';
			}
			
			$listResult = $obj->db->query($obj->query_reader->get_query_by_code($queryCode, $variableArray ));
			$obj->session->set_userdata('search_total_results', $listResult->num_rows());
		}
		
		$data['currentListPage'] = 1;
	}
	
	$data['rowsPerPage'] = $rowsPerPage;
	$start = ($data['currentListPage']-1)*$rowsPerPage;
	
	#If it is an array of results
	if(is_array($queryCode))
	{
		$data['pageList'] = array_slice($queryCode, $start, $rowsPerPage);
	}
	else
	{
		$limitTxt = " LIMIT ".$start." , ".$rowsPerPage;
		$data['pageList'] = $obj->db->query($obj->query_reader->get_query_by_code($queryCode, array_merge($variableArray, array('limittext'=>$limitTxt)) ))->result_array();
	}
	
	return $data;
}




#Function to format phone number for display
function format_phone_number($number, $country='USA')
{
	$finalNumber = "";
	if(!empty($number))
	{
		#For 10 digit countries
		if(in_array($country, array('USA')))
		{
			#+1(213)123-4567
			$finalNumber = preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $number);
		}
	}
	
	return $finalNumber;
}




	/**
	 * This function converts a binary string to hexadecimal characters.
	 *
	 * @param $bytes  Input string.
	 * @return String with lowercase hexadecimal characters.
	 */
	function string_to_hex($bytes) 
	{
		$ret = '';
		for($i = 0; $i < strlen($bytes); $i++) {
			$ret .= sprintf('%02x', ord($bytes[$i]));
		}
		return $ret;
	}


#Function to generate random bytes
function generate_random_bytes($length) 
{
	
	# Use mt_rand to generate $length random bytes. 
	$data = '';
	for($i = 0; $i < $length; $i++) 
	{
		$data .= chr(mt_rand(0, 255));
	}

	return $data;
}
	
#Function to generate an ID
function generate_id() 
{
	return '_' . string_to_hex(generate_random_bytes(21));
}


	
# Function checks all values to see if they are all true and returns the value TRUE or FALSE
function get_decision($values_array, $defaultTo=TRUE)
{
	$decision = empty($values_array)? $defaultTo: TRUE;
		
	foreach($values_array AS $value)
	{
		if(!$value)
		{
			$decision = FALSE;
			break;
		}
	}
		
	return $decision;
}


#Function to hide digits of a string given and show only the part desired
function hide_digits($fullString, $showLast=2, $hideChar='*')
{
	$fullLength = strlen($fullString);
	$hideLength = $fullLength - $showLast;
	$finalString = "";
	for($i=0;$i<$hideLength; $i++)
	{
		$finalString .= $hideChar;
	}
	
	#Add the part not to be hidden
	$finalString .= substr($fullString, -$showLast);
	
	return $finalString;
}


#Function to eliminate one of the items from array and show the selected 
function eliminate_this_and_glue($eliminateItem, $arrayType, $glueString="<>")
{
	$allString = "";
	$theArray = array();
	
	if($arrayType == "level_layers")
	{
		$theArray = array('level_0_tab','level_1_tab','level_2_tab','level_3_tab','level_4_tab','level_5_tab','level_6_tab','level_7_tab','level_8_tab','level_9_tab','level_10_tab');
	}
	
	$remainderArray = array_diff($theArray, array($eliminateItem));
	$allString = implode($glueString, $remainderArray);
	
	return $allString;
}




 /**
	* Validate an email address. If the email address is not required, then an empty string will be an acceptable
	* value for the email address
	* 
	* @param String $email The email address to be validated
	* @param boolean $isRequired Whether the email is required or not. Defaults to TRUE
	*
	* @returns true if the email address has the correct email address format and that the domain exists.
	*/
function is_valid_email($email, $isRequired = true)
{
	   $isValid = true;
	   $atIndex = strrpos($email, "@");
	   
	   #if email is not required and is an empty string, do not check it. Return True.
	   if(!$isRequired && empty($email)){
		   return true;
	   }
	   if (is_bool($atIndex) && !$atIndex){
		  $isValid = false;
	   } else {
		  $domain = substr($email, $atIndex+1);
		  $local = substr($email, 0, $atIndex);
		  $localLen = strlen($local);
		  $domainLen = strlen($domain);
		  
		if ($localLen < 1 || $localLen > 64) {
			 # local part length exceeded
			 $isValid = false;
		  } else if ($domainLen < 1 || $domainLen > 255) {
			 # domain part length exceeded
			 $isValid = false;
		  }  else if ($local[0] == '.' || $local[$localLen-1] == '.') {
			 # local part starts or ends with '.'
			 $isValid = false;
		  } else if (preg_match('/\\.\\./', $local)) {
			 # local part has two consecutive dots
			 $isValid = false;
		  } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
			 # character not valid in domain part
			 $isValid = false;
		  } else if (preg_match('/\\.\\./', $domain)) {
			 # domain part has two consecutive dots
			 $isValid = false;
		  } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
			 # character not valid in local part unless 
			 # local part is quoted
			 if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
				$isValid = false;
			 }
		  } else if (strpos($domain, '.') === FALSE) {
			 # domain has no period
			 $isValid = false;
		  }
		  
		 /* if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
			 # domain not found in DNS
			 $isValid = false;
		  } */
	 }
	 #return true if all above pass
	 return $isValid;
}
	
	
	
/**
 * Validate a delimited list of email addresses
 *
 * @param String $emaillist A delimited list of email addresses
 * @param boolean $isRequired Whether the email addresses are required
 * @param String $delimiter The delimiter for the emails, defaults to a comma
 * 
 * @return TRUE if the emails in the list are valid, and FALSE if any of the emails in the list are invalid
 */
function is_valid_email_list($emaillist, $isRequired = true, $delimiter = ",") 
{
	$list = explode($delimiter, $emaillist); 
	foreach ($list as $email) {
		if (!is_valid_email($email, $isRequired)) {
			return false; 
		} 
	}
	return true; 
}

/**
 * Session existance check.
 * 
 * Helper function that checks to see that we have a 'set' $_SESSION that we can
 * use for the demo.   
 */ 
function oauth_session_exists() {
  if((is_array($_SESSION)) && (array_key_exists('oauth', $_SESSION))) {
    return TRUE;
  } else {
    return FALSE;
  }
}



#Convert from one base to another
function convert_bases($numberInput, $fromBaseInput, $toBaseInput)
{
    if ($fromBaseInput==$toBaseInput) return $numberInput;
    $fromBase = str_split($fromBaseInput,1);
    $toBase = str_split($toBaseInput,1);
    $number = str_split($numberInput,1);
    $fromLen=strlen($fromBaseInput);
    $toLen=strlen($toBaseInput);
    $numberLen=strlen($numberInput);
    $retval='';
    if ($toBaseInput == '0123456789')
    {
        $retval=0;
        for ($i = 1;$i <= $numberLen; $i++)
            $retval = bcadd($retval, bcmul(array_search($number[$i-1], $fromBase),bcpow($fromLen,$numberLen-$i)));
        return $retval;
    }
    if ($fromBaseInput != '0123456789')
        $base10=convBase($numberInput, $fromBaseInput, '0123456789');
    else
        $base10 = $numberInput;
		
    if ($base10<strlen($toBaseInput))
        return $toBase[$base10];
    while($base10 != '0')
    {
        $retval = $toBase[bcmod($base10,$toLen)].$retval;
        $base10 = bcdiv($base10,$toLen,0);
    }
    return $retval;
}


#Function to check if string contains special characters
function does_string_contain_special_characters($string, $allowSpaces=FALSE)
{
	if (!$allowSpaces && !preg_match("#^[a-zA-Z0-9]+$#", $string)) {
   		return TRUE;  
	} 
	else if ($allowSpaces && !preg_match("#^[a-zA-Z0-9 ]+$#", $string)) {
   		return TRUE;  
	} 
	else 
	{
   		return FALSE;
	}
}


#Function to clean a string and remove special characters or spaces
function remove_string_special_characters($string, $allowSpaces=FALSE)
{
	if($allowSpaces)
	{
		$string = str_replace(' ', '-', $string);
		return str_replace('-', ' ', preg_replace('/[^A-Za-z0-9\-]/', '', $string));
	}
	else
	{
		return preg_replace('/[^A-Za-z0-9]/', '', $string);
	}
}



#Function to provide the difference of two dates in a desired format
#$minKey tells the function which minimum key to return in ideal situation, but if this key is empty, it will return the next non-empty key below it
function format_date_interval($startDate, $endDate, $returnArray=TRUE, $ignoreEmpty=TRUE, $minKey='')
{
    $interval = date_diff(date_create($startDate), date_create($endDate));
    $diffString = $interval->format("years:%Y,months:%M,days:%d,hours:%H,minutes:%i,seconds:%s");
    
	#Put the diff in an array
	$diffArray = array();
    array_walk(explode(',',$diffString),
    
	function($val,$key) use(&$diffArray){
        $diffPart=explode(':',$val);
        $diffArray[$diffPart[0]] = $diffPart[1];
    });
	
	#Remove the empty parts of the array
	$finalArray = array();
	foreach($diffArray AS $partKey=>$intervalPart)
	{
		$intervalPart = $intervalPart+0;
		if(!empty($intervalPart))
		{
			$finalArray[$partKey] = $intervalPart;
		}
	}
	
	#Now consider the minKey to be returned
	if(!empty($minKey))
	{
		$finalMinArray = array();
		$lastNonEmptyValue = 0;
		$reachedMinKey = FALSE;
			
		foreach($diffArray AS $key=>$value)
		{
			$value = 0+$value;
			#Only update the last non-empty value if you encounter a non-empty value
			$lastNonEmptyValue = !empty($value)? $value: $lastNonEmptyValue;
			
			if(!empty($value) && $key != $minKey)
			{
				$finalMinArray[$key] = $value;
				#Break if you already passed the minimum key
				if($reachedMinKey) break;
			} 
			else if(trim($key) == $minKey)
			{
				if(!empty($value))
				{
					$finalMinArray[$key] = $value;
				}
				$reachedMinKey = TRUE;
				if(!empty($lastNonEmptyValue))break;
			}
		}
		
		$finalArray = $finalMinArray;
	}
	
	
	#Return the interval in a desired format
	if($returnArray)
	{
		#Ignore empty parts of the interval or not?
		return $ignoreEmpty? $finalArray : $diffArray;
	}
	else
	{
		if($ignoreEmpty)
    	{
			$finalString = "";
			foreach($finalArray AS $partKey=>$intervalPart)
			{
				$intervalPart = 0+$intervalPart;
				$finalString .= $intervalPart." ".($intervalPart == 1? substr($partKey, 0, -1): $partKey).", ";
			}
			return !empty($finalArray)? trim($finalString, ', '): "0 seconds";
		}
		else 
		{
			return $diffString;
		}
	}
    
	
}









#Function to format a number to a desired length and format
function format_number($number, $maxCharLength=100, $decimalPlaces=2, $singleChar=TRUE, $hasCommas=TRUE)
{
	#first strip any formatting;
    $number = (0+str_replace(",","",$number));
    #is this a number?
    if(!is_numeric($number)) return false;
	
	#now format it based on desired length and other instructions
    if($number > 1000000000000 && $maxCharLength < 13) return number_format(($number/1000000000000),$decimalPlaces, '.', ($hasCommas? ',': '')).($singleChar? 'T': ' trillion');
    else if($number > 1000000000 && $maxCharLength < 10) return number_format(($number/1000000000),$decimalPlaces, '.', ($hasCommas? ',': '')).($singleChar? 'B': ' billion');
    else if($number > 1000000 && $maxCharLength < 7) return number_format(($number/1000000),$decimalPlaces, '.', ($hasCommas? ',': '')).($singleChar? 'M': ' million');
    else if($number > 1000 && $maxCharLength < 4) return number_format(($number/1000),$decimalPlaces, '.', ($hasCommas? ',': '')).($singleChar? 'K': ' thousand');
	else return number_format($number,(is_float($number)? $decimalPlaces: 0), '.', ($hasCommas? ',': ''));
}





#Generate the pagination table
function pagination($itemCount, $noPerPage=5, $currentPage=1, $tableId='', $extraStyling='', $pageLimit=0)
{
       $pageCount = ceil($itemCount/$noPerPage);
       $paginationIdParts = explode('__', $tableId);
	   
	   $tableHtml = "<table id='".$tableId."' border='0' cellspacing='0' cellpadding='0' class='paginationtable' style='".$extraStyling."'>
  					<tr>
    					<td id='".$paginationIdParts[0]."__first'>&laquo;</td>";
		for($i=1; $i<($pageCount+1); $i++)
		{
			
			$tableHtml .= "<td ".($currentPage == $i? " class='selectedpagination'": "").">".$i."</td>";
			#Do not exceed the page limit
			if(!empty($pageLimit) && $i >= $pageLimit)
			{
				break;
			}
		}
	   $tableHtml .= "<td id='".$paginationIdParts[0]."__last'>&raquo;</td>
  </tr></table>";
	   
       return $tableHtml;
}







#Function to control access to a function based on the passed variables
function access_control($obj, $usertypes=array())
{	
	#By default, this function checks that the user is logged in
	if($obj->native_session->get('userId'))
	{
		$usertype = $obj->native_session->get('user_type');
		#If logged in, check if the user is allowed to access the given page
		if(!empty($usertypes) && !in_array($usertype, $usertypes))
		{
			$qmsg = 'WARNING: You do not have the priviledges to access this function.';
		}
	}
	else
	{
		$qmsg = 'WARNING: You are not logged in or your session expired. Please login to continue.';
	}
		
	#Redirect if the user has no access to the given page
	if(!empty($qmsg))
	{
		$obj->native_session->set('qmsg', $qmsg);
		redirect(base_url()."web/account/logout/m/qmsg");
	}
}



#Returns appropriate message for a dorp down list
function get_list_message($obj, $messageCode, $defaultMessage='')
{
	$message = $defaultMessage;
	if(empty($message))
	{
		$messageDetails = $obj->db->query($obj->query_reader->get_query_by_code('get_system_message', array('message_code'=>$messageCode)) )->row_array();
		$message = !empty($messageDetails['message'])? $messageDetails['message']: $message;
	}
	return $message;
}



#limit string length
function limit_string_length($string, $maxLength, $ignoreSpaces=TRUE, $endString='..')
{
    if (strlen(html_entity_decode($string, ENT_QUOTES)) <= $maxLength) return $string;
	
	if(!$ignoreSpaces)
	{
    	$newString = substr($string, 0, $maxLength);
		$newString = (substr($newString, -1, 1) != ' ')?substr($newString, 0, strrpos($newString, " ")) : $string;
	}
	else
	{
		$newString = substr(html_entity_decode($string, ENT_QUOTES), 0, $maxLength);
		if(strpos($newString, '&') !== FALSE)
		{
			$newString = substr($newString, 0, strrpos($newString, " "));
		}
	}
	
    return $newString.$endString;
}



#Function to compute distance between two latitudes and longitudes
function compute_distance_between_latitude_and_longitude($latitude1, $longitude1, $latitude2, $longitude2, $unit='miles')
{
	$theta = $longitude1 - $longitude2;
  	$distance = sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) +  cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta));
	$distance = acos($distance);
	$distance = rad2deg($distance);
	$miles = $distance * 60 * 1.1515;
	$unit = strtoupper($unit);
	 
	if ($unit == "kilometers") 
	{
	   return ($miles * 1.609344);
	} 
	else if ($unit == "nautical_miles") 
	{
	   return ($miles * 0.8684);
    } 
	else if ($unit == "miles")
	{
	   return $miles;
	}
}



#Function to compute age from birthday
function compute_age_from_birthday($birthday, $returnType='years')
{
	$age = 0;
	
	if(!empty($birthday) && $birthday != '0000-00-00')
	{
		$interval = format_date_interval($birthday, date('Y-m-d'), TRUE, FALSE);
		if($returnType == 'years')
		{
			$age = $interval['years'];
		}
		else
		{
			$age = $interval;
		}
	}
	
	return $age;
}



#Function to check whether a variable is not empty
function is_not_empty($variable)
{
	return !empty($variable);
}


# get a list of sort columns and their data to pass to array_multisort
function pick_sort_list_data($data, $dataKeys)
{
	$sortList = array();
	foreach($data AS $key=>$row)
	{
   	 	#Pick the columns to sort by
		foreach($dataKeys AS $dataKey)
		{
			$sortList[$dataKey][$key] = !empty($row[$dataKey])?$row[$dataKey]:'';
		}
	}
	
	return $sortList;
}



#Format website for display
function format_website_for_display($rawWebsite)
{
	$website = strtolower($rawWebsite);
	if(strpos($website, 'http://') !== false)
	{
		$website = substr($rawWebsite, 7);
	}
	else if(strpos($website, 'https://') !== false)
	{
		$website = substr($rawWebsite, 8);
	}
	else
	{
		$website = $rawWebsite;
	}
	
	return $website;
}



#Remove an array item from the given items and return the final array
function remove_item($item, $fullArray)
{
	#First remove the item from the array list
	unset($fullArray[array_search($item, $fullArray)]);
	
	return $fullArray;
}




#Return a string between the given strings
function get_string_between($string, $start, $end)
{
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
	
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
	
    return substr($string,$ini,$len);
}



#Function to get a slow loading page link
function get_slow_link_url($url, $title, $loadingMessage='')
{
	return base_url().'web/page/load_slow_page/p/'.encrypt_value($url).'/t/'.encrypt_value($title).(!empty($loadingMessage)? '/m/'.encrypt_value($loadingMessage): '');
}

?>