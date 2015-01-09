<?php 
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>".get_AJAX_constructor(TRUE); 
$jquery = "<script src='".base_url()."assets/js/jquery.min.js' type='text/javascript'></script>";
$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 


#Show the result of a connection
if($area == 'connection_result')
{
	$tableHTML .= $javascript.$jquery.$response['clout_msg'];
}



#Show success steps
else if($area == 'show_success_steps')
{
	
	$tableHTML .= $javascript.$jquery."<table width='100%' border='0' cellpadding='5'  cellspacing='0'>
					<tr><td class='sectionheader' style='text-align:center;'> Account Added! </td></tr>";
	
	#Display the accounts successfully added for the selected user
	if(!empty($currentBanks))
	{				
		$tableHTML .= "<tr><td><div style='max-height:250px;overflow-y:auto;overflow-x:hidden;'>";
		
		foreach($currentBanks AS $row)
		{
			$tableHTML .= "<table width='100%' border='0' cellpadding='5'  cellspacing='0' class='listtable'>
				<tr>
				<td width='1%'><img src='".base_url()."assets/images/tick.png'></td>
				<td width='99%'><span style='font-weight: 800;'>".html_entity_decode($row['issue_bank_name'])."</span></td>
				</tr>
				</table>";
		}
		$tableHTML .= "</div></td></tr>";
	}
	
	$tableHTML .= "<tr><td class='closefancybox' style='text-align:center;padding-top:15px;'><input type='button' name='addanother' id='addanother' class='greenbtn' style='width:368px;' value='Add Another'></td></tr>
				   <tr><td style='text-align:center;padding-top:10px;'><a href='".base_url()."web/account/normal_dashboard' class='bluelink'>Finish</a></td></tr>
				</table>";
	
}

echo $tableHTML;

?>