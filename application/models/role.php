<?php
/**
 * This class creates and manages role data.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class Role extends CI_Model
{
	
	# STUB: Add a new role
	function add_new($roleDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}
		
		
		
	# STUB: Get role description
	function get_description($roleId)
	{
		$role = array();
		
		
		return $role;
	}	
		
		
		
	# STUB: Get role permissions
	function get_role_permissions($roleId)
	{
		$permissions = array();
		
		
		return $permissions;
	}			
		
		
		
	# STUB: Users who have the given role
	function get_role_users($roleId)
	{
		$users = array();
		
		
		return $users;
	}	
		
		
		
	# STUB: The duration of the role for the user in the number of days.
	function get_role_duration($userId, $roleId)
	{
		$duration = 0;
		
		
		return $duration;
	}



}


?>