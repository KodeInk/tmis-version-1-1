<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Dashboard";?></title>
	<?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
<script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
    <script src="<?php echo base_url();?>assets/js/slider.js"></script>

	

<script>
$(function() {
	$("#sendactionsbtn").click(function() {
    	$("#sendactions").slideToggle('fast');
	});
	$("#addlabelsbtn").click(function() {
    	$("#addlabels").slideToggle('fast');
	});
	
	
	$(document).mouseup(function (e)
	{
    	var container1btn = $("#sendactions");
		var container1 = $("#sendactions");
		
		var container2btn = $("#addlabelsbtn");
		var container2 = $("#addlabels");
		
		// if the target of the click isn't the container...
		// ... nor a descendant of the container
   		if (!container1btn.is(e.target) && container1btn.has(e.target).length === 0 && !container1.is(e.target) && container1.has(e.target).length === 0) 
    	{
       	 	container1.hide('fast');
    	}
		
		if (!container2btn.is(e.target) && container2btn.has(e.target).length === 0 && !container2.is(e.target) && container2.has(e.target).length === 0) 
    	{
       	 	container2.hide('fast');
    	}
	});
});


$(window).bind('resize',function(){
     window.location.href = window.location.href;
});
</script>
<style>
/*On this page, do not show the border on the right of the last cell*/
#customers_list tr td:last-child {
	border-right: 0px;
}

#customers_list thead td {
	height:20px;
}


#customers_list td {
	white-space:nowrap;
	height:28px;
}

#slider ul li {
  width: 100%;
  min-height: 100vh;
}

</style>

</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view('web/addons/header_merchant', array('main'=>'customers', 'sub'=>'Home', 'defaultHtml'=>''));?>
  <tr>
    <td class="normalpageheader" id='submenu_content' style="padding-left:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="0%" style="padding:0px;"><div class="mediumscreendetails topleftheader">Customers</div></td>
    <td width="2%" style="padding-bottom:15px; padding-left:0px;"><input name="searchdeals" type="text" class="searchfield" id="searchdeals" value='' placeholder="Enter the store or location name" style="font-size: 18px;width:300px;"><input name="checklist" id="checklist" type="hidden" value="user_001|user_002|user_003|user_004|user_005|user_006|user_007|user_008|user_009|user_010|user_011|user_012|user_013|user_014|user_015|user_016|user_017|user_018|user_019|user_020|user_021"><input name="showlayerslist" id="showlayerslist" type="hidden" value="add_labels_btn_container|send_actions_btn_container"></td>
    
    <td width="1%" style="padding-bottom:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
      <tr>
        <td width="1%" class="control_prev" style=" cursor:pointer; padding:9px;line-height:0px;" onClick="updateViewedLayerTitle('left')" id="left_arrow_box"><img src="<?php echo base_url();?>assets/images/left_arrow_big_grey.png" border="0"></td>
        <td class="mediumtext" style="text-align:center;line-height:17px;padding:10px; min-width:140px;" id="current_view_title" nowrap>Profile View</td>
        <td width="1%" class="control_next" style="padding:9px; cursor:pointer; line-height:0px;" onClick="updateViewedLayerTitle('right')" id="right_arrow_box"><img src="<?php echo base_url();?>assets/images/right_arrow_big_grey.png" border="0"></td>
      </tr>
    </table>
      <input type="hidden" name="current_layer_no" id="current_layer_no" value="0"></td>
    
    <td width="1%" style="padding-bottom:0px;"><div id="add_labels_btn_container" style="display:none;"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable" style=" cursor:pointer;" id="addlabelsbtn">
      <tr>
        <td width="1%" style="padding:8px;line-height:0px; border-right:solid 1px #E9E9E9;"><img src="<?php echo base_url();?>assets/images/tag_icon.png" border="0"></td>
        <td width="1%" style="padding:7px 5px 11px 5px; line-height:0px;"><img src="<?php echo base_url();?>assets/images/down_arrow_black.png" border="0"></td>
      </tr>
    </table>
    <div id="addlabels" class="menulayer" style="display:none;width:228px;padding:0px; z-index:100;"><table width="100%" border="0" cellspacing="0" cellpadding="5"  class="ariallabel" style="font-size:14px;">
  <tr>
    <td style="padding-bottom:0px;" valign="bottom">Label as:
</td>
  </tr>
  <tr>
    <td style="padding-top:0px;"><input type="text" name="labelsearch" id="labelsearch" value="" class="searchfield" style="width:200px;"></td>
  </tr>
  <tr>
    <td style="border-top: solid 1px #DDDDDD;"><div id="labelslist" style="max-height:150px;overflow:auto;">
    <div id="label_001"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="001" value="001"></td><td>Favorite Customer</td></tr></table></div>
    
    <div id="label_002"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="002" value="002"></td><td>Big Spender</td></tr></table></div>
    
    <div id="label_003"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="003" value="003"></td><td>Behaviour Issues</td></tr></table></div>
    
    <div id="label_004"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="004" value="004"></td><td>Celebrity</td></tr></table></div>
    
    <div id="label_005"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="005" value="005"></td><td>Has Many Friends</td></tr></table></div>
    
    <div id="label_006"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="006" value="006"></td><td>Cheap Tipper</td></tr></table></div>
    
    <div id="label_007"><table border="0" cellspacing="0" cellpadding="3"><tr><td><input type="checkbox" name="labels[]" id="007" value="007"></td><td>Big Tipper</td></tr></table></div>
    
    
    </div></td>
  </tr>
  <tr>
    <td style="border-top: solid 1px #DDDDDD;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="98%"><a href="javascript:;" class="smallblueariallink" style="color: #2C9FD1;">Manage</a> </td>
    <td width="1%"><input type="text" name="newlabel" id="newlabel" value="" placeholder="New Label" class="textfield" style="width:90px;font-size: 12px; padding:5px;"></td>
    <td width="1%" style="padding-left:3px;"><input id="addnewlabel" name="addnewlabel" type="button" value="Add" class="greenbtn" style="font-size: 12px; padding: 3px 7px 3px 7px;width:30px;"></td>
  </tr>
</table>
</td>
  </tr>
</table>
</div>
    
    </div></td>
    
    <td width="1%" style="padding-bottom:0px;"><div id="send_actions_btn_container" style="display:none;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable" style=" cursor:pointer;" id="sendactionsbtn">
      <tr>
        <td width="1%" style="padding:5px 5px 5px 9px;line-height:0px; border-right:solid 1px #E9E9E9;"><img src="<?php echo base_url();?>assets/images/send_icon.png" border="0"></td>
        <td width="1%" style="padding:7px 5px 11px 5px; line-height:0px;"><img src="<?php echo base_url();?>assets/images/down_arrow_black.png" border="0"></td>
      </tr>
    </table>
    <div id="sendactions" class="menulayer" style="display:none; z-index:100;"><a href="javascript:;">Create Promo for Group</a><br>

<a href="javascript:;">Send Message to Group</a></div>
    </div></td>
    
    <td width="80%" style="padding-bottom:0px;" align="right"><table border="0" cellspacing="0" cellpadding="0" class="listtable">
      <tr>
      <td class="label" style="text-align:center;line-height:17px;padding:10px; min-width:140px;" nowrap>1,425,781 results</td>
      
        <td style=" cursor:pointer; padding:9px;line-height:0px;"><img src="<?php echo base_url();?>assets/images/left_arrow_big_light_grey.png" border="0"></td>
        <td class="mediumtext" style="text-align:center;line-height:17px;padding:10px;" nowrap>1</td>
        <td style="padding:9px; cursor:pointer; line-height:0px;"><img src="<?php echo base_url();?>assets/images/right_arrow_big_grey.png" border="0"></td>
      </tr>
    </table></td>
    <td>&nbsp;
    </td>
    <td style="border-left: solid 1px #E0E0E0;"><table width="250" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td style="width:200px; color:#999999;">Filters</td>
        <td onClick="toggleLayer('filter_layer', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_medium_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_medium_grey.png\'>', 'filter_btn_cell', '<a href=\'javascript:void(0);\' class=\'greytext\'>Hide</a>', '<a href=\'javascript:void(0);\' class=\'greytext\'>Show</a>', 'filter_text_cell');changeWidthWithDiv('filterspace', 'filter_layer', '1%');" id="filter_text_cell"><a href="javascript:void(0);" class="greytext">Hide</a></td>
        <td style="padding-left:0px; cursor:pointer;" id="filter_btn_cell" onClick="toggleLayer('filter_layer', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_medium_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_medium_grey.png\'>', 'filter_btn_cell', '<a href=\'javascript:void(0);\' class=\'greytext\'>Hide</a>', '<a href=\'javascript:void(0);\' class=\'greytext\'>Show</a>', 'filter_text_cell');changeWidthWithDiv('filterspace', 'filter_layer', '1%');"><img src="<?php echo base_url();?>assets/images/up_arrow_medium_grey.png" border="0"></td>
      </tr>
    </table></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="99%" id="center_content" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="1%" valign="top">
    <table border="0" id="customers_list" cellspacing="0" cellpadding="5" class='listtable' style="border-top:0px;">
                <thead>
                <tr>
                  <td valign="bottom" width="1%" style=" height:60px;"><input type="checkbox" name="selectall" id="selectall" onChange="selectAll(this,'checklist');canWeShowActions('checklist')"></td>
                  
                  <td valign="bottom" style="cursor:pointer;" width="1%"><a href="javascript:void(0);" class='activelink'>User <br>Identifier</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  <td valign="bottom" style="cursor:pointer;" width="1%"><a href="javascript:void(0);" class='activelink'>Clout <br>Score</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="1%"><a href="javascript:void(0);" class='activelink'>Store <br>Score</a> 
                    <table align="center" class='clearborders'>
                      <tr>
                        <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                          </td>
                        <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                          </td>
                        </tr>
                      </table>
                  </td>
                  
                  </tr>
                </thead>
                
                
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')" id='user_001'></td>
                  <td align="center" style="font-weight:bold;">001</td>
                  <td class="blackbg bigwhitearial">1031</td>
                  <td class="blackbg bigwhitearial">1019</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_002'></td>
                  <td align="center" style="font-weight:bold;">002</td>
                  <td class="darkgreybg bigwhitearial">923</td>
                  <td class="darkgreybg bigwhitearial">928</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_003'></td>
                  <td align="center" style="font-weight:bold;">003</td>
                  <td class="deeppurplebg bigwhitearial">691</td>
                  <td class="greybg bigwhitearial">891</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_004'></td>
                  <td align="center" style="font-weight:bold;">004</td>
                  <td class="blackbg bigwhitearial">1039</td>
                  <td class="lightpurplebg bigwhitearial">719</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_005'></td>
                  <td align="center" style="font-weight:bold;">005</td>
                  <td class="deeppurplebg bigwhitearial">672</td>
                  <td class="deeppurplebg bigwhitearial">611</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_006'></td>
                  <td align="center" style="font-weight:bold;">006</td>
                  <td class="darkgreybg bigwhitearial">821</td>
                  <td class="bluebg bigwhitearial">531</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_007'></td>
                  <td align="center" style="font-weight:bold;">007</td>
                  <td class="lightbluebg bigwhitearial">423</td>
                  <td class="lightbluebg bigwhitearial">423</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_008'></td>
                  <td align="center" style="font-weight:bold;">008</td>
                  <td class="deeppurplebg bigwhitearial">691</td>
                  <td class="deepgreenbg bigwhitearial">391</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_009'></td>
                  <td align="center" style="font-weight:bold;">009</td>
                  <td class="greenbg bigwhitearial">291</td>
                  <td class="greenbg bigwhitearial">239</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_010'></td>
                  <td align="center" style="font-weight:bold;">010</td>
                  <td class="deepgreenbg bigwhitearial">320</td>
                  <td class="lightgreenbg bigwhitearial">172</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_011'></td>
                  <td align="center" style="font-weight:bold;">011</td>
                  <td class="greenbg bigwhitearial">275</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_012'></td>
                  <td align="center" style="font-weight:bold;">012</td>
                  <td class="lightgreybg bigwhitearial">50</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_013'></td>
                  <td align="center" style="font-weight:bold;">013</td>
                  <td class="lightgreybg bigwhitearial">25</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_014'></td>
                  <td align="center" style="font-weight:bold;">014</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  <td class="lightgreybg bigwhitearial">5</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_015'></td>
                  <td align="center" style="font-weight:bold;">015</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  </tr>
                
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_016'></td>
                  <td align="center" style="font-weight:bold;">016</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_017'></td>
                  <td align="center" style="font-weight:bold;">017</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  </tr>
                
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_018'></td>
                  <td align="center" style="font-weight:bold;">018</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_019'></td>
                  <td align="center" style="font-weight:bold;">019</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  </tr>
                
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_020'></td>
                  <td align="center" style="font-weight:bold;">020</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  </tr>
                
                
                <tr>
                  <td><input type='checkbox' name='users[]' onChange="canWeShowActions('checklist')"  id='user_021'></td>
                  <td align="center" style="font-weight:bold;">021</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  <td class="lightgreybg bigwhitearial">0</td>
                  </tr>
                
                
                
                
                
              </table>
    </td>
    
    <td width="99%" valign="top" id="slider_container" style="text-align:left;">
    
    
    
    
    <div id="slider">
    <ul>
    <li><div id='profile_view_div' style='overflow: auto; overflow-y: hidden; -ms-overflow-y: hidden; display:block;'><table width="100%" border="0" cellspacing="0" cellpadding="5" id="customers_list" class='listtable' style="border-top:0px;">
                <thead>
                <tr>
                  <td valign="bottom" style="cursor:pointer;height:60px;" width="10%"><a href="javascript:void(0);" class='activelink'>City</a> 
                    <table align="center" class='clearborders'>
                      <tr>
                        <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                          </td>
                        <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                          </td>
                        </tr>
                      </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="4%"><a href="javascript:void(0);" class='activelink'>State</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_blue.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="5%"><a href="javascript:void(0);" class='activelink'>Zip Code</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" nowrap width="10%"><a href="javascript:void(0);" class='activelink'>Country</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="5%"><a href="javascript:void(0);" class='activelink'>Age</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="3%"><a href="javascript:void(0);" class='activelink'>Gender</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>Network</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="6%"><a href="javascript:void(0);" class='activelink'>Invites</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>Last Login</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td>&nbsp;</td>
                  
               </tr>
                </thead>
                
                
                
                
                <tr>
                  <td align="center">Los Angeles</td>
                  <td align="center">CA</td>
                  <td align="center">90036</td>
                  <td align="center">United States</td>
                  <td align="center">28</td>
                  <td align="center">F</td>
                  <td align="center">1,234</td>
                  <td align="center">1,280</td>
                  <td align="center">10/06/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Los Angeles</td>
                  <td align="center">CA</td>
                  <td align="center">90036</td>
                  <td align="center">United States</td>
                  <td align="center">38</td>
                  <td align="center">M</td>
                  <td align="center">14</td>
                  <td align="center">114</td>
                  <td align="center">07/09/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Los Angeles</td>
                  <td align="center">CA</td>
                  <td align="center">90048</td>
                  <td align="center">United States</td>
                  <td align="center">31</td>
                  <td align="center">F</td>
                  <td align="center">24,234</td>
                  <td align="center">25,234</td>
                  <td align="center">06/11/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Los Angeles</td>
                  <td align="center">CA</td>
                  <td align="center">90038</td>
                  <td align="center">United States</td>
                  <td align="center">47</td>
                  <td align="center">F</td>
                  <td align="center">1,230</td>
                  <td align="center">1,234</td>
                  <td align="center">05/28/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Santa Monica</td>
                  <td align="center">CA</td>
                  <td align="center">90291</td>
                  <td align="center">United States</td>
                  <td align="center">59</td>
                  <td align="center">M</td>
                  <td align="center">401</td>
                  <td align="center">420</td>
                  <td align="center">09/07/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Santa Monica</td>
                  <td align="center">CA</td>
                  <td align="center">90401</td>
                  <td align="center">United States</td>
                  <td align="center">43</td>
                  <td align="center">M</td>
                  <td align="center">10</td>
                  <td align="center">45</td>
                  <td align="center">05/11/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Beverly Hills</td>
                  <td align="center">CA</td>
                  <td align="center">90210</td>
                  <td align="center">United States</td>
                  <td align="center">26</td>
                  <td align="center">M</td>
                  <td align="center">145</td>
                  <td align="center">187</td>
                  <td align="center">05/07/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Beverly Hills</td>
                  <td align="center">CA</td>
                  <td align="center">90201</td>
                  <td align="center">United States</td>
                  <td align="center">29</td>
                  <td align="center">M</td>
                  <td align="center">45,805</td>
                  <td align="center">45,809</td>
                  <td align="center">04/11/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90265</td>
                  <td align="center">United States</td>
                  <td align="center">50</td>
                  <td align="center">M</td>
                  <td align="center">1,290</td>
                  <td align="center">1,298</td>
                  <td align="center">05/07/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90265</td>
                  <td align="center">United States</td>
                  <td align="center">21</td>
                  <td align="center">M</td>
                  <td align="center">3,235</td>
                  <td align="center">4,235</td>
                  <td align="center">11/06/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90265</td>
                  <td align="center">United States</td>
                  <td align="center">25</td>
                  <td align="center">M</td>
                  <td align="center">4,236</td>
                  <td align="center">1,234</td>
                  <td align="center">05/04/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90265</td>
                  <td align="center">United States</td>
                  <td align="center">48</td>
                  <td align="center">M</td>
                  <td align="center">1,237</td>
                  <td align="center">1,234</td>
                  <td align="center">10/11/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90265</td>
                  <td align="center">United States</td>
                  <td align="center">41</td>
                  <td align="center">F</td>
                  <td align="center">160</td>
                  <td align="center">164</td>
                  <td align="center">07/08/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90266</td>
                  <td align="center">United States</td>
                  <td align="center">44</td>
                  <td align="center">F</td>
                  <td align="center">181</td>
                  <td align="center">190</td>
                  <td align="center">06/17/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90215</td>
                  <td align="center">United States</td>
                  <td align="center">27</td>
                  <td align="center">M</td>
                  <td align="center">1,800</td>
                  <td align="center">2,104</td>
                  <td align="center">05/07/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90215</td>
                  <td align="center">United States</td>
                  <td align="center">19</td>
                  <td align="center">F</td>
                  <td align="center">150</td>
                  <td align="center">198</td>
                  <td align="center">06/24/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90214</td>
                  <td align="center">United States</td>
                  <td align="center">28</td>
                  <td align="center">M</td>
                  <td align="center">134</td>
                  <td align="center">144</td>
                  <td align="center">10/03/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                <tr>

                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90213</td>
                  <td align="center">United States</td>
                  <td align="center">22</td>
                  <td align="center">F</td>
                  <td align="center">1,004</td>
                  <td align="center">1,239</td>
                  <td align="center">12/12/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90211</td>
                  <td align="center">United States</td>
                  <td align="center">35</td>
                  <td align="center">M</td>
                  <td align="center">1,030</td>
                  <td align="center">1,230</td>
                  <td align="center">11/07/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90215</td>
                  <td align="center">United States</td>
                  <td align="center">24</td>
                  <td align="center">M</td>
                  <td align="center">1,004</td>
                  <td align="center">1,261</td>
                  <td align="center">05/09/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">Malibu</td>
                  <td align="center">CA</td>
                  <td align="center">90215</td>
                  <td align="center">United States</td>
                  <td align="center">58</td>
                  <td align="center">F</td>
                  <td align="center">35</td>
                  <td align="center">38</td>
                  <td align="center">04/07/2013</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                
                
              </table>
            </div>
            </li>
            
            
            
            
            
            
            
            
            <li>
            
            
            
            
            
            
            
            
            
            
            
            
            
            <div id='score_view_div' style='overflow: auto; overflow-y: hidden; -ms-overflow-y: hidden; display:block;'>
              <table width="100%" border="0" cellspacing="0" cellpadding="5" class='listtable' id="customers_list" style="border-top:0px;">
                <thead>
                <tr>
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>In Store <br>Spending</a> 
                    <table align="center" class='clearborders'>
                      <tr>
                        <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                          </td>
                        <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                          </td>
                        </tr>
                      </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>Competitor <br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_blue.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>Category <br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" nowrap width="10%"><a href="javascript:void(0);" class='activelink'>Related Category <br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>Overall <br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>Linked <br>Accounts</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>Reviews / <br>Preferences</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  
                  <td>&nbsp;</td>
                  
               </tr>
                </thead>
                
                
                
                
                <tr>
                  <td align="center">100%</td>
                  <td align="center">100%</td>
                  <td align="center">100%</td>
                  <td align="center">100%</td>
                  <td align="center">100%</td>
                  <td align="center">100%</td>
                  <td align="center">100%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">81.0%</td>
                  <td align="center">99.9%</td>
                  <td align="center">99.9%</td>
                  <td align="center">92.6%</td>
                  <td align="center">99.9%</td>
                  <td align="center">100%</td>
                  <td align="center">92.8%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">80.1%</td>
                  <td align="center">89.9%</td>
                  <td align="center">91.9%</td>
                  <td align="center">92.6%</td>
                  <td align="center">96.9%</td>
                  <td align="center">68.0%</td>
                  <td align="center">69.1%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">85.9%</td>
                  <td align="center">90.9%</td>
                  <td align="center">72.6%</td>
                  <td align="center">76.9%</td>
                  <td align="center">99.9%</td>
                  <td align="center">99.9%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">75.9%</td>
                  <td align="center">70.9%</td>
                  <td align="center">62.6%</td>
                  <td align="center">66.9%</td>
                  <td align="center">65.9%</td>
                  <td align="center">58.9%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">65.9%</td>
                  <td align="center">50.9%</td>
                  <td align="center">52.6%</td>
                  <td align="center">56.9%</td>
                  <td align="center">79.9%</td>
                  <td align="center">88.9%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">40.1%</td>
                  <td align="center">50.9%</td>
                  <td align="center">46.9%</td>
                  <td align="center">38.6%</td>
                  <td align="center">40.9%</td>
                  <td align="center">49.9%</td>
                  <td align="center">36.9%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">45.1%</td>
                  <td align="center">20.9%</td>
                  <td align="center">36.9%</td>
                  <td align="center">38.6%</td>
                  <td align="center">40.9%</td>
                  <td align="center">72.9%</td>
                  <td align="center">66.9%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">32.9%</td>
                  <td align="center">32.9%</td>
                  <td align="center">19.6%</td>
                  <td align="center">20.9%</td>
                  <td align="center">27.9%</td>
                  <td align="center">32.9%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">32.9%</td>
                  <td align="center">32.9%</td>
                  <td align="center">19.6%</td>
                  <td align="center">20.9%</td>
                  <td align="center">27.9%</td>
                  <td align="center">39.9%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">27.5%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td align="center">0%</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                
                
              </table>
            </div>
            
            </li>
            
            
            
            
            
            
            <li>
            
            
            
            
            
            
            
            
            
            
            
            <div id='promo_view_div' style='overflow: auto; overflow-y: hidden; -ms-overflow-y: hidden; display:block;'>
              <table width="100%" border="0" cellspacing="0" cellpadding="5" class='listtable' id="customers_list" style="border-top:0px;">
                <thead>
                <tr>
                  <td valign="bottom" style="cursor:pointer;" width="5%"><a href="javascript:void(0);" class='activelink'>Promos <br>Available</a> 
                    <table align="center" class='clearborders'>
                      <tr>
                        <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                          </td>
                        <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                          </td>
                        </tr>
                      </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="5%"><a href="javascript:void(0);" class='activelink'>Promos <br>Viewed</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_blue.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="5%"><a href="javascript:void(0);" class='activelink'>Promos <br>Used</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" nowrap width="10%"><a href="javascript:void(0);" class='activelink'>This Week <br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>Last Week <br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>This Month <br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>Last Month<br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>This Year<br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%"><a href="javascript:void(0);" class='activelink'>Last Year<br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;" width="10%" nowrap><a href="javascript:void(0);" class='activelink'>Lifetime<br>Spending</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_blue.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  <td>&nbsp;</td>
                  
               </tr>
                </thead>
                
                
                
                
                <tr>
                  <td align="center">5</td>
                  <td align="center">3</td>
                  <td align="center">3</td>
                  <td align="center">$1,000.00</td>
                  <td align="center">$8,000.00</td>
                  <td align="center">$9,000.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$9,000.00</td>
                  <td align="center">$150,000.00</td>
                  <td align="center">$159,000.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">3</td>
                  <td align="center">6</td>
                  <td align="center">1</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$81.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$81.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$81.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">2</td>
                  <td align="center">12</td>
                  <td align="center">2</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$20.00</td>
                  <td align="center">$80.10</td>
                  <td align="center">$100.10</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">1</td>
                  <td align="center">9</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">1</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">1</td>
                  <td align="center">4</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">1</td>
                  <td align="center">2</td>
                  <td align="center">1</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">1</td>
                  <td align="center">1</td>
                  <td align="center">1</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">0</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td align="center">$0.00</td>
                  <td>&nbsp;</td>
                </tr>
                
                
                
                
                
              </table>
            </div>
            
            </li>
    
    </ul>
    </div> 
    </td></tr>
    </table>
     
     
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    </td>
    <td valign="top" class="rightmenubg" id="filterspace" width="1%"><div id="filter_layer" style="padding:0px 15px 15px 15px;min-width:245px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border-bottom: solid 1px #CCC;">
        <tr onClick="toggleLayer('score_and_spending_options', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_medium_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_medium_grey.png\'>', 'score_and_spending_cell', '', '', '');" style="cursor:pointer;">
          <td width="99%" style="padding-left:0px;"><a href="javascript:;" class="greytext">Score and Spending</a></td>
          <td width="1%" id="score_and_spending_cell"><img src="<?php echo base_url();?>assets/images/down_arrow_medium_grey.png" border="0"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:0px;"><div id="score_and_spending_options" class="filtersectionlayer" style="display:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-top:10px;" nowrap><select class="smallselect" name="cloutscorefrom" id="cloutscorefrom" style="margin-top:0px;width:105px;padding:5px 5px 5px 0px;">
    <option value="" selected>Clout Score</option>
    <option value="0">0</option>
    <option value="100">100</option>
    <option value="200">200</option>
    <option value="300">300</option>
    <option value="400">400</option>
    <option value="500">500</option>
    <option value="600">600</option>
    <option value="700">700</option>
    <option value="800">800</option>
    <option value="900">900</option>
    <option value="1000+">1000+</option>
    </select> to 
    <select class="smallselect" name="cloutscoreto" id="cloutscoreto" style="margin-top:0px;width:105px;padding:5px 5px 5px 0px;">
    <option value="" selected>Clout Score</option>
    <option value="0">0</option>
    <option value="100">100</option>
    <option value="200">200</option>
    <option value="300">300</option>
    <option value="400">400</option>
    <option value="500">500</option>
    <option value="600">600</option>
    <option value="700">700</option>
    <option value="800">800</option>
    <option value="900">900</option>
    <option value="1000+">1000+</option>
    </select></td>
  </tr>
  <tr>
    <td style="padding-top:5px;"><select class="smallselect" name="storescorefrom" id="storescorefrom" style="margin-top:0px;width:105px;padding:5px 5px 5px 0px;">
    <option value="" selected>Store Score</option>
    <option value="0">0</option>
    <option value="100">100</option>
    <option value="200">200</option>
    <option value="300">300</option>
    <option value="400">400</option>
    <option value="500">500</option>
    <option value="600">600</option>
    <option value="700">700</option>
    <option value="800">800</option>
    <option value="900">900</option>
    <option value="1000+">1000+</option>
    </select> to 
    <select class="smallselect" name="storescoreto" id="storescoreto" style="margin-top:0px;width:105px;padding:5px 5px 5px 0px;">
    <option value="" selected>Store Score</option>
    <option value="0">0</option>
    <option value="100">100</option>
    <option value="200">200</option>
    <option value="300">300</option>
    <option value="400">400</option>
    <option value="500">500</option>
    <option value="600">600</option>
    <option value="700">700</option>
    <option value="800">800</option>
    <option value="900">900</option>
    <option value="1000+">1000+</option>
    </select></td>
  </tr>
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;">Spending Rank (%)</td>
  </tr>
  <tr>
    <td style="padding-top:5px; padding-bottom:10px;" nowrap><select class="smallselect" name="spendingin" id="spendingin" style="margin-top:0px;width:80px;padding:5px 5px 5px 0px;">
    <option value="in_store" selected>In Store</option>
    <option value="competitor">Competitor</option>
    <option value="category">Category</option>
    <option value="relative_category">Relative Category</option>
    <option value="overall">Overall</option>
    </select> <select class="smallselect" name="spendlevel" id="spendlevel" style="margin-top:0px;width:70px;padding:5px 5px 5px 0px;">
    <option value="above" selected>Above</option>
    <option value="below">Below</option>
    </select>
    
    <input name="levelvalue" type="text" class="textfield" id="levelvalue" style="width:30px; font-size:12px;" value=""> %</td>
  </tr>
</table>

          
          </div></td>
          </tr>
      </table></td>
    </tr>
    <tr><td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border-bottom: solid 1px #CCC;">
        <tr onClick="toggleLayer('customer_activity_options', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_medium_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_medium_grey.png\'>', 'customer_activity_cell', '', '', '');" style="cursor:pointer;">
          <td width="99%" style="padding-left:0px;"><a href="javascript:;" class="greytext">Customer Activity</a></td>
          <td width="1%" id="customer_activity_cell"><img src="<?php echo base_url();?>assets/images/down_arrow_medium_grey.png" border="0"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:0px;"><div id="customer_activity_options" class="filtersectionlayer" style="display:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap>Eligible for Promo? &nbsp;<select class="smallselect" name="eligibleforpromo" id="eligibleforpromo" style="margin-top:0px;width:60px;padding:5px 5px 5px 0px;">
    <option value="yes" selected>Yes</option>
    <option value="no">No</option>
    </select></td>
  </tr>
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap>Viewed My Promo? &nbsp;<select class="smallselect" name="viewedmypromo" id="viewedmypromo" style="margin-top:0px;width:60px;padding:5px 5px 5px 0px;">
    <option value="yes" selected>Yes</option>
    <option value="no">No</option>
    </select></td>
  </tr>
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap>Used My Promo? &nbsp;<select class="smallselect" name="usedmypromo" id="usedmypromo" style="margin-top:0px;width:60px;padding:5px 5px 5px 0px;">
    <option value="yes" selected>Yes</option>
    <option value="no">No</option>
    </select></td>
  </tr>
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;">Promo Spending</td>
  </tr>
  <tr>
    <td style="padding-top:5px; padding-bottom:10px;" nowrap><select class="smallselect" name="spendingperiod" id="spendingperiod" style="margin-top:0px;width:100px;padding:5px 5px 5px 0px;">
    <option value="this_week" selected>This Week</option>
    <option value="last_week">Last Week</option>
    <option value="this_month">This Month</option>
    <option value="last_month">Last Month</option>
    <option value="this_year">This Year</option>
    <option value="last_year">Last Year</option>
    <option value="lifetime">Lifetime</option>
    </select> <select class="smallselect" name="spendingperiodlevel" id="spendingperiodlevel" style="margin-top:0px;width:70px;padding:5px 5px 5px 0px;">
    <option value="above" selected>Above</option>
    <option value="below">Below</option>
    </select>
    
    $ <input name="spendingvalue" type="text" class="textfield" id="spendingvalue" style="width:20px; font-size:12px;" value=""></td>
  </tr>
</table>

          
          </div></td>
          </tr>
      </table></td></tr>
    
    <tr><td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border-bottom: solid 1px #CCC;">
        <tr onClick="toggleLayer('demographics_options', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_medium_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_medium_grey.png\'>', 'demographics_cell', '', '', '');" style="cursor:pointer;">
          <td width="99%" style="padding-left:0px;"><a href="javascript:;" class="greytext">Demographics</a></td>
          <td width="1%" id="demographics_cell"><img src="<?php echo base_url();?>assets/images/down_arrow_medium_grey.png" border="0"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:0px;"><div id="demographics_options" class="filtersectionlayer" style="display:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap><input name="fromage" type="text" class="textfield" id="fromage" style="width:50px; font-size:12px;" value="" placeholder="From Age"> to <input name="toage" type="text" class="textfield" id="toage" style="width:50px; font-size:12px;" value="" placeholder="To Age"> <select class="smallselect" name="gender" id="gender" style="margin-top:0px;width:77px;padding:5px 5px 5px 0px;">
    <option value="" selected>Gender</option>
    <option value="all">All</option>
    <option value="female">Female</option>
    <option value="male">Male</option>
    </select></td>
  </tr>
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px; padding-bottom:10px;" nowrap>Network Size <select class="smallselect" name="networksizelevel" id="networksizelevel" style="margin-top:0px;width:70px;padding:5px 5px 5px 0px;">
      <option value="above" selected>Above</option>
    <option value="below">Below</option>
  </select> 
      <input name="networkvalue" type="text" class="textfield" id="networkvalue" style="width:40px; font-size:12px;" value=""></td>
  </tr>
</table>

          
          </div></td>
          </tr>
      </table></td></tr>
    
    
    
    
    <tr>
      <td  style="padding-top:15px; padding-bottom:15px;" align="right"><input id="clearchanges" name="clearchanges" type="button" value="Clear" class="greybtn" style="font-size: 12px; padding: 3px 7px 3px 7px; width: 80px;"> <input id="applychanges" name="applychanges" type="button" value="Apply" class="greenbtn" style="font-size: 12px; padding: 3px 7px 3px 7px; width: 80px;"></td>
    </tr>
    
    
    
    
    
    
    
    
    
    </table>
</div></td>
  </tr>
</table>
</td>
  </tr>
  
  <?php $this->load->view('web/addons/footer_normal');?>
</table>

</body>
</html>