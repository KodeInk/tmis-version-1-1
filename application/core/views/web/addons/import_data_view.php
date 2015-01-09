<?php 
$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

if($area == 'institution_results')
{
	$list = $xmlObj['institution'];
}


#All import lists will use this functionality to display their lists
	echo "<table  width='100%' cellpadding='3' cellspacing='0' border='0'>
	<tr>";
	
	#First clear all institution details in the temp DB table
	$result = $this->db->query($this->query_reader->get_query_by_code('clear_institution_table', array()));
			
	$titles = array_keys($list[0]);
	foreach($titles AS $heading)
	{
	    echo "<td nowrap><b>".$this->data_import->get_heading_conversions($heading)."</b></td>";
	}
	echo "</tr>";
	
	#List all data pulled from the results
	$counter = 0;
	foreach($list AS $row)
	{
		#Now, insert the data into the DB as you display them
		if($area == 'institution_results')
		{
			
			if($result)
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('add_raw_institution', array('institution_id'=>$row['institutionId'], 'institution_name'=>htmlentities($row['institutionName'], ENT_QUOTES), 'home_url'=>(!empty($row['homeUrl'])? htmlentities($row['homeUrl'], ENT_QUOTES): ''), 'phone_number'=>(!empty($row['phoneNumber'])? $row['phoneNumber']: ''), 'is_virtual'=>(!empty($row['virtual'])? $row['virtual']: '') )));
			}
		}
		
		
		echo "<tr style='".get_row_color($counter, 2)."'>";
		foreach($row AS $value) 
   		{
       		echo "<td>".$value."</td>";
    	}
		echo "</tr>";
		$counter++;
	}
	echo "</table>";


?>