<?php
/**
 * This file contains functions that are used in loading data for drop downs
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */




# Get a list of options 
# Allowed return values: [div, option]
function get_option_list($obj, $list_type, $return = 'div')
{
	$optionString = "";
	
	switch($list_type)
	{
		case "district":
			$districts = $obj->query_reader->get_list('get_list_of_districts');
			foreach($districts AS $row)
			{
				$optionString .= "<div data-value='".$row['value']."'>".$row['display']."</div>";
			}
		break;
		
		
		case "country":
			$countries = $obj->query_reader->get_list('get_list_of_countries');
			foreach($countries AS $row)
			{
				$optionString .= "<div data-value='".$row['value']."'>".$row['display']."</div>";
			}
		break;
		
		
		case "citizentype":
			$types = array('By Birth', 'By Naturalization', 'By Registration');
			foreach($types AS $row)
			{
				$optionString .= "<div data-value='".$row."'>".$row."</div>";
			}
		break;
		
		
		case "institutiontype":
			$types = array('University', 'College', 'Technical', 'Secondary', 'Primary');
			foreach($types AS $row)
			{
				$optionString .= "<div data-value='".$row."'>".$row."</div>";
			}
		break;
		
		
		case "month":
			$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			foreach($months AS $row)
			{
				$optionString .= "<div data-value='".$row."'>".$row."</div>";
			}
		break;
		
		
		case "pastyear":
			for($i=date('Y'); $i>(date('Y') - 80); $i--)
			{
				$optionString .= "<div data-value='".$i."'>".$i."</div>";
			}
		break;
		
		
		case "subjecttype":
			$types = array('Major', 'Other', 'Minor');
			foreach($types AS $row)
			{
				$optionString .= "<div data-value='".$row."'>".$row."</div>";
			}
		break;
		
		
		
		
		
		
		
		default:
			$optionString = ($return == 'div')? "<div data-value=''>No options available</div>": "<option value=''>No options available</option>";
		break;
	}
	
	return $optionString;
}

	




?>