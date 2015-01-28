<?php 
$forward = check_access($this, 'change_user_status', 'boolean')? 'user/update_status': get_user_dashboard($this, $this->native_session->get('__user_id'));
?>
<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon">

<title><?php echo SITE_TITLE;?>: <?php echo !empty($id)? 'Edit': 'New';?> User</title>

<!-- Stylesheets -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.mobile.css" media="(max-width:790px)" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.tablet.css" media="(min-width:791px) and (max-width: 900px)" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.desktop.css" media="(min-width:901px)" />

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.list.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/tmis.menu.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/trumbowyg.css"/>

<!-- Javascript -->
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-2.1.1.min.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery-ui.js'></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery.form.js'></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.fileform.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.menu.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/tmis.responsive.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/trumbowyg.js"></script> 

<script type="text/javascript">
<?php echo !empty($id) && !empty($result['boolean']) && $result['boolean']?"window.top.location.href = '".base_url().$forward."';": "";?>
</script>
</head>

<body style="margin:0px;">
<?php 
# Do not show the header, menu and footer when editing
if(empty($id)) {?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view("addons/secure_header");?>
  <tr>
    <td valign="top" colspan="2" class="bodyspace" style="padding-top:0px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td id="menucontainer"><?php $this->load->view("addons/menu");?></td>
        <td style="padding-left:15px;padding-top:15px; vertical-align:top;">
<?php }?>		

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      		<tr><td class="h1 grey"><?php echo !empty($id)? 'Edit': 'New';?> User</td></tr>
            <?php echo !empty($msg)?"<tr><td>".format_notice($this,$msg)."</td></tr>": "";?>
            <tr><td>
            
            
            <form id="user_data" method="post" autocomplete="off" action="<?php echo base_url().'user/add'.(!empty($id)? '/id/'.$id: '');?>" class='simplevalidator'>
            <table border="0" cellspacing="0" cellpadding="10">
  
  <tr>
    <td class="label">Role:</td>
    <td style="padding-right:42px;"><?php if(!empty($id) && $this->native_session->get('role__jobroles')){
		echo "<div class='value'>".$this->native_session->get('role__roles')."</div>";
		} else {?><input type="text" id="role__roles" name="role__roles" title="Select Role" placeholder="Select User Role" class="textfield selectfield" value="<?php echo $this->native_session->get('role__roles');?>" style="width:97%;"/><?php }?></td>
  </tr>
  <tr>
    <td class="label">Surname:</td>
    <td><input type="text" id="lastname" name="lastname" title="Surname" class="textfield" style="width:97%;" value="<?php echo $this->native_session->get('lastname');?>"/></td>
  </tr>
  <tr>
    <td class="label">Other Names:</td>
    <td><input type="text" id="firstname" name="firstname" title="Other Names" class="textfield" style="width:97%;" value="<?php echo $this->native_session->get('firstname');?>"/></td>
  </tr>
  <tr>
    <td class="label top">Email Address:</td>
    <td><input type="text" id="emailaddress" name="emailaddress" title="Email Address" class="textfield" style="width:97%;" value="<?php echo $this->native_session->get('emailaddress');?>"/><br><span class="smalltext">The user's password will be automatically generated <br>and sent to this email address.</span></td>
  </tr>
  <tr>
    <td class="label">Telephone:</td>
    <td><input type="text" id="telephone" name="telephone" title="Telephone"  placeholder="Optional (e.g: 0782123456)" maxlength="10" class="textfield numbersonly telephone optional" style="width:97%;" value="<?php echo $this->native_session->get('telephone');?>"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><button type="submit" name="save" id="save" class="btn">SAVE</button><?php echo !empty($id)? "<input type='hidden' id='userid' name='userid' value='".$id."' />": "";
	
	echo  empty($id)? "<input type='hidden' id='forwardurl' name='forwardurl' value='".$forward."' />": "";?></td>
  </tr>
            </table>
            </form>
            
            </td></tr>
        </table>
 
 <?php 
# Do not show the header and footer when editing
if(empty($id)) {?>       
        </td>
      </tr>
     </table>
    </td>
  </tr>
  <?php $this->load->view("addons/secure_footer");?>
</table>
<?php } else {echo "<input type='hidden' id='layerid' name='layerid' value='' />";}?>

<script type="text/javascript">
$(function(){	
	var btnsGrps = jQuery.trumbowyg.btnsGrps;
	$('#details').trumbowyg({btns: ['formatting',
           '|', btnsGrps.design,
           '|', 'link',
           '|', btnsGrps.justify,
           '|', btnsGrps.lists,
           '|', 'insertHorizontalRule']
	});
});
</script>
</body>
</html>