
<script src='<?php echo base_url();?>assets/js/jquery.als-1.3.min.js' type='text/javascript'></script>

<script type="text/javascript">
$(document).ready(function(){
	var numberOfElements = <?php echo count($photos);?>;
	var containerWidth = $('.als-viewport').width();
	var elementsPerSlide = Math.floor(containerWidth/140);
	if(elementsPerSlide >= numberOfElements)
	{
		elementsPerSlide = numberOfElements;
		$("#photo_list_next_action").hide('fast');
	}
	
	//Now get the number of sets
	var noOfslides = Math.ceil(numberOfElements/elementsPerSlide);
	$("#photo_list_total_slides").val(noOfslides);
	$("#photo_list_per_slide").val(elementsPerSlide);
	
	$("#photo_list").als({
		visible_items: elementsPerSlide,
		scrolling_items: (elementsPerSlide-1),
		orientation: "horizontal",
		circular: "no",
		autoscroll: "no",
		start_from: 0,
		speed: 300
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

</style>

<div class="als-container" id="item_list">
  <span class="als-prev" id="item_list_previous"></span><!-- The control buttons are called from another view by simulating clicking-->
  <div class="als-viewport" id="item_slider_window">
    <ul class="als-wrapper">
      <?php
	  foreach($photos AS $photo)
	  {
		  echo "<li class='als-item'>
		  <div href='".base_url()."web/page/view_image_details/u/".encrypt_value(str_replace('_image_', '_image_large_', $photo['file_url']))."' class='fancybox fancybox.ajax' style='border-radius: 7px; -webkit-border-radius: 7px; -moz-border-radius: 7px;background: url(".base_url()."assets/uploads/images/".$photo['file_url'].") no-repeat; width:122px; height:102px; cursor:pointer; -webkit-box-shadow: 1px 1px 2px #666; -moz-box-shadow: 1px 1px 2px #666; box-shadow: 1px 1px 2px #666; margin: 10px;display:inline-block;'></div>
		  </li>";
	  }
	  ?>
      
    </ul>
  </div>
  <span class="als-next" id="item_list_next"></span>
</div>
<input type="hidden" name="item_list_total_slides" id="item_list_total_slides" value="1" />
<input type="hidden" name="item_list_current_slide" id="item_list_current_slide" value="1" />
<input type="hidden" name="item_list_per_slide" id="item_list_per_slide" value="0" />