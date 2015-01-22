<?php
/**
 * This class manages the approval processes in the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class _approval_chain extends CI_Model
{
	
	# STUB: Add a new approval chain
	function add_chain($roleDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}
		
		
	
	# STUB: Get the type of approval 
	function get_approval_type($chainId)
	{
		$type = "";
		
		
		return $type;
	}
			
		
	
	# STUB: Check if the user is authorized to approve at the approval chain stage.
	function is_user_authorized_to_approve($userId, $chainId, $stage)
	{
		$isAuthorized = false;
		
		
		return $isAuthorized;
	}
			
		
	
	# STUB: Approve a stage in the chain
	function approve($approverId, $chainId, $stage, $note)
	{
		$isApproved = false;
		
		
		return $isApproved;
	}
			
		
	
	# STUB: Reject a stage in the chain
	function reject($rejectorId, $chainId, $stage, $note)
	{
		$isRejected = false;
		
		
		return $isRejected;
	}
			
		
	
	# STUB: Issue a certificate
	function issue_certificate($userId, $chainId, $stage)
	{
		$isIssued = false;
		
		
		return $isIssued;
	}		
			
		
	
	# STUB: Add a chain note
	function add_chain_note($userId, $chainId, $stage, $note)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}	
			
		
	
	# STUB: Get approval parties 
	function get_approval_parties($userId, $chainId, $stage)
	{
		$parties = array();
		
		
		return $parties;
	}	
			
		
	
	# STUB: Set the next approver in the chain stage
	function set_next_approver($chainId, $nextApproverId)
	{
		$isSet = false;
		
		
		return $isSet;
	}	
			
		
	
	# STUB: Add a chain setting
	function add_chain_setting($settingDetails)
	{
		$isAdded= false;
		
		
		return $isAdded;
	}

			
		
	
	# STUB: Get the action to perform based on the step in the chain.
	function get_step_action($chainId, $step, $actionType="approve")
	{
		$isAdded= false;
		
		
		return $isAdded;
	}








}


?>