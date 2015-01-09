<?php 
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>".get_AJAX_constructor(TRUE); 
$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 


#Category details
if($area == 'category_details')
{
	$tableHTML .= '<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="pagetitle">Add Favorites</td>
      </tr>
      <tr>
        <td class="pagesubtitle" style="padding-bottom:30px;">Get notified about special events, sales and promotions.</td>
      </tr>
      <tr>
        <td style="padding:0px; padding-left:20px;" valign="top"><table align="center" border="0" cellspacing="0" cellpadding="5"  class="sectiontable bluetop">
          <thead>
		  <tr>
            <td>'.(!empty($main)? ucwords($main): '').(!empty($submain)? " - <span class='greysectionheader'>".ucwords($submain)."</span>": "").'</td>
          </tr>
		  </thead>
		  <tr>
            <td valign="top" style="padding-top:10px;padding-bottom:10px; border-bottom: 1px solid #DDD;"><input name="searchfavs" type="text" class="searchfield" id="searchfavs" value="" placeholder="Enter name or website address" style="font-size: 18px;width:500px;" /></td>
          </tr>';
     
	 if($main == 'restaurants')
	 {     
	  	$tableHTML .= '<tr>
            <td valign="top" class="contentlistcell" style="background-color:#FFF;"><div class="contentlistdiv">
              <div class="contentitemdiv">Taco Bell</div>
              <div class="contentitemdiv">Imagine Foods</div>
              <div class="contentitemdiv">80\'s Burgers</div>
              <div class="contentitemdiv">80\'s Burgers</div>
            </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Taco Bell</div>
                <div class="contentitemdiv">Imagine Foods</div>
                <div class="contentitemdiv">80\'s Burgers And Friends</div>
                <div class="contentitemdiv">80\'s Burgers</div>
              </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Taco Bell</div>
                <div class="contentitemdiv">Imagine Foods</div>
                <div class="contentitemdiv">80\'s Burgers</div>
                <div class="contentitemdiv">80\'s Burgers</div>
              </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Taco Bell</div>
                <div class="contentitemdiv">Imagine Foods For Fido</div>
                <div class="contentitemdiv">80\'s Burgers</div>
                <div class="contentitemdiv">80\'s Burgers</div>
              </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Taco Bell</div>
                <div class="contentitemdiv">Imagine Foods</div>
                <div class="contentitemdiv">80\'s Burgers</div>
                <div class="contentitemdiv">80\'s Burgers</div>
              </div></td>
          </tr>';
	 }
	 else
	 {
		 $tableHTML .= '<tr>
            <td valign="top" class="contentlistcell" style="background-color:#FFF;"><div class="contentlistdiv">
              <div class="contentitemdiv">Place 001</div>
              <div class="contentitemdiv">Place 002</div>
              <div class="contentitemdiv">Place 003</div>
              <div class="contentitemdiv">Place 004</div>
            </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Place 005</div>
                <div class="contentitemdiv">Place 006</div>
                <div class="contentitemdiv">Place 007</div>
                <div class="contentitemdiv">Place 008</div>
              </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Place 009</div>
                <div class="contentitemdiv">Place 010</div>
                <div class="contentitemdiv">Place 011</div>
                <div class="contentitemdiv">Place 012</div>
              </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Place 013</div>
                <div class="contentitemdiv">Place 014</div>
                <div class="contentitemdiv">Place 015</div>
                <div class="contentitemdiv">Place 016</div>
              </div>
              <div class="contentlistdiv">
                <div class="contentitemdiv">Place 017</div>
                <div class="contentitemdiv">Place 018</div>
                <div class="contentitemdiv">Place 019</div>
                <div class="contentitemdiv">Place 020</div>
              </div></td>
          </tr>';
     }
		  
     $tableHTML .= '
        </table></td>
      </tr>
    </table>';
}




echo $tableHTML;
?>