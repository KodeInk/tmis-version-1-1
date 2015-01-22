<?php
/**
 * Handles and generates reports in the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class _report extends CI_Model
{
	
	private $query = "";
	
	# STUB: Generate a CSV report
	function generate_csv($query, $parameters=array())
	{
		$file = "";
		
		
		return $file;
	}
		
		
		
	# STUB: Generate a PDF report
	function generate_pdf($query, $parameters=array())
	{
		$file = "";
		
		
		return $file;
	}	
		
		
		
	# STUB: Send a report
	function send_report($query, $parameters=array())
	{
		$isSent = false;
		
		
		return $isSent;
	}	
	
		
		
	# STUB: Get a report list
	function get_report_list($query, $parameters=array())
	{
		$list = array();
		
		
		return $list;
	}	
	
		
		
	# STUB: Set a report query
	function set_report_query($queryDetails)
	{
		$isSet = false;
		
		
		return $isSet;
	}




}


?>