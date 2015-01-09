<?php
/**
 * Used to define all messages sent to users.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 02/19/2014
 */


#Define emails 
function get_confirmation_messages($obj, $formdata, $emailType)
{
	$emailto = '';
	$emailcc = '';
	$emailbcc = '';
	$emailHTML = '';
	$subject = '';
	$fileUrl = '';
	$formdata['messageid'] = generate_msg_id();
	$siteUrl = substr(base_url(), 0, -1);
	$unsubscribeUrl = base_url()."unsubscribe/e/".encrypt_value($formdata['emailaddress']);
	$trackerImage = "<img src='".base_url()."web/network/email_invite_confirmation/e/".encrypt_value($formdata['emailaddress'])."'/>";
	
	
	switch ($emailType) 
	{
		case 'signup_confirmation':
			$emailto = $formdata['emailaddress'];
			$emailbcc = SITE_ADMIN_MAIL;
			
			$subject = "An account for ".$formdata['emailaddress']." has been created at ".SITE_TITLE;
			
			$emailHTML = 	"Hi ".$formdata['firstname'].",
							<br><br>
							Welcome to ".SITE_TITLE.".
							<br><br>
							To activate your account, go to:
							<br>".base_url()."c/".$formdata['cloutid']."
							<br><br>This link will expire in 1 hour.";
							
			
			$emailHTML .= 	"<br><br>
							Regards,<br><br>
							Your team at ".SITE_TITLE."<br>
							".$siteUrl;
		break;
		
		
		
		case 'forgot_password_link':
			$emailto = $formdata['emailaddress'];
			$emailbcc = SITE_ADMIN_MAIL;
			
			$subject = "Password request for ".$formdata['emailaddress']." at ".SITE_TITLE;
			
			$emailHTML = 	"Hi ".$formdata['firstname'].",
							<br><br>
							You requested a link to reset your password at ".SITE_TITLE.".
							<br><br>
							To enter a new password, please go to:
							<br>".base_url()."p/".$formdata['cloutid']."
							<br><br>This link will expire in 1 hour.
							<br>If you did not request the new password, please contact us immediately at ".SECURITY_EMAIL;
							
			
			$emailHTML .= 	"<br><br>
							Regards,<br><br>
							Your team at ".SITE_TITLE."<br>
							".$siteUrl;
		break;
		
		
		
		
		case 'password_change_notice':
			$emailto = $formdata['emailaddress'];
			
			$subject = "Your password has been changed at ".SITE_TITLE;
			$call = !empty($formdata['firstname'])? $formdata['firstname']: $formdata['emailaddress'];
			$emailHTML = $call.",
						<br><br>
						Your password has been changed at ".SITE_TITLE.
						"<br><br>If you did not change your password or authorize its change, please contact us immediately at ".SECURITY_EMAIL;
			
			$emailHTML .= 	"<br><br>
						Regards,<br><br>
						Your team at ".SITE_TITLE."<br>
						".$siteUrl;
		break;
		
		
		
		
		
		case 'send_sys_msg_by_email':
			$emailto = NOREPLY_EMAIL;
			$emailbcc = $formdata['emailaddress'];
			
			$subject = $formdata['subject'];
			
			$emailHTML = "The following message has been sent to you from ".SITE_TITLE.":<br><hr>".nl2br($formdata['details'])
			."<hr><br>To respond to the above message, please login at:<br>"
			.base_url()."admin/login".
			"<br><br>and click on the messages icon to respond.";
			
			$emailHTML .= 	"<br><br>
							Regards,<br><br>
							Your team at ".SITE_TITLE."<br>
							".$siteUrl;
		break;
		
		
		
		
		
		
		
		
		case 'website_feedback':
			$emailto = $formdata['emailaddress'];
			$emailbcc = SITE_ADMIN_MAIL;
			
			$subject = "Your message to ".SITE_TITLE." has been received.";
			
			$emailHTML = "Hello,
						<br><br>
						Your message to ".SITE_TITLE." has been received. If necessary, you will be notified when our staff answers your message.<br>The details of your message are included below:
						<br><br>";
						
			$emailHTML .= "<table>
						<tr><td nowrap><b>Your email address:</b></td><td>".$formdata['emailaddress']."</td></tr>
						<tr><td nowrap><b>What do you need help with?</b></td><td>".$formdata['helptopic']."</td></tr>
						<tr><td nowrap><b>Subject:</b></td><td>".$formdata['subject']."</td></tr>
						<tr><td nowrap><b>Description:</b></td><td>".$formdata['description']."</td></tr>";
			
			if(!empty($formdata['attachmenturl']))
			{
				$emailHTML .= "<tr><td><b>Attachment:</b></td><td><a href='".base_url()."documents/force_download/f/".encryptValue('attachments')."/u/".encryptValue($formdata['attachmenturl'])."'>".$formdata['attachmenturl']."</a></td></tr>";
			}
						
			$emailHTML .= "</table>";
			
			$emailHTML .= 	"<br><br>
						Regards,<br><br>
						Your team at ".SITE_TITLE."<br>
						".$siteUrl;
		break;
		
		
		
		
		case 'user_invitation':
		
			$emailto = $formdata['emailaddress'];
			$subject = "Invitation from ".$formdata['fromname'];
			$emailfrom = !empty($formdata['fromemail'])? $formdata['fromemail']: $obj->native_session->get('email_address');
			#Get default referral ID
			$referral = $obj->db->query($obj->query_reader->get_query_by_code('get_user_default_referral_id', array('member_email'=>$formdata['fromemail'])))->row_array();
			$referral['default_url_id'] = !empty($referral['default_url_id'])? $referral['default_url_id']:$obj->native_session->get('cloutId'); 
			
			$emailHTML = "Hi";
			$emailHTML .= !empty($formdata['firstname'])? " ".$formdata['firstname']."": "";
			$emailHTML .= ",<br><br>Check this out!
							<br><br>I linked my debit and credit cards to Clout. Now I automatically get Cash Back added to my account when I spend at Clout affiliated merchants. It's one click to link your card and start getting Cash Back. It's free.
							<br><br>Here's the link:<br>".
							base_url()."u/".$referral['default_url_id'];
			
			$emailHTML .= 	"<br><br>
						Regards,<br>
						".$formdata['fromname']."<br><br><br><br>
						
						<span style='font-size:12px;color:#919191;'>Already a member under a different email? Click here:<br>
						<a href='".$unsubscribeUrl."/a/verifyaltemail'>".$unsubscribeUrl."/a/verifyaltemail</a></span>".
						
						
						"<br><br>  <span style='font-size:12px;color:#919191;'>To stop receiving invitations from this person, please click here:<br>
						<a href='".$unsubscribeUrl."/a/unsubscribe'>".$unsubscribeUrl."/a/unsubscribe</a></span>";
			
		break;
		
		
		
		
		case 'signup_submission_notification':
			$emailto = $formdata['emailaddress'];
			$emailcc = $formdata['contactemail'];
			$emailbcc = SITE_ADMIN_MAIL;
			
			$subject = "Business profile submitted for ".$formdata['businessname']." at ".SITE_TITLE;
			
			$emailHTML = 	"Hi ".$formdata['firstname'].",
							<br><br>
							You or a representative of your business has submitted your business' profile for consideration to be added to ".SITE_TITLE.".
							<br>We will notify you about your next steps as soon as your profile has been reviewed.
							<br><br>
							Please login using the registered user email to make updates to your profile and enjoy your Clout at:
							<br>".base_url()."
							<br><br>If you did not request your profile submission or do not know who requested it, please contact us immediately at ".SECURITY_EMAIL;
							
			
			$emailHTML .= 	"<br><br>
							Regards,<br><br>
							Your team at ".SITE_TITLE."<br>
							".$siteUrl;
		break;
		
		
		
		
		case 'send_store_schedule':
			$emailto = $formdata['emailaddress'];
			$emailcc = $formdata['useremail'];
			$emailbcc = SITE_ADMIN_MAIL;
			
			$subject = "Booking Made For ".$formdata['fromname']." On ".date('m/d/Y h:ia', strtotime($formdata['scheduledate']));
			
			$emailHTML = 	$formdata['fromname']." has submitted a booking from ".SITE_TITLE.". <br>The details of the booking are included below:
							<br>
							<table>
							<tr><td>Name:</td><td>".html_entity_decode($formdata['fromname'], ENT_QUOTES)."</td></tr>
							<tr><td>Email:</td><td>".$formdata['useremail']."</td></tr>
							<tr><td>Phone:</td><td>".format_phone_number($formdata['phonenumber'])." (".$formdata['phonetype'].")</td></tr>
							<tr><td>Date:</td><td>".date('m/d/Y h:ia', strtotime($formdata['scheduledate']))."</td></tr>
							<tr><td>Number in Party:</td><td>".$formdata['noinparty']."</td></tr>
							<tr><td valign='top'>Special Requests:</td><td>".html_entity_decode($formdata['specialrequest'], ENT_QUOTES)."</td></tr>
							</table>";
							
			
			$emailHTML .= 	"<br><br>
							Regards,<br><br>
							Your team at ".SITE_TITLE."<br>
							".$siteUrl;
		break;
		
		
		
		case 'store_suggestion':
			$emailto = $formdata['emailaddress'];
			
			$subject = "Add Store Suggestion: ".addslashes($formdata['store_name']);
			
			$emailHTML = 	$formdata['from_name']." has submitted a store suggestion at ".SITE_TITLE.". <br>The details of the suggestion are included below:
							
							<table>
							<tr><td nowrap>Store Name:</td><td>".htmlentities($formdata['store_name'], ENT_QUOTES)."</td></tr>
							<tr><td nowrap>Contact Name:</td><td>".htmlentities($formdata['contact_name'], ENT_QUOTES)."</td></tr>
							<tr><td nowrap>Contact Phone:</td><td>".format_phone_number($formdata['contact_phone'])."</td></tr>
							<tr><td>Website:</td><td>".$formdata['store_website']."</td></tr>
							<tr><td valign='top' nowrap>Store Address:</td><td>".$formdata['store_address']."<br>".$formdata['store_city']."<br>".$formdata['store_zipcode'].", ".$formdata['store_state']." (".$formdata['store_country'].")</td></tr>
							<tr><td valign='top' nowrap>Suggested By:</td><td>".$formdata['from_name']." (".$formdata['from_email'].")</td></tr>
							</table>";
							
			
			$emailHTML .= 	"<br><br>
							Regards,<br><br>
							Your team at ".SITE_TITLE."<br>
							".$siteUrl;
		
		
		break;
		
		
		
		
		
		case 'bank_suggestion':
			$emailto = $formdata['emailaddress'];
			
			$subject = "Add Bank Suggestion: ".addslashes($formdata['bank_name']);
			
			$emailHTML = 	$formdata['from_name']." has submitted a bank suggestion at ".SITE_TITLE.". <br>The details of the suggestion are included below:
							
							<table>
							<tr><td nowrap>Bank Name:</td><td>".addslashes($formdata['bank_name'])."</td></tr>
							<tr><td valign='top' nowrap>Suggested By:</td><td>".$formdata['from_name']." (".$formdata['from_email'].")</td></tr>
							</table>";
							
			
			$emailHTML .= 	"<br><br>
							Regards,<br><br>
							Your team at ".SITE_TITLE."<br>
							".$siteUrl;
		
		
		break;
		
		
		
		
		
		
		
		
		
		
		
		
		
		default:
			$emailto = $formdata['emailaddress'];
			if(!empty($formdata['subject'])){
				$subject = $formdata['subject'];
			}
			else
			{
				$subject = SITE_TITLE." Message";
			}
			
			$emailHTML = $formdata['message'];
			
		break;
	}
	
	$emailHTML .= "<br><br>MESSAGE ID: ".$formdata['messageid'];
	
	return array('emailto'=>$emailto, 'emailcc'=>$emailcc, 'emailbcc'=>$emailbcc, 'subject'=>$subject, 'message'=>$emailHTML, 'fileurl'=>$fileUrl);
}


#Function to generate a message ID
function generate_msg_id()
{
	return "CL".strtotime('now');
}




#Function to generate a password
function generate_new_password()
{
	return "CL".substr(strtotime('now')."", -4);
}




#Function to generate a standard password
function generate_standard_password()
{
	return strtoupper(generate_random_letter()).strtolower(generate_random_letter().generate_random_letter()).substr(strtotime('now')."", -4);
}




#Function to generate a random letter
function generate_random_letter()
{
	$characters = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O", "P","Q","R","S","T","U","V","W","X","Y","Z");
	$x = mt_rand(0, count($characters)-1);
	
	return $characters[$x];
}



#Function to generate a random character
function generate_random_character()
{
	$characters = array("_","@","#", "$", "%", "*", "!", "?", "-");
	$x = mt_rand(0, count($characters)-1);
	
	return $characters[$x];
}


#Function to generate a clout ID for any user given their USER ID
function generate_system_id($obj,$userId, $accountType='normal')
{
	#First convert the ID FROM decimal to hexadecimal
	$bareId = strtoupper(convert_bases($userId, '0123456789', '0123456789ABCDEF'));
	
	if($accountType == 'merchant')
	{
		#Get the user email for use in coding
		$user = $obj->db->query($obj->query_reader->get_query_by_code('get_store_by_attributes', array('query_part'=>" S.id='".$userId."' " )))->row_array();
		$finalId = "C".$bareId.strtoupper(substr($user['email_address'],0,2));
		
		#Update the referral system with the user's new ID
		$result1 = $obj->db->query($obj->query_reader->get_query_by_code('update_store_value', array('store_id'=>$userId, 'field_name'=>'store_clout_id', 'field_value'=>$finalId)));
		
	}
	else
	{
		#Get the user email for use in coding
		$user = $obj->db->query($obj->query_reader->get_query_by_code('get_user_by_id', array('id'=>$userId )))->row_array();
		$finalId = "C".$bareId.strtoupper(substr($user['email_address'],0,2));
		
		#Update the referral system with the user's new ID
		$result1 = $obj->db->query($obj->query_reader->get_query_by_code('update_user_value', array('user_id'=>$userId, 'field_name'=>'clout_id', 'field_value'=>$finalId)));
		#If there is no referral ID for the user with their clout ID, then add it
		$referralDetails = $obj->db->query($obj->query_reader->get_query_by_code('get_referral_url_ids', array('user_id'=>$userId, 'conditions'=>'')))->row_array();
		if(empty($referralDetails))
		{
			$result2 = $obj->db->query($obj->query_reader->get_query_by_code('add_referral_urls_list', array('user_id'=>$userId, 'url_id'=>$finalId, 'is_active'=>'Y', 'is_primary'=>'Y')));
		}
	}
	
	return $finalId;
}


#Function to get the USER ID from the clout ID
function get_user_id_from_system_id($sysId)
{
	#Extract important part of the user ID by removing the first letter and last 2 letters
	$usefulPart = substr($sysId, 1, -2);
	return convert_bases($usefulPart, '0123456789ABCDEF', '0123456789');	
}




#Function to make an object array (to enable tracking) out of a normal message from a redirection
function handle_redirected_msgs($obj, $data)
{
	if(!empty($data['msg']) && !is_array($data['msg'])){
		if(strcasecmp(substr($data['msg'], 0, 6), 'WARNING:') == 0){
			$error_code = "9902";
		}
		else
		{
			$error_code = "0";
		}
			
		$data['msg'] = array('obj'=>$obj, 'code'=>$error_code, 'details'=>$data['msg']);
	}
		
	return $data;
}





#Check the sending settings for a user
function check_sending_settings($obj, $storeId, $format) 
{
	$store = $obj->db->query($obj->query_reader->get_query_by_code('get_store_by_attributes', array('query_part'=>" S.id='".$storeId."' " )))->row_array();
	
	return (!empty($store['send_me_by_'.$format]) && $store['send_me_by_'.$format] == 'Y')? TRUE: FALSE;
}




?>