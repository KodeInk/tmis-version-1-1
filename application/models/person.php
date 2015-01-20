<?php
/**
 * This class manages addition, removal and update of the person in the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class Person extends CI_Model
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->helper('form');
	}
	
	# Add a person's profile
	function add_profile($profileDetails)
	{
		$msg = "";
		$required = array('firstname', 'lastname', 'emailaddress', 'gender', 'marital', 'birthday', 'birthplace');
		
		# 1. Add all provided data into the session
		$passed = process_fields($this, $profileDetails, $required, array("/"));
		$msg = !empty($passed['msg'])? $passed['msg']: "";
			
		# 2. Save the data into the database
		if($passed['boolean'])
		{
			$details = $passed['data'];
			
			# First check if a user with the given email already exists
			$check = $this->query_reader->get_row_as_array('get_user_by_email', array('email_address'=>$details['emailaddress']));
			if(empty($check) && !$this->native_session->get('person_id'))
			{
				# Determine whether to update the data or to create a new record
				if($this->native_session->get('person_id'))
				{
					$updateResult = $this->update_profile($this->native_session->get('person_id'), $details);
					$result = $updateResult['boolean'];
					$msg = $updateResult['msg'];
				}
				else
				{
					$personId = $this->query_reader->add_data('add_person_data', array('first_name'=>htmlentities($details['firstname'], ENT_QUOTES), 'last_name'=>htmlentities($details['lastname'], ENT_QUOTES), 'gender'=>$details['gender'], 'date_of_birth'=>format_date($details['birthday'], 'YYYY-MM-DD') )); 
			
					if(!empty($personId) || $personId == 0)
					{
						$emailContactId = $this->query_reader->add_data('add_contact_data', array('contact_type'=>'email', 'carrier_id'=>'', 'details'=>$details['emailaddress'], 'parent_id'=>$personId, 'parent_type'=>'person'));
						if(!empty($details['telephone'])) 
						{
							$phoneContactId = $this->query_reader->add_data('add_contact_data', array('contact_type'=>'telephone', 'carrier_id'=>'', 'details'=>$details['telephone'], 'parent_id'=>$personId, 'parent_type'=>'person'));
						}
						# Save the birth place
						$birthPlaceId = $this->add_address($personId, array('address_type'=>'physical', 'importance'=>'birthplace', 'details'=>htmlentities($this->native_session->get('birthplace__addressline'), ENT_QUOTES), 'district'=>$this->native_session->get('birthplace__district'), 'country'=>$this->native_session->get('birthplace__country'), 'county'=>($this->native_session->get('birthplace__county')? $this->native_session->get('birthplace__county'): "") ));
		
						# 3. Create an account and generate a confirmation code
						# For the first account, use the user's email address as the login username.
						$password = generate_temp_password();
						$code = generate_person_code($personId);
						$userId = $this->query_reader->add_data('add_user_data', array('person_id'=>$personId, 'login_name'=>$details['emailaddress'], 'login_password'=>sha1($password) ));
						if(empty($userId)) 
						{
							$msg = "ERROR: We could not create your user record.";
						}
						else
						{
							$this->native_session->set('user_id', $userId);
						}
					
						# 4. Send confirmation code to contacts
						$result = $this->messenger->send_email_message($userId, array('code'=>'new_teacher_first_step', 'email_from'=>SIGNUP_EMAIL, 'from_name'=>SITE_GENERAL_NAME, 'verification_code'=>$code, 'password'=>$password, 'first_name'=>htmlentities($details['firstname'], ENT_QUOTES), 'emailaddress'=>$details['emailaddress'], 'login_link'=>base_url() ));
						if(!$result) $msg = "ERROR: We could not send the email message with your code.";
						if($result) $this->native_session->set('person_id', $personId);
					}
					else
					{
						$msg = "ERROR: We could not create your record.";	
					}
				}
			} 
			else 
			{
				$msg = "WARNING: A user with the email entered already exists. Please login or recover your password to continue.";
			}
		} 
		else
		{
			$msg = !empty($msg)? $msg: "WARNING: Some required fields were left empty or entered with invalid characters. Please recheck your data and submit.";
		}
		
		return array('boolean'=>(!empty($result)? $result: false), 'msg'=>$msg);
	}
	
	
	
	# Add a person's address
	function add_address($personId, $addressDetails)
	{
		return $this->query_reader->add_data('add_new_address', array('parent_id'=>$personId, 'parent_type'=>'person', 'address_type'=>$addressDetails['address_type'], 'importance'=>$addressDetails['importance'], 'details'=>$addressDetails['details'], 'county'=>$addressDetails['county'], 'district'=>$addressDetails['district'], 'country'=>$addressDetails['country']));
	}	
		
	
	
	# Update the person's profile
	function update_profile($personId, $details)
	{
		$results = array();
		
		$result = $this->query_reader->run('update_person_data', array('person_id'=>$personId, 'first_name'=>htmlentities($details['firstname'], ENT_QUOTES), 'last_name'=>htmlentities($details['lastname'], ENT_QUOTES), 'gender'=>$details['gender'], 'date_of_birth'=>format_date($details['birthday'], 'YYYY-MM-DD') )); 
		array_push($results, $result);
		
		if(!empty($details['telephone'])) 
		{
			$result = $this->query_reader->run('update_contact_data', array('contact_type'=>'telephone', 'carrier_id'=>'', 'details'=>$details['telephone'], 'parent_id'=>$personId, 'parent_type'=>'person'));
			array_push($results, $result);
		}
		
		$result = $this->query_reader->run('update_address_data', array('parent_id'=>$personId, 'parent_type'=>'person', 'address_type'=>'physical', 'importance'=>'birthplace', 'details'=>htmlentities($this->native_session->get('birthplace__addressline'), ENT_QUOTES), 'district'=>$this->native_session->get('birthplace__district'), 'country'=>$this->native_session->get('birthplace__country'), 'county'=>($this->native_session->get('birthplace__county')? $this->native_session->get('birthplace__county'): "") ));
		array_push($results, $result);
		
		$isUpdated = get_decision($results);
		
		return array('boolean'=>$isUpdated, 'msg'=>($isUpdated? 'Your profile has been updated.': 'ERROR: Your profile could not be updated.'));
	}	
	
	
	
	# Add identification and contact addresses for the person
	function add_id_and_contacts($personId, $addressDetails)
	{
		$this->load->model('validator');
		$msg = "";
		$required = array('verificationcode', 'permanentaddress', 'contactaddress', 'citizenship__country', 'citizenship__citizentype');
		
		# 1. Add all provided data into the session
		$passed = process_fields($this, $addressDetails, $required, array("/"));
		
		if($passed['boolean'])
		{
			$details = $passed['data'];
			
			# Determine whether to update the data or to create a new record
			if($this->native_session->get('edit_step_2'))
			{
				$updateResult = $this->update_id_and_contacts($personId, $details);
				$result = $updateResult['boolean'];
				$msg = $updateResult['msg'];
			}
			# New record
			else
			{
				# 2. Verify the confirmation code
				if($this->validator->is_valid_confirmation_code($personId, $details['verificationcode']))
				{
					# Activate teacher user ID
					$result = $this->query_reader->run('activate_teacher_user', array('person_id'=>$personId));
					
					# 3. Save all the data into the database
					if(!empty($details['teacherid'])) 
					{
						$this->add_another_id($personId, array('id_type'=>'teacher_id', 'id_value'=>$details['teacherid']));
					}
					#Save permanent and contact addresses
					$permanentId = $this->add_address($personId, array('address_type'=>$this->native_session->get('permanentaddress__addresstype'), 'importance'=>'permanent', 'details'=>htmlentities($this->native_session->get('permanentaddress__addressline'), ENT_QUOTES), 'district'=>$this->native_session->get('permanentaddress__district'), 'country'=>$this->native_session->get('permanentaddress__country'), 'county'=>($this->native_session->get('permanentaddress__county')? $this->native_session->get('permanentaddress__county'): "") ));
					$contactId = $this->add_address($personId, array('address_type'=>$this->native_session->get('contactaddress__addresstype'), 'importance'=>'contact', 'details'=>htmlentities($this->native_session->get('contactaddress__addressline'), ENT_QUOTES), 'district'=>$this->native_session->get('contactaddress__district'), 'country'=>$this->native_session->get('contactaddress__country'), 'county'=>($this->native_session->get('contactaddress__county')? $this->native_session->get('contactaddress__county'): "") ));
				
					#Save the citizenship information
					$result = $this->query_reader->run('update_person_citizenship', array('person_id'=>$personId, 'citizen_country'=>htmlentities($details['citizenship__country'], ENT_QUOTES), 'citizenship_type'=>$details['citizenship__citizentype'] ));
				
					if($result) {
						$this->native_session->set('edit_step_2', 'Y');
					} else {
						$msg = "ERROR: We could not save your information. Please try again.";
					}
				}
				else
				{
					$msg = "WARNING: The provided confirmation code is not valid. Please re-check your email message.";
				}
			}
		}
		else
		{
			$msg = "WARNING: Some required fields were left empty or entered with invalid characters. Please recheck your data and submit.";
		}
		
		# 4. Prepare appropriate message and return
		return array('boolean'=>(!empty($result)? $result: false), 'msg'=>$msg);
	}
	
		
	
	
	# Add another ID that identifies that person on a third party system
	function add_another_id($personId, $idDetails)
	{
		return $this->query_reader->add_data('add_another_id', array('parent_id'=>$personId, 'parent_type'=>'person', 'id_type'=>$idDetails['id_type'], 'id_value'=>$idDetails['id_value']));
	}	
	
	
	# Update the person's ID and contact details
	function update_id_and_contacts($personId, $details)
	{
		$results = array();
		
		if(!empty($details['teacherid'])) 
		{
			$result = $this->query_reader->run('update_another_id', array('parent_id'=>$personId, 'parent_type'=>'person', 'id_type'=>'teacher_id', 'id_value'=>$details['teacherid']));
		}
		
		$result = $this->query_reader->run('update_address_data', array('parent_id'=>$personId, 'parent_type'=>'person', 'address_type'=>$this->native_session->get('permanentaddress__addresstype'), 'importance'=>'permanent', 'details'=>htmlentities($this->native_session->get('permanentaddress__addressline'), ENT_QUOTES), 'district'=>$this->native_session->get('permanentaddress__district'), 'country'=>$this->native_session->get('permanentaddress__country'), 'county'=>($this->native_session->get('permanentaddress__county')? $this->native_session->get('permanentaddress__county'): "") ));
		array_push($results, $result);
		
		
		$result = $this->query_reader->run('update_address_data', array('parent_id'=>$personId, 'parent_type'=>'person', 'address_type'=>$this->native_session->get('contactaddress__addresstype'), 'importance'=>'contact', 'details'=>htmlentities($this->native_session->get('contactaddress__addressline'), ENT_QUOTES), 'district'=>$this->native_session->get('contactaddress__district'), 'country'=>$this->native_session->get('contactaddress__country'), 'county'=>($this->native_session->get('contactaddress__county')? $this->native_session->get('contactaddress__county'): "") ));
		array_push($results, $result);
				
		#Save the citizenship information
		$result = $this->query_reader->run('update_person_citizenship', array('person_id'=>$personId, 'citizen_country'=>htmlentities($details['citizenship__country'], ENT_QUOTES), 'citizenship_type'=>$details['citizenship__citizentype'] ));
		array_push($results, $result);
		
		$isUpdated = get_decision($results);
		
		return array('boolean'=>$isUpdated, 'msg'=>($isUpdated? 'Your ID and contact information has been updated.': 'ERROR: Your ID and contact information could not be updated.'));
	}	
	
		
	
	
	# Add the person's education
	function add_education($personId, $educationDetails)
	{
		$msg = "";
		$required = array('institutionname', 'institution__institutiontype', 'from__month', 'from__pastyear', 'to__month', 'to__pastyear', 'certificatename', 'certificatenumber');
		$isAdded = false;
		
		$passed = process_fields($this, $educationDetails, $required);
		
		if($passed['boolean'])
		{
			$details = $passed['data'];
			
			# Make sure the "to" is greater than the "from" date
			if((strtotime($details['to__month'].' 01, '.$details['to__pastyear']) - strtotime($details['from__month'].' 01, '.$details['from__pastyear'])) > 0)
			{
				# Determine whether to update the data or to create a new record
				if($this->native_session->get('edit_step_3_education') && !empty($details['education_id']))
				{
					$updateResult = $this->update_education($personId, $details);
					$isAdded = $updateResult['boolean'];
					$msg = $updateResult['msg'];
				}
				# New record - add to the education session array
				else
				{
					$educationList = $this->native_session->get('education_list')? $this->native_session->get('education_list'): array();
					
					$education = array('institutionname'=>$details['institutionname'], 'institution__institutiontype'=>$details['institution__institutiontype'], 'from__month'=>$details['from__month'], 'from__pastyear'=>$details['from__pastyear'], 'to__month'=>$details['to__month'], 'to__pastyear'=>$details['to__pastyear'], 'certificatename'=>$details['certificatename'], 'certificatenumber'=>$details['certificatenumber'], 'highestcertificate'=>(!empty($details['highestcertificate'])? $details['highestcertificate']: ""), 'education_id'=>strtotime('now'));
					
					array_push($educationList, $education);
					$this->native_session->set('education_list', $educationList);
					$isAdded = true;
				}
			}
			else
			{
				$msg = "WARNING: The start date can not be equal to or greater than the end date.";
			}
		}
		
		return array('boolean'=>$isAdded, 'msg'=>(!empty($msg)? $msg: 'Your education information has been added.'));
	}	
		
	
		
	
	
	# Update the person's education
	function update_education($personId, $details)
	{
		$isUpdated = false;
		$list = $this->native_session->get('education_list');
		$position = get_row_from_list($list, 'education_id', $details['education_id'], 'key');
		
		if(!empty($position) || $position == 0)
		{
			$list[$position] = array('institutionname'=>$details['institutionname'], 'institution__institutiontype'=>$details['institution__institutiontype'], 'from__month'=>$details['from__month'], 'from__pastyear'=>$details['from__pastyear'], 'to__month'=>$details['to__month'], 'to__pastyear'=>$details['to__pastyear'], 'certificatename'=>$details['certificatename'], 'certificatenumber'=>$details['certificatenumber'], 'highestcertificate'=>(!empty($details['highestcertificate'])? $details['highestcertificate']: ""), 'education_id'=>$details['education_id']);
			
			$this->native_session->set('education_list', $list);
			$isUpdated = true;
		}
		
		return array('boolean'=>$isUpdated, 'msg'=>'Your education information has been updated.');
	}
	
	
	
	
	
	# Add a subject taught
	function add_subject_taught($personId, $subjectDetails)
	{
		$msg = "";
		$required = array('subjectname', 'subject__subjecttype');
		$isAdded = false;
		
		$passed = process_fields($this, $subjectDetails, $required);
		
		if($passed['boolean'])
		{
			$details = $passed['data'];
			
			# Determine whether to update the data or to create a new record
			if($this->native_session->get('edit_step_3_subject') && !empty($details['subject_id']))
			{
				$updateResult = $this->update_subject_taught($personId, $details);
				$isAdded = $updateResult['boolean'];
				$msg = $updateResult['msg'];
			}
			# New record - add to the subject session array
			else
			{
				$subjectList = $this->native_session->get('subject_list')? $this->native_session->get('subject_list'): array();
					
				$subject = array('subjectname'=>$details['subjectname'], 'subject__subjecttype'=>$details['subject__subjecttype'], 'subject_id'=>strtotime('now'));
					
				array_push($subjectList, $subject);
				$this->native_session->set('subject_list', $subjectList);
				$isAdded = true;
			}
		}
		
		return array('boolean'=>$isAdded, 'msg'=>(!empty($msg)? $msg: 'Your subject information has been added.'));
	}
		
	
	
	# STUB: Update the person's subjects taught
	function update_subject_taught($personId, $details)
	{
		$isUpdated = false;
		$list = $this->native_session->get('subject_list');
		$position = get_row_from_list($list, 'subject_id', $details['subject_id'], 'key');
		
		if(!empty($position) || $position == 0)
		{
			$list[$position] = array('subjectname'=>$details['subjectname'], 'subject__subjecttype'=>$details['subject__subjecttype'], 'subject_id'=>$details['subject_id']);
			
			$this->native_session->set('subject_list', $list);
			$isUpdated = true;
		}
		
		return array('boolean'=>$isUpdated, 'msg'=>'Your subject information has been updated.');
	}
	
	
	
	# Remove a list item
	function remove_list_item($listType, $itemId)
	{
		$result = false;
		$list = $this->native_session->get($listType.'_list');
		$key = get_row_from_list($list, $listType.'_id', $itemId, 'key');
		if(!empty($key) || $key == 0)
		{
			unset($list[$key]); 
			$this->native_session->set($listType.'_list', $list);	
			$result = true;
		}
		
		return $result;
	}
	
	
	
	
	# Add education and qualifications
	function add_education_and_qualifications($personId, $details)
	{
		$isAdded = false;
		$results = array();
		
		# If the user is editing, first remove the old records
		if($this->native_session->get('edit_step_3'))
		{
			$result1 = $this->query_reader->run('remove_academic_history', array('person_id'=>$personId));
			$result2 = $this->query_reader->run('remove_subject_data', array('parent_id'=>$personId, 'parent_type'=>'person'));
			array_push($results, $result1, $result2);
		}
		
		if($this->native_session->get('education_list')){
			foreach($this->native_session->get('education_list') AS $educationIndex=>$row)
			{
				$result = $this->query_reader->run('add_academic_history', array('person_id'=>$personId, 'institution'=>$row['institutionname'], 'start_date'=>format_date($row['from__month'].' 01, '.$row['from__pastyear'], 'YYYY-MM-DD'), 'end_date'=>format_date($row['to__month'].' 01, '.$row['to__pastyear'], 'YYYY-MM-DD'), 'certificate_name'=>$row['certificatename'], 'certificate_number'=>$row['certificatenumber'], 'is_highest'=>(!empty($row['highestcertificate'])? 'Y': 'N'), 'added_by'=>'' ));
				
				array_push($results, $result);
			}
		}
		
		
		if($this->native_session->get('subject_list'))
		{
			foreach($this->native_session->get('subject_list') AS $subjectIndex=>$row)
			{
				$result = $this->query_reader->run('add_subject_data', array('parent_id'=>$personId, 'parent_type'=>'person', 'details'=>$row['subjectname'], 'study_category'=>$row['subject__subjecttype'] ));
				
				array_push($results, $result);
			}
		}
		
		$isAdded = get_decision($results);
		
		
		# If this is a new record mark this as a start of the editing of the page
		if($isAdded && isset($educationIndex) && isset($subjectIndex) && !$this->native_session->get('edit_step_3')) 
		{
			$this->native_session->set('edit_step_3', 'Y');
		} 
		else if(!isset($educationIndex) || !isset($subjectIndex))
		{
			$isAdded = false;
			$msg = "WARNING: Your education and subjects are required to continue.";
		}
		
		
		# Prepare appropriate message to return
		$action = $this->native_session->get('edit_step_3')? "updated": "added";
		return array('boolean'=>$isAdded, 'msg'=>($isAdded? 'Your education and qualification information has been '.$action.'.': (!empty($msg)? $msg: 'ERROR: Your education and qualification information could not be '.$action.'.'))  );
	}
	
	
	
	
	# Submit the application
	function submit_application($personId, $details)
	{
		$msg = "";
		
		# Record message exchange
		$result1 = $this->query_reader->run('record_message_exchange', array('code'=>'teacher_application_submitted', 'send_format'=>'email', 'details'=>'email='.$details['emailaddress'].'|first name='.$details['first_name'].'|last name='.$details['last_name'], 'category'=>'registration', 'recipient_id'=>$details['user_id'], 'sender_id'=>'system'));
		
		# Send email message notifying the user - copy admin - about the confirmation
		$result2 = $this->messenger->send_email_message('', array('code'=>'teacher_application_submitted', 'email_from'=>SIGNUP_EMAIL, 'from_name'=>SITE_GENERAL_NAME, 'first_name'=>htmlentities($details['first_name'], ENT_QUOTES), 'emailaddress'=>$details['emailaddress'], 'login_link'=>base_url() ));	
		if(!$result2) $msg = "ERROR: We could not send your application confirmation email.";
		
		$isSent = get_decision(array($result1, $result2));
		
		return array('boolean'=>$isSent, 'msg'=>($isSent? "Your application has been submitted": $msg));
	}
	
	
		
	
	
	# STUB: Remove institution details from the user's profile
	function remove_institution($personId, $institutionId)
	{
		$isRemoved = false;
		
		
		return $isRemoved;
	}
	
		
	
	
	# STUB: Reject a list of institutions provided by the user as part of their education details
	function reject_education($personId, $educationDetails)
	{
		$isRejected = false;
		
		
		return $isRejected;
	}

		
	
	
	# STUB: Apply profile secrecy to the user's person account
	function apply_profile_secrecy($personId, $reasons)
	{
		$isApplied = false;
		
		
		return $isApplied;
	}

		
	
	
	# STUB: Remove profile secrecy from the user's person account
	function remove_profile_secrecy($personId, $reasons)
	{
		$isRemoved = false;
		
		
		return $isRemoved;
	}

		
	
	
	# STUB: Set the grade of the person
	function set_grade($personId, $gradeDetails)
	{
		$isSet = false;
		
		
		return $isSet;
	}

		
	
	
	# STUB: Generate the person's computer number 
	function generate_computer_number($personId, $parameters=array())
	{
		$isSet = false;
		
		
		return $isSet;
	}


	
	
	
}


?>