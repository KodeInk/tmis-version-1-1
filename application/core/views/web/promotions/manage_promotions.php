<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Promotions";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
	

	<?php 
		echo get_ajax_constructor(TRUE);
	 
	    echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>

 <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
//Show the div when it is clicked
$(document).ready(function ($) {
	$(".selectorrow td:not(.ignorethese)").click(function () {
        var cellId = $(this).attr('id');
		//Remove the connecting div filler
		$(".editlayerconnector_selectedtab div").remove();
		//Remove the connecter formatting
		$("div").removeClass("editlayerconnector_selectedtab");
		
		//Add it to this cell's corresponding connector div
		$("#"+cellId+"_connecter div").addClass("editlayerconnector_selectedtab");
		
		//Now add the filler div to this connector
		$("#"+cellId+"_connecter div").html('<div style="position:relative; background-color:#FFF; height:15px;"></div>');
		//Now update the container cell class to give it the corresponding color
		$("#containercell").removeClass().addClass($(this).attr('class'));
		//remove this selected class from all tab sections
		$("div").removeClass("editlayer_selectedtab");
		$("#"+cellId+" div").addClass("editlayer_selectedtab");
	});
	
	
	
});

</script>


    <script src='<?php echo base_url();?>assets/js/switchbtns.js' type='text/javascript'></script>
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view('web/addons/header_merchant', array('main'=>'promotions', 'sub'=>'Home', 'defaultHtml'=>''));
   ?>
  <tr>
    <td class="normalpageheader" id='submenu_content' style="padding-left:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="0%" style="padding:0px;"><div class="bigscreendetails topleftheader">Promotions</div></td>
    <td width="2%" style="padding-bottom:15px; padding-left:0px;">&nbsp;</td>
    <td width="1%" style="padding-bottom:15px;">&nbsp;</td>
    <td width="80%" class="greytext" style="padding-bottom:15px; vertical-align:bottom; font-size:14px;">&nbsp;</td>
    <td class="whiteheadertitle" style="padding-bottom:0px; padding-right:20px;padding-left:20px;border-left: solid 1px #E0E0E0;" nowrap><span class="green">Total Network:</span> 199,248</td>
    <td class="whiteheadertitle" style="padding-bottom:0px; padding-right:15px; padding-left:20px; border-left: solid 1px #E0E0E0;" nowrap><span class="blue">Pending Invites:</span> 26,420</td>
    <td class="rightmenubg" style="height:100%;min-width:250px; border-left:0px;">
    <div style="margin-left:10px;"><?php echo format_notice('WARNING: <b>ACCOUNT DISABLED</b><br>Last billing failed. Please update your payment details.');?>
    </div>
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
      <td valign="top" class="pagecontentarea" width="99%" style="padding:0px;">
      
      
      
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="scoretable">
      <thead>
      <tr>
      <td class="blackbg" style="text-align:right; padding-right:10px;">Score</td>
      <td class="lightgreybg">0</td>
      <td class="lightgreenbg">100</td>
      <td class="greenbg">200</td>
      <td class="deepgreenbg">300</td>
      <td class="lightbluebg">400</td>
      <td class="bluebg">500</td>
      <td class="deeppurplebg">600</td>
      <td class="lightpurplebg">700</td>
      <td class="mediumgreybg">800</td>
      <td class="darkgreybg">900</td>
      <td class="blackbg">1000+</td>
      <td class="blackbg">&nbsp;</td>
      </tr>
      </thead>
      
      <tr>
      <td class="blackbg" style="text-align:right; padding-right:10px;">World</td>
      <td class="lightgreybg">8.6m</td>
      <td class="lightgreenbg">7.5m</td>
      <td class="greenbg">4.9m</td>
      <td class="deepgreenbg">4.6m</td>
      <td class="lightbluebg">7.5m</td>
      <td class="bluebg">4.5m</td>
      <td class="deeppurplebg">4.8m</td>
      <td class="lightpurplebg">4.0m</td>
      <td class="mediumgreybg">1.5m</td>
      <td class="darkgreybg">2.5m</td>
      <td class="blackbg">1.5m</td>
      <td class="blackbg">49.5m</td>
      </tr>
      
      <tr>
      <td class="blackbg" style="text-align:right; padding-right:10px; ">United States</td>
      <td class="lightgreybg">1.5m</td>
      <td class="lightgreenbg">6.7m</td>
      <td class="greenbg">1.2m</td>
      <td class="deepgreenbg">2.5m</td>
      <td class="lightbluebg">3.1m</td>
      <td class="bluebg">1.4m</td>
      <td class="deeppurplebg">3.9m</td>
      <td class="lightpurplebg">1.2m</td>
      <td class="mediumgreybg">3.6m</td>
      <td class="darkgreybg">4.5m</td>
      <td class="blackbg">1.0m</td>
      <td class="blackbg">32.3m</td>
      </tr>
      
      <tr class="thickbottom">
      <td class="blackbg" nowrap style="text-align:right; padding-right:10px;">10 miles</td>
      <td class="lightgreybg">94k</td>
      <td class="lightgreenbg">14k</td>
      <td class="greenbg">26k</td>
      <td class="deepgreenbg">10k</td>
      <td class="lightbluebg">95k</td>
      <td class="bluebg">36k</td>
      <td class="deeppurplebg">94k</td>
      <td class="lightpurplebg">83k</td>
      <td class="mediumgreybg">47k</td>
      <td class="darkgreybg">15k</td>
      <td class="blackbg">1k</td>
      <td class="blackbg">1.98m</td>
      </tr>
      
      <tr class="nobottom selectorrow">
      <td class="blackbg ignorethese" style="text-align:right; padding-right:10px;">Cash Back Reward</td>
      <td class="lightgreybg" id="col_1" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('0');?>','','','containerdiv','')"><div class="editlayer">0%</div></td>
      <td class="lightgreenbg" id="col_2" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('100');?>','','','containerdiv','')"><div class="editlayer">0%-10%</div></td>
      <td class="greenbg" id="col_3" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('200');?>','','','containerdiv','')"><div class="editlayer editlayer_selectedtab">5%-10%</div></td>
      <td class="deepgreenbg" id="col_4" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('300');?>','','','containerdiv','')"><div class="editlayer">5%-10%</div></td>
      <td class="lightbluebg" id="col_5" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('400');?>','','','containerdiv','')"><div class="editlayer">5%-15%</div></td>
      <td class="bluebg" id="col_6" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('500');?>','','','containerdiv','')"><div class="editlayer">5%-15%</div></td>
      <td class="deeppurplebg" id="col_7" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('600');?>','','','containerdiv','')"><div class="editlayer">5%-20%</div></td>
      <td class="lightpurplebg" id="col_8" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('700');?>','','','containerdiv','')"><div class="editlayer">5%-20%</div></td>
      <td class="mediumgreybg" id="col_9" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('800');?>','','','containerdiv','')"><div class="editlayer">10%-25%</div></td>
      <td class="darkgreybg" id="col_10" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('900');?>','','','containerdiv','')"><div class="editlayer">10%-25%</div></td>
      <td class="blackbg" id="col_11" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('1000');?>','','','containerdiv','')"><div class="editlayer">10%-40%</div></td>
      <td class="blackbg ignorethese">Avg = 7.4%</td>
      </tr>
      
      <tr class="connectorrow">
      <td></td>
      <td class="lightgreybg" id="col_1_connecter"><div class="editlayerconnector"></div></td>
      <td class="lightgreenbg" id="col_2_connecter"><div class="editlayerconnector"></div></td>
      <td class="greenbg" id="col_3_connecter"><div class="editlayerconnector editlayerconnector_selectedtab"><div style="position:relative; background-color:#FFF; height:15px;"></div></div></td>
      <td class="deepgreenbg" id="col_4_connecter"><div class="editlayerconnector"></div></td>
      <td class="lightbluebg" id="col_5_connecter"><div class="editlayerconnector"></div></td>
      <td class="bluebg" id="col_6_connecter"><div class="editlayerconnector"></div></td>
      <td class="deeppurplebg" id="col_7_connecter"><div class="editlayerconnector"></div></td>
      <td class="lightpurplebg" id="col_8_connecter"><div class="editlayerconnector"></div></td>
      <td class="mediumgreybg" id="col_9_connecter"><div class="editlayerconnector"></div></td>
      <td class="darkgreybg" id="col_10_connecter"><div class="editlayerconnector"></div></td>
      <td class="blackbg" id="col_11_connecter"><div class="editlayerconnector"></div></td>
      <td></td>
      </tr>
      
      <tr class="notop">
      <td colspan="13" valign="top" id="containercell" class="greenbg" style="border-top: 0px;padding:0px;"><div id="containerdiv" class="contentlayer" style="padding:0px;">
        <div id="offer_001" class="bottombordergrey" style="padding:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="3%"><table border="0" cellspacing="0" cellpadding="2" class="rewardcardbig greenbg" style="width:90px;" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/edit_offer/i/".encrypt_value('001');?>','','','containerdiv','')">
  <tr>
    <td class="toprow"></td>
  </tr>
  <tr>
    <td class="editbottomrow" nowrap>5%</td>
  </tr>
</table></td>
    <td align="left" class="pagesubtitle" style="padding-top:5px; text-align:left;">Cash Back <a href="javascript:;" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/edit_offer/i/".encrypt_value('001');?>','','','containerdiv','')">edit</a><br>
<span class="opensansmedium">200+ points</span></td>
    <td width="3%" align="center" class="opensanslarge" style="min-width:200px;" nowrap>$14,021 gross sales <br>during 21 days active</td>
    <td width="1%" class="opensanslarge" style="min-width:90px;"><span class="green">active</span></td>
    <td width="1%" style="min-width:100px;"><input type="button" name="pausebtn" id="pausebtn" value="Pause" class="forrestgreenbtn" style="width:100px;"></td>
    <td width="1%" class="leftmenuitem">&nbsp;</td>
  </tr>
</table>

        </div>
        
        
        
        <div id="offer_002" class="bottombordergrey" style="padding:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="3%"><table border="0" cellspacing="0" cellpadding="2" class="rewardcardbig greenbg" style="width:90px;">
  <tr>
    <td class="toprow"><div style="position:relative; margin-top:-15px; margin-right:-8px; float:right;" title="This promotion is not yet published."><img src="<?php echo base_url();?>assets/images/warning_small.png"></div></td>
  </tr>
  <tr>
    <td class="editbottomrow" nowrap>10%</td>
  </tr>
</table></td>
    <td align="left" class="pagesubtitle" style="padding-top:5px; text-align:left;">Cash Back <a href="javascript:;">edit</a><br>
<span class="opensansmedium">Mon-Wed all day. Thur-Sun 10am-4pm. On all purchases</span></td>
    <td align="center" class="opensanslarge" style="min-width:200px;" width="3%" nowrap>$402 gross sales <br>
      during 1 day active</td>
    <td width="1%" class="opensanslarge" style="min-width:90px;"><span class="red">inactive</span></td>
    <td width="1%" style="min-width:100px;"><input type="button" name="publishbtn" id="publishbtn" value="Publish" class="bluebtn" style="width:100px;"></td>
    <td width="1%" class="leftmenuitem">&nbsp;</td>
  </tr>
</table>

        </div>
        
        
        
        
        
        <div id="offer_003" class="bottombordergrey" style="padding:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="3%"><table border="0" cellspacing="0" cellpadding="2" class="rewardcardbig greenbg" style="width:90px;">
  <tr>
    <td class="toprow"><div style="position:relative; margin-top:-15px; margin-right:-8px; float:right;" title="This promotion is not yet published."><img src="<?php echo base_url();?>assets/images/warning_small.png"></div></td>
  </tr>
  <tr>
    <td class="editbottomrow" nowrap>10%</td>
  </tr>
</table></td>
    <td align="left" class="pagesubtitle" style="padding-top:5px; text-align:left;">Cash Back <a href="javascript:;">edit</a><br>
<span class="opensansmedium">When you spend $100+. On all purchases.</span></td>
    <td align="center" class="opensanslarge" style="min-width:200px;" width="3%" nowrap>$802 gross sales <br>
      during 3 days active</td>
    <td width="1%" class="opensanslarge" style="min-width:90px;"><span class="red">inactive</span></td>
    <td width="1%" style="min-width:100px;"><input type="button" name="publishbtn" id="publishbtn" value="Publish" class="bluebtn" style="width:100px;"></td>
    <td width="1%" class="leftmenuitem">&nbsp;</td>
  </tr>
</table>

        </div>
        
        
        
        
        
        <div id="offer_005" class="bottombordergrey" style="padding:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="3%"><table border="0" cellspacing="0" cellpadding="2" class="perkcardbig" style="width:90px;">
  <tr>
    <td class="toprow"></td>
  </tr>
  <tr>
    <td class="bottomrow" nowrap>Perk</td>
  </tr>
</table></td>
    <td align="left" class="pagesubtitle" style="padding-top:5px; text-align:left;">VIP Entrance <a href="javascript:;">edit</a><br>
<span class="opensansmedium">No cover charge and skip the line. Upto 5 guests.</span></td>
    <td align="center" class="opensanslarge" style="min-width:200px;" width="3%" nowrap>21 customers <br>
      during 3 days active</td>
    <td width="1%" class="opensanslarge" style="min-width:90px;"><span class="grey">pending</span></td>
    <td width="1%" style="min-width:100px;">&nbsp;</td>
    <td width="1%" class="leftmenuitem">&nbsp;</td>
  </tr>
</table>

        </div>
        
        
        
        
        <div id="offer_new_offer" class="bottombordergrey" style="padding:10px; cursor:pointer;" onClick="unhideShowLayer('offer_new_offer_edit','offer_new_offer')"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="3%"><table border="0" cellspacing="0" cellpadding="2" class="offercardbig" style="width:90px;">
  <tr>
    <td class="toprow"></td>
  </tr>
  <tr>
    <td style="height:5px;"></td>
  </tr>
  <tr>
    <td class="bottomrow" nowrap>?%</td>
  </tr>
</table></td>
    <td align="left" class="pagesubtitle" style="padding-top:5px; text-align:left;">Create a new Cash Back Offer!</td>
    <td width="1%" class="opensanslarge" style="min-width:90px;">&nbsp;</td>
    <td width="1%" style="min-width:100px;"><input type="button" name="publishbtn" id="publishbtn" value="Add New" class="greenbtn" style="width:100px;"></td>
    <td width="1%" class="leftmenuitem">&nbsp;</td>
  </tr>
</table>

        </div>
        
        <div id="offer_new_offer_edit" class="bottombordergrey" style="padding:10px;display:none;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="3%"><table border="0" cellspacing="0" cellpadding="2" class="offercardbig" style="width:90px;">
  <tr>
    <td class="toprow"><div style="position:relative; margin-top:-15px; margin-right:-8px; float:right;" title="This promotion is not yet published."><img src="<?php echo base_url();?>assets/images/warning_small.png"></div></td>
  </tr>
  <tr>
    <td style="height:5px;"></td>
  </tr>
  <tr>
    <td class="bottomrow" nowrap>?%</td>
  </tr>
</table></td>
    <td align="left" valign="top" class="pagesubtitle" style="padding-top:5px; text-align:left;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><input type="text" name="newcashback" id="newcashback" value="" class="textfield" placeholder="0" style="width:50px;" onKeyUp="makeButtonActive('newcashback', 'savecashbackbtn', 'greybtn', 'greenbtn')"></td>
        <td>% Cash Back</td>
      </tr>
      <tr>
        <td colspan="2" class="opensansmedium"><a href="javascript:;">edit</a> to add restrictions to your offer.</td>
        </tr>
    </table></td>
    <td width="1%" style="min-width:90px;">&nbsp;</td>
    <td width="1%" style="min-width:100px;"><input type="button" name="savecashbackbtn" id="savecashbackbtn" value="Save" class="greybtn" style="width:100px;"></td>
    <td width="1%" class="leftmenuitem">&nbsp;</td>
  </tr>
</table>

        </div>
        
        
        
        
        <div id="offer_new_perk" class="bottombordergrey" style="padding:10px; cursor:pointer;" onClick="unhideShowLayer('offer_new_perk_edit','offer_new_perk')"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="3%"><table border="0" cellspacing="0" cellpadding="2" class="offercardbig" style="width:90px;">
  <tr>
    <td class="toprow"></td>
  </tr>
  <tr>
    <td style="height:5px;"></td>
  </tr>
  <tr>
    <td class="bottomrow" nowrap>Perk?</td>
  </tr>
</table></td>
    <td align="left" class="pagesubtitle" style="padding-top:5px; text-align:left;">Create a new Perk!</td>
    <td width="1%" class="opensanslarge" style="min-width:90px;">&nbsp;</td>
    <td width="1%" style="min-width:100px;"><input type="button" name="publishbtn" id="publishbtn" value="Add New" class="greenbtn" style="width:100px;"></td>
    <td width="1%" class="leftmenuitem">&nbsp;</td>
  </tr>
</table>

        </div>
        
        
        
        
        <div id="offer_new_perk_edit" class="bottombordergrey" style="padding:10px;display:none;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="3%" valign="top"><table border="0" cellspacing="0" cellpadding="2" class="offercardbig" style="width:90px;">
  <tr>
    <td class="toprow"><div style="position:relative; margin-top:-15px; margin-right:-8px; float:right;" title="This promotion is not yet published."><img src="<?php echo base_url();?>assets/images/warning_small.png"></div></td>
  </tr>
  <tr>
    <td style="height:5px;"></td>
  </tr>
  <tr>
    <td class="bottomrow" nowrap>Perk?</td>
  </tr>
</table></td>
    <td align="left" valign="top" class="pagesubtitle" style="padding-top:5px; text-align:left;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" nowrap><input type="text" name="perktitle" id="perktitle" value="" class="textfield" placeholder="Perk Title (e.g., VIP Entrance)" style="width:350px;" onKeyUp="makeButtonActive('perktitle<>perkdescription', 'saveperkbtn', 'greybtn', 'greenbtn')"></td>
        <td class="opensansmedium" style="padding-left:5px;"><a href="javascript:;">edit</a> to add restrictions to your offer.</td>
      </tr>
      <tr>
        <td valign="top" style="padding-top:8px;"><textarea class="textfield" name="perkdescription" id="perkdescription" onKeyUp="makeButtonActive('perktitle<>perkdescription', 'saveperkbtn', 'greybtn', 'greenbtn')" style="width:350px; min-height:80px; font-family:Arial, Helvetica, sans-serif;" placeholder="Perk Description (e.g., Free VIP entrance and complimentary first round of drinks. Advance reservations recommended.)"></textarea></td>
        <td class="opensansmedium" style="padding-left:5px;" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td width="1%"><input type="radio" name="reservationrequirements[]" id="checkin_on_arrival" value="checkin_on_arrival" checked></td><td>Check in on arrival</td></tr>
        <tr><td width="1%"><input type="radio" name="reservationrequirements[]" id="reservation_required" value="reservation_required"></td><td>Reservation required</td></tr>
        </table>
        </td>
        </tr>
    </table></td>
    <td width="1%" class="opensanslarge" style="min-width:90px;">&nbsp;</td>
    <td width="1%" style="min-width:100px;" valign="top"><input type="button" name="saveperkbtn" id="saveperkbtn" value="Save" class="greybtn" style="width:100px;"></td>
    <td width="1%" class="leftmenuitem">&nbsp;</td>
  </tr>
</table>

        </div>
        
        
        
        
        
        
        
      </div>
      </td>
      </tr>
      
      
      </table>
      
      
      
      
      </td>
        <td width="1%" valign="top" style="height:100vh">
        <div style="padding:15px;min-width:245px;max-width:245px;">
        
        <div style="padding-bottom:15px;">
        <table border="0" cellspacing="0" cellpadding="10" class="showtable" width="100%">
        <thead>
        <tr><td>Status</td></tr>
        </thead>
        
        <tr>
        <td><span style="font-weight:bold;">Cash Back Rewards</span><br>
        <span>3 Active, 5 Inactive, 2 Pending</span><br><br>
        <span style="font-weight:bold;">Perks</span><br>
        <span>1 Active, 8 Inactive, 1 Pending</span>
        </td>
        </tr>
        </table>
        </div>
        
        
        <div style="padding-bottom:15px;">
        <table border="0" cellspacing="0" cellpadding="10" class="showtable" width="100%">
        <thead>
        <tr><td>Cash Back Funding Source</td></tr>
        </thead>
        
        
        <tr>
        <td><div id='account_001'>
        <table border="0" cellspacing="0" cellpadding="0" width="100%"><tr>
        <td><img src="<?php echo base_url();?>assets/images/checking_account_icon.png"></td><td>Bank of America 5469<br><span style="color:#999;">BoU Checking A/C</span>
</td><td valign="top"><a href="javascript:;" class="bluebold">edit</a></td>
        </tr>
        </table>
        </div>
        </td>
        </tr>
        <tr>
          <td>Cash Back rewards and our fees (if any) are automatically charged to your account when the customer makes a purchase at your business.  Our complete fee schedule <a href="javascript:;" class="bluebold">is here</a>. </td>
        </tr>
        </table>
        </div>
        
        
        
        <div style="padding-bottom:15px;">
        <table border="0" cellspacing="0" cellpadding="10" class="showtable" width="100%">
        <thead>
        <tr>
          <td>Customer Messaging <span style="font-size:12px;color:#999;">(Optional)</span></td></tr>
        </thead>
        
        
        <tr>
        <td>
        <table border="0" cellspacing="0" cellpadding="3" width="100%">
        <tr>
        <td>System Message Delivery</td>
        <td valign="top"><div class="switchcontainer" id="system_msg"><div class="onbtn" id="system_msg_on" style="display:block;">ON</div><div class="offbtn" id="system_msg_off" style="display:none;">OFF</div></div><input type="hidden" id="system_msg_value" name="system_msg_value" value="ON"></td>
        </tr>
        <tr>
        <td>Email Delivery</td>
        <td valign="top"><div class="switchcontainer" id="email_delivery"><div class="onbtn" id="email_delivery_on" style="display:none;">ON</div><div class="offbtn" id="email_delivery_off" style="display:block;">OFF</div></div><input type="hidden" id="email_delivery_value" name="email_delivery_value" value="OFF"></td>
        </tr>
        <tr>
        <td>Text Message Delivery</td>
        <td valign="top"><div class="switchcontainer" id="text_msg"><div class="onbtn" id="text_msg_on" style="display:none;">ON</div><div class="offbtn" id="text_msg_off" style="display:block;">OFF</div></div><input type="hidden" id="text_msg_value" name="text_msg_value" value="OFF"></td>
        </tr>
        </table>
        </td>
        </tr>
        
        
        <tr>
        <td class="showtablesubhead">Send When:</td>
        </tr>
        <tr>
        <td>
        <table border="0" cellspacing="0" cellpadding="3" width="100%">
        <tr>
        <td><input type="checkbox" id="publish_new_offer" name="publish_new_offer" value="publish_new_offer"></td>
        <td>When you publish a new offer</td>
        </tr>
        
        <tr>
        <td><input type="checkbox" id="customer_is_near" name="customer_is_near" value="customer_is_near"></td>
        <td>customer is near your location</td>
        </tr>
        
        <tr>
        <td valign="top"><input type="checkbox" id="at_competitor" name="at_competitor" value="at_competitor"></td>
        <td>Customer is searching/shopping/visiting a competing business</td>
        </tr>
        
        </table>
        </td>
        </tr>
        
        
        <tr>
        <td>
        <table border="0" cellspacing="0" cellpadding="3" width="100%">
        <tr>
        <td>Set cost limit</td><td width="1%"><div class="switchcontainer" id="cost_limit" onClick="showSwitchDivs('cost_limit_value','cost_limit_label<>cost_limit_field','cost_limit_label<>cost_limit_field')"><div class="onbtn" id="cost_limit_on" style="display:block;">ON</div><div class="offbtn" id="cost_limit_off" style="display:none;">OFF</div></div><input type="hidden" id="cost_limit_value" name="cost_limit_value" value="ON"></td>
        </tr>
        <tr>
        <td><div id="cost_limit_label">Stop if monthly costs exceed:</div></td><td nowrap><div id="cost_limit_field">$ <input type="text" id="monthly_value" name="monthly_value" class="textfield" value="" style="width:52px;padding:3px;"></div></td>
        </tr>
        </table>
        
        
        </td>
        </tr>
        
        
        <tr>
        <td style="padding:5px 10px 5px 10px;border-bottom:0px;"><table border="0" cellspacing="0" cellpadding="0" width="100%"  onClick="toggleLayer('delivery_costs_info', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_single_light_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_single_light_grey.png\'>', 'delivery_arrow_btn', '', '', '')"  style="cursor:pointer;">
        <tr><td width="99%">Delivery Costs</td><td width="1%" id="delivery_arrow_btn"><img src="<?php echo base_url();?>assets/images/up_arrow_single_light_grey.png" border="0"></td></tr>
        </table>
        </td>
        </tr>
        <tr>
        <td style="padding:0px;">
        <div id="delivery_costs_info" style="border-top: solid 1px #CCC;">
      
      	<table border="0" cellspacing="0" cellpadding="0" width="100%" style="text-align:center;">
      	<tr>
        <td style="padding-top:8px;">per system message</td>
        </tr>
        <tr>
        <td><table width="100%" class="smalltablelabel">
        <tr><td class="lightgreybg">2&cent;</td><td class="lightgreenbg">2&cent;</td><td class="greenbg">2&cent;</td><td class="deepgreenbg">5&cent;</td><td class="lightbluebg">7&cent;</td><td class="bluebg">10&cent;</td><td class="deeppurplebg">15&cent;</td><td class="lightpurplebg">20&cent;</td><td class="mediumgreybg">25&cent;</td><td class="darkgreybg" style="color:#FFF;">40&cent;</td><td class="blackbg" style="color:#FFF;">50&cent;</td></tr>
        </table></td>
        </tr>
        
        
        <tr>
        <td style="padding-top:8px;">per email</td>
        </tr>
        <tr>
        <td><table width="100%" class="smalltablelabel">
        <tr><td class="lightgreybg">2&cent;</td><td class="lightgreenbg">2&cent;</td><td class="greenbg">2&cent;</td><td class="deepgreenbg">5&cent;</td><td class="lightbluebg">7&cent;</td><td class="bluebg">10&cent;</td><td class="deeppurplebg">15&cent;</td><td class="lightpurplebg">20&cent;</td><td class="mediumgreybg">25&cent;</td><td class="darkgreybg" style="color:#FFF;">40&cent;</td><td class="blackbg" style="color:#FFF;">50&cent;</td></tr>
        </table></td>
        </tr>
        
        
        <tr>
        <td style="padding-top:8px;">per text message</td>
        </tr>
        <tr>
        <td><table width="100%" class="smalltablelabel">
        <tr><td class="lightgreybg">2&cent;</td><td class="lightgreenbg">2&cent;</td><td class="greenbg">2&cent;</td><td class="deepgreenbg">5&cent;</td><td class="lightbluebg">7&cent;</td><td class="bluebg">10&cent;</td><td class="deeppurplebg">15&cent;</td><td class="lightpurplebg">20&cent;</td><td class="mediumgreybg">25&cent;</td><td class="darkgreybg" style="color:#FFF;">40&cent;</td><td class="blackbg" style="color:#FFF;">50&cent;</td></tr>
        </table></td>
        </tr>
        
        
        </table>
        </div>
        </td>
        </tr>
        
        
        </table>
        </div>
        
        
        
        
        
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