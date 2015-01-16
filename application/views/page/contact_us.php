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
      <td style="text-align:center;"><div style="display:inline-block;"><form id="tmiscontact" method="post" autocomplete="off" ><table border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td class="label">Your Name: </td>
    <td><input type="text" id="yourname" name="yourname" class="textfield" value="" maxlength="100"/></td>
  </tr>
  <tr>
    <td class="label">Email Address: </td>
    <td><input type="text" id="emailaddress" name="emailaddress" class="textfield" value="" maxlength="100"/></td>
  </tr>
  <tr>
    <td class="label">Telephone: </td>
    <td><input type="text" id="telephone" name="telephone" placeholder="Optional" class="textfield" value="" maxlength="100"/></td>
  </tr>
  <tr>
    <td class="label">Reason: </td>
    <td><select id="reason" name="reason"><?php echo get_option_list($this,"contact_us","option");?></select></td>
  </tr>
  <tr>
    <td class="label" valign="top">Message: </td>
    <td><textarea id="message" name="message" placeholder="Enter your message here" class="textfield" style="height:120px;"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:right;"><button type="button" class="greybtn" id="submitmessage" name="submitmessage" style="width:340px;">SUBMIT</button></td>
  </tr>
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