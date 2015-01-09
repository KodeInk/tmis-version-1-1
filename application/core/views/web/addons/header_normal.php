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
			content: "<table width='100%' cellpadding='5'><tr><td><img src='<?php echo base_url()."assets/uploads/images/".(!empty($_SESSION['photo_url'])? $_SESSION['photo_url']: 'anonymous.png');?>'></td><td ><?php echo "<b style='font-size:18px;'>".$this->native_session->get('first_name')." ".$this->native_session->get('last_name')."</b><br>Logged in as: <b style='font-size:13px;'>User</b>";?></td></tr><tr><td colspan='2'><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td><a href='javascript:;'><input type='button' name='mysettings' id='mysettings' value='my settings' class='otherbtn'></a></td><td align='right' style='padding-left:20px;'><a href='<?php echo base_url();?>web/account/logout'><input type='button' name='logout' id='logout' value='logout' class='otherbtn'></a></td></tr><?php if($this->native_session->get('pending_merchant_application')){?><tr><td colspan='2' style='padding-top:10px;'><a href='<?php echo base_url();?>web/account/complete_merchant_application'><input type='button' name='completeapplication' id='completeapplication' value='complete merchant application' class='otherbtn' style='width:330px;'></a></td></tr><?php }?></table></td></tr></table></td></tr></table>"
			});
	});
	
	</script>

<tr>
    <td style="background-color:#000; height:46px;"><div class='stickyheader'><table width="100%" border="0" cellspacing="0" cellpadding="10" class="menutable">
      <tr>
        
        <td id="menu_search" <?php echo ($main=='search')? " class='activemenu'":"";?> style="width:120px;" onclick="document.location.href='<?php echo base_url();?>web/search/show_search_home'"><a href="javascript:void(0);">Search</a></td>
        
        <td id="menu_favorites" <?php echo ($main=='favorites')? " class='activemenu'":"";?> style="width:120px;" onclick="document.location.href='<?php echo base_url();?>web/favorites/show_favorites_home'"><a href="javascript:void(0);">Favorites</a></td>
        <td id="menu_network" <?php echo ($main=='network')? " class='activemenu'":"";?> onclick="document.location.href='<?php echo base_url();?>web/network/show_network_home'" nowrap><a href="javascript:void(0);" style="width:120px;">Network</a></td>
        
        <td id="menu_money" <?php echo ($main=='money')? " class='activemenu'":"";?> style="width:120px;" onclick="document.location.href='<?php echo base_url();?>web/money/show_money_home'"><a href="javascript:void(0);">Money</a></td>
        
        
        
        <td style="width:30%;border-top: solid 4px #000; cursor:default;">&nbsp;</td>
        <td align="center"  nowrap style="padding-left:40px; padding-right:40px;" id="user_pop"><img src="<?php echo base_url();?>assets/images/down_arrow_lightgrey.png" border="0"/> &nbsp;<a href="javascript:void(0);"><?php echo "<b>".$this->native_session->get('first_name')." ".$this->native_session->get('last_name')."</b>";?></a>
</td>
        <td style="padding:0px; padding-left:30px; padding-right:30px; width:1%; height:40px; text-align:center;"><a href="<?php echo base_url()."web/account/normal_dashboard";?>"><img src="<?php echo base_url();?>assets/images/logo.png" border="0" height="18"/></a></td>
      </tr>
    </table><input name="layerid" id="layerid" type="hidden" value=""></div></td>
  </tr>
  