<?php

/**
 * This class manages search functionality in the system
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 03/20/2014
 */
class Search_manager extends CI_Model
{
	#a variable to hold the search scope
    private $searchScope=array();
	#a variable to hold a store's competitors
    private $storeCompetitors=array();
	#a variable to hold the search limit
    private $searchLimit=array();
	#a variable to hold the store ids
    private $searchStoreIds=array();
	#a variable to hold the user location details (latitude and longitude)
    private $userLocation=array();
	#a variable to hold the user suggested businesses
    private $suggestedMerchants=array();
	#a variable to hold the user suggested businesses with their details
    private $suggestedMerchantsWithDetails=array();
	#a variable to determine the sorting parameter
    private $sortBy=array();
	
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('statistic_manager');
		$this->load->model('scoring');
		$this->load->model('promotion_manager');
	}
	
	
	
	
	
	
	
	#Returns search categories for the UI
	#TODO: Add option for $scope = 'sub-categories' when needed
	public function get_search_categories($returnType='detailed_array', $scope='category')
	{
		$response = '';
		if($scope == 'category')
		{
			#Return full details of the system categories
			if($returnType == 'detailed_array')
			{
				$response = array('total_categories'=>0, 'category_list'=>array());
				$response['category_list'] = $this->db->query($this->query_reader->get_query_by_code('get_category_list', array('isactive_options'=>"'Y'", 'order_by_options'=>" preferred_rank+0 ASC ")))->result_array();
				$response['total_categories'] = count($response['category_list']);
			}
		}
		
		return $response;
	}
	
	
	
	#Function to get featured adverts
	public function get_featured_adverts($parameters)
	{
		switch($parameters['page_type']) {
    		case 'search_home':
        		return $this->get_home_adverts($parameters);
			break;
		
			
			default:
				return "ERROR: code not recognized.";
			break;
		}
	}
	
	
	
	#Function to return the small cover image adverts for the home page based on restrictions
	private function get_home_adverts($parameters)
	{
		$finalAdvertList = array();
		
		#1. Get clout score of the user
		$userScore = !empty($parameters['user_id'])? $this->statistic_manager->get_score($parameters['user_id'], 'clout_score'): 0;
		#2. Get current location of the user
		$userLocation = !empty($parameters['user_id'])? $this->promotion_manager->get_most_recent_location($parameters['user_id'], 'longitude_latitude'): $this->promotion_manager->get_current_location_by_ip('longitude_latitude');
		#Add to the restrictions for passing to the promotions manager
		$parameters = array_merge($parameters, array('user_score'=>$userScore, 'user_location'=>$userLocation, 'current_time'=>date('Y:m:d H:i:s')));
		
		#3. Get qualifying adverts (advert ID list) based on 1, 2 and other restrictions
		$qualifyingAdverts = $this->promotion_manager->get_adverts_that_meet_restrictions($parameters, 'store_list_details');
		
		#4. Add extra information needed to the adverts such as cashback range, or has perk
		foreach($qualifyingAdverts AS $advert)
		{
			array_push($finalAdvertList, $this->get_store_details($advert, array('cashback_range', 'has_perk'), (!empty($parameters['user_id'])? $parameters['user_id']: ''))  );
		}
		
		return $finalAdvertList;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	#Function to format fields to prepare a query
	public function format_search_query($searchField, $phrase, $isDelimited=FALSE, $isExactMatch=FALSE, $delimiter=',')
	{
		$searchString1 = $searchString2 = $searchString3 = $searchString4 = '';
		
		$searchFieldArray = explode('__', $searchField);
		#Direct matches
		$count = 0;
		foreach($searchFieldArray AS $field)
		{
			if($count > 0)
			{
				$searchString1 .= " OR ";
			}
			
			#e.g., naics_code='_CODE_' OR naics_code LIKE '%,_CODE_' OR naics_code LIKE '%,_CODE_,%' OR naics_code LIKE '_CODE_,%'
			if($isDelimited)
			{
				$searchString1 .= $field."='".$phrase."' OR ".$field." LIKE '%".$delimiter.$phrase."' OR ".$field." LIKE '%".$delimiter.$phrase.$delimiter."%' OR ".$field." LIKE '".$phrase.$delimiter."%' ";
			}
			else
			{
				$searchString1 .= $field." LIKE '".$phrase."'";
			}
			
			$count++;
		}
		
		#Ignore these if you need exact match
		if(!$isExactMatch)
		{
		
		#part of value matches
		$count = 0;
		foreach($searchFieldArray AS $field)
		{
			if($count > 0)
			{
				$searchString2 .= " OR ";
			}
			
			if($isDelimited)
			{
				$searchString2 .= $field." LIKE '".$phrase."' OR ".$field." LIKE '%".$delimiter.$phrase."%' OR ".$field." LIKE '%".$delimiter."%".$phrase.$delimiter."%' OR ".$field." LIKE '".$delimiter."%".$phrase."' ";
			}
			else
			{
				$searchString2 .= $field." LIKE '%".$phrase."%'";
			}
			$count++;
		}
		
		#part of search exact matches
		$count = 0;
		foreach($searchFieldArray AS $field)
		{
			$phrasePart = explode(' ', $phrase);
			foreach($phrasePart AS $part)
			{
				if($count > 0 && trim($part) != '')
				{
					$searchString3 .= " OR ";
				}
				
				if(trim($part) != '')
				{
					$phrase = trim($part);
					if($isDelimited)
					{
						$searchString3 .= $field." LIKE '".$phrase."' OR ".$field." LIKE '%".$delimiter.$phrase."%' OR ".$field." LIKE '%".$delimiter."%".$phrase."%".$delimiter."%' OR ".$field." LIKE '".$delimiter."%".$phrase."' ";
					}
					else
					{
						$searchString3 .= $field." LIKE '".$phrase."'";
					}
					$count++;
				}
			}
		}
		
		#part of search aproximate matches
		$count = 0;
		foreach($searchFieldArray AS $field)
		{
			$phrasePart = explode(' ', $phrase);
			
			if(count($phrasePart) > 1)
			{
				foreach($phrasePart AS $part)
				{
					if($count > 0 && trim($part) != '')
					{
						$searchString4 .= " OR ";
					}
				
					if(trim($part) != '')
					{
						$searchString4 .= $field." LIKE '".trim($part)."'";
						$count++;
					}
				}
			}
		}
		
		
		}#END of check for exact match
		
		return $searchString1.' '.(!empty($searchString2)? ' OR ': '').$searchString2.(!empty($searchString3)? ' OR ': '').$searchString3.(!empty($searchString4)? ' OR ': '').$searchString4;
	}
	
	
	
	
	
	
	
	#Returns the suggested competitors location 
	public function get_store_competitors($merchantId, $excludeList=array(), $returnLimit=10, $returnType='list')
	{
		$finalList = array();
		#get the merchant details
		$merchant = $this->db->query($this->query_reader->get_query_by_code('get_store_by_field', array('field_name'=>'id', 'field_value'=>$merchantId, 'limit_text'=>" LIMIT 0,1; ")))->row_array();
		
		#Now use the merchant details to build a profile of the competitors
		#TODO: Make this list dynamic - and the admin can set it in their profile
		#TODO: Add other scopes after speeding up this query
		$competitorProfile = array('scope_1'=>'price_range|sub_category|zip_code', 'scope_2'=>'price_range|category|zip_code', 'scope_3'=>'price_range|sub_category|county', 'scope_4'=>'price_range|sub_category|city', 'scope_5'=>'price_range|sub_category|online','scope_0'=>'zip_code');
		
		$this->searchLimit = $returnLimit;
		
		#Get the competitors list using the profile levels as directions
		foreach($competitorProfile AS $key=>$scope)
		{
			if(count($this->storeCompetitors) < $returnLimit)
			{
				$finalList = $this->get_stores_by_criteria(array('search_type'=>'merchant', 'return_type'=>$returnType,'search_by'=>$merchant, 'exclude_list'=>$excludeList), $scope, $returnLimit, " AND S.id != '".$merchantId."' ");
			}
			#Do not exceed the set return limit
			else
			{
				$finalList = array_slice($this->storeCompetitors, 0, $returnLimit);
				break; 
			}
		}
		
		return $finalList;
	}
	
	
	
	
	#Get the store by the given criteria
	private function get_stores_by_criteria($parameters, $scope, $returnLimit, $specificQuery='')
	{
		$storesList = array();
		
		if(!empty($parameters['search_type']) && !empty($parameters['search_by']) && !empty($scope))
		{
			switch($parameters['search_type'])
			{
				case 'merchant':
					$criteria = "";
					$parts = explode('|', $scope);
					#Make the merchant zip codes, counties and cities
					$parameters['search_by']['merchant_zipcodes'] = !empty($parameters['search_by']['raw_merchant_zipcodes'])? $parameters['search_by']['raw_merchant_zipcodes'].'|'.$parameters['search_by']['zipcode']: $parameters['search_by']['zipcode'];
					$parameters['search_by']['merchant_counties'] = !empty($parameters['search_by']['raw_merchant_counties'])? $parameters['search_by']['raw_merchant_counties'].'|'.$parameters['search_by']['raw_store_counties']: $parameters['search_by']['raw_store_counties'];
					$parameters['search_by']['merchant_cities'] = !empty($parameters['search_by']['raw_merchant_cities'])? $parameters['search_by']['raw_merchant_cities'].'|'.$parameters['search_by']['raw_store_cities']: $parameters['search_by']['raw_store_cities'];
					
					#Price range
					$criteria .= in_array('price_range', $parts)? " AND CHAR_LENGTH(price_range)=CHAR_LENGTH('".$parameters['search_by']['price_range']."') ": "";
					#Sub categories
					$criteria .= (in_array('sub_category', $parts) && !empty($parameters['search_by']['system_category_tags']))? $this->breakdown_delimited_field_for_search($parameters['search_by']['system_category_tags'], ',', 'system_category_tags'): "";
					
					#Zip codes
					if(in_array('zip_code', $parts) && !empty($parameters['search_by']['merchant_zipcodes']))
					{
						$criteria .= " AND (";
						$searchZipCodes = explode('|', $parameters['search_by']['merchant_zipcodes']);
						$counter = 0;
						foreach($searchZipCodes AS $zipCode)
						{
							$criteria .= $counter > 0? " OR ": "";
							
							$criteria .= " S.zipcode='".$zipCode."' OR L.zipcode='".$zipCode."' ";
							$counter++;
						}
						$criteria .= ") ";
					}
					
					#Counties
					if(in_array('county', $parts) && !empty($parameters['search_by']['merchant_counties']))
					{
						$criteria .= " AND (";
						$searchZipCodes = explode('|', $parameters['search_by']['merchant_counties']);
						$counter = 0;
						foreach($searchZipCodes AS $zipCode)
						{
							$criteria .= $counter > 0? " OR ": "";
							
							$criteria .= " Z.county='".$zipCode."' ";
							$counter++;
						}
						$criteria .= ") ";
					}
					
					#Cities
					if(in_array('city', $parts) && !empty($parameters['search_by']['merchant_cities']))
					{
						$criteria .= " AND (";
						$searchZipCodes = explode('|', $parameters['search_by']['merchant_cities']);
						$counter = 0;
						foreach($searchZipCodes AS $zipCode)
						{
							$criteria .= $counter > 0? " OR ": "";
							
							$criteria .= " Z.city='".$zipCode."' ";
							$counter++;
						}
						$criteria .= ") ";
					}
					
					#Only continue with the items below if the above does not meet the requirements
					#TODO: Add searching locations by zipcode, county or city or whether it is available online
					
					#Exclude the list of the ids listed
					$excludeQuery = !empty($parameters['exclude_list'])? " AND S.id NOT IN ('".implode("','", $parameters['exclude_list'])."') ": "";
					
					$storesList = $this->db->query($this->query_reader->get_query_by_code('get_store_or_its_locations_by_attribute', array('search_string'=>$excludeQuery.$specificQuery.$criteria." LIMIT 0,".$returnLimit."; ")))->result_array(); 
					#Collect the store IDs
					$storeIds = $this->collect_list_attribute('id', $storesList);
					$newIds = array();
					foreach($storeIds AS $id)
					{
						if(!in_array($id, $this->searchStoreIds)) {
							array_push($this->searchStoreIds, $id);
							array_push($newIds, $id);
						}
						
					}
					
					if($parameters['return_type'] == 'list')
					{
						#Get the full data 
						foreach($storesList AS $row)
						{
							if(in_array($row['id'],$this->searchStoreIds)) $this->storeCompetitors[$row['id']] = $row;
						}
						return $this->storeCompetitors;
					}
					else if($parameters['return_type'] == 'ids')
					{
						return $this->searchStoreIds;
					}
					
				break;
				
				
				
				
				
				
				
				case 'user_suggestions':
					return $this->get_default_store_suggestions($parameters, $scope, $returnLimit);
				break;
				
				
				
				
				
				default:
				break;
			}
		}
		
		return $storesList;
	}
	
	
	
	
	
	
	
	
	#Get suggestions of stores to a user based on provided parameters
	public function get_default_store_suggestions($parameters, $sortBy, $maxSearchDistance=25)
	{
		$stores = array();
		$userId = !empty($parameters['user_id'])? $parameters['user_id']: '';
		$itemsPerPage = !empty($parameters['items_per_page'])? $parameters['items_per_page']: 10;
		$start = !empty($parameters['page'])? ($parameters['page']-1)*$itemsPerPage: 0;
		$userLocation = !empty($this->userLocation)? $this->userLocation: $this->promotion_manager->get_most_recent_location((!empty($parameters['user_id'])? $parameters['user_id']: ''), 'longitude_latitude'); 
		
		#If there is no search details, check if there are search results already
		$parameters['store_name'] = !empty($parameters['store_name'])? $parameters['store_name']: ($this->native_session->get('search_store')? $this->native_session->get('search_store'): '');
		$zipcodeOrCity = !empty($parameters['zipcode_or_city'])? $parameters['zipcode_or_city']: ($this->native_session->get('search_location')? $this->native_session->get('search_location'): '');
		$parameters['zipcode'] = (!empty($zipcodeOrCity) && is_numeric($zipcodeOrCity)? $zipcodeOrCity: '');
		$parameters['city'] = (!empty($zipcodeOrCity) && !is_numeric($zipcodeOrCity)? $zipcodeOrCity: '');
		
		#1. First re-sort the order of the store suggestions if the sort order has changed or is not available
		if(empty($this->sortBy) || (!empty($this->sortBy) && $this->sortBy == $sortBy))
		{
			$zipcodeList = array();
			$extraConditions = array('user_id'=>$userId);
			$extraConditions['category'] = !empty($parameters['category'])? $parameters['category']: '';
			if(!empty($parameters['zipcode']))
			{
				$extraConditions['zipcode_list'] = array($parameters['zipcode']);
			}
			else if(!empty($parameters['city']))
			{
				$lastComma = strrpos($parameters['city'], ',');
				$city = htmlentities(trim(substr($parameters['city'], 0, $lastComma)), ENT_QUOTES);
				$state = trim(substr($parameters['city'], $lastComma+1));
				
				$zipcodeList = $this->db->query($this->query_reader->get_query_by_code('get_zipcode_comma_list', array('extra_conditions'=>" AND city LIKE '%".$city."%' AND state LIKE '".strtoupper($state)."' " )))->row_array();
				$extraConditions['zipcode_list'] = !empty($zipcodeList['zipcode_list'])? explode(',',$zipcodeList['zipcode_list']): array();
			}
			
			if(!empty($parameters['store_name']))
			{
				$extraConditions['store_name'] = $parameters['store_name'];
			}
			$storeCount = $this->get_search_list_count($extraConditions, $sortBy, $maxSearchDistance);	
		}
		
		#2. Now get only the portion of the desired list
		$suggested = !empty($this->suggestedMerchantsWithDetails)? array_slice($this->suggestedMerchantsWithDetails, $start, $itemsPerPage): array();
		
		#3. Get the detailed merchant list
		$detailedMerchantList = array();
		
		#make sure that you have a store score for all items which are going to be displayed	
		foreach($suggested AS $storeData)
		{
			#a) Get more store details
			$store = $this->db->query($this->query_reader->get_query_by_code('get_stores_details_for_display', array('latitude'=>$userLocation['latitude'], 'longitude'=>$userLocation['longitude'], 'store_id'=>$storeData['store_id'], 'user_id'=>$userId )))->row_array();
			
			#b) Get the store offer details too
			$store = array_merge($store, $storeData);
			array_push($stores, $store);
		}	
		
		return $stores;
	}
	
	
	
	
	
	#Add the details of store that are listed in the parameters
	public function get_store_details($knownDetails, $parameters, $userId='', $returnType='array')
	{
		$store = $knownDetails;
		
		foreach($parameters AS $parameter)
		{
			if($parameter == 'store_score')
			{
				#a) Check if the store score is already cached. generate it if not
				$cache = $this->db->query($this->query_reader->get_query_by_code('get_store_score_cache', array('user_id'=>$userId, 'store_id'=>$knownDetails['store_id'])))->row_array();
				if(empty($cache))
				{
					$totalScore = $this->scoring->compute_store_score($userId, $knownDetails['store_id'],'Y');
					#Try again to collect the store score
					$cache = $this->db->query($this->query_reader->get_query_by_code('get_store_score_cache', array('user_id'=>$userId, 'store_id'=>$knownDetails['store_id'])))->row_array();
				}
				$store[$parameter] = !empty($cache['total_score'])? $cache['total_score']:0;
			}
			else if($parameter == 'cashback_range')
			{
				$cashBack = (!empty($userId) && !empty($knownDetails['store_id']))? $this->promotion_manager->compute_cashback_range($knownDetails['store_id'], $userId): array('min_cashback'=>0, 'max_cashback'=>0);
				
				#The flat array enables ease of sorting
				if($returnType == 'flat_array')
				{
					$store['min_cashback'] = $cashBack['min_cashback'];
					$store['max_cashback'] = $cashBack['max_cashback'];
					$store[$parameter] =  $cashBack;
				}
				else
				{
					$store[$parameter] =  $cashBack;
				}
			}
			else if($parameter == 'has_perk')
			{
				$store[$parameter] =  (!empty($userId) && !empty($knownDetails['store_id']))? $this->promotion_manager->does_user_qualify_for_perk($userId, $knownDetails['store_id']): 0;
			}
		}
		
		return $store;
	}
	
	
	
	
	
	
	
	#Get a count or the whole possible list of a search result
	public function get_search_list_count($parameters, $sortBy, $maxSearchDistance)
	{
		if(empty($this->suggestedMerchants) || empty($this->sortBy) || (!empty($this->sortBy) && $sortBy != $this->sortBy))
		{
			$itemsPerPage = !empty($parameters['items_per_page'])? $parameters['items_per_page']: 100;
			$start = !empty($parameters['page'])? ($parameters['page']-1)*$itemsPerPage: 0;
			$userId = !empty($parameters['user_id'])? $parameters['user_id']: '';
			$idList = array();
			
			#If the user has specified zipcodes to search from
			$extraCondition = !empty($parameters['zipcode_list'])? " AND S.zipcode IN ('".implode("','", $parameters['zipcode_list'])."') ": "";
			$extraCondition .= !empty($parameters['store_name'])? " AND S.name LIKE '%".htmlentities($parameters['store_name'], ENT_QUOTES)."%' ": "";
			$extraCondition .= !empty($parameters['category'])? " AND C.category_id LIKE '".$parameters['category']."' ": "";
			
			#First get the user location or desired location
			$userLocation = !empty($this->userLocation)? $this->userLocation: $this->promotion_manager->get_most_recent_location($userId, 'longitude_latitude'); 
			
			
			#pull the data from the database
			$rawResult = $this->db->query($this->query_reader->get_query_by_code('get_stores_near_longitude_and_latitude_idlist', array('latitude'=>$userLocation['latitude'], 'longitude'=>$userLocation['longitude'], 'max_distance'=>$maxSearchDistance, 'user_id'=>$userId, 'extra_conditions'=>" AND S.status = 'active' AND S.online_only != 'Y' ".$extraCondition, 'limit_text'=>" LIMIT ".$start.",".$itemsPerPage."; ", 'order_by'=>" distance ASC ")))->result_array();
			foreach($rawResult AS $row)
			{
				array_push($idList, $row['id']);
			}
			
			#Store them so that they are available class-wide
			$this->suggestedMerchants = $idList;
			$this->add_details_to_suggested_merchants($this->suggestedMerchants, $userId);
				
			#Update the sorting order of the stores in the ID list for the best deal sort option
			if($sortBy == 'best_deal')
			{
				#Now sort the list data by best deal
				$sortList = pick_sort_list_data($this->suggestedMerchantsWithDetails, array('max_cashback', 'has_perk', 'min_cashback'));
				array_multisort($sortList['max_cashback'], SORT_DESC, $sortList['has_perk'], SORT_DESC, $sortList['min_cashback'], SORT_DESC,  $this->suggestedMerchantsWithDetails);
				
				#Now get the new suggested store list order
				$this->suggestedMerchants = array_keys($this->suggestedMerchantsWithDetails);
			}
			else if($sortBy == 'store_score')
			{
				#Now sort the list data by best deal
				$sortList = pick_sort_list_data($this->suggestedMerchantsWithDetails, array('store_score'));
				array_multisort($sortList['store_score'], SORT_DESC,  $this->suggestedMerchantsWithDetails); 
				
				#Now get the new suggested store list order
				$this->suggestedMerchants = array_keys($this->suggestedMerchantsWithDetails);
			}
			
			$this->sortBy = $sortBy;
		}
			
		#This is the number of stores to be updated
		return count($this->suggestedMerchants);
	}
	
	
	
	
	
	#Add suggested merchants with details
	private function add_details_to_suggested_merchants($storeList, $userId)
	{
		if(empty($this->suggestedMerchantsWithDetails))
		{
			foreach($storeList AS $storeId)
			{
				$this->suggestedMerchantsWithDetails[$storeId] = $this->get_store_details(array('store_id'=>$storeId), array('store_score', 'cashback_range', 'has_perk'), $userId);
			}
		}
	}
	
	
	
	
	
	
	
	
	#Get zipcodes near a given zipcode
	public function get_zipcode_from_longitude_and_latitude($geoDetails, $returnLimit=1, $returnType='one_zipcode', $extraCondition='')
	{
		$zipcode = '';
		$geoDetails['max_distance'] = !empty($geoDetails['max_distance'])? $geoDetails['max_distance']: 5;
		
		$zipcodeList = $this->db->query($this->query_reader->get_query_by_code('get_zipcode_list_from_longitude_and_latitude', array('longitude'=>$geoDetails['longitude'], 'latitude'=>$geoDetails['latitude'], 'max_distance'=>$geoDetails['max_distance'], 'return_limit'=>$returnLimit, 'condition'=>(!empty($extraCondition)? " WHERE ".$extraCondition : '')     )))->result_array();
		
		if($returnType == 'one_zipcode' && !empty($zipcodeList[0]['zip_code']))
		{
			$zipcode = $zipcodeList[0]['zip_code'];
		}
		else if($returnType == 'zipcode_list')
		{
			$zipcode = array();
			foreach($zipcodeList AS $zipcodeRow)
			{
				array_push($zipcode, $zipcodeRow['zip_code']);
			}
		}
		
		return $zipcode;
	}
	
	
	
	
	
	
	
	
	
	
	#Function to collect an attribute from a search result list
	public function collect_list_attribute($attributeKey, $resultList)
	{
		$finalArray = array();
		#Check if list item exists before executing
		if(!empty($resultList[0][$attributeKey]))
		{
			foreach($resultList AS $row)
			{
				array_push($finalArray, $row[$attributeKey]);
			}
		}
		
		return $finalArray;
	}
	
	
	
	#Function to help in breaking down a field and formatting it for use
	private function breakdown_delimited_field_for_search($fieldValue, $delimiter, $searchField, $includeAnd=TRUE)
	{
		$criteria = ($includeAnd? " AND ": "")."(";
		$categories = explode($delimiter, $fieldValue);
		$count = 0;
		$categoryCount = count($categories);
		foreach($categories AS $category)
		{
			$criteria .= ($count > 0)? ") OR (": "(";
			$criteria .= $this->format_search_query($searchField, $category, TRUE, TRUE,$delimiter);
			$criteria .= ($count == ($categoryCount - 1))? ") ": "";
			$count++;
		}
		$criteria .= ") ";
		
		return $criteria;
	}
	
	
	
	
	#Get the list transactions based on the provided list type
	public function get_more_table_list_items($listType, $page, $itemsPerPage, $desiredColumns=array(), $hasCheckBox='Y')
	{
		$list = array();
		
		#Use the list query to get more data
		#The query has to be cached
		if($this->native_session->get($listType.'_cache_query'))
		{
			$query = $this->native_session->get($listType.'_cache_query');
			
			$lastLimitPos = strrpos($query , 'LIMIT') !== FALSE? strrpos($query , 'LIMIT'): 0;
			$semiColonPos = strrpos($query , ';', $lastLimitPos) !== FALSE? strrpos($query , ';', $lastLimitPos): 0;
			
			#Only proceed if there are limit instructions
			if($lastLimitPos > 0)
			{
				$start = ($page-1)*$itemsPerPage;
				$limitStringLength = $semiColonPos - $lastLimitPos;
				$newQuery = substr_replace($query, 'LIMIT '.$start.','.$itemsPerPage, $lastLimitPos, $limitStringLength);
				
				#Now get the new list items
				$list = $this->db->query($newQuery)->result_array();
			}
		}
		
		return $this->format_list_into_table_rows($list, $desiredColumns, $hasCheckBox);
	}
	
	
	
	#Gets a list returned from the database query and returns a string with the table rows as desired
	private function format_list_into_table_rows($list, $desiredColumns, $hasCheckBox)
	{
		$tableString = "";
		$desiredColumns = !empty($desiredColumns)? $desiredColumns: (!empty($list[0])? array_keys($list[0]): array());
		
		#Go through the list results and pick the desired 
		if(!empty($desiredColumns))
		{
			foreach($list AS $row)
			{
				$tableString .= "<tr>";
				if($hasCheckBox == 'Y')
				{
					$tableString .= "<td><input id='select_".$row['id']."' name='selectlist[]' type='checkbox' value='".$row['id']."' class='bigcheckbox'><label for='select_".$row['id']."'></label></td>";
				}
				
				#Go through each of the columns in the row
				foreach($desiredColumns AS $column)
				{
					$columnParts = explode('<>', $column);
					if(array_key_exists($columnParts[0], $row))
					{
						$tableString .= "<td>".$this->format_cell_data($row[$columnParts[0]], (!empty($columnParts[1])?$columnParts[1]: ''))."</td>";
					}
				}
				$tableString .= "</tr>";
			}
		}
		
		return $tableString;
	}
	
	
	
	
	
	
	
	
	#Function to provide the list columns to pull from the database for a given list - to enable further list loading
	public function get_desired_list_columns($listCode)
	{
		switch($listCode)
		{
			case 'transactions':
				return array('start_date<>DATE', 'user_name<>STRING|UCWORDS', 'store_name<>STRING', 'amount<>MONEY[sign=none]', 'transaction_type<>CONVERT[buy=Withdrawal,other=Deposit]', 'item_details', 'store_address');
			break;
			
			
			
			
			
			
			
			
			
			
			
			default:
				return array();
			break;
		}
	}
	
	
	
	
	
	
	//Fomarts the cell data ready for display to a user screen
	public function format_cell_data($rawData, $instructions='')
	{
		$finalCellData = $rawData;
		if(!empty($rawData))
		{
			$instructionsList = explode('|', $instructions);
		
			foreach($instructionsList AS $instructionCode)
			{
				$useCode = strpos($instructionCode, '[') !== FALSE? substr($instructionCode, 0, strpos($instructionCode, '[')): $instructionCode;
				switch($useCode)
				{
					case 'DATE':
						$finalCellData = ($finalCellData != '0000-00-00 00:00:00')? date('D, M j, Y', strtotime($finalCellData)): '&nbsp;';
					break;
			
			
					case 'STRING':
						$finalCellData = html_entity_decode($finalCellData, ENT_QUOTES);
					break;
			
			
					case 'UCWORDS':
						$finalCellData = ucwords($finalCellData);
					break;
			
			
					case 'MONEY':
						$extraInstructions = get_string_between($instructionCode, '[', ']');
						$extraList = explode(',', $extraInstructions);
						#Apply the extra instructions
						foreach($extraList AS $extraInstruction)
						{
							$extraArray = explode('=', $extraInstruction);
							if($extraArray[0]=='sign' && $extraArray[1]=='none')
							{
								$finalCellData = '$'.add_commas($finalCellData < 0? (0-$finalCellData): $finalCellData);
							}
							else if($extraArray[0]=='sign' && $extraArray[1]=='asis')
							{
								$finalCellData = $finalCellData < 0? '($'.add_commas(0-$finalCellData).')': '$'.add_commas($finalCellData);
							}
						}
					break;
			
			
					case 'CONVERT':
						$extraInstructions = get_string_between($instructionCode, '[', ']');
						$extraList = explode(',', $extraInstructions);
						$instructionsInArray = array();
						
						#Apply the extra instructions
						foreach($extraList AS $extraInstruction)
						{
							$extraArray = explode('=', $extraInstruction);
							$instructionsInArray[$extraArray[0]] = $extraArray[1];
						}
						#Convert to the appropriate value in the conversion array
						$finalCellData = !empty($instructionsInArray[$finalCellData])? $instructionsInArray[$finalCellData]: (!empty($instructionsInArray['other'])? $instructionsInArray['other']: $finalCellData);
					break;
			
			
					default:
						#Do not apply any formatting to the data
					break;
				}
			}
		}
		
		return $finalCellData;
	}
	
	
	
	
	
	
	
}

?>