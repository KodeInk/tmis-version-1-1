<?php

/**
 * This class manages formatting and sending of emails.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 11/26/2013
 */
 
class Sys_email extends CI_Model {
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->library('email');
    }
	
	#Function to email data from a form
	function email_form_data($urlData, $formData, $emailType='')
	{
		#use defaults if there are no emails given
		if(!empty($urlData['fromemail']))
		{
			if(empty($urlData['fromname'])){
				$fromName = $urlData['fromemail'];
			} else {
				$fromName = $urlData['fromname'];
			}
			$this->email->from($urlData['fromemail'], $fromName);
			$this->email->reply_to($urlData['fromemail'], $fromName);
		}
		else
		{
			$this->email->from($_SESSION['emailaddress'], $_SESSION['names']);
			$this->email->reply_to($_SESSION['emailaddress'], $_SESSION['names']);
		}
		
		$this->email->to($formData['emailto']);
		if(!empty($formData['emailcc']) && trim($formData['emailcc']) != '')
		{
			$this->email->cc($formData['emailcc']);
		}
		if(!empty($formData['emailbcc']) && trim($formData['emailbcc']) != '')
		{
			$this->email->bcc($formData['emailbcc']);
		}
		
		$this->email->subject($formData['subject']);
		$this->email->message($formData['message']);
		
		if(isset($formData['fileurl']) && trim($formData['fileurl']) != '')
		{
			$this->email->attach($formData['fileurl']);
		}
		
		#Use this line to test sending of email without actually sending it
		#return $this->email->print_debugger();
		
		return $this->email->send();
	}
	
	
	
	
	#function to get the recipients of a given message
	function get_msg_recipientids($msgId)
	{
		$recipients = array();
		$receivedBy = $this->db->query($this->Query_reader->get_query_by_code('get_recipients_for_msg', array('messageid'=>$msgId )));
		$recipientsRows = $receivedBy->result_array();
		foreach($recipientsRows AS $row)
		{
			array_push($recipients, $row['userid']);
		}
			
		return $recipients;
	}
}

?>