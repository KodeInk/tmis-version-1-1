<?php
/**
 * This class handles validation of data in the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class Validator extends CI_Model
{
	
	# Check if this is a valid user account
	function is_valid_account($accountDetails)
	{
		$boolean = false;
		$userId = "";
		
		$user = $this->query_reader->get_row_as_array('get_user_by_name_and_pass', array('login_name'=>$accountDetails['login_name'], 'login_password'=>sha1($accountDetails['login_password']) ));
		if(!empty($user))
		{
			$boolean = true;
			$userId = $user['id'];
			
			#Set the user's session variables
			$this->native_session->set('user_id', $user['id']);
			$this->native_session->set('email_address', $user['email_address']);
			if(!empty($user['telephone'])) $this->native_session->set('telephone', $user['telephone']);
			$this->native_session->set('permission_group', $user['permission_group_id']);
			$this->native_session->set('first_name', $user['first_name']);
			$this->native_session->set('last_name', $user['last_name']);
			$this->native_session->set('gender', $user['gender']);
			$this->native_session->set('date_of_birth', $user['date_of_birth']);
		}
		
		return array('boolean'=>$boolean, 'user_id'=>$userId);
	}
	
	
	
	# STUB: Check if this is a valid email
	function is_valid_email($email)
	{
		$isValid = false;
		
		
		return $isValid;
	}
	
	
	
	# STUB: Check if this is a valid phone
	function is_valid_phone($phone)
	{
		$isValid = false;
		
		
		return $isValid;
	}
	
	
	
	# Check if this is a valid confirmation code
	function is_valid_confirmation_code($personId, $code)
	{
		$isValid = false;
		
		if(strlen($code) > 2)
		{
			$hexCode = strrev(substr($code, 0, (strlen($code)-2))); 
			$isValid = (hexdec($hexCode) == $personId)? true: false;
		}
		
		return $isValid;
	}
	
	
	
	# STUB: Check if this is a valid confirmation password
	function is_valid_password($password)
	{
		$isValid = false;
		
		
		return $isValid;
	}
	
	
	
	# STUB: Check if this is a valid address
	function is_valid_address($addressDetails)
	{
		$isValid = false;
		
		
		return $isValid;
	}


}


?>