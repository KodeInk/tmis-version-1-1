<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": For Business";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
	
	<?php 
	echo get_ajax_constructor(TRUE);
	 
	echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:100italic,100,300italic,300,400italic,400,500italic,500,700italic,700,900italic,900\" rel=\"stylesheet\" type=\"text/css\">
";?>
<style>


.promotionsadbg {
	background: url(<?php echo base_url();?>assets/images/promotionsad_bg.png) no-repeat center bottom;
	margin:0px;
	width: 100%;
}

.rewardsloyaltybg {
	background: url(<?php echo base_url();?>assets/images/rewardsloyalty_bg.png) no-repeat center bottom;
	margin:0px;
	width: 100%;
}

.customergenerationbg {
	background: url(<?php echo base_url();?>assets/images/customer_generation_bg.png) no-repeat center bottom;
	margin:0px;
	width: 100%;
}

.nohardwarebg {
	background: url(<?php echo base_url();?>assets/images/white_no_hardware_icon.png) no-repeat left center;
	padding-left:40px;
	height: 40px;
	min-width: 200px;
	margin: 15px;
	cursor:pointer;
}


.notrainingbg {
	background: url(<?php echo base_url();?>assets/images/white_favorite_icon.png) no-repeat left center;
	padding-left:40px;
	height: 40px;
	min-width: 200px;
	margin: 15px;
	cursor:pointer;
}


.lowmaitenancebg {
	background: url(<?php echo base_url();?>assets/images/white_settings_icon.png) no-repeat left center;
	padding-left:40px;
	height: 40px;
	min-width: 200px;
	margin: 15px;
	cursor:pointer;
}


.automaticacquisitionbg {
	background: url(<?php echo base_url();?>assets/images/white_refresh_icon.png) no-repeat left center;
	padding-left:40px;
	height: 40px;
	min-width: 200px;
	margin: 15px;
	cursor:pointer;
}


.securebg {
	background: url(<?php echo base_url();?>assets/images/white_secure_icon.png) no-repeat left center;
	padding-left:40px;
	height: 40px;
	min-width: 200px;
	margin: 15px;
	cursor:pointer;
}


.riskfreebg {
	background: url(<?php echo base_url();?>assets/images/white_tick_icon.png) no-repeat left center;
	padding-left:40px;
	height: 40px;
	min-width: 200px;
	margin: 15px;
	cursor:pointer;
}


</style>

<script type="text/javascript">
$(document).ready(function() {
   var windowHeight =  $( window ).height(); 
   $('.pagecontentarea').css('height', (windowHeight - 180));
});


$(window).bind('resize',function(){
     window.location.href = window.location.href;
});


</script>
</head>

<body style="margin: 0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="greybodybg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>
<div class="fadinglinebottom"><table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="5%"><table border="0" cellspacing="0" cellpadding="0"><tr><td><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo_white.png" border="0"></a></td><td style="padding-left:15px; vertical-align:bottom;" nowrap><span class="robototext whitebigtext">For Business</span></td></tr></table></td>
    <td width="80%">&nbsp;</td>
    <td width="5%"><a href="<?php echo base_url();?>web/account/login" class="robototext whitebigtext">Login</a></td>
    <td width="5%">&nbsp;</td>
  </tr>
</table>
</div>
</td></tr>

<tr><td class="customersbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="pagecontentarea"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" style="padding-top:45px;"><img src="<?php echo base_url();?>assets/images/reach_customers_header.png">
    <br>
   <span class="robototext whitebigtext">Target who you want, when you want. It’s
simple and risk-free.<span></td>
  </tr>
  <tr>
    <td align="center" style="padding-top:20px;padding-bottom:20px;"><input type='button' class='fadedbtn bluefade' name='starttrial' id='starttrial' value='Start the 6 Month Trial' onClick="document.location.href='<?php echo base_url();?>web/account/merchant_signup'"></td>
  </tr>
  <tr>
    <td align="center" class="bodytabcontent" style="padding-top:20px;padding-bottom:0px;"><div id="customer_generation" class="currentbodytabcell jumper" onClick="updateTabColors('customer_generation','currentbodytabcell','bodytabcell');showHideOnCondition('promotions_advertising_details<>rewards_loyalty_details', 'customer_generation_details', '')"><img src='<?php echo base_url();?>assets/images/customer_generation.png' border='0'></div><div id="promotions_advertising" class="bodytabcell jumper" onClick="updateTabColors('promotions_advertising','currentbodytabcell','bodytabcell');showHideOnCondition('customer_generation_details<>rewards_loyalty_details', 'promotions_advertising_details', '')"><img src='<?php echo base_url();?>assets/images/promotions_ad.png' border='0'></div><div id="rewards_loyalty" class="bodytabcell jumper" onClick="updateTabColors('rewards_loyalty','currentbodytabcell','bodytabcell');showHideOnCondition('customer_generation_details<>promotions_advertising_details', 'rewards_loyalty_details', '')"><img src='<?php echo base_url();?>assets/images/rewards_loyalty.png' border='0'></div></td>
  </tr>
  <tr>
    <td align="center" style="padding-top:0px;padding-bottom:10px;height:350px;"><div id="customer_generation_details" class="customergenerationbg robototext whitebigtext" style="display:block;"><div style="width:50%;">Clout automatically generates customers who shop at your store, 
shop at your competitors, buy similiar products, live nearby and more.</div><div style="padding-top:230px;"></div></div>
    
    <div id="promotions_advertising_details" class="promotionsadbg robototext whitebigtext" style="display:none;"><div style="width:50%;">Deliver user specific offers, promotions, perks, and 
advertisements to millions of customers with one click.</div><div style="padding-top:230px;"></div></div>
	
    <div id="rewards_loyalty_details" class="rewardsloyaltybg robototext whitebigtext" style="display:none;"><div style="width:50%;">Clout's FREE loyalty system allows you to create custom programs to automatically reward customers who mean the most to your business.</div><div style="padding-top:230px;"></div></div></td>
  </tr>
  
  
</table></td>
  </tr>
  <tr><td><div class="translucentbg robototext whitebigtext" style="line-height:55px;cursor:pointer;" onClick="scrollToAnchor('start_trial')">Learn More</div></td></tr>
</table>

</td></tr>
</table></td>
  </tr>
  <tr>
    <td class="greybodybg"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td align="center" class="pagecontentarea">
    <div style="padding-top:30px;padding-bottom:10px; display:block;" id="breakdown_div">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><img src="<?php echo base_url();?>assets/images/break_down_header.png">
    
 <table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" style="padding-bottom:5px;height:180px;">
<div id="no_hardware_details" style="display:block;width:50%;"><span class="robototext whitebigtext">No special hardware or software is required.  Clout rides on top of the credit/debit card registered by Clout users.  There’s no need to conncect to your system or access your data.  <span></div>

<div id="no_training_details" style="display:none;width:50%;"><span class="robototext whitebigtext">Since the customer and your staff are using the same cards and 
same payment terminals they already use, there’s absolutely 
nothing to teach.  All the systems are already in place. <span></div>

<div id="low_maitenance_details" style="display:none;width:50%;"><span class="robototext whitebigtext">Our "Set-it-and-forget-it" approach means you can configure your programs one time, and let our system do the rest. 
Simply create a campaign with our one-click ad/promotion/reward 
publishing system and let the customers flow!  <span></div>

<div id="automatic_acquisition_details" style="display:none;width:50%;"><span class="robototext whitebigtext">Eliminate the need to enter customer data by hand.  With Clout, 
your existing and target customer information is always up to date, and customers are always informed of your promotions. <span></div>

<div id="completely_secure_details" style="display:none;width:50%;"><span class="robototext whitebigtext">Your information belongs to you.  Since we have no need to touch your 
data or integrate with your systems, security is never an issue. 
Our analytics come from bank linked cards.<span></div>

<div id="risk_free_details" style="display:none;width:50%;"><span class="robototext whitebigtext">During your free trial you’ll have full use of our loyalty and reward program. Many of our services are always free, and the ones that aren’t are risk free and pay as you go. Claim or create your business account to see how many customers we have waiting for you.<span></div>
    </td>
  </tr>
  
  <tr>
    <td align="center">
    <table>
    <tr>
    <td align="left">
    <div id="no_hardware_div" class="nofade nohardwarebg robototext whitebigtext" onClick="updateTabColors('no_hardware_div','nofade','halfpercentfade');showHideOnCondition('no_training_details<>low_maitenance_details<>low_maitenance_details<>automatic_acquisition_details<>completely_secure_details<>risk_free_details', 'no_hardware_details', '')">No Hardware</div>
    
    <div id="no_training_div" class="halfpercentfade notrainingbg robototext whitebigtext" onClick="updateTabColors('no_training_div','nofade','halfpercentfade');showHideOnCondition('no_hardware_details<>low_maitenance_details<>low_maitenance_details<>automatic_acquisition_details<>completely_secure_details<>risk_free_details', 'no_training_details', '')">No Training</div>
    
    <div id="low_maitenance_div" class="halfpercentfade lowmaitenancebg robototext whitebigtext" onClick="updateTabColors('low_maitenance_div','nofade','halfpercentfade');showHideOnCondition('no_hardware_details<>no_training_details<>low_maitenance_details<>automatic_acquisition_details<>completely_secure_details<>risk_free_details', 'low_maitenance_details', '')">Low Maitenance</div>
    </td>
    <td align="left" style="padding-left:30px;">
    <div id="automatic_acquisition_div" class="halfpercentfade automaticacquisitionbg robototext whitebigtext" onClick="updateTabColors('automatic_acquisition_div','nofade','halfpercentfade');showHideOnCondition('no_hardware_details<>no_training_details<>low_maitenance_details<>low_maitenance_details<>completely_secure_details<>risk_free_details', 'automatic_acquisition_details', '')">Automatic Acquisition</div>
    
    <div id="completely_secure_div" class="halfpercentfade securebg robototext whitebigtext" onClick="updateTabColors('completely_secure_div','nofade','halfpercentfade');showHideOnCondition('no_hardware_details<>no_training_details<>low_maitenance_details<>low_maitenance_details<>automatic_acquisition_details<>risk_free_details', 'completely_secure_details', '')">Completely Secure</div>
    
    <div id="risk_free_div" class="halfpercentfade riskfreebg robototext whitebigtext" onClick="updateTabColors('risk_free_div','nofade','halfpercentfade');showHideOnCondition('no_hardware_details<>no_training_details<>low_maitenance_details<>low_maitenance_details<>automatic_acquisition_details<>completely_secure_details', 'risk_free_details', '')">Risk Free</div>
    </td>
  </tr>
    </table>
    </td>
  </tr>
 </table>
 
 
</td>
  </tr>
  
  
  <tr>
    <td align="center" style="padding-top:20px;padding-bottom:20px;"><input type='button' class='fadedbtn bluefade' name='starttrial' id='starttrial' value='Start the 6 Month Trial' onClick="document.location.href='<?php echo base_url();?>web/account/merchant_signup'"> <span class="robototext whitebigtext"> &nbsp;&nbsp; or &nbsp;&nbsp; </span> <input type='button' class='fadedbtn purplefade' name='starttrial' id='starttrial' value='Contact Us Today'>
      <a id="start_trial"></a></td>
  </tr>
  
  
  </table>
    
    </div>
    </td>
  </tr>
    <tr><td>
<?php $this->load->view('web/addons/footer_public', array('area'=>'business'));?>
</td></tr>
    </table></td>
  </tr>
</table>






</body>
</html>