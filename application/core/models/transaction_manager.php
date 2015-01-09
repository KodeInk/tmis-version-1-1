<?php

/**
 * This class manages transaction information, access and use
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 06/04/2014
 */
class Transaction_manager extends CI_Model
{
	#the transaction user's ID
    private $userId=array();
	
	
	
	
	
	#Creates a new user
	public function process_simple_list_action($actionCode, $data)
	{
		$response = array('bool'=>FALSE, 'msg'=>'');
		
		switch($actionCode) 
		{
    		case 'delete':
        		#1. Collect the raw bank transcation IDs
				$rawIds = $this->db->query($this->query_reader->get_query_by_code('get_raw_transaction_ids', array('id_list'=>"'".implode("','", $data['items'])."'")))->result_array();
				$rawBankIds = array();
				foreach($rawIds AS $idRow)
				{
					array_push($rawBankIds, $idRow['related_transaction_id']);
				}
				#2. Delete the live transaction records
				$liveResult = $this->db->query($this->query_reader->get_query_by_code('delete_clout_transactions', array('id_list'=>"'".implode("','", $data['items'])."'")));
				#3. Delete the raw bank transaction records
				$rawResult = $this->db->query($this->query_reader->get_query_by_code('delete_raw_bank_transactions', array('id_list'=>"'".implode("','", $rawBankIds)."'")));
				$response['bool'] = get_decision(array($liveResult,$rawResult), FALSE);
				
				$response['msg'] = $response['bool']? "The selected transactions have been removed": "ERROR: The selected transactions could not be removed.";
			break;
			
			
			case 'archive':
        		#1. Mark the transactions as archived
				$response['bool'] = $this->db->query($this->query_reader->get_query_by_code('update_transaction_field_value', array('id_list'=>"'".implode("','", $data['items'])."'", 'field_name'=>'status', 'field_value'=>'archived')));
				
				$response['msg'] = $response['bool']? "The selected transactions have been archived": "ERROR: The selected transactions could not be archived.";
			break;
			
			
			
			
			
			
			
			
			
			
			
			
			
			default:
				$response['msg'] = "ERROR: Action code could not be resolved";
			break;
		}
		
		return $response;
	}
	
}


?>