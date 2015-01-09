<?php 
$jquery = "<script src='".base_url()."assets/js/jquery.min.js' type='text/javascript'></script>";
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/tmis.js'></script>".get_AJAX_constructor(TRUE); 

$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/tmis.css' type='text/css' media='screen' />"; 

if(!empty($area) && $area == "show_bigger_image")
{
	$tableHTML .= "<table width='530' height='398' border='0' cellspacing='0' cellpadding='0'><tr><td><img src='".$url."' border='0' /></td></tr></table>"; 
}



else if(!empty($area) && $area == "basic_msg" && !empty($msg)) 
{
	$tableHTML .= format_notice($msg);
}












echo $tableHTML;
?>