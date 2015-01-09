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
	<title><?php echo SITE_TITLE.": Merchant Signup - Additional Locations";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
<script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
    <script src="<?php echo base_url();?>assets/js/jquery.form.js"></script>
	<script src="<?php echo base_url();?>assets/js/fileform.js"></script>
    
 <?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";
 
 echo get_ajax_constructor(TRUE);
 ?>  

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
    
    <table border="0" cellspacing="0" cellpadding="10" align="center">
      <tr>
        <td class="contentheading bottomborder" style="padding-bottom:15px;text-align:left;">Additional Locations</td>
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
        <td class="pagesubtitle" style="padding-bottom:10px;padding-top:10px;text-align:left;">Please add your locations:</td>
    </tr>
        
    
      <tr>
        <td style="padding:5px;"><div id="business_details">
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
            
            <tr>
              <td><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td style="text-align:left;">
                    <table border="0" cellspacing="0" cellpadding="5">
                      
                      
                      <tr><td colspan='2' style="padding-left:0px;"><input type="text" id="storename" name="storename" placeholder="Store Name" class="textfield" style="width:260px">
                        </td>
                        <td><input type="text" id="storeid" name="storeid" placeholder="Store ID" class="textfield" style="width:260px"></td>
                        <td>&nbsp;</td>
                      </tr>
                      
                      <tr><td colspan='2' style="padding-left:0px;"><input type="text" id="addressline1" name="addressline1" placeholder="Address" class="textfield" style="width:260px"></td>
                        <td><div class='searchselect'><input type="text" id="city" name="city" placeholder="City" class="plainfield" data-rel="city_name" style="width:254px" value=""><input name="city__searchby" id="city__searchby" type="hidden" value="name"><input name="city__extrafields" id="city__extrafields" type="hidden" value="*countrycode"></div></td>
                        <td>&nbsp;</td>
                      </tr>
                      
                      <tr><td style="padding-left:0px;"><input type="text" id="zipcode" name="zipcode" placeholder="Zip Code" class="textfield" style="width:80px"></td>
                        <td><div class='searchselect'><input type="text" id="state" name="state" data-rel="state_name" placeholder="State" class="nosearch noenter" style="width:150px"><input name="state__searchby" id="state__searchby" type="hidden" value="state_code__state_name"><input name="statecode" id="statecode" type="hidden" value=""></div></td><td><div class='searchselect'><input type="text" id="country" name="country" data-rel="country_name" placeholder="Country" style="width:254px"><input name="country__searchby" id="country__searchby" type="hidden" value="name"><input name="countrycode" id="countrycode" type="hidden" value=""></div></td>
                        <td><input id="clearstorebtn" name="clearstorebtn" type="reset" class="greybtn" value="Clear" style="width:120px;"></td>
                      </tr>
                      
                      <tr><td colspan='2' style="padding-left:0px;"><input type="text" id="telephone" name="telephone" placeholder="Phone" class="textfield" style="width:260px"></td>
                        <td><input type="text" id="emailaddress" name="emailaddress" placeholder="Email" class="textfield" style="width:260px"></td>
                        <td><input id="savestorebtn" name="savestorebtn" type="button" class="bluebtn" value="Save" style="width:120px;" onClick="updateFieldLayer('<?php echo base_url().'web/account/add_store_locations/a/add_one';?>','storename<>*storeid<>addressline1<>city<>zipcode<>state<>statecode<>country<>countrycode<>telephone<>emailaddress','','saved_locations','The store name, address details and contacts are required.')"></td>
                      </tr>
                      
                      </table>
                    
                    </td>
                </tr>
                <tr>
        <td class="pagesubtitle bottomborder" style="padding-bottom:10px;padding-top:18px;text-align:left;">Or upload file:<br>
          <br>
          <table width="100" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><input id="downloadtemplate" name="downloadtemplate" type="button" class="bluebtn" value="Download Template" style="width:200px;" onClick="updateFieldLayer('<?php echo base_url().'web/documents/force_download/f/'.encrypt_value('documents').'/u/'.encrypt_value('store_location_template.csv');?>','','','_','');toggleStyles('downloadtemplate','greybtn','bluebtn');changeClass('locationsfile_btn','bluebtn')"></td>
              <td style="padding-left:20px;"><div id='locationsfile_div' class="uploadfield"><form class='layerform' action='<?php echo base_url()."web/account/load_locations_from_file/s/locationsfile/f/documents";?>' method='post' id='locationsfile__form' enctype='multipart/form-data'><input class='realuploadfield' type="file" id="locationsfile" name="locationsfile" size="5">
                    <input id="locationsfile_btn" name="locationsfile_btn" type="button" class="greybtn" value="Upload" style="width:200px;"><input type='hidden' id='locationsfile_displaylayer' name='locationsfile_displaylayer' value='saved_locations'></form></div></td>
            </tr>
          </table></td>
    </tr>
                <tr>
                  <td style="padding-bottom:20px;text-align:left;max-width:480px;"><div id="saved_locations">
				  
<?php
  	$locationList = $this->native_session->get('location_list')? $this->native_session->get('location_list'): array();
	if(!empty($locationList))
	{
		echo "<div style='display:block;position:relative;' id='delete_all_div'><table style='cursor:pointer;' onClick=\"updateFieldLayer('".base_url()."web/account/remove_location_address/l/all','','','saved_locations','');showLayerSet('locationsfile_div');\"><tr><td style='padding:5px;'><img src='".base_url()."/assets/images/remove_icon.png'></td><td><a href='javascript:;' class='bluebold'>Delete All</a></td></tr></table></div>";
		
		echo "<div id='location_msg_div'></div>
			<table width='100%' border='0' cellspacing='0' cellpadding='5' class='listtable'> ";
		$locationList = array_reverse($locationList, TRUE);
		$counter = 0;
		foreach($locationList AS $id=>$row)
		{
			echo "<tr id='location_".$id."'>
			<td width='1%' valign='top' onclick=\"updateFieldLayer('".base_url()."web/account/remove_location_address/l/".$id."','','','location_msg_div','');removeTableRow('location_".$id."')\" style='cursor:pointer;' nowrap><img src='".base_url()."/assets/images/remove_icon.png'></td>
			<td valign='top'>".html_entity_decode($row['storename'], ENT_QUOTES).(!empty($row['storeid'])? " (ID: ".$row['storeid'].")": "")."</td>
			<td valign='top'>".$row['addressline1']."</td>
			<td valign='top'>".$row['city']."</td>
			<td valign='top'>".$row['state']."</td>
			<td valign='top'>".$row['zipcode']."</td>
			<td valign='top'>".$row['country']."</td>
			<td valign='top'>".$row['telephone']."</td>
			<td valign='top'>".$row['emailaddress']."</td>
			</tr>";
			$counter++;
		}
		echo "</table>";
				  
	}
	echo "<input type='hidden' id='max_locations' name='max_locations' value='".($this->native_session->get('locations_count')? $this->native_session->get('locations_count'): 0)."'>
	<input type='hidden' id='locations_count' name='locations_count' value='".(!empty($counter)? $counter: 0)."'>";
	?></div></td>
                </tr>
                  
                  
                
                  
                  <tr>
                  <td>
                  <table border="0" cellspacing="0" cellpadding="5">
            	
                    <tr><td style="padding-left:0px; padding-top:15px;text-align:left;" width="98%">&nbsp;</td><td width="1%" style="white-space:nowrap;" valign="middle"><a href="<?php echo base_url(); ?>web/account/add_store_competitors/t/skip" class="bluelink">Skip This Step</a></td><td style="padding-top:10px;" width="1%"><input id="gotostep3" name="gotostep3" type="button" class="greenbtn" value="Submit All Locations" style="width:200px;" onClick="msgOnExceedCheck('max_locations', 'locations_count', '<?php echo base_url(); ?>web/account/add_store_competitors','', 'You have entered '+$('#locations_count').val()+' of the '+$('#max_locations').val()+' locations. Do you want to continue?\nOK to confirm. Cancel to stay on this page.')"></td></tr>
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
              <td>&nbsp;</td>
            </tr>
          </table>
        
        
        
        
        </div></td>
        </tr>
    </table>
    
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>