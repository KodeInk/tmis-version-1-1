<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": For Agents";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
	
	<?php 
	echo get_ajax_constructor(TRUE);
	 
	echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
<style>
.easytosellbg {
	background: url(<?php echo base_url();?>assets/images/easy_to_sell_bg.png) repeat-x center bottom;
	margin:0px;
	width: 100%;
}

.bigdemandbg {
	background: url(<?php echo base_url();?>assets/images/big_demand_bg.png) repeat-x center bottom;
	margin:0px;
	width: 100%;
}

.aggressivecompesationbg {
	background: url(<?php echo base_url();?>assets/images/aggressive_compesation_bg.png) no-repeat center bottom;
	margin:0px;
	width: 100%;
}

</style>

<script type="text/javascript">
$(document).ready(function() {
   var windowHeight = $(document).height(); 
   $('#pagecontentarea').css('height', (windowHeight - 125));
});


$(window).bind('resize',function(){
     window.location.href = window.location.href;
});

$(document).ready(function() {
	 $(".jumper").on("click", function( e ) {

        e.preventDefault();

        $("body, html").animate({ 
            scrollTop: $('#'+$(this).attr('data-rel') ).offset().top 
        }, 600);

    }); 
});
</script>
</head>

<body class="bluebodybg">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>
<div class="fadinglinebottom"><table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="5%"><table border="0" cellspacing="0" cellpadding="0"><tr><td><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo_white.png" border="0"></a></td>
    <td style="padding-left:15px; vertical-align:bottom;" nowrap><span class="robototext whitebigtext">For Agents</span></td></tr></table></td>
    <td width="80%">&nbsp;</td>
    <td width="5%"><a href="<?php echo base_url();?>web/account/login" class="robototext whitebigtext">Login</a></td>
    <td width="5%">&nbsp;</td>
  </tr>
</table>
</div>
</td></tr>

<tr><td class="customersbg easytosellbg" id="pagecontentarea"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" style="padding-top:45px;"><img src='<?php echo base_url();?>assets/images/join_clout_team.png' border='0'>
    <br>
   <span class="robototext whitebigtext">Get local businesses to sign up, manage those <br>accounts, and make money. It's that easy.<span></td>
  </tr>
  <tr>
    <td align="center" style="padding-top:20px;padding-bottom:20px;"><input type='button' class='fadedbtn bluefade' name='starttrial' id='starttrial' value='Apply Today'></td>
  </tr>
  <tr>
    <td align="center" class="bodytabcontent" style="padding-top:20px;padding-bottom:0px;"><div id="customer_generation" class="currentbodytabcell jumper" onClick="updateTabColors('customer_generation','currentbodytabcell','bodytabcell');updateTabColors('pagecontentarea','easytosellbg','bigdemandbg aggressivecompesationbg');showHideOnCondition('promotions_advertising_details<>rewards_loyalty_details', 'customer_generation_details', '')"><img src='<?php echo base_url();?>assets/images/easy_to_sell.png' border='0'></div><div id="promotions_advertising" class="bodytabcell jumper" onClick="updateTabColors('promotions_advertising','currentbodytabcell','bodytabcell');updateTabColors('pagecontentarea','bigdemandbg','easytosellbg aggressivecompesationbg');showHideOnCondition('customer_generation_details<>rewards_loyalty_details', 'promotions_advertising_details', '')"><img src='<?php echo base_url();?>assets/images/big_demand.png' border='0'></div><div id="rewards_loyalty" class="bodytabcell jumper" onClick="updateTabColors('rewards_loyalty','currentbodytabcell','bodytabcell');updateTabColors('pagecontentarea','aggressivecompesationbg','easytosellbg bigdemandbg');showHideOnCondition('customer_generation_details<>promotions_advertising_details', 'rewards_loyalty_details', '')"><img src='<?php echo base_url();?>assets/images/aggressive_compesation.png' border='0'></div></td>
  </tr>
  <tr>
    <td align="center" style="padding-top:0px;padding-bottom:0px;height:330px; margin-bottom:0px;"><div id="customer_generation_details" class="robototext whitebigtext" style="display:block;"><div style="width:50%;">Free access to new customers is something every business wants. It’s simple to pitch, and easy to sign. Our no hardware, no software, no training approach means saying YES to Clout is easy.</div><div style="padding-top:230px;"></div></div>
    
    <div id="promotions_advertising_details" class="robototext whitebigtext" style="display:none;"><div style="width:50%;">Our ability to reach and reward customers based on what, 
when, where, and how much they spend appeals to every size business.<BR><BR></div><div style="padding-top:230px;"></div></div>
	
    <div id="rewards_loyalty_details" class="robototext whitebigtext" style="display:none;"><div style="width:50%;">With the ability to collect aggressive ongoing commissions 
on the businesses you sign, life as a Clout sales agent 
can be extremely rewarding.</div><div style="padding-top:230px;"></div></div></td>
  </tr>
</table>
</td></tr>

<tr><td>
<?php $this->load->view('web/addons/footer_public', array('area'=>'agents'));?>
</td></tr>
</table>





</body>
</html>