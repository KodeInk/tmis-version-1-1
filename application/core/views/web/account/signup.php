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
	<title><?php echo SITE_TITLE.": Signup";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
<script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

 <?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";
 
 echo get_ajax_constructor(TRUE);
 ?>
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10" style="border-bottom: 2px #B3B3B3 solid;">
      <tr>
        <td><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo_black.png" border="0"></a></td>
        <td>&nbsp;</td>
        <td align="right"><?php 
		if($this->native_session->get('userId'))
		{
			echo "<a href='".base_url()."web/account/normal_dashboard' class='whiteheadertitle'>Dashboard</a>";
		}
		else
		{
			echo "<a href='".base_url()."web/account/login' class='whiteheadertitle'>Login</a>"; 
		}
		?><input name="layerid" id="layerid" type="hidden" value=""></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="padding-top:80px; padding-bottom: 30px; text-align:center;">
    <?php
    if(!empty($signup_confirmation))
	{
		
		
		if(empty($signupError))
		{
		?>
		<table border="0" cellspacing="0" cellpadding="10" align="center">
      
      <tr>
        <td class="contentheading" style="padding-bottom:20px;">Thanks<span class="blue"><?php echo (!empty($_SESSION['registration']['firstname'])? " ".$_SESSION['registration']['firstname']: '');?></span>!</td>
        </tr>
        <?php echo !empty($msg)? "<tr><td>".format_notice($msg)."</td></tr>": '';?>
        <tr>
        <td class="whiteheadertitle">Please check <span class="blue"><?php echo (!empty($_SESSION['registration']['emailaddress'])? $_SESSION['registration']['emailaddress']: 'your registered email');?></span>
<br>
and click the verification link to sign in. </td>
        </tr>
        <?php if(!empty($userId)){?>
        <tr><td class="label" style="padding-top:25px;">
        No email? Click to <a  href='javascript:;' onClick="updateFieldLayer('<?php echo base_url()."web/account/resend_activation_link/u/".encrypt_value($userId);?>','','','msg_div','')">resend</a>.
       <div id="msg_div"></div> </td></tr>
        <?php }?>
       </table>
	<?php
		}
		else if(!empty($msg))
		{
			echo format_notice($msg);
		}
    }
	else
	{
	?>
    <form action="<?php echo base_url().'web/account/signup'.(!empty($t)? '/t/'.$t: '');?>" method="post">
    <table border="0" cellspacing="0" cellpadding="10" align="center">
      <tr>
        <td colspan="2" class="contentheading" style="padding-bottom:20px;">Sign up to get started:</td>
        </tr>
        
        <?php
	if(!empty($msg))
	{
		echo "<tr><td colspan='2' style='padding-top:10px;padding-bottom:0px;'>".format_notice($msg)."</td></tr>";
		
	}
	#Put a special message for other account signups
	if(empty($msg) && !empty($t))
	{
		echo "<tr><td colspan='2' style='padding-top:10px;padding-bottom:0px;'>".format_notice('You require a normal user account to set up the business account(s) you own or manage.')."</td></tr>";
	}
	?>
      <tr>
        <td><?php	echo get_required_field_wrap($requiredFields, 'firstname');?><input name="firstname" type="text" class="textfield" id="firstname" placeholder="First Name" size="35" style="width:200px;" maxlength="100" value="<?php echo (!empty($formData['firstname'])? $formData['firstname']: (!empty($_SESSION['registration']['firstname'])? $_SESSION['registration']['firstname']: ''));?>"><?php echo get_required_field_wrap($requiredFields, 'firstname', 'end');?></td>
        <td><?php	echo get_required_field_wrap($requiredFields, 'lastname');?><input name="lastname" type="text" class="textfield" id="lastname" placeholder="Last Name" size="35" style="width:200px;" maxlength="100" value="<?php echo (!empty($formData['lastname'])? $formData['lastname']: (!empty($_SESSION['registration']['lastname'])? $_SESSION['registration']['lastname']: ''));?>"><?php echo get_required_field_wrap($requiredFields, 'lastname', 'end');?></td>
      </tr>
      <tr>
        <td><?php	echo get_required_field_wrap($requiredFields, 'yourpassword', 'start', 'A valid password is atleast 8<br> characters and contains a <br>number.');?><input name="yourpassword" type="password" class="textfield" id="yourpassword" placeholder="Password" size="35" style="width:200px;" maxlength="100"><?php echo get_required_field_wrap($requiredFields, 'yourpassword', 'end');?></td>
        <td><?php	echo get_required_field_wrap($requiredFields, 'emailaddress');?><input name="emailaddress" type="text" class="textfield" id="emailaddress" placeholder="Email" size="35" style="width:200px;" maxlength="100" value="<?php echo (!empty($formData['emailaddress'])? $formData['emailaddress']: (!empty($_SESSION['registration']['emailaddress'])? $_SESSION['registration']['emailaddress']: ''));?>"><?php echo get_required_field_wrap($requiredFields, 'emailaddress', 'end');?></td>
      </tr>
      <tr>
        <td><?php 
		$gender = (!empty($formData['gender'])? $formData['gender']: (!empty($_SESSION['registration']['gender'])? $_SESSION['registration']['gender']: ''));
		
		echo get_required_field_wrap($requiredFields, 'gender');?><select name='gender' id='gender' class="selecttextfield" style="width:220px;padding:8px 5px 8px 5px;">
        <option value='' <?php echo (empty($gender)? 'selected': '');?>>Gender</option>
        <option value='female' <?php echo ($gender == 'female'? 'selected': '');?> style="color:#333;">Female</option>
        <option value='male' <?php echo ($gender == 'male'? 'selected': '');?> style="color:#333;">Male</option>
        </select><?php echo get_required_field_wrap($requiredFields, 'gender', 'end');?></td>
        <td><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="label">Born</td>
            <td style="padding-left:5px;"><?php	echo get_required_field_wrap($requiredFields, 'dateofbirth');
			
			$dateOfBirth = (!empty($formData['dateofbirth'])? $formData['dateofbirth']: (!empty($_SESSION['registration']['dateofbirth'])? $_SESSION['registration']['dateofbirth']: ''));
			?>
            <select name='month' id='month' class="selecttextfield" style="width:53px; padding:8px 0px 8px 0px; border-right:0px;">
        <?php 
		
		echo "<option value='' ".(empty($dateOfBirth)? " selected": '').">MM</option>";
		for($i=1;$i<13;$i++)
		{
			echo "<option value='".sprintf('%02d', $i)."' style='color:#333;' ".((!empty($dateOfBirth) && date('m', strtotime($dateOfBirth)) == $i)? ' selected': '').">".sprintf('%02d', $i)."</option>";
		}?>
        </select><select name='day' id='day' class="selecttextfield" style="width:48px; padding:8px 0px 8px 0px; border-right:0px;border-left:0px;">
        
        <?php 
		echo "<option value='' ".(empty($dateOfBirth)? " selected": '').">DD</option>";
		
		for($i=1;$i<32;$i++)
		{
			echo "<option value='".sprintf('%02d', $i)."' style='color:#333;' ".((!empty($dateOfBirth) && date('d', strtotime($dateOfBirth)) == $i)? ' selected': '').">".sprintf('%02d', $i)."</option>";
		}?>
        </select><select name='year' id='year' class="selecttextfield" style="width:75px; padding:8px 5px 8px 0px;border-left:0px;">
        <?php 
		echo "<option value='' ".(empty($dateOfBirth)? " selected": '').">YYYY</option>";
		
		for($i=(date('Y')-17);$i>(date('Y')-100);$i--)
		{
			echo "<option value='".$i."' style='color:#333;' ".((!empty($dateOfBirth) && date('Y', strtotime($dateOfBirth)) == $i)? ' selected': '').">".$i."</option>";
		}?>
        </select><?php echo get_required_field_wrap($requiredFields, 'dateofbirth', 'end');?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo get_required_field_wrap($requiredFields, 'zipcode');?><input name="zipcode" type="text" class="textfield" id="zipcode" placeholder="Zip Code" size="35" style="width:200px;" maxlength="100" value="<?php echo (!empty($formData['zipcode'])? $formData['zipcode']: (!empty($_SESSION['registration']['zipcode'])? $_SESSION['registration']['zipcode']: ''));?>"><?php echo get_required_field_wrap($requiredFields, 'zipcode', 'end');?></td>
        <td><input type="submit" name="createaccount" id="createaccount" class="greenbtn" value="Create Account"></td>
      </tr>
      
      <tr>
        <td colspan="2" class="bottomborder" style="padding:10px;">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" style="text-align:center;"><a href="<?php echo base_url()."web/account/login".(!empty($t)? "/t/".encrypt_value('confirm_merchant'): '');?>" class="bluelink">I already have a Clout account</a></td>
        </tr>
        
    </table>
    </form>
    <?php }?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>