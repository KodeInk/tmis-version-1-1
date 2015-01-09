<?php 
$jquery = "<script src='".base_url()."assets/js/jquery.min.js' type='text/javascript'></script>";
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>".get_AJAX_constructor(TRUE); 

$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

if(!empty($area) && $area == "show_bigger_image")
{
	$tableHTML .= "<table width='530' height='398' border='0' cellspacing='0' cellpadding='0'><tr><td><img src='".$url."' border='0' /></td></tr></table>"; 
}



else if(!empty($area) && $area == "basic_msg" && !empty($msg)) 
{
	$tableHTML .= format_notice($msg);
}



else if(!empty($area) && $area == "imap_import_details") 
{
	$tableHTML .= !empty($msg)?format_notice($msg):'';
	
	if(!empty($getEmail) && $getEmail)
	{
		$tableHTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
  <tr>
    <td style='text-align:left;'><input name='youremail' type='text' class='textfield' id='youremail' value='' placeholder='Enter your own email address' style='font-size: 18px;width:380px;'></td>
    <td><input type='button' name='import_from_email' id='import_from_email' class='greenbtn' value='Start' style='width:110px;' onClick=\"updateFieldLayer('".base_url()."web/network/import_by_imap','youremail','','imap_email_field','Please enter a valid email')\"></td>
    </tr>
</table>";
	}
	else
	{
		$tableHTML .= $javascript."<form id='imapimport' action='".base_url()."web/network/import_by_imap'  method='post' onsubmit=\"return submitLayerForm('imapimport')\">"; 
		$tableHTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td width='99%'>
		<table width='100%' border='0' cellspacing='0' cellpadding='5'>
		<tr><td style='text-align:left;'><input name='yourpass' type='password' class='textfield' id='yourpass' value='' placeholder='Enter your email password' style='font-size: 18px;width:380px;'><input type='hidden' name='youremail' id='youremail' value='".$youremail."' /></td></tr>";
	
		if(!empty($getHost) && $getHost)
		{				
			$tableHTML .= "<tr><td style='text-align:left;' nowrap><input name='emailhost' type='text' class='textfield' id='emailhost' value='' placeholder='Enter email IMAP or POP server' style='font-size: 18px;width:290px;'> : <input name='hostport' type='text' class='textfield' id='hostport' value='' placeholder='Port' style='font-size: 18px;width:60px;'></td></tr>";
		}
	
	
		$tableHTML .= "</table></td>
		<td width='1%' valign='top' style='padding:5px;'><input type='submit' name='importbtn' id='importbtn' style='width:110px;' class='greenbtn' value='Import'><input type='hidden' name='imapimport_displaylayer' id='imapimport_displaylayer' value='imap_email_field'></td>
		</tr></table>
		</form>";
	}
	
}



else if(!empty($area) && $area == "import_from_file") 
{
	$tableHTML .= !empty($msg)?format_notice($msg):'';
	
	$tableHTML .= $javascript."<div id='csvform_div'>
  <form id='csvform' class='layerform' action='".base_url()."web/network/import_from_file' method='post' enctype='multipart/form-data' onsubmit=\"updateFieldValue('layerid', 'csvform');hideLayerSet('csvform_div')\"><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td align='left'><select name='csv_file_format' id='csv_file_format' class='selecttextfield' style='width:140px; padding: 10px 10px 10px 0px;'>
      <option value='' selected>File Format</option>
      <option value='csv_aol'>CSV - AOL Address Book</option>
      <option value='csv_generic'>CSV - Generic File</option>
      <option value='csv_gmail'>CSV - Gmail Address Book</option>
      <option value='csv_hotmail'>CSV - Hotmail Address Book</option>
      <option value='csv_outlook'>CSV - Outlook  Contacts</option>
      <option value='csv_thunderbird'>CSV - Thunderbird  Contacts</option>
      <option value='csv_yahoo'>CSV - Yahoo Address Book</option>
      <option value='text_commas'>Text File - Comma Delimited</option>
      <option value='text_tabs'>Text File - Tab Delimited</option>
      </select></td>
    <td><input name='csvuploadfile' type='file' class='textfield' id='csvuploadfile' value='' style='font-size: 14px;width:230px;'></td>
    <td align='right'><input type='submit' name='import_from_email' id='import_from_email' class='forrestgreenbtn' value='Import' style='width:110px;'><input type='hidden' name='csvform_displaylayer' id='csvform_displaylayer' value='file_email_field'></td>
  </tr>
</table></form>
	</div>
	<div  id='file_email_field'></div>
	<div class='progresscontainer' style='margin-top:10px;'>
        <div id='csvform_bar' class='progressbar'></div >
        <div id='csvform_percent' class='progresspercent'>0%</div >
    </div>";
}



#Copy from one field to another
else if(!empty($area) && $area == "copy_link_location")
{
	$tableHTML .= "<table border='0' cellspacing='0' cellpadding='5'>
  <tr>
    <td colspan='2' style='text-align:left;'>Just copy, paste, share and watch your network grow!</td>
  </tr>
  <tr>
    <td style='text-align:left;'><input name='box-content' type='text' class='textfield selectcloak' id='box-content' value='https://www.clout.com/u/mderrick' style='font-size: 18px;width:400px;'></td>
    <td><a href='javascript:;' id='copy' style='display:block;'><input type='button' name='copy' id='copy' class='bluebtn' value='Copy' style='width:90px;'></a></td>
  </tr>
  </table>";
}


else if(!empty($area) && $area == "temporary_category_list")
{
	$tableHTML .= "<div id='add_another_div' style='padding-bottom:10px;'><input id='addanothercategory' name='addanothercategory' type='button' class='bluebtn' style='width:230px;' onclick=\"showLayerSet('add_category_div');hideLayerSet('add_another_div')\" value='Add Another Category'></div><div class='tableborder' style='text-align:left;padding:5px 8px 5px 8px;'>";
	if(!empty($categories))
	{
		$tableHTML .= !empty($msg)? format_notice($msg): '';
		$categories = array_reverse($categories, TRUE);
		foreach($categories AS $id=>$row)
		{
			$tableHTML .= "<div id='".$id."' class='listdivs'>".$row['category']." (".$row['subcategory'].")<input type='hidden' id='categories_".$id."' name='categories[]' value='".$row['category']."<>".$row['subcategory']."<>".$row['subcategoryid']."'></div>";
		}
	}
	else
	{
		$tableHTML .= format_notice('WARNING: No categories selected.');
	}
	$tableHTML .= "</div>";
}




else if(!empty($area) && $area == "show_store_location_list")
{
	if(!empty($locationList))
	{
		$tableHTML .= "<div style='display:block;position:relative;' id='delete_all_div'><table style='cursor:pointer;' onClick=\"updateFieldLayer('".base_url()."web/account/remove_location_address/l/all','','','saved_locations','');showLayerSet('locationsfile_div');\"><tr><td style='padding:5px;'><img src='".base_url()."/assets/images/remove_icon.png'></td><td><a href='javascript:;' class='bluebold'>Delete All</a></td></tr></table></div>";
		
		$tableHTML .= "<div id='location_msg_div'>".(!empty($msg)?format_notice($msg):'')."</div>
			<table width='100%' border='0' cellspacing='0' cellpadding='5' class='listtable'> ";
		$locationList = array_reverse($locationList, TRUE);
		$counter = 0;
		foreach($locationList AS $id=>$row)
		{
			$tableHTML .= "<tr id='location_".$id."'>
			<td width='1%' valign='top' onclick=\"updateFieldLayer('".base_url()."web/account/remove_location_address/l/".$id."','','','location_msg_div','');removeTableRow('location_".$id."')\" style='cursor:pointer;' nowrap><img src='".base_url()."/assets/images/remove_icon.png'></td>
			<td valign='top'>".$row['storename'].(!empty($row['storeid'])? " (ID: ".$row['storeid'].")": "")."</td>
			<td valign='top'>".$row['addressline1']."</td>
			<td valign='top'>".$row['city']."</td>
			<td valign='top'>".$row['state']."</td>
			<td valign='top'>".$row['zipcode']."</td>
			<td valign='top'>".$row['country']."</td>
			<td valign='top'>".$row['telephone']."</td>
			<td valign='top'>".$row['emailaddress']."</td>
			</tr>";
			$counter++;
		}
		$tableHTML .= "</table>";
	}
	else
	{
		$tableHTML .= format_notice('WARNING: No stores added.');
	}
	$tableHTML .= "<input type='hidden' id='max_locations' name='max_locations' value='".($this->native_session->get('locations_count')? $this->native_session->get('locations_count'): 0)."'>
	<input type='hidden' id='locations_count' name='locations_count' value='".(!empty($counter)? $counter : 0)."'>";
}




else if(!empty($area) && $area == "application_competitor_list")
{
	if($this->native_session->get('competitor_list'))
	{
		$competitors = $this->native_session->get('competitor_list')? $this->native_session->get('competitor_list'): array();
		$tableHTML .= !empty($msg)?format_notice($msg):'';
		
		$tableHTML .= "<table border='0' cellspacing='0' cellpadding='5' class='listtable bigcontenttext'>";
		foreach($competitors AS $id=>$competitor)
		{
			$tableHTML .= "<tr id='row_".$competitor['id']."'><td class='lightergreybg' style='border-right:0px;' width='1%' onclick=\"updateFieldLayer('".base_url()."web/account/remove_competitor/d/".encrypt_value($competitor['id'])."','','','competitor_list','')\"><img src='".base_url()."assets/images/remove_icon.png' border='0'></td>
                  <td width='92%' class='lightergreybg' style='font-weight:bold;'>".$competitor['name']."<input type='hidden' name='competitor_ids[]' id='competitor_".$id."_id' value='".$competitor['id']."'></td>
                  <td width='1%' style='border-right:0px;padding-right:0px;'><input name='competitor_price_".$competitor['id']."[]' type='radio' value='1'></td>
                  <td width='1%' style='padding-right:35px;'>$</td>
                  <td width='1%' style='border-right:0px;padding-right:0px;'><input name='competitor_price_".$competitor['id']."[]' type='radio' value='2'></td>
                  <td width='1%' style='padding-right:35px;'>$$</td>
                  <td width='1%' style='border-right:0px;padding-right:0px;'><input name='competitor_price_".$competitor['id']."[]' type='radio' value='3'></td>
                  <td width='1%' style='padding-right:35px;'>$$$</td>
                  <td width='1%' style='border-right:0px;padding-right:0px;'><input name='competitor_price_".$competitor['id']."[]' type='radio' value='4'></td>
                  <td width='1%' style='padding-right:10px;'>$$$$</td>
                  </tr>";
		}
		$tableHTML .= "</table>";
	}
}




else if(!empty($area) && $area == "merchant_application_sub_menu")
{
	$tableHTML .= "<tr>
    <td style='padding-bottom:10px;padding-top:5px;' class='bottomborder'>
		<table border='0' cellspacing='0' cellpadding='10' width='100%'>
		<tr>
		<td style='padding-top:5px;padding-bottom:0px;'><a href='".base_url()."web/account/merchant_signup/t/".encrypt_value('saved_profile')."' class='bluebold'>Business Details</a></td>
		<td style='padding-top:5px;padding-bottom:0px;'><a href='".base_url()."web/account/add_store_locations' class='bluebold'>Additional Locations</a></td>
		<td style='padding-top:5px;padding-bottom:0px;'><a href='".base_url()."web/account/add_store_competitors' class='bluebold'>Competitors</a></td>
		<td style='padding-top:5px;padding-bottom:0px;'><a href='javascript:;' data-rel='merchant_application_status' class='bluebold tiplink'>Application Status</a><div id='merchant_application_status' class='tableborder' style='position:absolute;max-width:200px;max-height:150px;overflow-y:auto;overflow-x:hidden;padding:5px;background-color:#FFF;display:none;'><table border='0' cellspacing='0' cellpadding='3' width='100%'>
		<tr><td style='text-align:left; font-weight:bold;'>".strtoupper(format_status($merchant['status']))."</td><td style='text-align:right;cursor:pointer;' onClick=\"toggleLayer('merchant_application_status', '', '', '', '', '', '', '')\"><img src='".base_url()."assets/images/remove_icon.png' border='0'></td></tr>
		<tr><td style='text-align:left;' colspan='2'>".$merchant['status_message']."</td></tr>
		</table></div></td>
		</tr>
		</table>
	</td>
    </tr>";
}








else if(!empty($area) && $area == "search_side_list")
{
	
	if(!empty($pageList))
	{
		$alphabetCounter = 'A';
		
		foreach($pageList AS $row)
		{
			$tableHTML .= "<div class='noncurrentcell'>
    <table width='100%' border='0' cellspacing='0' cellpadding='0'  id='contenttable'>
  <tr>
    <td id='numbercell' width='1%'><div><span id='bignumber'>".(!empty($row['store_score'])? format_number($row['store_score'],5,0): 0)."</span><br><span id='smallnumber'  nowrap>Store Score</span></div></td>
    <td style='padding:0px;margin:0px;'><div class='locationbubble'>".$alphabetCounter."</div></td>
    <td width='98%' valign='top' style='padding:10px 10px 0px 0px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
        <td width='99%' style='cursor:pointer;' nowrap><a href='".base_url()."web/search/show_store_home/i/".encrypt_value($row['store_id']).(!empty($sort)? '/sort/'.$sort: '/sort/distance').(!empty($p)? '/p/'.$p: '/p/1').(!empty($c)? '/c/'.$c: '/c/10').($this->native_session->get('return_count')? '/returnCount/'.$this->native_session->get('return_count'): '/returnCount/10')."' class='title'>".limit_string_length(html_entity_decode($row['name'], ENT_QUOTES), 17)."</a></td>
      </tr>
      <tr>
        <td class='subtitle' nowrap>".(!empty($row['sub_category_tags'])? limit_string_length(wordwrap(html_entity_decode($row['sub_category_tags'], ENT_QUOTES), 25,'<BR>'), 48) : "")." <img src='".base_url()."assets/images/right_arrow_lightgrey.png'> ".$row['price_range']."</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td id='".$row['id']."_favorite' ".((!empty($row['is_favorite']) && $row['is_favorite']=='Y')? " style='padding:10px; text-align:center;' title='This is one of your favorites' ": " style='padding:10px; text-align:center;cursor:pointer;'  onClick=\"updateFieldLayer('".base_url()."web/search/add_favorite_store/s/".encrypt_value($row['id']).($this->native_session->get('userId')? "/u/".encrypt_value($this->native_session->get('userId')): '')."','','','".$row['id']."_favorite','')\" title='Click to add to favorites' ")." ><img src='".base_url()."assets/images/favorite_icon".((!empty($row['is_favorite']) && $row['is_favorite']=='Y')? "": "_grey").".png'></td>
    <td colspan='2' style='padding:10px;'>
    <table width='100%' border='0' cellspacing='0' cellpadding='3'>
  <tr>";


	if(!empty($row['cashback_range']['max_cashback']))
	{
    	$tableHTML .= "<td style='padding-left:0px;' width='1%'><table border='0' cellspacing='0' cellpadding='2' class='rewardcard'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>".($row['cashback_range']['min_cashback'] == $row['cashback_range']['max_cashback']? format_number($row['cashback_range']['max_cashback'],3,0): format_number($row['cashback_range']['min_cashback'],3,0)."-".format_number($row['cashback_range']['max_cashback'],3,0))."%</td>
  </tr>
</table>
</td>";
	}
	
	if(!empty($row['has_perk']) && $row['has_perk'])
	{ 
    	$tableHTML .= "<td style='padding-left:3px;padding-right:0px;' width='1%'><table border='0' cellspacing='0' cellpadding='2' class='perkcard'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>Perk</td>
  </tr>
</table></td>";
	}


$tableHTML .= "<td width='98%' valign='bottom' style='text-align:right;'>".(!empty($row['distance'])? format_number($row['distance'],4,1): 0)."mi</td>
  </tr>
</table>
    </td>
    </tr>
</table>
    </div>";
	
    		$alphabetCounter++;
		}
    }
	else
	{
		$tableHTML .= format_notice('WARNING: There are no search results.');
	}
}








else if(!empty($area) && $area == "add_favorite")
{
	$tableHTML .= (!empty($result) && $result)? "<img src='".base_url()."assets/images/favorite_icon.png'>": "<img src='".base_url()."assets/images/favorite_icon_grey.png'>";
	
	
}


else if(!empty($area) && $area == "featured_items_home_page")
{
	$tableHTML .= $javascript.$jquery;
	if(!empty($featured))
	{
    	foreach($featured AS $row)     
     	{  
          $defaultImage = $row['category_image'];
		  $showImage = !empty($row['small_cover_image'])? $row['small_cover_image']: (!empty($row['logo_url'])? $row['logo_url']:$defaultImage);
		  
		  $tableHTML .= "<div class='highlightbox featured'>
          <table width='100%' cellpadding='10' border='0' cellspacing='0' >
          <thead>
          <tr>
		  ".
		  ($showImage != $defaultImage? 
		  "<td style='background: url(".base_url()."assets/uploads/images/".$showImage.") no-repeat center center;'>&nbsp;</td>":
		  "<td style='background: #2DA0D1; text-align:center; verticle-align:center;'><img src='".base_url()."assets/images/".(!empty($defaultImage)? str_replace('blue_', 'white_', $defaultImage): 'white_local_flavor_icon.png')."' border='0'></td>"
		  )."
		  </tr>
          </thead>
          <tr><td style='padding-top:0px;' nowrap><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td colspan='3'><table width='100%' border='0' cellspacing='0' cellpadding='3'>
    <tr><td width='99%' class='subsectiontitle' style='text-align:left;padding-left:0px; padding-right:2px;'>
    ".limit_string_length(html_entity_decode($row['name'], ENT_QUOTES), 22)."
    </td>
    <td width='1%' class='smalltxt' style='text-align:right;'>".format_number($row['distance'],4,1)."mi</td>
    </tr>
    </table></td>
    </tr>
  <tr>
    
<td class='smallertitle'>".(!empty($row['sub_category_tags'])? limit_string_length(wordwrap(html_entity_decode($row['sub_category_tags'], ENT_QUOTES), 30,'<BR>'), 45) : "")."  <img src='".base_url()."assets/images/right_arrow_lightgrey.png'> ".$row['price_range']."
</td>";



			if(!empty($row['cashback_range']['max_cashback']))
			{
				$tableHTML .= "<td width='1%'>
<table border='0' cellspacing='0' cellpadding='2' class='rewardcard'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>".($row['cashback_range']['min_cashback'] == $row['cashback_range']['max_cashback']? format_number($row['cashback_range']['max_cashback'],3,0): format_number($row['cashback_range']['min_cashback'],3,0)."-".format_number($row['cashback_range']['max_cashback'],3,0))."%</td>
  </tr>
</table>
</td>";
			}


	
			if(!empty($row['has_perk']) && $row['has_perk'])
			{	
				$tableHTML .= "<td width='1%' style='padding-left:5px;padding-right:0px;'><table border='0' cellspacing='0' cellpadding='2' class='perkcard'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>Perk</td>
  </tr>
</table></td>";
			}

			$tableHTML .= "</tr>
</table></td></tr>
          </table>
          </div>";
         $promotionType = $row['promotion_type']; 
	 }
}
else
{
	$tableHTML ='';
}

	$tableHTML .= ((!empty($promotionType) && in_array($promotionType, array('cash_back','perk'))) || $tableHTML == '')? "<input type='hidden' id='".$l."_stop_load' name='".$l."_stop_load' value='Y'>": "";
}








else if(!empty($area) && $area == "suggestion_result")
{
	$tableHTML .= format_notice((!empty($result) && $result)? "Request Sent": "ERROR: Request Not Sent");
	
	
}








else if(!empty($area) && $area == "show_video_area")
{
	$tableHTML .= "<table border='0' cellspacing='0' cellpadding='5'><tr><td>";
	
	$tableHTML .= !empty($videoDetails)? "<iframe width='560' height='315' src='".$videoDetails['asset_value']."' frameborder='0' allowfullscreen></iframe>": format_notice('ERROR: The requested video can not be resolved.');

	$tableHTML .= "</td></tr></table>";
	
	
}





























echo $tableHTML;
?>