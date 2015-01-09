<?php

/**
 * This class manages store functionality in the system
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.1.0
 * @copyright Clout
 * @created 05/16/2014
 */
class Store_manager extends CI_Model
{
	#the current user ID
	private $userId;
	#the current store ID
	private $storeId;
	#the store details from the store table row
    private $storeDetails;
	#the schedule
    private $schedule;
	#relevant tags for the store
	private $relevantTags;
	#photos for the store
	private $photos;
	#offers from the store
	private $offers;
	
	
	
	#Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
		$this->load->model('promotion_manager');
	}
	
	
	
	
	
	#Gets desired details passed as a list of codes
	public function get_store_details($storeId, $requiredData, $userId='') 
	{
		$this->set_store_id($storeId);
		$this->set_user_id($userId);
		
		$response = array();
		
		foreach($requiredData AS $dataCode)
		{
			$response[$dataCode] = $this->get_store_data_by_code($storeId, $dataCode, $userId);
		}
		return $response;
	}
	
	
	
	#Get store data given the code desired
	public function get_store_data_by_code($storeId, $dataCode, $userId='')
	{
		if(empty($this->storeId)) $this->set_store_id($storeId);
		if(empty($this->userId) || (!empty($this->userId) && $this->userId != $userId)) $this->set_user_id($userId);
		
		switch($dataCode) 
		{
    		case 'name':
        		return !empty($this->storeDetails['name'])? $this->storeDetails['name']: $this->get_store_detail('name');
			break;
			
			case 'address':
        		return !empty($this->storeDetails['address'])? $this->storeDetails['address']: $this->get_store_address();
			break;
			
			case 'phone_number':
        		return !empty($this->storeDetails['phone_number'])? $this->storeDetails['phone_number']: $this->get_store_detail('phone_number');
			break;
			
			case 'website':
        		return !empty($this->storeDetails['website'])? $this->storeDetails['website']: $this->get_store_detail('website');
			break;
			
			case 'is_favorite':
        		return !empty($this->storeDetails['is_favorite'])? $this->storeDetails['is_favorite']: $this->get_store_detail('is_favorite');
			break;
			
			case 'category_tags':
        		return !empty($this->storeDetails['category_tags'])? $this->storeDetails['category_tags']: $this->get_store_detail('category_tags');
			break;
			
			case 'sub_category_tags':
        		return !empty($this->storeDetails['sub_category_tags'])? $this->storeDetails['sub_category_tags']: $this->get_store_detail('sub_category_tags');
			break;
			
			case 'price_range':
        		return !empty($this->storeDetails['price_range'])? $this->storeDetails['price_range']: $this->get_store_detail('price_range');
			break;
			
			case 'schedule':
        		return !empty($this->schedule)? $this->schedule: $this->get_store_schedule();
			break;
			
			case 'description':
        		return !empty($this->storeDetails['description'])? $this->storeDetails['description']: $this->get_store_detail('description');
			break;
			
			case 'relevant_tags':
        		return !empty($this->relevantTags)? $this->relevantTags: $this->get_relevant_tags();
			break;
			
			case 'photos':
        		return !empty($this->photos)? $this->photos: $this->get_photo_list();
			break;
			
			case 'offers':
        		return !empty($this->offers)? $this->offers: $this->get_offer_list();
			break;
			
			
			
			
			
			
			default:
				return "ERROR: code not recognized.";
			break;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	#Get offer list
	public function get_offer_list($limit=20)
	{
		$cashBackOffers = $this->promotion_manager->which_promotions_does_score_qualify_for($this->storeId, $this->userId, array('cash_back'), $limit);
		$perkOffers = $this->promotion_manager->which_promotions_does_score_qualify_for($this->storeId, $this->userId, array('perk'), $limit);
		return array('cash_back'=>$cashBackOffers, 'perks'=>$perkOffers);
	}
	
	
	
	
	
	#Get photo list
	public function get_photo_list($limit=100)
	{
		return $this->db->query($this->query_reader->get_query_by_code('get_store_photo_list', array('store_id'=>$this->storeId, 'order_by'=>" ORDER BY is_featured DESC, (0+display_order) ASC, who_submitted ASC, date_added DESC ", 'limit_text'=>' LIMIT 0,'.$limit.';')))->result_array(); 
	}
	
	
	
	
	
	#Get relevant tags
	public function get_relevant_tags($returnType='string', $tagsOfInterest=array(), $tagLimit=100)
	{
		$tags = array();
		$tagsOfInterest = !empty($tagsOfInterest)? $tagsOfInterest: array('good_for', 'online_only', 'ages_allowed', 'parking', 'attire', 'good_for_kids', 'takes_reservations', 'delivery', 'accepts_credit_cards', 'take_out', 'waiter_service', 'outdoor_seating', 'wi_fi', 'alcohol', 'noise_level', 'ambience', 'caters',  'wheelchair_accessible', 'dogs_allowed', 'by_appointment_only', 'music', 'smoking', 'coat_check', 'good_for_dancing', 'has_tv', 'happy_hour', 'best_nights', 'good_for_groups', 'accepts_insurance', 'drive_thru', 'is_franchise');
		
		#Get tags of interest
		foreach($tagsOfInterest AS $tag)
		{
			$tagString = !empty($this->storeDetails[$tag])? $this->storeDetails[$tag]: $this->get_store_detail($tag);
			
			if($tag == 'online_only' && $tagString == 'Y') array_push($tags, 'Online Only');
			
			#Plain Yes or No
			if(in_array($tag, array('good_for_kids', 'takes_reservations', 'delivery', 'accepts_credit_cards', 'take_out', 'waiter_service', 'outdoor_seating', 'wi_fi', 'alcohol', 'caters', 'wheelchair_accessible', 'dogs_allowed', 'by_appointment_only', 'music', 'smoking', 'coat_check', 'good_for_dancing', 'has_tv', 'good_for_groups', 'accepts_insurance', 'drive_thru', 'is_franchise')) && $tagString == 'Yes')
			{
				array_push($tags, ucwords(str_replace('_', ' ', $tag)));
			}
			
			#Get the value of the tag
			if(in_array($tag, array('good_for','ages_allowed','happy_hour', 'best_nights')) && !empty($tagString))
			{
				array_push($tags, str_replace(',', ', ', $tagString));
			}
			
			#Extra info
			if(in_array($tag, array('parking','noise_level', 'ambience', 'attire')) && !empty($tagString))
			{
				array_push($tags, str_replace(',',' and ',$tagString).' '.ucwords(str_replace('_', ' ', $tag))); 
			}
		}
		
		
		return ($returnType == 'array')? $tags: implode(', ', $tags);
	}
	
	
	
	
	
	
	#Get the store schedule
	public function get_store_schedule($returnType='string', $daysOfInterest=array())
	{
		#Start with a blank schedule
		$schedule = array(
			'Mon'=>array('start'=>'', 'end'=>''),
		 	'Tue'=>array('start'=>'', 'end'=>''), 
		 	'Wed'=>array('start'=>'', 'end'=>''), 
		 	'Thu'=>array('start'=>'', 'end'=>''), 
			'Fri'=>array('start'=>'', 'end'=>''), 
			'Sat'=>array('start'=>'', 'end'=>''), 
			'Sun'=>array('start'=>'', 'end'=>'')
		);
		
		#Get the string according to the database
		$scheduleString = !empty($this->storeDetails['hours'])? $this->storeDetails['hours']: $this->get_store_detail('hours');
		$days = array_keys($schedule);
		$dayRange = array();
		
		#first split up the string
		if(!empty(trim($scheduleString)))
		{
			$daysHoursArray = explode('|', $scheduleString);
			foreach($daysHoursArray AS $dayKey=>$daysHours)
			{
				$daysForRange = array();
				$daysHours = trim($daysHours);
				$daySchedule = explode(' ', trim($daysHours));
			
				#Make the day range
				if(strpos($daySchedule[0], '-') !== false)
				{
					$stringRange = explode('-', $daySchedule[0]);
					#The start day
					if(strpos($stringRange[0], ',') !== false)
					{
						$startDays = explode(',', $stringRange[0]);
						$startRangeDate = array_pop($startDays);
						$daysForRange = array_merge($daysForRange, $startDays);
					}
					else
					{
						$startRangeDate = $stringRange[0];
					}
				
					#The end day
					if(strpos($stringRange[1], ',') !== false)
					{
						$endDays = explode(',', $stringRange[1]);
						$endRangeDate = array_shift($endDays);
						$daysForRange = array_merge($daysForRange, $endDays);
					}
					else
					{
						$endRangeDate = $stringRange[1];
					}
				
					#Now also include the range
					$startDateNumber = date('N', strtotime(trim($startRangeDate))) - 1;
					$endDateNumber = date('N', strtotime(trim($endRangeDate))) - 1; 
					for($i=$startDateNumber; $i<=$endDateNumber; $i++)
					{
						array_push($daysForRange, $days[$i]);
					}
				}
				else
				{
					array_push($daysForRange, $daySchedule[0]);
				}
				
				#clean days
				$dayRange = array_merge($dayRange, $daysForRange);
				$dayRange = array_unique($dayRange);
				$hours = array_slice($daySchedule, 1);
			
				#Now add the start and end hours
				foreach($dayRange AS $day)
				{
					if(in_array($day, $daysForRange))
					{
						$startHr = (!empty($hours[0]) && !empty($hours[1]))? date('Hi', strtotime($hours[0].$hours[1])): '';
						$endHr = (!empty($hours[3]) && !empty($hours[4]))? date('Hi', strtotime($hours[3].$hours[4])): '';
						#Make sure the start date you have is the lowest in the schedule list given
						$schedule[$day]['start'] = !empty($schedule[$day]['start'])? ($schedule[$day]['start'] > $startHr? $startHr: $schedule[$day]['start']): $startHr;
						#Make sure the end date you have is the highest in the schedule list given
						$schedule[$day]['end'] = !empty($schedule[$day]['end'])? ($schedule[$day]['end'] < $endHr? $endHr: $schedule[$day]['end']): $endHr;
					}
				}
			}
		}
		
		
		#Only take the days of interest if specified
		if(!empty($daysOfInterest))
		{
			$newSchedule = array();
			foreach($daysOfInterest AS $dayOfWeek)
			{
				$newSchedule[$dayOfWeek] = $schedule[$dayOfWeek];
			}
			$schedule = $newSchedule;
		}
		
		#Now determine the return type
		if($returnType == 'string')
		{
			$newSchedule = array();
			foreach($schedule AS $day=>$daySchedule)
			{
				$newSchedule[$day] = ((empty($daySchedule['start']) && empty($daySchedule['end']))? 'Closed': (!empty($daySchedule['start']) && !empty($daySchedule['end'])? date('g:ia', strtotime($daySchedule['start'])).' - '.date('g:ia', strtotime($daySchedule['end'])):  (!empty($daySchedule['start'])? date('g:ia', strtotime($daySchedule['start'])): '')   ));
			}
			$schedule = $newSchedule;
		}
		
		return $schedule;
	}
	
	
	
	
	
	
	
	#Get a detail of the store from the store DB table row
	public function get_store_detail($detailCode)
	{
		$location = $this->promotion_manager->get_most_recent_location($this->userId);
		$store = $this->db->query($this->query_reader->get_query_by_code('get_stores_details_for_display', array('store_id'=>$this->storeId, 'user_id'=>$this->userId, 'latitude'=>$location['latitude'], 'longitude'=>$location['longitude'])))->row_array();
		$this->storeDetails = !empty($store)? $store: array();
		
		#Format some of the data passed
		$this->storeDetails[$detailCode] = ($detailCode == 'phone_number' && !empty($this->storeDetails[$detailCode])? str_replace(')','',str_replace('(','',str_replace('-','',str_replace(' ','',$this->storeDetails[$detailCode])))): $this->storeDetails[$detailCode]);
		
		return !empty($this->storeDetails[$detailCode])? $this->storeDetails[$detailCode]: '';
	}
	
	
	
	
	#gets the store address
	public function get_store_address($addressKeys=array(), $returnType='string')
	{
		$address['address_line_1'] = !empty($this->storeDetails)? $this->storeDetails['address_line_1']: $this->get_store_detail('address_line_1');
		$address['address_line_2'] = !empty($this->storeDetails)? $this->storeDetails['address_line_2']: $this->get_store_detail('address_line_2');
		$address['city'] = !empty($this->storeDetails)? $this->storeDetails['city']: $this->get_store_detail('city');
		$address['state'] = !empty($this->storeDetails)? $this->storeDetails['state']: $this->get_store_detail('state');
		$address['zipcode'] = !empty($this->storeDetails)? $this->storeDetails['zipcode']: $this->get_store_detail('zipcode');
		$address['country'] = !empty($this->storeDetails)? $this->storeDetails['country']: $this->get_store_detail('country');
		
		$returnArray = array();
		#Pick only the desired keys
		if(!empty($addressKeys))
		{
			foreach($addressKeys AS $key)
			{
				$returnArray[$key] = $address[$key];
			}
		}
		else
		{
			$returnArray = $address;
		}
		
		#Determine the return type
		if($returnType == 'array')
		{
			return $returnArray;
		}
		else
		{
			$cleanArray = array_filter($returnArray);
			return implode(', ', $cleanArray);
		}
	}
	
	
	
	
	#Set the store ID
	private function set_store_id($storeId)
	{
		$this->storeId = $storeId;
	}
	
	
	#Set the user ID
	private function set_user_id($userId)
	{
		$this->userId = $userId;
	}
	
	
	
	
	#Checkin a user
	public function checkin_user_on_offer($userId, $offerId, $otherDetails="")
	{
		$location = $this->promotion_manager->get_current_location_by_ip('longitude_latitude');
		$store = $this->db->query($this->query_reader->get_query_by_code('get_store_details_from_promotion', array('promotion_id'=>$offerId)))->row_array();
		
		return $this->db->query($this->query_reader->get_query_by_code('add_user_checkin', array('user_id'=>$userId, 'longitude'=>($location['longitude']? $location['longitude']: ''), 'latitude'=>($location['latitude']? $location['latitude']: ''), 'store_id'=>($store['store_id']? $store['store_id']: ''), 'offer_id'=>$offerId, 'details'=>'', 'source'=>'checkin')));
	}
	
	
	
	
	#Send a schedule request to the store owner
	public function send_schedule_request($userId, $offerId, $formData)
	{
		#1. Get the user and offer details
		$user = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$userId)))->row_array();
		$offer = $this->db->query($this->query_reader->get_query_by_code('get_promotion_by_id', array('promotion_id'=>$offerId)))->row_array();
		$store = $this->db->query($this->query_reader->get_query_by_code('get_store_by_id', array('store_id'=>$offer['store_id'], 'user_id'=>$userId )))->row_array();
		
		#Format the form data
		$userName = $user['first_name'].' '.$user['last_name'];
		$scheduleDate = date('Y-m-d H:i:s', strtotime($formData['reservationdate'].' '.$formData['reservationtime']));
		$noInParty = !empty($formData['noinparty'])?$formData['noinparty']: 1;
		$phoneType = ucwords($formData['phonetype']);
		$specialRequest = htmlentities($formData['specialrequests'], ENT_QUOTES);
		
		#2. Record the schedule in the database
		$scheduleResult = $this->db->query($this->query_reader->get_query_by_code('add_store_schedule', array('store_id'=>$offer['store_id'], 'scheduler_email'=>$formData['useremail'], 'scheduler_phone'=>$formData['userphone'], 'phone_type'=>$formData['phonetype'], 'schedule_date'=>$scheduleDate, 'number_in_party'=>$noInParty, 'special_request'=>$specialRequest )));
		
		#3. Notify the owner about the schedule
		if($scheduleResult && check_sending_settings($this, $offer['store_id'], 'email'))
		{
			$sendResult = $this->sys_email->email_form_data(array('fromemail'=>$formData['useremail'], 'fromname'=>$userName), get_confirmation_messages($this, array('emailaddress'=>$store['email_address'], 'fromname'=>$userName, 'phonenumber'=>$formData['userphone'], 'phonetype'=>$phoneType, 'scheduledate'=>$scheduleDate, 'noinparty'=>$noInParty, 'specialrequest'=>$specialRequest, 'useremail'=>$formData['useremail']), 'send_store_schedule')); 
		}
		else if($scheduleResult && check_sending_settings($this, $offer['store_id'], 'sms'))
		{
			$sendResult = TRUE;
			#TODO: Add SMS sending functionality
		}
		else if($scheduleResult && check_sending_settings($this, $offer['store_id'], 'voice'))
		{
			$sendResult = TRUE;
			#TODO: Add voice call functionality
		}
		
		return get_decision(array($scheduleResult, $sendResult));
	}
	
	
	
	
	
	
	
	#Suggest a store to clout
	public function suggest_store($extraInfo)
	{
		if(!empty($extraInfo['user_id']))
		{
			$userDetails = $this->db->query($this->query_reader->get_query_by_code('get_user_by_id', array('id'=>$extraInfo['user_id'])))->row_array();
		}
		#Check where it is coming from
		$fromEmail = !empty($userDetails['id'])? $userDetails['email_address']: NOREPLY_EMAIL;
		$fromName = !empty($userDetails['id'])? $userDetails['name']: SITE_TITLE;
		
		#Record store suggestion
		$extraInfo = array('store_name'=>htmlentities($extraInfo['newstorename'], ENT_QUOTES), 'contact_name'=>htmlentities($extraInfo['contactname'], ENT_QUOTES), 'contact_phone'=>$extraInfo['contactphone'], 'store_website'=>$extraInfo['website'], 'store_address'=>htmlentities($extraInfo['address'], ENT_QUOTES), 'store_city'=>$extraInfo['city'], 'store_state'=>$extraInfo['state'], 'store_zipcode'=>$extraInfo['zipcode'], 'suggested_by'=>(!empty($extraInfo['user_id'])? $extraInfo['user_id']: ''), 'from_email'=>$fromEmail, 'from_name'=>$fromName, 'store_country'=>'USA', 'emailaddress'=>SITE_ADMIN_MAIL );
		
		$results[0] = $this->db->query($this->query_reader->get_query_by_code('record_store_suggestion', $extraInfo));
		
		#Send nootification to admin about the suggestion
		if($results[0])
		{
			$results[1] = $this->sys_email->email_form_data(array('fromemail'=>$fromEmail, 'fromname'=>$fromName), get_confirmation_messages($this, $extraInfo, 'store_suggestion'));
		}
		return get_decision($results);
	}
	
	
	
	
	
	
	
	
	
}

?>