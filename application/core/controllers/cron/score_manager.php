<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls running score cron jobs.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 12/03/2013
 */
class Score_manager extends CI_Controller 
{
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
        $this->load->model('scoring');
    }
	
	
	
	
	#Update a user's score cache
	public function run_user_score_cache_update()
	{
		$data = filter_forwarded_data($this);
		
		#Parameters for the first and ending user id to give the range of user IDs to update
		$data['from_user_id'] = !empty($data['s'])? decrypt_value($data['s']): (!empty($data['startuser'])? $data['startuser']: "");
		$data['to_user_id'] = !empty($data['e'])? decrypt_value($data['e']): (!empty($data['enduser'])? $data['enduser']: "");
		$data['job_type'] = !empty($data['t'])? decrypt_value($data['t']): (!empty($data['jobtype'])? $data['jobtype']: "");
		$data['store_id'] = !empty($data['m'])? decrypt_value($data['m']): (!empty($data['storeid'])? $data['storeid']: "");
		$resultsArray = $failedUsers = $jobTypeMatch = array();
		
		$jobTypeMatch['clout_score'] = array('clout_score_job'); 
		$jobTypeMatch['store_score'] = array('store_score_job'); 
		$jobTypeMatch['merchant_score'] = array('merchant_score_job'); 
		$jobTypeMatch['general'] = array('data_clean_up', 'backup_data');
		
		$data['score_type'] = $this->search_array_for_match($jobTypeMatch, $data['job_type']);
		
		#Get all user IDs between the given ranges
		#If it is the same ID then only one user needs to be updated
		if($data['from_user_id'] == $data['to_user_id'])
		{
			$resultsArray = $this->update_user_score_cache($data['from_user_id'], $data['score_type'], $data['store_id']);
			#$this->cron_manager->log_cron_job_results('update_score_cache', array('user_id'=>$data['from_user_id'], 'results_array'=>$resultsArray));
			#Record users whose update has fails
			$failedUsers = !empty($resultsArray['fails'])? array($data['from_user_id']): $failedUsers;
		}
		else
		{
			$idList = $this->db->query($this->query_reader->get_query_by_code('get_user_ids_in_range', array('start_id'=>$data['from_user_id'], 'end_id'=>$data['to_user_id'], 'query_part'=>" AND user_status='active' ")))->result_array();
			foreach($idList AS $row)
			{
				$resultsArray = $this->update_user_score_cache($row['id'], $data['score_type'], $data['store_id']);
				#Log the cron job results
				#$this->cron_manager->log_cron_job_results('update_score_cache', array('user_id'=>$row['id'], 'results_array'=>$resultsArray));
				#Log failed user updates
				if(!empty($resultsArray['fails']))
				{
					array_push($failedUsers, $row['id']);
				}
			}
		}
		
		$data['msg'] = (!empty($resultsArray) && empty($failedUsers))? ">User score details updated": "> There were failed updates. <br>>The following users were not updated successfully: ".implode("<BR>> ", $failedUsers);
		
		$data['area'] = 'cron_run_result';
		$data = add_msg_if_any($this, $data); 
		$this->load->view('cron/addons/result_view', $data);
		
	}
	
	
	
	#Function to 
	private function search_array_for_match($multiArray, $searchValue)
	{
		$rowKey = "";
		foreach($multiArray AS $key=>$row)
		{
			if(array_search($searchValue, $row) !== FALSE)
			{
				$rowKey = $key;
				break;
			}
		}
		
		return $rowKey;
	}
	
	
	
	#Update a user's score cache
	private function update_user_score_cache($userId, $scoreType, $storeId='')
	{
		$successfulCodes = $failedCodes = array();
		$ignoreFields = array('id', 'store_id', 'merchant_id', 'user_id', 'total_score', 'last_compute_date', 'is_updated');
		
		#If the code is in the clout score table
		if($scoreType == 'clout_score')
		{
			$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_clout_score_cache', array('user_id'=>DUMMY_USER_ID)))->row_array();
			
		}
		#If the code is in the store score table
		else if($scoreType == 'store_score')
		{
			$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_a_user_store_score_cache', array('user_id'=>DUMMY_USER_ID)))->row_array();
			
		}
		#If the code is in the merchant score table
		else if($scoreType == 'merchant_score')
		{
			$scoreDetails = $this->db->query($this->query_reader->get_query_by_code('get_merchant_score_cache', array('user_id'=>DUMMY_USER_ID)))->row_array();
			
		}
		
		$storeScoreCodes = array_keys($scoreDetails);
			
		#Now update the the score cache value and note which is successful and which is not
		foreach($storeScoreCodes AS $code)
		{
			if($this->cron_manager->update_score_field_cache_value($userId, $code, $scoreType, $storeId))
			{
				array_push($successfulCodes, $code);
			}
			else if(!in_array($code, $ignoreFields))
			{
				array_push($failedCodes, $code);
			}
		}
		
		#Update the score caches when done
		if(empty($failedCodes))
		{
			if($scoreType == 'clout_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_clout_score_cache_value', array('user_id'=>$userId, 'field_name'=>'last_compute_date', 'field_value'=>date('Y-m-d H:i:s'))));
			}
			else if($scoreType == 'store_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_store_score_cache_value', array('user_id'=>$userId, 'store_id'=>$storeId, 'field_name'=>'last_compute_date', 'field_value'=>date('Y-m-d H:i:s'))));
			}
			else if($scoreType == 'merchant_score')
			{
				$result = $this->db->query($this->query_reader->get_query_by_code('update_merchant_score_cache_value', array('user_id'=>$userId, 'field_name'=>'last_compute_date', 'field_value'=>date('Y-m-d H:i:s'))));
			}
			
			$score = $this->scoring->get_score_origins($userId, '0', 'top', $scoreType, $storeId);
		}
		
		return array('success'=>$successfulCodes, 'fails'=>$failedCodes);
	}
	
	
	
}



/* End of controller file */