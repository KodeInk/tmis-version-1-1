<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Search";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
	

	<?php 
		echo get_ajax_constructor(TRUE);
	 
	    echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
      
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ui.css">
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

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data1 = google.visualization.arrayToDataTable([
          ['Clout', 'Score'],
          ['',  597],
          ['',  303]
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
<script>
$(function() {
	$(".favrow").hover(function(){
		$(this).find("div").show('fast');
	}, function(){
		$(this).find("div").hide('fast');
	});
	
	//Make the store map frame the same height as the window scroll height
	$('#store_map_frame').height($(document).height());

});
</script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
   $('.fancybox').fancybox();
});
</script>

</head>
<body style="margin:0px;">    <?php
    if(!empty($showMap) && $showMap)
	{ 
	?>
	<iframe id="store_map_frame" frameborder="0" scrolling="no" width="100%" src="<?php echo base_url()."web/search/show_store_map";?>"></iframe> 
	<?php 
	} else {
	?>
    <div id="deal_home_content"><table width="100%" border="0" cellspacing="0" cellpadding="15">
  <tr>
    <td class="pagetitle">Mariscos Jalisco</td>
    
  </tr>
  <tr>
    <td>
    <table border="0" cellspacing="0" cellpadding="5" align="center">
    <tr><td class="pagesubtitle" style="padding-top:5px;" nowrap>310-555-5100 &nbsp;&nbsp;&nbsp; www.mariscosjalisco.com &nbsp;&nbsp;&nbsp; Mexican Food - $$</td></tr>
    <tr><td class="pagesubtitle greytext" style="border-top: 2px solid #B0B0B0; padding-top:5px;"><a href="javascript:;" onClick="scrollToAnchor('business_details_anchor')">Business Details</a> &nbsp;&nbsp;&nbsp; <a href="javascript:;"  onClick="scrollToAnchor('photos_anchor')">Photos</a> &nbsp;&nbsp;&nbsp; <a href="javascript:;" onClick="scrollToAnchor('offers_anchor')">Offers</a> &nbsp;&nbsp;&nbsp; <a href="javascript:;"  onClick="scrollToAnchor('store_score_anchor')">Store Score</a> </td></tr>
    </table>
    
    </td>
    </tr>
  <tr>
    <td style="padding:0px;" valign="top"><table align="center"><tr><td valign="top">
    
    <div id="business_details_div" class="contentdiv" style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greytop" style="width:580px;">
      <thead>
        <tr>
          <td><a name="business_details_anchor"></a>Business Details</td>
          </tr>
        </thead>
      
      <tr>
          <td height="2"></td>
      </tr>
      <tr>
          <td class="sectionsubtitle"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
          <td width="1%"><img src="<?php echo base_url()."assets/images/map_marker_small.png";?>" border="0" /></td><td width="98%" style="padding-left:15px;">3040 E Olympic Blvd, Los Angeles, CA 90023</td><td width="1%"><a href="javascript:;" onClick="newPopup('<?php echo base_url()."web/page/map_to_location/a/".encrypt_value('3040 E Olympic Blvd, Los Angeles, CA 90023');?>','700','500')">Map</a></td>
          </tr></table></td>
      </tr>
      <tr>
          <td height="5"></td>
      </tr>
      <tr>
      <td style="padding:0px;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
          <td width="1%" valign="top" style="padding:5px; padding-left:15px;background-color:#FFF;"><img src="<?php echo base_url()."assets/images/comment_icon.png";?>" border="0" /></td>
          <td width="49%" valign="top" class="subsectiontitle" style="padding-left:15px;padding-top:0px;background-color:#FFF;text-align:left;">Mariscos Jalisco is a mexican restaurant chain that originated from a taco stand in the 1908. Try our food Today!</td>
          <td width="0%" valign="top" style="padding-left:10px;">&nbsp;</td>
          <td width="1%" valign="top" style="background-color:#FFF;padding:5px; padding-right:10px;"><img src="<?php echo base_url()."assets/images/time_icon.png";?>" border="0" /></td>
          <td width="49%" style="text-align:left;background-color:#FFF;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	<tr><td align="right" width="1%">Mon</td><td width="98%" style="padding-left:10px;">9:00am - 5:00pm</td></tr>
            <tr><td align="right">Tue</td><td style="padding-left:10px;">9:00am - 5:00pm</td></tr>
            <tr><td align="right">Wed</td><td style="padding-left:10px;">9:00am - 5:00pm</td></tr>
            <tr><td align="right">Thu</td><td style="padding-left:10px;">9:00am - 5:00pm</td></tr>
            <tr><td align="right">Fri</td><td style="padding-left:10px;">9:00am - 5:00pm</td></tr>
            <tr><td align="right">Sat</td><td style="padding-left:10px;">9:00am - 8:00pm</td></tr>
            <tr><td align="right">Sun</td><td style="padding-left:10px;">Closed</td></tr>
          </table>
          </td>
          </tr></table>
      </td>
      </tr>
      <tr>
          <td height="5"></td>
      </tr>
      <tr><td style="background-color:#FFF;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
          <td width="1%" valign="top" style="padding-left:15px;"><img src="<?php echo base_url()."assets/images/tick.png";?>" border="0" /></td><td width="99%" style="padding-left:15px; text-align:left;">Tacos, Mexican, Seafood, Food Stands, Outdoor Seating, Open Late, Full Bar, Sports Bar, Wi-Fi, Delivery, Take-out, Casual, Alchohol</td>
          </tr></table>
      </td></tr>
      <tr>
          <td height="2"></td>
      </tr>
    </table>
    </div>
    
    
    
    
    
    <div id="photos_div" class="contentdiv" style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greytop" style="width:580px;">
      <thead>
        <tr>
          <td><a name="photos_anchor"></a>Photos (27)<div class="arrowwithtail" style="display:inline-block; float:right;">More</div></td>
          </tr>
        </thead>
      
      <tr><td><div class="highlightbox"><a href="<?php echo base_url()."web/page/view_image_details/u/".encrypt_value('sample_store_image_large_001.jpg');?>" class="fancybox fancybox.ajax"><img src="<?php echo base_url()."assets/images/sample_store_image_001.jpg";?>" border="0" style="margin:5px 5px 1px 5px;"/></a></div>
      <div class="highlightbox"><a href="<?php echo base_url()."web/page/view_image_details/u/".encrypt_value('sample_store_image_large_002.jpg');?>" class="fancybox fancybox.ajax"><img src="<?php echo base_url()."assets/images/sample_store_image_002.jpg";?>" border="0" style="margin:5px 5px 1px 5px;"/></a></div>
      <div class="highlightbox"><a href="<?php echo base_url()."web/page/view_image_details/u/".encrypt_value('sample_store_image_large_003.jpg');?>" class="fancybox fancybox.ajax"><img src="<?php echo base_url()."assets/images/sample_store_image_003.jpg";?>" border="0" style="margin:5px 5px 1px 5px;"/></a></div>
      <div class="highlightbox"><a href="<?php echo base_url()."web/page/view_image_details/u/".encrypt_value('sample_store_image_large_004.jpg');?>" class="fancybox fancybox.ajax"><img src="<?php echo base_url()."assets/images/sample_store_image_004.jpg";?>" border="0" style="margin:5px 5px 1px 5px;"/></a></div>
      <div class="highlightbox"><a href="<?php echo base_url()."web/page/view_image_details/u/".encrypt_value('sample_store_image_large_005.jpg');?>" class="fancybox fancybox.ajax"><img src="<?php echo base_url()."assets/images/sample_store_image_005.jpg";?>" border="0" style="margin:5px 5px 1px 5px;"/></a></div>
      <div class="highlightbox"><a href="<?php echo base_url()."web/page/view_image_details/u/".encrypt_value('sample_store_image_large_006.jpg');?>" class="fancybox fancybox.ajax"><img src="<?php echo base_url()."assets/images/sample_store_image_006.jpg";?>" border="0" style="margin:5px 5px 1px 5px;"/></a></div></td></tr>
    </table>
    </div>
    
    
    <div id="offers_div" class="contentdiv" style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greytop" style="width:580px;">
      <thead>
        <tr>
          <td><a name="offers_anchor"></a>Your Offers</td>
          </tr>
        </thead>
      <tr>
        <td style="padding:10px;" nowrap><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" id="tabtable" class="tabtable">
            <tr>
              <td id="level_0_top" style="border-top: 4px solid #CCCCCC;"  onClick="hideTabsAndDisplayThis('level_0_tab')" onMouseOver="hideTabsAndDisplayBg('level_0')"><div id="level_0_tab" class="innertablayer" style="background-color:#CCCCCC; display:none;" title="level 0 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>0</td></tr>
              <tr><td>0%</td></tr>
              </table></div>0</td>
              <td id="level_1_top" style="border-top: 4px solid #56D42B;"  onClick="hideTabsAndDisplayThis('level_1_tab')" onMouseOver="hideTabsAndDisplayBg('level_1')"><div id="level_1_tab" class="innertablayer" style="background-color:#56D42B; display:none;" title="level 1 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>100</td></tr>
              <tr><td>0%</td></tr>
              </table></div>100</td>
              <td id="level_2_top" style="border-top: 4px solid #18C93E;"  onClick="hideTabsAndDisplayThis('level_2_tab')" onMouseOver="hideTabsAndDisplayBg('level_2')"><div id="level_2_tab" class="innertablayer" style="background-color:#18C93E; display:none;" title="level 2 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>200</td></tr>
              <tr><td>0%</td></tr>
              </table></div>200</td>
              <td id="level_3_top" style="border-top: 4px solid #0AC298;"  onClick="hideTabsAndDisplayThis('level_3_tab')" onMouseOver="hideTabsAndDisplayBg('level_3')"><div id="level_3_tab" class="innertablayer" style="background-color:#0AC298; display:none;" title="level 3 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>300</td></tr>
              <tr><td>0%</td></tr>
              </table></div>300</td>
              <td id="level_4_top" style="border-top: 4px solid #03BFCD;"  onClick="hideTabsAndDisplayThis('level_4_tab')" onMouseOver="hideTabsAndDisplayBg('level_4')"><div id="level_4_tab" class="innertablayer" style="background-color:#03BFCD; display:none;" title="level 4 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>400</td></tr>
              <tr><td>5%</td></tr>
              </table></div>400</td>
              <td id="level_5_top" style="border-top: 4px solid #2DA0D1;background-color:#2DA0D1;" onClick="hideTabsAndDisplayThis('level_5_tab')" onMouseOver="hideTabsAndDisplayBg('level_5')"><div id="level_5_tab" class="innertablayer" style="background-color:#2DA0D1;" title="level 5 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>567</td></tr>
              <tr><td>5-10%</td></tr>
              </table></div>
              567</td>
              
              <td id="level_6_top" onClick="hideTabsAndDisplayThis('level_6_tab')" onMouseOver="hideTabsAndDisplayBg('level_6')" style="border-top: 4px solid #6D76B5;"><div id="level_6_tab" class="innertablayer" style="background-color:#6D76B5; display:none;" title="level 6 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>600</td></tr>
              <tr><td>5-10%</td></tr>
              </table></div>600</td>
              <td id="level_7_top" style="border-top: 4px solid #8566AB;"  onClick="hideTabsAndDisplayThis('level_7_tab')" onMouseOver="hideTabsAndDisplayBg('level_7')"><div id="level_7_tab" class="innertablayer" style="background-color:#8566AB; display:none;" title="level 7 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>700</td></tr>
              <tr><td>10-15%</td></tr>
              </table></div>700</td>
              <td id="level_8_top" style="border-top: 4px solid #999999;"  onClick="hideTabsAndDisplayThis('level_8_tab')" onMouseOver="hideTabsAndDisplayBg('level_8')"><div id="level_8_tab" class="innertablayer" style="background-color:#999999; display:none;" title="level 8 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>800</td></tr>
              <tr><td>10-25%</td></tr>
              </table></div>800</td>
              <td id="level_9_top" style="border-top: 4px solid #666666;"  onClick="hideTabsAndDisplayThis('level_9_tab')" onMouseOver="hideTabsAndDisplayBg('level_9')"><div id="level_9_tab" class="innertablayer" style="background-color:#666666; display:none;" title="level 9 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>900</td></tr>
              <tr><td>10-30%</td></tr>
              </table></div>900</td>
              <td id="level_10_top" style="border-top: 4px solid #333333;"  onClick="hideTabsAndDisplayThis('level_10_tab')" onMouseOver="hideTabsAndDisplayBg('level_10')"><div id="level_10_tab" class="innertablayer" style="background-color:#333333; display:none;" title="level 10 Offers"><table border="0" cellspacing="0" cellpadding="0" align="center" class="innertabtable">
              <tr><td class='toprow'>1000+</td></tr>
              <tr><td>10-40%</td></tr>
              </table></div>1000+</td>
            </tr>
            <tr>
              <td id="level_0_bottom"  onClick="hideTabsAndDisplayThis('level_0_tab')" onMouseOver="hideTabsAndDisplayBg('level_0')">0%<input name="currentlevelvalue" id="currentlevelvalue" type="hidden" value="level_5"></td>
              <td id="level_1_bottom"  onClick="hideTabsAndDisplayThis('level_1_tab')" onMouseOver="hideTabsAndDisplayBg('level_1')">0%</td>
              <td id="level_2_bottom"  onClick="hideTabsAndDisplayThis('level_2_tab')" onMouseOver="hideTabsAndDisplayBg('level_2')">0%</td>
              <td id="level_3_bottom"  onClick="hideTabsAndDisplayThis('level_3_tab')" onMouseOver="hideTabsAndDisplayBg('level_3')">0%</td>
              <td id="level_4_bottom"  onClick="hideTabsAndDisplayThis('level_4_tab')" onMouseOver="hideTabsAndDisplayBg('level_4')">5%</td>
              <td id="level_5_bottom"  onClick="hideTabsAndDisplayThis('level_5_tab')" onMouseOver="hideTabsAndDisplayBg('level_5')" style="background-color:#2DA0D1;">5-10%</td>
              <td id="level_6_bottom"  onClick="hideTabsAndDisplayThis('level_6_tab')" onMouseOver="hideTabsAndDisplayBg('level_6')" >5-10%</td>
              <td id="level_7_bottom"  onClick="hideTabsAndDisplayThis('level_7_tab')" onMouseOver="hideTabsAndDisplayBg('level_7')">10-15%</td>
              <td id="level_8_bottom"  onClick="hideTabsAndDisplayThis('level_8_tab')" onMouseOver="hideTabsAndDisplayBg('level_8')">10-25%</td>
              <td id="level_9_bottom"  onClick="hideTabsAndDisplayThis('level_9_tab')" onMouseOver="hideTabsAndDisplayBg('level_9')">10-30%</td>
              <td id="level_10_bottom"  onClick="hideTabsAndDisplayThis('level_10_tab')" onMouseOver="hideTabsAndDisplayBg('level_10')">10-40%</td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td style="padding:10px;">
        
        <div id="offer_list">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="blacksectionheader" style="font-size:16px;">Get cash back when you pay using any <a href="javascript:;">linked card</a>..</td>
              </tr>
             <tr>
             <td><div id="offer_1" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;"><table border="0" cellspacing="5" cellpadding="0" style="cursor:pointer;" onClick="toggleLayer('offer_1_details', '<?php echo base_url()."web/store/offer_explanation/u/".encrypt_value('USER_ID_HERE')."/t/".encrypt_value('offer_1');?>', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_single_light_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png\'>', 'offer_1_arrow_cell', '', '', '');toggleLayersOnCondition('offer_1_details', 'offer_2<>offer_3<>offer_4<>offer_5');">
    <tr>
      <td rowspan="2" style="width:80px;"><table border="0" cellspacing="0" cellpadding="2" class="rewardcardbig">
  <tr>
    <td class="toprow"></td>
  </tr>
  <tr>
    <td class="bottomrow" nowrap>5%</td>
  </tr>
</table></td>
      <td class="greycategoryheader" style="width:500px;">Cash Back</td>
      <td rowspan="2" style="text-align:center; vertical-align:middle; width:25px;" id="offer_1_arrow_cell"><img src='<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png'></td>
      </tr>
    <tr>
      <td class="smallarial">Any time. On all Purchases</td>
      </tr>
    </table>
    
    <div id="offer_1_details" style="display:none;">
                </div>
  </div>
  
  
  
  <div id="offer_2" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;"><table border="0" cellspacing="5" cellpadding="0" style="cursor:pointer;">
    <tr>
      <td rowspan="2" style="width:80px;"><table border="0" cellspacing="0" cellpadding="2" class="rewardcardbig">
  <tr>
    <td class="toprow"></td>
  </tr>
  <tr>
    <td class="bottomrow" nowrap>10%</td>
  </tr>
</table></td>
      <td class="greycategoryheader" style="width:500px;">Cash Back</td>
      <td rowspan="2" style="background: url(<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png) no-repeat center center; width:25px;">&nbsp;</td>
      </tr>
    <tr>
      <td class="smallarial">Mon-Wed all day. Thu-Sun 10am-4pm. On all Purchases</td>
      </tr>
    </table>
  </div>
  
  
  <div id="offer_3" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;"><table border="0" cellspacing="5" cellpadding="0" style="cursor:pointer;">
    <tr>
      <td rowspan="2" style="width:80px;"><table border="0" cellspacing="0" cellpadding="2" class="rewardcardbig">
  <tr>
    <td class="toprow"></td>
  </tr>
  <tr>
    <td class="bottomrow" nowrap>10%</td>
  </tr>
</table></td>
      <td class="greycategoryheader" style="width:500px;">Cash Back</td>
      <td rowspan="2" style="background: url(<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png) no-repeat center center; width:25px;">&nbsp;</td>
      </tr>
    <tr>
      <td class="smallarial">When you spend $100+. On all Purchases</td>
      </tr>
    </table>
  </div>
  
  
  
  
  <div id="offer_4" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;"><table border="0" cellspacing="5" cellpadding="0" style="cursor:pointer;" onClick="toggleLayer('offer_4_details', '<?php echo base_url()."web/store/offer_explanation/u/".encrypt_value('USER_ID_HERE')."/t/".encrypt_value('offer_4');?>', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_single_light_grey.png\'>', '<input type=\'button\' name=\'use_offer_4\' id=\'use_offer_4\' class=\'greenbtn\' style=\'width:60px;\' value=\'Use\'>', 'offer_4_arrow_cell', '', '', '');toggleLayersOnCondition('offer_4_details', 'offer_1<>offer_2<>offer_3<>offer_5');">
    <tr>
      <td rowspan="2" style="width:80px;"><table border="0" cellspacing="0" cellpadding="2" class="perkcardbig">
  <tr>
    <td class="toprow"></td>
  </tr>
  <tr>
    <td class="bottomrow" nowrap>Perk</td>
  </tr>
</table></td>
      <td class="greycategoryheader" style="width:500px;">VIP Entrance</td>
      <td rowspan="2" style="width:25px;" id="offer_4_arrow_cell"><input type="button" name="use_offer_4" id="use_offer_4" class="greenbtn" style="width:60px;" value="Use"></td>
      </tr>
    <tr>
      <td class="smallarial">No cover charge and skip the line. Up to 5 guests.</td>
      </tr>
    </table>
    
    <div id="offer_4_details" style="display:none;">
                </div>
  </div>
  
  
  
  
  
  <div id="offer_5" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;"><table border="0" cellspacing="5" cellpadding="0" style="cursor:pointer;">
    <tr>
      <td rowspan="2" style="width:80px;"><table border="0" cellspacing="0" cellpadding="2" class="perkcardbig">
  <tr>
    <td class="toprow"></td>
  </tr>
  <tr>
    <td class="bottomrow" nowrap>Perk</td>
  </tr>
</table></td>
      <td class="greycategoryheader" style="width:500px;">VIP Seating</td>
      <td rowspan="2" style="width:25px;"><input type="button" name="use_offer_5" id="use_offer_5" class="greenbtn" style="width:60px;" value="Use"></td>
      </tr>
    <tr>
      <td class="smallarial">Skip the table wait list. Choose any available table for instant seating.</td>
      </tr>
    </table>
  </div>
  
  
             </td>
             </tr>
        </table>
        
        </div>
        
        </td>
        </tr>
  </table>
  </div><div id="score_div" class="contentdiv"  style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greytop" style="width:580px;">
    <thead>
      <tr>
        <td><a name="store_score_anchor"></a>Store Score - <span class="greysectionheader">Your Unique Score at This Store</span>
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
    line-height:0px;">567</span><br>
  <span style="font-family: 'Open Sans', arial;
    -webkit-font-smoothing: antialiased;
	color: #999;
	font-size:15px;
	font-weight: 400;">Your Score</span></div></td>
              
              </tr>
            <tr>
              <td style="padding-top:15px;" class="greysectionheader">Member Type<br>
  <div class="blacksectionheader">Level 5</div></td>
              </tr>
            <tr>
              <td style="padding-top:15px;" class="greysectionheader">Cash Back<br>
  <div class="blacksectionheader">5% to 10%</div></td>
              </tr>
            <tr>
              <td style="padding-top:30px;"><div class="greensectionheader" style="padding:20px;">Just 133 more points to reach 15% Cash Back</div></td>
              </tr>
            </table></td>
          <td valign="top" style="width:380px; padding-left:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="blacksectionheader" style="font-size:16px;">Ways to raise your score..</td>
              </tr>
            <tr>
              <td><div id="in_store_spending" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;" ><table border="0" cellspacing="5" cellpadding="0" style=" cursor:pointer;" onClick="toggleLayer('in_store_spending_details', '<?php echo base_url()."web/score/score_explanation/u/".encrypt_value('USER_ID_HERE')."/t/".encrypt_value('in_store_spending');?>', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_single_light_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png\'>', 'in_store_spending_arrow_cell', '', '', '');toggleLayersOnCondition('in_store_spending_details', 'competitor_spending<>category_spending<>related_category_spending<>overall_spending<>linked_accounts<>reviews_preferences');">
                <tr>
                  <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/home_icon.png"></td>
                  <td class="greycategoryheader" style="width:315px;">In Store Spending</td>
                  <td rowspan="2" style="text-align:center; vertical-align:middle; width:25px;" id="in_store_spending_arrow_cell"><img src='<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png'></td>
                  </tr>
                <tr>
                  <td><table width="67%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="1%" style="padding-right:3px;"><img src="<?php echo base_url();?>assets/images/up_arrow_grey_with_tail.png"></td>
                      <td width="98%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="65%" style="background-color: #000;text-align:right;padding-right:5px;"><span style="color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;">130</span></td>
                          <td width="35%" style="background-color: #C1C1C1;">&nbsp;</td>
                        </tr>
                      </table></td>
                      <td width="1%" style="padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;">200</td>
                    </tr>
                  </table></td>
                  </tr>
                </table>
                
                
                <div id="in_store_spending_details" style="display:none;">
                </div>
  </div>
                
                
                
                
  <div id="competitor_spending" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left; cursor:pointer;"><table border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/competitor_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Competitor Spending</td>
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
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/category_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Category Spending</td>
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
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/related_category_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Related Category Spending</td>
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
   
   
   
   
   <div id="overall_spending" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;"><table border="0" cellspacing="5" cellpadding="0" style="cursor:pointer;" onClick="toggleLayer('overall_spending_details', '<?php echo base_url()."web/score/score_explanation/u/".encrypt_value('USER_ID_HERE')."/t/".encrypt_value('overall_spending');?>', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_single_light_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png\'>', 'overall_spending_arrow_cell', '', '', '');toggleLayersOnCondition('overall_spending_details', 'in_store_spending<>competitor_spending<>category_spending<>related_category_spending<>linked_accounts<>reviews_preferences');">
    <tr>
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/world_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Overall Spending</td>
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
    
    
    <div id="overall_spending_details" style="display:none;">
    </div>
  </div>
   
   
   
   <div id="linked_accounts" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left; cursor:pointer;"><table border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/linked_account_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Linked Accounts</td>
      <td rowspan="2" style="background: url(<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png) no-repeat center center; width:25px;">&nbsp;</td>
      </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1%" style="padding-right:3px;"><img src="<?php echo base_url();?>assets/images/up_arrow_grey_with_tail.png"></td><td width="98%">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%" style="background-color: #0AC298;text-align:right;padding-right:5px;"><span style="color:#FFF;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600;">150</span></td>
            <td width="50%" style="background-color: #C1C1C1;">&nbsp;</td>
          
          </tr>
          </table>
          
          
          
          </td>
          <td width="1%" style="padding-left:2px;color:#9D9D9D;font-family: 'Open Sans', arial; -webkit-font-smoothing: antialiased; font-size:11px; font-weight:600; line-height:0px;">300</td>
          </tr>
        </table></td>
      </tr>
    </table>
  </div>
   
   
   
   
   <div id="reviews_preferences" style="background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left; "><table border="0" cellspacing="5" cellpadding="0" onClick="toggleLayer('reviews_preferences_details', '<?php echo base_url()."web/score/score_explanation/u/".encrypt_value('USER_ID_HERE')."/t/".encrypt_value('reviews_preferences');?>', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_single_light_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/next_arrow_single_light_grey.png\'>', 'reviews_preferences_arrow_cell', '', '', '');toggleLayersOnCondition('reviews_preferences_details', 'in_store_spending<>overall_spending<>competitor_spending<>category_spending<>related_category_spending<>linked_accounts');"style="cursor:pointer;">
    <tr>
      <td rowspan="2" style="width:40px;"><img src="<?php echo base_url();?>assets/images/preferences_icon.png"></td>
      <td class="greycategoryheader" style="width:315px;">Reviews / Preferences</td>
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
    
    
    <div id="reviews_preferences_details" style="display:none;">
    </div>
  </div>
   
   
   
   
   
   
   
   
   
   
   
                
  </td>
              </tr>
            </table></td>
          </tr>
  </table>
  </td>
      </tr>
    </table></div></td>
      
    </tr></table></td>
    </tr>
</table></div>
    <?php }?>
	
</body>
</html>