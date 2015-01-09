<?php 

if(!empty($area) && strpos($area, 'selectlist__') !== FALSE)
{ 
	
	if(!empty($pageList))
	{
		$tableHTML = '';
		$counter = 0;
		$listLength = count($pageList) -1;
		#determine which layer to close
		$layerClues = explode('__', $layer);
		$layer = $layerClues[0].'__container';
		
		
		switch($area)
		{
			#Business categories
			case 'selectlist__business_category':
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div onclick=\"updateFieldValue('".$layerClues[0]."', '".$row['category_name']."');hideLayerSet('".$layer."');showLayerSet('".$layerClues[0]."__sublayer')\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".$row['category_name']."</div>";
					$counter++;
				}
			break;	
			
			#Business sub categories
			case 'selectlist__business_subcategory':
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div onclick=\"updateFieldValue('".$layerClues[0]."', '".$row['subcategory']."');updateFieldValue('".$layerClues[0]."__id', '".$row['id']."');hideLayerSet('".$layer."')\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".$row['subcategory']."</div>";
					$counter++;
				}
			break;
			
			#Business name
			case 'selectlist__business_name': 
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div onclick=\"updateFieldValue('".$layerClues[0]."', '".str_replace("&#039;", "\'", $row['name'])."');updateFieldValue('".$layerClues[0]."claimid', '".$row['id']."');hideLayerSet('".$layer."');showLayerSet('business_claim_notice')\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".limit_string_length($row['name']." (".$row['address_line_1'].' '.$row['address_line_2'].' '.$row['city'].', '.$row['state'].' '.$row['zipcode'], 40).") "."</div>";
					$counter++;
				}
				
				$tableHTML .= ($counter >= 50)? "<BR><span style='font-weight:700;padding-left:5px;'>Enter a business name to view more</span>":'';
			break;
			
			
			#Competitor name
			case 'selectlist__competitor_name':
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div class='contentitemdiv' onclick=\"addRowToCompetitorTable('competitor_list_table', '".$row['id']."', '".htmlentities(limit_string_length(addslashes(html_entity_decode($row['name'], ENT_QUOTES))." (".$row['address_line_1'], 32).") ", ENT_QUOTES)."');hideLayerSet('".$layer."')\">".limit_string_length($row['name']." (".$row['address_line_1'].' '.$row['address_line_2'].' '.$row['city'].', '.$row['state'].' '.$row['zipcode'], 65).") 
					
					<div id='content_".$row['id']."' style='display:none;'></div>
					
					</div>";
					$counter++;
				}
				
				$tableHTML .= ($counter >= 50)? "<BR><span style='font-weight:700;padding-left:5px;'>Enter a business name to view more</span>":'';
			break;
			
			#Store name
			case 'selectlist__store_name': 
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div onclick=\"updateFieldValue('".$layerClues[0]."', '".str_replace("&#039;", "\'", $row['name'])."');hideLayerSet('".$layer."');\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".limit_string_length($row['name']." (".$row['address_line_1'].' '.$row['address_line_2'].' '.$row['city'].', '.$row['state'].' '.$row['zipcode'], 40).") "."</div>";
					$counter++;
				}
				
				$tableHTML .= ($counter >= 50)? "<BR><span style='font-weight:700;padding-left:5px;'>Enter a business name to view more</span>":'';
			break;
			
			
			#State list
			case 'selectlist__states':
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div onclick=\"updateFieldValue('".$layerClues[0]."', '".limit_string_length($row['state_name'],12)."');updateFieldValue('".$layerClues[0]."code', '".$row['state_code']."');hideLayerSet('".$layer."')\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".$row['state_name']."</div>";
					$counter++;
				}
			break;
				
			
			#City list
			case 'selectlist__cities':
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div onclick=\"updateFieldValue('".$layerClues[0]."', '".$row['name']."');hideLayerSet('".$layer."')\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".$row['name']."</div>";
					$counter++;
				}
				
				$tableHTML .= ($counter >= 50)? "<BR><span style='font-weight:700;padding-left:5px;'>Enter a city name to view more</span>":'';
			break;
				
			
			#Country
			case 'selectlist__countries':
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div onclick=\"updateFieldValue('".$layerClues[0]."', '".$row['name']."');updateFieldValue('".$layerClues[0]."code', '".$row['code']."');hideLayerSet('".$layer."')\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".$row['name']."</div>";
					$counter++;
				}
			break;
				
			
			#Annual revenue
			case 'selectlist__annualrevenue':
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div onclick=\"updateFieldValue('".$layerClues[0]."', '".$row['amount_range']."');hideLayerSet('".$layer."')\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".$row['amount_range']."</div>";
					$counter++;
				}
			break;
				
			
			#Price range
			case 'selectlist__pricerange':
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div onclick=\"updateFieldValue('".$layerClues[0]."', '".$row['range_marker']."');hideLayerSet('".$layer."')\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".$row['range_marker']."</div>";
					$counter++;
				}
			break;
			
			
			
			
			case 'selectlist__zipcode_or_city':
				
				foreach($pageList AS $row)
				{
					$display = ($sub_area == 'zipcode')? $row['zip_code']: ucwords(strtolower($row['city'])).', '.$row['state_code']; 
					
					$tableHTML .= "<div onclick=\"updateFieldValue('".$layerClues[0]."', '".$display."');hideLayerSet('".$layer."')\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".$display."</div>";
					$counter++;
				}
				
				$tableHTML .= ($counter >= 50)? "<BR><span style='font-weight:700;padding-left:5px;'>Enter a city name or zip code to view more</span>":'';
			break;
			
			#Store name for the search list
			case 'selectlist__search_store_name': 
				foreach($pageList AS $row)
				{
					$tableHTML .= "<div onclick=\"updateFieldLayer('".base_url()."web/search/show_store_home/t/".encrypt_value('single_result')."/i/".encrypt_value($row['id'])."','','','','');hideLayerSet('".$layer."');\" class='searchlistitem' style='".($counter < $listLength? '': 'padding-bottom:0px;border-bottom: 0px;').($counter == 0? 'padding-top:0px;': '')."'>".limit_string_length($row['name']." (".$row['address_line_1']." ".$row['address_line_2']." ".$row['city'].", ".$row['state']." ".$row['zipcode'], 40).") "."</div>";
					$counter++;
				}
				
				$tableHTML .= ($counter >= 50)? "<BR><span style='font-weight:700;padding-left:5px;'>Enter a business name to view more</span>":'';
			break;
			
			
			
			
			
			
			
			
			
			
			
			
			
				
			default:
			break;
		}
			
			
			
			
		
		
	}
	else
	{
		$defaultMsg = get_list_message($this,$area);
		if(!empty($defaultMsg))
		{
			$tableHTML = $defaultMsg;
		}
		else
		{
			$tableHTML = !empty($msg)? format_notice($msg): format_notice('WARNING:No search results.');
		}
	}
}









echo $tableHTML;
?>