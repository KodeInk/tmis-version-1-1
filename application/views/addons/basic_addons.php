<?php 
$jquery = "<script src='".base_url()."assets/js/jquery-2.1.1.min.js' type='text/javascript'></script>";
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/tmis.js'></script>".get_AJAX_constructor(TRUE); 

$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/tmis.css' type='text/css' media='screen' />"; 

if(!empty($area) && $area == "show_bigger_image")
{
	$tableHTML .= "<table width='530' height='398' border='0' cellspacing='0' cellpadding='0'><tr><td><img src='".$url."' border='0' /></td></tr></table>"; 
}





else if(!empty($area) && $area == "basic_msg" && !empty($msg)) 
{
	$tableHTML .= format_notice($this, $msg);
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





else if(!empty($area) && $area == "education_form")
{
	$tableHTML .= "<table border='0' cellspacing='0' cellpadding='10' class='microform'>
  <tr>
    <td class='label' style='width:150px;'>Institution:</td>
    <td><div class='nextdiv'><input type='text' id='institutionname' name='institutionname' title='Insitution Name' class='textfield' value='".(!empty($details['institutionname'])? $details['institutionname']: '')."'/></div>
      <div class='nextdiv'><input type='text' id='institution__institutiontype' name='institution__institutiontype' class='textfield selectfield' value='".(!empty($details['institution__institutiontype'])? $details['institution__institutiontype']: '')."' placeholder='Insitution Type' /></div></td>
  </tr>
  <tr>
    <td class='label'>Period:</td>
    <td><div class='nextdiv'>
    <table border='0' cellspacing='0' cellpadding='0'>
    <tr><td class='value' style='padding-right:9px;'>From</td>
    <td><input type='text' id='from__month' name='from__month' placeholder='Month' class='textfield selectfield' style='width:100px;' value='".(!empty($details['from__month'])? $details['from__month']: date('F'))."'/></td>
    <td><input type='text' id='from__pastyear' name='from__pastyear' placeholder='Year' class='textfield selectfield' style='width:55px;' value='".(!empty($details['from__pastyear'])? $details['from__pastyear']: date('Y'))."'/></td>
    </tr>
    </table>
    </div>
    <div class='nextdiv'>
    <table border='0' cellspacing='0' cellpadding='0'>
    <tr><td class='value' style='padding-right:30px;'>To</td>
    <td><input type='text' id='to__month' name='to__month' placeholder='Month' class='textfield selectfield' style='width:100px;' value='".(!empty($details['to__month'])? $details['to__month']: date('F'))."'/></td>
    <td><input type='text' id='to__pastyear' name='to__pastyear' placeholder='Year' class='textfield selectfield' style='width:55px;' value='".(!empty($details['to__pastyear'])? $details['to__pastyear']: date('Y'))."'/></td>
    </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    <td class='label'>Certificate Obtained:</td>
    <td><div class='nextdiv'><input type='text' id='certificatename' name='certificatename' title='Certificate Name' class='textfield' value='".(!empty($details['certificatename'])? $details['certificatename']: '')."'/></div>
      <div class='nextdiv'><input type='checkbox' id='highestcertificate' name='highestcertificate' value='Y' ".(!empty($details['highestcertificate'])? 'checked': '')."/>
      <label for='highestcertificate'>This is my highest certificate.</label></div></td>
  </tr>
  <tr>
    <td class='label'>Certificate Number:</td>
    <td><input type='text' id='certificatenumber' name='certificatenumber' title='Certificate Number' class='textfield' value='".(!empty($details['certificatenumber'])? $details['certificatenumber']: '')."'/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><button type='button' name='saveeducation' id='saveeducation' class='greybtn'>ADD</button><input type='hidden' id='action' name='action' value='".base_url()."register/step_three/action/add_education' /><input type='hidden' id='resultsdiv' name='resultsdiv' value='institution_list' />".(!empty($details['item_id']) && !empty($type)? "<input type='hidden' name='".$type."_id' id='".$type."_id' value='".$details['item_id']."' />": "")."</td>
  </tr>
        </table>";
	
	
}








else if(!empty($area) && $area == "education_list")
{

	$tableHTML .= !empty($response['msg'])? format_notice($this, $response['msg']): "";
	
	if($this->native_session->get('education_list'))
	{
		$tableHTML .= "<table border='0' cellspacing='0' cellpadding='0' class='resultslisttable".(!empty($mode) && $mode=='preview'? " preview":" editable")."'>
			<tr><td colspan='3'>Education List</td></tr>";
			
		foreach($this->native_session->get('education_list') AS $row) 
		{
			$tableHTML .= "<tr id='".$row['education_id']."'><td class='edit'>&nbsp;</td>
			<td><div class='nextdiv'><span class='label'>".$row['institution__institutiontype'].": ".$row['institutionname']."</span><br>".$row['certificatename']."</div>
				<div class='nextdiv'>(".$row['from__month']." ".$row['from__pastyear']." - ".$row['to__month']." ".$row['to__pastyear'].")<br>Certificate # ".$row['certificatenumber']."</div>
				<div class='nextdiv'>".(!empty($row['highestcertificate']) && $row['highestcertificate'] == 'Y'? "-- highest --": "&nbsp;")."</div></td>
			<td class='delete'>&nbsp;</td>
			</tr>";
		}
		$tableHTML .= "</table>";
	}
}





else if(!empty($area) && $area == "subject_form")
{
	$tableHTML .= "<table border='0' cellspacing='0' cellpadding='10' class='microform'>
  <tr>
    <td class='label' style='width:150px;'>Subject Name:</td>
    <td><div class='nextdiv'><input type='text' id='subjectname' name='subjectname' title='Subject Name' class='textfield' value='".(!empty($details['subjectname'])? $details['subjectname']: '')."'/></div>
      <div class='nextdiv'><input type='text' id='subject__subjecttype' name='subject__subjecttype' class='textfield selectfield' value='".(!empty($details['subject__subjecttype'])? $details['subject__subjecttype']: '')."' placeholder='Subject Type' /></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><button type='button' name='saveeducation' id='saveeducation' class='greybtn'>ADD</button><input type='hidden' id='action' name='action' value='".base_url()."register/step_three/action/add_subject' /><input type='hidden' id='resultsdiv' name='resultsdiv' value='subject_list' />".(!empty($details['item_id']) && !empty($type)? "<input type='hidden' name='".$type."_id' id='".$type."_id' value='".$details['item_id']."' />": "")."</td>
  </tr>
  </table>";
}






else if(!empty($area) && $area == "subject_list")
{
	$tableHTML .= !empty($response['msg'])? format_notice($this, $response['msg']): "";
	
	if($this->native_session->get('subject_list'))
	{
		$tableHTML .= "<table border='0' cellspacing='0' cellpadding='0' class='resultslisttable".(!empty($mode) && $mode=='preview'? " preview":" editable")."'>
			<tr><td colspan='3'>Subject List</td></tr>";
			
		foreach($this->native_session->get('subject_list') AS $row) 
		{
			$tableHTML .= "<tr id='".$row['subject_id']."'><td class='edit'>&nbsp;</td>
			<td><div class='nextdiv'>".$row['subjectname']."</div>
				<div class='nextdiv'>".(!empty($row['subject__subjecttype']) && $row['subject__subjecttype'] != 'Other'? "-- ".strtolower($row['subject__subjecttype'])." --": "&nbsp;")."</div></td>
			<td class='delete'>&nbsp;</td>
			</tr>";
		}
		$tableHTML .= "</table>";
	}
}





else if(!empty($area) && in_array($area, array("verify_vacancy", "verify_user")))
{
	$tableHTML .= "<table border='0' cellspacing='0' cellpadding='5' width='100%' />
	<tr><td width='99%'><textarea id='reason_".$action."_".$id."' name='reason_".$action."_".$id."' class='yellowfield' style='width:100%' placeholder='Enter the reason you want to ".$list_type." this item. (Optional)'></textarea></td>
	<td width='1%'><input id='confirm_".$action."_".$id."' name='confirm_".$action."_".$id."' type='button' class='greybtn confirmlistbtn' style='width:125px;' value='CONFIRM' /><div style='padding-top:5px;'><input id='cancel_".$action."_".$id."' name='cancel_".$action."_".$id."' type='button' class='greybtn cancellistbtn' style='width:125px;' value='CANCEL' /><input type='hidden' id='hidden_".$action."_".$id."' name='hidden_".$action."_".$id."' value='".str_replace('verify_', '', $area)."' /></div></td></tr>
	</table>";
}









echo $tableHTML;
?>