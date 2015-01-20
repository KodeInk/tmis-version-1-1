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
	
	# Get permission list of a given user id
	function get_user_permission_list($userId)
	{
		# What's the user's permission group?
		if($this->native_session->get('permission_group'))
		{
			$userPermissionGroup = $this->native_session->get('permission_group');
		}
		else
		{
			$user = $this->query_reader->get_row_as_array('get_user_by_id', array('user_id'=>$userId));
			$userPermissionGroup = $user['permission_group_id'];
		}
		
		return $this->get_group_permission_list($userPermissionGroup);
	}
	
	
	
	# Get group permission list
	function get_group_permission_list($groupId)
	{
		$permissions = array();
		$group = $this->query_reader->get_row_as_array('get_group_by_id', array('group_id'=>$groupId));
		
		# Only proceed if the group exists
		if(!empty($group))
		{
			$this->native_session->set('permission_group_name', $group['name']);
			$permissions = $this->query_reader->get_single_column_as_array('get_group_permissions', 'code', array('group_id'=>$groupId));
		}
		
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