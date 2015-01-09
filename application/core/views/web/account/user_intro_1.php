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
	<title><?php echo SITE_TITLE.": Signin";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-top:80px; padding-bottom: 30px; text-align:center;"><table border="0" cellspacing="0" cellpadding="10" align="center">
      <tr>
        <td class="contentheading" style="padding-bottom:20px;">Welcome Derick!</td>
        </tr>
      <tr>
        <td class="whiteheadertitle" style="padding-top:40px;">Upgrading your Life has never been so easy!</td>
        </tr>
      <tr>
        <td style="padding-top:40px; padding-bottom:40px;">&nbsp;</td>
        </tr>
      <tr>
        <td class="whiteheadertitle">Upgrading your income is even easier</td>
      </tr>
      <tr>
        <td><input type="submit" name="login" id="login" class="nextgreenbtn" style="width:100px;" value=""></td>
        </tr>
      <tr>
        <td><a href="javascript:void(0);" class="bluelink">Skip Intro</a></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>