<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Cron Jobs";?></title>
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
  "<td class='activemenu' nowrap><a href='javascript:void(0);'>Cron Log</a></td>".
  "<td class='inactivemenu' nowrap><a href='javascript:void(0);'>Cron Settings</a></td>".
  "<td class='activemenu' style='width:48px; padding:0px;' nowrap><a href='javascript:void(0);' onclick='showSubMenu()'><img src='".base_url()."assets/images/front_arrow_grey.png' border='0'></a></td>".
  "</tr>".
  "</table>";
  
  $this->load->view('web/addons/header_admin', array('main'=>'settings', 'sub'=>'', 'defaultHtml'=>$defaultHtml));?>
  
  
  <tr>
    <td style="padding:20px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" valign="top"><table border="0" cellspacing="0" cellpadding="8" class="bodytable">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class='largefont' nowrap>Cron Jobs</td>
                <td align="right" nowrap><a href="javascript:void(0);">Help</a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><select name="jobtype" type="text" class="textfield" id="jobtype" style="width:318px;">
            <option value="" selected> - Select Job Type - </option>
            <option value="clout_score_job">Clout Score Job</option>
            <option value="store_score_job">Store Score Job</option>
            <option value="merchant_score_job">Merchant Score Job</option>
            <option value="data_clean_up">Data Clean Up</option>
            <option value="backup_data">Backup Data</option>
            </select></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><input name="startuser" type="text" class="textfield" id="startuser" size="35" placeholder="Start at User ID"></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><input name="enduser" type="text" class="textfield" id="enduser" size="35" placeholder="End at User ID"></td>
          </tr>
          
          <tr>
            <td style="padding-top:0px;"><input name="storeid" type="text" class="textfield" id="storeid" size="35" placeholder="Store ID (optional)"></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div style="display:block;"><div id="job_results">&nbsp;</div></div></td>
                <td align="right"><input type="button" name="runjob" id="runjob" value="run job" class="otherbtn"  onclick="updateFieldLayer('<?php echo base_url();?>cron/score_manager/run_user_score_cache_update','startuser<>enduser<>jobtype<>*storeid','','job_results','All fields are required except where indicated')" style='width:90px;'></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td style="padding-left:20px;" valign="top"><table border="0" cellspacing="0" cellpadding="8" width="100%" class="bodytable">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" nowrap class='largefont'>Cron Codes</td>
                
                <td width="1%" align="right" nowrap><input name="searchcodes" type="text" class="searchfield" id="searchcodes" value='' placeholder="search by code.." size="30">
               </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                <td style="width:20px;">&nbsp;</td>
                  <td style="width:200px;cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Name <img src="<?php echo base_url();?>assets/images/down_arrow_grey.png" border="0"/></a></td>
                  <td style="width:400px;"><a href="javascript:void(0);" class='activelink'>Description</a></td>
                  <td><a href="javascript:void(0);" class='activelink'>Frequency</a></td>
                </tr>
         </table></td>
  </tr>
  <tr>
    <td><div id='search_tags_div' style='max-height:187px; overflow:auto;'>
              <table width="100%" border="0" cellspacing="0" cellpadding="5" class='listtable'>
                <tr>
                <td style="width:20px;" valign="top"><input type="checkbox" name="searchtag0" id="searchtag0"></td>
                  <td valign="top" style="width:200px">update_clout_score_cache</td>
                  <td valign="top" style="width:400px;">Marks updates to the clout score cache</td>
                  <td valign="top">1215Hrs, Everyday</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag1" id="searchtag1"></td>
                  <td valign="top" style="width:200px;">import_data_from_intuit</td>
                  <td valign="top" style="width:400px;">Imports data from intuit.</td>
                  <td valign="top">1200Hrs, Everyday</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag2" id="searchtag2"></td>
                  <td valign="top" style="width:200px;">import_data_from_yodlee</td>
                  <td valign="top" style="width:400px;">Imports data from Yodlee.</td>
                  <td valign="top">1000Hrs, Monday, Tuesday, Wednesday</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">update_store_score_cache</td>
                  <td valign="top" style="width:400px;">Update Store Score Cache</td>
                  <td valign="top">1900Hrs, Saturday, Sunday</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">update_merchant_score_cache</td>
                  <td valign="top" style="width:400px;">Update Merchant Score Cache</td>
                  <td valign="top">1900Hrs, Saturday, Sunday</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">backup_whole_database</td>
                  <td valign="top" style="width:400px;">Take an image of the database for backup</td>
                  <td valign="top">1230Hrs, Sunday</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">update_store_score_cache</td>
                  <td valign="top" style="width:400px;">Update Store Score Cache</td>
                  <td valign="top">1900Hrs, Saturday, Sunday</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">update_store_score_cache</td>
                  <td valign="top" style="width:400px;">Update Store Score Cache</td>
                  <td valign="top">1900Hrs, Saturday, Sunday</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">update_store_score_cache</td>
                  <td valign="top" style="width:400px;">Update Store Score Cache</td>
                  <td valign="top">1900Hrs, Saturday, Sunday</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">update_store_score_cache</td>
                  <td valign="top" style="width:400px;">Update Store Score Cache</td>
                  <td valign="top">1900Hrs, Saturday, Sunday</td>
                </tr>
              </table>
            </div></td>
  </tr>
</table>
</td>
          </tr>
        </table></td>
        
        
      </tr>
    </table>
    
    </td>
  </tr>
  
  
  <tr>
    <td style="padding:20px; padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="8" class="bodytable">
      <tr>
        <td style="padding-bottom:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class='largefont' nowrap>Cron Log</td>
    <td width="1%"><input type="button" name="requestnewcronjob" id="requestnewcronjob" value="request new cron job" class="otherbtn" style='width:230px;'></td>
    
    <td width="1%" style="padding-left:70px; padding-right:0px;" align="right"><input name="searchlogs" type="text" class="searchfield" id="searchlogs" value='' placeholder="search.." size="30"></td>
  </tr>
</table>
</td>
      </tr>
      
      
      
      <tr>
        <td><div class="logscreen" style="background-color:#000; color:#FFF; min-height:350px; padding:3px;" id="job_log"><?php echo ">today is: ".date('Y-m-d');?></div></td>
      </tr>
      
    </table></td>
  </tr>
</table>


</body>
</html>