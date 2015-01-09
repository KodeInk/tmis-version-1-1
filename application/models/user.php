<?php
/**
 * This class handles user functions in the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class User extends CI_Model
{
	
	# STUB: Check if a user exists and is active
	function validate_user($userName, $userPassword, $getDetails=false)
	{
		$isValid = false;
		
		
		return $isValid;
	}
	
	# STUB: Add a new user
	function add_new()
	{
		$userId = "";
		
		return $userId;
	}
	
	# STUB: Check if a user has a valid user session
	function has_valid_session($userId)
	{
		$isValid = false;
		
		return $isValid;
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
	
	
	# STUB: Update a user account
	function update($userId, $userDetails)
	{
		$isUpdated = false;
		
		return $isUpdated;
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
			
	
	# STUB: Generate a confirmation code for the user to verify their account
	function generate_confirmation_code($userDetails)
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
	

	
}


?>