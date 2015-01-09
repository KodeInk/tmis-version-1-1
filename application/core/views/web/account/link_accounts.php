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
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
    
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
     <?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
     <?php 
		echo get_ajax_constructor(TRUE);
	?>
<script type="text/javascript">
//Resize the document
$(document).ready(function() {
	var windowHeight = $(document).height(); 
	$('#pagecontentarea').css('height', (windowHeight - 51)+'px'); 
	
	$('.fancybox').fancybox();
});
</script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.pack.js"></script>
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class='bluetogreenbg' height="10"></td>
  </tr>
  
  
  <tr>
    <td id="pagecontentarea">
    
    <table border="0" cellspacing="0" cellpadding="10" align="center">
      <tr>
        <td class="contentheading" style="padding-bottom:15px;text-align:center;">Link your accounts. Live with Clout.</td>
        </tr>
      <tr>
        <td class="sectionheader" style="padding-bottom:15px;padding-top:0px;text-align:center;">Select the bank that issues your credit or debit card below.</td>
        </tr>
    <tr>
        <td style="text-align:center;"><div style="max-height:340px; overflow:hidden;">
        <?php
		foreach($featuredBanks AS $bank)
		{
			echo "<a href='".base_url()."web/account/show_bank_login/i/".encrypt_value($bank['id'])."/n/".encrypt_value($bank['institution_name'])."/c/".encrypt_value($bank['institution_code'])."' class='fancybox fancybox.ajax'><div style='background: url(".base_url()."assets/uploads/images/".$bank['logo_url'].") no-repeat; background-size: contain; background-position:center; width:148px; height:148px; cursor:pointer; -webkit-box-shadow: 1px 1px 2px #666; -moz-box-shadow: 1px 1px 2px #666; box-shadow: 1px 1px 2px #666; margin: 10px;display:inline-block;'></div></a>";
		}
		?></div>
        </td>
        </tr>
        
        <tr>
        <td style="height:120px;padding-top:0px;text-align:center;padding-left:20px;padding-right:20px;" valign="top">
        <div id='search_instructions' class="label bgcrossedtitle"> &nbsp; Click on your bank or search. &nbsp; </div>
        
        
        <div id='search_field_div' style="margin-top:20px;text-align:center;">
        <table cellpadding="0" cellspacing="0" border="0" align="center"><tr><td>
        <div id='suggestion_sent_notice'></div>
        <input name="searchbanks" type="text" class="searchfield" id="searchbanks" value='' placeholder="Enter your bank's name or website" style="width:400px; font-size:19px; padding:12px; font-weight:100;"   onkeyup="startInstantSearch('searchbanks', 'searchby', '<?php echo base_url();?>web/search/load_results/type/bank_name/layer/select_accounts');showContent('select_accounts','');" onClick="hideLayerSet('select_accounts')"><input name="searchby" type="hidden" id="searchby" value="home_url__institution_name" />
        <div id="select_accounts" style="max-height:190px; min-width:426px; position:absolute; overflow:auto; display:none; text-align:left;"></div>
        </td></tr></table></div>
        
        <div id="not_listed_div" style="margin-top:10px;"><a href="javascript:;" onClick="hideLayerSet('not_listed_div<>search_instructions<>search_field_div');showLayerSet('not_listed_form_div')" class="bluelink">Bank not listed?</a></div>
        <div id="not_listed_form_div" style="display:none;  text-align:center;">
        <table align="center">
        <tr>
        <td><input type="text" id="bank_not_listed" name="bank_not_listed" value=""  placeholder="Enter your bank's name" style="width:240px;" class="textfield"></td>
        <td style="text-align:left;"><input type="button" name="proceed_not_listed" id="proceed_not_listed" class="greenbtn" style="width:150px;" value="Request Addition" onclick="updateFieldLayer('<?php echo base_url()."web/account/suggest_bank_addition";?>','bank_not_listed','','suggestion_sent_notice','');showLayerSet('not_listed_div<>search_instructions<>search_field_div');hideLayerSet('not_listed_form_div')"> <input type="button" name="cancel_not_listed" id="cancel_not_listed" class="greybtn" style="width:80px;" value="Cancel" onclick="showLayerSet('not_listed_div<>search_instructions<>search_field_div');hideLayerSet('not_listed_form_div')"></td>
        </tr>
        </table>
        </div></td>
        </tr>
        <tr>
        <td style="text-align:center; padding-top:10px;"><a id='learn_more_link' href='<?php echo base_url()."web/page/show_help_video/t/".encrypt_value('linking_accounts');?>' class='fancybox fancybox.ajax'></a><input type="button" name="learnmore" id="learnmore" class="bluebtn" style="width:300px;" onClick="clickItem('learn_more_link')" value="Learn More"></td>
        </tr>
        <tr>
        <td style="padding-top:0px;text-align:center; height:55px;" valign="top">
        
        <?php if(!empty($currentBanks))
		{?>
		<table align="center"><tr><td><div id="continuebtn"><a href="<?php echo base_url();?>web/account/normal_dashboard" class="bluelink">Continue to dashboard</a></div></td>
        </tr></table>
		<?php }
		else
		{?>
		<table align="center"><tr><td><div id="skip_link_div"><a href="javascript:;" class="bluelink" onClick="showLayerSet('confirm_skip_div');hideLayerSet('skip_link_div')">Skip linking accounts</a></div></td><td><div id="confirm_skip_div" style="display:none;">
        
        <table width='100%' align="left">
        <tr><td width="1%"><input type="checkbox" id="skip_link" name="skip_link" value="Y" onChange="showHideOnChecked('donot_remind_warning', 'skip_link');passFormValue('skip_link', 'skip_link_check', 'checkbox')"><input id="skip_link_check" name="skip_link_check" type="hidden" value=""></td><td width="1%" nowrap>Do not remind me again.</td><td width="98%" style="text-align:left;"><input type="button" name="proceed_after_link" id="proceed_after_link" class="greenbtn" style="width:80px;" value="Skip" onclick="updateFieldLayer('<?php 
		echo !empty($userDashboard)? $userDashboard: base_url()."web/account/login";?>','skip_link_check','','','')"> <input type="button" name="cancel_skip_link" id="cancel_skip_link" class="greybtn" style="width:80px;" value="Cancel" onclick="showLayerSet('skip_link_div');hideLayerSet('confirm_skip_div<>donot_remind_warning')"></td></tr>
        </table>
        
        </div></td>
        </tr></table>	
		<?php }?>
        
        <div id="donot_remind_warning" style="display:none;">
        <?php echo format_notice('WARNING: By skipping this step, you will not be able to earn referral commissions or cash back until you link an account.');?>
        </div>
        
        </td>
        </tr>
    </table>
    </td>
  </tr>
  
  
  <tr>
    <td class='bluetogreenbg'><table width="80%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr>
    <td width="1%"><img src="<?php echo base_url();?>assets/images/logo_white_small.png"></td>
    <td width="1%" nowrap>&copy 2014</td>
    <td>&nbsp;<input type="hidden" name="layerid" id="layerid"></td>
    <td width="1%" nowrap><a href="javascript:;">Home</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:;">Businesses</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:;">Agents</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:;">Affiliates</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:;">FAQs</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:;">Terms</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:;">Privacy</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:;">Contact</a></td>
  </tr>
</table>
</td>
  </tr>
</table>

</body>
</html>