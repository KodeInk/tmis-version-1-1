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
    <td width="1%" style="padding-left:15px;"><input type="button" name="search_stores" id="search_stores" class="greenbtn" style="width:80px;" value="Search" onClick="updateFieldLayer('<?php echo base_url()."web/search/load_side_list/t/search_results";?>','storename<>zipcode_or_city<>*search_category','','side_search_section','Please enter a search phrase and location');showOnePageNav('pagination_section');"></td>
    <td width="80%"><div id="display_search_category"></div><input name="search_category" id="search_category" type="hidden" value=""></td>
    
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
    <tr><td style="padding:10px 10px 0px 10px;"><table width="100%"><tr><td style="background-color:#FFF;padding:5px 10px 5px 10px; border: 1px solid #CCC; text-align:center;" class='sortheader'>Sort By: &nbsp;<a href="javascript:;"  class='boldlink' onClick="updateSideListSort('side_pagination', 'distance')" id='side_pagination__distance'>Distance</a> &nbsp;&nbsp;|&nbsp;&nbsp;  <a href="javascript:;" onClick="updateSideListSort('side_pagination', 'store_score')" id='side_pagination__store_score'>Score</a>  &nbsp;&nbsp;|&nbsp;&nbsp; <a href="javascript:;" onClick="updateSideListSort('side_pagination', 'best_deal')" id='side_pagination__best_deal'>Best Deal</a></td></tr></table></td></tr>
    
    <tr><td>
    
    <div id="side_search_section">
    
    <?php 
	if(!empty($suggested))
	{
		$alphabetCounter = 'A';
		
		foreach($suggested AS $row)
		{
			echo "<div class='noncurrentcell'>
    <table width='100%' border='0' cellspacing='0' cellpadding='0'  id='contenttable'>
  <tr>
    <td id='numbercell' width='1%'><div><span id='bignumber'>".(!empty($row['store_score'])? format_number($row['store_score'],5,0): 0)."</span><br><span id='smallnumber'  nowrap>Store Score</span></div></td>
    <td style='padding:0px;margin:0px;'><div class='locationbubble'>".$alphabetCounter."</div></td>
    <td width='98%' valign='top' style='padding:10px 10px 0px 0px;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
        <td width='99%' style='cursor:pointer;' nowrap><a href='".base_url()."web/search/show_store_home/i/".encrypt_value($row['store_id']).(!empty($sort)? '/sort/'.$sort: '/sort/distance').(!empty($p)? '/p/'.$p: '/p/1').(!empty($c)? '/c/'.$c: '/c/10').($this->native_session->get('return_count')? '/returnCount/'.$this->native_session->get('return_count'): '/returnCount/10')."' class='title'>".limit_string_length(html_entity_decode($row['name'], ENT_QUOTES), 17)."</a></td>
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
    ?>
    
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</td></tr>
    
    
    <tr>
      <td style="padding: 10px;">
      <div id="pagination_section" onClick="scrollToAnchor('submenu_content')"><?php echo pagination((!empty($returnCount)? $returnCount: $sideItemsPerPage), $sideItemsPerPage, 1, 'side_pagination', 'text-align:center;', 8);?></div><input name="side_pagination_showdiv" id="side_pagination_showdiv" type="hidden" value="side_search_section"><input name="side_pagination_action" id="side_pagination_action" type="hidden" value="<?php echo base_url()."web/search/load_side_list/t/suggestions";?>"><input name="side_pagination_noofentries" id="side_pagination_noofentries" type="hidden" value="<?php echo $sideItemsPerPage;?>"><input name="side_pagination_totalpageno" id="side_pagination_totalpageno" type="hidden" value="<?php echo (!empty($returnCount)? $returnCount: $sideItemsPerPage);?>">
      </td>
    </tr>
    <tr>
      <td style="padding: 10px; border-top: solid 1px #CCC;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="font-size: 11px; vertical-align:middle;" nowrap>Not here? Tell us what we're missing. &nbsp;</td>
    <td><a href="<?php echo base_url()."web/store/suggest_store_by_public/u/".encrypt_value($this->native_session->get('userId'));?>" class="fancybox fancybox.ajax"><input id="addabusiness" name="addabusiness" type="button" value="Add a Business" class="greenbtn" style="font-size: 12px; padding: 3px 7px 3px 7px; width: 100px;"></a></td>
  </tr>
</table>
<div id='add_a_business'></div>
</td>
    </tr>
    
    
    </table>
    
    </td>
    <td width="98%" class="pagecontentarea" style="vertical-align:text-top;" >
    <div id='page_details'>
    <div  class="contentdiv" style="max-width:90%;">
    <table border="0" cellspacing="0" cellpadding="5" class="sectiontable greytop" width="100%">
        <thead>
          <tr>
            <td>
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr><td style="border-bottom:0px;padding-left: 0px;" width="98%">
            Categories - <span class="greysectionheader">Choose a category to begin searching</span>
            </td>
            <td width="1%" style="border-bottom:0px;" nowrap><div id='category_list_previous_action' onClick="scrollThroughItems('previous', 'category_list')" style="cursor:pointer;display:none;">
            <table border="0" cellspacing="0" cellpadding="0"><tr><td style="border-bottom:0px;padding-left: 0px; padding-right:5px;"><img src="<?php echo base_url();?>assets/images/previous_arrow_icon.png" border="0"></td><td style="border-bottom:0px;padding-left: 0px;padding-bottom:10px;"><a href="javascript:;" class="bluebold" style="font-size:16px; font-weight:400;">Previous</a></td></tr></table></div>
            </td>
            <td width="1%" style="border-bottom:0px;height:37px;" nowrap><div id='category_list_next_action' onClick="scrollThroughItems('next', 'category_list')" style="cursor:pointer; padding-left:20px;">
            <table border="0" cellspacing="0" cellpadding="0"><tr><td style="border-bottom:0px;padding-left: 0px; padding-bottom:10px; padding-right:5px;"><a href="javascript:;" class="bluebold" style="font-size:16px; font-weight:400;">More</a></td><td style="border-bottom:0px;padding-left: 0px;"><img src="<?php echo base_url();?>assets/images/next_arrow_icon.png" border="0"></td></tr></table></div>
            </td>
            </tr></table>
            
            </td>
            </tr>
          </thead>
        <tr>
          <td>
          <?php $this->load->view('web/search/category_scroll_view', array('categoryData'=>$categories));?>
          </td>
        </tr>
        </table></div>
    
    
    
    
    
    <div  class="contentdiv" style="width:90%;"><table border="0" cellspacing="0" cellpadding="5" class="sectiontable greytop" width="100%">
        <thead>
          <tr>
            <td>Featured</td>
            </tr>
          </thead>
        
        
        <tr>
          <td id="featured_container">
          
<?php 
if(!empty($featured))
{
     foreach($featured AS $row)     
     {  
          $defaultImage = $row['category_image'];
		  $showImage = !empty($row['small_cover_image'])? $row['small_cover_image']: (!empty($row['logo_url'])? $row['logo_url']:$defaultImage);
		  
		  echo "<div class='highlightbox featured'>
          <table width='100%' cellpadding='10' border='0' cellspacing='0' >
          <thead>
          <tr>
		  ".
		  ($showImage != $defaultImage? 
		  "<td style='background: url(".base_url()."assets/uploads/images/".$showImage.") no-repeat center center;'>&nbsp;</td>":
		  "<td style='background: #2DA0D1; text-align:center; verticle-align:center;'><img src='".base_url()."assets/images/".(!empty($defaultImage)? str_replace('blue_', 'white_', $defaultImage): 'white_local_flavor_icon.png')."' border='0'></td>"
		  )."
		  </tr>
          </thead>
          <tr><td style='padding-top:0px;' nowrap><table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td colspan='3'><table width='100%' border='0' cellspacing='0' cellpadding='3'>
    <tr><td width='99%' class='subsectiontitle' style='text-align:left;padding-left:0px; padding-right:2px;'>
    ".limit_string_length(html_entity_decode($row['name'], ENT_QUOTES), 22)."
    </td>
    <td width='1%' class='smalltxt' style='text-align:right;'>".format_number($row['distance'],4,1)."mi</td>
    </tr>
    </table></td>
    </tr>
  <tr>
    
<td class='smallertitle'>".(!empty($row['sub_category_tags'])? limit_string_length(wordwrap(html_entity_decode($row['sub_category_tags'], ENT_QUOTES), 20,' <BR> '), 33) : "")."  <img src='".base_url()."assets/images/right_arrow_lightgrey.png'> ".$row['price_range']."
</td>";

if(!empty($row['cashback_range']['max_cashback']))
{
echo "<td width='1%'>
<table border='0' cellspacing='0' cellpadding='2' class='rewardcard'>
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
echo "<td width='1%' style='padding-left:5px;padding-right:0px;'><table border='0' cellspacing='0' cellpadding='2' class='perkcard'>
  <tr>
    <td class='toprow'></td>
  </tr>
  <tr>
    <td class='bottomrow' nowrap>Perk</td>
  </tr>
</table></td>";
}

echo "</tr>
</table></td></tr>
          </table>
          </div>";
          
	 }
}
?>
          
          
          <div class='scroll_checker_view' id='featured_container_checker_view'></div>
          <input name="featured_container_per_section" id="featured_container_per_section" type="hidden" value="<?php echo (!empty($featuredItemsPerPage)? $featuredItemsPerPage: 10);?>"><input type="hidden" class="featured_container_counter_fields" name='featured_list[]' id='counter_0' value='0'></td>
        </tr>
        </table></div>
    
    
    
    
    </div></td>
    
    <td valign="top" class="rightmenubg" id="filterspace" width="0%"></td>
  </tr>
</table>

    
    </td>
  </tr>
  
  <?php $this->load->view('web/addons/footer_normal');?>
</table>


<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
   $('.fancybox').fancybox();
});
</script>
</body>
</html>
