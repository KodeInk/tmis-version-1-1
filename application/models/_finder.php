<?php
/**
 * This class searches for data on the system.
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.1.0
 * @copyright TMIS
 * @created 01/08/2015
 */
class _finder extends CI_Model
{
	
	# Load a list of search items
	function load_list($instructions)
	{
		$data = $instructions;
		$list = array();
		# Get the search parameters passed with the instructions
		$data['page'] = !empty($data['p']) && empty($data['__clear'])? $data['p']: 1;
		$data['pagecount'] = !empty($data['n']) && empty($data['__clear'])? $data['n']: NUM_OF_ROWS_PER_PAGE;
		$data['phrase'] = !empty($data['phrase']) && empty($data['__clear'])? addslashes(restore_bad_chars($data['phrase'])): '';
		$data['searchby'] = !empty($data['searchby']) && empty($data['__clear'])? explode('--', $data['searchby']): '';
		
		if(!empty($instructions['type']))
		{
			$data['listid'] = $instructions['type'].'search';
			switch($instructions['type'])
			{
				case 'user':
					$this->load->model('_user');
					#Did the UI send any fields to search by?
					if(empty($data['__clear']))
					{
						$searchBy = !empty($data['searchby'])? $data['searchby']: array('P.first_name', 'P.last_name');
						$data['searchstring'] = $this->generate_phrase_query($searchBy, $data['phrase']);
					}
					$list = $this->_user->get_list($data);
				break;
				
				
				case 'vacancy':
					$this->load->model('_vacancy');
					#Did the UI send any fields to search by?
					if(empty($data['__clear']))
					{
						$searchBy = !empty($data['searchby'])? $data['searchby']: array('V.topic', 'V.summary', 'I.name');
						$data['searchstring'] = $this->generate_phrase_query($searchBy, $data['phrase']);
					}
					$list = $this->_vacancy->get_list($data);
				break;
			}
		}
		$data['list'] = $list;
		return $data;
	}
		




	# Format the search query to be used in the search
	function generate_phrase_query($searchBy, $phrase)
	{
		$query = array();
		$phrase = htmlentities($phrase, ENT_QUOTES);
		
		foreach($searchBy AS $field)
		{
			array_push($query, "(".$field." LIKE '".$phrase."%' OR ".$field." LIKE '% ".$phrase."%')");
		}
		
		return " (".implode(" OR ", $query).") ";
	}

}


?>