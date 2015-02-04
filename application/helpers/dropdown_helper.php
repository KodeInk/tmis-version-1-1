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
function get_option_list($obj, $list_type, $return = 'div', $searchBy="")
{
	$optionString = "";
	
	switch($list_type)
	{
		case "district":
			$districts = $obj->_query_reader->get_list('get_list_of_districts');
			foreach($districts AS $row)
			{
				$optionString .= "<div data-value='".$row['value']."'>".$row['display']."</div>";
			}
		break;
		
		
		case "institutions":
			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";
			$searchQuery = !empty($searchString)? " MATCH(name) AGAINST('+".implode(" +",explode(" ",$searchString))."') OR name LIKE '".$searchString."%' OR name LIKE '% ".$searchString."%'": " 1=1 ";
			$institutions = $obj->_query_reader->get_list('get_list_of_institutions', array('search_query'=>$searchQuery));
			foreach($institutions AS $row)
			{
				$optionString .= "<div data-value='".$row['value']."'>".$row['display']."</div>";
			}
		break;
		
		
		case "country":
			$countries = $obj->_query_reader->get_list('get_list_of_countries');
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
		
		
		case "jobroles":
			$roles = $obj->_query_reader->get_list('get_permission_groups', array('system_only'=>"'N'"));
			foreach($roles AS $row)
			{
				$optionString .= "<div data-value='".$row['value']."'>".$row['display']."</div>";
			}
		break;
		
		
		case "roles":
			$roles = $obj->_query_reader->get_list('get_permission_groups', array('system_only'=>"'N','Y'"));
			foreach($roles AS $row)
			{
				$optionString .= "<div data-value='".$row['value']."'>".$row['display']."</div>";
			}
		break;
		
		
		case "users":
			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";
			$searchQuery = !empty($searchString)? " P.first_name LIKE '".$searchString."%' OR P.first_name LIKE '% ".$searchString."%' OR P.last_name LIKE '".$searchString."%' AND U.status='active' ": " U.status='active' ";
			$orderBy = " ORDER BY P.last_name ASC";
			
			$users = $obj->_query_reader->get_list('get_user_list_data', array('search_query'=>$searchQuery, 'order_by'=>$orderBy, 'limit_text'=>'100'));
			foreach($users AS $row)
			{
				$optionString .= "<div data-value='".$row['value']."' onclick=\"universalUpdate('userid', '".$row['id']."')\">".$row['display']."</div>";
			}
		break;
		
		
		case "schooltypes":
			$types = array('Primary', 'Secondary', 'Tertiary', 'University', 'Other');
			foreach($types AS $row)
			{
				$optionString .= "<div data-value='".$row."'>".$row."</div>";
			}
		break;
		
		
		case "teachers":
			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";
			$searchQuery = !empty($searchString)? " P.first_name LIKE '".$searchString."%' OR P.first_name LIKE '% ".$searchString."%' OR P.last_name LIKE '".$searchString."%' AND U.status='active' ": " U.status='active' ";
			$orderBy = " ORDER BY P.last_name ASC";
			
			$users = $obj->_query_reader->get_list('get_user_list_data', array('search_query'=>$searchQuery." AND U.permission_group_id='2' ", 'order_by'=>$orderBy, 'limit_text'=>'100'));
			foreach($users AS $row)
			{
				$optionString .= "<div data-value='".$row['value']."' onclick=\"universalUpdate('teacherid', '".$row['id']."')\">".$row['display']."</div>";
			}
		break;
		
		
		
		case "contactreason":
			$reasons = array('Account Access', 'Job Application', 'Information Security', 'General Inquiries');
			foreach($reasons AS $row)
			{
				$optionString .= "<div data-value='".$row."'>".$row."</div>";
			}
		break;
		
		
		case "grades":
			$grades = $obj->_query_reader->get_list('get_teacher_grades');
			foreach($grades AS $row)
			{
				$optionString .= "<div data-value='".$row['value']."'>".$row['display']."</div>";
			}
		break;
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		default:
			$optionString = ($return == 'div')? "<div data-value=''>No options available</div>": "<option value=''>No options available</option>";
		break;
	}
	
	return $optionString;
}

	




?>