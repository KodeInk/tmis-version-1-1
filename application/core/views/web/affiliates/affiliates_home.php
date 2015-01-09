<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": For Affiliates";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
	
	<?php 
	echo get_ajax_constructor(TRUE);
	 
	echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
<style>



.homeimg {
	background: url(<?php echo base_url();?>assets/images/affiliate_home_img.png) no-repeat center bottom;
	height: 100%;
	margin:0px;
}

.leftcardimg {
	background: url(<?php echo base_url();?>assets/images/left_card_img.png) no-repeat left bottom;
	height: 100%;
	margin:0px;
	width:120px;
}

.rightcardimg {
	background: url(<?php echo base_url();?>assets/images/right_card_img.png) no-repeat right bottom;
	height: 100%;
	margin:0px;
	width:120px;
}



</style>

<script type="text/javascript">
$(document).ready(function() {
   var windowHeight = $(document).height(); 
   $('.homeimg').height(windowHeight - 125);
   $('.leftcardimg').height(windowHeight - 125);
   $('.rightcardimg').height(windowHeight - 125);
   $('#pagecontentarea').css('min-height', (windowHeight - 125)+'px'); 
   
   //Make the image contained on smaller screens
   if(windowHeight < 700)
   {
	   $('.homeimg').css('background-size', 'contain');
   }
});


$(window).bind('resize',function(){
     window.location.href = window.location.href;
});
</script>
</head>

<body class="redbodybg">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>
<div class="fadinglinebottom"><table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="5%"><table border="0" cellspacing="0" cellpadding="0"><tr><td><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo_white.png" border="0"></a></td><td style="padding-left:15px; vertical-align:bottom;" nowrap><span class="robototext whitebigtext">For Affiliates</span></td></tr></table></td>
    <td width="80%">&nbsp;</td>
    <td width="5%"><a href="<?php echo base_url();?>web/account/login" class="robototext whitebigtext">Login</a></td>
    <td width="5%">&nbsp;</td>
  </tr>
</table>
</div>
</td></tr>

<tr><td align="center" id="pagecontentarea"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%"><div class="leftcardimg">
</div></td>
    <td width="98%"><div class="homeimg" onClick="document.location.href='<?php echo base_url();?>web/account/signup'" style="cursor:pointer;">
</div></td>
    <td width="1%"><div class="rightcardimg">
</div></td>
  </tr>
</table>
</td></tr>

<tr><td>
<?php $this->load->view('web/addons/footer_public', array('area'=>'affiliates'));?>
</td></tr>
</table>





</body>
</html>