<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo SITE_TITLE.": Dashboard";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
     <?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
     
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fancybox.css" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.pack.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function() {
  	 	$('.fancybox').fancybox();
	});
	</script>

	<?php 
		echo get_ajax_constructor(TRUE);
	?>
</head>
<body>
<table width="700" border="0" align="center" cellpadding="10" cellspacing="0" class="bodytable">
    <tr>
      <td style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="pageheading" style="padding-left:0px;"><?php echo !empty($_SESSION['merchant_details']['merchant_name'])?$_SESSION['merchant_details']['merchant_name']: "";?> Dashboard</td>
          <td width="1%" align="right" valign="top" style="padding-right:5px; padding-top:8px;" nowrap><?php echo "<b>".$_SESSION['first_name']." ".$_SESSION['last_name']."</b>";?> &nbsp;|&nbsp; <a href="<?php echo base_url()."web/account/logout";?>">Logout</a></td>
          <td width="1%"><img src="<?php echo base_url();?>assets/images/user_icon.png" border="0"></td>
        </tr>
      </table></td>
    </tr>
    <?php
	if(!empty($msg))
	{
		echo "<tr><td>".format_notice($msg)."</td></tr>";
	}
	?>
    <tr>
      <td><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Your Merchant Score is <b style="font-size:17px;"><?php echo $_SESSION['merchant_details']['merchant_score'];?></b> </td>
    <td style="padding-left:15px;padding-right:4px;"><a href="javascript:void(0);" onClick="updateFieldLayer('<?php echo base_url()."web/score/show_score_origins/v/".encrypt_value('top')."/l/".encrypt_value('1')."/u/".encrypt_value($_SESSION['userId'])."/t/".encrypt_value('merchant_score');?>','','','merchant_level_1_details','')">Show generation details</a></td>
    <td onClick="updateFieldLayer('<?php echo base_url()."web/score/show_score_origins/v/".encrypt_value('top')."/l/".encrypt_value('1')."/u/".encrypt_value($_SESSION['userId'])."/t/".encrypt_value('merchant_score');?>','','','merchant_level_1_details','')"><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/search_icon.png" border="0"></a></td>
    
    <td style="padding-left:40px;"><a href="javascript:void(0);" onClick="updateFieldLayer('<?php echo base_url()."web/score/show_score_origins/v/".encrypt_value('top')."/l/".encrypt_value('0')."/u/".encrypt_value($_SESSION['userId'])."/t/".encrypt_value('merchant_score');?>','','','merchant_level_0_details','')">RE-CALCULATE</a></td>
    
    <td><div id="merchant_level_0_details"></div></td>
  </tr>
</table>
</td>
    </tr>
    <tr>
      <td style="padding-top:0px;"><div id="merchant_level_1_details" style="max-height:450px; overflow:auto;"></div></td>
    </tr>
    
  </table><input name="layerid" id="layerid" type="hidden" value="">

</body>
</html>