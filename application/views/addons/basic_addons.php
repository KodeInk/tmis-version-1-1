<?php 
$jquery = "<script src='".base_url()."assets/js/jquery.min.js' type='text/javascript'></script>";
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/tmis.js'></script>".get_AJAX_constructor(TRUE); 

$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/tmis.css' type='text/css' media='screen' />"; 

if(!empty($area) && $area == "show_bigger_image")
{
	$tableHTML .= "<table width='530' height='398' border='0' cellspacing='0' cellpadding='0'><tr><td><img src='".$url."' border='0' /></td></tr></table>"; 
}



else if(!empty($area) && $area == "basic_msg" && !empty($msg)) 
{
	$tableHTML .= format_notice($msg);
}




else if(!empty($area) && $area == "address_field_form")
{
	$tableHTML .= "<table border='0' cellspacing='0' cellpadding='5' id='".$field_id."__form' class='simpleform'>";
	
  	$tableHTML .= !empty($physical_only)? "":"<tr><td>
  			<div class='nextdiv'><input type='radio' name='".$field_id."__addresstype' id='".$field_id."__addresstype_physical' value='physical' ".((!$this->native_session->get($field_id.'__addresstype') || ($this->native_session->get($field_id.'__addresstype') && $this->native_session->get($field_id.'__addresstype')=='physical'))? 'checked': '')."><label for='".$field_id."__addresstype_physical'>Physical</label></div>
  			<div class='nextdiv'><input type='radio' name='".$field_id."__addresstype' id='".$field_id."__addresstype_postal' value='postal' ".(($this->native_session->get($field_id.'__addresstype') && $this->native_session->get($field_id.'__addresstype')=='postal')? 'checked': '')."><label for='".$field_id."__addresstype_postal'>Postal</label></div>
		</td></tr>";
	   
	$tableHTML .= "<tr><td><input type='text' id='".$field_id."__addressline' name='".$field_id."__addressline' class='textfield' placeholder='Address' value='".($this->native_session->get($field_id.'__addressline')? $this->native_session->get($field_id.'__addressline'): '')."' maxlength='200'/></td></tr>
	
  <tr><td><input type='text' id='".$field_id."__county' name='".$field_id."__county' class='textfield optional' placeholder='County (Optional)' value='".($this->native_session->get($field_id.'__county')? $this->native_session->get($field_id.'__county'): '')."' maxlength='200'/></td></tr>
  
  <tr><td><input type='text' id='".$field_id."__district' name='".$field_id."__district' class='textfield selectfield editable' placeholder='District or State' value='".($this->native_session->get($field_id.'__district')? $this->native_session->get($field_id.'__district'): '')."' maxlength='200'/>".
  ($this->native_session->get($field_id.'__district__hidden')? "<input type='hidden' id='".$field_id."__district__hidden' name='".$field_id."__district__hidden' value='".$this->native_session->get($field_id.'__district__hidden')."' /><div id='".$field_id."__district__div' class='selectfielddiv'></div>": "")
  ."</td></tr>
  
  <tr><td><input type='text' id='".$field_id."__country' name='".$field_id."__country' class='textfield selectfield' placeholder='Country' value='".($this->native_session->get($field_id.'__country')? $this->native_session->get($field_id.'__country'): '')."' maxlength='200'/>".
  ($this->native_session->get($field_id.'__country__hidden')? "<input type='hidden' id='".$field_id."__country__hidden' name='".$field_id."__country__hidden' value='".$this->native_session->get($field_id.'__country__hidden')."' /><div id='".$field_id."__country__div' class='selectfielddiv'></div>": "")
  ."</td></tr>
  
  <tr><td style='text-align:right'><button type='button' id='".$field_id."__btn' name='".$field_id."__btn' ".($this->native_session->get($field_id.'__addressline')? "class='submitbtn btn' onclick=\"postFormFromLayer('".$field_id."__form')\"": "class='submitbtn greybtn'").">SAVE</button><div id='".$field_id."__resultsdiv' style='display:none;'></div><input type='hidden' id='".$field_id."__response_fields' name='".$field_id."__response_fields' value='".$field_id."__addressline' /><input type='hidden' id='".$field_id."__type' name='".$field_id."__type' value='address' /></td></tr>
  </table>";
}




else if(!empty($area) && $area == "dropdown_list")
{
	$tableHTML .= !empty($list)? $list: "";
}













echo $tableHTML;
?>