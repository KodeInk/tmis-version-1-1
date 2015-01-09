<?php
#If the main or sub menu items are not given, then just assign them an empty string
$main = !empty($main)? $main: "transactions";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Dashboard";?></title>
	<?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
    <script src='<?php echo base_url();?>assets/js/jquery.sortelements.js' type='text/javascript'></script>
    <script src='<?php echo base_url();?>assets/js/clout.list.js' type='text/javascript'></script>
	<?php 
		echo get_ajax_constructor(TRUE);
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/clout.list.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
<script>
$(function() {
	$("#sendactionsbtn").click(function() {
    	$("#sendactions").slideToggle('fast');
	});
	
	$(document).mouseup(function (e)
	{
    	var container1btn = $("#sendactions");
		// if the target of the click isn't the container...
		if (!container1btn.is(e.target) && container1btn.has(e.target).length == 0) 
    	{
       	 	container1btn.hide('fast');
    	}
	});
});
</script>
</head>
<body style="margin:0px;"><div id="systemmessage" class="pagemessage"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="transactions_list_header">
<tr>
<td colspan='5' class='menutablecontainer'><table width="100%" border="0" cellspacing="0" cellpadding="0" class="menutable">
      <tr>
      	<td id="menu_dashboard" <?php echo (empty($main) || $main=='dashboard')? " class='activemenu'":"";?>><a href="javascript:void(0);">Dashboard</a></td>
        <td id="menu_users" <?php echo ($main=='users')? " class='activemenu'":"";?>><a href="javascript:void(0);">Users</a></td>
        
        <td id="menu_merchants" <?php echo ($main=='merchants')? " class='activemenu'":"";?>><a href="javascript:void(0);">Merchants</a></td>
        <td id="menu_agents" <?php echo ($main=='agents')? " class='activemenu'":"";?>><a href="javascript:void(0);">Agents</a></td>
        <td id="menu_affiliates" <?php echo ($main=='affiliates')? " class='activemenu'":"";?>><a href="javascript:void(0);">Affiliates</a></td>
        <td id="menu_transactions" <?php echo ($main=='transactions')? " class='activemenu'":"";?>><a href="javascript:void(0);">Transactions</a></td>
        <td id="menu_promos" <?php echo ($main=='promos')? " class='activemenu'":"";?>><a href="javascript:void(0);">Promos</a></td>
        <td id="menu_message_center" <?php echo ($main=='messages')? " class='activemenu'":"";?>><a href="javascript:void(0);">Message Center</a></td>
        <td id="menu_finances" <?php echo ($main=='finances')? " class='activemenu'":"";?>><a href="javascript:void(0);">Finances</a></td>
        <td id='menu_settings' <?php echo ($main=='settings')? " class='activemenu'":"";?>><a href="javascript:void(0);">Settings</a></td>
        <td id="menu_customer_service" <?php echo ($main=='customer_service')? " class='activemenu'":"";?> nowrap><a href="javascript:void(0);">Customer Service</a></td>
        
        <td align="center"  nowrap style="padding-left:40px; padding-right:40px;" onClick="location.href='<?php echo base_url().'web/account/logout';?>'"><div id="user_pop_btn_container">
        
        <div id="usersettings" class="stickytip"><img src="<?php echo base_url();?>assets/images/down_arrow_lightgrey.png" border="0"/> &nbsp;<a href="javascript:void(0);"><?php echo "<b>".$_SESSION['first_name']." ".$_SESSION['last_name']." - ".($_SESSION['user_type'] != 'normal'? ucfirst($_SESSION['user_type']): '')."</b>";?></a></div>
        
<div id="usersettings_tip" class="menulayer" style="display:none; z-index:100;"><table width='100%' cellpadding='5'>
<tr><td><img src='<?php echo base_url()."assets/uploads/".$_SESSION['photo_url'];?>'></td>
<td ><?php echo "<b style='font-size:18px;'>".$_SESSION['first_name']." ".$_SESSION['last_name']."</b><br>Logged in as: <b style='font-size:13px;'>".($_SESSION['user_type'] != 'normal'? ucfirst($_SESSION['user_type']): 'User')."</b>";?></td></tr>

<tr><td colspan='2'>
<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td><a href='javascript:;'><input type='button' name='mysettings' id='mysettings' value='my settings' class='otherbtn'></a></td><td align='right' style='padding-left:20px;'><a href='<?php echo base_url();?>web/account/logout'><input type='button' name='logout' id='logout' value='logout' class='otherbtn'></a></td></tr></table>
</td></tr></table>
    </div>
    
    </div></td>
		
        <td id="logocell" style="padding:0px; padding-left:30px; padding-right:30px; width:1%; height:40px; text-align:center;"><a href="<?php echo $this->account_manager->get_dashboard();?>"><img src="<?php echo base_url();?>assets/images/logo.png" border="0"/></a><input id="layerid" name="layerid" type="hidden" value=""></td>
        
      </tr>
    </table></td>
						</tr>
                        
                        
<tr>
   <td style="padding: 0px;background-color: #F1F1F1;">             
     <table width="100%" border="0" cellspacing="0" cellpadding="5">   
       <tr>
       <td class="adminsubtitle" onClick="showDiv()">Transactions</td>
       <td style="padding:15px;" align="right"><table  border="0" cellspacing="0" cellpadding="0">
       <tr>
       		<td style="padding-right:15px;"><input id="transactionsoptions" name="transactionsoptions" class="searchlistoptions" value="Transactions - List"/><div id="transactionsoptions_values" class="searchlistoptionsvalues"><em></em><table>
            <tr><td colspan='2' class='header'>Transactions:</td></tr>
            <tr><td width="1%"><input id="transactionscheck_list" name="optionactions[]" type="radio" value="Transactions - List" checked></td><td width="99%">List View</td></tr>
            <tr><td><input id="transactionscheck_report" name="optionactions[]" type="radio" value="Transactions - Report"></td><td>Report View</td></tr>
            
            </table></div></td>
       		<td class='leftheaderborder'><table width="100%" border="0" cellspacing="0" cellpadding="0" id="slideoptionstable" class="slideoptionslist">
      <tr>
        <td width="1%" onClick="updateViewedLayerTitle('left','transactions_dashboard')" id="left_arrow_box">&nbsp;</td>
        <td id="transactions_dashboard_view_title">All</td>
        <td width="1%" onClick="updateViewedLayerTitle('right','transactions_dashboard')" id="right_arrow_box">&nbsp;</td>
      </tr>
    </table>
    <div id="slideoptionstable_values" class="slideoptionslistvalues">
    <em></em>
    <table>
       <tr><td width="1%"><input id="slideoptions_all" name="slideoptions[]" type="radio" value="All" checked></td><td width="99%">All</td></tr>
       <tr><td><input id="slideoptions_cleared" name="slideoptions[]" type="radio" value="Cleared"></td><td>Cleared</td></tr>
       <tr><td><input id="slideoptions_flagged" name="slideoptions[]" type="radio" value="Flagged"></td><td>Flagged</td></tr>
       <tr><td><input id="slideoptions_failed" name="slideoptions[]" type="radio" value="Failed"></td><td>Failed</td></tr>
       <tr><td><input id="slideoptions_unmatched" name="slideoptions[]" type="radio" value="Unmatched"></td><td>Unmatched</td></tr>
       <tr><td><input id="slideoptions_disputes" name="slideoptions[]" type="radio" value="Disputes"></td><td>Disputes</td></tr>
       <tr><td><input id="slideoptions_release_of_funds" name="slideoptions[]" type="radio" value="Release of Funds"></td><td>Release of Funds</td></tr>
       <tr><td><input id="slideoptions_holds" name="slideoptions[]" type="radio" value="Holds"></td><td>Holds</td></tr>
       <tr><td><input id="slideoptions_charged_back" name="slideoptions[]" type="radio" value="Charged Back"></td><td>Charged Back</td></tr>
       <tr><td><input id="slideoptions_pending" name="slideoptions[]" type="radio" value="Pending"></td><td>Pending</td></tr>
       <tr><td><input id="slideoptions_archived" name="slideoptions[]" type="radio" value="Archived"></td><td>Archived</td></tr>
     </table>
    </div>
    <input type="hidden" name="listbaseurl" id="listbaseurl" value="<?php echo base_url().'web/transactions/load_transaction_list';?>">
    <input type="hidden" name="listdiv" id="listdiv" value="transactions">
    <input type="hidden" name="mainmenuvalue" id="mainmenuvalue" value="transactionscheck_list">
    <input type="hidden" name="submenu" id="submenu" value="slideoptionstable">
    </td>
            <td class='leftheaderborder'><input type="text" id="transactionslist" name="transactionslist" placeholder="Search.." class="simpleheadersearch" style="width:200px"  onkeyup="startInstantSearch('transactionslist', 'transactionslist__searchby', '<?php echo base_url();?>web/search/load_results/type/search_transaction_list/layer/transactions')" onClick="updateFieldValue('transactionslist', '')"><input name="transactionslist__searchby" id="transactionslist__searchby" type="hidden" value="U.first_name__U.last_name__U.email_address__S.name"></td>
            
            
            
            
            <td class='leftheaderborder'><div id="settings_btn_container" style="display:block;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable" style="cursor:pointer;" id="settingsbtn">
      <tr>
        <td width="1%" style="padding:3px 5px 3px 5px;line-height:0px; border-right:solid 1px #E9E9E9;"><img src="<?php echo base_url();?>assets/images/search_settings_icon.png" border="0"></td>
        <td width="1%" style="padding:5px 2px 5px 2px; line-height:0px;"><img src="<?php echo base_url();?>assets/images/down_arrow_black.png" border="0"></td>
      </tr>
    </table>
    <div id="settingsactions" class="menulayer" style="display:none; z-index:100;"><table width="100%" border="0" cellspacing="0" cellpadding="5"  class="ariallabel" style="font-size:14px;">
  <tr>
    <td style="padding-bottom:0px;" valign="bottom">Search By:
</td>
  </tr>
  <tr>
    <td style="padding-top:0px;">Store Name</td>
  </tr>
  <tr>
    <td style="padding-top:0px;">User First Name</td>
  </tr>
  <tr>
    <td style="padding-top:0px;">User Last Name</td>
  </tr>
  <tr>
    <td style="padding-top:0px;">User Email Address</td>
  </tr>
  </table></div>
    </div></td>
            
            <td style="padding-right:15px;">
            <div id="add_labels_btn_container" style="display:block;"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable" style=" cursor:pointer;" id="addlabelsbtn">
      <tr>
        <td width="1%" style="padding:5px 5px 4px 5px;line-height:0px; border-right:solid 1px #E9E9E9;"><img src="<?php echo base_url();?>assets/images/tag_icon.png" border="0"></td>
        <td width="1%" style="padding:5px 2px 5px 2px; line-height:0px;"><img src="<?php echo base_url();?>assets/images/down_arrow_black.png" border="0"></td>
      </tr>
    </table>
    <div id="addlabels" class="menulayer" style="display:none;width:228px;padding:0px; z-index:100;"><table width="100%" border="0" cellspacing="0" cellpadding="5"  class="ariallabel" style="font-size:14px;">
  <tr>
    <td style="padding-bottom:0px;" valign="bottom">Label as:
</td>
  </tr>
  <tr>
    <td style="padding-top:0px;"><input type="text" name="labelsearch" id="labelsearch" value="" class="searchfield" style="width:200px;"></td>
  </tr>
  <tr>
    <td style="border-top: solid 1px #DDDDDD;"><div id="labelslist" style="max-height:150px;overflow:auto;">
    <div id="label_001"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="001" value="001"></td><td>Favorite Customer</td></tr></table></div>
    
    <div id="label_002"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="002" value="002"></td><td>Big Spender</td></tr></table></div>
    
    <div id="label_003"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="003" value="003"></td><td>Behaviour Issues</td></tr></table></div>
    
    <div id="label_004"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="004" value="004"></td><td>Celebrity</td></tr></table></div>
    
    <div id="label_005"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="005" value="005"></td><td>Has Many Friends</td></tr></table></div>
    
    <div id="label_006"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="006" value="006"></td><td>Cheap Tipper</td></tr></table></div>
    
    <div id="label_007"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="007" value="007"></td><td>Big Tipper</td></tr></table></div>
    
    
    </div></td>
  </tr>
  <tr>
    <td style="border-top: solid 1px #DDDDDD;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="98%"><a href="javascript:;" class="smallblueariallink" style="color: #2C9FD1;">Manage</a> </td>
    <td width="1%"><input type="text" name="newlabel" id="newlabel" value="" placeholder="New Label" class="textfield" style="width:90px;font-size: 12px; padding:5px;"></td>
    <td width="1%" style="padding-left:3px;"><input id="addnewlabel" name="addnewlabel" type="button" value="Add" class="greenbtn" style="font-size: 12px; padding: 3px 7px 3px 7px;width:30px;"></td>
  </tr>
</table>
</td>
  </tr>
</table>
</div>
    
    </div>
            </td>
            
            
            
            <td><div style="display:block;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable" style=" cursor:pointer;" id="sendactionsbtn">
      <tr>
        <td width="1%" style="padding:1px 2px 2px 4px;line-height:0px; border-right:solid 1px #E9E9E9;"><img src="<?php echo base_url();?>assets/images/send_icon.png" border="0"></td>
        <td width="1%" style="padding:5px 2px 5px 2px; line-height:0px;"><img src="<?php echo base_url();?>assets/images/down_arrow_black.png" border="0"></td>
      </tr>
    </table>
    <div id="sendactions" class="menulayer" style="display:none; z-index:100;"><a href="javascript:;" onclick="processToMessage('<?php echo base_url().'web/transactions/simple_list_action/a/'.encrypt_value('archive');?>', '.bigcheckbox', '*archive', 'actionMsgDiv', 'Are you sure you want to archive the selected transactions?')">Archive</a><br>

<a href="javascript:;" onclick="processToMessage('<?php echo base_url().'web/transactions/simple_list_action/a/'.encrypt_value('delete');?>', '.bigcheckbox', '*delete', 'actionMsgDiv', 'Are you sure you want to delete the selected transactions?')">Delete</a></div>
    </div>
    <div id="actionMsgDiv" style="display:none;"></div></td>
            
            
       </tr>
       </table></td>
       </tr>
     </table>     
   </td>
</tr>   
</table>
</td></tr>


<tr><td class="sticky_table"><div id="transactions">
<table border="0" width="100%" cellspacing="0" cellpadding="0" id="transactions_list" class="scrollablelisttable">
					<thead>
						<tr class="tableheaderrow">
                          <th width='1%' style="padding-left:3px;padding-right:3px;"><a href='javascript:;'>Select All</a><br>
<input id="selectallbtn" name="selectallbtn" type="checkbox" value="selectall" class="selectallcheck" onClick="selectAllByClass('selectallbtn', 'bigcheckbox');"><label for="selectallbtn"></label></th>
							<th><a href='javascript:;'>Date</a></th>
                            <th class='sortcolumn'><a href='javascript:;'>User</a></th>
							<th class='sortcolumn'><a href='javascript:;'>Store</a></th>
							<th><a href='javascript:;'>Amount</a></th>
							<th class='sortcolumn'><a href='javascript:;'>Type</a></th>
							<th><a href='javascript:;'>Item Details</a></th>
                            <th><a href='javascript:;'>Address</a></th>
						</tr>
					</thead>
					<tbody id='listbody'>
						<?php
                        if(!empty($transactionList))
						{
							foreach($transactionList AS $row)
							{
								echo "<tr>
						  <td width='1%'><input id='select_".$row['id']."' name='selectall[]' type='checkbox' value='".$row['id']."' class='bigcheckbox'><label for='select_".$row['id']."'></label></td>
					    <td style='min-width:120px;' nowrap>".((!empty($row['start_date']) || $row['start_date'] == '0000-00-00 00:00:00')? date('D, M j, Y', strtotime($row['start_date'])): '&nbsp;')."</td>
						<td style='min-width:140px;'>".ucwords(html_entity_decode($row['user_name'], ENT_QUOTES))."</td>
						<td>".html_entity_decode($row['store_name'], ENT_QUOTES)."</td>
						<td>$".add_commas($row['amount'] < 0? (0-$row['amount']): $row['amount'])."</td>
					    <td>".($row['transaction_type'] == 'buy'? 'Withdrawal': 'Deposit')."</td>
						<td>".$row['item_details']."</td>
						<td>".$row['store_address']."</td>
						</tr>";
							}
						}
						else
						{
							echo "<tr><td colspan='6'>".format_notice('WARNING: There are no imported transactions at the moment.')."</td></tr>";
						}
                        
                        
                        
                        
                        
                        ?>
                        
					</tbody>
				</table>

                <div id='transactions_checker_view' class="scroll_checker_view"></div><input type="hidden" id="list_checker_view_flag" name="list_checker_view_flag" value="use_list" />
                </div>
</td></tr></table>	</body>
</html>