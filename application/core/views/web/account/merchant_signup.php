<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");

#Instantiate required fields variable if not given
$requiredFields = empty($requiredFields)? array(): $requiredFields;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Merchant Signup";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
<script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

 <?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";
 
 echo get_ajax_constructor(TRUE);
 ?>  
 
<script>
$(function() {
 	//Remove a div if clicked
	//Bind to element even if loaded later
	$(document).on('click', '.listdivs', function(){ 
		var listId = $(this).attr('id');
		//First remove its value from the list of selected values
		updateFieldLayer('<?php echo base_url();?>web/account/add_merchant_category/a/remove/c/'+listId,'','','added_category_list','');
		
		//Now remove the div
		$(this).remove();
	});
});

</script>
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="10" style="border-bottom: 2px #B3B3B3 solid;">
      <tr>
        <td><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo_black.png" border="0"></a></td>
        <td>&nbsp;</td>
        <td align="right"><input name="layerid" id="layerid" type="hidden" value=""><?php 
		if($this->native_session->get('userId'))
		{
			echo "<a href='".base_url()."web/account/normal_dashboard' class='whiteheadertitle'>Dashboard</a>";
		}
		?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="padding-top:20px; padding-bottom: 30px; text-align:center;">
    <form action="<?php echo base_url()."web/account/merchant_signup".(!empty($t)? '/t/'.$t: '');?>" method="post">
    <table border="0" cellspacing="0" cellpadding="10" align="center">
      <tr>
        <td class="contentheading bottomborder" style="padding-bottom:15px;text-align:left;">Business Details</td>
        </tr>


<?php
if($this->native_session->get('has_submitted_account'))
{
	$this->load->view('web/addons/basic_addons', array('area'=>'merchant_application_sub_menu', 'merchant'=>$applicationStatus));
}


	if(!empty($msg))
	{
		echo "<tr><td style='padding-top:10px;padding-bottom:0px;'>".format_notice($msg)."</td></tr>";
	}
	?>
    <tr>
        <td class="pagesubtitle" style="padding-bottom:10px;padding-top:10px;text-align:left;"><?php echo get_required_field_wrap($requiredFields, 'howdoyousell');?>How do you sell your products / services?<?php echo get_required_field_wrap($requiredFields, 'howdoyousell', 'end');?></td>
    </tr>
        
    <tr>
        <td>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-right:10px;" valign="bottom"><table border="0" cellspacing="0" cellpadding="10" class="tableborder" width="170">
    <tr><td style="height:55px;"><img src="<?php echo base_url();?>assets/images/map_marker_medium.png"></td></tr>
    <tr><td style="padding-top:0px;">At your in-store location</td></tr>
    <tr><td><input id="instore" name="howdoyousell[]" type="checkbox" value="instore" class="bigcheckbox" onClick="showHideOnChecked('instore_details', 'instore')" <?php echo (!empty($formData['howdoyousell']) && in_array('instore',$formData['howdoyousell'])? ' checked': '');?>><label for="instore"></label></td></tr>
    </table></td>
    <td style="padding-right:10px;"><table border="0" cellspacing="0" cellpadding="10" class="tableborder" width="170">
      <tr>
        <td style="height:55px;"><img src="<?php echo base_url();?>assets/images/online_icon.png"></td>
      </tr>
      <tr>
        <td style="padding-top:0px;">On your e-commerce website</td>
      </tr>
      <tr>
        <td><input id="ecommerce" name="howdoyousell[]" type="checkbox" value="ecommerce" class="bigcheckbox" onClick="showHideOnChecked('ecommerce_details', 'ecommerce')" <?php echo (!empty($formData['howdoyousell']) && in_array('ecommerce',$formData['howdoyousell'])? ' checked': '');?>><label for="ecommerce"></label></td>
      </tr>
    </table></td>
    <td style="padding-right:10px;"><table border="0" cellspacing="0" cellpadding="10" class="tableborder" width="170">
      <tr>
        <td style="height:55px;"><img src="<?php echo base_url();?>assets/images/world_icon_purple.png"></td>
      </tr>
      <tr>
        <td style="padding-top:0px;">Through online or local distributors</td>
      </tr>
      <tr>
        <td><input id="distributors" name="howdoyousell[]" type="checkbox" value="distributors" class="bigcheckbox" onClick="showHideOnChecked('distributors_details', 'distributors')" <?php echo (!empty($formData['howdoyousell']) && in_array('distributors',$formData['howdoyousell'])? ' checked': '');?>><label for="distributors"></label></td>
      </tr>
    </table></td>
    <td><table border="0" cellspacing="0" cellpadding="10" class="tableborder" width="170">
      <tr>
        <td style="height:55px;"><img src="<?php echo base_url();?>assets/images/service_icon.png"></td>
      </tr>
      <tr>
        <td style="padding-top:0px;">Other methods (e.g. in-person, etc)</td>
      </tr>
      <tr>
        <td><input id="othermethods" name="howdoyousell[]" type="checkbox" value="othermethods" class="bigcheckbox" onClick="showHideOnChecked('othermethods_details', 'othermethods')" <?php echo (!empty($formData['howdoyousell']) && in_array('othermethods',$formData['howdoyousell'])? ' checked': '');?>><label for="othermethods"></label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><div id="instore_details" style="display: <?php echo (!empty($formData['howdoyousell']) && in_array('instore',$formData['howdoyousell'])? 'block': 'none');?>;">
    <table border="0" cellspacing="0" cellpadding="10" class="tableborder" width="170" style="border-top:0px;">
      <tr>
        <td style="padding-bottom:0px;">How many stores?</td>
      </tr>
      <tr>
        <td><input name="instore_howmany" type="text" class="textfield" id="instore_howmany" size="20" style="width:110px;" value="<?php echo ((!empty($formData['instore_howmany']) || (isset($formData) && $formData['instore_howmany']=='0'))? $formData['instore_howmany']: '1');?>"></td>
      </tr>
      <tr>
        <td style="padding-bottom:0px;">Percent of sales?</td>
      </tr>
      <tr>
        <td><input name="instore_percentofsales" type="text" class="textfield" id="instore_percentofsales" size="20" style="width:95px;" value="<?php echo ((!empty($formData['instore_percentofsales']) || (isset($formData) && $formData['instore_percentofsales']=='0'))? $formData['instore_percentofsales']: '100');?>">%</td>
      </tr>
    </table>
    </div></td>
    
    <td valign="top"><div id="ecommerce_details" style="display:<?php echo (!empty($formData['howdoyousell']) && in_array('ecommerce',$formData['howdoyousell'])? 'block': 'none');?>;">
    <table border="0" cellspacing="0" cellpadding="10" class="tableborder" width="170" style="border-top:0px;">
      <tr>
        <td style="padding-bottom:0px;">Percent of sales?</td>
      </tr>
      <tr>
        <td><input name="ecommerce_percentofsales" type="text" class="textfield" id="ecommerce_percentofsales" size="20" style="width:95px;" value="<?php echo ((!empty($formData['ecommerce_percentofsales']) || (isset($formData) && $formData['ecommerce_percentofsales']=='0'))? $formData['ecommerce_percentofsales']: '0');?>">%</td>
      </tr>
    </table>
    </div></td>
    <td valign="top"><div id="distributors_details" style="display:<?php echo (!empty($formData['howdoyousell']) && in_array('distributors',$formData['howdoyousell'])? 'block': 'none');?>;">
    <table border="0" cellspacing="0" cellpadding="10" class="tableborder" width="170" style="border-top:0px;">
      <tr>
        <td style="padding-bottom:0px;">Percent of sales?</td>
      </tr>
      <tr>
        <td><input name="distributors_percentofsales" type="text" class="textfield" id="distributors_percentofsales" size="20" style="width:95px;" value="<?php echo ((!empty($formData['distributors_percentofsales']) || (isset($formData) && $formData['distributors_percentofsales']=='0'))? $formData['distributors_percentofsales']: '0');?>">%</td>
      </tr>
    </table>
    </div></td>
    
    <td valign="top"><div id="othermethods_details" style="display:<?php echo (!empty($formData['howdoyousell']) && in_array('othermethods',$formData['howdoyousell'])? 'block': 'none');?>;">
    <table border="0" cellspacing="0" cellpadding="10" class="tableborder" width="170" style="border-top:0px;">
      <tr>
        <td style="padding-bottom:0px;">Percent of sales?</td>
      </tr>
      <tr>
        <td><input name="othermethods_percentofsales" type="text" class="textfield" id="othermethods_percentofsales" size="20" style="width:95px;" value="<?php echo ((!empty($formData['othermethods_percentofsales']) || (isset($formData) && $formData['othermethods_percentofsales']=='0'))? $formData['othermethods_percentofsales']: '0');?>">%</td>
      </tr>
    </table>
    </div></td>
  </tr>
</table></td>
        </tr>
      <tr>
        <td><div id="business_details">
          <table width="100%" border="0" cellspacing="0" cellpadding="5" class="topborder">
            <tr><td class="pagesubtitle" style="padding-bottom:10px;padding-top:10px;text-align:left;"><?php echo get_required_field_wrap($requiredFields, 'typeofbusiness');?>What type of business?<?php echo get_required_field_wrap($requiredFields, 'typeofbusiness', 'end');?></td></tr>
            <tr>
              <td><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><div id="add_category_div"><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  <td><div class='searchselect'><input type="text" id="businesscategory" name="businesscategory" placeholder="Category" data-rel="business_category" style="width:285px" onClick="updateFieldValue('businesssubcategory', '')"><input name="businesscategory__searchby" id="businesscategory__searchby" type="hidden" value="category_name"></div></td>
                  <td style="padding-left:20px;"><div id="businesscategory__sublayer" style="display:none;"><table width="100" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class='searchselect'><input type="text" id="businesssubcategory" name="businesssubcategory" data-rel="business_subcategory" placeholder="Sub-Category" style="width:285px"><input name="businesssubcategory__extrafields" id="businesssubcategory__extrafields" type="hidden" value="businesscategory"><input name="businesssubcategory__searchby" id="businesssubcategory__searchby" type="hidden" value="S.subcategory"></div></td>
    <td style="padding-left:20px;"><input type="hidden" id="businesssubcategory__id" name="businesssubcategory__id" value=""><input id="addsubcategory" name="addsubcategory" type="button" class="bluebtn" style="width:50px;" onClick="updateFieldLayer('<?php echo base_url().'web/account/add_merchant_category';?>','businesscategory<>businesssubcategory<>*businesssubcategory__id','','added_category_list','All category fields are required.');updateFieldValue('businesscategory<>businesssubcategory<>businesssubcategory__id', '<><>');hideLayerSet('add_category_div')" value="Add"></td>
  </tr>
</table>
</div></td>
                  </tr>
                  </table></div></td>
                </tr>
                <tr>
                  <td style="text-align:left; padding-top:10px;padding-bottom:10px;">
                  <div id="added_category_list" style="padding-top:5px;padding-bottom:15px;max-width:700px;"><?php
$categories = $this->native_session->get('new_business_category')? $this->native_session->get('new_business_category'): array();
$categories = array_reverse($categories, TRUE);


#Put the surrounding div only if their are previously entered categories
echo (!empty($categories)? "<div class='tableborder' style='text-align:left;padding:5px 8px 5px 8px;'>": '');

foreach($categories AS $id=>$row)
{
	echo "<div id='".$id."' class='listdivs'>".$row['category']." (".$row['subcategory'].")<input type='hidden' id='categories_".$id."' name='categories[]' value='".$row['category']."<>".$row['subcategory']."<>".$row['subcategoryid']."'></div>";
}
echo (!empty($categories)? "</div>": '');				  
?></div>
                  
<span class="mediumgreytext">Clout uses this information to provide you with the right products and features to help grow your business.</span></td>
                </tr>
                <tr>
                  <td class="topborder" style="padding-bottom:20px;text-align:left;">
                  <table border="0" cellspacing="0" cellpadding="5">
            		<tr>
            		  <td colspan="4"  style="padding-bottom:10px;padding-top:20px;text-align:left;padding-left:0px;"><span class="pagesubtitle">Business Information</span><div id="business_claim_notice" style="display:<?php echo !empty($formData['businessnameclaimid'])? 'block': 'none';?>;"><?php echo format_notice('You wil be recorded as one of the claimants of this business until after verification before it can <BR>be assigned to you. <BR><BR>In the meantime, please complete this signup process and provide as much information as you <BR>can to prove that you are the rightful owner.');?></div></td></tr>
                  	
                    <tr><td colspan='2' style="padding-left:0px;"><?php echo get_required_field_wrap($requiredFields, 'businessname');?><div class='searchselect'><input type="text" id="businessname" name="businessname" placeholder="Business Name" data-rel="business_name" class="plainfield" style="width:285px" onClick="hideLayerSet('business_claim_notice')" value="<?php echo (!empty($formData['businessname'])? $formData['businessname']: '');?>"><input name="businessname__searchby" id="businessname__searchby" type="hidden" value="name"><input name="businessnameclaimid" id="businessnameclaimid" type="hidden" value="<?php echo (!empty($formData['businessnameclaimid'])? $formData['businessnameclaimid']: '');?>"></div><?php echo get_required_field_wrap($requiredFields, 'businessname', 'end');?>
                    </td>
                    <td colspan="2"><input type="text" id="businesswebsite" name="businesswebsite" placeholder="Website" class="textfield" style="width:350px" value="<?php echo (!empty($formData['businesswebsite'])? $formData['businesswebsite']: '');?>"></td></tr>
                    
                    <tr><td colspan='2' style="padding-left:0px;"><?php echo get_required_field_wrap($requiredFields, 'addressline1');?><input type="text" id="addressline1" name="addressline1" placeholder="Address" class="textfield" style="width:290px" value="<?php echo (!empty($formData['addressline1'])? $formData['addressline1']: '');?>"><?php echo get_required_field_wrap($requiredFields, 'addressline1', 'end');?></td>
                    <td colspan="2"><?php echo get_required_field_wrap($requiredFields, 'city');?><div class='searchselect'><input type="text" id="city" name="city" placeholder="City" class="plainfield" data-rel="city_name" style="width:340px" value="<?php echo (!empty($formData['city'])? $formData['city']: '');?>"><input name="city__searchby" id="city__searchby" type="hidden" value="name"><input name="city__extrafields" id="city__extrafields" type="hidden" value="*countrycode"></div><?php echo get_required_field_wrap($requiredFields, 'city', 'end');?></td></tr>
                    
                    <tr><td style="padding-left:0px;"><?php echo get_required_field_wrap($requiredFields, 'zipcode');?><input type="text" id="zipcode" name="zipcode" placeholder="Zip Code" class="textfield" style="width:120px" value="<?php echo (!empty($formData['zipcode'])? $formData['zipcode']: '');?>"><?php echo get_required_field_wrap($requiredFields, 'zipcode', 'end');?></td>
                    
                    <td><?php echo get_required_field_wrap($requiredFields, 'state');?><div class='searchselect'><input type="text" id="state" name="state" data-rel="state_name" placeholder="State" class="nosearch noenter" style="width:140px" value="<?php echo (!empty($formData['state'])? $formData['state']: '');?>"><input name="state__searchby" id="state__searchby" type="hidden" value="state_code__state_name"><input name="statecode" id="statecode" type="hidden" value="<?php echo (!empty($formData['statecode'])? $formData['statecode']: '');?>"></div><?php echo get_required_field_wrap($requiredFields, 'state', 'end');?></td>
                    
                    <td colspan="2"><?php echo get_required_field_wrap($requiredFields, 'country');?><div class='searchselect'><input type="text" id="country" name="country" data-rel="country_name" placeholder="Country" value="<?php echo (!empty($formData['country'])? $formData['country']: '');?>" style="width:340px"><input name="country__searchby" id="country__searchby" type="hidden" value="name"><input name="countrycode" id="countrycode" type="hidden" value="<?php echo (!empty($formData['countrycode'])? $formData['countrycode']: '');?>"></div><?php echo get_required_field_wrap($requiredFields, 'country', 'end');?></td></tr>
                    
                    <tr><td colspan='2' style="padding-left:0px;"><?php echo get_required_field_wrap($requiredFields, 'telephone');?><input type="text" id="telephone" name="telephone" placeholder="Phone" class="textfield" style="width:292px" value="<?php echo (!empty($formData['telephone'])? $formData['telephone']: '');?>"><?php echo get_required_field_wrap($requiredFields, 'telephone', 'end');?></td>
                    <td colspan="2"><?php echo get_required_field_wrap($requiredFields, 'emailaddress');?><input type="text" id="emailaddress" name="emailaddress" placeholder="Email" class="textfield" style="width:350px" value="<?php echo (!empty($formData['emailaddress'])? $formData['emailaddress']: '');?>"><?php echo get_required_field_wrap($requiredFields, 'emailaddress', 'end');?></td></tr>
                    
                    <tr><td colspan='2' style="padding-left:0px;"><?php echo get_required_field_wrap($requiredFields, 'employeeno');?><input type="text" id="employeeno" name="employeeno" placeholder="How many employees" class="textfield" style="width:292px" value="<?php echo (!empty($formData['employeeno'])? $formData['employeeno']: '');?>"><?php echo get_required_field_wrap($requiredFields, 'employeeno', 'end');?></td>
                    <td><?php echo get_required_field_wrap($requiredFields, 'annualrevenue');?>$ <div class='searchselect'><input type="text" id="annualrevenue" name="annualrevenue" value="<?php echo (!empty($formData['annualrevenue'])? $formData['annualrevenue']: '');?>" placeholder="Est. Annual Revenue" data-rel="annual_revenue" class="nosearch" style="width:190px"><input name="annualrevenue__searchby" id="annualrevenue__searchby" type="hidden" value="revenue_level"></div><?php echo get_required_field_wrap($requiredFields, 'annualrevenue', 'end');?></td>
                    <td><?php echo get_required_field_wrap($requiredFields, 'pricerange');?><div class='searchselect'><input type="text" id="pricerange" name="pricerange" value="<?php echo (!empty($formData['pricerange'])? $formData['pricerange']: '');?>" placeholder="Price Range" data-rel="price_range" class="nosearch" style="width:120px"><input name="pricerange__searchby" id="pricerange__searchby" type="hidden" value="price_range"></div><?php echo get_required_field_wrap($requiredFields, 'pricerange', 'end');?></td>
                    </tr>
                    
                  </table>
                  
                  </td>
                  </tr>
                  
                  
                  
                  <tr>
                  <td class="topborder" style="padding-bottom:30px; text-align:left;">
                  <table border="0" cellspacing="0" cellpadding="5">
            		<tr>
            		  <td colspan="3" class="pagesubtitle" style="padding-bottom:10px;padding-top:20px;text-align:left;padding-left:0px;">Primary Contact</td></tr>
                    <tr><td colspan='2' style="padding-left:0px;"><?php echo get_required_field_wrap($requiredFields, 'contactname');?><input type="text" id="contactname" name="contactname" placeholder="Full Name" class="textfield" style="width:290px" value="<?php echo (!empty($formData['contactname'])? $formData['contactname']: '');?>"><?php echo get_required_field_wrap($requiredFields, 'contactname', 'end');?></td><td><?php echo get_required_field_wrap($requiredFields, 'contacttitle');?><input type="text" id="contacttitle" name="contacttitle" placeholder="Title" class="textfield" style="width:350px" value="<?php echo (!empty($formData['contacttitle'])? $formData['contacttitle']: '');?>"><?php echo get_required_field_wrap($requiredFields, 'contacttitle', 'end');?></td></tr>
                    <tr><td colspan='2' style="padding-left:0px;"><?php echo get_required_field_wrap($requiredFields, 'contacttelephone');?><input type="text" id="contacttelephone" name="contacttelephone" placeholder="Phone" class="textfield" style="width:290px" value="<?php echo (!empty($formData['contacttelephone'])? $formData['contacttelephone']: '');?>"><?php echo get_required_field_wrap($requiredFields, 'contacttelephone', 'end');?></td><td><?php echo get_required_field_wrap($requiredFields, 'contactemailaddress');?><input type="text" id="contactemailaddress" name="contactemailaddress" placeholder="Email" class="textfield" value="<?php echo (!empty($formData['contactemailaddress'])? $formData['contactemailaddress']: '');?>" style="width:350px"><?php echo get_required_field_wrap($requiredFields, 'contactemailaddress', 'end');?></td></tr>
                  </table>
                  
<span class="mediumgreytext">Use a business email that corresponds with your business website to speed up the verification process.</span>
                  </td>
                  </tr>
                  
                  
                  <tr>
                  <td class="topborder">
                  <table border="0" cellspacing="0" cellpadding="5">
            	
                    <tr><td style="padding-left:0px; padding-top:15px;text-align:left;"><span class="mediumgreytext">By clicking submit, you agree to the <a href="javascript:;" class="bluelink">terms &amp; conditions</a> and <a href="javascript:;" class="bluelink">privacy policy</a>.</span></td><td style="padding-top:15px;"><input id="gotostep2" name="gotostep2" type="submit" class="greenbtn" value="Submit"></td></tr>
                  </table>
                  </td>
                  </tr>
                  
                  
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;<input type="hidden" name="layerid" id="layerid"></td>
            </tr>
          </table>
        
        
        
        
        </div></td>
        </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>