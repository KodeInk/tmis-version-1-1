<?php 
$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

if(!empty($area) && $area == 'cron_run_result')
{
	if(!empty($msg))
	{
		$tableHTML = $msg;
	}

}
else
{
	$tableHTML .= format_notice("ERROR: Result could not be displayed.");
}

echo $tableHTML;

?>