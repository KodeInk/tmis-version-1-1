<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
<script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
</head>
<body>		
<?php 
#

/**********************************************************
 * This file obtains and processes social network contacts
 **********************************************************/

#Process the response
if(!empty($connectionApproved) && $connectionApproved)
{
	if(!empty($msg))
	{
		echo format_notice($msg);
	}
	
	
	#Was the response a success
	if(!empty($response) && $response['success'] === TRUE) 
	{
         $_SESSION['oauth']['linkedin']['authorized'] = (isset($_SESSION['oauth']['linkedin']['authorized'])) ? $_SESSION['oauth']['linkedin']['authorized'] : FALSE;
		 $connections = new SimpleXMLElement($response['linkedin']); 
         if((int)$connections['total'] > 0) 
		 {
			 $msgTemplate = get_confirmation_messages($this, array('emailaddress'=>"", 'firstname'=>'', 'fromname'=>$_SESSION['first_name']." ".$_SESSION['last_name'], 'fromemail'=>$_SESSION['email_address']), 'user_invitation');
			 
			 echo "<form action='".base_url()."web/network/send_linkedin_message' method='post'><table width='100%'> 
		<tr>
		<td class='pagesubtitle' width='99%' style='text-align:left;padding-top:0px;'>Your ".(!empty($service)? $service: '')." Contacts<br>
<span class='ariallabel greytext'>Select contacts and click the Send button to send <a href='javascript:;' onclick=\"toggleLayersOnCondition('send_message_details', 'send_message_details')\" class='bluebold'>an invitation</a></span>
</td>
		<td width='1%' valign='top'><input type='submit' name='send_invitations' id='send_invitations' class='purplebtn' value='Send' style='width:90px;'></td>
		</tr>
		
		<tr><td colspan='2'><div id='send_message_details' class='ariallabel greytext' style='border: solid 1px #E0E0E0;padding:10px;display:none;'><div style='float:right;cursor:pointer;' onclick=\"toggleLayersOnCondition('send_message_details', 'send_message_details')\"><img src='".base_url()."assets/images/remove_icon.png'></div>".$msgTemplate['message']."</div></td></tr>
		
		
		<tr><td colspan='2'>
		<table width='100%' border='0' cellspacing='0' cellpadding='5'><tr>
		<td width='98%'>Showing ".(MAX_EMAIL_BATCH_COUNT > $connections['total']? $connections['total']:MAX_EMAIL_BATCH_COUNT)." of ".$connections['total']." total connections:</td>
		<td><input type='checkbox' id='selectall' name='selectall' value='allcontacts' onChange=\"selectAll(this,'contactchecklist')\"/></td><td style='font-weight:bold;' nowrap>Select All</td>
		<td><input type='checkbox' id='sendmecopy' name='sendmecopy' value='YES'/></td><td nowrap>Send me a copy</td></tr></table>
		</td></tr>
		
		<tr><td colspan='2'>
		<div style='max-height:450px; overflow:auto;'>";
			$allCheckIds = "";
		
			#GO through all checkids and show the contacts
			foreach($connections->person AS $connection) 
			{
				$name = $connection->{'first-name'}." ".$connection->{'last-name'};
				$contactArray = array('owner_user_id'=>$_SESSION['userId'], 'source'=>'LINKEDIN', 'name'=>$name, 'email_address'=>$connection->id."@linkedin.com", 'photo_url'=>$connection->{'picture-url'});
				$addResponse = $this->referral_manager->add_new_contact($contactArray);
			
			
				echo "<div style='float: left; width: 150px; border: 1px solid #888; margin: 0.5em; text-align: center;'>";
            
            	if($connection->{'picture-url'}) 
				{
           			echo "<img src='".$connection->{'picture-url'}."' alt='' title='' width='80' height='80' style='display: block; margin: 0 auto; padding: 5px;' />";
				} 
				else 
				{
               		echo "<img src='".base_url()."assets/images/anonymous.png' alt='' title='' width='80' height='80' style='display: block; margin: 0 auto; padding: 5px;' />";
            	}
            
				if(empty($addResponse['last_invitation_sent_on']) || (!empty($addResponse['can_send']) && $addResponse['can_send'] == 'YES'))
				{
					echo "<input type='checkbox' name='connections[]' id='connection_".$connection->id."' value='".$connection->id."' />";
				}
				echo "<label for='connection_".$connection->id."'>".$name."</label>";
			
				if(!empty($addResponse['last_invitation_sent_on']))
				{
					echo "<div><img src='".base_url()."assets/images/send_mail_icon.png'/> <span class='greytext smalltxt'>(".date('m/d/Y', strtotime($addResponse['last_invitation_sent_on'])).")</span></div>";
				}
			
				echo "</div>";
			 
			 	$allCheckIds .= "|connection_".$connection->id;
			}
			
			echo "</table><input name='contactchecklist' id='contactchecklist' type='hidden' value='".trim($allCheckIds, "|")."'>
			</div>
			</td></tr>
			</table>
			</form>";
			 
			   
		 }
		 else if(empty($msg))
		 {
			 echo format_notice('WARNING: You do not have any LinkedIn connections to display.');
	     }
	}
	else if(empty($msg))
	{
		echo format_notice('ERROR: There was a problem connecting to your LinkedIn account.');
	}
}
#There was a problem
else
{
	if(!empty($msg))
	{
		echo format_notice($msg);
	}
	else
	{
		echo format_notice('ERROR: No contacts could be obtained.');
	}
}
?>
</body>
</html>