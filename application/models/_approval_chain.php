<?php
/**
 * This class manages the approval processes in the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class _approval_chain extends CI_Model
{
	
	# Add a new approval chain
	function add_chain($subjectId, $chainType, $step, $status, $comment='', $actionDetails=array())
	{
		$msg = "ERROR: The approval could not be recorded.";
		$thisUserId = ($chainType == 'registration' && !$this->native_session->get('__user_id'))? $this->native_session->get('user_id'): $this->native_session->get('__user_id');
		
		# 1. Record the approval chain
		# 1. a) Get the originator from the previous chain
		if($step != '1')
		{
			$chain = $this->_query_reader->get_row_as_array('get_step_chain', array('subject_id'=>$subjectId, 'step_number'=>($step - 1), 'chain_type'=>$chainType));
			$originatorId = $chain['actual_approver'];
		}
		else
		{
			$originatorId = '';
		}
		
		# The next approvers
		$approvers = $this->get_next_approver((!empty($originatorId)? $originatorId: $thisUserId), $chainType, $step);
		
		# 1. b) Add the approval chain
		if(!empty($approvers)) $chainId = $this->_query_reader->add_data('add_approval_chain', array('chain_type'=>$chainType, 'step_number'=>$step, 'subject_id'=>$subjectId, 'originator_id'=>$originatorId, 'actual_approver'=>$thisUserId, 'status'=>$status, 'approver_id'=>implode(',',$approvers), 'comment'=>$comment )); 
		
		# 2. Perform action
		if(!empty($chainId)) 
		{
			$result = $this->action($chainId, $actionDetails);
			if($result) $msg = "Your approval actions have been successful";
		}
		
		# 3. Determine what message to send
		if(empty($approvers)) $msg = "ERROR: No approvers could be found for the next stage.";
		else if(empty($chainId)) $msg = "ERROR: The chain could not be committed.";
		else if(!empty($result) && !$result) $msg = "ERROR: The approval actions could not be executed.";
		
		return array('boolean'=>(!empty($result) && $result? true: false), 'msg'=>$msg);
	}
			
	
	
	# Get the action to perform based on the step in the chain.
	function action($chainId, $otherDetails=array())
	{
		# 1. Get the chain details and settings
		$chain = $this->_query_reader->get_row_as_array('get_approval_chain_by_id', array('chain_id'=>$chainId));
		if(!empty($chain)) $settings = $this->_query_reader->get_row_as_array('get_approval_chain_setting', array('chain_type'=>$chain['chain_type'], 'step_number'=>$chain['step_number']));
		
		# 2. Get all the actions to be perfomed from the code
		if(!empty($settings['step_actions'])) $actions = explode(',',$settings['step_actions']);
		
		# 3. Combine actions to determine the result to return
		$results = array();
		if(!empty($actions)) 
		{
			foreach($actions AS $action)
			{
				switch($action)
				{
					case 'notify_next_chain_party':
						$result = $this->notify_next_chain_party($chain);
					break;
					
					case 'notify_previous_and_next_chain_parties':
						$result = $this->notify_previous_and_next_chain_parties($chain);
					break;
					
					case 'publish_job_notice':
						$result = $this->publish_job_notice($chain);
					break;
					
					case 'notify_previous_chain_parties':
						$result = $this->notify_previous_chain_parties($chain);
					break;
					
					case 'issue_confirmation_letter':
						$result = $this->issue_confirmation_letter($chain);
					break;
					
					case 'issue_file_number':
						$result = $this->issue_file_number($chain);
					break;
					
					case 'issue_registration_certificate':
						$result = $this->issue_registration_certificate($chain, $otherDetails);
					break;
					
					case 'issue_transfer_letter':
						$result = $this->issue_transfer_letter($chain);
					break;
					
					case 'submit_transfer_pca':
						$result = $this->submit_transfer_pca($chain);
					break;
					
					case 'confirm_transfer':
						$result = $this->confirm_transfer($chain);
					break;
					
					case 'send_verification_letter':
						$result = $this->send_verification_letter($chain);
					break;
					
					case 'confirm_retirement':
						$result = $this->confirm_retirement($chain);
					break;
					
					case 'apply_data_secrecy':
						$result = $this->apply_data_secrecy($chain);
					break;
					
					case 'activate_data_records':
						$result = $this->activate_data_records($chain);
					break;
					
					default:
						$result = false;
					break;
				}
				array_push($results, $result);
			}
		}
		
		return get_decision($results, FALSE);
	}
	
	
	
	# Notify the next party in an approval chain
	function notify_next_chain_party($chain)
	{
		$results = array();
		$approvers = explode(",", $chain['approver_id']);
		
		foreach($approvers AS $approverId)
		{
			$result = $this->_messenger->send($approverId, array('code'=>'notify_next_chain_party', 'item_type'=>$chain['chain_type'], 'originator_name'=>$chain['originator_name'], 'action_date'=>date('d-M-Y H:i:sAT', strtotime('now')), 'email_from'=>SITE_ADMIN_MAIL, 'from_name'=>SITE_ADMIN_NAME ));
			array_push($results,$result); 
		}
		
		return get_decision($results);
	}
	
	
	# Notify the previous and next party in an approval chain
	function notify_previous_and_next_chain_parties($chain)
	{
		return  $this->notify_previous_chain_parties($chain) && $this->notify_next_chain_party($chain);
	}	
	
	
	
	# Get previous parties in the approval chain
	function get_previous_parties($subjectId)
	{
		return $this->_query_reader->get_single_column_as_array('get_parties_in_chain', 'actual_approver', array('subject_id'=>$subjectId));
	}
	
	
	
	
	# Notify the previous chain parties
	function notify_previous_chain_parties($chain)
	{
		$results = array();
		# 1. Get first originator and previous approvers
		$parties = $this->get_previous_parties($chain['subject_id']);
		
		# 2. Notify all parties 
		foreach($parties AS $approverId)
		{
			$result = $this->_messenger->send($approverId, array('code'=>'notify_previous_chain_parties', 'item_type'=>$chain['chain_type'], 'originator_name'=>$chain['originator_name'], 'approver_name'=>$chain['approver_name'], 'verification_result'=>$chain['status'], 'action_date'=>date('d-M-Y H:i:sAT', strtotime('now')), 'email_from'=>SITE_ADMIN_MAIL, 'from_name'=>SITE_ADMIN_NAME ));
			array_push($results,$result); 
		}
		
		return get_decision($results, FALSE);
	}
	
	
	# Publish job notice as part of the approval process
	function publish_job_notice($chain)
	{
		return $this->_query_reader->run('update_vacancy_status', array('vacancy_id'=>$chain['subject_id'], 'status'=>'published'));
	}

	
	
	#Send a document as part of the approval process
	function send_document($chain, $documentType, $requiredModes=array('system'), $otherDetails=array())
	{
		$this->load->model('_document');
		$originator = $this->_query_reader->get_row_as_array('get_originator_of_chain', array('subject_id'=>$chain['subject_id']));
		
		if(!empty($originator['originator']))
		{
			# Generate a PDF of the confirmation letter and send it to the confirmed teacher.
			$user = $this->_query_reader->get_row_as_array('get_user_profile', array('user_id'=>$chain['subject_id']));
			$details = $user;
			if(!empty($otherDetails)) $details = array_merge($details, $otherDetails);
			
			#Generate the letter PDF
			$letterUrl = $this->_document->generate_letter('document__'.$documentType, $details);
			
			# Send the document to the user's email and originator of the approval process if they are different in their system
			if(!empty($letterUrl))
			{
				$result = $this->_messenger->send($chain['subject_id'], array('code'=>'send_'.$documentType, 'fileurl'=>$letterUrl, 'email_from'=>SITE_ADMIN_MAIL, 'from_name'=>SITE_ADMIN_NAME), $requiredModes);
				
				# Copy the originator if they are different
				if($chain['subject_id'] != $originator['originator']) $this->_messenger->send($originator['originator'], array('code'=>'send_'.$documentType, 'fileurl'=>$letterUrl, 'email_from'=>SITE_ADMIN_MAIL, 'from_name'=>SITE_ADMIN_NAME), $requiredModes);
				
				return $result;
			}
		}
		else
		{
			return false;
		}
	}

	
	# Issue a file number to the user as part of the approval process
	function issue_file_number($chain)
	{
		$originator = $this->_query_reader->get_row_as_array('get_originator_of_chain', array('subject_id'=>$chain['subject_id']));
		
		$user = $this->_query_reader->get_row_as_array('get_user_profile', array('user_id'=>$originator['originator']));
		$fileNumber = 'TM'.strtotime('now').(strtoupper(substr($user['first_name'], -1).substr($user['last_name'], -1)));
		
		#Record the file number on the teacher's person profile
		$result = $this->_query_reader->run('update_person_profile_part', array('person_id'=>$user['person_id'], 'query_part'=>" file_number='".$fileNumber."' "));
		
		return $this->_messenger->send($originator['originator'], array('code'=>'issue_file_number', 'first_name'=>$user['first_name'], 'file_number'=>$fileNumber, 'email_from'=>SITE_ADMIN_MAIL, 'from_name'=>SITE_ADMIN_NAME));
	}
	
	
	
	# Issue confirmation letter as part of the approval process
	function issue_confirmation_letter($chain)
	{
		return $this->send_document($chain, 'confirmation_letter');
	}
	
	
	
	# Issue registration certificate as part of the approval process
	function issue_registration_certificate($chain, $otherDetails)
	{
		$user = $this->_query_reader->get_row_as_array('get_user_profile', array('user_id'=>$chain['subject_id']));
		
		$actionDetails['date_today'] = date('d-M-Y', strtotime('now'));
		$actionDetails['asset_folder'] = BASE_URL."assets/";
		$actionDetails['document_size'] = 'A4';
		$actionDetails['document_orientation'] = 'landscape';
		$actionDetails['teacher_name'] = strtoupper($user['last_name'].' '.$user['first_name']);
		$actionDetails['teacher_grade'] = strtoupper($otherDetails['grade__grades']);
		$actionDetails['effective_date'] = date('d-M-Y', strtotime($otherDetails['effectivedate']));
		$actionDetails['certificate_number'] = $this->generate_certificate_number($chain['subject_id'], $otherDetails['grade__grades']);
		$approver = $this->_query_reader->get_row_as_array('get_user_profile', array('user_id'=>$this->native_session->get('__user_id')));
		$actionDetails['signature_url'] = $approver['signature'];
		
		return !empty($actionDetails['certificate_number'])? $this->send_document($chain, 'registration_certificate', array('system'), $actionDetails): false;
	}
	
	
	
	# Generate a certificate number for a teacher
	function generate_certificate_number($teacherId, $grade)
	{
		$numberStart = $this->_query_reader->get_row_as_array('get_grade_details_by_name', array('grade_name'=>$grade));
		$number = $numberStart['number'].strtotime('now');
		#record the new certificate for the teacher
		$result = $this->_query_reader->run('add_another_id', array('parent_id'=>$teacherId, 'parent_type'=>'user', 'id_type'=>'certificate_number', 'id_value'=>$number));
		
		return $result? $number: '';
	}
	
	
	
	# Issue transfer letter as part of the approval process
	function issue_transfer_letter($chain)
	{
		return $this->send_document($chain, 'transfer_letter');
	}
	
	
	# Submit transfer PCA as part of the approval process
	function submit_transfer_pca($chain)
	{
		return $this->send_document($chain, 'transfer_pca');
	}
	
	
	# Send verification letter as part of the approval process
	function send_verification_letter($chain)
	{
		return $this->send_document($chain, 'verification_letter');
	}
	
	
	# Confirm retirement as part of the approval process
	function confirm_retirement($chain)
	{
		# 1. Update status of the person's user accounts to inactive
		$result = $this->_query_reader->run('deactivate_user_profile', array('user_id'=>$chain['subject_id']));
		# 2. Send retirement letter
		return $result && $this->send_document($chain, 'retirement_letter', array('email'));
	}
	
	
	# Apply data secrecy as part of the approval process
	function apply_data_secrecy($chain)
	{
		return $this->_query_reader->run('update_profile_visibility', array('is_visible'=>'N', 'person_id'=>$chain['subject_id']));
	}
	
	
	# Activate data records as part of the approval process
	function activate_data_records($chain)
	{
		# Get the data records scope from the subject id
		# scope in the format: [record type]|[id list]
		$scope = explode('|', $chain['subject_id']);
		
		# Take action based on the record type
		switch($scope[0])
		{
			case 'teacher':
				$result = $this->_query_reader->run('activate_teacher_data', array('updated_by'=>$this->native_session->get('__user_id'), 'id_list'=>"'".implode("','", explode(',', $scope[1]))."'" ));
			break;
			
			case 'school':
				$result = $this->_query_reader->run('activate_school_data', array('updated_by'=>$this->native_session->get('__user_id'), 'id_list'=>"'".implode("','", explode(',', $scope[1]))."'" ));
			break;
			
			case 'census':
				$result = $this->_query_reader->run('activate_census_data', array('updated_by'=>$this->native_session->get('__user_id'), 'id_list'=>"'".implode("','", explode(',', $scope[1]))."'" ));
			break;
		}
		
		return $result;
	}
	
			
	
	
	# Get the next approver in the chain stage
	function get_next_approver($originatorId, $chainType, $stepNumber)
	{
		$approvers = array();
		# 1. Get the chain settings
		$chainSetttings = $this->_query_reader->get_row_as_array('get_approval_chain_setting', array('chain_type'=>$chainType, 'step_number'=>$stepNumber));
		
		# 2. Get the scope details of the originator to properly obtain the next approver scope
		$originator = $this->_query_reader->get_row_as_array('get_originator_scope', array('originator_id'=>$originatorId));
		
		# 3. Now extract the approvers list
		if(!empty($chainSetttings['approvers']))
		{
			$scopes = $this->_query_reader->get_list('get_approver_scope', array('group_list'=>"'".implode("','", explode(',', $chainSetttings['approvers']))."'"));
			
			# 2. Get the users within that scope
			foreach($scopes AS $scope)
			{
				if($scope['scope'] == 'institution')
				{
					$condition = " AND PT.institution_id IN ('".implode("','",explode(',',$originator['institutions']))."') ";
				}
				else if($scope['scope'] == 'county')
				{
					$condition = " AND A.county IN ('".implode("','",explode(',',$originator['counties']))."') ";
				}
				else if($scope['scope'] == 'district')
				{
					$condition = " AND A.district_id IN ('".implode("','",explode(',',$originator['districts']))."') ";
				}
				# Take all users at that scope - for now (as TMIS is for only Uganda)
				else if($scope['scope'] == 'country')
				{
					$condition = "";
				}
				# Take all users at that scope
				else if($scope['scope'] == 'system')
				{
					$condition = "";
				}
				
				# Proceed with users who are allowed to approve
				if(!empty($scope['scope']) && $scope['scope'] != 'self')
				{
					$approvers = array_merge($approvers, $this->_query_reader->get_single_column_as_array('get_users_in_group', 'user_id', array('group'=>$scope['approver'], 'condition'=>$condition)) );
				}
			}
		}
		
		return array_unique($approvers);
	}	







}


?>