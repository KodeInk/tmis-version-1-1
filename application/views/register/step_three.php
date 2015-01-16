<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">

<title><?php echo SITE_TITLE;?>: Register</title>

<!-- Stylesheets -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.mobile.css" media="(max-width:790px)" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.tablet.css" media="(min-width:791px) and (max-width: 900px)" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.desktop.css" media="(min-width:901px)" />

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.list.css"/>

<!-- Javascript -->
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-2.1.1.min.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-ui.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.form.js'></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.callout.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.fileform.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.responsive.js"></script> 

</head>

<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view("addons/public_header", array("page"=>"register"));?>
  <tr>
    <td valign="top" colspan="2" class="bodyspace">
    <form id="home_registration_form" method="post" autocomplete="off" action="<?php echo base_url();?>register/step_three" class='simplevalidator'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td class="h1 grey">Teacher Registration</td>
     </tr>
     <tr>
     <td>
     <table width="100%" border="0" cellspacing="0" cellpadding="0" id="stepstracker">
     	<tr>
    		<td class='stepone visited'><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div></td>
     		<td class='visitedfiller'>&nbsp;</td>
     		<td class='steptwo visited'><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div></td>
     		<td class='visitedfiller'>&nbsp;</td>
     		<td class='stepthree visited'><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div></td>
     		<td class='unvisitedfiller'>&nbsp;</td>
     		<td class='stepfour unvisited'><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div></td>
     	</tr>
     	<tr>
     		<td class='visited'>Personal Information</td>
     		<td>&nbsp;</td>
     		<td class='visited'>Identification &amp; Contacts</td>
     		<td>&nbsp;</td>
     		<td class='visited'>Education &amp; Qualifications</td>
     		<td>&nbsp;</td>
    		<td class='unvisited'>Preview &amp; Submit</td>
     	</tr>
     </table>
     </td>
     </tr>
     
     <?php echo !empty($msg)?"<tr><td>".format_notice($this,$msg)."</td></tr>": "";?>
     
     <tr><td class="greybg h3" style="padding-left:5px;">Education:</td></tr>
     <tr>
      <td>
      
        <table border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td class="label" id="institutionlabel">Institution:</td>
    <td><div class="nextdiv"><input type="text" id="institutionname" name="institutionname" title="Insitution Name" class="textfield" value=""/></div>
      <div class="nextdiv"><input type="text" id="institution__institutiontype" name="institution__institutiontype" class="textfield selectfield" value="" placeholder="Insitution Type" /></div></td>
  </tr>
  <tr>
    <td class="label">Period:</td>
    <td><div class="nextdiv">
    <table border="0" cellspacing="0" cellpadding="0">
    <tr><td class="value" style="padding-right:9px;">From</td>
    <td><input type="text" id="from__month" name="from__month" placeholder="Month" class="textfield selectfield" style="width:100px;" value=""/></td>
    <td><input type="text" id="from__pastyear" name="from__pastyear" placeholder="Year" class="textfield selectfield" style="width:55px;" value=""/></td>
    </tr>
    </table>
    </div>
    <div class="nextdiv">
    <table border="0" cellspacing="0" cellpadding="0">
    <tr><td class="value" style="padding-right:30px;">To</td>
    <td><input type="text" id="to__month" name="to__month" placeholder="Month" class="textfield selectfield" style="width:100px;" value=""/></td>
    <td><input type="text" id="to__pastyear" name="to__pastyear" placeholder="Year" class="textfield selectfield" style="width:55px;" value=""/></td>
    </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    <td class="label">Certificate Obtained:</td>
    <td><div class="nextdiv"><input type="text" id="certificatename" name="certificatename" title="Certificate Name" class="textfield" value=""/></div>
      <div class="nextdiv"><input type="checkbox" id="highestcertificate" name="highestcertificate" value="Y" />
      <label for="highestcertificate">This is my highest certificate.</label></div></td>
  </tr>
  <tr>
    <td class="label">Certificate Number:</td>
    <td><input type="text" id="certificatenumber" name="certificatenumber" title="Certificate Number" class="textfield" value=""/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><button type="button" name="saveeducation" id="saveeducation" class="greybtn">ADD</button></td>
  </tr>
        </table>
        
      </td>
     </tr>
     
     <tr><td><div id="institution_list">
     <table border="0" cellspacing="0" cellpadding="0" class="resultslisttable">
     <tr><td>Current List</td></tr>
     <tr><td>No institution added yet.</td></tr>
     </table>
     </div></td></tr>
     <tr><td>&nbsp;</td></tr>
     <tr><td class="greybg h3" style="padding-left:5px;">Subjects Taught:</td></tr>
     
     <tr>
       <td><table border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td class="label" id="subjectlabel">Subject Name:</td>
    <td><div class="nextdiv"><input type="text" id="subjectname" name="subjectname" title="Subject Name" class="textfield" value=""/></div>
      <div class="nextdiv"><input type="text" id="subject__subjecttype" name="subject__subjecttype" class="textfield selectfield" value="" placeholder="Subject Type" /></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><button type="button" name="saveeducation" id="saveeducation" class="greybtn">ADD</button></td>
  </tr>
        </table></td></tr>
     <tr><td><div id="subject_list"><table border="0" cellspacing="0" cellpadding="0" class="resultslisttable">
     <tr><td>Current List</td></tr>
     <tr><td>No subject added yet.</td></tr>
     </table></div></td></tr>
     <tr><td style="padding-top:30px;">&nbsp;</td></tr>
     
     <tr>
      <td>
     <table width="100%" border="0" cellspacing="0" cellpadding="0" class='buttonnav'>
     <tr>
     <td><button type="button" name="backtostep2" id="backtostep2" class="greybtn back">BACK</button></td>
     <td class='spacefiller'>&nbsp;</td>
     <td><button type="submit" name="step2save" id="step2save" class="greybtn">SAVE &amp; EXIT</button></td>
     <td><button type="submit" name="step2" id="step2" class="btn next">NEXT</button></td>
     </tr>
     <tr>
       <td colspan="4" class='note'>Applications not completed within 14 days will be automatically deleted by the system.</td>
       </tr>
     </table> 
      </td>
     </tr>
     </table>
     </form>
    </td>
  </tr>
  <?php $this->load->view("addons/public_footer");?>
</table>


</body>
</html>