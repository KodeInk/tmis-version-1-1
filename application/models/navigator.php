<?php
/**
 * Helps controllers with navigation data.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class Navigator extends CI_Model
{
	
	# STUB: Get the user's dashboard
	function get_user_dashboard($userId)
	{
		$dashboard = "";
		
		
		return $dashboard;
	}
	
	
	
	# STUB: Logout a user
	function logout($userId="")
	{
		$isLoggedOut = false;
		
		
		return $isLoggedOut;
	}		
	
	
	
	# STUB: Clean parameters before they are used by other functions.
	function clean_forwarded_parameters($data)
	{
		$cleanData = array();
		
		
		return $cleanData;
	}		
	
	
	
	# STUB: Set the next page for the user
	function set_next_page($sessionData)
	{
		$nextPage = "";
		
		
		return $nextPage;
	}		
	
	
	
	# STUB: Set the previous page for the user
	function set_previous_page($sessionData)
	{
		$previousPage = "";
		
		
		return $previousPage;
	}		



}


?>