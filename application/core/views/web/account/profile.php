<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": My Profile";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
	

	<?php 
		echo get_ajax_constructor(TRUE);
	 
	    echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
 
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data1 = google.visualization.arrayToDataTable([
          ['Clout', 'Score'],
          ['',  700],
          ['',  200]
        ]);
		
		var data2 = google.visualization.arrayToDataTable([
          ['Clout', 'Score'],
          ['',  180],
          ['',  180],
		  ['',  180],
          ['',  180],
		  ['',  180]
        ]);

        var options1 = {
          pieHole: 0.7,
		  backgroundColor: 'transparent',
		  legend: 'none',
          pieSliceText: 'none',
          pieStartAngle: 180,
		  pieSliceBorderColor: '#F2F2F2',
          tooltip: { trigger: 'none' },
          slices: {
            0: { color: '#2DA0D1' },
            1: { color: '#E0E0E0' }
          },
		  chartArea: {left:0,top:0,width:"180",height:"180"}
        };
		
		var options2 = {
          pieHole: 0.7,
		  backgroundColor: 'transparent',
		  legend: 'none',
          pieSliceText: 'none',
          pieStartAngle: 180,
		  pieSliceBorderColor: '#F2F2F2',
          tooltip: { trigger: 'none' },
          slices: {
            0: { color: 'transparent' },
            1: { color: 'transparent' },
            2: { color: 'transparent' },
            3: { color: 'transparent' },
            4: { color: 'transparent' }
          },
		  chartArea: {left:0,top:0,width:"180",height:"180"}
        };

        var chart1 = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart1.draw(data1, options1);
		
		var chart2 = new google.visualization.PieChart(document.getElementById('donutchartskeleton'));
        chart2.draw(data2, options2);
		
      }
	  
</script>	
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view('web/addons/header_normal', array('main'=>'account', 'sub'=>'Home', 'defaultHtml'=>''));?>
  <tr>
    <td class="normalpageheader" id='submenu_content' style="padding-left:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="0%" style="padding:0px;"><div class="bigscreendetails topleftheader">Profile</div></td>
    <td width="2%" style="padding-bottom:15px; padding-left:0px;">&nbsp;</td>
    <td width="1%" style="padding-bottom:15px;">&nbsp;</td>
    <td width="80%" class="greytext" style="padding-bottom:15px; vertical-align:bottom; font-size:14px;">&nbsp;</td>
    <td class="whiteheadertitle" style="padding-bottom:0px; padding-right:20px;padding-left:20px;border-left: solid 1px #E0E0E0;" nowrap><span class="green">Total Network:</span> 199,248</td>
    <td class="whiteheadertitle" style="padding-bottom:0px; padding-right:15px; padding-left:20px; border-left: solid 1px #E0E0E0;" nowrap><span class="blue">Pending Invites:</span> 26,420</td>
    <td class="rightmenubg" style="height:100%;min-width:250px;"><table border="0" cellspacing="0" cellpadding="5" width="100%">
      <tr>
        <td style="color:#999999;" nowrap>Feed</td>
        <td style="width:20px; color:#999999;" nowrap><img src="<?php echo base_url();?>assets/images/settings_icon.png"/></td>
        </tr>
    </table>
    
    
    </td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="left" style="padding-left:0px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="top" class="leftmenuarea" width="1%" style="padding:15px 5px 15px 15px;"><span class='greysectionheader'>Spending is not the only way to raise your score.</span>
      <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">++</td>
    <td width="99%" nowrap><a href="javascript:;">Link a Card</a></td>
  </tr>
</table></div>
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">+45</td>
    <td width="99%" nowrap><a href="javascript:;">Complete Your Profile</a></td>
  </tr>
</table></div>
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">+25</td>
    <td width="99%" nowrap><a href="javascript:;">Connect a Social Network</a></td>
  </tr>
</table></div>
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">++</td>
    <td width="99%" nowrap><a href="javascript:;">Refer New Members</a></td>
  </tr>
</table></div>
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">++</td>
    <td width="99%" nowrap><a href="javascript:;">Your Referrals Spend</a></td>
  </tr>
</table></div>
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">+10</td>
    <td width="99%" nowrap><a href="javascript:;">Answer Merchant Surveys</a></td>
  </tr>
</table></div>
     
     
     
     <div class="leftmenuitem">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="scorecircle">++</td>
    <td width="99%" nowrap><a href="javascript:;">Shop at Clout Merchants</a></td>
  </tr>
</table></div>
     
     
     
     
     
     </td>
        <td valign="top" width="98%" class="pagecontentarea" style="padding-top:30px;"><table width="100%" border="0" cellspacing="0" cellpadding="15" style="background-color:#FFF;">
  
  
  <tr>
        <td class="pagetitle">Derick Manlapeg</td>
      </tr>
      <tr>
        <td class="pagesubtitle" style="padding-top:10px;">Member since: 04/23/2013<br>
          Referral URL: <span style="font-weight:bold;">https://www.clout.com/u/derick</span></td>
      </tr>
      <tr>
        <td valign="top" style="padding-top:0px;"><div class="contentdiv" style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greentop" style="width:580px;">
      <thead>
        <tr>
          <td>Account Settings
</td>
          </tr>
        </thead>
      
      <tr>
        <td style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="text-align:left;">
          <tr>
            <td valign="top" style="text-align:left;border-bottom:solid 1px #DDD;"><table border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td colspan="2"><span class="label">Current Photo:</span></td>
                </tr>
              <tr>
                <td><img src="<?php echo base_url();?>assets/uploads/derrick.jpg" border="0" style="width:100px; cursor:pointer;" class="imgborder"></td>
                <td valign="top" style="padding-left:10px;"><input type="button" name="updatephoto" id="updatephoto" class="greenbtn smallbtn"  style="width: 100px;" value="Update Photo"><br>
<span style="font-size:11px;">&bull; You can upload a JPG, JPEG, GIF or PNG. <br>
&bull; File size limit is 4MB.<br>
&bull; Recommended image size is 300px (width) x 300px (length).</span><br>
</td>
              </tr>
            </table></td>
            <td style="text-align:left;border-bottom:solid 1px #DDD;
	border-left:solid 1px #DDD;"><table border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td><span class="label">Your Email:</span></td>
              </tr>
              <tr>
                <td valign="top" style="padding-left:0px;"><table border="0" cellpadding="3" cellspacing="0">
                  <tr>
                    <td valign="top"><input name="emaillist" type="radio" id="email_1" value="email_1" checked="checked" /></td>
                    <td valign="top">derick@clout.com</td>
                    <td valign="top" style="font-weight:bold;font-size:11px;" nowrap>[Primary Email]</td>
                    </tr>
                  <tr>
                    <td valign="top"><input type="radio" name="emaillist" id="email_2" value="email_2" /></td>
                    <td valign="top">dmanlapeg@yahoo.com</td>
                    <td valign="top"><a href="javascript:;" class="bluebold">remove</a></td>
                    </tr>
                  <tr>
                    <td valign="top"><input type="radio" name="emaillist" id="email_3" value="email_3" /></td>
                    <td valign="top">d.manlap@gmail.com</td>
                    <td valign="top"><a href="javascript:;" class="bluebold">remove</a></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table border="0" cellpadding="3" cellspacing="0">
                  <tr>
                    <td><input name="newemail" type="text" class="smalltextfield" id="newemail" style="width:150px;" placeholder="Enter new email" value=''></td>
                    <td><input type="button" name="addemail" id="addemail" class="bluebtn smallbtn"  style="font-size: 12px; padding: 3px 7px 3px 7px; width:80px;" value="Add Email"></td>
                    </tr></table></td>
                </tr>
            </table></td>
          </tr>
          
          <tr>
            <td colspan="2" style="padding:0px;"><table width="100%" border="0" cellspacing="0"  cellpadding="10" class="sectiontable" style="border:0px;">
              <tr>
      <td style="padding:0px;text-align:left; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="10" style="cursor:pointer;" onClick="toggleLayer('user_info_div', '', '', '', '', '<a href=\'javascript:;\' class=\'bluebold\'>Close</a>', '<a href=\'javascript:;\' class=\'bluebold\'>Edit</a>', 'user_info_action')">
  <tr>
    <td width="99%"><span style="font-weight:bold;">User Information</span></td>
    <td width="1%" id="user_info_action"><a href="javascript:;" class="bluebold">Edit</a></td>
  </tr>
</table>

<div style="display:none;" id="user_info_div">
<table width="100%" border="0"  cellpadding="10" cellspacing="0" style="background-color:#F2F2F2;border-top:solid 1px #DDD;">
  <tr>
    <td colspan="2" width="99%"><span class="label">First Name:</span><br />
      <input name="firstname" type="text" class="smalltextfield" id="firstname" style="width:200px;"  value='Derick' /></td>
    <td><span class="label">Last Name:</span><br />
      <input name="lastname" type="text" class="smalltextfield" id="lastname" style="width:200px;"  value='Manlapeg' /></td>
  </tr>
  <tr>
    <td><span class="label">Main Phone:</span><br />
      <input name="mainphone" type="text" class="smalltextfield" id="mainphone" style="width:100px;"  value='714-261-7820' /></td>
    <td style="padding-left:0px;"><span class="label">Mobile Phone:</span><br />
      <input name="mobilephone" type="text" class="smalltextfield" id="mobilephone" style="width:100px;"  value='714-261-7820' /></td>
    <td><span class="label">Gender:</span><br />
      <select name="gender" id="gender" class="smallselect" style="width:215px;">
        <option value="">- Select Gender -</option>
        <option value="female">Female</option>
        <option value="male" selected="selected">Male</option>
      </select></td>
  </tr>
  <tr>
    <td colspan="2"><span class="label">Address:</span><br />
      <input name="address" type="text" class="smalltextfield" id="address" style="width:200px;"  value='40575 La Colima Rd' /></td>
    <td><span class="label">City:</span><br />
      <input name="city" type="text" class="smalltextfield" id="city" style="width:200px;"  value='Temecula' /></td>
  </tr>
  <tr>
    <td colspan="2"><span class="label">State:</span><br />
      <select name="state" id="state" class="smallselect" style="width:215px;">
        <option value="">- Select State -</option>
        <option value="AZ">Arizona</option>
        <option value="CA" selected="selected">California</option>
        <option value="NV">Nevada</option>
      </select></td>
    <td><span class="label">Zip Code:</span><br />
      <input name="zipcode" type="text" class="smalltextfield" id="zipcode" style="width:200px;"  value='92591' /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td style="text-align:right; padding-right:15px;"><input type="button" name="save" id="save" class="bluebtn smallbtn"    style="font-size: 12px; padding: 3px 7px 3px 7px; width:80px;" value="Save" /></td>
  </tr>
</table>

</div>
</td>
      </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
      
      
      <tr>
      <td style="padding:0px;text-align:left;border-top:solid 1px #DDD; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="10" style="cursor:pointer;" onClick="toggleLayer('user_pass_div', '', '', '', '', '<a href=\'javascript:;\' class=\'bluebold\'>Close</a>', '<a href=\'javascript:;\' class=\'bluebold\'>Edit</a>', 'user_pass_action')">
  <tr>
    <td width="99%"><span style="font-weight:bold;">Password</span> - <span class="greytext">Updated about 4 months ago</span></td>
    <td width="1%" id="user_pass_action"><a href="javascript:;" class="bluebold">Edit</a></td>
  </tr>
</table>

<div style="display:none;" id="user_pass_div">
<table width="100%" border="0"  cellpadding="10" cellspacing="0" style="background-color:#F2F2F2;border-top:solid 1px #DDD;">
  <tr>
    <td width="99%"><span class="label">Old Password:</span><br />
      <input name="oldpassword" type="text" class="smalltextfield" id="oldpassword" style="width:200px;" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="label">New Password:</span><br />
      <input name="newpassword" type="password" class="smalltextfield" id="newpassword" style="width:200px;" /></td>
    <td><span class="label">Confirm Password:</span><br />
      <input name="confirmpassword" type="password" class="smalltextfield" id="confirmpassword" style="width:200px;" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:right; padding-right:10px;"><input type="button" name="save" id="save" class="bluebtn"   style="font-size: 12px; padding: 3px 7px 3px 7px; width:80px;" value="Save" /></td>
  </tr>
</table>

</div>
</td>
      </tr>
      
      <tr>
      <td style="padding:0px;text-align:left;border-top:solid 1px #DDD; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="10" style="cursor:pointer;" onClick="toggleLayer('user_url_div', '', '', '', '', '<a href=\'javascript:;\' class=\'bluebold\'>Close</a>', '<a href=\'javascript:;\' class=\'bluebold\'>Edit</a>', 'user_url_action')" >
  <tr>
    <td width="99%"><span style="font-weight:bold;">Referral URLs</span> - <span class="greytext">https://www.clout.com/u/derick</span></td>
    <td width="1%" id="user_url_action"><a href="javascript:;" class="bluebold">Edit</a></td>
  </tr>
</table>



<div style="display:none;" id="user_url_div">
<table width="100%" border="0"  cellpadding="10" cellspacing="0" style="background-color:#F2F2F2;border-top:solid 1px #DDD;">
  <tr>
    <td><span class="label">Your Current URLs:</span><br /><table border="0" cellpadding="3" cellspacing="0">
                  <tr>
                    <td valign="top"><input name="emaillist" type="radio" id="email_1" value="email_1" checked="checked" /></td>
                    <td valign="top">https://www.clout.com/u/derick</td>
                    <td valign="top" style="font-weight:bold; font-size:11px;" nowrap>[Primary URL]</td>
                    </tr>
                  <tr>
                    <td valign="top"><input type="radio" name="emaillist" id="email_2" value="email_2" /></td>
                    <td valign="top">https://www.clout.com/u/dericktheman</td>
                    <td valign="top"><a href="javascript:;" class="bluebold">remove</a></td>
                    </tr>
                  <tr>
                    <td valign="top"><input type="radio" name="emaillist" id="email_3" value="email_3" /></td>
                    <td valign="top">https://www.clout.com/u/topdealssocal</td>
                    <td valign="top"><a href="javascript:;" class="bluebold">remove</a></td>
                    </tr>
                </table></td>
    </tr>
  <tr>
    <td style="padding-right:0px;"><span class="label">New URL:</span>
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><input name="newurl" type="text" class="smalltextfield" id="newurl" style="width:350px;" /></td>
          <td style="padding-left:7px;"><input type="button" name="save2" id="save2" class="bluebtn"   style="font-size: 12px; padding: 3px 7px 3px 7px; width:80px;"  value="Save" /></td>
          </tr>
  </table><span style="font-size:11px;">You are allowed up to 5 URLs</span>    </td>
    </tr>
  </table>

</div>

</td>
      </tr>
      
  
      <tr>
      <td style="padding:0px;text-align:left;border-top:solid 1px #DDD; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="10" style="cursor:pointer;"  onClick="toggleLayer('linked_accounts_div', '', '', '', '', '<a href=\'javascript:;\' class=\'bluebold\'>Close</a>', '<a href=\'javascript:;\' class=\'bluebold\'>Edit</a>', 'linked_accounts_action')">
  <tr>
    <td width="99%"><span style="font-weight:bold;">Linked Accounts</span></td>
    <td width="1%" id="linked_accounts_action"><a href="javascript:;" class="bluebold">Edit</a></td>
  </tr>
</table>



<div style="display:none;" id="linked_accounts_div">
<table width="100%" border="0"  cellpadding="10" cellspacing="0" style="background-color:#F2F2F2;border-top:solid 1px #DDD;">
  <tr>
    <td><span class="label">Accounts that raise your score and earn cash back</span><div class="curvedcorners" style="margin-left:0px; margin-right:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>Bank of America</td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/checking_account_icon.png" border="0"></a></td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/credit_card_icon.png" border="0"></a></td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/debit_card_icon.png" border="0"></a></td>
    <td width="1%" style="padding-left:40px;"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/remove_icon.png" border="0"></a></td>
  </tr>
</table>
</div>


<div class="curvedcorners" style="margin-left:0px;margin-right:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>Chase</td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/credit_card_icon.png" border="0"></a></td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/debit_card_icon.png" border="0"></a></td>
    <td width="1%" style="padding-left:40px;"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/remove_icon.png" border="0"></a></td>
  </tr>
</table>
</div>


<div class="curvedcorners" style="margin-left:0px;margin-right:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>Goldman Sachs</td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/trading_account_icon.png" border="0"></a></td>
    <td width="1%" style="padding-left:40px;"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/remove_icon.png" border="0"></a></td>
  </tr>
</table>
</div>

</td>
    </tr>
  <tr>
    <td align="right"><input type="button" id="addaccount" name="addaccount" value="Add Linked Account" class="greenbtn"  style="font-size: 12px; padding: 3px 7px 3px 7px; width:140px;"></td>
    </tr>
  </table>

</div>

</td>
      </tr>    
      
      
      
      
      
      
      
      
      
        </table>
  </div>
  
  
  
  
  
  
  <div  class="contentdiv"  style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greytop" style="width:580px;">
    <thead>
      <tr>
        <td>Clout Score - <span class="greysectionheader">Your Overall Score</span>
          </td>
        </tr>
      </thead>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td style="min-width: 190px;" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td style="height:180px; width:180px; vertical-align:top;"><div style="position:absolute; width:180px; height:180px; z-index:0; display:block;" id="donutchart">&nbsp;</div>
                <div style="position:absolute; width:180px; height:180px; z-index:5; display:block;" id="donutchartskeleton">&nbsp;</div>
                <div style="position:absolute; width:180px; height:180px; z-index:10; display:block; text-align:center; padding-top:85px;"><span style="font-family: 'Open Sans', arial;
    -webkit-font-smoothing: antialiased;
	color: #646464;
	font-size:38px;
	font-weight: 700; 
    line-height:0px;">700</span><br>
  <span style="font-family: 'Open Sans', arial;
    -webkit-font-smoothing: antialiased;
	color: #999;
	font-size:15px;
	font-weight: 400;">Your Score</span></div></td>
              
              </tr>
            <tr>
              <td style="padding-top:15px;" class="greysectionheader">Member Type<br>
  <div class="blacksectionheader">Level 7</div></td>
              </tr>
            <tr>
              <td style="padding-top:15px;" class="greysectionheader">Commission<br>
  <div class="blacksectionheader">35&cent; / Transaction</div></td>
              </tr>
            <tr>
              <td style="padding-top:30px;"><div class="greensectionheader" style="padding:20px;">Just 200 more points to reach 2% commission</div></td>
              </tr>
            </table></td>
          <td valign="top" style="width:380px; padding-left:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="blacksectionheader" style="font-size:16px;">Ways to raise your score..</td>
              </tr>
            <tr>
              <td><div style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;" ><table border="0" cellspacing="5" cellpadding="0" style=" cursor:pointer;">
                <tr>
                  <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/account_setup_icon.png"></td>
                  <td class="greycategoryheader" style="width:315px;">Account Setup</td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle; width:25px;"><img src='<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png'></td>
                  </tr>
                <tr>
                  <td><table width="67%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="1%" style="padding-right:3px;"><img src="<?php echo base_url();?>assets/images/up_arrow_grey_with_tail.png"></td>
                      <td width="98%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="90%" style="background-color: #000;text-align:right;padding-right:5px;"><span style="color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;">180</span></td>
                          <td width="10%" style="background-color: #C1C1C1;">&nbsp;</td>
                        </tr>
                      </table></td>
                      <td width="1%" style="padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;">200</td>
                    </tr>
                  </table></td>
                  </tr>
                </table>
                
  </div>
                
                
                
                
  <div id="competitor_spending" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left; cursor:pointer;"><table border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/user_activity_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Activity</td>
      <td rowspan="2" style="background: url(<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png) no-repeat center center; width:25px;">&nbsp;</td>
      </tr>
    <tr>
      <td><table width="67%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1%" style="padding-right:3px;"><img src="<?php echo base_url();?>assets/images/down_arrow_grey_with_tail.png"></td><td width="98%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="65%" style="background-color: #8566AB;text-align:right;padding-right:5px;"><span style="color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;">130</span></td>
            <td width="35%" style="background-color: #C1C1C1;">&nbsp;</td>
          
          </tr>
          </table>
          
          
          
          </td>
          <td width="1%" style="padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;">200</td>
          </tr>
        </table></td>
      </tr>
    </table>
  </div>
                
   
   
   
   <div id="category_spending" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left; cursor:pointer;"><table border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/overall_spending_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Overall Spending</td>
      <td rowspan="2" style="background: url(<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png) no-repeat center center; width:25px;">&nbsp;</td>
      </tr>
    <tr>
      <td><table width="67%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1%" style="padding-right:3px;"><img src="<?php echo base_url();?>assets/images/up_arrow_grey_with_tail.png"></td><td width="98%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="65%" style="background-color: #6D76B5;text-align:right;padding-right:5px;"><span style="color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;">130</span></td>
            <td width="35%" style="background-color: #C1C1C1;">&nbsp;</td>
          
          </tr>
          </table>
          
          
          
          </td>
          <td width="1%" style="padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;">200</td>
          </tr>
        </table></td>
      </tr>
    </table>
  </div>
   
   
   
   <div id="related_category_spending" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left; cursor:pointer;"><table border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/ad_related_spending_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Ad Related Spending</td>
      <td rowspan="2" style="background: url(<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png) no-repeat center center; width:25px;">&nbsp;</td>
      </tr>
    <tr>
      <td><table width="33%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1%" style="padding-right:3px;"><img src="<?php echo base_url();?>assets/images/up_arrow_grey_with_tail.png"></td><td width="98%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="90%" style="background-color: #2DA0D1;text-align:right;padding-right:5px;"><span style="color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;">90</span></td>
            <td width="10%" style="background-color: #C1C1C1;">&nbsp;</td>
          
          </tr>
          </table>
          
          
          
          </td>
          <td width="1%" style="padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;">100</td>
          </tr>
        </table></td>
      </tr>
    </table>
  </div>
   
   
   
   
   <div  style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;"><table border="0" cellspacing="5" cellpadding="0" style="cursor:pointer;" >
    <tr>
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/linked_accounts_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Linked Accounts</td>
      <td rowspan="2" style="text-align:center; vertical-align:middle; width:25px;" id="overall_spending_arrow_cell"><img src='<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png'></td>
      </tr>
    <tr>
      <td><table width="33%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1%" style="padding-right:3px;"><img src="<?php echo base_url();?>assets/images/down_arrow_grey_with_tail.png"></td><td width="98%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="80%" style="background-color: #03BFCD;text-align:right;padding-right:5px;"><span style="color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;">80</span></td>
            <td width="20%" style="background-color: #C1C1C1;">&nbsp;</td>
          
          </tr>
          </table>
          
          
          
          </td>
          <td width="1%" style="padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;">100</td>
          </tr>
        </table></td>
      </tr>
    </table>
    
    
  </div>
   
   
   
   <div id="linked_accounts" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left; cursor:pointer;"><table border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/network_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Network Size/Growth</td>
      <td rowspan="2" style="background: url(<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png) no-repeat center center; width:25px;">&nbsp;</td>
      </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1%" style="padding-right:3px;"><img src="<?php echo base_url();?>assets/images/up_arrow_grey_with_tail.png"></td><td width="98%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="83%" style="background-color: #0AC298;text-align:right;padding-right:5px;"><span style="color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;">250</span></td>
            <td width="17%" style="background-color: #C1C1C1;">&nbsp;</td>
          
          </tr>
          </table>
          
          
          
          </td>
          <td width="1%" style="padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;">300</td>
          </tr>
        </table></td>
      </tr>
    </table>
  </div>
   
   
   
   
   <div style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left; "><table border="0" cellspacing="5" cellpadding="0" style="cursor:pointer;">
    <tr>
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/network_spending_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Network Spending</td>
      <td rowspan="2" style="text-align:center; vertical-align:middle; width:25px;" id="reviews_preferences_arrow_cell"><img src='<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png'></td>
      </tr>
    <tr>
      <td><table width="67%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1%" style="padding-right:3px;"><img src="<?php echo base_url();?>assets/images/up_arrow_grey_with_tail.png"></td><td width="98%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="65%" style="background-color: #18C93E;text-align:right;padding-right:5px;"><span style="color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;">130</span></td>
            <td width="35%" style="background-color: #C1C1C1;">&nbsp;</td>
          
          </tr>
          </table>
          
          
          
          </td>
          <td width="1%" style="padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;">200</td>
          </tr>
        </table></td>
      </tr>
    </table>
    
  </div>
   
   
   
   
   
   
   
   
   
   
   
                
  </td>
              </tr>
            </table></td>
          </tr>
  </table>
  </td>
      </tr>
    </table></div></td>
      </tr>
     </table></td>
        <td width="1%" valign="top" class="rightmenubg">
        <div id="filterspace" style="padding:15px;min-width:245px;max-width:245px;">
        <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 15px;">
        
        <tr>
        <td class="categorycircle">People</td>
        <td class="categorycircle">Clout</td>
        <td class="selectedcategorycircle">All</td>
        <td class="categorycircle">Money</td>
        <td class="categorycircle">Offers</td>
        </tr>
        <tr>
        <td colspan="5" style="padding-top:10px;"><input type="text" name="feedsearch" id="feedsearch" value="" placeholder="Search in Feed" class="searchfield" style="width:230px;"></td>
        </tr>
        </table>
        
        
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="plusicon">&nbsp;</div></td><td style="padding-left:5px;">J.M. joined your network - 1st</td></tr></table></div>
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="moneyicon">&nbsp;</div></td><td style="padding-left:5px;">$.25 Payout at <a href="javascript:;">Mike's Bar and Grill</a></td></tr></table></div>
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="usericon">&nbsp;</div></td><td style="padding-left:5px;">J.M. Sent 648 Invites</td></tr></table></div>
        
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="moneyicon">&nbsp;</div></td><td style="padding-left:5px;">$.30 Payout at <a href="javascript:;">Nordstrom Rack</a></td></tr></table></div>
        
        <div class="feedboxseparator">&nbsp;</div>
        
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="hotspoticon">&nbsp;</div></td><td style="padding-left:5px;">New Hotspot!<br>
<span class="additionalinfo">You have 15 new friends at <a href="javascript:;">The Parlor</a></span></td></tr></table></div>
        
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td style="padding-left:5px;">BUY ONE. GET FOUR FREE.<br>
 <a href="javascript:;">now.sprint.com</a>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td style='padding-left:0px;'><img src="<?php echo base_url();?>assets/images/sample_ad_image.png"/></td>
    <td valign='top'><span class="additionalinfo">Arm your crew with 5 rugged Kyocera Torque phones for the price of 1. </span></td>
  </tr>
</table>
</td></tr></table></div>
        
        
        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="usericon">&nbsp;</div></td><td style="padding-left:5px;">People joined your network!<br>
<span class="additionalinfo">You have <a href="javascript:;">125</a> new people in your network.</span></td></tr></table></div>

        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="loyaltyicon">&nbsp;</div></td><td style="padding-left:5px;">Loyalty almost reached!<br>
<span class="additionalinfo">Visit <a href="javascript:;">Morton Steakhouse</a> 2 more times to reach the store VIP level.</span></td></tr></table></div>

        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="businessicon">&nbsp;</div></td><td style="padding-left:5px;">New Local Business<br>
<span class="additionalinfo">You may be interested in  <a href="javascript:;">Big Mama's Steakhouse</a> which just joined Clout near you.</span></td></tr></table></div>

        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="offericon">&nbsp;</div></td><td style="padding-left:5px;">15% Cash Back - <a href="javascript:;">Chillies Restaurant</a><br>
<span class="additionalinfo">Valid Mon-Fri 8:00am to 9:00am. Offer does not apply to CocaCola drinks and products.</span></td></tr></table></div>

        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="messageicon">&nbsp;</div></td><td style="padding-left:5px;">New Message<br>
<span class="additionalinfo"><a href="javascript:;">Francis Konig</a> sent you a message.</span></td></tr></table></div>

        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="messageicon">&nbsp;</div></td><td style="padding-left:5px;">New Message<br>
<span class="additionalinfo"><a href="javascript:;">Mary Jane</a> sent you a message.</span></td></tr></table></div>


        <div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="messageicon">&nbsp;</div></td><td style="padding-left:5px;">New Message<br>
<span class="additionalinfo"><a href="javascript:;">Peter Parker</a> responded to your message.</span></td></tr></table></div>
</div>
        </td>
      </tr>
    </table></td>
  </tr>
</table>

    
    </td>
  </tr>
  
  <?php $this->load->view('web/addons/footer_normal');?>
</table>

</body>
</html>