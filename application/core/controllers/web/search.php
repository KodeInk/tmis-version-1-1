<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls searching on the system.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 12/21/2013
 */
class Search extends CI_Controller 
{
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('search_manager');
		$this->load->model('store_manager');
		$this->load->model('promotion_manager');
	}
	
	
	
	#Function to show the search landing page
	#More details at:
	#https://google-developers.appspot.com/maps/documentation/javascript/examples/
	function show_store_map()
	{
		$data = filter_forwarded_data($this);
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/search/google_map_view', $data);
	}
	
	function show_search_home()
	{
	$this->load->view('web/search/TEMP');
	}
	
	
	#Function to show the search landing page
	function show_search_home_BACKUP()
	{
		access_control($this);
		
		$data = filter_forwarded_data($this);
		$data['categories'] = $this->search_manager->get_search_categories();
		$data['c'] = !empty($data['c'])? $data['c']: 10;
		$data['p'] = !empty($data['p'])? $data['p']: 1;
		$data['sideItemsPerPage'] = $data['c'];
		$data['featuredItemsPerPage'] = 10;
		
		#Remove search settings
		$this->native_session->delete('search_location');
		$this->native_session->delete('search_store');
		
		#Featured advertisements
		$data['featured'] = $this->search_manager->get_featured_adverts(array('user_id'=>$this->native_session->get('userId'), 'page'=>$data['p'], 'items_per_page'=>$data['featuredItemsPerPage'], 'page_type'=>'search_home', 'max_distance'=>100));
		
		
		#@params: 
		#Search Parameters (e.g., user ID, page, items per page)
		#Search Type: by distance or score or best deals
		#Maximum search distance
		
		#1. Get the number of items returned (100 max)
		$data['returnCount'] =  $this->search_manager->get_search_list_count(array('user_id'=>$this->native_session->get('userId'), 'page'=>$data['p'], 'items_per_page'=>100, 'return_type'=>'list_count'), 'distance', 100);
		$this->native_session->set('return_count', $data['returnCount']);
		
		#2. Now get the details of those to be displayed
		$data['suggested'] = $this->search_manager->get_default_store_suggestions(array('user_id'=>$this->native_session->get('userId'), 'page'=>$data['p'], 'items_per_page'=>$data['sideItemsPerPage'], 'return_type'=>'list_details'), 'distance', 100);
		
		#Check if this is a staff member and their application is not yet completed
		$data['msg'] = $this->account_manager->has_user_applied_to_become_merchant($this->native_session->get('userId'), 'pending')? "Please <a href='".base_url()."web/account/complete_merchant_application' class='bluebold'>click here</a> to complete your merchant application.": '';
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/search/search_home', $data);
	}
	
	#Function to show the deal main page
	function show_store_home()
	{
		$data = filter_forwarded_data($this);
		$data['sort'] = !empty($data['sort'])? $data['sort']: 'distance';
		$data['sideItemsPerPage'] = !empty($data['c'])? $data['c']: 10;
		$data['p'] = !empty($data['p'])? $data['p']: 1;
		
		/*if(!empty($data['v']) && decrypt_value($data['v']) == 'map')
		{
			$data['showMap'] = TRUE;
		}*/
		
		#Get store details
		if(!empty($data['i']))
		{
			$data['storeId'] = decrypt_value($data['i']);
			
			#Get the store data
			$requiredData = array('name', 'address', 'phone_number', 'website', 'is_favorite', 'category_tags', 'sub_category_tags', 'price_range', 'schedule', 'description', 'relevant_tags', 'photos', 'offers');
			$data['storeDetails'] = $this->store_manager->get_store_details($data['storeId'], $requiredData, $this->native_session->get('userId'));
			
			#Get the store score data
			$statCodes = array('store_score', 'store_score_details', 'store_score_level', 'store_score_level_data', 'store_score_key_description', 'store_score_breakdown');
			$data['storeScoreDetails'] = $this->statistic_manager->get_user_statistic_by_group($this->native_session->get('userId'), $statCodes, $data['storeId']);
		}
		
		
		#Now get the details of those to be displayed
		if(!empty($data['t']) && decrypt_value($data['t']) == 'single_result')
		{
			$userLocation = $this->promotion_manager->get_most_recent_location($this->native_session->get('userId'), 'longitude_latitude'); 			
			$data['suggested'][0] = $this->db->query($this->query_reader->get_query_by_code('get_stores_details_for_display', array('latitude'=>$userLocation['latitude'], 'longitude'=>$userLocation['longitude'], 'store_id'=>decrypt_value($data['i']), 'user_id'=>$this->native_session->get('userId') )))->row_array();
			$data['isSingleResult'] = "Y";
		}
		else
		{
			$data['suggested'] = $this->search_manager->get_default_store_suggestions(array('user_id'=>$this->native_session->get('userId'), 'page'=>$data['p'], 'items_per_page'=>$data['c'], 'return_type'=>'list_details'), $data['sort'], 100);
		}
		
		
		
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/search/store_details', $data);
	}
	
	
	
	
	#Function to load more featured items in a list
	function load_more_featured_items()
	{
		$data = filter_forwarded_data($this);
		
		#Load the list only if there is a page and items per page count specified
		if(!empty($data['p']) && !empty($data['c']))
		{
			$data['featured'] = $this->search_manager->get_featured_adverts(array('user_id'=>$this->native_session->get('userId'), 'page'=>$data['p'], 'items_per_page'=>$data['c'], 'page_type'=>'search_home', 'max_distance'=>100));
		}
		
		$data['area'] = 'featured_items_home_page';
		$this->load->view('web/addons/basic_addons', $data);
	}
	
	
	
	
	#Function to load more table items in a list table
	function load_more_table_list_items()
	{
		$data = filter_forwarded_data($this);
		if(!empty($data['p']) && !empty($data['c']) && !empty($data['t']))
		{
			$desiredColumns = $this->search_manager->get_desired_list_columns($data['t']);
			$data['tableListItems'] = $this->search_manager->get_more_table_list_items($data['t'], $data['p'], $data['c'], $desiredColumns);
			
			$data['tableName'] = !empty($data['l'])? $data['l']: '';
		}
		
		$data['area'] = 'table_list_items';
		$this->load->view('web/addons/list_addons', $data);
	}
	
	
	
	
	
	
	#Get the list of items to show on the side section
	function load_side_list()
	{
		$data = filter_forwarded_data($this);
		$data['pageList'] = array();
		
		#The suggestions list
		if(!empty($data['t']) && $data['t'] == 'suggestions')
		{
			$data['pageList'] = $this->search_manager->get_default_store_suggestions(array(
					'user_id'=>$this->native_session->get('userId'), 
					'page'=>(!empty($data['p'])? $data['p']:1), 
					'items_per_page'=>(!empty($data['n'])? $data['n']:10), 
					'return_type'=>'list_details'
				), 
				(!empty($data['sort'])? $data['sort']:'distance'), 
				100);
		}
		#Single search result
		else if(!empty($data['t']) && $data['t'] == 'single_search_result')
		{
			$userLocation = $this->promotion_manager->get_most_recent_location($this->native_session->get('userId'), 'longitude_latitude'); 			
			$data['pageList'][0] = $this->db->query($this->query_reader->get_query_by_code('get_stores_details_for_display', array('latitude'=>$userLocation['latitude'], 'longitude'=>$userLocation['longitude'], 'store_id'=>decrypt_value($data['i']), 'user_id'=>$this->native_session->get('userId') )))->row_array();
			
		}
		#Search the stores based on the values entered by a user
		else if(!empty($data['t']) && $data['t'] == 'search_results')
		{
			if(!empty($data['storename'])) $this->native_session->set('search_store', $data['storename']);
			if(!empty($data['zipcode_or_city'])) $this->native_session->set('search_location', $data['zipcode_or_city']);
			
			$data['pageList'] = $this->search_manager->get_default_store_suggestions(array(
					'user_id'=>$this->native_session->get('userId'), 
					'page'=>(!empty($data['p'])? $data['p']:1), 
					'items_per_page'=>(!empty($data['n'])? $data['n']:10), 
					'return_type'=>'list_details',
					'store_name'=>(!empty($data['storename'])? $data['storename']: ''),
					'zipcode'=>(!empty($data['zipcode_or_city']) && is_numeric($data['zipcode_or_city'])? $data['zipcode_or_city']: ''),
					'city'=>(!empty($data['zipcode_or_city']) && !is_numeric($data['zipcode_or_city'])? $data['zipcode_or_city']: ''),
					'category'=>(!empty($data['search_category'])? $data['search_category']: '')
				), 
				(!empty($data['sort'])? $data['sort']:'distance'), 
				100);
		}
		
		
		$data['area'] = !empty($area)? $area: 'search_side_list';
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/addons/basic_addons', $data);
	}
	
	
	
	#Function to add a new favorite store for a user
	function add_favorite_store()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['s']) && !empty($data['u']))
		{
			$data['result'] = $this->db->query($this->query_reader->get_query_by_code('add_favorite_store', array('user_id'=>decrypt_value($data['u']), 'store_id'=>decrypt_value($data['s']) )));
		}
		
		$data['area'] = 'add_favorite';
		$data = add_msg_if_any($this, $data); 
		$this->load->view('web/addons/basic_addons', $data);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	#Searches database based on passed values and returns a list of appropriate items that qualify
	function load_results()
	{	
		# Get the passed details into the url data array if any
		$data = filter_forwarded_data($this);
		$data['phrase'] = !empty($data['phrase'])? addslashes(restore_bad_chars($data['phrase'])): '';
		
		#Searching for a bank name
		if(isset($data['type']) && $data['type'] == 'bank_name')
		{
			$searchString = $this->search_manager->format_search_query($data['searchfield'], $data['phrase']);
			
			#Determine which query to use to search
			$query = $this->query_reader->get_query_by_code('get_institution_list', array('search_string'=>" (".$searchString.") AND institution_code != '' ORDER BY institution_name ", 'limit_text'=>" LIMIT 0,100 "));
			
			#Choose display area based on the passed layer
			if(!empty($data['layer']) && $data['layer'] == 'select_accounts')
			{
				$data['area'] = 'select_account_bank_list';
			}
			else
			{
				$data['area'] = 'institution_list';
			}
		}
		
		
		
		#searching my direct network
		else if(isset($data['type']) && $data['type'] == 'my_direct_network')
		{
			$searchString = $this->search_manager->format_search_query($data['searchfield'], $data['phrase']);
			$searchString = !empty($searchString)? ' AND '.$searchString: $searchString;
			
			#Determine which query to use to search
			$query = $this->query_reader->get_query_by_code('get_network_user_summary', array('referrer_id'=>$this->native_session->get('userId'), 'limit_query'=>$searchString." ORDER BY U.first_name  LIMIT 0,10; "));
			
			$data['area'] = 'my_direct_network';
		}
		
		
		
		#searching my direct network
		else if(isset($data['type']) && $data['type'] == 'my_invites')
		{
			$searchString = $this->search_manager->format_search_query($data['searchfield'], $data['phrase']);
			$searchString = !empty($searchString)? ' AND '.$searchString: $searchString;
			
			#Determine which query to use to search
			$query = $this->query_reader->get_query_by_code('get_invite_user_summary', array('referrer_id'=>$this->native_session->get('userId'), 'limit_query'=>$searchString." ORDER BY I.last_invitation_sent_on DESC, I.first_name  LIMIT 0,10; "));
			
			$data['area'] = 'my_invite_network';
		}
		
		
		
		#Get the business categories
		else if(isset($data['type']) && $data['type'] == 'business_category')
		{
			#Get the search string to use based on passed items
			if(empty($data['phrase']) || $data['phrase'] == '_')
			{
				$searchString = " ORDER BY total_active+0 DESC ";
				$data['limit'] = 5;
			} 
			else
			{
				$searchString = ($data['searchfield'] != '_')? $this->search_manager->format_search_query($data['searchfield'], $data['phrase']): '';
				$searchString = !empty($searchString)? ' AND ('.$searchString.') ': $searchString;
			}
			
			$listStart = !empty($data['liststart'])? $data['liststart']+1: '0';
			$rowsPerPage = !empty($data['limit'])? $data['limit']: '5';
			
			#Determine which query to use to search
			$query = $this->query_reader->get_query_by_code('search_business_categories', array('condition'=>$searchString, 'limit_query'=>""));
			
			$data['area'] = 'selectlist__business_category';
		}
		
		
		
		#Get the business sub categories
		else if(isset($data['type']) && $data['type'] == 'business_subcategory')
		{
			$data['msg'] = empty($data['businesscategory'])? 'WARNING: Select a category first': '';
			#Get the search string to use based on passed items
			if(empty($data['phrase']) || $data['phrase'] == '_')
			{
				$searchString = " AND C.category_name='".(!empty($data['businesscategory'])? $data['businesscategory']: '')."' ORDER BY S.total_active+0 DESC ";
			} 
			else
			{
				$searchString = ($data['searchfield'] != '_')? $this->search_manager->format_search_query($data['searchfield'], $data['phrase']): '';
				$searchString = " AND C.category_name='".$data['businesscategory']."' ".(!empty($searchString)? " AND (".$searchString.") ": '')." ORDER BY S.total_active+0 DESC ";
			}
			
			
			#Determine which query to use to search
			$query = $this->query_reader->get_query_by_code('search_business_subcategories', array('condition'=>$searchString, 'limit_query'=>""));
			
			$data['area'] = 'selectlist__business_subcategory';
		}
		
		
		
		#Get the business name suggestions
		else if(isset($data['type']) && in_array($data['type'], array('business_name', 'competitor_name','store_name', 'search_store_name')))
		{
			$searchString = $query = '';
			#Get the search string to use based on passed items
			if(!(empty($data['phrase']) || $data['phrase'] == '_'))
			{
				$searchString = ($data['searchfield'] != '_')? $this->search_manager->format_search_query($data['searchfield'], $data['phrase']): '';
				$searchString = (!empty($searchString)? " AND (".$searchString.") ": '')." AND status='active' ORDER BY name ASC ";
				
				#Determine which query to use to search
				$query = $this->query_reader->get_query_by_code('search_business_name', array('condition'=>$searchString, 'limit_query'=>" LIMIT 0,50; "));
			}
			else if(empty($data['phrase']) || $data['phrase'] == '_')
			{
				$suggestedIdList = $this->native_session->get('suggested_merchants')? $this->native_session->get('suggested_merchants'): array();
				$query = $this->query_reader->get_query_by_code('search_business_name', array('condition'=>" AND id IN ('".implode("','", $suggestedIdList)."') AND id !='1' ", 'limit_query'=>" LIMIT 0,50; "));
			} 
			
			$data['area'] = 'selectlist__'.$data['type'];
		}
		
		
		
		#Get the states
		else if(isset($data['type']) && $data['type'] == 'state_name')
		{
			$data['countrycode'] = !empty($data['countrycode'])? $data['countrycode']: 'USA';
			#TODO: Enable for other countries
			$data['msg'] = empty($data['countrycode'])? 'WARNING:Select a country first': '';
			
			#Get the search string to use based on passed items
			if(empty($data['phrase']) || $data['phrase'] == '_')
			{
				$searchString = " AND country='".$data['countrycode']."' ORDER BY state_name ASC ";
			} 
			else
			{
				$searchString = ($data['searchfield'] != '_')? $this->search_manager->format_search_query($data['searchfield'], $data['phrase']): '';
				$searchString = " AND country='".$data['countrycode']."' ".(!empty($searchString)? " AND (".$searchString.") ": '')." ORDER BY state_name ASC ";
			}
			
			
			#Determine which query to use to search
			$query = $this->query_reader->get_query_by_code('search_states', array('condition'=>$searchString, 'limit_query'=>""));
			
			
			$data['area'] = 'selectlist__states';
		}
		
		
		
		#Get the city
		else if(isset($data['type']) && $data['type'] == 'city_name')
		{
			$data['countrycode'] = !empty($data['countrycode'])? $data['countrycode']: 'USA';
			
			#Get the search string to use based on passed items
			if(empty($data['phrase']) || $data['phrase'] == '_')
			{
				$cityCondition = "";
				$cityAliasCondition = "";
			} 
			else
			{
				$cityCondition = " AND (".$this->search_manager->format_search_query('city', $data['phrase']).") ";
				$cityAliasCondition = " AND (".$this->search_manager->format_search_query('city_alias', $data['phrase']).") ";
			}
			
			#Determine which query to use to search
			$query = $this->query_reader->get_query_by_code('search_cities', array('city_condition'=>$cityCondition, 'city_alias_condition'=>$cityAliasCondition, 'limit_query'=>" LIMIT 0,50; "));
			
			$data['area'] = 'selectlist__cities';
		}
		
		
		
		#Get the country by name
		else if(isset($data['type']) && $data['type'] == 'country_name')
		{
			#Get the search string to use based on passed items
			if(empty($data['phrase']) || $data['phrase'] == '_')
			{
				$searchString = " ORDER BY name ASC ";
			} 
			else
			{
				$searchString = ($data['searchfield'] != '_')? $this->search_manager->format_search_query($data['searchfield'], $data['phrase']): '';
				$searchString = (!empty($searchString)? " AND (".$searchString.") ": '')." ORDER BY name ASC ";
			}
			#Determine which query to use to search
			$query = $this->query_reader->get_query_by_code('search_countries', array('condition'=>$searchString, 'limit_query'=>" "));
			
			$data['area'] = 'selectlist__countries';
		}
		
		
		
		#Get the annual revenue
		else if(isset($data['type']) && $data['type'] == 'annual_revenue')
		{
			$listArray = array(
			array('amount_range'=>'0 - 10,000'),
			array('amount_range'=>'10,001 - 50,000'),
			array('amount_range'=>'50,001 - 100,000'),
			array('amount_range'=>'100,001 - 500,000'),
			array('amount_range'=>'500,001 - 1m'),
			array('amount_range'=>'1,000,001 - 5m'),
			array('amount_range'=>'5,000,001 - 10m'),
			array('amount_range'=>'10,000,001 - 50m'),
			array('amount_range'=>'50,000,001 - 100m'),
			array('amount_range'=>'Above 100m')
			);
			$data['area'] = 'selectlist__annualrevenue';
		}
		
		
		
		#Get the annual revenue
		else if(isset($data['type']) && $data['type'] == 'price_range')
		{
			$listArray = array(
			array('range_marker'=>'$'),
			array('range_marker'=>'$$'),
			array('range_marker'=>'$$$'),
			array('range_marker'=>'$$$$')
			);
			$data['area'] = 'selectlist__pricerange';
		}
		
		
		
		
		
		#Get either the zip code or city based on what is being searched
		else if(isset($data['type']) && $data['type'] == 'zipcode_or_city')
		{
			#Get the search string to use based on passed items
			if(!(!empty($data['phrase']) || $data['phrase'] == '0') || $data['phrase'] == '_' )
			{
				#Have we saved a location before?
				if($this->native_session->get('current_location'))
				{
					$listArray = $this->native_session->get('current_location');
				}
				else
				{
					$listArray = $this->search_manager->get_current_location_by_ip('zipcode_details');
					$this->native_session->set('current_location', $listArray);
					
					if(empty($listArray['city']) && $this->native_session->get('userId'))
					{
						$listArray = $this->query_reader->get_query_by_code('get_user_by_id', array('condition'=>$searchString, 'limit_query'=>" "));
						$listArray['state_code'] = !empty($listArray['state'])?$listArray['state']: '';
					}
				}
				#Make it a multi-dimensional array
				$listArray = array($listArray);
				
				$data['sub_area'] = 'city';
			} 
			else
			{
				$data['countrycode'] = !empty($data['countrycode'])? $data['countrycode']: 'USA';
				
				#If the user has started with a number, then show zipcode list
				if(is_numeric(trim($data['phrase'])))
				{
					#TODO: Add picking zipcodes by country code too
					$searchString = " AND zip_code LIKE '".$data['phrase']."%' ORDER BY zip_code+0 ASC ";
					$query = $this->query_reader->get_query_by_code('search_zip_codes', array('condition'=>$searchString, 'limit_query'=>" LIMIT 0,50; "));
					$data['sub_area'] = 'zipcode';
				}
				#Else show and search the city list
				else
				{
					$cityCondition = $this->search_manager->format_search_query('city', $data['phrase']);
					$cityAliasCondition = $this->search_manager->format_search_query('city_alias', $data['phrase']);
					#" AND country_code='".$data['countrycode']."' ".(!empty($searchString)? " AND (".$searchString.") ": '')." ORDER BY city ASC ";
					$query = $this->query_reader->get_query_by_code('search_cities', array('city_condition'=>' AND ('.$cityCondition.') ', 'city_alias_condition'=>' AND ('.$cityAliasCondition.') ', 'limit_query'=>" LIMIT 0,50; "));
					
					$data['sub_area'] = 'city';
				}
				
			}
			
			
			$data['area'] = 'selectlist__zipcode_or_city';
		}
		
		
		
		#Get the states
		else if(isset($data['type']) && $data['type'] == 'search_transaction_list')
		{
			$searchString = ($data['searchfield'] != '_')? $this->search_manager->format_search_query($data['searchfield'], $data['phrase']): '';
			$searchString = !empty($searchString)? " AND (".$searchString.") ": '';
			
			$query = $this->query_reader->get_query_by_code('get_batch_user_transactions', array('query_part'=>$searchString, 'limit_text'=>" LIMIT 0,100; "));
			
			
			
			$data['area'] = 'search_transaction_list';
			$view_to_load = "web/addons/list_addons";
		}
		
		
		
		
		
		
		
		
		
		
		
		
		#*************************************************************************************************
		#Process for all
		#*************************************************************************************************
		$data['pageList'] = !empty($query)? $this->db->query($query)->result_array() : (!empty($listArray)? $listArray: array());
			
		# Send results to default addon if no view to load is specified (e.g., in the case of instant search)
		$view_to_load = !empty($view_to_load)? $view_to_load: ((strpos($data['area'], 'selectlist__') !== FALSE)? 'web/addons/select_list_view':'web/addons/result_view');
		
		$this->load->view($view_to_load, $data);
	}
	
}