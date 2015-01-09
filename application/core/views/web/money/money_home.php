<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Money";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
	

	<?php 
		echo get_ajax_constructor(TRUE);
	 
	    echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
 
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  if(!empty($_SESSION['user_type']) && $_SESSION['user_type'] == 'merchant')
  {
	  $this->load->view('web/addons/header_merchant', array('main'=>'money', 'sub'=>'Home', 'defaultHtml'=>''));
  }
  else
  {
  	 $this->load->view('web/addons/header_normal', array('main'=>'money', 'sub'=>'Home', 'defaultHtml'=>''));
  }?>
  <tr>
    <td class="normalpageheader" id='submenu_content' style="padding-left:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="0%" style="padding:0px;"><div class="bigscreendetails topleftheader">Money</div></td>
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
        <td valign="top" width="98%" style="padding:30px 15px 15px 15px;"><table width="100%" border="0" cellspacing="0" cellpadding="15" style="background-color:#FFF;">
  
  
  <tr>
        <td class="pagetitle">Your Money</td>
      </tr>
      <tr>
        <td class="pagesubtitle" style="padding-top:10px;">Your spending activity earns you cash!</td>
      </tr>
      <tr>
        <td valign="top" style="padding-top:0px;" align="center"><div class="contentdiv" style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greentop" style="width:580px;">
      <thead>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding:0px; border-bottom: 0px;">Account Summary</td>
    <td width="1%" style="border-bottom: 0px;"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/info_icon.png" border="0"></a></td>
  </tr>
</table>
</td>
          </tr>
        </thead>
      
      <tr>
        <td style="padding:0px;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="summarytable">
  <thead>
  <tr>
    <td>&nbsp;</td>
    <td>Earnings</td>
    <td>Withdrawals</td>
    <td>Pending</td>
    <td>Available</td>
  </tr>
  </thead>
  <tr>
    <td style="text-align:left;">Cash Back</td>
    <td>$1,456.35</td>
    <td>$1,456.35</td>
    <td>$1,456.35</td>
    <td style="border-right:0px;">$1,456.35</td>
  </tr>
  <tr>
    <td style="text-align:left;">Network</td>
    <td>$1,456.35</td>
    <td>$1,456.35</td>
    <td>$1,456.35</td>
    <td style="border-right:0px;">$1,456.35</td>
  </tr>
  <tfoot>
  <tr>
    <td style="text-align:left;">Total</td>
    <td>$1,456.35</td>
    <td>$1,456.35</td>
    <td>$1,456.35</td>
    <td style="border-right:0px;">$1,456.35</td>
  </tr>
  </tfoot>
</table>

          </td>
      </tr>
      
      
      <?php if(!(!empty($_SESSION['user_type']) && $_SESSION['user_type'] == 'merchant'))
	  {?>
      <tr><td height="10" style="background-color:#FFF;"></td></tr>
      
      <tr>
        <td class="sectionrow"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="1%"><input name="earningtype" id="cashback" type="radio" value="cashback" checked></td>
            <td style="text-align:left;">Cash Back</td>
            <td width="1%"><input name="earningtype" id="network" type="radio" value="network"></td>
            <td style="text-align:left;">Network</td>
            <td>&nbsp;</td>
            <td width="1%"><input name="searchearning" type="text" class="searchfield" id="searchearning" value='' placeholder="Enter the store name" style="font-size: 18px;width:300px;"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="sectioncontent">
  <tr>
    <td style="border-bottom: 1px solid #CCC;" colspan="2"><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="padding:0px;"><div class="greybg" style="width:20px; height:20px;">&nbsp;</div></td>
        <td style="cursor:pointer;">Pending</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="padding:0px;"><div class="greenbg" style="width:20px; height:20px;">&nbsp;</div></td>
        <td style="cursor:pointer;">Available</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td style="padding:0px;"><div class="bluebg" style="width:20px; height:20px;">&nbsp;</div></td>
        <td style="cursor:pointer;" nowrap>Lifetime Earnings <img src="<?php echo base_url()."assets/images/up_arrow_medium_grey.png";?>" border="0" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="width:180px;">1. Target</td>
    <td><div class="linediv greenbg" style="width:20%;">$279.90</div><div class="linediv bluebg" style="width:40%;">&nbsp;</div><div class="linediv bluebg" style="width:1px; padding-left:0px; margin-left:3px;">&nbsp;</div><div class="linediv bluebg" style="width:1px; padding-left:0px; margin-left:3px;">&nbsp;</div><div class="linediv"><span class="blue">$12,037,650.00</span></div></td>
  </tr>
  <tr>
    <td>2.    Morton's Steakhouse</td>
    <td><div class="linediv greenbg" style="width:18%;">$234.85</div><div class="linediv greybg" style="width:12%;">$15.40</div><div class="linediv bluebg" style="width:10%;">&nbsp;</div><div class="linediv"><span class="blue">$301.85</span></div></td>
  </tr>
  <tr>
    <td>3.    Nordstrom's</td>
    <td><div class="linediv greenbg" style="width:15%;">$123.45</div><div class="linediv greybg" style="width:15%;">$199.35</div><div class="linediv"><span class="blue">$322.80</span></div></td>
  </tr>
  <tr>
    <td>4.    Whole Foods</td>
    <td><div class="linediv greenbg" style="width:15%;">$123.50</div></td>
  </tr>
  <tr>
    <td>5.    W Hotel</td>
    <td><div class="linediv greenbg" style="width:10%;">$99.25</div></td>
  </tr>
  <tr>
    <td>6.    BMW Financial</td>
    <td><div class="linediv greenbg" style="width:8%;">$23.50</div></td>
  </tr>
  <tr>
    <td>7.    Gucci</td>
    <td><div class="linediv greenbg" style="width:8%;">$10.00</div></td>
  </tr>
  <tr>
    <td>8.    Uber</td>
    <td><div class="linediv greybg" style="width:8%;">$9.99</div></td>
  </tr>
  <tr>
    <td>9.    Mastro’s</td>
    <td><div class="linediv greybg" style="width:8%;">$5.00</div></td>
  </tr>
  <tr>
    <td>10.  Katana</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
  <tr>
    <td>11.  Air France</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
  <tr>
    <td>12.  KLM</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
  <tr>
    <td>13.  Virgin America</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
  <tr>
    <td>14.  Marriot</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
  <tr>
    <td>15.  The Peninsula Hotel..</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
  <tr>
    <td>16.  Katsuya</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
  <tr>
    <td>17.  Nate N' Al</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
  <tr>
    <td>18.  Coffee Bean</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
  <tr>
    <td>19.  Ralphs</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
  <tr>
    <td>20.  In N' Out</td>
    <td><div class="linediv greybg" style="width:8%;">$0.00</div></td>
  </tr>
</table>
</td>
      </tr>
      <?php }?>
        </table>
  </div><div  class="contentdiv"  style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable bluetop" style="width:580px;" align="center">
    <thead>
      <tr>
        <td>Linked Accounts</td>
        </tr>
      </thead>
    
    
    <tr>
      <td class="boldernotice" style="padding-top:5px; padding-bottom:0px;">Accounts that raise your score and earn cash back</td>
      </tr>
      <tr>
      <td><div class="curvedcorners"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>Bank of America</td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/checking_account_icon.png" border="0"></a></td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/credit_card_icon.png" border="0"></a></td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/debit_card_icon.png" border="0"></a></td>
    <td width="1%" style="padding-left:40px;"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/remove_icon.png" border="0"></a></td>
  </tr>
</table>
</div>


<div class="curvedcorners"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>Chase</td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/credit_card_icon.png" border="0"></a></td>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/debit_card_icon.png" border="0"></a></td>
    <td width="1%" style="padding-left:40px;"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/remove_icon.png" border="0"></a></td>
  </tr>
</table>
</div>


<div class="curvedcorners"><table width="100%" border="0" cellspacing="0" cellpadding="5">
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
      <td style="text-align:right; padding:5px 10px 15px 15px;"><input type="button" id="addaccount" name="addaccount" value="Add Linked Account" class="greenbtn"></td>
      </tr>
      <thead>
      <tr>
        <td style="border-top:solid 1px #DDD;">Payout Accounts</td>
      </tr>
      </thead>
      <tr>
      <td class="boldernotice" style="padding-top:5px; padding-bottom:0px;">Where we deposit your cashback rewards</td>
      </tr>
      <tr>
        <td><div class="curvedcorners"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/tick.png" border="0"></a></td>
    <td nowrap>Bank of America 5469 - Account Nickname</td>
    <td width="1%" style="padding-left:40px;"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/remove_icon.png" border="0"></a></td>
  </tr>
</table>
</div>


<div class="curvedcorners"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/tick_grey.png" border="0"></a></td>
    <td nowrap>Goldman Sachs 4318 - Account Nickname</td>
    <td width="1%" style="padding-left:40px;"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/remove_icon.png" border="0"></a></td>
  </tr>
</table>
</div>





</td>
      </tr>
      <tr>
      <td style="text-align:right; padding:5px 10px 15px 15px;" nowrap>
      <table align="right" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div id="transfer_funds_section"></div></td>
  </tr>
  <tr>
    <td><div id="transfer_funds_btn"><input type="button" id="transferfunds" name="transferfunds" value="Transfer Funds" class="bluebtn" onClick="updateFieldLayer('<?php echo base_url()."web/money/transfer_funds/a/".encrypt_value('start');?>','','','transfer_funds_section','');hideLayerSet('transfer_funds_btn')"></div></td>
    <td style="padding-left:20px; text-align:right;"><input type="button" id="addpayoutaccount" name="addpayoutaccount" value="Add Payout Account" class="greenbtn"></td>
  </tr>
</table>

      
      
      
      
      
      
       &nbsp; </td>
      </tr>
      <thead>
      <tr>
        <td style="border-top:solid 1px #DDD;">Funding Sources</td>
      </tr>
      </thead>
      <tr>
      <td  class="boldernotice" style="padding-top:5px; padding-bottom:0px;">Accounts you use to make purchases on Clout</td>
      </tr>
      <tr>
        <td><div class="curvedcorners"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/tick.png" border="0"></a></td>
    <td nowrap>Bank of America 5469 - Account Nickname</td>
    <td width="1%" style="padding-left:40px;"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/remove_icon.png" border="0"></a></td>
  </tr>
</table>
</div>


<div class="curvedcorners"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="1%"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/tick_grey.png" border="0"></a></td>
    <td nowrap>Goldman Sachs 4318 - Account Nickname</td>
    <td width="1%" style="padding-left:40px;"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/remove_icon.png" border="0"></a></td>
  </tr>
</table>
</div>





</td>
      </tr>
      <tr>
      <td style="text-align:right; padding:5px 10px 15px 15px;"><input type="button" id="addfundingsource" name="addfundingsource" value="Add Funding Source" class="greenbtn"></td>
      </tr>
    </table>
  </div></td>
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