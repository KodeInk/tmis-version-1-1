<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">

<title><?php echo SITE_TITLE;?>: Welcome</title>

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
 

<!-- Functionality to handle pagination. -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.pagination.css" type="text/css" media="screen" />
<style type="text/css"> 
.centerpagination {width: 100%; text-align: center;}
.paginationdiv {display: table;  margin: 0 auto;} 
.paginationdiv div { background-color: #FFF; } 
</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.pagination.js"></script>


</head>

<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view("addons/public_header", array("page"=>"home"));?>
  <tr>
    <td valign="top" class="leftcolumn"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="mobilebuttons_details"></div>
    <div id="mobilebuttons"><button type="button" name="step1btnbig" id="step1btnbig" class="bigbtn">REGISTER</button><br><br>
<button type="button" name="loginbtnbig" id="loginbtnbig" class="biggreybtn">LOGIN</button></div>
    <div class="h1 blue nowrap listheader">Job Notices</div><div class="listsearchfield"><input type="text" id="jobsearch" name="jobsearch" placeholder="Search Jobs" class="findfield" value=""/></div></td>
    </tr>
  <tr>
    <td>
    <div id="listcontainer">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="paginationdiv__jobsearch_list">
    <table border="0" cellspacing="0" cellpadding="0" class="listtable">
    
    <tr>
    <td><div class="rowcontent"><span class="header">1. Kampala: Primary School Teacher</span><br>
A Mathematics teacher with more than 15 years of experience is desired. They should be willing to move closer to the school and work more than 12 hours on some days. This is not a requirement but may be..</div>
    <div class="leftnote">16-Jan-2015</div><div class="rightnote"><a href="javascript:;">details</a></div></td>
  </tr>
  
  <tr>
    <td><div class="rowcontent"><span class="header">2. Moroto: Secondary School Teacher</span><br>
A Social Studies teacher with at least 2 years of experience is desired. They may be allowed to work from  home after proving that they can keep time for in-person classes. The class size will be about 30 studen..</div>
    <div class="leftnote">27-Jan-2015</div><div class="rightnote"><a href="javascript:;">details</a></div></td>
  </tr>
  
  <tr>
    <td><div class="rowcontent"><span class="header">3. Moroto: Secondary School Teacher</span><br>
A Social Studies teacher with at least 2 years of experience is desired. They may be allowed to work from  home after proving that they can keep time for in-person classes. The class size will be about 30 studen..</div>
    <div class="leftnote">27-Jan-2015</div><div class="rightnote"><a href="javascript:;">details</a></div></td>
  </tr>
  
  <tr>
    <td><div class="rowcontent"><span class="header">4. Moroto: Secondary School Teacher</span><br>
A Social Studies teacher with at least 2 years of experience is desired. They may be allowed to work from  home after proving that they can keep time for in-person classes. The class size will be about 30 studen..</div>
    <div class="leftnote">27-Jan-2015</div><div class="rightnote"><a href="javascript:;">details</a></div></td>
  </tr>
  
  <tr>
    <td><div class="rowcontent"><span class="header">5. Moroto: Secondary School Teacher</span><br>
A Social Studies teacher with at least 2 years of experience is desired. They may be allowed to work from  home after proving that they can keep time for in-person classes. The class size will be about 30 studen..</div>
    <div class="leftnote">27-Jan-2015</div><div class="rightnote"><a href="javascript:;">details</a></div></td>
  </tr>
  
    </table>
    </div></td>
  </tr>
  <tr>
    <td style="padding:15px;"><div class='centerpagination' style="margin:0px;padding:0px;"><div id="jobsearch" class="paginationdiv"><div class="previousbtn">&#x25c4;</div><div class="selected">1</div><div>2</div><div>3</div><div class="nextbtn">&#x25ba;</div></div><input name="paginationdiv__jobsearch_action" id="paginationdiv__jobsearch_action" type="hidden" value="<?php echo base_url()."search/load_list/t/jobs";?>" />
<input name="paginationdiv__jobsearch_maxpages" id="paginationdiv__jobsearch_maxpages" type="hidden" value="5" />
<input name="paginationdiv__jobsearch_showdiv" id="paginationdiv__jobsearch_showdiv" type="hidden" value="paginationdiv__jobsearch_list" /></div></td>
  </tr>
</table>
</div>

<div id="jobslist_btn_only"><button type="button" name="jobslistbtn" id="jobslistbtn" class="btn" style="width:240px;">VIEW JOBS</button></div>
   
    </td>
    </tr>
</table>
</td>
    <td valign="top" class="rightcolumn"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="h1 grey">Teacher Registration</td>
        <td valign="top"><div id="registration_close_btn">&nbsp;</div></td>
      </tr>
      <tr>
        <td colspan="2" class="h2 grey">Registration helps you to speed up your benefit processing, leave application, transfer and many more career tracking options.</td>
      </tr>
      <tr>
        <td colspan="2"><div id="registration_form"><form id="home_registration_form" method="post" autocomplete="off" action="<?php echo base_url();?>register/step_one" class='simplevalidator'>
        <table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="label">Surname:</td>
    <td><input type="text" id="lastname" name="lastname" title="Surname" class="textfield" value="<?php echo ($this->native_session->get('lastname')? $this->native_session->get('lastname'): '');?>"/></td>
  </tr>
  <tr>
    <td class="label">Other Names:</td>
    <td><input type="text" id="firstname" name="firstname" title="Other Names" class="textfield" value="<?php echo ($this->native_session->get('firstname')? $this->native_session->get('firstname'): '');?>"/></td>
  </tr>
  <tr>
    <td class="label">Telephone:</td>
    <td><input type="text" id="telephone" name="telephone" title="Telephone" placeholder="Optional" maxlength="16" class="textfield numbersonly optional" value="<?php echo ($this->native_session->get('telephone')? $this->native_session->get('telephone'): '');?>"/></td>
  </tr>
  <tr>
    <td class="label">Email Address:</td>
    <td><input type="text" id="emailaddress" name="emailaddress" title="Email Address" class="textfield email" value="<?php echo ($this->native_session->get('emailaddress')? $this->native_session->get('emailaddress'): '');?>"/></td>
  </tr>
  <tr>
    <td class="label">Gender:</td>
    <td><div class="nextdiv"><input type="radio" name="gender" id="gender_female" value="female" <?php echo ($this->native_session->get('gender') && $this->native_session->get('gender')=='female'? 'checked': '');?>>
       <label for="gender_female">Female</label></div>
       <div class="nextdiv"><input type="radio" name="gender" id="gender_male" value="male" <?php echo ($this->native_session->get('gender') && $this->native_session->get('gender')=='male'? 'checked': '');?>>
       <label for="gender_male">Male</label></div></td>
  </tr>
  <tr>
    <td class="label">Marital Status:</td>
    <td><div class="nextdiv"><input type="radio" name="marital" id="marital_married" value="married" <?php echo ($this->native_session->get('marital') && $this->native_session->get('marital')=='married'? 'checked': '');?>>
       <label for="marital_married">Married</label></div>
       <div class="nextdiv"><input type="radio" name="marital" id="marital_single" value="single" <?php echo ($this->native_session->get('marital') && $this->native_session->get('marital')=='single'? 'checked': '');?>>
       <label for="marital_single">Single</label></div></td>
  </tr>
  <tr>
    <td class="label">Birth Day:</td>
    <td><input type="text" id="birthday" name="birthday" title="Birth Day" class="textfield datefield birthday" value="<?php echo ($this->native_session->get('birthday')? $this->native_session->get('birthday'): '');?>" readonly/></td>
  </tr>
  <tr>
    <td class="label">Birth Place:</td>
    <td><input type="text" id="birthplace" name="birthplace" title="Birth Place" class="textfield placefield physical" value="<?php echo ($this->native_session->get('birthplace__addressline')? $this->native_session->get('birthplace__addressline'): '');?>" readonly/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" style="padding-top:20px;"><button type="submit" name="step1" id="step1" class="btn next">NEXT</button></td>
  </tr>
</table>
        </form>
</div><div id="registration_form_btn_only"><button type="button" name="step1btn" id="step1btn" class="btn" style="width:240px;">REGISTER</button></div></td>
      </tr>
    </table></td>
  </tr>
  <?php $this->load->view("addons/public_footer");?>
</table>


</body>
</html>