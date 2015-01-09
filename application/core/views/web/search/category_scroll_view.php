
<script src='<?php echo base_url();?>assets/js/jquery.als-1.3.min.js' type='text/javascript'></script>

<script type="text/javascript">
$(document).ready(function(){
	var numberOfElements = <?php echo $categoryData['total_categories'];?>;
	var containerWidth = $('.als-viewport').width();
	var elementsPerSlide = Math.floor(containerWidth/160);
	if(elementsPerSlide >= numberOfElements)
	{
		elementsPerSlide = numberOfElements;
		$("#category_list_next_action").hide('fast');
	}
	
	//Now get the number of sets
	var noOfslides = Math.ceil(numberOfElements/elementsPerSlide);
	$("#category_list_total_slides").val(noOfslides);
	$("#category_list_per_slide").val(elementsPerSlide);
	
	$("#category_list").als({
		visible_items: elementsPerSlide,
		scrolling_items: (elementsPerSlide-1),
		orientation: "horizontal",
		circular: "no",
		autoscroll: "no",
		start_from: 0,
		speed: 300
	});
	
	$('.als-item div').on('click', function(){
		$('.als-item div').removeClass('selected_highlight');
		$(this).addClass('selected_highlight');
		
		$('#display_search_category').html("in <b>"+$(this).find('td.subsectiontitle').html()+"</b>");
		$('#search_category').val($(this).find('td.subsectiontitle').attr("data-rel"));
	});
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

.als-prev, .als-next {
	position: absolute;
	cursor: pointer;
	clear: both;
}


/*************************************
 * specific styling for #category_list
 ************************************/

#category_list {
	margin: 5px auto;
	float:left;
}

#category_list .als-item {
	margin: 0px 0px;
	padding: 3px 4px;
	min-height: 100px;
	min-width: 100px;
	text-align: center;
}
#category_list .highlightbox {
	margin: 0px 7px;
	width: 160px;
}
</style>

<div class="als-container" id="category_list">
  <span class="als-prev" id="category_list_previous"></span><!-- The control buttons are called from another view by simulating clicking-->
  <div class="als-viewport" id="category_slider_window">
    <ul class="als-wrapper">
      <?php
	  foreach($categoryData['category_list'] AS $category)
	  {
		  echo "<li class='als-item'><div class='highlightbox'>
        <table width='100%' cellpadding='10'>
          <tr><td style='height:50px;'><img src='".base_url()."assets/images/".$category['icon_url']."'></td></tr>
          <tr><td style='padding-top:0px;' class='subsectiontitle' data-rel='".$category['id']."' nowrap>".$category['category_name']."</td></tr>
          </table>
        </div></li>";
	  }
	  ?>
      
    </ul>
  </div>
  <span class="als-next" id="category_list_next"></span>
</div>
<input type="hidden" name="category_list_total_slides" id="category_list_total_slides" value="1" />
<input type="hidden" name="category_list_current_slide" id="category_list_current_slide" value="1" />
<input type="hidden" name="category_list_per_slide" id="category_list_per_slide" value="0" />