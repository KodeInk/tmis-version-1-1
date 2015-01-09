<?php
#If the main or sub menu items are not given, then just assign them an empty string
$main = !empty($main)? $main: "";
?>
	<script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    
    <script>
$(function() {
	$(".stickytip").click(function() {
    	var tipId = $(this).attr('id');
		$("#"+tipId+"_tip").slideToggle('fast');
	});
	
	$(document).mouseup(function (e)
	{
    	var container1btn = $("#usersettings");
		var container1 = $("#usersettings_tip");
		
		// if the target of the click isn't the container...
		// ... nor a descendant of the container
   		if (!container1btn.is(e.target) && container1btn.has(e.target).length === 0 && !container1.is(e.target) && container1.has(e.target).length === 0) 
    	{
       	 	container1.hide('fast');
    	}
		
	});
});



</script>

<tr>
    <td style="background-color:#000;padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="10" class="menutable">
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
        
        <td align="center"  nowrap style="padding-left:40px; padding-right:40px;"><div id="user_pop_btn_container">
        
        <div id="usersettings" class="stickytip"><img src="<?php echo base_url();?>assets/images/down_arrow_lightgrey.png" border="0"/> &nbsp;<a href="javascript:void(0);"><?php echo "<b>".$_SESSION['first_name']." ".$_SESSION['last_name']." - ".($_SESSION['user_type'] != 'normal'? ucfirst($_SESSION['user_type']): '')."</b>";?></a></div>
        
<div id="usersettings_tip" class="menulayer" style="display:none; z-index:100;"><table width='100%' cellpadding='5'>
<tr><td><img src='<?php echo base_url()."assets/uploads/".$_SESSION['photo_url'];?>'></td>
<td ><?php echo "<b style='font-size:18px;'>".$_SESSION['first_name']." ".$_SESSION['last_name']."</b><br>Logged in as: <b style='font-size:13px;'>".($_SESSION['user_type'] != 'normal'? ucfirst($_SESSION['user_type']): 'User')."</b>";?></td></tr>

<tr><td colspan='2'>
<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td><a href='javascript:;'><input type='button' name='mysettings' id='mysettings' value='my settings' class='otherbtn'></a></td><td align='right' style='padding-left:20px;'><a href='<?php echo base_url();?>web/account/logout'><input type='button' name='logout' id='logout' value='logout' class='otherbtn'></a></td></tr></table>
</td></tr></table>
    </div>
    
    </div></td>
		
        <td style="padding:0px; padding-left:30px; padding-right:30px; width:1%; height:40px; text-align:center;"><a href="<?php echo $this->account_manager->get_dashboard();?>"><img src="<?php echo base_url();?>assets/images/logo.png" border="0" height="18"/></a></td>
        
      </tr>
    </table><input name="layerid" id="layerid" type="hidden" value=""></td>
  </tr>