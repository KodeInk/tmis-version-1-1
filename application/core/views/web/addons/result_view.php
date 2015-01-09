<?php 
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>".get_AJAX_constructor(TRUE); 
$jquery = "<script src='".base_url()."assets/js/jquery.min.js' type='text/javascript'></script>";
$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 
$area = !empty($area)? $area: '';

#result of updating a score
if($area == 'score_update_area')
{
	$tableHTML .= (!empty($updateResult) && $updateResult)? format_notice("UPDATED"): format_notice("<span class='error'>ERROR</span>");
}

#Import results
else if($area == 'import_results')
{
	$tableHTML .= format_notice($msg);
}

#List of institutions to select from
else if($area == 'institution_list')
{
	$tableHTML .= "<table width='100%' class='listtable' border='0' cellpadding='5'  cellspacing='0'>";
	foreach($pageList AS $row)
	{
		$tableHTML .= "<tr><td>&bull; <a href='javascript:void(0)' onclick=\"updateFieldValue('bankid', '".$row['third_party_id']."');showFieldValue('bank_name_display', '<b style=\'font-size:15px;\'>Login: ".$row['institution_name']."</b>');unhideShowLayer('','institution_search_and_display');hideLayerSet('".$layer."');\">".html_entity_decode($row['institution_name'])."</a></td></tr>";
	}
	
	$tableHTML .= "</table>";
}


#List of banks used in selecting accounts
else if($area == 'select_account_bank_list')
{
	if(!empty($pageList))
	{
		$tableHTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='7' class='listtable' style='background-color:#fff;'>";
		
		foreach($pageList AS $bank)
		{
	 		$tableHTML .= "<tr style='border-bottom: solid 1px #F2F2F2;'><td><a href='".base_url()."web/account/show_bank_login/i/".encrypt_value($bank['id'])."/n/".encrypt_value($bank['institution_name'])."/c/".encrypt_value($bank['institution_code'])."' class='fancybox fancybox.ajax bluelink'>".html_entity_decode($bank['institution_name'])."</a></td></tr>";
		}
		$tableHTML .= "</table>";
	}
	else
	{
		$tableHTML .= format_notice('WARNING: No bank matching the search phrase has been added to the platform yet.');
	}
}


#Results from the account processing
else if($area == 'account_results')
{
	print_r($xmlObj);
}


#Show a list of accounts that have been imported
else if($area == 'account_list')
{
	$tableHTML .= "<table width='100%' class='listtable' border='0' cellpadding='5'  cellspacing='0'>
					<tr><td colspan='5'>".format_notice($msg)."</td></tr>
					
					<thead><tr>
					<td>&nbsp;</td>
					<td nowrap><b>Account Number</b></td>
					<td nowrap><b>Nickname</b></td>
					<td nowrap><b>Bank</b></td>
					<td nowrap><b>Account Type</b><input type='hidden' id='selectedaccounts' name='selectedaccounts' value=''></td>
					</tr></thead>";
	
	$counter = 0;
	$rawIds = array();
	foreach($rawAccounts AS $accountType=>$accountGroup)
	{
		foreach($accountGroup AS $accountRow)
		{
			$typeArray = explode('_', $accountType);
			$tableHTML .= "<tr style=\"".get_row_color($counter, 2)."\">
			<td>".(in_array($accountRow['account_id'], $currentAccountIds)? "<img src='".base_url()."assets/images/tick.png' border='0'/>": "<input type='checkbox' id='account_".$accountRow['account_id']."' name='accounts[]' value='".$accountRow['account_id']."_".$typeArray[0]."' onclick=\"updateCheckboxList('account_".$accountRow['account_id']."', 'selectedaccounts')\">")."</td>
			<td>".$accountRow['account_number']."</td>
			<td>".$accountRow['account_nickname']."</td>
			<td>".$accountRow['institution_name']."</td>
			<td>".ucwords(str_replace('_', ' ', $accountType))."</td>
			</tr>";
			#Add the account ID to the list of non-linked accounts if it is included in the list of raw accounts
			if(!in_array($accountRow['account_id'], $currentAccountIds))
			{
				array_push($rawIds, $accountRow['account_id']);
			}
			
			$counter++;
		}
	}
	
	if(!empty($rawIds))
	{
		$tableHTML .= "<tr><td colspan='5'><input type='button' name='linkaccounts' id='linkaccounts' value='Link Selected Accounts' class='blackbtn'  onClick=\"updateFieldLayer('".base_url()."web/transactions/link_accounts/u/".encrypt_value($userId)."','selectedaccounts','','bank_access_results','Please select at least one account to link.')\"></td></tr>";
	}
	
	$tableHTML .= "</table>";
}





#List of users in my direct network
else if($area == 'my_direct_network')
{
	if(!empty($pageList))
	{
		$tableHTML .= "<table border='0' cellspacing='0' cellpadding='0' width='100%' class='networklisttable' style='border:0px;'>";
	   
	   	$counter = 0;
	   	foreach($pageList AS $row)
	   	{
		   $tableHTML .= "<tr ".($counter%2 == 0? " style='background-color:#FFF;'": "").">
          	<td>";
		  if(!empty($row['photo_url']) && strpos(strtolower($row['photo_url']), 'http') !== FALSE)
		  {
			  $imgUrl = $row['photo_url'];
		  }
		  else if(!empty($row['photo_url']))
		  {
			  $imgUrl = base_url()."assets/uploads/images/".$row['photo_url'];
		  }
		  else
		  {
			  $imgUrl = base_url().'assets/uploads/images/default_network_user_icon.png';
		  }
		  
		  $tableHTML .= "<div class='circular' style='background: url(".$imgUrl.") no-repeat; display:inline-block;'></div><div style='display:inline-block; vertical-align:top; padding-left:10px; padding-top:10px;'><span style='font-weight:bold;'>".$row['name']."</span><br>
<span class='smalltxt'>".$row['email_address']."</span></div>
</td>
          <td style='width:100px;'>".(!empty($row['last_activity_date'])? format_date_interval($row['last_activity_date'], date('Y-m-d H:i:s', strtotime('now')), FALSE, TRUE, 'days'): 'never')."</td>
          <td style='width:60px;'>".format_number($row['total_network'],6)."</td>
          <td style='width:50px;border-right:0px;'>".format_number($row['total_invites'],6)."</td>
        </tr>";
        	
        	$counter++;
	    }
	    $tableHTML .= "</table>";
	}
	else
	{
		$tableHTML .= format_notice('WARNING: No user matches the search phrase.');
	}
}



#List of users in the invite network
else if($area == 'my_invite_network')
{
	if(!empty($pageList))
	{
		$tableHTML .= "<table border='0' cellspacing='0' cellpadding='0' width='100%' class='networklisttable' style='border:0px;'>";
	   
	   	$counter = 0;
	   	foreach($pageList AS $row)
	   	{
		   $tableHTML .= "<tr ".($counter%2 == 0? " style='background-color:#FFF;'": "").">
          	<td>";
		  if(!empty($row['photo_url']) && strpos(strtolower($row['photo_url']), 'http') !== FALSE)
		  {
			  $imgUrl = $row['photo_url'];
		  }
		  else if(!empty($row['photo_url']))
		  {
			  $imgUrl = base_url()."assets/uploads/images/".$row['photo_url'];
		  }
		  else
		  {
			  $imgUrl = base_url().'assets/uploads/images/default_network_user_icon.png';
		  }
		  
		  $tableHTML .= "<div class='circular' style='background: url(".$imgUrl.") no-repeat; display:inline-block;'></div><div style='display:inline-block; vertical-align:top; padding-left:10px; padding-top:10px;'><span style='font-weight:bold;'>".$row['name']."</span><br>
<span class='smalltxt'>".$row['email_address']."</span></div>
</td>
          <td style='width:100px;'>".((!empty($row['last_activity_date']) && $row['last_activity_date'] != '0000-00-00 00:00:00')? format_date_interval($row['last_activity_date'], date('Y-m-d H:i:s', strtotime('now')), FALSE, TRUE, 'days'): 'never')."</td>
          <td style='width:50px;'>".format_number($row['total_invites'],6)."</td>
		  <td style='width:60px;border-right:0px;'>".format_status($row['invitation_status'])."</td>
        </tr>";
        	
        	$counter++;
	    }
	    $tableHTML .= "</table>";
	}
	else
	{
		$tableHTML .= format_notice('WARNING: No user matches the search phrase.');
	}
}








echo $tableHTML;

?>