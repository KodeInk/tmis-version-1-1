<?php

/**
 * This class Picks queries from the database, inserts requested data and then returns the query for processing.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 11/26/2013
 */
class Query_reader extends CI_Model
{
	#a variable to hold the cached queries to prevent pulling from the DB for each request
    private $cachedQueries=array();
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
	}
	
	#Function which picks the queries from the database
	function get_query_by_code($queryCode, $queryData = array())
	{
		$queryString = !empty($this->cachedQueries[$queryCode])? $this->cachedQueries[$queryCode]: $this->get_raw_query_string($queryCode);
		
		if(!empty($queryString))
		{
			# Process the query data to fit the field format expected by the query
			$queryData = $this->format_field_for_query($queryData);
		
			#replace place holders with actual data required in the string
			foreach($queryData AS $key => $value)
			{
				$queryString = str_replace("'".$key."'", "'".$value."'", $queryString);
			}
			
			#Then replace any other keys without quotes
			foreach($queryData AS $key => $value)
			{
				$queryString = str_replace($key, ''.$value, $queryString);
			}
		}
		
		
		return $queryString;
	}
	
	
	
	#Returns the raw query string
	private function get_raw_query_string($queryCode)
	{
		# Get the query from the database by the query code
		$qresultArray = $this->db->query("SELECT query FROM system_queries WHERE querycode = '".$queryCode."'")->row_array();
		
		$this->cachedQueries[$queryCode] = !empty($qresultArray['query'])? $qresultArray['query']: '';
		return $this->cachedQueries[$queryCode]; 
	}
	
	
	
	
	# Returns all fields in the format array('_FIELDNAME_', 'fieldvalue') which is expected by the database 
	# query processing function
	function format_field_for_query($queryData)
	{	
		$dataForQuery = array();
	
		foreach($queryData AS $key => $value)
		{
			#e.g., $queryData['_LIMIT_'] = "10";
			$dataForQuery['_'.strtoupper($key).'_'] = $value;
		}
		
		return $dataForQuery;
	}
	
}


?>