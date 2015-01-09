<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": FAQs";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
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
	 	#Get the nice thin fonts needed for the Clout "look"
	    echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";
	?>
        
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view('web/addons/header_normal', array('main'=>'help', 'sub'=>'FAQs', 'defaultHtml'=>''));?>
  
  <tr>
    <td style="background: url(<?php echo base_url();?>assets/images/faqs.png) no-repeat center top #F1F1F1; width:100%; background-size: 100% auto;"><div id="bodycell" style="text-align:left;">&nbsp;</div></td>
  </tr>
  <tr>
    <td style="padding-bottom:20px;">&nbsp;</td>
  </tr>
  <?php $this->load->view('web/addons/footer_normal');?>
</table>

</body>
</html>