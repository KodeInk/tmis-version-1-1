<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Survey</title>

	<link rel='stylesheet' href='<?php base_url();?>assets/css/clout.css' type='text/css' media='screen' />
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
	<script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
<?php echo get_ajax_constructor(TRUE);?>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
      
      
<?php 
if(!empty($step) && $step == '1')
{
?>
      <tr>
        <td class="pagetitle" style="padding-top:30px;">Get <span class="bluetext">20</span> Points!</td>
      </tr>
      <tr>
        <td class="pagesubtitle" style="padding-bottom:30px;">Who are Mariscos Jalisco's top competitors?</td>
      </tr>
      <tr>
        <td style="padding:0px 40px 10px 30px;" valign="top"><table width="100%" align="center" style="border: 1px solid #CCC;">
          <tr>
            <td valign="top" class="pagesubtitle" style="color:#2DA0D1;padding-top:10px;">Suggestions:</td>
          </tr>
          <tr>
            <td valign="top" class="contentlistcell"><div class="contentlistdiv">
              <div class="contentitemdiv">Cactus Joe's</div>
              <div class="contentitemdiv">Imagine Foods</div>
              <div class="contentitemdiv">80's Burgers</div>
              <div class="contentitemdiv">80's Burgers</div>
            </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Cabo Cantina</div>
                <div class="contentitemdiv">Imagine Foods</div>
                <div class="contentitemdiv">80's Friends</div>
                <div class="contentitemdiv">80's Burgers</div>
              </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Sea Food 007</div>
                <div class="contentitemdiv">Imagine Foods</div>
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
          
          
          
          
          <tr>
            <td valign="top" style="padding-top:40px;padding-bottom:25px;"><input name="searchfavs" type="text" class="searchfield" id="searchfavs" value="" placeholder="Enter name or website address" style="font-size: 18px;width:500px;" /></td>
          </tr>
        </table></td>
      </tr>
      
      
          <tr>
        <td class="pagesubtitle" style="padding-bottom:20px; padding-top:40px;">Your Selections</td>
      </tr>
      <tr>
        <td style="padding:0px 40px 10px 30px;" valign="top"><table width="500" align="center" border="0"  cellspacing="0" cellpadding="0" style="border: 1px solid #CCC; border-top: 0px solid #CCC;">
          <tr>
            <td valign="top" class="contentlistcell"><div id='fav_001'><table width="100%"  border="0" cellspacing="0" cellpadding="5"  class="ariallabel selectedmenulist" style="border-top: 0px solid #CCC;">
    <tr class='favrow'>
      <td width="1%" nowrap>1.</td>
    <td width="98%" colspan="3" style="padding-right: 15px;" nowrap>Fave Dave</td><td width="1%"><div style="float:right; cursor:pointer; vertical-align:bottom;" onClick="hideLayerSet('fav_001')"><img src="<?php echo base_url();?>assets/images/remove_icon.png"></div></td>
    </tr>
    </table></div>
    
    <div id='fav_002'><table width="100%"  border="0" cellspacing="0" cellpadding="5"  class="ariallabel selectedmenulist" style="border-top:0px solid #CCC;">
    <tr class='favrow'>
      <td width="1%" nowrap>2.</td>
    <td width="98%" colspan="3" style="padding-right: 15px;" nowrap>Five For Fighting</td><td width="1%"><div style="float:right; cursor:pointer; vertical-align:bottom;" onClick="hideLayerSet('fav_002')"><img src="<?php echo base_url();?>assets/images/remove_icon.png"></div></td>
    </tr>
    </table></div>
    
    <div id='fav_003'><table width="100%"  border="0" cellspacing="0" cellpadding="5"  class="ariallabel selectedmenulist">
    <tr class='favrow'>
      <td width="1%" nowrap>3.</td>
    <td width="98%" colspan="3" style="padding-right: 15px;" nowrap>Mary Jane's</td><td width="1%"><div style="float:right; cursor:pointer; vertical-align:bottom;" onClick="hideLayerSet('fav_003')"><img src="<?php echo base_url();?>assets/images/remove_icon.png"></div></td>
    </tr>
    </table></div>
    
    
    <div id='fav_004'><table width="100%"  border="0" cellspacing="0" cellpadding="5"  class="ariallabel selectedmenulist">
    <tr class='favrow'>
      <td width="1%" nowrap>4.</td>
    <td width="98%" colspan="3" style="padding-right: 15px;" nowrap>Lollipop</td><td width="1%"><div style="float:right; cursor:pointer; vertical-align:bottom;" onClick="hideLayerSet('fav_004')"><img src="<?php echo base_url();?>assets/images/remove_icon.png"></div></td>
    </tr>
    </table></div>
    
    
    <div id='fav_005'><table width="100%"  border="0" cellspacing="0" cellpadding="5"  class="ariallabel selectedmenulist">
    <tr class='favrow'>
      <td width="1%" nowrap>5.</td>
    <td width="98%" colspan="3" style="padding-right: 15px;" nowrap>Peter's Joint</td><td width="1%"><div style="float:right; cursor:pointer; vertical-align:bottom;" onClick="hideLayerSet('fav_005')"><img src="<?php echo base_url();?>assets/images/remove_icon.png"></div></td>
    </tr>
    </table></div>
    
    
    <div id='fav_006'><table width="100%"  border="0" cellspacing="0" cellpadding="5"  class="ariallabel selectedmenulist">
    <tr class='favrow'>
      <td width="1%" nowrap>6.</td>
    <td width="98%" colspan="3" style="padding-right: 15px;" nowrap>Burger John</td><td width="1%"><div style="float:right; cursor:pointer; vertical-align:bottom;" onClick="hideLayerSet('fav_006')"><img src="<?php echo base_url();?>assets/images/remove_icon.png"></div></td>
    </tr>
    </table></div>
    
    <div id='fav_007'><table width="100%"  border="0" cellspacing="0" cellpadding="5"  class="ariallabel selectedmenulist">
    <tr class='favrow'>
      <td width="1%" nowrap>7.</td>
    <td width="98%" colspan="3" style="padding-right: 15px;" nowrap>Whatever Place</td><td width="1%"><div style="float:right; cursor:pointer; vertical-align:bottom;" onClick="hideLayerSet('fav_007')"><img src="<?php echo base_url();?>assets/images/remove_icon.png"></div></td>
    </tr>
    </table></div>
    
    <div id='fav_008'><table width="100%"  border="0" cellspacing="0" cellpadding="5"  class="ariallabel selectedmenulist">
    <tr class='favrow'>
      <td width="1%" nowrap>8.</td>
    <td width="98%" colspan="3" style="padding-right: 15px;" nowrap>Wow For You</td><td width="1%"><div style="float:right; cursor:pointer; vertical-align:bottom;" onClick="hideLayerSet('fav_008')"><img src="<?php echo base_url();?>assets/images/remove_icon.png"></div></td>
    </tr>
    </table></div></td>
          </tr>
          
          
          
    </table>
 </td>
 </tr>
 
 <?php 
 }
 else if(!empty($step) && $step == '2')
 {
 ?>
 
 <tr>
        <td class="pagetitle" style="padding-top:30px;">Who's Better and Why?</td>
      </tr>
      <tr>
        <td class="pagesubtitle" style="padding-top:60px;padding-bottom:10px;">Mariscos Jalisco &nbsp; Vs &nbsp; Cactus Joe's</td>
      </tr>
      <tr>
        <td style="padding:0px 40px 10px 30px;" valign="top"><table width="500" align="center" class="ariallabel" cellpadding="5" style="border: 1px solid #CCC; padding-left:20px; padding-right:20px;">
          <tr>
            <td valign="top" witdh="1%">&nbsp;</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Same</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Mariscos Jalisco</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Cactus Joe's</td>
           </tr>
           
           <tr>
             <td valign="top" style="text-align:left;" nowrap>Product Quality</td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td valign="top" style="text-align:left;" nowrap>Price / Value</td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td valign="top" style="text-align:left;" nowrap>Facilities / Decore</td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td style="text-align:left;" valign="top" nowrap>Selection / Menu</td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td  style="text-align:left;"valign="top" nowrap>Service</td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_3" value='cactus_joes' /></td>
            </tr>
            
            
            <tr>
            <td style="text-align:left;" valign="top" nowrap>Specific Product</td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_3" value='cactus_joes' /></td>
           
          </tr>
          <tr>
              <td colspan="4" align="right"><input name="qn_1_product" type="text" class="textfield" id="qn_1_product" value='' placeholder="Favorite Cactus Joe's Product" style="width:300px;"></td>
            </tr>
            <tr>
              <td colspan="4" style="height:10px;"></td>
            </tr>
 
        </table>
 </td></tr>
 
 
 
 
 
 
 
 <tr>
        <td class="pagesubtitle" style="padding-top:60px;padding-bottom:10px;">Mariscos Jalisco &nbsp; Vs &nbsp; Cabo Cantina</td>
      </tr>
      <tr>
        <td style="padding:0px 40px 10px 30px;" valign="top"><table width="500" align="center" class="ariallabel" cellpadding="5" style="border: 1px solid #CCC; padding-left:20px; padding-right:20px;">
          <tr>
            <td valign="top" witdh="1%">&nbsp;</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Same</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Mariscos Jalisco</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Cabo Cantina</td>
           </tr>
           
           <tr>
             <td valign="top" style="text-align:left;" nowrap>Product Quality</td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td valign="top" style="text-align:left;" nowrap>Price / Value</td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td valign="top" style="text-align:left;" nowrap>Facilities / Decore</td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td style="text-align:left;" valign="top" nowrap>Selection / Menu</td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td  style="text-align:left;"valign="top" nowrap>Service</td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_3" value='cactus_joes' /></td>
            </tr>
            
            
            <tr>
            <td style="text-align:left;" valign="top" nowrap>Specific Product</td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_3" value='cactus_joes' /></td>
           
          </tr>
          <tr>
              <td colspan="4" align="right"><input name="qn_2_product" type="text" class="textfield" id="qn_2_product" value='' placeholder="Favorite Cabo Cantina Product" style="width:300px;"></td>
            </tr>
            
            <tr>
              <td colspan="4" style="height:10px;"></td>
            </tr>
 
        </table>
 </td></tr>
 
 
 
 
 
 
 <tr>
        <td class="pagesubtitle" style="padding-top:60px;padding-bottom:10px;">Mariscos Jalisco &nbsp; Vs &nbsp; Sea Food 007</td>
      </tr>
      <tr>
        <td style="padding:0px 40px 10px 30px;" valign="top"><table width="500" align="center" class="ariallabel" cellpadding="5" style="border: 1px solid #CCC; padding-left:20px; padding-right:20px;">
          <tr>
            <td valign="top" witdh="1%">&nbsp;</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Same</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Mariscos Jalisco</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Sea Food 007</td>
           </tr>
           
           <tr>
             <td valign="top" style="text-align:left;" nowrap>Product Quality</td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td valign="top" style="text-align:left;" nowrap>Price / Value</td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td valign="top" style="text-align:left;" nowrap>Facilities / Decore</td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td style="text-align:left;" valign="top" nowrap>Selection / Menu</td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td  style="text-align:left;"valign="top" nowrap>Service</td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_3" value='cactus_joes' /></td>
            </tr>
            
            
            <tr>
            <td style="text-align:left;" valign="top" nowrap>Specific Product</td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_3" value='cactus_joes' /></td>
           
          </tr>
          <tr>
              <td colspan="4" align="right"><input name="qn_3_product" type="text" class="textfield" id="qn_3_product" value='' placeholder="Favorite Sea Food 007 Product" style="width:300px;"></td>
            </tr>
            
            <tr>
              <td colspan="4" style="height:10px;"></td>
            </tr>
 
        </table>
 </td></tr>
 
 
 
 
 
 <tr>
        <td class="pagesubtitle" style="padding-top:60px;padding-bottom:10px;">Mariscos Jalisco &nbsp; Vs &nbsp; 80's Burgers</td>
      </tr>
      <tr>
        <td style="padding:0px 40px 10px 30px;" valign="top"><table width="500" align="center" class="ariallabel" cellpadding="5" style="border: 1px solid #CCC; padding-left:20px; padding-right:20px;">
          <tr>
            <td valign="top" witdh="1%">&nbsp;</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Same</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Mariscos Jalisco</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>80's Burgers</td>
           </tr>
           
           <tr>
             <td valign="top" style="text-align:left;" nowrap>Product Quality</td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td valign="top" style="text-align:left;" nowrap>Price / Value</td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td valign="top" style="text-align:left;" nowrap>Facilities / Decore</td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td style="text-align:left;" valign="top" nowrap>Selection / Menu</td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td  style="text-align:left;"valign="top" nowrap>Service</td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_3" value='cactus_joes' /></td>
            </tr>
            
            
            <tr>
            <td style="text-align:left;" valign="top" nowrap>Specific Product</td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_3" value='cactus_joes' /></td>
           
          </tr>
          <tr>
              <td colspan="4" align="right"><input name="qn_4_product" type="text" class="textfield" id="qn_4_product" value='' placeholder="Favorite 80's Burgers Product" style="width:300px;"></td>
            </tr>
            <tr>
              <td colspan="4" style="height:10px;"></td>
            </tr>
 
        </table>
 </td></tr>
 
 
 
 
 <tr>
        <td class="pagesubtitle" style="padding-top:60px;padding-bottom:10px;">Mariscos Jalisco &nbsp; Vs &nbsp; Imagine Foods</td>
      </tr>
      <tr>
        <td style="padding:0px 40px 10px 30px;" valign="top"><table width="500" align="center" class="ariallabel" cellpadding="5" style="border: 1px solid #CCC; padding-left:20px; padding-right:20px;">
          <tr>
            <td valign="top" witdh="1%">&nbsp;</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Same</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Mariscos Jalisco</td>
            <td valign="top" style="padding:5px 20px 10px 20px;" nowrap>Imagine Foods</td>
           </tr>
           
           <tr>
             <td valign="top" style="text-align:left;" nowrap>Product Quality</td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_1" id="qn_1_option_1_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td valign="top" style="text-align:left;" nowrap>Price / Value</td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_2" id="qn_1_option_2_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td valign="top" style="text-align:left;" nowrap>Facilities / Decore</td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_3" id="qn_1_option_3_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td style="text-align:left;" valign="top" nowrap>Selection / Menu</td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_4" id="qn_1_option_4_ans_3" value='cactus_joes' /></td>
            </tr>
            
            <tr>
            <td  style="text-align:left;"valign="top" nowrap>Service</td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_5" id="qn_1_option_5_ans_3" value='cactus_joes' /></td>
            </tr>
            
            
            <tr>
            <td style="text-align:left;" valign="top" nowrap>Specific Product</td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_1" value='same' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_2" value='mariscos_jalisco' /></td>
            <td valign="top"><input type="radio" name="qn_1_option_6" id="qn_1_option_6_ans_3" value='cactus_joes' /></td>
           
          </tr>
          <tr>
              <td colspan="4" align="right"><input name="qn_4_product" type="text" class="textfield" id="qn_4_product" value='' placeholder="Favorite Imagine Foods Product" style="width:300px;"></td>
            </tr>
            <tr>
              <td colspan="4" style="height:10px;"></td>
            </tr>
 
        </table>
 </td></tr>
 
 
 <?php }?>
 
 
 <tr>
            <td  valign="top" style="padding-top:40px;padding-bottom:25px;"><input id="gotostep2" name="gotostep2" type="button" value="Submit" class="greenbtn" style="width:100px;" onclick="<?php
            if($step > 1)
			{
				echo "updateFieldLayer('".base_url()."web/search/show_deal_home', '', '', '', '')";
			}
			else
			{
				echo "updateFieldLayer('".base_url()."web/survey/show_store_survey/s/".encrypt_value($step)."', '', '', 'deal_home_content', '')";
			}
			?>"></td>
          </tr>
 </table>
</body>
</html>