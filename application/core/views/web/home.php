<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Upgrade your life!";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.2.min.js"></script>
	
	<?php 
	echo get_ajax_constructor(TRUE);
	 
	echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
<style>
#card_div {
	display:inline-block;
	float:right;
    background:url(<?php echo base_url();?>assets/images/card_1.png) no-repeat;
	width: 260px;
	height: 170px;
}


#card_section {
    background:url(<?php echo base_url();?>assets/images/card_1.png) 130px 0 no-repeat;
	width: 260px;
	height: 170px;
	position:absolute;
	z-index: 50;
}


#machine_front {
    background:url(<?php echo base_url();?>assets/images/machine_front.png) center no-repeat;
	width: 531px;
	height: 142px;
	vertical-align:bottom;
	position:absolute;
	z-index: 100;
	text-align:center;
	display:inline-block;
}


#machine_back {
    background:url(<?php echo base_url();?>assets/images/machine_back.png) center no-repeat;
	width: 531px;
	height: 142px;
	vertical-align:bottom;
	position:absolute;
	z-index:0;
	display:inline-block;
	margin-left:auto;
	margin-right:auto;
}
</style>

<script type="text/javascript">
//Reload the page to get the new window size
$(window).bind('resize',function(){
     window.location.href = window.location.href;
});


$(document).ready(function() {
    var windowHeight = $(document).height(); 
    var windowWidth = $(document).width(); 
	var totalDuration = 1600;
	var card = $('#card_section');
	var machineFront = $('#machine_front');
	var machineBack = $('#machine_back');
	
    $('#pagecontentarea').css('height', (windowHeight - 238)+'px');  
	//Lift the card up to meet the swiping image
    card.css('margin-top', '-'+70+'px');
	machineFront.css('margin-left', ((windowWidth/2) - (machineFront.width()/2))+'px');
	machineBack.css('margin-left', ((windowWidth/2) - (machineBack.width()/2))+'px');
	
    //1. First put the card slightly off the page with the style
	showNewCard(card,windowWidth,totalDuration);
    //2. Now move it to the center
	card.animate({'marginLeft' : "-="+(windowWidth*0.40)+"px"}, ((windowWidth*0.40) - (card.width()/2))*totalDuration/windowWidth);
	//3. Move it slower after the machine
	card.animate({'marginLeft' : "-="+(windowWidth*0.60 - (card.width()/2))+"px"}, ((windowWidth*0.60) - (card.width()/2))*totalDuration/windowWidth);
	
});


//Start showing new card
function showNewCard(card,windowWidth,totalDuration)
{
	card.hide();
	card.css('marginLeft', "+="+(windowWidth-card.width())+"px");
	card.show();
	
	//Background slide time
	//Divide by 2 because only half was hidden
	var cardDuration = ((card.width()/2) / windowWidth) * totalDuration;
	showFullCardOnRightSide(card, cardDuration);
}


//Show full card on right side
function showFullCardOnRightSide(card, slideDuration)
{
	card.animate({'background-position': 0},
		{step: function(now, fx) {
    		$(fx.elem).css("background-position", now+"px 0px");
			now+=1;
  		},
 		duration: slideDuration
	});
}


</script>
</head>

<body class="greybodybg">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>
<div class="fadinglinebottom"><table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="5%"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logo_white.png" border="0"></a></td>
    <td width="80%">&nbsp;</td>
    <td width="5%"><a href="<?php echo base_url();?>web/account/login" class="robototext whitebigtext">Login</a></td>
    <td width="5%">&nbsp;</td>
  </tr>
</table>
</div>
</td></tr>

<tr><td align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><img src="<?php echo base_url();?>assets/images/add_cash_back.png" border="0"></td>
  </tr>
  <tr>
    <td id="pagecontentarea" onClick="location.href='<?php echo base_url();?>web/account/signup'" style="cursor:pointer;"><div id="machine_front"></div><div id="machine_back"></div><div id="card_section"></div></td>
  </tr>
</table>
</td></tr>

<tr><td>
<?php $this->load->view('web/addons/footer_public', array('area'=>'home'));?>
</td></tr>
</table>





</body>
</html>