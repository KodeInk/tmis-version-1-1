<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
<script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
</head>
<body <?php if(empty($r) && !empty($service) && $service == 'GMAIL') {?> onLoad="document.location.href='https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=<?php echo $oauth->rfc3986_decode($accessToken['oauth_token']);?>'" <?php }?>>		
<?php 
#

/**********************************************************
 * This file obtains and processes email provider contacts
 **********************************************************/

#Process the response
if(!empty($r))
{
	if(!empty($finalContactsList))
	{
		$inPageForms = array('imap_email', 'file_email', 'paste_email');
		$msgTemplate = get_confirmation_messages($this, array('emailaddress'=>"[recipient email]", 'firstname'=>'[recipient first name]', 'fromname'=>$_SESSION['first_name']." ".$_SESSION['last_name'], 'fromemail'=>$_SESSION['email_address']), 'user_invitation');
		
		echo "<form ";
		#Add this section to not redirect the page if some one submits
		if(in_array($r,$inPageForms))
		{
			echo " action='".base_url()."web/network/send_invitations/r/internal/t/".$r."' method='post'  id='".$r."_sendform' onsubmit=\"return submitLayerForm('".$r."_sendform')\"";
		}
		else 
		{
			echo " action='".base_url()."web/network/send_invitations' method='post' ";
		}
		
		echo "><table width='100%'> 
		<tr>
		<td class='pagesubtitle' width='99%' style='text-align:left;padding-top:0px;'>Your ".(!empty($service)? $service: '')." Contacts<br>
<span class='ariallabel greytext'>Select contacts and click the Send button to send <a href='javascript:;' onclick=\"toggleLayersOnCondition('send_message_details', 'send_message_details')\" class='bluebold'>an invitation</a></span>
</td>
		<td width='1%' valign='top'><input type='submit' name='send_invitations' id='send_invitations' class='purplebtn' value='Send' style='width:90px;'>";
		
		#Add this section to not redirect the page if some one submits
		if(in_array($r,$inPageForms))
		{
			echo "<input type='hidden' name='".$r."_sendform_displaylayer' id='".$r."_sendform_displaylayer' value='".$r."_field'>";
		}
		
		
		echo "</td>
		</tr>
		
		<tr><td colspan='2'><div id='send_message_details' class='ariallabel greytext' style='border: solid 1px #E0E0E0;padding:10px;display:none;text-align:left;'><div style='float:right;cursor:pointer;' onclick=\"toggleLayersOnCondition('send_message_details', 'send_message_details')\"><img src='".base_url()."assets/images/remove_icon.png'></div>".$msgTemplate['message']."</div></td></tr>
		
		<tr><td colspan='2'>
		<div style='max-height:450px; overflow:auto;'>
		<table  border='0' cellspacing='0' cellpadding='3 width='100%'  class='networklisttable' style='border-left: solid 1px #E0E0E0;border-bottom: solid 1px #E0E0E0;'>
		<tr style='background-color:#F2F2F2;'><td width='1%'><input type='checkbox' id='selectall' name='selectall' value='allcontacts' onChange=\"selectAll(this,'contactchecklist')\" checked/></td><td  width='".(($r != 'paste_email')?"1%":"99%")."' style='font-weight:bold;'>Email</td>".(($r != 'paste_email')?"<td style='font-weight:bold;'>Name</td>":'')."</tr>";
		foreach($finalContactsList AS $key=>$contact)
		{
			echo "<tr><td>";
			if(empty($contact['last_invitation_sent_on']) || (!empty($contact['can_send']) && $contact['can_send'] == 'YES'))
			{
				echo "<input type='checkbox' id='".$key."_c' name='contacts[]' value='".$contact['email_address']."' checked/>";
			}
			
			echo "</td><td>".$contact['email_address']."</td>";
			if($r != 'paste_email')
			{
				echo "<td nowrap>".$contact['name'];
			
				if(!empty($contact['last_invitation_sent_on']))
				{
					echo " <img src='".base_url()."assets/images/send_mail_icon.png'/> <span class='greytext smalltxt'>(".date('m/d/Y', strtotime($contact['last_invitation_sent_on'])).")</span>";
				}
			
				echo "</td>";
			}
			
			echo "</tr>";
		}
		echo "</table><input name='contactchecklist' id='contactchecklist' type='hidden' value='".implode('_c|', array_keys($finalContactsList))."_c'>
		</div>
		</td></tr>
		</table>
		</form>";
	}
	else
	{
		$msg = !empty($msg)? $msg: 'ERROR: No contacts could be obtained.';
		echo format_notice($msg);
	}
	
}
#Getting the contacts
else
{
	if(!empty($msg))
	{
		echo format_notice($msg);
	}
	else if(!empty($service) && $service == 'GMAIL')
	{
		echo "<img src='".base_url()."assets/images/loading.gif' border='0'/>";
	}
	else
	{
		echo format_notice('ERROR: No contacts could be obtained.');
	}
}
?>
</body>
</html>