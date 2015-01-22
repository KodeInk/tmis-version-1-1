<?php $msg = empty($msg)? get_session_msg($this): $msg; ?>
<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">

<title><?php echo SITE_TITLE;?>: My Settings</title>

<!-- Stylesheets -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.mobile.css" media="(max-width:790px)" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.tablet.css" media="(min-width:791px) and (max-width: 900px)" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.desktop.css" media="(min-width:901px)" />

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.list.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.menu.css"/>

<!-- Javascript -->
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-2.1.1.min.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.form.js'></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.fileform.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.menu.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.responsive.js"></script> 

</head>

<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view("addons/secure_header", array('page'=>'my_settings'));?>
  <tr>
    <td valign="top" colspan="2" class="bodyspace">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td id="menucontainer"><?php $this->load->view("addons/menu", array('clear_menu'=>'Y'));?></td>
        <td style="padding-left:15px;padding-top:15px; vertical-align:top;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
      		<?php echo !empty($msg)?"<tr><td>".format_notice($this,$msg)."</td></tr>": "";?>
            <tr><td style="vertical-align:middle;"><div class="nextdiv h1 grey">My Settings</div><div class="nextdiv editcontenticon editcontent"></div></td></tr>
            <tr><td>
            
            
            <form id="user_data" method="post" autocomplete="off" action="<?php echo base_url();?>profile/user_data" class='simplevalidator'>
            <table border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td class="label">User Name:</td>
    <td class='value'><?php echo $this->native_session->get('profile_loginname');?></td>
  </tr>
  <tr>
    <td class="label">Current Role:</td>
    <td class='value'><?php echo $this->native_session->get('profile_userrole');?></td>
  </tr>
  <tr>
    <td class="label">Current Password:</td>
    <td><div class="viewdiv value">*********</div><div class="editdiv"><input type="password" id="currentpassword" name="currentpassword" title="Current Password" placeholder="Current Password" maxlength="100" class="textfield optional" value=""/></div></td>
  </tr>
  <tr>
    <td class="label editdiv">New Password:</td>
    <td><div class="nextdiv"><div class="editdiv"><input type="password" id="newpassword" name="newpassword" title="New Password" placeholder="New Password" maxlength="100" class="textfield optional" value=""/></div></div><div class="nextdiv"><div class="editdiv"><input type="password" id="repeatpassword" name="repeatpassword" title="Repeat New Password" placeholder="Repeat New Password" maxlength="100" class="textfield optional" value=""/></div></div>
    <div class="editdiv smalltext">Your password should be at least 6 characters long with a letter and a number.</div>
    </td>
  </tr>
  <tr>
    <td class="label">Surname:</td>
    <td><div class="viewdiv value"><?php echo $this->native_session->get('profile_lastname');?></div><div class="editdiv"><input type="text" id="lastname" name="lastname" title="Surname" class="textfield" value="<?php echo $this->native_session->get('profile_lastname');?>"/></div></td>
  </tr>
  <tr>
    <td class="label">Other Names:</td>
    <td><div class="viewdiv value"><?php echo $this->native_session->get('profile_firstname');?></div><div class="editdiv"><input type="text" id="firstname" name="firstname" title="Other Names" class="textfield" value="<?php echo $this->native_session->get('profile_firstname');?>"/></div></td>
  </tr>
  <tr>
    <td class="label">Telephone:</td>
    <td><div class="viewdiv value"><?php echo ($this->native_session->get('profile_telephone')? $this->native_session->get('profile_telephone'): '&nbsp;');?></div><div class="editdiv"><input type="text" id="telephone" name="telephone" title="Telephone" placeholder="Optional" maxlength="16" class="textfield numbersonly optional" value="<?php echo ($this->native_session->get('profile_telephone')? $this->native_session->get('profile_telephone'): '');?>"/></div></td>
  </tr>
  <tr>
    <td class="label">Email Address:</td><td class="value"><?php echo $this->native_session->get('profile_emailaddress');?></td>
  </tr>
  <tr>
    <td class="label">&nbsp;</td>
    <td class="editdiv"><button type="submit" name="save" id="save" class="btn">SAVE</button></td>
  </tr>
            </table>
            </form>
            
            </td></tr>
        </table></td>
      </tr>
     </table>
    </td>
  </tr>
  <?php $this->load->view("addons/secure_footer");?>
</table>


</body>
</html>