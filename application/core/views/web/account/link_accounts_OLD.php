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
	<title><?php echo SITE_TITLE.": Link Accounts";?></title>
	<script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
    <script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
    
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
     <?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
     <?php 
		echo get_ajax_constructor(TRUE);
	?>
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-top:10px; padding-bottom: 15px; text-align:center;"><form action="">
    <table border="0" cellspacing="0" cellpadding="10" align="center">
      <tr>
        <td class="contentheading" style="padding-bottom:0px;">Add Accounts. Get Cash Back.</td>
        </tr>
      <tr>
        <td class="whiteheadertitle" style="">No Coupons. No Vouchers. No Hassle. Just swipe your card and earn.<br>
          We add the cash back to your account a few days later. </td>
        </tr>
      <tr>
        <td style="padding-top:10px;">
        <table border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td align="left" valign="top"><table width="300" border="0" cellspacing="0" cellpadding="10" class="sectiontable greentop">
  <thead>
  <tr>
    <td>&#9312; Select Your Bank</td>
  </tr>
  </thead>
  <tr><td style="height:0px; padding-top:3px;"></td></tr>
  <tr>
    <td class="sectionnote">Select the bank that issues your credit or debit card.
    </td>
  </tr>
  <tr>
    <td><input name="searchbanks" type="text" class="searchfield" id="searchbanks" value='' placeholder="Enter your bank's name or website" style="width:260px;"   onkeyup="startInstantSearch('searchbanks', 'searchby', '<?php echo base_url();?>web/search/load_results/type/bank_name/layer/select_accounts');showContent('select_accounts','');"><input name="searchby" type="hidden" id="searchby" value="institution_name__home_url" /></td>
  </tr>
  <tr>
    <td><div id="select_accounts" style="max-height:197px; overflow:auto; min-height: 197px;"><?php 
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='5' style='background-color:#fff;'>";
	$counter = 0;
foreach($topBanks AS $bank)
{
	 echo "<tr style='border-bottom: solid 1px #F2F2F2;'><td><a href='javascript:void(0);' onclick=\"updateFieldLayer('".base_url()."web/account/show_bank_login/i/".encrypt_value($bank['third_party_id'])."','','','sync_accounts','')\" class='bluelink'>".html_entity_decode($bank['institution_name'])."</a></td></tr>";
	 $counter++;
}
 echo "</table>";
?></div></td>
  </tr>
</table>
</td>
    <td align="left" valign="top"><table width="300" border="0" cellspacing="0" cellpadding="10" class="sectiontable bluetop">
  <thead>
  <tr>
    <td class="sectionheader" style="border-bottom: solid 1px #DDD;">&#9313; Verify Account</td>
  </tr>
  </thead>
  <tr><td style="height:0px; padding-top:3px;"></td></tr>
  <tr>
    <td class="sectionnote">Sign in with your online banking credentials to verify your account.
    </td>
  </tr>
  <tr>
    <td><div id="sync_accounts" style="min-height:250px;max-height:250px; overflow-y:auto;overflow-x:hidden;">
      <div class='greytext' style="text-align:center; padding-top:80px;">Select a bank in Step 1 to enter its details.</div></div></td>
  </tr>
</table></td>
    <td align="left" valign="top"><table width="300" border="0" cellspacing="0" cellpadding="10" class="sectiontable purpletop">
  <thead>
  <tr>
    <td class="sectionheader" style="border-bottom: solid 1px #DDD;">&#9314; Get Cash Back</td>
  </tr>
  </thead>
  <tr><td style="height:0px; padding-top:3px;"></td></tr>
  <tr>
    <td class="sectionnote">Accounts at these banks are now qualified for cash back rewards.</td>
  </tr>
  <tr>
    <td><div id="qualified_accounts" style="min-height:250px;max-height:250px;overflow:auto;">
      <div  style="text-align:center; font-size:16px; color:#999; padding-top:80px;">You have no verified accounts yet.</div></div></td>
  </tr>
</table></td>
  </tr>
        </table>
</td>
    <td>&nbsp;
        
        </td>
        </tr>
     
      <tr>
        <td><table align="center"><tr><td nowrap><a href="javascript:;" class="bluelink">FAQs</a> &nbsp;&nbsp;|&nbsp;&nbsp; </td><td align="left" nowrap><div id="skip_link_div"><a href="javascript:;" class="bluelink" onClick="showLayerSet('confirm_skip_div');hideLayerSet('skip_link_div')">Skip Linking Accounts</a></div></td><td><div id="confirm_skip_div" style="display:none;">
        <table width='100%' align="left">
        <tr><td width="1%"><input type="checkbox" id="skip_link" name="skip_link" value="Y" onChange="showHideOnChecked('donot_remind_warning', 'skip_link');passFormValue('skip_link', 'skip_link_check', 'checkbox')"><input id="skip_link_check" name="skip_link_check" type="hidden" value=""></td><td width="1%" nowrap>Do not remind me again.</td><td width="98%" style="text-align:left;"><input type="button" name="proceed_after_link" id="proceed_after_link" class="greenbtn" style="width:80px;" value="Skip" onclick="updateFieldLayer('<?php echo !empty($userDashboard)? $userDashboard: base_url()."web/account/login";?>','skip_link_check','','','')"> <input type="button" name="cancel_skip_link" id="cancel_skip_link" class="greybtn" style="width:80px;" value="Cancel" onclick="showLayerSet('skip_link_div');hideLayerSet('confirm_skip_div<>donot_remind_warning')"></td></tr>
        </table>
        </div></td></tr></table><div id="donot_remind_warning" style="display:none;">
        <?php echo format_notice('WARNING: By skipping this step, you will not be able to earn referral commissions or cash back until you link an account.');?>
        </div></td>
        </tr>
      <tr>
        <td style="padding-top:3px;"><img src="<?php echo base_url();?>assets/images/trust_logos.png">
          <input type="hidden" name="layerid" id="layerid"></td>
      </tr>
    </table>
    </form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>