<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls showing information related to customizing your favorites.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 01/15/2014
 */
class Favorites extends CI_Controller 
{
	
	
	#Function to show the favorites home
	public function show_favorites_home()
	{
		access_control($this);
		
		$data = filter_forwarded_data($this);
		
		$this->load->view('web/favorites/favorites_home', $data);
	}
	
	
	#Function to show the category details to build on favorites
	public function show_category()
	{
		$data = filter_forwarded_data($this);
		
		$data['main'] = !empty($data['m'])? decrypt_value($data['m']): '';
		$data['submain'] = !empty($data['s'])? decrypt_value($data['s']): '';
		
		$data['area'] = "category_details";
		$this->load->view('web/favorites/category_details', $data);
	}
	
	
	#Function to show the favorites menu 
	public function show_favorites()
	{
		$data = filter_forwarded_data($this);
		
		
		$data['area'] = "category_details";
		$this->load->view('web/favorites/category_details', $data);
	}
	
}

/* End of controller file */