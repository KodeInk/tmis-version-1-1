<?php 
$jquery = "<script src='".base_url()."assets/js/jquery.min.js' type='text/javascript'></script>";
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>".get_AJAX_constructor(TRUE); 

$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

if(!empty($area) && $area == "add_new_url_id") 
{
	$tableHTML .= !empty($msg)?format_notice($msg):'';
	
	if(!empty($canSave))
	{
		$tableHTML .= ($canSave=='YES')? "<input type='button' name='savenewurl' id='savenewurl' style='width:100px;' onclick=\"updateFieldLayer('".base_url()."web/network/save_new_url_id','newurlid','','new_url_action','Please enter a valid referral ID')\" class='greenbtn' value='Save'>": format_notice('WARNING: ID is taken');
	}
	
}


#Show the current referral links
else if(!empty($area) && $area == "current_referral_links")
{
	foreach($referralUrls AS $urlId)
	{
		$url = base_url().'u/'.$urlId['url_id'];
		$tableHTML .= "<div style='padding:4px;'><a href='javascript:;' onclick=\"updateFieldValue('referralurl_field', '".$url."');hideLayerSet('user_ref_urls');clickItem('referralurl')\" class='bluebold'><img src='".base_url()."assets/images/add_icon.png' width='10'> ".$url."</a></div>";
	}
	#Show if the number of referral links has not been exceeded.
	if(empty($referralUrls) || (count($referralUrls) < 2 || count($referralUrls) < MAX_REFERRAL_LINKS))
	{
		$tableHTML .= "<div class='smallboldarial' style='margin:10px 5px 0px 5px;'>You can now <a href='javascript:;' onclick=\"hideLayerSet('user_ref_urls');showLayerSet('add_new_urlid');\">add up to ".MAX_REFERRAL_LINKS."</a> referral links!</div>";
	}
}


echo $tableHTML;
?>