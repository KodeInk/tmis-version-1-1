<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Favorites";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
	

	<?php 
		echo get_ajax_constructor(TRUE);
	 
	    echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
<script>
$(function() {
	$( ".mainitem" ).click(function(){ 
		 var divId = this.id;
		 var subSectionDivId = divId+"_child";
		 //Close all other subsections
		 $('.subcontainer').hide('fast');
		 //Show the desired subsection
		 $('#'+subSectionDivId).show('fast');
		 
		 $("div").removeClass("selectedmain selectedsubmain");
		 $(this).addClass("selectedmain");
	});
	
	$( ".submainitem" ).click(function(){ 
		$("div").removeClass("selectedsubmain");
		$(this).addClass("selectedsubmain");
	});
	
	$(".favrow").hover(function(){
		$(this).find("div").show('fast');
	}, function(){
		$(this).find("div").hide('fast');
	});
});
</script>  

</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view('web/addons/header_normal', array('main'=>'favorites', 'sub'=>'Home', 'defaultHtml'=>''));?>
  <tr>
    <td class="normalpageheader" id='submenu_content' style="padding-left:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="0%" style="padding:0px;"><div class="bigscreendetails topleftheader">Favorites</div></td>
    <td width="1%" style="padding-bottom:15px; padding-left:0px;"><select name='place' id='place' class="selecttextfield" style="width:220px;">
        <option value='' selected>Any Distance</option>
        <option value="0.25">1/4 mile</option>
    <option value="1">1 mile</option>
    <option value="5">5 miles</option>
    <option value="10">10 miles</option>
    <option value="15">15 miles</option>
    <option value="30">30 miles</option>
    <option value="50">50 miles</option>
        </select></td>
    <td width="99%" style="padding-bottom:15px; text-align:left;"><select name='place' id='place' class="selecttextfield" style="width:300px;">
        <option value='Los Angeles' selected>Los Angeles, CA</option>
        <option value='San Diego'>San Diego, CA</option>
        <option value='Orange'>Orange, CA</option>
        <option value='Riverside'>Riverside, CA</option>
        <option value='San Bernardino'>San Bernardino, CA</option>
        <option value='Kern'>Kern, CA</option>
        <option value='Ventura'>Ventura, CA</option>
        <option value='Santa Barbara'>Santa Barbara, CA</option>
        <option value='San Luis Obispo'>San Luis Obispo, CA</option>
        <option value='Imperial'>Imperial, CA</option>
        </select></td>
    
    
    <td class="rightmenubg" style="height:100%; min-width:250px;"><table border="0" cellspacing="0" cellpadding="5" width="100%">
      <tr>
        <td style="color:#999999;" nowrap>My Favorites</td>
        
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
    <td width="1%" class="leftmenu" valign="top"><table border="0" cellspacing="0" cellpadding="0" width="100%">
    
    
    <tr><td style="padding:10px; padding-bottom:0px;"><table width="100%"><tr><td style="background-color:#FFF;padding:5px 25px 5px 25px; border: 1px solid #CCC; " nowrap>Favorite: &nbsp;<a href="javascript:;" class='boldlink'>Place</a> &nbsp;&nbsp;|&nbsp;&nbsp;  <a href="javascript:;">Product</a>  &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:;">Event</a></td></tr></table></td></tr>
    
    
    <tr><td class="noncurrentcell favmenu" style="padding-right:0px; padding-left:0px;" valign="top">
    
    <div id="item_1" class="mainitem" style="border-top: 1px solid #CCCCCC;" onClick="updateFieldLayer('<?php echo base_url().'web/favorites/show_category/m/'.encrypt_value('shopping');?>', '', '', 'contentarea', '')">Shopping</div>
    	<div class="subcontainer" id="item_1_child" style="display:none;">
        <div class="submainitem">Clothes, Shoes and Outer Wear</div>
        <div class="submainitem" onClick="updateFieldLayer('<?php echo base_url().'web/favorites/show_category/m/'.encrypt_value('shopping').'/s/'.encrypt_value('electronics');?>', '', '', 'contentarea', '')">Electronics</div>
        <div class="submainitem">Cars, Trucks, Boats and more</div>
        <div class="submainitem">Real Estate</div>
        </div>
        
    <div id="item_2" class="mainitem selectedmain">Restaurants</div>
    	<div class="subcontainer" id="item_2_child" style="display:block;">
        <div class="submainitem">BBQ</div>
        <div class="submainitem selectedsubmain" onClick="updateFieldLayer('<?php echo base_url().'web/favorites/show_category/m/'.encrypt_value('restaurants').'/s/'.encrypt_value('american');?>', '', '', 'contentarea', '')">American</div>
        <div class="submainitem">Chinese</div>
        <div class="submainitem">Mexican</div>
        <div class="submainitem">Organic</div>
        </div>
    
    <div id="item_3" class="mainitem">Healthcare</div>
    <div id="item_4" class="mainitem">Sports</div>
    <div id="item_5" class="mainitem">Travel</div>
    <div id="item_6" class="mainitem">Services</div>
    <div id="item_7" class="mainitem">Transportation</div>
    <div id="item_8" class="mainitem">Other</div>
    
    </td></tr>
    </table></td>
    <td class="pagecontentarea" width="98%" style="padding:50px 15px 15px 15px;"><div id="contentarea"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="pagetitle">Add Favorites</td>
      </tr>
      <tr>
        <td class="pagesubtitle" style="padding-bottom:30px;">Get notified about special events, sales and promotions.</td>
      </tr>
      <tr>
        <td style="padding:0px;" valign="top"><table border="0" cellspacing="0" cellpadding="5" align="center"  class="sectiontable bluetop">
          <thead>
          <tr>
            <td>Restaurants  - <span class="greysectionheader">American</span></td>
          </tr>
          </thead>
          <tr>
            <td valign="top" style="padding-top:10px;padding-bottom:10px; border-bottom: 1px solid #DDD;"><input name="searchfavs" type="text" class="searchfield" id="searchfavs" value='' placeholder="Enter name or website address" style="font-size: 18px;width:500px;" /></td>
          </tr>
          
          
          
          <tr>
            <td valign="top" class="contentlistcell" style="background-color:#FFF;"><div class="contentlistdiv">
              <div class="contentitemdiv">Taco Bell</div>
              <div class="contentitemdiv">Imagine Foods</div>
              <div class="contentitemdiv">80's Burgers</div>
              <div class="contentitemdiv">80's Burgers</div>
            </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Taco Bell</div>
                <div class="contentitemdiv">Imagine Foods</div>
                <div class="contentitemdiv">80's Burgers And Friends</div>
                <div class="contentitemdiv">80's Burgers</div>
              </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Taco Bell</div>
                <div class="contentitemdiv">Imagine Foods</div>
                <div class="contentitemdiv">80's Burgers</div>
                <div class="contentitemdiv">80's Burgers</div>
              </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Taco Bell</div>
                <div class="contentitemdiv">Imagine Foods For Fido</div>
                <div class="contentitemdiv">80's Burgers</div>
                <div class="contentitemdiv">80's Burgers</div>
              </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Taco Bell</div>
                <div class="contentitemdiv">Imagine Foods</div>
                <div class="contentitemdiv">80's Burgers</div>
                <div class="contentitemdiv">80's Burgers</div>
              </div></td>
          </tr>
          
        </table></td>
      </tr>
    </table></div></td>
<td valign="top" class="rightmenubg" width="1%" >
<div id="filterspace" style="padding:15px;min-width:245px;">
<div class="label" style="padding-bottom:10px;">American Restaurants (8)</div>

<div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="favoriteicon">&nbsp;</div></td><td style="padding-left:5px;">Fave Dave</td><td style="padding-left:5px;" width="1%">&nbsp;</td></tr></table></div>


<div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="favoriteicon">&nbsp;</div></td><td style="padding-left:5px;">Five For Fighting</td><td style="padding-left:5px;" width="1%">&nbsp;</td></tr></table></div>


<div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="favoriteicon">&nbsp;</div></td><td style="padding-left:5px;">Mary Jane's</td><td style="padding-left:5px;" width="1%">&nbsp;</td></tr></table></div>


<div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="favoriteicon">&nbsp;</div></td><td style="padding-left:5px;">Lollipop</td><td style="padding-left:5px;" width="1%">&nbsp;</td></tr></table></div>


<div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="favoriteicon">&nbsp;</div></td><td style="padding-left:5px;">Pete's Joint</td><td style="padding-left:5px;" width="1%">&nbsp;</td></tr></table></div>


<div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="favoriteicon">&nbsp;</div></td><td style="padding-left:5px;">Burger John</td><td style="padding-left:5px;" width="1%">&nbsp;</td></tr></table></div>


<div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="favoriteicon">&nbsp;</div></td><td style="padding-left:5px;">Whatever Place</td><td style="padding-left:5px;" width="1%">&nbsp;</td></tr></table></div>


<div class="feedbox"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="favoriteicon">&nbsp;</div></td><td style="padding-left:5px;">Wow For You</td><td style="padding-left:5px;" width="1%">&nbsp;</td></tr></table></div>

</div>
</td>
  </tr>
</table>

    
    </td>
  </tr>
  <?php $this->load->view('web/addons/footer_normal');?>
</table>

</body>
</html>