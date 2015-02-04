<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">

<title><?php echo SITE_TITLE;?>: Contact Us</title>

<!-- Stylesheets -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.mobile.css" media="(max-width:790px)" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.tablet.css" media="(min-width:791px) and (max-width: 900px)" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.desktop.css" media="(min-width:901px)" />

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.list.css"/>

<!-- Javascript -->
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-2.1.1.min.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.form.js'></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.fileform.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.responsive.js"></script> 

</head>

<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view("addons/public_header", array("page"=>"contact_us"));?>
  <tr>
    <td valign="top" colspan="2" class="bodyspace">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td class="h1 grey">Contact Us</td>
     </tr>
     <tr>
      <td style="text-align:center;"><div style="display:inline-block;"><form method="post" autocomplete="off" action="<?php echo base_url();?>page/contact_us" class='simplevalidator' ><table border="0" cellspacing="0" cellpadding="10">
<?php
if(!empty($result) && $result){
	echo "<tr><td style='padding-bottom:100px;'>".format_notice($this, $msg)."</td></tr>";
} else {
	echo !empty($msg)? "<tr><td colspan='2'>".format_notice($this, $msg)."</td></tr>": "";
?>
  
  <tr>
    <td class="label">Your Name: </td>
    <td><input type="text" id="yourname" name="yourname" class="textfield" value="" maxlength="100"/></td>
  </tr>
  <tr>
    <td class="label">Email Address: </td>
    <td><input type="text" id="emailaddress" name="emailaddress" class="textfield email" value="" maxlength="100"/></td>
  </tr>
  <tr>
    <td class="label">Telephone: </td>
    <td><input type="text" id="telephone" name="telephone" placeholder="Optional (e.g: 0782123456)" class="textfield numbersonly telephone optional" value="" maxlength="10"/></td>
  </tr>
  <tr>
    <td class="label">Reason: </td>
    <td><input type="text" id="reason__contactreason" name="reason__contactreason" placeholder="Enter or Select reason" class="textfield selectfield editable"/></td>
  </tr>
  <tr>
    <td class="label" valign="top">Message: </td>
    <td><textarea id="message" name="message" placeholder="Enter your message here" class="textfield" style="height:120px;"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:right;"><button type="submit" class="btn" id="submitmessage" value-'send' name="submitmessage" style="width:238px;">SEND</button></td>
  </tr>
<?php }?>
      </table>
      </form></div></td>
     </tr>
     </table>
    </td>
  </tr>
  <?php $this->load->view("addons/public_footer", array("page"=>"contact_us"));?>
</table>


</body>
</html>