<?php
/**
 * This class handles permissioning in the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class Permission extends CI_Model
{
	
	# STUB: Get group permission list
	function get_group_permission_list($groupId)
	{
		$permissions = array();
		
		
		return $permissions;
	}
		
		
	
	# STUB: Deactivate permission.
	function deactivate($permissionId)
	{
		$isDeactivated = false;
		
		
		return $isDeactivated;
	}
		
		
	
	# STUB: Activate permission.
	function activate($permissionId)
	{
		$isActivated = false;
		
		
		return $isActivated;
	}
		
		
	
	# STUB: Add a new permission group
	function add_new_group($groupDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}
		
		
	
	# STUB: Update group permissions.
	function update_group_permissions($groupId, $newPermissions)
	{
		$isUpdated = false;
		
		
		return $isUpdated;
	}
		
		
	
	# STUB: Check if a group can be notified about changes in their permissions
	function can_group_be_notified($groupId)
	{
		$canBeNotified = false;
		
		
		return $canBeNotified;
	}	
	
	

}


?>