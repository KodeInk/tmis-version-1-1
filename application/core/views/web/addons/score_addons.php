<?php 
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>".get_AJAX_constructor(TRUE); 
$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

if(!empty($area) && $area == "store_score_actions")
{
	$tableHTML .= "<table border='0' cellpadding='0' cellspacing='0'>
  <tr>
  	<td nowrap>is: <b style='font-size:17px;'>".(!empty($scoreDetails['total_score'])? $scoreDetails['total_score']: "NONE")."</b></td>
	
    <td nowrap style='padding-left:15px;padding-right:4px;'>
		<a href='javascript:void(0);'  onClick=\"updateFieldLayer('".base_url()."web/score/show_score_origins/v/".encrypt_value('top')."/l/".encrypt_value('1')."/u/".encrypt_value($userId)."/t/".encrypt_value('store_score')."/s/".encrypt_value($storeId)."','','','store_level_1_details','')\">Show generation details</a>
	</td>
    
	<td>
		<a href='javascript:void(0);'  onClick=\"updateFieldLayer('".base_url()."web/score/show_score_origins/v/".encrypt_value('top')."/l/".encrypt_value('1')."/u/".encrypt_value($userId)."/t/".encrypt_value('store_score')."/s/".encrypt_value($storeId)."','','','store_level_1_details','')\"><img src='".base_url()."assets/images/search_icon.png' border='0'></a>
	</td>
    
	<td nowrap style='padding-left:40px;'>
		<a href='javascript:void(0);' onClick=\"updateFieldLayer('".base_url()."web/score/show_score_origins/v/".encrypt_value('top')."/l/".encrypt_value('0')."/u/".encrypt_value($userId)."/t/".encrypt_value('store_score')."/s/".encrypt_value($storeId)."','','','store_level_0_details','')\">RE-CALCULATE</a>
	</td>
    
	<td>
		<div id='store_level_0_details'></div>
	</td>
  </tr>
</table>";
}



else if(!empty($area) && $area == "score_explanation")
{
	$tableHTML .= $javascript."<div style='border: 1px solid #CCCCCC;padding:5px; min-height:400px; max-height:400px; overflow:auto;'><table width='100%' border='0' cellpadding='0' cellspacing='0'>
  <tr>
  	<td valign='top' class='greycategoryheader'>";
	
	if($scoreType == 'in_store_spending')
	{
		$tableHTML .= "Measures how much you spent at this store compared to other Clout users.
<br><br>
<b>130</b> points out of <b>200</b> 
<br><br>
<b>542</b> users have more points at this store.<br><br>
Linking another account usually rasies your score.  <a href='javascript:;'>Add Card</a>";
	}
	else if($scoreType == 'overall_spending')
	{
		$tableHTML .= "Measures how much you have spent in Clout related transactions compared to other users.
<br><br>
<b>80</b> points out of <b>100</b> 
<br><br>
<b>198,750</b> users have more points than you in this section.<br><br>
Linking another account usually rasies your score.  <a href='javascript:;'>Add Card</a>";
	}
	else if($scoreType == 'reviews_preferences')
	{
		$tableHTML .= "Compares the number of reviews, feedback or personal preferences you have provided about this store.
<br><br>
<b>130</b> points out of <b>200</b> 
<br><br>
<b>1,780</b> users have more points than you in this section.<br><br>
Answering a survey usually raises your score.  <a href='javascript:;' onclick=\"updateFieldLayer('".base_url()."web/survey/show_store_survey/u/".encrypt_value('USER_ID_HERE')."/s/".encrypt_value('SURVEY_ID_HERE_IF_NECESSARY')."', '', '', 'deal_home_content', '')\">Answer a Survey</a>";
	}

	$tableHTML .= "</td>
	</tr>
	<tr><td class='greycategoryheader' style='text-align:right;padding-top:20px;'><a href='javascript:;'  onClick=\"toggleLayer('".$scoreType."_details', '".base_url()."web/score/score_explanation/u/".encrypt_value('USER_ID_HERE')."/t/".encrypt_value($scoreType)."', '<img src=\'".base_url()."assets/images/up_arrow_single_light_grey.png\'>', '<img src=\'".base_url()."assets/images/next_arrow_single_light_grey.png\'>', '".$scoreType."_arrow_cell', '', '', '');toggleLayersOnCondition('".$scoreType."_details', '".implode('<>', $typeTitles)."');\">Close</a></td></tr> 
	</table></div>";
	
}






echo $tableHTML;
?>