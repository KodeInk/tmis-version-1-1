<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Network";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
	<script src="<?php echo base_url();?>assets/js/jquery.form.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.zclip.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/fileform.js"></script>
	<?php 
		echo get_ajax_constructor(TRUE);
	 
	    echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>

<script>
$(function() {
	$( ".optionheader" ).click(function(){ 
		 //Close any opened seciton child
		 $('.optionchild').hide('fast');
		 //Show the desired subsection using the parent div
		 $(this).parent('div').children('div').first().show('fast');
	});

	//Now how about network
	$(".networklisttable td").click(function(){ 
		 //Get a section ID
		 var divId = this.id;
		 
		 if(divId != '')
		 {
		 //Remove all previous class shows
		 $("td").removeClass('bottomborder nobottomborder bluebold blackbold');
		 
		 //Hide all current subsection divs
		 $('.networkdetaildiv').hide('fast');
		 
		 var subSectionDivId = divId+"_details";
		 //Show this section's div
		 $('#'+subSectionDivId).show('fast');
		 $(this).parent('tr').find('td').addClass('bottomborder');
		 
		 //Make the selected cell blue bold
		 $(this).removeClass('bottomborder');
		 //Change the color based on the type of section
		 if(divId.toLowerCase().indexOf("network") >= 0)
		 {
			 $(this).addClass('blackbold nobottomborder');
		 }
		 else
		 {
			 $(this).addClass('bluebold nobottomborder');
	     }
		 }
	});
	
	
	$(".tabdiv").click(function(){ 
		//Remove all previous class shows
		$("td").removeClass('bottomborder nobottomborder bluebold blackbold');
		$("div").removeClass('selectedtabdiv');
		$(this).addClass('selectedtabdiv');
		
		//Hide all current subsection divs
		$('.networkdetaildiv').hide('fast');
		
		//Hide all the overall list divs
		$('#my_network_list').hide('fast');
		$('#my_invites_list').hide('fast');
		$('#my_earnings_list').hide('fast');
		
		//Now show the current user's info
		$('#'+this.id+'_list').show('fast');
		$('#'+this.id+'_list').find('div').first().show('fast');
		
		//TODO: Add check to pull data from PHP file using updateFileLayer if the layer innerHTML is empty
	});
	
	
	
	//Remove a div if clicked
	//Bind to element even if loaded later
	$(document).on('click', '.listdivs', function(){ 
		//First remove its value from the list of selected values
		var selectedEmail = $(this).html();
		var currentEmailArray = $('#emailpastevalues').val().split('|');
		currentEmailArray.splice( $.inArray(selectedEmail, currentEmailArray), 1 );
		$('#emailpastevalues').val(currentEmailArray.join('|'));
		
		//Now remove the div
		$(this).remove();
	});
	
	
});

</script>  
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  if(!empty($_SESSION['user_type']) && $_SESSION['user_type'] == 'merchant')
  {
	  $this->load->view('web/addons/header_merchant', array('main'=>'network', 'sub'=>'Home', 'defaultHtml'=>''));
  }
  else
  {
  	 $this->load->view('web/addons/header_normal', array('main'=>'network', 'sub'=>'Home', 'defaultHtml'=>''));
  }
  
  ?>
  <tr>
    <td class="normalpageheader" id='submenu_content' style="padding-left:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="0%" style="padding:0px;"><div class="bigscreendetails topleftheader">Network</div></td>
    <td width="2%" style="padding-bottom:15px; padding-left:0px;">&nbsp;</td>
    <td width="1%" style="padding-bottom:15px;">&nbsp;</td>
    <td width="80%" class="greytext" style="padding-bottom:15px; vertical-align:bottom; font-size:14px;">&nbsp;</td>
    <td class="whiteheadertitle" style="padding-bottom:0px; padding-right:20px;padding-left:20px;border-left: solid 1px #E0E0E0;" nowrap><span class="green">Total Network:</span> <?php echo format_number($pageStats['total_users_in_my_network'],6);?></td>
    <td class="whiteheadertitle" style="padding-bottom:0px; padding-right:15px; padding-left:20px; border-left: solid 1px #E0E0E0;" nowrap><span class="blue">Total Invites:</span> <?php echo format_number($pageStats['total_invites_in_my_network'],6);?></td>
    <td class="rightmenubg" style="height:100%;min-width:250px;"><table border="0" cellspacing="0" cellpadding="5" width="100%">
      <tr>
        <td style="color:#999999;" nowrap>Feed</td>
        <td style="width:20px; color:#999999;" nowrap><img src="<?php echo base_url();?>assets/images/settings_icon.png"/></td>
        </tr>
    </table>
    
    
    </td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="left" style="padding-left:0px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    
      <tr>
      <td valign="top" class="leftmenuarea" width="1%" style="padding:15px 5px 15px 15px;"><span class='greysectionheader'>Spending is not the only way to raise your score.</span>
      <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">++</td>
    <td width="99%" nowrap><a href="javascript:;">Link a Card</a></td>
  </tr>
</table></div>
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">+45</td>
    <td width="99%" nowrap><a href="javascript:;">Complete Your Profile</a></td>
  </tr>
</table></div>
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">+25</td>
    <td width="99%" nowrap><a href="javascript:;">Connect a Social Network</a></td>
  </tr>
</table></div>
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">++</td>
    <td width="99%" nowrap><a href="javascript:;">Refer New Members</a></td>
  </tr>
</table></div>
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">++</td>
    <td width="99%" nowrap><a href="javascript:;">Your Referrals Spend</a></td>
  </tr>
</table></div>
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">+10</td>
    <td width="99%" nowrap><a href="javascript:;">Answer Merchant Surveys</a></td>
  </tr>
</table></div>
     
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">++</td>
    <td width="99%" nowrap><a href="javascript:;">Shop at Clout Merchants</a></td>
  </tr>
</table></div>
     
     
     
     
     
     </td>
        <td valign="top" class="pagecontentarea" width="98%" style="padding:<?php echo !empty($msg)?'15':'30';?>px 15px 15px 15px;">
        <?php echo !empty($msg)?format_notice($msg)."<BR><BR>":''; ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="15">
  
  
  <tr>
        <td class="pagetitle">Your Network</td>
      </tr>
      <tr>
        <td class="pagesubtitle" style="padding-bottom:15px; padding-top:10px;">Build your network and <b>earn</b>.</td>
      </tr>
  
  
  
  <tr>
    <td style="padding:0px;" valign="top"><table align="center">
    
    
    <tr><td valign="top"><div class="contentdiv" style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable purpletop" style="width:580px;">
      <thead>
        <tr>
          <td>My Commission Network - <span class="greysectionheader">Track Your Earnings</span></td>
          </tr>
        </thead>
      
      <tr>
        <td style="padding:0px;" nowrap><div class="tabdiv selectedtabdiv" id="my_network"><span class="label">Network</span><br>
<span class="black"><?php echo format_number($pageStats['total_users_in_my_network'],6);?></span></div><div class="tabdiv" id="my_invites"><span class="label">Invites</span><br>
<span class="blue"><?php echo format_number($pageStats['total_invites_in_my_network'],6);?></span></div><div class="tabdiv" id="my_earnings" style="border-right:solid 0px #CCC;"><span class="label">Earnings</span><br>
<span class="green"><?php echo "$".format_number($pageStats['total_earnings_in_my_network'],6);?></span></div></td>
      </tr>
      <tr>
        <td style="padding:0px;">
        
        
        
        
        
        <div id="my_network_list">
        <div class="networkdetaildiv">
        <table border="0" cellspacing="0" cellpadding="10" align="center">
        <tr><td colspan="4" style="padding-bottom:0px;"><span class="whiteheadertitle">Your Network</span><br>
The last member joined your direct network <?php echo format_date_interval($pageStats['last_time_user_joined_my_direct_network'], date('Y-m-d H:i:s', strtotime('now')), FALSE, TRUE, 'years');?> ago.</td></tr>
        <tr>
        
<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo format_number($pageStats['total_direct_referrals_in_my_network'],5);?><br>
<div class="networkbar blackbg first"></div>
1st</td></tr></table></td>

<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_2_referrals_in_my_network'],5);?><br>
<div class="networkbar blackbg second"></div>
2nd</td></tr></table>
</td>

<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_3_referrals_in_my_network'],5);?><br>
<div class="networkbar blackbg third"></div> 
3rd</td></tr></table>
</td>

<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_4_referrals_in_my_network'],5);?><br>
<div class="networkbar blackbg fourth"></div> 
4th</td></tr></table>
</td>

</tr>
        </table>
        </div>
        
        <div id="section_list_container">
        <?php echo $this->load->view('web/network/network_list', array('sectionType'=>'network', 'sectionList'=>(!empty($networkSectionList)?$networkSectionList:array()), 'itemCount'=>(!empty($networkItemCount)? $networkItemCount: 0) ));?>
        </div>
        </div>
        
        
        
        
        
        
        
        
        
        <div id="my_invites_list" style="display:none;">
        <div class="networkdetaildiv">
        <table border="0" cellspacing="0" cellpadding="10" align="center">
        <tr><td colspan="4" style="padding-bottom:0px;"><span class="whiteheadertitle">Your Invites</span><br>
The last invite you sent was  <?php echo format_date_interval($pageStats['last_time_invite_was_sent'], date('Y-m-d H:i:s', strtotime('now')), FALSE, TRUE, 'years');?> ago.</td></tr>
        <tr>
        
<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo format_number($pageStats['total_direct_invites_in_my_network'],5);?><br>
<div class="networkbar bluebg first"></div>
1st</td></tr></table></td>

<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_2_invites_in_my_network'],5);?><br>
<div class="networkbar bluebg second"></div>
2nd</td></tr></table>
</td>

<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_3_invites_in_my_network'],5);?><br>
<div class="networkbar bluebg third"></div> 
3rd</td></tr></table>
</td>

<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_4_invites_in_my_network'],5);?><br>
<div class="networkbar bluebg fourth"></div> 
4th</td></tr></table>
</td>

</tr>
        </table>
        </div>
        
        
        
        <div id="invite_list_container">
        <?php echo $this->load->view('web/network/network_list', array('sectionType'=>'invites', 'sectionList'=>(!empty($inviteSectionList)?$inviteSectionList:array()), 'itemCount'=>(!empty($inviteItemCount)? $inviteItemCount: 0) ));?>
        </div>
        
        </div>
        
        
        
        
        
        
        <div id="my_earnings_list" style="display:none;">
        <div class="networkdetaildiv">
        <table border="0" cellspacing="0" cellpadding="10" align="center">
        <tr><td colspan="4" style="padding-bottom:0px;"><span class="whiteheadertitle">Your Earnings</span><br>
The last commission you earned was <?php echo format_date_interval($pageStats['last_time_commission_was_earned'], date('Y-m-d H:i:s', strtotime('now')), FALSE, TRUE, 'years');?> ago.</td></tr>
        <tr>
        
<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo "$".format_number($pageStats['total_direct_earnings_in_my_network'],4);?><br>
<div class="networkbar greenbg first"></div>
1st</td></tr></table></td>

<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo "$".format_number($pageStats['total_level_2_earnings_in_my_network'],4);?><br>
<div class="networkbar greenbg second"></div>
2nd</td></tr></table>
</td>

<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo "$".format_number($pageStats['total_level_3_earnings_in_my_network'],4);?><br>
<div class="networkbar greenbg third"></div> 
3rd</td></tr></table>
</td>

<td valign="bottom"><table><tr><td class="whiteheadertitle"><?php echo "$".format_number($pageStats['total_level_4_earnings_in_my_network'],4);?><br>
<div class="networkbar greenbg fourth"></div> 
4th</td></tr></table>
</td>

</tr>
        </table>
        </div>
        
        
        <div id="score_details_container">
        <?php echo $this->load->view('web/network/clout_score_details', $cloutScoreDetails);?>
        </div>
        
        </div>
        
        </td>
        </tr>
      </table>
      </div>
      
      
      
      
      
      
      
      
      
      
      
      <div  class="contentdiv"  style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greentop" style="width:580px;">
        <thead>
          <tr>
            <td>Invite Tools - <span class="greysectionheader">Get Paid When Your Friends Shop</span>
              </td>
            </tr>
          </thead>
        
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td><div class="optionheaderdiv"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="optionheader"><tr>
                <td style="padding-left:15px; margin-right: 20px; line-height:45px;">Services</td></tr></table><div class="optionchild"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="5" style="text-align:left;">Click on the service icon to login securely and invite your contacts to Clout</td>
    </tr>
  <tr>
    <td><a href="javascript:newPopup('<?php echo base_url()."web/network/get_gmail_contacts";?>', 700, 500)" ><img src="<?php echo base_url()."assets/images/gmail_icon.png";?>" border="0" title="Click to invite your Gmail contacts."/></a></td>
    <td><a href="javascript:newPopup('<?php echo base_url()."web/network/get_yahoo_contacts";?>', 700, 500)" ><img src="<?php echo base_url()."assets/images/yahoo_icon.png";?>" border="0" title="Click to invite your Yahoo! contacts."/></a></td>
    <td><a href="javascript:newPopup('<?php echo base_url()."web/network/get_facebook_contacts";?>', 700, 500)"><img src="<?php echo base_url()."assets/images/facebook_icon.png";?>" border="0" title="Click to invite your Facebook contacts."/></a></td>
    <td><a href="javascript:newPopup('<?php echo base_url()."web/network/get_linkedin_contacts";?>', 700, 500)"><img src="<?php echo base_url()."assets/images/linkedin_icon.png";?>" border="0" title="Click to invite your LinkedIn contacts."/></a></td>
    <td><a href="javascript:clickItem('import_from_email_header')"><img src="<?php echo base_url()."assets/images/msn_icon.png";?>" border="0" title="Click to invite your contacts using your email."/></a></td>
  </tr>
</table>
</div></div>
              </td>
            </tr>
            <tr>
              <td><div class="optionheaderdiv"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="optionheader" id="import_from_email_header"><tr>
                <td style="padding-left:15px; margin-right: 20px; line-height:45px;">Import From Email</td></tr></table><div id="imap_email_field" class="optionchild" style="display:none;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td style="text-align:left;"><input name="youremail" type="text" class="textfield" id="youremail" value='' placeholder="Enter your own email address" style="font-size: 18px;width:380px;"></td>
    <td><input type="button" name="import_from_email" id="import_from_email" class="greenbtn" value="Start" style="width:110px;" onClick="updateFieldLayer('<?php echo base_url()."web/network/import_by_imap";?>','youremail','','imap_email_field','Please enter a valid email')"></td>
    </tr>
</table></form>
</div></td>
            </tr>
            <tr>
              <td><div class="optionheaderdiv"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="optionheader"><tr>
                <td style="padding-left:15px; margin-right: 20px; line-height:45px;">Import From Excel/CSV</td></tr></table><div id="csv_form_div" class="optionchild" style="display:none;">
                <div id="csvform_div">
                <form id="csvform" class="layerform" action="<?php echo base_url()."web/network/import_from_file";?>" method="post" enctype="multipart/form-data" onsubmit="updateFieldValue('layerid', 'csvform');hideLayerSet('csvform_div')"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><select name="csv_file_format" id="csv_file_format" class="selecttextfield" style="width:140px; padding: 10px 10px 10px 0px;">
      <option value="" selected>File Format</option>
      <option value="csv_aol">CSV - AOL Address Book</option>
      <option value="csv_generic">CSV - Generic File</option>
      <option value="csv_gmail">CSV - Gmail Address Book</option>
      <option value="csv_hotmail">CSV - Hotmail Address Book</option>
      <option value="csv_outlook">CSV - Outlook  Contacts</option>
      <option value="csv_thunderbird">CSV - Thunderbird  Contacts</option>
      <option value="csv_yahoo">CSV - Yahoo Address Book</option>
      <option value="text_commas">Text File - Comma Delimited</option>
      <option value="text_tabs">Text File - Tab Delimited</option>
      </select></td>
    <td><input name="csvuploadfile" type="file" class="textfield" id="csvuploadfile" value='' style="font-size: 14px;width:230px;"></td>
    <td align="right"><input type="submit" name="import_from_email" id="import_from_email" class="forrestgreenbtn" value="Import" style="width:110px;"><input type='hidden' name='csvform_displaylayer' id='csvform_displaylayer' value='file_email_field'></td>
  </tr>
</table></form>
	</div>
	<div  id="file_email_field"></div>
	<div class="progresscontainer" style="margin-top:10px;">
        <div id="csvform_bar" class="progressbar"></div >
        <div id="csvform_percent" class="progresspercent">0%</div >
    </div>
</div></div></td>
            </tr>
            <tr>
              <td><div class="optionheaderdiv"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="optionheader"><tr>
                <td style="padding-left:15px; margin-right: 20px; line-height:45px;">Share Your Link</td></tr></table><div class="optionchild" style="display:none;"><table border='0' cellspacing='0' cellpadding='5'>
  <tr>
    <td colspan='2' style='text-align:left;'>Just copy, paste, share and watch your network grow!</td>
  </tr>
  <?php
  #Get the clout ID or default ID
  if(!empty($referralUrls))
  {
	  $sysId = $referralUrls[0]['url_id'];
   }
   else if($this->native_session->get('cloutId'))
   {
	   $sysId = $this->native_session->get('cloutId');
	}
	else
	{
		$sysId = generate_system_id($this,$this->native_session->get('userId'));
	}
  ?>
  <tr>
    <td style='text-align:left;'><input name='referralurl_field' type='text' class='textfield selectmimic' id='referralurl_field' value='<?php echo base_url().'u/'.$sysId;?>' style='font-size: 18px;width:360px;' onClick="toggleLayer('user_ref_urls', '<?php echo base_url().'web/network/current_referral_links';?>', '', '', '', '', '', '')"><div id='user_ref_urls' style="position:absolute;width:380px;padding:5px;background-color:#FFF;border:solid 1px #DDD;display:none;"></div></td>
    <td><input type='button' name='referralurl' id='referralurl' class='bluebtn copyfieldbtn' value='Copy' style='width:90px;' ></td>
  </tr>
  </table>
  <div id="add_new_urlid" style="display:none;padding-left:5px;padding-top:15px;">
  <table border="0" cellspacing="0" cellpadding="0">
  <tr><td nowrap><?php echo base_url().'u/';?></td><td style="height:60px;"><input name='newurlid' type='text' class='textfield' id='newurlid' value='' style='font-size: 18px;width:140px;' placeholder='New Referral ID' onKeyUp="updateFieldLayer('<?php echo base_url()."web/network/check_new_url_validity";?>','newurlid','','new_url_action','Please enter a valid referral ID')"></td><td style="padding-left:10px;"><div id='new_url_action'></div></td></tr>
  </table>
  </div>
  </div>
  
  
  </div></td>
            </tr>
            <tr>
              <td><div class="optionheaderdiv"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="optionheader"><tr>
                <td style="padding-left:15px; margin-right: 20px; line-height:45px;">Paste Emails</td></tr></table><div id='paste_email_field' class="optionchild" style="display:none;">
                <form id="pasteform" class="layerform" action="<?php echo base_url()."web/network/send_from_paste";?>" method="post" onsubmit="return submitLayerForm('pasteform')">
                <table border="0" cellspacing="0" cellpadding="5">
  <?php $msgTemplate = get_confirmation_messages($this, array('emailaddress'=>"", 'firstname'=>'', 'fromname'=>$_SESSION['first_name']." ".$_SESSION['last_name'], 'fromemail'=>$_SESSION['email_address']), 'user_invitation');?>
  <tr>
    <td colspan="2" style="text-align:left;">Clout will send <a href='javascript:;' onclick="toggleLayersOnCondition('send_message_details', 'send_message_details')" class='bluebold'>a personalized invitation</a> for you to each of your contacts.<div id='send_message_details' class='ariallabel greytext' style='border: solid 1px #E0E0E0;padding:10px;display:none;'><div style="float:right;cursor:pointer;" onclick="toggleLayersOnCondition('send_message_details', 'send_message_details')"><img src="<?php echo base_url();?>assets/images/remove_icon.png"></div><?php echo $msgTemplate['message'];?></div></td>
  </tr>
  <tr>
    <td style="text-align:left;"><div class="textfield mocktextfield greytext" style="font-size:16px; width:400px;height:150px;">
   <input name='newemail' type='text' class='textfield' id='newemail' value='' style='font-size: 16px;width:180px;border: 0px; padding:2px; margin-bottom:20px;' placeholder='Enter Email'><input type='hidden' value='' name='emailpastevalues' id='emailpastevalues'>
    </div>
    </td>
    <td valign="bottom"><input type="submit" name="sendfrompaste" id="sendfrompaste" class="purplebtn" value="Send" style="width:90px;"><input type='hidden' name='pasteform_displaylayer' id='pasteform_displaylayer' value='paste_email_field'></td>
  </tr>
                </table>
                </form>
</div></div></td>
            </tr>
          </table></td>
        </tr>
        </table></div></td>
      
      </tr></table></td>
  </tr>
</table></td>
        <td width="1%" valign="top" class="rightmenubg">
        <div id="filterspace" style="padding:15px;min-width:245px;max-width:245px;">
        <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 15px;">
        
        <tr>
        <td class="categorycircle">People</td>
        <td class="categorycircle">Clout</td>
        <td class="selectedcategorycircle">All</td>
        <td class="categorycircle">Money</td>
        <td class="categorycircle">Offers</td>
        </tr>
        <tr>
        <td colspan="5" style="padding-top:10px;"><input type="text" name="feedsearch" id="feedsearch" value="" placeholder="Search in Feed" class="searchfield" style="width:230px;"></td>
        </tr>
        </table>
        
        
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="plusicon">&nbsp;</div></td><td style="padding-left:5px;">J.M. joined your network - 1st</td></tr></table></div>
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="moneyicon">&nbsp;</div></td><td style="padding-left:5px;">$.25 Payout at <a href="javascript:;">Mike's Bar and Grill</a></td></tr></table></div>
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="usericon">&nbsp;</div></td><td style="padding-left:5px;">J.M. Sent 648 Invites</td></tr></table></div>
        
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="moneyicon">&nbsp;</div></td><td style="padding-left:5px;">$.30 Payout at <a href="javascript:;">Nordstrom Rack</a></td></tr></table></div>
        
        <div class="feedboxseparator">&nbsp;</div>
        
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="hotspoticon">&nbsp;</div></td><td style="padding-left:5px;">New Hotspot!<br>
<span class="additionalinfo">You have 15 new friends at <a href="javascript:;">The Parlor</a></span></td></tr></table></div>
        
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td style="padding-left:5px;">BUY ONE. GET FOUR FREE.<br>
 <a href="javascript:;">now.sprint.com</a>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td style='padding-left:0px;'><img src="<?php echo base_url();?>assets/images/sample_ad_image.png"/></td>
    <td valign='top'><span class="additionalinfo">Arm your crew with 5 rugged Kyocera Torque phones for the price of 1. </span></td>
  </tr>
</table>
</td></tr></table></div>
        
        
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="usericon">&nbsp;</div></td><td style="padding-left:5px;">People joined your network!<br>
<span class="additionalinfo">You have <a href="javascript:;">125</a> new people in your network.</span></td></tr></table></div>

        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="loyaltyicon">&nbsp;</div></td><td style="padding-left:5px;">Loyalty almost reached!<br>
<span class="additionalinfo">Visit <a href="javascript:;">Morton Steakhouse</a> 2 more times to reach the store VIP level.</span></td></tr></table></div>

        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="businessicon">&nbsp;</div></td><td style="padding-left:5px;">New Local Business<br>
<span class="additionalinfo">You may be interested in  <a href="javascript:;">Big Mama's Steakhouse</a> which just joined Clout near you.</span></td></tr></table></div>

        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="offericon">&nbsp;</div></td><td style="padding-left:5px;">15% Cash Back - <a href="javascript:;">Chillies Restaurant</a><br>
<span class="additionalinfo">Valid Mon-Fri 8:00am to 9:00am. Offer does not apply to CocaCola drinks and products.</span></td></tr></table></div>

        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="messageicon">&nbsp;</div></td><td style="padding-left:5px;">New Message<br>
<span class="additionalinfo"><a href="javascript:;">Francis Konig</a> sent you a message.</span></td></tr></table></div>

        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="messageicon">&nbsp;</div></td><td style="padding-left:5px;">New Message<br>
<span class="additionalinfo"><a href="javascript:;">Mary Jane</a> sent you a message.</span></td></tr></table></div>


        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="messageicon">&nbsp;</div></td><td style="padding-left:5px;">New Message<br>
<span class="additionalinfo"><a href="javascript:;">Peter Parker</a> responded to your message.</span></td></tr></table></div>
</div>
        </td>
      </tr>
    </table></td>
  </tr>
</table>

    
    </td>
  </tr>
  <?php $this->load->view('web/addons/footer_normal');?>
</table>

</body>
</html>