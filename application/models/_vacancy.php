<?php
/**
 * This class manages vacancy data in the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class _vacancy extends CI_Model
{
	
	# STUB: Add a new vacancy.
	function add_new($vacancyDetails)
	{
		$isAdded = false;
		$required = array('institution__institutions', 'role__jobroles', 'headline', 'summary', 'details', 'publishstart', 'publishend');
		
		# 1. Add all provided data into the session
		$passed = process_fields($this, $vacancyDetails, $required, array("/", "<", ">", "\"", "=", "(", ")", "!", "#", "%", "&", "?", ":", ";"));
		$msg = !empty($passed['msg'])? $passed['msg']: "";
		# 2. Save the data into the database
		if($passed['boolean'])
		{
			$details = $passed['data'];
			$vacancyId = $this->_query_reader->add_data('add_vacancy_data', array('institution'=>htmlentities($details['institution__institutions'], ENT_QUOTES), 'role'=>$details['role__jobroles'], 'topic'=>htmlentities($details['headline'], ENT_QUOTES), 'summary'=>htmlentities($details['summary'], ENT_QUOTES), 'details'=>htmlentities($details['details'], ENT_QUOTES), 'start_date'=>format_date($details['publishstart'], 'YYYY-MM-DD'), 'end_date'=>format_date($details['publishend'], 'YYYY-MM-DD'), 'added_by'=>$this->native_session->get('user_id') ));
			
			 $isAdded = !empty($vacancyId)? true: false;
			 if($isAdded) $this->native_session->delete_all($details);
		}
		
		return array('boolean'=>$isAdded, 'msg'=>$msg, 'id'=>(!empty($vacancyId)? $vacancyId: ''));
	}
		
		
	
	# STUB: Publish a vacancy
	function publish($vacancyId)
	{
		$isPublished = false;
		
		
		return $isPublished;
	}	
		
		
	
	# Update a vacancy
	function update($vacancyId, $vacancyDetails)
	{
		$isUpdated = false;
		$required = array('headline', 'summary', 'details', 'publishstart', 'publishend');
		# 1. Add all provided data into the session
		$passed = process_fields($this, $vacancyDetails, $required, array("/", "<", ">", "\"", "=", "(", ")", "!", "#", "%", "&", "?", ":", ";"));
		$msg = !empty($passed['msg'])? $passed['msg']: "";
		# 2. Save the data into the database
		if($passed['boolean'])
		{
			$details = $passed['data'];
			$isUpdated = $this->_query_reader->run('update_vacancy_data', array('topic'=>htmlentities($details['headline'], ENT_QUOTES), 'summary'=>htmlentities($details['summary'], ENT_QUOTES), 'details'=>htmlentities($details['details'], ENT_QUOTES), 'start_date'=>format_date($details['publishstart'], 'YYYY-MM-DD'), 'end_date'=>format_date($details['publishend'], 'YYYY-MM-DD'), 'vacancy_id'=>$vacancyId ));
			
			 if($isUpdated) $this->native_session->delete_all($details);
		}
		
		return array('boolean'=>$isUpdated, 'msg'=>$msg, 'id'=>$vacancyId);
	}	
		
		
	
	# STUB: Archive a vacancy
	function archive($vacancyId)
	{
		$isArchived = false;
		
		
		return $isArchived;
	}	
		
		
	
	# STUB: Apply for a vacancy
	function apply($vacancyDetails)
	{
		$isApplied = false;
		
		
		return $isApplied;
	}
		
		
	
	# STUB: Generate a shortlist of the applicants
	function generate_shortlist($vacancyId)
	{
		$shortlist = array();
		
		
		return $shortlist;
	}
		
		
	
	# STUB: Get responses to a vacancy.
	function get_responses($vacancyId)
	{
		$responses = array();
		
		
		return $responses;
	}
		
		
	
	# STUB: Set an interview for a vacancy.
	function set_interview($vacancyId, $interviewDetails)
	{
		$isSet = false;
		
		
		return $isSet;
	}
	
		
	
	# Get list of vacancies
	function get_list($instructions=array())
	{
		#TODO: Add instructions for listing the vacancies
		
		return $this->_query_reader->get_list('get_vacancy_list_data', array('search_query'=>"1=1", 'limit_text'=>'0,10'));
	}
	
	


}


?>