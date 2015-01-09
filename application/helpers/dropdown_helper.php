<?php
/**
 * This file contains functions that are used in loading data for drop downs
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */




#Function to get data related to dropdown lists
function get_dropdown_lists($obj, $dropList)
{
	$listData = array();
	
	foreach($dropList AS $listName)
	{
		#Create the list data field to store the dropdown list data
		$listData[$listName] = array();
		
		switch($listName)
		{
			#The phone provider
			case 'phone_carrier':
				$list = $obj->db->query($obj->query_reader->get_query_by_code('search_phone_carriers', array('condition'=>'')))->result_array();
				foreach($list AS $row)
				{
					array_push($listData[$listName], array('value'=>$row['id'], 'display'=>$row['full_carrier_name']));
				}
			break;
			
			#The gender of the user
			case 'gender':
				$list = array(array('gender_type'=>'Female'), array('gender_type'=>'Male'));
				foreach($list AS $row)
				{
					array_push($listData[$listName], array('value'=>strtolower($row['gender_type']), 'display'=>$row['gender_type']));
				}
			break;
			
			#The day of the month
			case 'day_of_month':
				$list = array();
				for($i=1;$i<32;$i++) array_push($list, array('day_value'=>sprintf('%02d', $i)));
				foreach($list AS $row)
				{
					array_push($listData[$listName], array('value'=>strtolower($row['day_value']), 'display'=>$row['day_value']));
				}
			break;
			
			#The month of the year - in number format
			case 'month_number':
				$list = array();
				for($i=1;$i<13;$i++) array_push($list, array('month_value'=>sprintf('%02d', $i)));
				foreach($list AS $row)
				{
					array_push($listData[$listName], array('value'=>strtolower($row['month_value']), 'display'=>$row['month_value']));
				}
			break;
			
			#The month of the year - in number format
			case 'birth_year_above_17':
			case 'birth_year_above_13':
				$caseParts = explode('_', $listName);
				$minAge = end($caseParts);
				$list = array();
				for($i=(date('Y')-$minAge);$i>(date('Y')-100);$i--)  array_push($list, array('year_value'=>$i));
				foreach($list AS $row)
				{
					array_push($listData[$listName], array('value'=>strtolower($row['year_value']), 'display'=>$row['year_value']));
				}
			break;
			
			
			
			
			
			
			
			
			
			
			default:
			break;
		}
	}
	
	return $listData;
}


	




?>