<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Import Data";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
<?php 
		echo get_ajax_constructor(TRUE);
	?> 

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ui.css">
<script src="<?php echo base_url();?>assets/js/jquery-1.9.1.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>

<script>
var defaultDate = $( ".datepicker" ).datepicker( "option", "defaultDate" );
var dateFormat = $( ".datepicker" ).datepicker( "option", "dateFormat" );
var changeYear = $( ".datepicker" ).datepicker( "option", "changeYear" );

$(function() {
	$( ".datepicker" ).datepicker({ 
		 defaultDate: +0,
		 dateFormat: "mm/dd/yy",
		 changeYear: true  
	});
});
</script>
	
    
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  #WARNING: All HTML should be on one line or the string properly broken to avoid 
  #upsetting its display javascript
  $defaultHtml = "<table border='0' cellspacing='0' cellpadding='15' class='submenu'>".
  "<tr>".
  
  "<td class='activemenu' nowrap><a href='javascript:void(0);'>Intuit Data</a></td>".
  
  "<td class='inactivemenu' nowrap><a href='javascript:void(0);'>Yodlee Data</a></td>".
  
  "<td class='activemenu' style='width:48px; padding:0px;' nowrap><a href='javascript:void(0);' onclick='showSubMenu()'><img src='".base_url()."assets/images/front_arrow_grey.png' border='0'></a></td>".
  "</tr>".
  
  "</table>";
  
  $this->load->view('web/addons/header_admin', array('main'=>'transactions', 'sub'=>'', 'defaultHtml'=>$defaultHtml));?>
  
  
  <tr>
    <td style="padding:20px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" valign="top"><table border="0" cellspacing="0" cellpadding="8" class="bodytable">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class='largefont' nowrap>Set  Scope of Import</td>
                <td align="right" nowrap><a href="javascript:void(0);">Help</a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><select name="datatype" type="text" class="textfield" id="datatype" style="width:318px;">
            <option value="" selected> - Select Data Type - </option>
            <option value="institutions">Institutions</option>
            <option value="customer_accounts">Customer Accounts</option>
            <option value="cash_transactions">Cash Transactions</option>
            <option value="loan_transactions">Loan Transactions</option>
            <option value="investment_transactions">Investment Transactions</option>
            </select></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><input name="startdate" type="text" class="datepicker calendartextfield" id="startdate" size="35" placeholder="Start at Date"></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><input name="enddate" type="text" class="datepicker calendartextfield" id="enddate" size="35" value="" placeholder="End at Date"></td>
          </tr>
          
          <tr>
            <td style="padding-top:0px;"><input name="searchuser" type="text" class="searchtextfield" id="searchuser" size="35" placeholder="Specify User (optional)"></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div style="display:block;"><div id="job_results">&nbsp;</div></div></td>
                <td align="right"><input type="button" name="startimport" id="startimport" value="import data.." class="otherbtn"  onclick="getFieldsForUpdateFieldLayer('<?php echo base_url()."web/transactions/import_data";?>','fieldscontainer', '','import_results','All fields are required except where indicated.')" style='width:140px;'><input name="fieldscontainer" id="fieldscontainer" type="hidden" value="datatype"></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td style="padding-left:20px;" valign="top"><table border="0" cellspacing="0" cellpadding="8" width="100%" class="bodytable">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" nowrap class='largefont'>Data Mining Tags</td>
                
                <td width="1%" align="right" nowrap><input name="searchcodes" type="text" class="searchfield" id="searchcodes" value='' placeholder="search by name.." size="30">
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
                  
                </tr>
         </table></td>
  </tr>
  <tr>
    <td><div id='search_tags_div' style='max-height:187px; overflow:auto;'>
              <table width="100%" border="0" cellspacing="0" cellpadding="5" class='listtable'>
                <tr>
                <td style="width:20px;" valign="top"><input type="checkbox" name="searchtag0" id="searchtag0"></td>
                  <td valign="top" style="width:200px">transactions_above_100_dollars</td>
                  <td valign="top">Gets transactions whose amount is above $500</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag1" id="searchtag1"></td>
                  <td valign="top" style="width:200px;">transactions_with_fraud_flag</td>
                  <td valign="top">Transactions that may be fraudlent.</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag2" id="searchtag2"></td>
                  <td valign="top" style="width:200px;">complete_trasactions</td>
                  <td valign="top">Transactions whose status is COMPLETE</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">pending_transactions</td>
                  <td valign="top">Transactions whose status is not complete</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">could_not_import</td>
                  <td valign="top">Transactions whose format does not fit expected format for importing into the Clout database</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">advert_related</td>
                  <td valign="top">Transactions that were originated from an advertisement.</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">transactions_more_than_1_month_old</td>
                  <td valign="top">Transactions which were initiated more than 30 days ago.</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">transactions_more_than_1_month_old</td>
                  <td valign="top">Transactions which were initiated more than 30 days ago.</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">transactions_more_than_1_month_old</td>
                  <td valign="top">Transactions which were initiated more than 30 days ago.</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top" style="width:200px;">transactions_more_than_1_month_old</td>
                  <td valign="top">Transactions which were initiated more than 30 days ago.</td>
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
    <td style="padding:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="8" class="bodytable">
      <tr>
        <td style="padding-bottom:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class='largefont' nowrap>Import Data</td>
   
    
    <td width="1%" style="padding-left:70px; padding-right:0px;" align="right"><table><tr>
    <td><div id="merge_result"></div></td>
    <td><input type="button" name="startimport" id="startimport" value="..merge data" class="otherbtn"  onclick="updateFieldLayer('<?php echo base_url()."web/transactions/import_institution_data";?>','datatype', '','merge_result','All fields are required except where indicated.')" style='width:140px;'></td><td style="padding-left:30px;"><input name="searchsettings" type="text" class="searchfield" id="searchsettings" value='' placeholder="search imported data.." size="30"></td></tr></table></td>
  </tr>
</table>
</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div id="import_results"><?php echo format_notice('WARNING: There is no imported data.'); ?></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table></td>
      </tr>
      
    </table></td>
  </tr>
</table>


</body>
</html>