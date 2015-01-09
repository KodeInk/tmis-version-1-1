<?php
#If the main or sub menu items are not given, then just assign them an empty string
$main = !empty($main)? $main: "";
$sub = !empty($sub)? $sub: "";
?>

	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/tiptip.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.tiptip.minified.js' type='text/javascript'></script>
    <script>
	$(function(){
		$("#user_pop").tipTip({
			maxWidth: "450px", 
			keepAlive: true,
			edgeOffset: 10,
			fadeIn: 0,
			delay: 30,
			activation: "click",
			content: "<table width='100%' cellpadding='5'><tr><td><img src='<?php echo base_url()."assets/uploads/mortons_steakhouse_01.jpg";?>'></td><td ><?php echo "<b style='font-size:18px;'>Morton's Steakhouse</b><br>Logged in as: <b style='font-size:13px;'>Merchant</b>";?></td></tr><tr><td colspan='2'><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td><a href='javascript:;'><input type='button' name='mysettings' id='mysettings' value='my settings' class='otherbtn'></a></td><td align='right' style='padding-left:20px;'><a href='<?php echo base_url();?>web/account/logout'><input type='button' name='logout' id='logout' value='logout' class='otherbtn'></a></td></tr></table></td></tr><tr><td colspan='2'><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td align='center'><a href='<?php echo base_url()."web/account/switch_my_account/a/".encrypt_value('1000000000000002');?>'><input type='button' name='switch001' id='switch001' value='login as Derick Manlapeg' class='otherbtn' style='width:320px'></a></td></tr></table></td></tr></table>"
			});
	});
	
	</script>

<tr>
    <td style="background-color:#000; height:46px;"><div class='stickyheader'><table width="100%" border="0" cellspacing="0" cellpadding="10" class="menutable">
      <tr>
        
        <td id="menu_customers" <?php echo ($main=='customers')? " class='activemenu'":"";?> style="width:120px;" onclick="document.location.href='<?php echo base_url();?>web/account/merchant_dashboard'"><a href="javascript:void(0);">Customers</a></td>
        
        <td id="menu_money" <?php echo ($main=='money')? " class='activemenu'":"";?> style="width:120px;" onclick="document.location.href='<?php echo base_url();?>web/money/show_money_home'"><a href="javascript:void(0);">Money</a></td>
        
        <td id="menu_network" <?php echo ($main=='network')? " class='activemenu'":"";?> onclick="document.location.href='<?php echo base_url();?>web/network/show_network_home'" nowrap><a href="javascript:void(0);" style="width:120px;">Network</a></td>
        
        <td id="menu_promotions" <?php echo ($main=='promotions')? " class='activemenu'":"";?> style="width:120px;" onclick="document.location.href='<?php echo base_url();?>web/promotions/manage_promotions'"><a href="javascript:void(0);">Promotions</a></td>
        
        
        
        <td style="width:30%;border-top: solid 4px #000; cursor:default;">&nbsp;</td>
        <td align="center"  nowrap style="padding-left:40px; padding-right:40px;" id="user_pop"><img src="<?php echo base_url();?>assets/images/down_arrow_lightgrey.png" border="0"/> &nbsp;<a href="javascript:void(0);"><?php echo "<b>Morton's Steakhouse</b>";?></a>
</td>
        <td style="padding:0px; padding-left:30px; padding-right:30px; width:1%; height:40px; text-align:center;"><a href="<?php echo base_url()."web/account/merchant_dashboard";?>"><img src="<?php echo base_url();?>assets/images/logo.png" border="0" height="18"/></a></td>
      </tr>
    </table><input name="layerid" id="layerid" type="hidden" value=""></div></td>
  </tr>
  