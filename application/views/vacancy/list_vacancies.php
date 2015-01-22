<?php $msg = empty($msg)? get_session_msg($this): $msg; ?>
<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">

<title><?php echo SITE_TITLE;?>: Job List</title>

<!-- Stylesheets -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.mobile.css" media="(max-width:790px)" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.tablet.css" media="(min-width:791px) and (max-width: 900px)" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.desktop.css" media="(min-width:901px)" />

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.list.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.menu.css"/>

<!-- Javascript -->
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-2.1.1.min.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-ui.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.form.js'></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.fileform.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.menu.js"></script> 
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
  <?php $this->load->view("addons/secure_header");?>
  <tr>
    <td valign="top" colspan="2" class="bodyspace" style="padding-top:0px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td id="menucontainer"><?php $this->load->view("addons/menu");?></td>
        <td style="padding-left:15px;padding-top:15px; vertical-align:top;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
      		<?php echo !empty($msg)?"<tr><td>".format_notice($this,$msg)."</td></tr>": "";?>
            <tr>
              <td><div class="h1 grey nowrap listheader">Job Notices<?php if(check_access($this, 'add_new_job', 'boolean')) echo "<div class='nextdiv addcontenticon' data-url='vacancy/add'></div>";?></div><div class="listsearchfield"><input type="text" id="jobsearch" name="jobsearch" placeholder="Search Jobs" class="findfield" value=""/></div></td></tr>
            <tr><td>
       
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <div id="listcontainer">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="paginationdiv__jobsearch_list">
    <table border="0" cellspacing="0" cellpadding="0" class="listtable">
<?php 
if(!empty($list))
{
	foreach($list AS $row)
	{
		echo "<tr class='listrow' id='".$row['id']."'>
    <td>
	<table border='0' cellspacing='0' cellpadding='0' width='100%'>
	<tr><td width='1%' style='padding:0px;'><div class='approverow'></div><div class='rejectrow'></div><div class='archiverow'></div></td>
	<td width='99%'>
	<div class='rowcontent'><span class='header'>1. Kampala: Primary School Teacher</span><br>
A Mathematics teacher with more than 15 years of experience is desired. They should be willing to move closer to the school and work more than 12 hours on some days. This is not a requirement but may be..</div>
    <div class='leftnote'>16-Jan-2015</div><div class='rightnote'><a href='javascript:;'>details</a></div>
	</td></tr></table>
	</td>
  </tr>";
	}  
}
else
{
	echo "<tr><td>".format_notice('WARNING: There are no items in this list.')."</td></tr>";
}
?>

  
    </table>
    </div></td>
  </tr>
  <tr>
    <td style="padding:15px;"><div class='centerpagination' style="margin:0px;padding:0px;"><div id="jobsearch" class="paginationdiv"><div class="previousbtn">&#x25c4;</div><div class="selected">1</div><div class="nextbtn">&#x25ba;</div></div><input name="paginationdiv__jobsearch_action" id="paginationdiv__jobsearch_action" type="hidden" value="<?php echo base_url()."search/load_list/t/jobs";?>" />
<input name="paginationdiv__jobsearch_maxpages" id="paginationdiv__jobsearch_maxpages" type="hidden" value="5" />
<input name="paginationdiv__jobsearch_showdiv" id="paginationdiv__jobsearch_showdiv" type="hidden" value="paginationdiv__jobsearch_list" /></div></td>
  </tr>
</table>
</div>
   
    </td>
    </tr>
</table>
            
            </td></tr>
        </table></td>
      </tr>
     </table>
    </td>
  </tr>
  <?php $this->load->view("addons/secure_footer");?>
</table>

</body>
</html>