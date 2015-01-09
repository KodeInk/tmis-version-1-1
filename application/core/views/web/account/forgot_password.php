<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");

#Instantiate required fields variable if not given
$requiredFields = empty($requiredFields)? array(): $requiredFields;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Forgot Password";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
     <?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10" style="border-bottom: 2px #B3B3B3 solid;">
      <tr>
        <td><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo_black.png" border="0"></a></td>
        <td>&nbsp;</td>
        <td align="right"><a href="<?php echo base_url();?>web/account/login" class="whiteheadertitle">Login</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="padding-top:80px; padding-bottom: 30px; text-align:center;">
    <form action="<?php echo base_url()."web/account/forgot_password";?>" method="post">
    <table border="0" cellspacing="0" cellpadding="10" align="center">
      
    
    <?php 
	if(!empty($linkIsSent) && $linkIsSent)
	{
	?>	
	<tr>
        <td colspan="2" class="contentheading" style="padding-bottom:20px;">Your New Password</td>
        </tr>
      <?php
	if(!empty($msg))
	{
		echo "<tr><td colspan='2' style='padding-top:10px;padding-bottom:0px;'>".format_notice($msg)."</td></tr>";
		
	}
	?>
    <tr>
        <td colspan="2" class="label" style="padding-top:30px;">Enter a password with a minimum of 8 characters and at least one number.</td>
      </tr> 
      <tr>
        <td colspan="2" align="center">
        <table cellpadding="5">
        <tr><td>
        <?php	echo get_required_field_wrap($requiredFields, 'newpassword', 'start', 'A valid password is atleast 8<br> characters and contains a <br>number.');?><input name="newpassword" type="password" class="textfield" id="newpassword" placeholder="New Password" size="35" style="width:200px;" maxlength="100" value=""><?php echo get_required_field_wrap($requiredFields, 'newpassword', 'end');?></td></tr>
        
        <tr><td>
        <?php	echo get_required_field_wrap($requiredFields, 'repeatpassword', 'start', 'Passwords should match.');?><input name="repeatpassword" type="password" class="textfield" id="repeatpassword" placeholder="Repeat Password" size="35" style="width:200px;" maxlength="100" value=""><?php echo get_required_field_wrap($requiredFields, 'repeatpassword', 'end');?></td></tr>
        <tr>
        <td style="padding-top:15px;"><input type="submit" name="updatepassword" id="updatepassword" class="purplebtn" style="width:218px;" value="Submit"><input id="cloutid" name="cloutid" type="hidden" value="<?php echo $cloutId;?>"></td>
        </tr>
        </table>
        </td>
      </tr>
		
	<?php 
	}
	else 
	{
	?>
    <tr>
        <td colspan="2" class="contentheading" style="padding-bottom:20px;">Forgot Your Password?</td>
        </tr>
      <?php
	if(!empty($msg))
	{
		echo "<tr><td colspan='2' style='padding-top:10px;padding-bottom:0px;'>".format_notice($msg)."</td></tr>";
		
	}
	?>
    <tr>
        <td colspan="2" class="label" style="padding-top:40px;">Please provide your registered email address below to reset your password.</td>
      </tr> 
      <tr>
        <td colspan="2" align="center">
        <table>
        <tr><td>
        <?php	echo get_required_field_wrap($requiredFields, 'emailaddress');?><input name="emailaddress" type="text" class="textfield" id="emailaddress" placeholder="Email" size="35" style="width:200px;" maxlength="100" value="<?php echo !empty($formData['emailaddress'])? $formData['emailaddress']: '';?>"><?php echo get_required_field_wrap($requiredFields, 'emailaddress', 'end');?></td>
        <td><input type="submit" name="sendlink" id="sendlink" class="purplebtn" style="width:150px;" value="Send Link"></td>
        </tr>
        </table>
        </td>
      </tr>
      
      <?php }?>
      
      
      
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>