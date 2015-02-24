<?php 

if(!empty($area) && $area == 'download_csv')
{
	send_download_headers("file_".strtotime('now').".csv");
	echo array2csv($list);
	die();
}

else if(!empty($area) && $area == 'download_shortlist_csv')
{
	$htmldata = array(
		array('Shortlist:'=>'School:', $shortlist_name=>$vacancy_details['institution_name']),
		array('Shortlist:'=>'Vacancy:', $shortlist_name=>$vacancy_details['topic']),
		array('Shortlist:'=>'Role:', $shortlist_name=>$vacancy_details['role_name']),
		array('Shortlist:'=>'Summary:', $shortlist_name=>$vacancy_details['summary']),
		array('Shortlist:'=>'', $shortlist_name=>''),
		array('APPLICANT','DATE ADDED','ADDED BY')
	);
	
	foreach($list AS $row)
	{
		array_push($htmldata, array($row['applicant'], date('d-M-Y h:ia T', strtotime($row['date_added'])), $row['added_by'])); 
	}
	
	send_download_headers("file_".strtotime('now').".csv");
	echo array2csv($htmldata);
	die();
}

?>