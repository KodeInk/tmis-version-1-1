<?php
/**
 * This class handles user functions in the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class _user extends CI_Model
{
	# STUB: Add a new user
	function add_new()
	{
		$userId = "";
		
		return $userId;
	}
	
	
	# STUB: Activate a user account
	function activate($userId)
	{
		$isActive = false;
		
		return $isActive;
	}
	
	
	# STUB: Deactivate a user account
	function deactivate($userId)
	{
		$isDeactivated = false;
		
		
		return $isDeactivated;
	}
	
	
	# STUB: Delete a user account
	function delete($userId)
	{
		$isDeleted = false;
		
		return $isDeleted;
	}
	
	
	# Update a user account
	function update($userId, $details)
	{
		$isUpdated = false;
		$msg = "";
		
		#Check if the user is changing their password
		if(!empty($details['currentpassword']) || !empty($details['newpassword']) || !empty($details['repeatpassword']))
		{
			# 1. If any of the above fields is empty, do not proceed to validate
			if(!empty($details['currentpassword']) && !empty($details['newpassword']) && !empty($details['repeatpassword']))
			{
				# 2. Check whether the new password is valid
				if($this->is_valid_password($details['newpassword']))
				{
					# 3. Check if the repeated password and the new password match
					if($details['newpassword'] == $details['repeatpassword'])
					{
						# 4. Now check whether the current password is valid
						$user = $this->_query_reader->get_row_as_array('get_user_by_name_and_pass', array('login_name'=>$this->native_session->get('profile_loginname'), 'login_password'=>sha1($details['currentpassword']) ));
						
						if(!empty($user))
						{
							$isUpdated = $this->_query_reader->run('update_user_password', array('new_password'=>sha1($details['newpassword']), 'old_password'=>sha1($details['currentpassword']), 'updated_by'=>$this->native_session->get('user_id'), 'user_id'=>$this->native_session->get('profile_id') ));
							$msg = $isUpdated? "Your profile changes have been applied.": "ERROR: Your password could not be updated.";
						}
						else
						{
							$msg = "WARNING: The current password provided is not valid.";
						}
						
					}
					else
					{
						$msg = "WARNING: The new password and your repeated password do not match.";
					}
					
				}
				else
				{
					$msg = "WARNING: Your new password does not meet the minimum security requirements.";
				}
			}
			else
			{
				$msg = "WARNING: Please provide the current password and your new password.";
			}
		}
		
		
		# User is not changing password - OR - the password change was successfull
		if($isUpdated || (!$isUpdated && $msg == ''))
		{
			# Update the person details
			$isUpdated = $this->_query_reader->run('update_person_profile_part', array('query_part'=>" first_name='".htmlentities($details['firstname'], ENT_QUOTES)."', last_name='".htmlentities($details['lastname'], ENT_QUOTES)."' ", 'person_id'=>$this->native_session->get('profile_personid') ));
			if(!$isUpdated)
			{
				$msg = "ERROR: We could not update your name.";
			}
			# Add or update the contact telephone if given
			else if(!empty($details['telephone']))
			{
				$queryCode = $this->native_session->get('profile_telephone')? 'update_contact_data': 'add_contact_data';
				$isUpdated = $this->_query_reader->run($queryCode, array('details'=>$details['telephone'], 'carrier_id'=>'', 'contact_type'=>'telephone', 'parent_type'=>'person', 'parent_id'=>$this->native_session->get('profile_personid') ));
				
				$msg = $isUpdated? "Your profile updates have been applied.": "ERROR: We could not update your name.";
			}
			
			#Notify to login again if the user's changes were successful
			$msg = $isUpdated? $msg." Please log out and login again to start using your new changes.": $msg;
		}
		
		
		
		
		return array('boolean'=>$isUpdated, 'msg'=>$msg);
	}
	
	
	
	# Check if the password provided is valid
	function is_valid_password($password)
	{
		return (strlen($password) > 5 && preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $password));
	}
	
	
		
	
	# STUB: Approve a user application
	function approve_user_application($applicationId, $notes)
	{
		$isApproved = false;
		
		return $isApproved;
	}
			
	
	# STUB: Reject a user application
	function reject_user_application($applicationId, $notes)
	{
		$isRejected = false;
		
		return $isRejected;
	}
		
	
	# STUB: Block a user from accessing the system
	function block($userId, $notes)
	{
		$isRejected = false;
		
		return $isRejected;
	}
			
	
	# STUB: Get the vacancies the user saved to view later
	function get_saved_vacancies($userId, $listParameters=array())
	{
		$vacancies = array();
		
		return $vacancies;
	}
			
	
	# STUB: Get the vacancy list that the user can qualify for
	function get_qualifying_vacancy_list($userId, $listParameters=array())
	{
		$vacancies = array();
		
		return $vacancies;
	}
			
	
	# STUB: Update the user password
	function update_password($userId, $newPasswordDetails)
	{
		$isUpdated = false;
		
		
		
		return $isUpdated;
	}
	

	
	# STUB: Assign the user to a school
	function assign_to_school($userId, $schoolId)
	{
		$isAssigned = false;
		
		
		return $isAssigned;
	}
	

	
	# STUB: Change the schools the user is assigned
	function change_schools($userId, $oldSchoolId, $newSchoolId)
	{
		$isChanged = false;
		
		
		return $isChanged;
	}	
	

	
	# STUB: Change the role of the user
	function change_role($userId, $newRoleId)
	{
		$isChanged = false;
		
		
		return $isChanged;
	}
	

	
	# STUB: Change the status of the user
	function change_status($userId, $newStatus)
	{
		$isChanged = false;
		
		
		return $isChanged;
	}
	

	# Populate a user session profile
	function populate_session($userId)
	{
		$profile = $this->_query_reader->get_row_as_array('get_user_profile', array('user_id'=>$userId));
		if(!empty($profile))
		{
			$this->native_session->set('profile_id', $profile['user_id']);
			$this->native_session->set('profile_personid', $profile['person_id']);
			$this->native_session->set('profile_loginname', $profile['login_name']);
			$this->native_session->set('profile_userrole', $profile['user_role']);
			$this->native_session->set('profile_lastname', $profile['last_name']);
			$this->native_session->set('profile_firstname', $profile['first_name']);
			if(!empty($profile['telephone'])) $this->native_session->set('profile_telephone', $profile['telephone']);
			$this->native_session->set('profile_emailaddress', $profile['email_address']);
		}
		
	}
	
}


?>