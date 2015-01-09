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
	<title><?php echo SITE_TITLE.": Merchant Signup - Competitors";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
<script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
    <script src="<?php echo base_url();?>assets/js/jquery.form.js"></script>
	<script src="<?php echo base_url();?>assets/js/fileform.js"></script>
    
 <?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";
 
 echo get_ajax_constructor(TRUE);
 ?>  
 
 <style>
 .contentitemdiv {
	 margin-left: 0px;
	 margin-right: 0px;
 }
 

 </style>

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
        <td class="contentheading bottomborder" style="padding-bottom:15px;text-align:left;">Competitors</td>
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
        <td class="pagesubtitle" style="padding-bottom:10px;padding-top:10px;text-align:left;">Who are your top competitors?</td>
    </tr>
        
    
      <tr>
        <td style="padding:5px;"><div id="business_details">
          <table width="100%" border="0" cellspacing="0" cellpadding="5">
            
            <tr>
              <td><form action="<?php echo base_url(); ?>web/account/add_store_competitors" method="post">
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td style="text-align:left;">
                    <table border="0" cellspacing="0" cellpadding="5">
                      
                      
                      <tr><td style="padding-left:0px;"><div class='searchselect'><input type="text" id="storename" name="storename" placeholder="Store Name" class="plainfield" data-rel="competitor_name" style="width:500px" value=""><input name="storename__searchby" id="storename__searchby" type="hidden" value="name"></div></td>
                        <td><input id="addcompetitorbtn" name="addcompetitorbtn" type="button" class="bluebtn" value="Add" style="width:135px;"></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="padding-left:0px;"><span class="mediumgreytext">Please input a minimum of 5 competitors to enable us present your business better.</span></td>
                        </tr>
                      
                      </table>
                    
                    </td>
                </tr>
                
                
                
 <?php
 if(!empty($competitors))
 {
 ?>
                <tr>
        <td class="pagesubtitle bottomborder" style="padding-bottom:10px;padding-top:18px;text-align:left;">Or add suggested competitors:</td>
    </tr>
                <tr>
                  <td class="contentlistcell" style="padding-bottom:20px;text-align:left;min-width:430px;background-color:#FFF;">
                  <?php 
				  $counter = 0;
				  $maxColumnCount = 3; $listTotal = count($competitors);
				  $rowArray = array();
				  
				  foreach($competitors AS $competitor)
				  {
					  $rowArray[$counter%$maxColumnCount] = !empty($rowArray[$counter%$maxColumnCount])? $rowArray[$counter%$maxColumnCount]: array();
					  array_push($rowArray[$counter%$maxColumnCount], $competitor);
					  $counter++;
				  }
				  
				  foreach($rowArray AS $columnData)
				  {
					  echo "<div class='contentlistdiv' style='padding-left:0px;padding-right:0px;'>";
					  foreach($columnData AS $row)
					  {
						  echo "<div id='suggestion_".$row['id']."' class='contentitemdiv' onClick=\"addRowToCompetitorTable('competitor_list_table', '".$row['id']."', '".htmlentities(limit_string_length(addslashes(html_entity_decode($row['name'], ENT_QUOTES))." (".addslashes($row['address_line_1']), 32).") ", ENT_QUOTES)."');hideLayerSet('suggestion_".$row['id']."')\">".wordwrap(limit_string_length($row['name']." (".$row['address_line_1'].' '.$row['address_line_2'].' '.$row['city'].', '.$row['state'].' '.$row['zipcode'], 32), 20, "<BR>", true).")</div>"; 
					  }
					  echo "</div>";
				  }
				  
				  
				  ?>
              
              </td>
                </tr>
<?php
 }
 ?>
                
                
                <tr>
        <td><div id="competitor_list_table_heading" class="pagesubtitle topborder" style="padding-bottom:10px;padding-top:18px;text-align:left;display:none;">Tell us how their prices compare to your business:</div></td>
    </tr>
                <tr>
                  <td style="padding-bottom:20px;text-align:left;max-width:480px;"><div id="competitor_list">
                  <?php
				  echo "<table border='0' cellspacing='0' cellpadding='5' class='listtable bigcontenttext' id='competitor_list_table'>";
				  
				  if(!empty($currentCompetitors))
				  {	
				  		foreach($currentCompetitors AS $id=>$competitor)
				  		{
					  		echo "<tr id='row_".$competitor['competitor_id']."'><td class='lightergreybg' style='border-right:0px;cursor:pointer;' width='1%' onclick=\"removeTableRow('row_".$competitor['competitor_id']."')\"><img src='".base_url()."assets/images/remove_icon.png' border='0'></td>
                  <td width='92%' class='lightergreybg' style='font-weight:bold;'>".limit_string_length($competitor['competitor_name']." (".$competitor['address'], 32).") "
				  
				  
				  ."<input type='hidden' name='competitor_ids[]' id='competitor_".$competitor['competitor_id']."_id' value='".$competitor['competitor_id']."'></td>
                  <td width='1%' style='border-right:0px;padding-right:0px;'><input name='competitor_price_".$competitor['competitor_id']."' type='radio' value='1' ".(!empty($competitor['price_level']) && $competitor['price_level'] == '1'? ' checked': '')."></td>
                  <td width='1%' style='padding-right:35px;'>$</td>
                  <td width='1%' style='border-right:0px;padding-right:0px;'><input name='competitor_price_".$competitor['competitor_id']."' type='radio' value='2' ".(!empty($competitor['price_level']) && $competitor['price_level'] == '2'? ' checked': '')."></td>
                  <td width='1%' style='padding-right:35px;'>$$</td>
                  <td width='1%' style='border-right:0px;padding-right:0px;'><input name='competitor_price_".$competitor['competitor_id']."' type='radio' value='3' ".(!empty($competitor['price_level']) && $competitor['price_level'] == '3'? ' checked': '')."></td>
                  <td width='1%' style='padding-right:35px;'>$$$</td>
                  <td width='1%' style='border-right:0px;padding-right:0px;'><input name='competitor_price_".$competitor['competitor_id']."' type='radio' value='4' ".(!empty($competitor['price_level']) && $competitor['price_level'] == '4'? ' checked': '')."></td>
                  <td width='1%' style='padding-right:10px;'>$$$$</td>
                  </tr>";
				  		}
				  }
				  
				  echo "</table>";
				  ?>
                  
                  </div></td>
                </tr>
                  
                  <tr>
                  <td>
                  <table border="0" cellspacing="0" cellpadding="5">
            	
                    <tr><td style="padding-left:0px; padding-top:15px;text-align:left;" width="98%">&nbsp;</td><td width="1%" style="white-space:nowrap;" valign="middle"><a href="<?php echo base_url(); ?>web/account/add_store_competitors/t/<?php echo encrypt_value('skip_to_dashboard');?>" class="bluelink">Skip This Step</a></td><td style="padding-top:10px;" width="1%"><input id="gotodashboard" name="gotodashboard" type="submit" class="greenbtn" value="Submit" style="width:200px;"></td></tr>
                  </table>
                  </td>
                  </tr>
                  
                  
              </table>
              </form></td>
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