<?php
/**
 * This class manages addition, removal and update of the person in the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class Person extends CI_Model
{
	
	# STUB: Add a person's profile
	function add_profile($profileDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}
	
	
	
	# STUB: Add a person's address
	function add_address($personId, $addressDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}	
		
	
	
	# STUB: Add a subject taught
	function add_subject_taught($personId, $subjectDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}
		
	
	
	# STUB: Add the person's education
	function add_education($personId, $educationDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}	
	
		
	
	
	# STUB: Add another ID that identifies that person on a third party system
	function add_another_id($personId, $idDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}	
	
		
	
	
	# STUB: Update the person's profile information
	function update_profile($personId, $profileDetails)
	{
		$isUpdated = false;
		
		
		return $isUpdated;
	}		
	
		
	
	
	# STUB: Add an institution to a person's profile
	function add_institution($personId, $institutionDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}
	
		
	
	
	# STUB: Remove institution details from the user's profile
	function remove_institution($personId, $institutionId)
	{
		$isRemoved = false;
		
		
		return $isRemoved;
	}
	
		
	
	
	# STUB: Reject a list of institutions provided by the user as part of their education details
	function reject_education($personId, $educationDetails)
	{
		$isRejected = false;
		
		
		return $isRejected;
	}

		
	
	
	# STUB: Apply profile secrecy to the user's person account
	function apply_profile_secrecy($personId, $reasons)
	{
		$isApplied = false;
		
		
		return $isApplied;
	}

		
	
	
	# STUB: Remove profile secrecy from the user's person account
	function remove_profile_secrecy($personId, $reasons)
	{
		$isRemoved = false;
		
		
		return $isRemoved;
	}

		
	
	
	# STUB: Set the grade of the person
	function set_grade($personId, $gradeDetails)
	{
		$isSet = false;
		
		
		return $isSet;
	}

		
	
	
	# STUB: Generate the person's file number
	function generate_file_number($personId, $parameters=array())
	{
		$isSet = false;
		
		
		return $isSet;
	}

		
	
	
	# STUB: Generate the person's computer number 
	function generate_computer_number($personId, $parameters=array())
	{
		$isSet = false;
		
		
		return $isSet;
	}


	
	
	
}


?>