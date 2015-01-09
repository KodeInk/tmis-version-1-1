<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Score Settings";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
    <script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
	<?php 
		echo get_ajax_constructor(TRUE);
	?>
    
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  #WARNING: All HTML should be on one line or the string properly broken to avoid 
  #upsetting its display javascript
  $defaultHtml = "<table border='0' cellspacing='0' cellpadding='15' class='submenu'>".
  "<tr>".
  
  "<td class='".(($scoreType=='clout_score')? 'activemenu': 'inactivemenu')."' onclick=\\\"document.location.href='".base_url()."web/score/score_settings'\\\" nowrap><a href='javascript:void(0);'>Clout Score Settings</a></td>".
  
  "<td class='".(($scoreType=='store_score')? 'activemenu': 'inactivemenu')."' onclick=\\\"document.location.href='".base_url()."web/score/score_settings/t/".encrypt_value('store_score')."'\\\" nowrap><a href='javascript:void(0);'>Store Score Settings</a></td>".
  
  "<td class='".(($scoreType=='merchant_score')? 'activemenu': 'inactivemenu')."' onclick=\\\"document.location.href='".base_url()."web/score/score_settings/t/".encrypt_value('merchant_score')."'\\\" nowrap><a href='javascript:void(0);'>Merchant Score Settings</a></td>".
  
  "<td class='activemenu' style='width:48px; padding:0px;' nowrap><a href='javascript:void(0);' onclick='showSubMenu()'><img src='".base_url()."assets/images/front_arrow_grey.png' border='0'></a></td>".
  "</tr>".
  
  "</table>";
  
  $this->load->view('web/addons/header_admin', array('main'=>'settings', 'sub'=>'', 'defaultHtml'=>$defaultHtml));?>
  
  <tr>
    <td style="padding:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="8" class="bodytable">
      <tr>
        <td style="padding-bottom:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class='largefont' nowrap><?php echo ucwords(str_replace('_', ' ', $scoreType));?> Settings</td>
    <td width="1%"><input type="button" name="requestnewsetting" id="requestnewsetting" value="request new setting" class="otherbtn" style='width:200px;'></td>
    
    <td width="1%" style="padding-left:70px; padding-right:0px;" align="right"><input name="searchsettings" type="text" class="searchfield" id="searchsettings" value='' placeholder="search.." size="30"></td>
  </tr>
</table>
</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div id='search_list_div' style='overflow: auto; overflow-y: hidden; -ms-overflow-y: hidden;'>
              <table width="100%" border="0" cellspacing="0" cellpadding="5" class='listtable'>
                <thead>
                <tr>
                  <td width="1%" valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Parameter</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  <td width="1%" valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Criteria</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  
                  <td width="1%" valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Minimum Value</a> 
                  </td>
                  
                  
                  
                  <td width="1%" valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Maximum Value</a> 
                  </td>
                  
                  <td valign="bottom" style="cursor:pointer;">&nbsp;</td>
                  
                  
               </tr>
                </thead>
                
                
                
                
                
                <?php
				foreach($criteriaList AS $row)
				{
					echo "<tr>
                  <td nowrap>".$row['description']."</td>
					
              		<td nowrap>".strtoupper(str_replace('_', ' ', $row['criteria']))."</td>
					
              		<td><input type='text' name='min_".$row['code']."' id='min_".$row['code']."' class='textfield' style='width:50px;' value='".$row['low_range']."'   onKeyUp=\"updateFieldLayer('".base_url()."web/score/update_score_criteria/c/".encrypt_value($row['code'])."/f/".encrypt_value('low_range')."/p/".encrypt_value('min_')."','min_".$row['code']."','','low_div_".$row['code']."','')\"><div id='low_div_".$row['code']."'></div></td>
					
              		<td><input type='text' name='max_".$row['code']."' id='max_".$row['code']."' class='textfield' onKeyUp=\"updateFieldLayer('".base_url()."web/score/update_score_criteria/c/".encrypt_value($row['code'])."/f/".encrypt_value('high_range')."/p/".encrypt_value('max_')."','max_".$row['code']."','','high_div_".$row['code']."','')\" style='width:50px;' value='".$row['high_range']."'><div id='high_div_".$row['code']."'></div></td>
					
					<td>&nbsp;</td>
					</tr>";
				}
				
				?>
                
                
              </table>
            </div></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table></td>
      </tr>
      
    </table></td>
  </tr>
</table>


</body>
</html>