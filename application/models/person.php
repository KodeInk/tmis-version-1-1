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
		# 2. Save the data into the database
		if($passed['boolean'])
		{
			$details = $passed['data'];
			
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
					if(!empty($userId)) $msg = "ERROR: We could not create your user record.";
				
					# 4. Send confirmation code to contacts
					$result = true;#$this->messenger->send_email_message($userId, array('code'=>'new_teacher_first_step', 'email_from'=>SIGNUP_EMAIL, 'from_name'=>SITE_GENERAL_NAME, 'verification_code'=>$code, 'password'=>$password, 'first_name'=>htmlentities($details['firstname'], ENT_QUOTES), 'emailaddress'=>$details['emailaddress'], 'login_link'=>base_url() ));
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
			$msg = "WARNING: Some required fields were left empty or entered with invalid characters. Please recheck your data and submit.";
		}
		
		return array('boolean'=>(!empty($result)? $result: false), 'msg'=>$msg);
	}
	
	
	
	# Add a person's address
	function add_address($personId, $addressDetails)
	{
		return $this->query_reader->add_data('add_new_address', array('parent_id'=>$personId, 'parent_type'=>'person', 'address_type'=>$addressDetails['address_type'], 'importance'=>$addressDetails['importance'], 'details'=>$addressDetails['details'], 'county'=>$addressDetails['county'], 'district'=>$addressDetails['district'], 'country'=>$addressDetails['country']));
	}	
		
	
	
	# STUB: Update the person's profile
	function update_profile($personId, $profileDetails)
	{
		$isAdded = true;
		
		
		return array('boolean'=>$isAdded, 'msg'=>'Your profile has been updated.');
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
					# 3. Save all the data into the database
					if(!empty($details['teacherid'])) 
					{
						$this->add_another_id($personId, array('id_type'=>'teacher_id', 'id_value'=>$details['teacherid']));
					}
					#Save permanent and contact addresses
					$permanentId = $this->add_address($personId, array('address_type'=>$this->native_session->get('permanentaddress__addresstype'), 'importance'=>'permanent', 'details'=>htmlentities($this->native_session->get('permanentaddress__addressline'), ENT_QUOTES), 'district'=>$this->native_session->get('permanentaddress__district'), 'country'=>$this->native_session->get('permanentaddress__country'), 'county'=>($this->native_session->get('permanentaddress__county')? $this->native_session->get('permanentaddress__county'): "") ));
					$contactId = $this->add_address($personId, array('address_type'=>$this->native_session->get('contactaddress__addresstype'), 'importance'=>'contact', 'details'=>htmlentities($this->native_session->get('contactaddress__addressline'), ENT_QUOTES), 'district'=>$this->native_session->get('contactaddress__district'), 'country'=>$this->native_session->get('contactaddress__country'), 'county'=>($this->native_session->get('contactaddress__county')? $this->native_session->get('contactaddress__county'): "") ));
				
					#Save the citizenship information
					$result = $this->query_reader->run('update_person_citizenship', array('person_id'=>$personId, 'citizen_country'=>htmlentities($details['citizenship__country'], ENT_QUOTES), 'citizen_type'=>$details['citizenship__citizentype'] ));
				
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
		
	
	
	# STUB: Update the person's ID and contact details
	function update_id_and_contacts($personId, $addressDetails)
	{
		$isAdded = true;
		
		
		return array('boolean'=>$isAdded, 'msg'=>'Your ID and contact information has been updated.');
	}	
	
	
	
	
	
	# STUB: Add a subject taught
	function add_subject_taught($personId, $subjectDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}
		
	
	
	# STUB: Add the person's education
	function add_education($personId, $educationDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}	
	
		
	
	
	# STUB: Add another ID that identifies that person on a third party system
	function add_another_id($personId, $idDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
	}	
	
		
	
	
	# STUB: Add an institution to a person's profile
	function add_institution($personId, $institutionDetails)
	{
		$isAdded = false;
		
		
		return $isAdded;
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

		
	
	
	# STUB: Generate the person's file number
	function generate_file_number($personId, $parameters=array())
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