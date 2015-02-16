<?php 
$jquery = "<script src='".base_url()."assets/js/jquery-2.1.1.min.js' type='text/javascript'></script>";
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/tmis.js'></script>".get_AJAX_constructor(TRUE); 

$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/tmis.css' type='text/css' media='screen' />
<link rel='stylesheet' href='".base_url()."assets/css/tmis.list.css' type='text/css' media='screen' />"; 





if(!empty($area) && $area == "submit_recommendation")
{
	#Redirect back to list if submission has been made
	if(!empty($result)) $tableHTML .= "<script type='text/javascript'>window.top.location.href = '".base_url()."interview/lists/action/recommend';</script>";
	
	# There was an error loading the recommendation
	if(!empty($msg)) 
	{
		$tableHTML .= format_notice($this, $msg);
	} 
	# Show the recommendation form
	else
	{
	
		$tableHTML .= "<form id='recommend_".$id."' method='post' action='".base_url()."interview/recommend/id/".$id."'  class='simplevalidator'>
		<table border='0' cellspacing='0' cellpadding='10'>
			<tr><td class='label'>Recommend:</td><td class='value'>".$this->native_session->get('applicant')."</td></tr>
			<tr><td class='label'>Applying To:</td><td class='value'>".$this->native_session->get('institution_name')."</td></tr>
			<tr><td class='label'>Applied On:</td><td class='value'>".date('d-M-Y h:ia T', strtotime($this->native_session->get('submission_date')))."</td></tr>
			<tr><td class='label top'>Your Recommendation:</td><td><textarea id='details' name='details' title='Your recommendation' class='textfield' placeholder='Enter your recommendation here' style='min-width:300px; min-height: 150px;'></textarea></td></tr>
			
			<tr><td>&nbsp;</td><td><button type='submit' name='submit' id='submit' value='submit' class='btn'>SUBMIT</button></td></tr>
		</table></form>";
	}
}




else if(!empty($area) && $area == "recommendation_list")
{
	$tableHTML .= "<link rel='stylesheet' href='".base_url()."assets/css/tmis.list.css' type='text/css' media='screen' />
	<table border='0' cellspacing='0' cellpadding='0' class='listtable'>
		<tr class='header'><td>Recommender</td><td>Recommendation</td><td>Date</td></tr>";
	foreach($list AS $row)
	{
		$tableHTML .= "<tr class='listrow'><td style='vertical-align:top;'>".$row['recommender']."</td><td>".$row['notes']."</td><td style='vertical-align:top;'>".date('d-M-Y h:ia T', strtotime($row['date_added']))."</td></tr>";
	}
	$tableHTML .= "</table>";

}





else if(!empty($area) && $area == "set_date")
{
	#Redirect back to list if submission has been made
	if(!empty($result)) $tableHTML .= "<script type='text/javascript'>window.top.location.href = '".base_url()."interview/lists/action/setdate';</script>";
	
	# There was an error loading the details
	if(!empty($msg)) 
	{
		$tableHTML .= format_notice($this, $msg);
	} 
	# Show the form
	else
	{
	
		$tableHTML .= $jquery.$javascript."<link rel='stylesheet' href='".base_url()."assets/css/jquery-ui.css' type='text/css' media='screen' />
		<script src='".base_url()."assets/js/jquery-ui.js' type='text/javascript'></script>
		<script src='".base_url()."assets/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>
		<script src='".base_url()."assets/js/tmis.fileform.js' type='text/javascript'></script>
		
		<form id='setdate_".$id."' method='post' action='".base_url()."interview/set_date/id/".$id."'  class='simplevalidator'>
		<table border='0' cellspacing='0' cellpadding='10'>
			
			<tr><td class='label'>Applicant:</td><td class='value'>".$this->native_session->get('applicant')."</td></tr>
			
			<tr><td class='label'>Applying To:</td><td class='value'>".$this->native_session->get('institution_name')."</td></tr>
			
			<tr><td class='label'>Applied On:</td><td class='value'>".date('d-M-Y h:ia T', strtotime($this->native_session->get('submission_date')))."</td></tr>
			
			<tr><td class='label top'>Interviewer:</td><td><input type='text' id='interviewer__users' name='interviewer__users' title='Select or Search for User' placeholder='Select or Search for User' class='textfield selectfield searchable' value='' style='width:95%;' /><input type='text' class='textfield' id='userid' name='userid' value='' style='display:none;' /></td></tr>
			
			<tr><td class='label top'>Interview Date:</td><td><input type='text' id='interviewdate' name='interviewdate' title='Interview Date' class='textfield datefield showtime' value=''/></td></tr>
			
			<tr><td class='label top'>Notes:</td><td><textarea id='notes' name='notes' title='Interview Notes' class='textfield' placeholder='This message is sent to the applicant on submission of this form. Enter information the applicant may need to consider before the interview.' style='min-width:300px; min-height: 200px;'></textarea></td></tr>
			
			<tr><td>&nbsp;</td><td><button type='submit' name='submit' id='submit' value='submit' class='btn'>SUBMIT</button></td></tr>
		</table></form>
		<input type='hidden' id='layerid' name='layerid' value='' />";
	}
}





else if(!empty($area) && $area == "add_note")
{
	#Redirect back to list if submission has been made
	if(!empty($result)) $tableHTML .= "<script type='text/javascript'>window.top.location.href = '".base_url()."interview/lists/action/addresult';</script>";
	
	# There was an error loading the application
	if(!empty($msg)) 
	{
		$tableHTML .= format_notice($this, $msg);
	} 
	# Show the note form
	else
	{
	
		$tableHTML .= "<form id='addnote_".$id."' method='post' action='".base_url()."interview/add_note/id/".$id."'  class='simplevalidator'>
		<table border='0' cellspacing='0' cellpadding='10'>
			<tr><td class='label'>Job:</td><td class='value'>".$this->native_session->get('job')."</td></tr>
			<tr><td class='label'>Applicant:</td><td class='value'>".$this->native_session->get('applicant')."</td></tr>
			<tr><td class='label'>Interviewer:</td><td class='value'>".$this->native_session->get('interviewer')."</td></tr>
			<tr><td class='label'>Date:</td><td class='value'>".date('d-M-Y h:ia T', strtotime($this->native_session->get('interview_date')))."</td></tr>
			<tr><td class='label top'>Your Note:</td><td><textarea id='details' name='details' title='Your note' class='textfield' placeholder='Enter your note here' style='min-width:300px; min-height: 150px;'></textarea></td></tr>
			
			<tr><td>&nbsp;</td><td><button type='submit' name='submit' id='submit' value='submit' class='btn'>SUBMIT</button></td></tr>
		</table></form>";
	}
}




else if(!empty($area) && $area == "note_list")
{
	$tableHTML .= "<link rel='stylesheet' href='".base_url()."assets/css/tmis.list.css' type='text/css' media='screen' />
	<table border='0' cellspacing='0' cellpadding='0' class='listtable'>
		<tr class='header'><td nowrap>Added By</td><td>Note</td><td>Date</td></tr>";
	foreach($list AS $row)
	{
		$tableHTML .= "<tr class='listrow'><td style='vertical-align:top;'>".$row['added_by']."</td><td>".html_entity_decode($row['details'], ENT_QUOTES)."</td><td style='vertical-align:top;'>".date('d-M-Y h:ia T', strtotime($row['date_added']))."</td></tr>";
	}
	$tableHTML .= "</table>";

}





else if(!empty($area) && $area == "set_result")
{
	#Redirect back to list if submission has been made
	if(!empty($result)) $tableHTML .= "<script type='text/javascript'>window.top.location.href = '".base_url()."interview/lists/action/addresult';</script>";
	
	# There was an error loading the details
	if(!empty($msg)) 
	{
		$tableHTML .= format_notice($this, $msg);
	} 
	# Show the form
	else
	{
	
		$tableHTML .= $jquery.$javascript."<link rel='stylesheet' href='".base_url()."assets/css/jquery-ui.css' type='text/css' media='screen' />
		<script src='".base_url()."assets/js/jquery-ui.js' type='text/javascript'></script>
		<script src='".base_url()."assets/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>
		<script src='".base_url()."assets/js/tmis.fileform.js' type='text/javascript'></script>
		
		<form id='setresult_".$id."' method='post' action='".base_url()."interview/set_result/id/".$id."'  class='simplevalidator'>
		<table border='0' cellspacing='0' cellpadding='10'>
			
			<tr><td class='label'>Job:</td><td class='value'>".$this->native_session->get('job')."</td></tr>
			<tr><td class='label'>Applicant:</td><td class='value'>".$this->native_session->get('applicant')."</td></tr>
			<tr><td class='label'>Interviewer:</td><td class='value'>".$this->native_session->get('interviewer')."</td></tr>
			<tr><td class='label'>Planned Interview Date:</td><td class='value'>".date('d-M-Y h:ia T', strtotime($this->native_session->get('interview_date')))."</td></tr>
			
			<tr><td class='label top'>Result:</td><td><div class='nextdiv'><input type='text' id='result__interviewresults' name='result__interviewresults' onchange=\"showHideOnFieldValueCondition('', 'shortlistdiv', 'result__interviewresults', 'Passed')\" title='Select Result' placeholder='Select Result' class='textfield selectfield' value='' style='width:220px;'/></div>
			
			<div id='shortlistdiv' class='nextdiv' style='display:none;'><input type='text' id='shortlist__shortlists' name='shortlist__shortlists' title='Enter or Select Shortlist' data-val='jobid' placeholder='Enter or Select Shortlist' class='textfield selectfield editable optional' value='' style='width:220px;' /><input type='hidden' id='shortlistid' name='shortlistid' value='' /><input type='hidden' id='jobid' name='jobid' value='".$this->native_session->get('job_id')."' /></div></td></tr>
			
			<tr><td class='label top'>Actual Interview Date:</td><td><input type='text' id='interviewdate' name='interviewdate' title='Interview Date' class='textfield datefield showtime' value=''/></td></tr>
			
			<tr><td class='label top'>Duration:</td><td><input type='text' id='duration' name='duration' title='Duration in Minutes' class='textfield numbersonly' placeholder='Minutes' value=''/></td></tr>
			
			<tr><td class='label top'>Notes:</td><td><textarea id='notes' name='notes' title='Interview Notes' class='textfield optional' placeholder='Enter notes related to this result (Optional).' style='min-width:300px; min-height: 200px;'></textarea></td></tr>
			
			<tr><td>&nbsp;</td><td><button type='submit' name='submit' id='submit' value='submit' class='btn'>SUBMIT</button></td></tr>
		</table></form>
		<input type='hidden' id='layerid' name='layerid' value='' />";
	}
}




else if(!empty($area) && $area == "view_shortlist")
{
	if(!empty($msg))
	{
		$tableHTML .= format_notice($this, $msg);
	}
	else
	{
		$tableHTML .= "<link rel='stylesheet' href='".base_url()."assets/css/tmis.list.css' type='text/css' media='screen' />
		<span class='h1'>".$shortlist_name."</span>
		<table border='0' cellspacing='0' cellpadding='0' class='listtable'>
		<tr class='header'><td nowrap>Applicant</td><td>Date Added</td><td>Added By</td></tr>";
		foreach($list AS $row)
		{
			$tableHTML .= "<tr class='listrow'><td style='vertical-align:top;'>".$row['applicant']."</td><td style='vertical-align:top;'>".date('d-M-Y h:ia T', strtotime($row['date_added']))."</td><td>".$row['added_by']."</td></tr>";
		}
		$tableHTML .= "</table>";
	}
}









echo $tableHTML;
?>