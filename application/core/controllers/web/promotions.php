<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls showing information related to a promotion.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 02/07/2014
 */
class Promotions extends CI_Controller 
{
	#Function to manage the promotion
	public function manage_promotions()
	{
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/promotions/manage_promotions', $data);
	}
	
	
	#Function to update promotions by score
	public function update_promotion_by_score()
	{
		$data = filter_forwarded_data($this);
		
		$data['score'] = !empty($data['t'])? decrypt_value($data['t']): '0';
		
		$this->load->view('web/promotions/promotion_by_score', $data);
	}
	
	
	#Function to edit offers
	public function edit_offer()
	{
		$data = filter_forwarded_data($this);
		
		$data['offerId'] = !empty($data['i'])? decrypt_value($data['i']): '';
		
		$this->load->view('web/promotions/edit_offer', $data);
	}
	
	
	#Function to show edit fields
	public function show_edit_fields()
	{
		$data = filter_forwarded_data($this);
		
		$data['type'] = !empty($data['t'])? decrypt_value($data['t']): '';
		
		$this->load->view('web/promotions/edit_offer_fields', $data);
	}
	
	
	
	
}

/* End of controller file */