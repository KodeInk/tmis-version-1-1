<?php
$systemColors = unserialize(SYSTEM_COLORS);
?><table border="0" cellspacing="0" cellpadding="0" width="100%" class="networklisttable">
        <tr><td class="label" style="border-right: solid 0px #E2E2E2;height:30px;">Your current commission is <span style="font-weight:700;color:#333;"><?php echo format_number($currentCommission,2);?>%</span></td>
       </table>
<table border="0" cellspacing="0" cellpadding="5" class="sectiontable bluetop" width="100%" style="border-left:0px;border-right:0px;border-bottom:0px;">
        
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="sectiontable">
  <tr>
    <td class="subsectiontitle" style="text-align:left; background-color:#FFF;">Clout Score</td>
  </tr>
  <tr>
    <td class="mediumrobototext" style="background-color:<?php echo (!empty($cloutScoreLevel))? $systemColors['level_'.$cloutScoreLevel]: $systemColors['level_0'];?>"><?php echo $cloutScore;?></td>
  </tr>
</table>
</td>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="3" class="sectiontable">
                <tr>
                  <td class="subsectiontitle" style="text-align:left; background-color:#FFF;">Commission</td>
                </tr>
                <tr>
                  <td class="mediumrobototext" style="background-color:<?php echo (!empty($cloutScoreLevel))? $systemColors['level_'.$cloutScoreLevel]: $systemColors['level_0'];?>"><?php echo format_number($currentCommission,2);?>%</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        
        <tr>
          <td class="sectionsubtitle">Your <span style="font-weight:bold;"><?php echo $cloutScore;?></span> Clout Score determines the cash back you collect from people in your network.</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td style="padding-left:0px;padding-top:0px;" valign="top"><table border="0" cellspacing="0" cellpadding="5">
              <?php
			  #The score level data
			  foreach($scoreLevelData AS $scoreRow)
			  {
				  $levelColor = $systemColors['level_'.$scoreRow['level']];
				  $color = (!empty($scoreRow['low_end_score']) && $scoreRow['low_end_score'] <= $cloutScore)? $levelColor: $systemColors['level_0'];
				  $boxFontColor = (!empty($scoreRow['low_end_score']) && $scoreRow['low_end_score'] <= $cloutScore)? '#FFF': '#646464';
				  
				  echo "<tr>
				  <td style='padding-bottom:10px;'><div style='border-bottom: solid 8px ".$levelColor."; padding-bottom:3px;font-size: 18px;
    color:".$levelColor.";'>".$scoreRow['low_end_score'].(empty($scoreRow['high_end_score'])? '+':'')."</div></td>
				  <td style='padding-bottom:8px;'><div class='mediumrobototext' style='width:150px;background-color:".$color.";color:".$boxFontColor.";'>".$scoreRow['commission']."%</div></td>
				  </tr>";
			  }
			  ?>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="blacksectionheader" style="font-size:16px;">Ways to raise your score..</td>
              </tr>
            <tr>
              <td>  
              <?php
			  #The categorized score details
			  
			  #Specify the categories as expected
			  $categories = array();
			  $categories['clout_score_profile_setup'] = array('id'=>'profile_setup', 'title'=>'Account Setup', 'image'=>'account_setup_icon.png', 'color'=>'#000');
			  $categories['clout_score_activity'] = array('id'=>'activity', 'title'=>'Activity', 'image'=>'user_activity_icon.png', 'color'=>'#8566AB');
			  $categories['clout_score_overall_spending'] = array('id'=>'overall_spending', 'title'=>'Overall Spending', 'image'=>'overall_spending_icon.png', 'color'=>'#6D76B5');
			  $categories['clout_score_ad_related_spending'] = array('id'=>'ad_related_spending', 'title'=>'Ad Related Spending', 'image'=>'ad_related_spending_icon.png', 'color'=>'#2DA0D1');
			  $categories['clout_score_linked_accounts'] = array('id'=>'linked_accounts', 'title'=>'Linked Accounts', 'image'=>'linked_accounts_icon.png', 'color'=>'#03BFCD');
			  $categories['clout_score_network_size_growth'] = array('id'=>'network_size_growth', 'title'=>'Network Size/Growth', 'image'=>'network_icon.png', 'color'=>'#0AC298');
			  $categories['clout_score_network_spending'] = array('id'=>'network_spending', 'title'=>'Network Spending', 'image'=>'network_spending_icon.png', 'color'=>'#18C93E');
			  
			  #Get the category ids
			  $ids = array();
			  foreach($categories AS $row)
			  {
				  array_push($ids, $row['id']);
			  }
			  #Get the biggest score in the system
			  $maxScore = 0;
			  foreach($cloutScoreBreakdown AS $breakdownRow)
			  {
				  $maxScore = (!empty($breakdownRow['total_score']) && $breakdownRow['total_score'] > $maxScore)? $breakdownRow['total_score']: $maxScore;
			  }
			  
			  #Now format and display the categories as desired
			  foreach($categories AS $key=>$rowDetails)
			  {
				  $breakdownRow = $cloutScoreBreakdown[$key];
				  $containerWidth = format_number(((100*$breakdownRow['total_score'])/$maxScore), 3);
				  $filledWidth = format_number(((100*$breakdownRow['total_score'])/$breakdownRow['max_total_score']), 3);
				  $unfilledWidth = 100 - $filledWidth;
				  
				  echo "<div id='".$rowDetails['id']."' style='background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;' ><table border='0' cellspacing='5' cellpadding='0' style='cursor:pointer;' onClick=\"toggleLayer('".$rowDetails['id']."_details', '', '<img src=\'".base_url()."assets/images/up_arrow_single_light_grey.png\'>', '<img src=\'".base_url()."assets/images/next_arrow_single_light_grey.png\'>', '".$rowDetails['id']."_arrow_cell', '', '', '');toggleLayersOnCondition('".$rowDetails['id']."_details', '".implode('<>', array_diff($ids, array($rowDetails['id'])))."');\">
                <tr>
                  <td rowspan='2' style='width:40px;'><img src='".base_url()."assets/images/".$rowDetails['image']."'></td>
                  <td class='greycategoryheader' style='width:315px;'>".$rowDetails['title']."</td>
                  <td rowspan='2' style='text-align:center; vertical-align:middle; width:25px;' id='".$rowDetails['id']."_arrow_cell'><img src='".base_url()."assets/images/next_arrow_single_light_grey.png'></td>
                  </tr>
                <tr>
                  <td><table width='".$containerWidth."%' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='99%'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                          <td width='".$filledWidth."%' style='background-color: ".$rowDetails['color'].";text-align:right;padding-right:5px;'><span style=\"color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;\">".format_number($breakdownRow['total_score'],4,0)."</span></td>
                          <td width='".$unfilledWidth."%' style='background-color: #C1C1C1;'>&nbsp;</td>
                        </tr>
                      </table></td>
                      <td width='1%' style=\"padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;\">".$breakdownRow['max_total_score']."</td>
                    </tr>
                  </table></td>
                  </tr>
                </table>
                
                
                <div id='".$rowDetails['id']."_details' style='display:none;'>
				".$breakdownRow['description']."
				Measures how much you spent at this store compared to other Clout users.
<br><br>
<span class='label'>".format_number($breakdownRow['total_score'],4,0)." points out of ".format_number($breakdownRow['max_total_score'],4,0)."</span> 
<br><br>
<span style='font-weight:bold;'>The Breakdown:</span>
<table width='100%' border='0' cellspacing='0' cellpadding='5' style='border: 1px solid #EEE;'>";
$counter = 0;
foreach($breakdownRow['codes'] AS $code)
{
	echo "<tr style='".get_row_color($counter, 2)."'><td><b>".$keyDescription[$code]['description']."</b></td><td valign='top'>".format_number($breakdownRow['code_scores'][$code],4,0)."</td></tr>";
	$counter++;
}
				echo "
				</table>
				</div>
  </div>";
			  }
			  ?>
              

   
   
   
   
   
   
                
  </td>
              </tr>
            </table></td>
            </tr>
          </table></td>
        </tr>
</table>
