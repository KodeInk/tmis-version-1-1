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

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data1 = google.visualization.arrayToDataTable([
          ['Clout', 'Score'],
          ['',  <?php echo $storeScoreDetails['store_score'];?>],
          ['',  <?php echo (1000 - $storeScoreDetails['store_score']);?>]
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

<style>
/*************************************
 * generic styling for ALS elements
 ************************************/


.als-container {
	position: relative;
	width: 100%;
	margin: 0px;
	z-index: 0;
}

.als-viewport {
	position: relative;
	overflow: hidden;
	margin: 0px;
}

.als-wrapper {
	position: relative;
	list-style: none;
	margin: 0px;
	padding:0px;
}

.als-item {
	position: relative;
	display: block;
	text-align: center;
	cursor: pointer;
	float: left;
}

.als-prev {
	position: absolute;
	cursor: pointer;
	/*clear: both;*/
}

.next-btn {
	position: absolute;
	cursor: pointer;
	background: url(<?php echo base_url();?>assets/images/next_arrow_single.png) no-repeat center center;
	width: 35px;
}

/*************************************
 * specific styling for #item_list
 ************************************/

#item_list {
	margin: 5px auto;
	float:left;
}

#item_list .als-item {
	margin: 0px 0px;
	padding: 3px 4px;
	min-height: 100px;
	min-width: 100px;
	text-align: center;
}
#item_list .highlightbox {
	margin: 0px 7px;
	width: 160px;
}

.item_shadow {
	-webkit-box-shadow: 1px 1px 2px #666; 
	-moz-box-shadow: 1px 1px 2px #666;
	 box-shadow: 1px 1px 2px #666; 
	 margin: 7px;
}

.item_shadow_shown {
	 -webkit-box-shadow: 1px 1px 2px #666; 
	-moz-box-shadow: 1px 1px 2px #666;
	 box-shadow: 1px 1px 2px #666; 
	 margin: 7px;
	 border: 5px solid #2DA0D1;
}

</style>
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php $this->load->view('web/addons/header_normal', array('main'=>'search', 'sub'=>'Home', 'defaultHtml'=>''));?>
  <tr>
    <td class="normalpageheader" id='submenu_content' style="padding-left:10px;"><table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="0%" style="padding:0px;"><div class="bigscreendetails topleftheader">Search</div></td>
    <td width="2%" style="padding-left:0px;padding-right:15px;"><div class='searchselect'><input type="text" id="storename" name="storename" placeholder="Enter the store name" data-rel="search_store_name" style="width:260px" value=""><input name="storename__searchby" id="storename__searchby" type="hidden" value="name"></div></td>
    <td width="1%" class='label' style="padding-left:15px;padding-right:0px;">near:</td>
    <td width="1%"><div class='searchselect'><input type="text" id="zipcode_or_city" class="plainfield" name="zipcode_or_city" placeholder="Enter the zipcode or city" data-rel="zipcode_or_city" style="width:200px" value=""><input name="zipcode_or_city__searchby" id="zipcode_or_city__searchby" type="hidden" value="zipcode__city_name"></div></td>
    <td width="1%" style="padding-left:15px;"><input type="button" name="search_stores" id="search_stores" class="greenbtn" style="width:80px;" value="Search" onClick="updateFieldLayer('<?php echo base_url()."web/search/load_side_list/t/search_results";?>','storename<>zipcode_or_city','','side_search_section','Please enter a search phrase and location');showOnePageNav('pagination_section');"></td>
    <td width="80%">&nbsp;</td>
    
    <td style="text-align:right;"><div id="map_button" style="display:none;"><a href="<?php echo base_url()."web/search/show_deal_home/v/".encrypt_value('map');?>"><img src="<?php echo base_url();?>assets/images/switch_to_map_view.png" border="0"></a></div></td>
  </tr>
</table>

</td>
  </tr>
  <tr>
    <td align="left" style="padding-left:0px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" class="leftmenu" valign="top"><table border="0" cellspacing="0" cellpadding="0">
	<?php if(empty($isSingleResult)){?>
    <tr><td style="padding:10px 10px 0px 10px;"><table width="100%"><tr><td style="background-color:#FFF;padding:5px 10px 5px 10px; border: 1px solid #CCC; text-align:center;" class='sortheader'>Sort By: &nbsp;<a href="javascript:;" <?php echo (!empty($sort) && $sort=='distance')? " class='boldlink' ": "";?> onClick="updateSideListSort('side_pagination', 'distance')" id='side_pagination__distance'>Distance</a> &nbsp;&nbsp;|&nbsp;&nbsp;  <a href="javascript:;" <?php echo (!empty($sort) && $sort=='store_score')? " class='boldlink' ": "";?> onClick="updateSideListSort('side_pagination', 'store_score')" id='side_pagination__store_score'>Score</a>  &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:;" <?php echo (!empty($sort) && $sort=='best_deal')? " class='boldlink' ": "";?> onClick="updateSideListSort('side_pagination', 'best_deal')" id='side_pagination__best_deal'>Best Deal</a></td></tr></table></td></tr>
    <?php }?>
    
    <tr><td>
    <div id="side_search_section"><?php 
	if(!empty($suggested))
	{
		$alphabetCounter = 'A';
		
		foreach($suggested AS $row)
		{ 
			echo "<div ".((!empty($storeId) && $storeId == $row['store_id'])? " class='currentcell' ": " class='noncurrentcell' ")." ".(!empty($isSingleResult)? "style='width:99%;'":"")." >
    <table width='300' border='0' cellspacing='0' cellpadding='0'  id='contenttable'>
  <tr>
    <td id='numbercell' width='1%'><div><span id='bignumber'>".(!empty($row['store_score'])? format_number($row['store_score'],5,0): 0)."</span><br><span id='smallnumber'  nowrap>Store Score</span></div></td>
    <td style='padding:0px;margin:0px;'><div class='locationbubble'>".$alphabetCounter."</div></td>
    <td width='98%' valign='top' style='padding:10px 10px 0px 0px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
        <td width='99%' style='cursor:pointer;' nowrap><a href='".
		(
		!empty($isSingleResult)? "javascript:;": base_url()."web/search/show_store_home/i/".encrypt_value($row['store_id']).(!empty($sort)? '/sort/'.$sort: '/sort/distance').(!empty($p)? '/p/'.$p: '/p/1').(!empty($c)? '/c/'.$c: '/c/10').($this->native_session->get('return_count')? '/returnCount/'.$this->native_session->get('return_count'): '/returnCount/10')
		
		)."' class='title'>".limit_string_length(html_entity_decode($row['name'], ENT_QUOTES), 17)."</a></td>
      </tr>
      <tr>
        <td class='subtitle'nowrap>".(!empty($row['sub_category_tags'])? limit_string_length(wordwrap(html_entity_decode($row['sub_category_tags'], ENT_QUOTES), 25,'<BR>'), 48) : "")." <img src='".base_url()."assets/images/right_arrow_lightgrey.png'> ".$row['price_range']."</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td id='".$row['id']."_favorite' ".((!empty($row['is_favorite']) && $row['is_favorite']=='Y')? " style='padding:10px; text-align:center;' title='This is one of your favorites' ": " style='padding:10px; text-align:center;cursor:pointer;'  onClick=\"updateFieldLayer('".base_url()."web/search/add_favorite_store/s/".encrypt_value($row['id']).($this->native_session->get('userId')? "/u/".encrypt_value($this->native_session->get('userId')): '')."','','','".$row['id']."_favorite','')\" title='Click to add to favorites' ")." ><img src='".base_url()."assets/images/favorite_icon".((!empty($row['is_favorite']) && $row['is_favorite']=='Y')? "": "_grey").".png'></td>
    <td colspan='2' style='padding:10px;'>
    <table width='100%' border='0' cellspacing='0' cellpadding='3'>
  <tr>";


	if(!empty($row['cashback_range']['max_cashback']))
	{
    	echo "<td style='padding-left:0px;' width='1%'><table border='0' cellspacing='0' cellpadding='2' class='rewardcard'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>".($row['cashback_range']['min_cashback'] == $row['cashback_range']['max_cashback']? format_number($row['cashback_range']['max_cashback'],3,0): format_number($row['cashback_range']['min_cashback'],3,0)."-".format_number($row['cashback_range']['max_cashback'],3,0))."%</td>
  </tr>
</table>
</td>";
	}
	
	if(!empty($row['has_perk']) && $row['has_perk'])
	{ 
    	echo "<td style='padding-left:3px;padding-right:0px;' width='1%'><table border='0' cellspacing='0' cellpadding='2' class='perkcard'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>Perk</td>
  </tr>
</table></td>";
	}


echo "<td width='98%' valign='bottom' style='text-align:right;'>".(!empty($row['distance'])? format_number($row['distance'],4,1): 0)."mi</td>
  </tr>
</table>
    </td>
    </tr>
</table>
    </div>";
	
    		$alphabetCounter++;
		}
    }
	
	
    ?></div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</td></tr>
    
    
    <tr>
      <td style="padding: 10px;">
      <div id="pagination_section" onClick="scrollToAnchor('submenu_content')"><?php echo (!empty($isSingleResult) || $this->native_session->get('search_store'))? "<table border='0' cellspacing='0' cellpadding='0' class='paginationtable'><tr><td>&laquo;</td><td class='selectedpagination'>1</td><td>&raquo;</td></tr></table>": pagination((!empty($returnCount)? $returnCount: $sideItemsPerPage), $sideItemsPerPage, 1, 'side_pagination', 'text-align:center;', 8);?></div><input name="side_pagination_showdiv" id="side_pagination_showdiv" type="hidden" value="side_search_section"><input name="side_pagination_action" id="side_pagination_action" type="hidden" value="<?php echo base_url()."web/search/load_side_list/t/suggestions";?>"><input name="side_pagination_noofentries" id="side_pagination_noofentries" type="hidden" value="<?php echo $sideItemsPerPage;?>"><input name="side_pagination_totalpageno" id="side_pagination_totalpageno" type="hidden" value="<?php echo (!empty($returnCount)? $returnCount: $sideItemsPerPage);?>">
      </td>
    </tr>
    <tr>
      <td style="padding: 10px; border-top: solid 1px #CCC;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="font-size: 11px; vertical-align:middle;" nowrap>Not here? Tell us what we're missing. &nbsp;</td>
    <td><input id="addabusiness" name="addabusiness" type="button" value="Add a Business" class="greenbtn" style="font-size: 12px; padding: 3px 7px 3px 7px; width: 100px;"></td>
  </tr>
</table>
</td>
    </tr>
    
    
    </table>
    
    </td>
    <td width="99%" class="pagecontentarea" style="vertical-align:text-top;<?php echo (!empty($showMap) && $showMap)? 'margin:0px;': '';?>" ><?php
    if(!empty($showMap) && $showMap)
	{ 
	?>
	<iframe id="store_map_frame" frameborder="0" scrolling="no" width="100%" src="<?php echo base_url()."web/search/show_store_map";?>"></iframe> 
	<?php 
	} else {
	?>
    <div id="deal_home_content"><table width="100%" border="0" cellspacing="0" cellpadding="15">
  <tr>
    <td class="pagetitle"><?php echo $storeDetails['name'];?></td>
    
  </tr>
  <tr>
    <td>
    <table border="0" cellspacing="0" cellpadding="5" align="center">
    <tr><td class="pagesubtitle" style="padding-top:5px;" nowrap><?php echo !empty($storeDetails['phone_number'])?format_phone_number($storeDetails['phone_number']):'';?> &nbsp;&nbsp;&nbsp; <?php echo !empty($storeDetails['website'])?format_website_for_display($storeDetails['website']):'';?> &nbsp;&nbsp;&nbsp; <?php
	 echo !empty($storeDetails['category_tags'])?$storeDetails['category_tags']:'';
	 echo !empty($storeDetails['price_range'])?(!empty($storeDetails['category_tags'])? ' - '.$storeDetails['price_range']: $storeDetails['price_range']):'';?></td></tr>
    <tr><td class="pagesubtitle greytext" style="border-top: 2px solid #B0B0B0; padding-top:5px;"><a href="javascript:;"  class="jumper" data-rel="business_details_div">Business Details</a> &nbsp;&nbsp;&nbsp; <a href="javascript:;" class="jumper" data-rel="photos_div">Photos</a> &nbsp;&nbsp;&nbsp; <a href="javascript:;" class="jumper" data-rel="offers_div">Offers</a> &nbsp;&nbsp;&nbsp; <a href="javascript:;" class="jumper" data-rel="score_div">Store Score</a></td></tr>
    </table>
    
    </td>
    </tr>
  <tr>
    <td style="padding:0px;" valign="top"><table align="center"><tr><td valign="top">
    
    <div id="business_details_div" class="contentdiv" style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greytop" style="width:580px;">
      <thead>
        <tr>
          <td>Business Details</td>
          </tr>
        </thead>
      
      <tr>
          <td height="2"></td>
      </tr>
      <tr>
          <td class="sectionsubtitle"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
          <td width="1%"><img src="<?php echo base_url()."assets/images/map_marker_small.png";?>" border="0" /></td><td width="98%" style="padding-left:15px;"><?php echo !empty($storeDetails['address'])?$storeDetails['address']:'';?></td><td width="1%"><?php echo !empty($storeDetails['address'])? "<a href='javascript:;' onClick=\"newPopup('".base_url()."web/page/map_to_location/a/".encrypt_value($storeDetails['address'])."','700','500')\">Map</a>": "&nbsp;";?></td>
          </tr></table></td>
      </tr>
      <tr>
          <td height="5"></td>
      </tr>
      <tr>
      <td style="padding:0px;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
          <td width="1%" valign="top" style="padding:5px; padding-left:15px;background-color:#FFF;"><img src="<?php echo base_url()."assets/images/comment_icon.png";?>" border="0" /></td>
          <td width="49%" valign="top" class="subsectiontitle" style="padding-left:15px;padding-top:0px;background-color:#FFF;text-align:left;"><?php echo !empty($storeDetails['description'])?$storeDetails['description']:'No description provided.';?></td>
          <td width="0%" valign="top" style="padding-left:10px;">&nbsp;</td>
          <td width="1%" valign="top" style="background-color:#FFF;padding:5px; padding-right:10px;"><img src="<?php echo base_url()."assets/images/time_icon.png";?>" border="0" /></td>
          <td width="49%" valign="top" style="text-align:left;background-color:#FFF;padding-top:0px;">
          <?php
		  if(!empty($storeDetails['schedule']))
		  {
			  $tableString = "";
			  $tableString .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
			  $hasSchedule = FALSE;
			  
			  foreach($storeDetails['schedule'] AS $day=>$schedule)
			  {
				  if(!empty($schedule['start']))
				  {
					  $tableString .= "<tr><td align='right' width='1%'>".$day."</td><td width='98%' style='padding-left:10px;'>".date('g:ia', strtotime($schedule['start']))." - ".!empty($schedule['end'])?date('g:ia', strtotime($schedule['end'])): 'Late'."</td></tr>";
					  $hasSchedule = TRUE;
				  }
				  else
				  {
					  $tableString .= "<tr><td align='right' width='1%'>".$day."</td><td width='98%' style='padding-left:10px;'>Closed</td></tr>";
				  }
			  }
			  
			  $tableString .= "</table>";
			  
			  echo $hasSchedule? $tableString: "<span class='subsectiontitle'>No schedule provided.</span>";
		  }
		  else
		  {
			  echo "&nbsp;";
		  }
		  ?>
          
          	
          
          </td>
          </tr></table>
      </td>
      </tr>
      <tr>
          <td height="5"></td>
      </tr>
     <?php if(!empty($storeDetails['relevant_tags'])){?>
      <tr><td style="background-color:#FFF;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
          <td width="1%" valign="top" style="padding-left:15px;"><img src="<?php echo base_url()."assets/images/tick.png";?>" border="0" /></td><td width="99%" style="padding-left:15px; text-align:left;"><?php echo !empty($storeDetails['relevant_tags'])?$storeDetails['relevant_tags']: "&nbsp;";?></td>
          </tr></table>
      </td></tr>
      <tr>
          <td height="2"></td>
      </tr>
      <?php }?>
    </table>
    </div>
    
    
    
    
    
    <div id="photos_div" class="contentdiv" style="vertical-align:top;"><?php
    if(!empty($storeDetails['photos']))
	{
	?><table border="0" cellspacing="0" cellpadding="5" class="sectiontable" style="width:580px;">
      <tr><td id="photo_list_large" style="background: url(<?php echo base_url()."assets/uploads/images/".str_replace('_image_', '_image_large_', $storeDetails['photos'][0]['file_url']);?>) no-repeat; 
      background-size: cover;
      height:250px; 
      padding-left:0px;padding-right:0px;padding-bottom:0px;">
      <div class="whitesubtitle bottom" style="background:#2DA0D1;margin-top:50%;opacity: 0.9;"><table border="0" cellspacing="0" cellpadding="3" width="100%"><tr><td align="left" id="image_comment">&nbsp;</td><td align="right" id="image_added_by">&nbsp;</td></tr></table></div>
      </td></tr>
      <tr><td>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td class="previous_slide_btn" style="cursor: pointer;
	background: url(<?php echo base_url();?>assets/images/previous_arrow_single.png) no-repeat center center;
	width: 25px;">&nbsp;</td>
  <td>
  <div id="photo_list"></div><input type="hidden" name="photo_list_total_slides" id="photo_list_total_slides" value="1" />
<input type="hidden" name="photo_list_current_slide" id="photo_list_current_slide" value="0" />
<input type="hidden" name="photo_list_per_slide" id="photo_list_per_slide" value="0" />
  </td>
  <td class="next_slide_btn" style="cursor: pointer;
	background: url(<?php echo base_url();?>assets/images/next_arrow_single.png) no-repeat center center;
	width: 25px;">&nbsp;</td>
  </tr></table>
      </td></tr>
    </table>
    <?php
	} else {
		echo "<table border='0' cellspacing='0' cellpadding='5' class='sectiontable' style='width:580px;'>
      <tr><td class='subsectiontitle' style='text-align:left;padding-left:15px;'>No photos uploaded.</td></tr></table>";
	}
	?>
    </div>
    
    
    <div id="offers_div" class="contentdiv" style="vertical-align:top;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greytop" style="width:580px;">
      <thead>
        <tr>
          <td>Your Offers</td>
          </tr>
        </thead>
      <tr>
        <td style="padding:10px;" nowrap><table width="100%" border="0" cellspacing="0" cellpadding="4" align="center" id="tabtable" class="tabtable">
            <?php 
			$trFirst = $trSecond = "<tr>";
			foreach($storeScoreDetails['store_score_level_data'] AS $level)
			{
				
				#The first table row
				$trFirst .= "<td id='level_".$level['level']."_top' style='border-top: 4px solid #".$level['color'].";'  onClick=\"hideTabsAndDisplayThis('level_".$level['level']."_tab','".decrypt_value($i)."__".$storeScoreDetails['store_score_level'].
				
				($storeScoreDetails['store_score_level'] < $level['level']? "__".($level['low_end_score']-format_number($storeScoreDetails['store_score'],4,0)): "")
				
				."')\" onMouseOver=\"hideTabsAndDisplayBg('level_".$level['level']."')\"><div id='level_".$level['level']."_tab' class='innertablayer' style='background-color:#".$level['color']."; display:".($storeScoreDetails['store_score_level'] == $level['level']? 'block': 'none').";' title='level ".$level['level']." Offers'><table border='0' cellspacing='0' cellpadding='0' align='center' class='innertabtable'>
              <tr><td class='toprow'>".($storeScoreDetails['store_score_level'] == $level['level']? format_number($storeScoreDetails['store_score'],4,0): $level['low_end_score']).(empty($level['high_end_score'])? '+': '')."</td></tr>
              <tr><td>".(!empty($level['max_cashback'])? $level['min_cashback'].'%-'.$level['max_cashback'].'%': $level['min_cashback'].'%')."</td></tr>
              </table></div>".($storeScoreDetails['store_score_level'] == $level['level']? format_number($storeScoreDetails['store_score'],4,0): $level['low_end_score']).(empty($level['high_end_score'])? '+': '')."</td>";
			  
			  
			  
			  
			  #The second table row
			  $trSecond .= "<td id='level_".$level['level']."_bottom'  onClick=\"hideTabsAndDisplayThis('level_".$level['level']."_tab','".decrypt_value($i)."__".$storeScoreDetails['store_score_level'].
				
				($storeScoreDetails['store_score_level'] < $level['level']? "__".($level['low_end_score']-format_number($storeScoreDetails['store_score'],4,0)): "")
				
				."')\" onMouseOver=\"hideTabsAndDisplayBg('level_".$level['level']."')\" style='font-size:10.3px;'>".(!empty($level['max_cashback'])? $level['min_cashback'].'%-'.$level['max_cashback'].'%': $level['min_cashback'].'%');
			 
			  $trSecond .= $level['level'] == '0'? "<input name='currentlevelvalue' id='currentlevelvalue' type='hidden' value='level_".$storeScoreDetails['store_score_level']."'>": '';
			  $trSecond .= "</td>";
			  
			  
			  
			  #Get the current cashback range
			  if($storeScoreDetails['store_score_level'] == $level['level'])
			  {
			  	$storeScoreDetails['min_cashback'] = $level['min_cashback'];
			  	$storeScoreDetails['max_cashback'] = $level['max_cashback'];
			  }
			  
			  #Get the next points remaining for the next level
			  if($level['level'] == ($storeScoreDetails['store_score_level']+1) && !empty($level['high_end_score']))
			  {
				  $storeScoreDetails['remaining_points'] = $level['low_end_score'] - format_number($storeScoreDetails['store_score'],4,0);
				  $hasRemainingPoints = 'Y';
			  }
			}
			$trFirst .= "</tr>";
			$trSecond .= "</tr>";
			
			echo $trFirst.$trSecond;
			?>
            
          </table></td>
        </tr>
      <tr>
        <td style="padding:10px;">
        
        <div id="offer_list">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="blacksectionheader" style="font-size:16px;">Get cash back when you pay using any linked card..</td>
              </tr>
             <tr>
             <td>
       <?php
		$offerDivArray = array();
		if(!empty($storeDetails['offers']['cash_back']))
		{
			foreach($storeDetails['offers']['cash_back'] AS $row)
			{
				array_push($offerDivArray,'offer_'.$row['id']);
			}
		}
		
		if(!empty($storeDetails['offers']['perks']))
		{
			foreach($storeDetails['offers']['perks'] AS $row)
			{
				array_push($offerDivArray,'offer_'.$row['id']);
			}
		}
		$this->native_session->set('all_divs', $offerDivArray);
		 
		#Do if there are any cashback offers
		if(!empty($storeDetails['offers']['cash_back']))
		{
			 foreach($storeDetails['offers']['cash_back'] AS $offer)
			 {
				 echo "<div id='offer_".$offer['id']."' style='background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;'><table border='0' cellspacing='5' cellpadding='0' style='cursor:pointer;' onClick=\"toggleLayer('offer_".$offer['id']."_details', '".base_url()."web/store/offer_explanation/u/".encrypt_value($this->native_session->get('userId'))."/t/".encrypt_value($offer['id'])."', '<img src=\'".base_url()."assets/images/up_arrow_single_light_grey.png\'>', '<img src=\'".base_url()."assets/images/next_arrow_single_light_grey.png\'>', 'offer_".$offer['id']."_arrow_cell', '', '', '');toggleLayersOnCondition('offer_".$offer['id']."_details', '".implode('<>', remove_item('offer_'.$offer['id'], $this->native_session->get('all_divs')))."');\">
    <tr>
      <td rowspan='2' style='width:80px;'><table border='0' cellspacing='0' cellpadding='2' class='rewardcardbig'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>".$offer['promotion_amount']."%</td>
  </tr>
</table></td>
      <td class='greycategoryheader' style='width:500px;'>Cash Back</td>
      <td rowspan='2' style='text-align:center; vertical-align:middle; width:25px;' id='offer_".$offer['id']."_arrow_cell'><img src='".base_url()."assets/images/next_arrow_single_light_grey.png'></td>
      </tr>
    <tr>
      <td class='smallarial'>".$offer['description']."</td>
      </tr>
    </table>
    
    <div id='offer_".$offer['id']."_details' style='display:none;'></div>
  </div>";
			 }
		}
		
		
		#Do if there are any cashback offers
		if(!empty($storeDetails['offers']['perks']))
		{
			 foreach($storeDetails['offers']['perks'] AS $offer)
			 {
				 echo "<div id='offer_".$offer['id']."' style='background-color:#FFF; padding:6px; border-top: 1px solid #F2F2F2; text-align:left;'><table border='0' cellspacing='5' cellpadding='0' style='cursor:pointer;' onClick=\"toggleLayer('offer_".$offer['id']."_details', '".base_url()."web/store/offer_explanation/u/".encrypt_value($this->native_session->get('userId'))."/t/".encrypt_value($offer['id'])."', '<img src=\'".base_url()."assets/images/up_arrow_single_light_grey.png\'>', '<input type=\'button\' name=\'use_offer_".$offer['id']."\' id=\'use_offer_".$offer['id']."\' class=\'greenbtn\' style=\'width:60px;\' value=\'Use\'>', 'offer_".$offer['id']."_arrow_cell', '', '', '');toggleLayersOnCondition('offer_".$offer['id']."_details', '".implode('<>', remove_item('offer_'.$offer['id'], $this->native_session->get('all_divs')))."');\">
    <tr>
      <td rowspan='2' style='width:80px;'><table border='0' cellspacing='0' cellpadding='2' class='perkcardbig'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>Perk</td>
  </tr>
</table></td>
      <td class='greycategoryheader' style='width:500px;'>".$offer['name']."</td>
      <td rowspan='2' style='width:25px;' id='offer_".$offer['id']."_arrow_cell'><input type='button' name='use_offer_".$offer['id']."' id='use_offer_".$offer['id']."' class='greenbtn' style='width:60px;' value='Use'></td>
      </tr>
    <tr>
      <td class='smallarial'>".$offer['description']."</td>
      </tr>
    </table>
    
    <div id='offer_".$offer['id']."_details' style='display:none;'></div>
  </div>";
			 }
		}
		?>

             </td>
             </tr>
        </table>
        
        </div>
        
        </td>
        </tr>
  </table>
  </div><div id="score_div" class="contentdiv"  style="vertical-align:top;">
  <table border="0" cellspacing="0" cellpadding="5" class="sectiontable greytop" style="width:580px;">
    <thead>
      <tr>
        <td>Store Score - <span class="greysectionheader">Your Unique Score at This Store</span>
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
    line-height:0px;"><?php echo format_number($storeScoreDetails['store_score'],4,0);?></span><br>
  <span style="font-family: 'Open Sans', arial;
    -webkit-font-smoothing: antialiased;
	color: #999;
	font-size:15px;
	font-weight: 400;">Your Score</span></div></td>
              
              </tr>
            <tr>
              <td style="padding-top:15px;" class="greysectionheader">Member Type<br>
  <div class="blacksectionheader">Level <?php echo $storeScoreDetails['store_score_level'];?></div></td>
              </tr>
            <tr>
              <td style="padding-top:15px;" class="greysectionheader">Cash Back<br>
  <div class="blacksectionheader"><?php echo $storeScoreDetails['min_cashback'].'% to '.$storeScoreDetails['max_cashback'].'%';?></div></td>
              </tr>
            <?php if(!empty($hasRemainingPoints)){?>
            <tr>
              <td style="padding-top:30px;"><div class="greensectionheader" style="padding:20px;"><?php echo "Just ".$storeScoreDetails['remaining_points']." more points to reach the next level";?></div></td>
              </tr>
            <?php }?>
            </table></td>
          <td valign="top" style="width:380px; padding-left:10px;">
          <div id='store_score_div'>
          <?php $this->load->view('web/search/store_score_details', $storeScoreDetails);?>
          </div>
          </td>
          </tr>
  </table>
  </td>
      </tr>
    </table></div></td>
      

    </tr></table></td>
    </tr>
</table></div>
    <?php }?></td>
    
    <td valign="top" class="rightmenubg" id="filterspace" width="0%">
<div id="filter_layer" style="color:#919191;padding:0px 15px 15px 15px;min-width:245px; display:none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border-bottom: solid 1px #CCC;">
        <tr onClick="toggleLayer('categorization_options', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_medium_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_medium_grey.png\'>', 'categorization_cell', '', '', '');" style="cursor:pointer;">
          <td width="99%" style="padding-left:0px;"><a href="javascript:;" class="greytext">Categorization</a></td>
          <td width="1%" id="categorization_cell"><img src="<?php echo base_url();?>assets/images/down_arrow_medium_grey.png" border="0"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:0px;"><div id="categorization_options" class="filtersectionlayer" style="display:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-top:10px;" nowrap>Category
      <select class="smallselect" name="category" id="category" style="margin-top:0px;width:170px;">
    <option value="all">All</option>
    <option value="automotive">Automotive</option>
    <option value="community and government">Community and Government</option>
    <option value="healthcare">Healthcare</option>
    <option value="landmarks">Landmarks</option>
    <option value="retail">Retail</option>
    <option value="Restaurants" selected>Restaurants</option>
    <option value="social">Social</option>
    <option value="sports and Recreation">Sports and Recreation</option>
    <option value="transportation">Transportation</option>
    <option value="travel">Travel</option>
    
    </select></td>
  </tr>
  <tr>
    <td style="padding-top:5px; padding-bottom:10px;"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%" valign="top">Sub-category </td>
    <td width="99%">
    <div style="max-height:150px; overflow:auto;">
    <table border="0" cellspacing="0" cellpadding="2">
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="out_door_seating" name="features[]" value="Outdoor Seating"></td>
    <td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>American</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="patio" name="features[]" value="Patio"></td>
    <td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Chinese</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="full_bar" name="features[]" value="Full Bar"></td>
    <td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>German</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="food_stand" name="features[]" value="Food Stand"></td>
    <td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Italian</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="beer_and_wine" name="features[]" value="Beer and Wine"></td>
    <td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Pizza</td>
    </tr>
    </table>
    </div>
    </td>
  </tr>
</table>
</td>
  </tr>
</table>

          
          </div></td>
          </tr>
      </table></td>
    </tr>
    <tr><td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border-bottom: solid 1px #CCC;">
        <tr onClick="toggleLayer('offers_options', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_medium_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_medium_grey.png\'>', 'offers_cell', '', '', '');" style="cursor:pointer;">
          <td width="99%" style="padding-left:0px;"><a href="javascript:;" class="greytext">Offers</a></td>
          <td width="1%" id="offers_cell"><img src="<?php echo base_url();?>assets/images/down_arrow_medium_grey.png" border="0"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:0px;"><div id="offers_options" class="filtersectionlayer" style="display:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap>Cashback Offer Above&nbsp;
      <select class="smallselect" name="cashbackoffer" id="cashbackoffer" style="margin-top:0px;width:60px;padding:5px 5px 5px 0px;">
    <option value="0" selected>0%</option>
    <option value="10">10%</option>
    <option value="20">20%</option>
    <option value="30">30%</option>
    <option value="40">40%</option>
    <option value="50">50%</option>
    <option value="60">60%</option>
    <option value="70">70%</option>
    <option value="80">80%</option>
    <option value="90">90%</option>
    </select></td>
  </tr>
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;padding-bottom:10px;"  nowrap>Has Perks? &nbsp;
      <select class="smallselect" name="hasperks" id="hasperks" style="margin-top:0px;width:60px;padding:5px 5px 5px 0px;">
    <option value="any" selected>Any</option>
    <option value="yes">Yes</option>
    <option value="no">No</option>
    </select></td>
  </tr>
</table>

          
          </div></td>
          </tr>
      </table></td></tr>
    
    <tr><td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border-bottom: solid 1px #CCC;">
        <tr onClick="toggleLayer('locations_options', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_medium_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_medium_grey.png\'>', 'locations_cell', '', '', '');" style="cursor:pointer;">
          <td width="99%" style="padding-left:0px;"><a href="javascript:;" class="greytext">Location and Features</a></td>
          <td width="1%" id="locations_cell"><img src="<?php echo base_url();?>assets/images/down_arrow_medium_grey.png" border="0"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:0px;"><div id="locations_options" class="filtersectionlayer" style="display:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap>Distance  
       <select class="smallselect" name="distance" id="distance" style="margin-top:0px;width:77px;padding:5px 5px 5px 0px;">
     <option value="">Any</option>
    <option value="0.25">1/4</option>
    <option value="1">1</option>
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="15">15</option>
    <option value="20">20</option>
    <option value="30">30</option>
    <option value="50">50</option>
    <option value="100">100</option>
  </select> miles</td>
  </tr>
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px; padding-bottom:10px;" nowrap><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top">Features</td>
        <td><table border="0" cellspacing="0" cellpadding="2">
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="out_door_seating" name="features[]" value="Outdoor Seating"></td><td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Outdoor Seating</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="patio" name="features[]" value="Patio"></td><td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Patio</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="full_bar" name="features[]" value="Full Bar"></td><td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Full Bar</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="food_stand" name="features[]" value="Food Stand"></td><td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Food Stand</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="beer_and_wine" name="features[]" value="Beer and Wine"></td><td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Beer and Wine</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="delivery" name="features[]" value="Delivery"></td><td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Delivery</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="wifi" name="features[]" value="WIFI"></td><td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>WIFI</td>
    </tr>
    </table></td>
      </tr>
    </table></td>
  </tr>
</table>

          
          </div></td>
          </tr>
      </table></td></tr>
    
    
    <tr><td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border-bottom: solid 1px #CCC;">
        <tr onClick="toggleLayer('hours_of_operation_options', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_medium_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_medium_grey.png\'>', 'hours_of_operation_cell', '', '', '');" style="cursor:pointer;">
          <td width="99%" style="padding-left:0px;"><a href="javascript:;" class="greytext">Hours of Operation</a></td>
          <td width="1%" id="hours_of_operation_cell"><img src="<?php echo base_url();?>assets/images/down_arrow_medium_grey.png" border="0"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:0px;"><div id="hours_of_operation_options" class="filtersectionlayer" style="display:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap>Time <select class="smallselect" name="filterday" id="filterday" style="margin-top:0px;width:105px;padding:5px 5px 5px 0px;">
              <option value="">Day</option>
              <option value="monday">Monday</option>
              <option value="tuesday">Tuesday</option>
              <option value="wednesday">Wednesday</option>
              <option value="thursday">Thursday</option>
              <option value="friday">Friday</option>
              <option value="saturday">Saturday</option>
              <option value="sunday">Sunday</option>
              </select> <select class="smallselect" name="time" id="time" style="margin-top:0px;width:90px;padding:5px 5px 5px 0px;">
              <option value="">Time</option>
              <option value="2400">12:00am</option>
              <option value="0100">1:00am</option>
              <option value="0200">2:00am</option>
              <option value="0300">3:00am</option>
              <option value="0400">4:00am</option>
              <option value="0500">5:00am</option>
              <option value="0600">6:00am</option>
              <option value="0800">7:00am</option>
              <option value="0900">8:00am</option>
              <option value="1000">9:00am</option>
              <option value="1100">10:00am</option>
              <option value="1200">11:00am</option>
              <option value="1300">12:00pm</option>
              <option value="1400">1:00pm</option>
              <option value="1500">2:00pm</option>
              <option value="1600">3:00pm</option>
              <option value="1700">4:00pm</option>
              <option value="1800">5:00pm</option>
              <option value="1900">7:00pm</option>
              <option value="2000">8:00pm</option>
              <option value="2100">9:00pm</option>
              <option value="2200">10:00pm</option>
              <option value="2300">11:00pm</option>
              </select> </td>
  </tr>
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px; padding-bottom:15px;" nowrap><table border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td>Schedule </td>
    <td><input type="checkbox" id="opennowcheck" name="opennowcheck" value="opennow"></td><td class="ariallabel" style="font-size:14px; padding-right: 5px;" nowrap>Open Now</td>
    <td><input type="checkbox" id="openlatecheck" name="openlatecheck" value="openlate"></td><td class="ariallabel" style="font-size:14px;">Open Late</td>
    </tr>
    </table></td>
  </tr>
</table>

          
          </div></td>
          </tr>
      </table></td></tr>
    
    
    
    
    <tr><td><table width="100%" border="0" cellspacing="0" cellpadding="5" style="border-bottom: solid 1px #CCC;">
        <tr onClick="toggleLayer('preferences_options', '', '<img src=\'<?php echo base_url();?>assets/images/up_arrow_medium_grey.png\'>', '<img src=\'<?php echo base_url();?>assets/images/down_arrow_medium_grey.png\'>', 'preferences_cell', '', '', '');" style="cursor:pointer;">
          <td width="99%" style="padding-left:0px;"><a href="javascript:;" class="greytext">Preferences</a></td>
          <td width="1%" id="preferences_cell"><img src="<?php echo base_url();?>assets/images/down_arrow_medium_grey.png" border="0"></td>
        </tr>
        <tr>
          <td colspan="2" style="padding:0px;"><div id="preferences_options" class="filtersectionlayer" style="display:none;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap>Only Show</td>
  </tr>
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px; padding-bottom:10px;" nowrap><table border="0" cellspacing="0" cellpadding="2">
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="favoritescheck" name="preferences[]" value="Favorites"></td><td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Favorites</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="hot_spots" name="preferences[]" value="Hot Spots"></td><td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Hot Spots</td>
    </tr>
    <tr>
    <td style="padding-left:0px;"><input type="checkbox" id="places_i_have_been" name="preferences[]" value="Places I Have Been"></td><td class="ariallabel" style="font-size:14px; padding-right: 15px;" nowrap>Places I've Been</td>
    </tr>
    </table></td>
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

<script src='<?php echo base_url();?>assets/js/jquery.als-1.3.min.js' type='text/javascript'></script>

<script type="text/javascript">
 var photoList = new Array();
  var photoListLarge = new Array();
  var photoListComment = new Array();
  var photoListAddedBy = new Array();
<?php
foreach($storeDetails['photos'] AS $i=>$photo)
{
	echo "photoList[".$i."]='".$photo['file_url']."';";
	echo "photoListLarge[".$i."]='".str_replace('_image_', '_image_large_', $photo['file_url'])."';";
	echo "photoListComment[".$i."]='".addslashes($photo['photo_note'])."';";
	echo "photoListAddedBy[".$i."]='".(!empty($photo['added_by_name'])?$photo['added_by_name']:'')."';";
}
?>
	  
$(document).ready(function(){
	var numberOfElements = <?php echo !empty($storeDetails['photos'])?count($storeDetails['photos']): 0;?>;
	var containerWidth = $('#photo_list').width();
	var elementsPerSlide = Math.floor(containerWidth/90);
	if(elementsPerSlide >= numberOfElements)
	{
		elementsPerSlide = numberOfElements;
	}
	
	//Now get the number of sets
	var noOfSlides = Math.ceil(numberOfElements/elementsPerSlide);
	$("#photo_list_total_slides").val(noOfSlides);
	$("#photo_list_per_slide").val(elementsPerSlide);
	$('.previous_slide_btn').hide();
	//Get the current slide
	var currentSlide = $("#photo_list_current_slide").val();
	var startPoint = currentSlide*elementsPerSlide;
	var endPoint = (currentSlide+1)*elementsPerSlide;
	
	var listToShow = photoList.slice(startPoint, endPoint);
	var listToShowLarge = photoListLarge.slice(startPoint, endPoint);
	var listToShowComment = photoListComment.slice(startPoint, endPoint);
	var listToShowAddedBy = photoListAddedBy.slice(startPoint, endPoint);
	
	add_slide_image_list('photo_list', listToShow, listToShowLarge, listToShowComment, listToShowAddedBy);
	
	
	//Next slide of images
	$('.next_slide_btn').on('click', function(){
		//Get the current slide
		var currentSlide = $("#photo_list_current_slide").val();
		var totalSlides = $("#photo_list_total_slides").val();
		if(currentSlide < (totalSlides-1))
		{
			//Add one extra slide
			currentSlide = Number(currentSlide) + 1;
			$("#photo_list_current_slide").val(currentSlide);
			var startPoint = currentSlide*elementsPerSlide;
			var endPoint = (currentSlide+1)*elementsPerSlide;
			
			var listToShow = photoList.slice(startPoint, endPoint);
			var listToShowLarge = photoListLarge.slice(startPoint, endPoint);
			var listToShowComment = photoListComment.slice(startPoint, endPoint);
			var listToShowAddedBy = photoListAddedBy.slice(startPoint, endPoint);
		
			add_slide_image_list('photo_list', listToShow, listToShowLarge, listToShowComment, listToShowAddedBy);
			$('#photo_list_large').css('background-image', "url(<?php echo base_url()."assets/uploads/images/";?>"+ listToShowLarge[0] +")");
			
			if(currentSlide == (totalSlides-1))
			{
				$('.next_slide_btn').hide();
			}
		}
		$('.previous_slide_btn').show();
	});
	
	
	
	//Previous slide of images
	$('.previous_slide_btn').on('click', function(){
		//Get the current slide
		var currentSlide = $("#photo_list_current_slide").val();
		var totalSlides = $("#photo_list_total_slides").val();
		if(currentSlide > 0)
		{
			//Add one extra slide
			currentSlide = Number(currentSlide) - 1;
			$("#photo_list_current_slide").val(currentSlide);
			var startPoint = currentSlide*elementsPerSlide;
			var endPoint = (currentSlide+1)*elementsPerSlide;
	
			var listToShow = photoList.slice(startPoint, endPoint);
			var listToShowLarge = photoListLarge.slice(startPoint, endPoint);
			var listToShowComment = photoListComment.slice(startPoint, endPoint);
			var listToShowAddedBy = photoListAddedBy.slice(startPoint, endPoint);
		
			add_slide_image_list('photo_list', listToShow, listToShowLarge, listToShowComment, listToShowAddedBy);
			$('#photo_list_large').css('background-image', "url(<?php echo base_url()."assets/uploads/images/";?>"+ listToShowLarge[0] +")");
			
			if(currentSlide == 0)
			{
				$('.previous_slide_btn').hide();
			}
			$('.next_slide_btn').show();
		}
	});
		
});




//Function to show the large image when clicked
function show_large_image(elementId)
{
	$('.enlarge_image').removeClass('item_shadow_shown');
	$('#'+elementId).addClass('item_shadow_shown');
	var largeImage = $('#'+elementId).attr('data-role');
	var imageDivId = $('#'+elementId).attr('id');
		
	//Change the image
	$('#photo_list_large').css('background-image', "url(<?php echo base_url()."assets/uploads/images/";?>"+ largeImage +")");
		
	//Change the comment and commentor
	$('#image_comment').html($('#'+imageDivId+'_comment').val());
	$('#image_added_by').html($('#'+imageDivId+'_added_by').val());
}



//Function to add a new slide image list
function add_slide_image_list(listDivId, listToShow, listToShowLarge, listToShowComment, listToShowAddedBy)
{
	//Now replace the html
	$('#'+listDivId).html('');
			
	//Now add the viewed list div details
	for(var i=0; i<listToShow.length; i++)
	{
		var divString = "<div data-role='"+listToShowLarge[i]+"' class='enlarge_image";
		if(i == 0)
		{
			divString += " item_shadow item_shadow_shown";
			$('#image_comment').html(listToShowComment[i]);
			$('#image_added_by').html(listToShowAddedBy[i]);
		}
		else
		{
			divString += " item_shadow";
		}
		
		divString += "' id='photo_div_"+i+"' onclick=\"show_large_image('photo_div_"+i+"')\" style='border-radius: 7px; -webkit-border-radius: 7px; -moz-border-radius: 7px;background: url(<?php echo base_url()."assets/uploads/images/";?>"+listToShow[i]+") no-repeat; width:87px; height:80px; cursor:pointer; display:inline-block;'><input type='hidden' id='photo_div_"+i+"_comment' name='photo_div_"+i+"_comment' value='"+listToShowComment[i]+"' /><input type='hidden' id='photo_div_"+i+"_added_by' name='photo_div_"+i+"_added_by' value='"+listToShowAddedBy[i]+"' /></div>";
		
		$('#'+listDivId).append(divString); 
	}
}


</script>


</body>
</html>
