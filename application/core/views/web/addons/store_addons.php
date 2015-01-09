<?php 
$systemJavascript = "<script src='".base_url()."assets/js/jquery.min.js' type='text/javascript'></script>
<script src='".base_url()."assets/js/clout.js' type='text/javascript'></script>";

$systemCss = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

$tableHTML = $systemCss;

if(!empty($area) && $area == "offer_explanation")
{
	$tableHTML .= "<div style='border: 1px solid #CCCCCC;padding:5px; overflow:auto;'>
	<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr>
  	<td valign='top' class='smallarial'><span class='greycategoryheader'>".$offerDetails['description']."</span>";
	
	if(!empty($offerDetails['extra_conditions']))
	{
		$tableHTML .= "<ul style='padding-left: 15px;'>";
		foreach($offerDetails['extra_conditions'] AS $condition)
		{
			$tableHTML .= "<li style='list-style-type: square;'>".$condition."</li>";
		}
		$tableHTML .= "</ul>";
	}
	
	$tableHTML .= "</td>
	</tr>
	<tr><td>";
	
	
	#-----------------------------------------------------------------------------
	# Scheduling form
	#-----------------------------------------------------------------------------
	if(!empty($offerDetails['requires_scheduling']) && $offerDetails['requires_scheduling'])
	{
		$randomNo = strtotime('now');
		$tableHTML .= "<div id='perk_scheduler_".$randomNo."'>
		<form id='scheduler_".$randomNo."' method='post' action='".base_url()."web/store/send_schedule_request/t/".encrypt_value($offerId)."/u/".encrypt_value($userId)."' onSubmit=\"return submitLayerForm('scheduler_".$randomNo."')\">
		<table width='100%' border='0' cellpadding='5' cellspacing='0'>
		<tr>
  	<td class='greycategoryheader'>Name:</td>
	<td class='greycategoryheader'><b>".$this->native_session->get('first_name')." ".$this->native_session->get('last_name')."</b></td>
	<td class='greycategoryheader' style='text-align:right;'>Email:</td>
	<td valign='top' width='1%'><input name='useremail' type='text' class='textfield' id='useremail' placeholder='Email' style='width:200px;' maxlength='100' value='".$this->native_session->get('email_address')."'></td>
	</tr>
	
	<tr>
  	<td class='greycategoryheader'>Phone:</td>
	<td valign='top' colspan='3'><table width='100%' border='0' cellpadding='0' cellspacing='0'><tr>
	<td><input name='userphone' type='text' class='textfield' id='userphone' placeholder='Phone Number' style='width:275px;' onKeyUp='formatPhoneValue(this, event)' maxlength='10' value='".($this->native_session->get('mobile_phone')? $this->native_session->get('mobile_phone'): "")."'></td>
	
	<td width='1%'><select name='phonetype' id='phonetype' class='selecttextfield' style='width:100px;'>
	<option value='mobile' selected>Mobile</option>
	<option value='home'>Home</option>
	<option value='office'>Office</option>
	</select></td>
	</tr></table>
	</td>
	</tr>
	
	
	<tr>
  	<td class='greycategoryheader'>Date:</td>
	<td colspan='3'>
	<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr>
	<td width='1%'><input name='reservationdate' type='text' class='textfield' id='reservationdate' placeholder='MM / DD / YYYY' style='width:150px;' onKeyUp='formatDateValue(this, event)' maxlength='10' value=''></td>
	<td width='1%' style='padding-left:15px;'><select class='selecttextfield' name='reservationtime' id='reservationtime' style='margin-top:0px;width:110px;'>";
    for($i=0; $i<24; $i++)
	{
		$tableHTML .= "<option value='".str_pad($i, 2, '0', STR_PAD_LEFT)."00' ";
		if($i == (date('G')+1)) $tableHTML .= " selected";
		$tableHTML .= ">".date('h:ia', strtotime(str_pad($i, 2, '0', STR_PAD_LEFT).'00'))."</option>";
	}
	
    $tableHTML .= "</select></td>
	
	<td class='greycategoryheader' style='text-align:right; padding-right:10px;'>Number in Party:</td>
	<td valign='top' width='1%'><input name='noinparty' type='text' class='textfield' id='noinparty' placeholder='1' style='width:20px;' maxlength='2' value='1' onKeyUp='formatPhoneValue(this, event)'>
	</td></tr>
	</table>
	</td>
	</tr>
	
	
	<tr>
  	<td colspan='4' class='greycategoryheader'>Special Requests:</td>
	</tr>
	
	<tr>
  	<td valign='top' colspan='4'>
	<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr>
	<td>
	<textarea class='textfield' name='specialrequests' id='specialrequests' style='width:385px;'></textarea></td>
	<td valign='top' class='greycategoryheader' style='padding-left:10px;text-align:right;'><input type='submit' name='submit_perk' id='submit_perk' class='greenbtn' style='width:100px;' value='Submit'>
	</td>
	</tr></table>
</td>
	</tr></table>
	<input type='hidden' name='scheduler_".$randomNo."_required' id='scheduler_".$randomNo."_required' value='useremail<>userphone<>reservationdate'>
	<input type='hidden' name='scheduler_".$randomNo."_required_msg' id='scheduler_".$randomNo."_required_msg' value='A phone number and schedule date are required to continue.'>
	<input type='hidden' name='scheduler_".$randomNo."_displaylayer' id='scheduler_".$randomNo."_displaylayer' value='perk_scheduler_".$randomNo."'></form>
	</div>";
		
		
		
		
		
		
		
		
		
		
		
		
	}
	else
	{
		$timeStamp = strtotime('now');
		$tableHTML .= "<div id='checkin_".$offerId."_".$timeStamp."' style='padding-top:15px;'><input type='button' name='checkin' id='checkin' class='greenbtn' value='Checkin' style='width:300px;' onClick=\"updateFieldLayer('".base_url()."web/store/checkin_user/f/".encrypt_value($offerId)."/u/".encrypt_value($this->native_session->get('userId'))."','','','checkin_".$offerId."_".$timeStamp."','')\"></div>";
	}
			
	$tableHTML .= "</td></tr>
	<tr><td style='padding-top:0px;'>
	
	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
	<tr>
	<td class='greycategoryheader' width='1%' style='text-align:right;'><a href='javascript:;'  onClick=\"toggleLayer('offer_".$offerId."_details', '".base_url()."web/store/offer_explanation/u/".encrypt_value($userId)."/t/".encrypt_value($offerId)."', '<img src=\'".base_url()."assets/images/up_arrow_single_light_grey.png\'>', '".($offerDetails['promotion_type'] == 'perk'? "<input type=\'button\' name=\'use_offer_".$offerDetails['id']."\' id=\'use_offer_".$offerDetails['id']."\' class=\'greenbtn\' style=\'width:60px;\' value=\'Use\'>": "<img src=\'".base_url()."assets/images/next_arrow_single_light_grey.png\'>")."', 'offer_".$offerId."_arrow_cell', '', '', '');toggleLayersOnCondition('offer_".$offerId."_details', '".implode('<>', remove_item('offer_'.$offerDetails['id'], $this->native_session->get('all_divs')))."');\">Close</a></td></tr>
	</table>
	</td></tr>
	</table>";
	
	$tableHTML .= "</div>";
	
}








else if(!empty($area) && $area == "offer_list")
{
	if(!empty($offers))
	{
		$tableHTML .= " <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <tr>".
              (!empty($isCurrentLevel)? "<td class='blacksectionheader' style='font-size:16px;'>Get cash back when you pay using any linked card..</td>": ($currentLevel < $viewedLevel? format_notice("WARNING: You need ".$remainingPoints." more points to use these offers."): format_notice("You qualify for offers at this level.")))
              ."</tr>
             <tr>
             <td>";
       
		$offerDivArray = array();
		if(!empty($offers['cash_back']))
		{
			foreach($offers['cash_back'] AS $row)
			{
				array_push($offerDivArray,'offer_'.$row['id']);
			}
		}
		
		if(!empty($offers['perks']))
		{
			foreach($offers['perks'] AS $row)
			{
				array_push($offerDivArray,'offer_'.$row['id']);
			}
		}
		$this->native_session->set('all_divs', $offerDivArray);
		 
		#Do if there are any cashback offers
		if(!empty($offers['cash_back']))
		{
			 foreach($offers['cash_back'] AS $offer)
			 {
				 $tableHTML .= "<div id='offer_".$offer['id']."' style='background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;'><table border='0' cellspacing='5' cellpadding='0' ";
				 
				 $tableHTML .= !($currentLevel < $viewedLevel)? "style='cursor:pointer;' onClick=\"toggleLayer('offer_".$offer['id']."_details', '".base_url()."web/store/offer_explanation/u/".encrypt_value($this->native_session->get('userId'))."/t/".encrypt_value($offer['id'])."', '<img src=\'".base_url()."assets/images/up_arrow_single_light_grey.png\'>', '<img src=\'".base_url()."assets/images/next_arrow_single_light_grey.png\'>', 'offer_".$offer['id']."_arrow_cell', '', '', '');toggleLayersOnCondition('offer_".$offer['id']."_details', '".implode('<>', remove_item('offer_'.$offer['id'], $this->native_session->get('all_divs')))."');\"": "";
				 
				 $tableHTML .= ">
    <tr>
      <td rowspan='2' style='width:80px;'><table border='0' cellspacing='0' cellpadding='2' class='rewardcardbig'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>".$offer['promotion_amount']."%</td>
  </tr>
</table></td>
      <td class='greycategoryheader' style='width:500px;'>Cash Back</td>
      <td rowspan='2' style='text-align:center; vertical-align:middle; width:25px;' id='offer_".$offer['id']."_arrow_cell'>";
	  $tableHTML .= !($currentLevel < $viewedLevel)? "<img src='".base_url()."assets/images/next_arrow_single_light_grey.png'>": "";
	  
	  $tableHTML .= "</td>
      </tr>
    <tr>
      <td class='smallarial'>".$offer['description']."</td>
      </tr>
    </table>
    
    <div id='offer_".$offer['id']."_details' style='display:none;'></div>
  </div>";
			 }
		}
		
		
		#Do if there are any cashback offers
		if(!empty($offers['perks']))
		{
			 foreach($offers['perks'] AS $offer)
			 {
				 $tableHTML .= "<div id='offer_".$offer['id']."' style='background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;'><table border='0' cellspacing='5' cellpadding='0' ";
				 
				 $tableHTML .= !($currentLevel < $viewedLevel)? "style='cursor:pointer;' onClick=\"toggleLayer('offer_".$offer['id']."_details', '".base_url()."web/store/offer_explanation/u/".encrypt_value($this->native_session->get('userId'))."/t/".encrypt_value($offer['id'])."', '<img src=\'".base_url()."assets/images/up_arrow_single_light_grey.png\'>', '<input type=\'button\' name=\'use_offer_".$offer['id']."\' id=\'use_offer_".$offer['id']."\' class=\'greenbtn\' style=\'width:60px;\' value=\'Use\'>', 'offer_".$offer['id']."_arrow_cell', '', '', '');toggleLayersOnCondition('offer_".$offer['id']."_details', '".implode('<>', remove_item('offer_'.$offer['id'], $this->native_session->get('all_divs')))."');\"": "";
				 
				 $tableHTML .= ">
    <tr>
      <td rowspan='2' style='width:80px;'><table border='0' cellspacing='0' cellpadding='2' class='perkcardbig'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>Perk</td>
  </tr>
</table></td>
      <td class='greycategoryheader' style='width:500px;'>".$offer['name']."</td>
      <td rowspan='2' style='width:25px;' id='offer_".$offer['id']."_arrow_cell'>";
	  $tableHTML .= !($currentLevel < $viewedLevel)? "<input type='button' name='use_offer_".$offer['id']."' id='use_offer_".$offer['id']."' class='greenbtn' style='width:60px;' value='Use'>": "";
	  
	  $tableHTML .= "</td>
      </tr>
    <tr>
      <td class='smallarial'>".$offer['description']."</td>

      </tr>
    </table>
    
    <div id='offer_".$offer['id']."_details' style='display:none;'></div>
  </div>";
			 }
		}
		

             $tableHTML .= "</td>
             </tr>
        </table>";
	}
	else
	{
		$tableHTML .= format_notice("WARNING: No offers could be resolved for this level.");
	}
	
}






else if(!empty($area) && $area == "checkin_result")
{
	$tableHTML .= (!empty($result) && $result)? format_notice("Checkin Confirmed"): format_notice("ERROR: Checkin Not Confirmed");
}


else if(!empty($area) && $area == "scheduler_result")
{
	$tableHTML .= (!empty($result) && $result)? format_notice("Schedule Sent"): format_notice("ERROR: Schedule Not Sent");
}


else if(!empty($area) && $area == "suggest_store")
{
	$tableHTML .= $systemJavascript;
	if(!empty($result))
	{
		$tableHTML .= $result? format_notice("Suggestion Sent"): format_notice("ERROR: Suggestion Not Sent");
		$tableHTML .= "<BR><input type='button' name='close_suggestion_window' id='close_suggestion_window' class='greenbtn closefancybox' style='width:250px;' value='Close Window' >";
	}
	else 
	{
		$tableHTML .= "<form id='store_suggestions' method='post' action='".base_url()."web/store/suggest_store_by_public".($this->native_session->get('userId')? "/u/".encrypt_value($this->native_session->get('userId')): '')."' onsubmit=\"return submitLayerForm('store_suggestions');\">
						<table border='0' cellspacing='0' cellpadding='0' style='padding:50px;' width='100%'>
							<tr>
							<td colspan='2'>
							<div id='suggest_business_form'><table>
							<tr><td class='subsectiontitle' colspan='2' style='text-align:left;padding-top:0px;padding-left:3px;'>Suggest a Store</td></tr>
							<tr><td><table border='0' cellspacing='0' cellpadding='5'>
							<tr><td style='padding-bottom:5px;'><input type='text' class='textfield' id='newstorename' name='newstorename' value='' placeholder='Store Name' style='width:250px;'></td></tr>
							<tr><td style='padding-bottom:5px;'><input type='text' class='textfield' id='contactname' name='contactname' value='' placeholder='Store Contact Name (Optional)' style='width:250px;'></td></tr>
							<tr><td style='padding-bottom:5px;'><input type='text' class='textfield' id='contactphone' name='contactphone' value='' placeholder='Store Contact phone' style='width:250px;'></td></tr>
							<tr><td style='padding-bottom:5px;'><input type='text' class='textfield' id='website' name='website' value='' placeholder='Store Website (Optional)' style='width:250px;'></td></tr>
							
							</table></td>
							
							<td valign='top'>
							<table border='0' cellspacing='0' cellpadding='5'>
							<tr><td><input type='text' class='textfield' id='address' name='address' value=''  placeholder='Address' style='width:250px;'></td></tr>
							<tr><td>
							<table border='0' cellspacing='0' cellpadding='0'><tr><td><input type='text' id='zipcode' name='zipcode' placeholder='Zip Code' class='textfield' style='width:90px' value=''></td>
                    
                    		<td style='padding-left:12px;'><div class='searchselect'><input type='text' id='state' name='state' data-rel='state_name' placeholder='State' class='nosearch noenter' style='width:130px' value=''><input name='state__searchby' id='state__searchby' type='hidden' value='state_code__state_name'><input name='statecode' id='statecode' type='hidden' value=''></div>
							</td></tr></table>
                            </td></tr>
							<tr><td><div class='searchselect'><input type='text' id='city' name='city' placeholder='City' class='plainfield' data-rel='city_name' style='width:245px' value=''><input name='city__searchby' id='city__searchby' type='hidden' value='name'><input name='city__extrafields' id='city__extrafields' type='hidden' value='*countrycode'></div></td></tr>
							</table>
							</td>
							</tr>
							
							<tr>
							<td colspan='2' style='padding-top:30px; padding-bottom:30px;padding-left:3px;'><input type='submit' name='submit_suggestion' id='submit_suggestion' class='greenbtn' style='width:250px;' value='Send Suggestion' >
							<input name='countrycode' id='countrycode' type='hidden' value='USA'>
							<input type='hidden' name='store_suggestions_required' id='store_suggestions_required' value='newstorename<>contactphone<>address<>zipcode<>state<>city'>
	<input type='hidden' name='store_suggestions_required_msg' id='store_suggestions_required_msg' value='All fields are required except where indicated.'>
	<input type='hidden' name='store_suggestions_displaylayer' id='store_suggestions_displaylayer' value='suggest_business_results'>
	<input type='hidden' name='store_suggestions_hidelayer' id='store_suggestions_hidelayer' value='suggest_business_form'>
							</td>
							</tr>
							</table></div>
							</td>
							</tr>
							<tr>
							<td colspan='2'>
							<div id='suggest_business_results'></div>
							</td>
							</tr>
							</table>
						</form>";
	}
	
}










echo $tableHTML;
?>