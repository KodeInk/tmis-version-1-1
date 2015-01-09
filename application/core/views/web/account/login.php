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
	<title><?php echo SITE_TITLE.": Login";?></title>
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
    <form action="<?php echo base_url()."web/account/login".(!empty($t)? '/t/'.$t: '');?>" method="post">
    <table border="0" cellspacing="0" cellpadding="10" align="center">
      
    
      <tr>
        <td colspan="2" class="contentheading" style="padding-bottom:20px;">Welcome</td>
        </tr>
      <tr>
        <td colspan="2" class="label" style="padding-top:40px;">Please login below to get started:</td>
        </tr>
        <?php
	if(!empty($msg))
	{
		echo "<tr><td colspan='2' style='padding-top:10px;padding-bottom:0px;'><div id='msg_div'>".format_notice($msg)."</div></td></tr>";
		
	}
	?>
      <tr>
        <td colspan="2" align="center">
        
        <table>
        <tr><td>
        <?php	echo get_required_field_wrap($requiredFields, 'username');?><input name="username" type="text" class="textfield" id="username" placeholder="Email" size="35" style="width:200px;" maxlength="100" value="<?php echo !empty($formData['username'])? $formData['username']: '';?>"><?php echo get_required_field_wrap($requiredFields, 'username', 'end');?></td>
        <td style="padding-left:10px;"><?php	echo get_required_field_wrap($requiredFields, 'password');?><input name="password" type="password" class="textfield" id="password" placeholder="Password" size="35" style="width:200px;" maxlength="100"><?php echo get_required_field_wrap($requiredFields, 'password', 'end');?>
        </td></tr>
        </table>
        </td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="login" id="login" class="greenbtn" style="width:150px;" value="Log In"><?php echo (!empty($t)? "<input id='specialaction' name='specialaction' type='hidden' value='".decrypt_value($t)."'>": '');?></td>
        </tr>
      <tr>
        <td colspan="2"><a href="<?php echo base_url(); ?>web/account/forgot_password" class="bluelink">Forgot Password?</a></td>
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