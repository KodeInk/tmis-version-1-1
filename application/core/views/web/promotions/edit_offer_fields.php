<?php 	
#Days/Times
if(empty($type) || $type == 'daystimes')
{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%" style="text-align:left;padding:5px;" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="left">
      <tr>
        <td class="showtableplainhead">Blackout Days/Times:</td>
      </tr>
      <tr>
        <td><div id="time_001" style="padding:0px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width='1%' style="cursor:pointer; padding-right:5px;"><img src="<?php echo base_url();?>assets/images/delete_icon.png" border="0"></td><td style="text-align:left;">Mondays: 8am-10pm, 2pm-4pm</td></tr></table>
        </div>
        <div id="time_002" style="padding:0px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width='1%' style="cursor:pointer; padding-right:5px;"><img src="<?php echo base_url();?>assets/images/delete_icon.png" border="0"></td><td style="text-align:left;">Sundays: 4pm-8pm</td></tr></table>
        </div>
        
        
        </td>
      </tr>
      <tr>
        <td nowrap><select class="smallselect" name="filterday" id="filterday" style="margin-top:0px;width:120px;padding:5px 5px 5px 0px;">
              <option value="">Day</option>
              <option value="monday">Mondays</option>
              <option value="tuesday">Tuesdays</option>
              <option value="wednesday">Wednesdays</option>
              <option value="thursday">Thursdays</option>
              <option value="friday">Fridays</option>
              <option value="saturday">Saturdays</option>
              <option value="sunday">Sundays</option>
              </select> from:<select class="smallselect" name="time" id="time" style="margin-top:0px;width:90px;padding:5px 5px 5px 0px;">
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
              </select> to:<select class="smallselect" name="time" id="time" style="margin-top:0px;width:90px;padding:5px 5px 5px 0px;">
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
              </select></td>
      </tr>
      <tr>
        <td align="right"><input id="applychanges" name="applychanges" type="button" value="Add" class="bluebtn" style="font-size: 12px; padding: 3px 7px 3px 7px; width: 90px;"></td>
      </tr>
    </table></td>
    <td width="5%">&nbsp;</td>
    <td width="45%" style="text-align:left;padding:5px;" valign="top"><table border="0" cellspacing="0" cellpadding="0" align="left">
      <tr>
        <td class="showtableplainhead">Blackout Dates:</td>
      </tr>
      <tr>
        <td><div id="time_001" style="padding:0px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width='1%' style="cursor:pointer; padding-right:5px;"><img src="<?php echo base_url();?>assets/images/delete_icon.png" border="0"></td>
        <td style="text-align:left;">December 25th, 2015</td></tr></table>
        </div>
        <div id="time_002" style="padding:0px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width='1%' style="cursor:pointer; padding-right:5px;"><img src="<?php echo base_url();?>assets/images/delete_icon.png" border="0"></td>
        <td style="text-align:left;">October 31st, 2015</td></tr></table>
        </div>
        
        
        </td>
      </tr>
      <tr>
        <td nowrap><input id="blackoutdate" name="blackoutdate" type="text" value="" class="calendartextfield" placeholder="MM / DD / YYYY" style="font-size: 13px; padding: 5px; width:150px;"></td>
      </tr>
      <tr>
        <td align="right"><input id="applychanges" name="applychanges" type="button" value="Add" class="bluebtn" style="font-size: 12px; padding: 3px 7px 3px 7px; width: 90px;"></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php 	
}
else if($type == 'locations')
{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left;">
<tr>
<td><table><tr><td style="width:160px;" nowrap>Available at all locations:</td><td><input type="radio" id="alllocations_yes" name="alllocations[]" value="yes" onClick="hideLayerSet('all_locations_div')" checked></td><td>Yes</td><td><input type="radio" id="alllocations_no" name="alllocations[]" value="no" onClick="showLayerSet('all_locations_div')"></td><td>No</td></tr></table></td>
</tr>
<tr>
<td><div id="all_locations_div" style="display:none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td style="padding:0px;"><table>
<tr>
    <td style="width:160px;" nowrap>View locations by:</td>
    <td><input type="text" name="locationsearch" id="locationsearch" value="" placeholder="Search in locations" class="searchfield" style="width:230px;"></td><td nowrap> or select from:&nbsp; <input type="radio" id="locationsview_all" name="locationsview[]" value="all"></td><td>All</td><td><input type="radio" id="locationsview_country" name="locationsview[]" value="country"></td><td>Country</td><td><input name="locationsview[]" type="radio" id="locationsview_state" value="state" checked></td><td>State</td><td><input type="radio" id="locationsview_city" name="locationsview[]" value="city"></td><td>City</td>
    </tr>
  
</table></td></tr>
<tr><td style="padding:0px;"><table><tr><td><input type="checkbox" id="selectallcheck" name="selectallcheck" value="all"></td><td>Select All</td></tr></table></td></tr>
<tr><td>
<table border="0" cellspacing="0" cellpadding="0" class="celltable">
<tr><td><input type="checkbox" id="al" name="states[]" value="AL"> Alabama (2)</td><td><input type="checkbox" id="ak" name="states[]" value="AK"> Alaska (1)</td><td><input type="checkbox" id="il" name="states[]" value="IL"> Illinois (16)</td><td><input type="checkbox" id="in" name="states[]" value="IN"> Indiana (3)</td></tr>

<tr><td><input type="checkbox" id="az" name="states[]" value="AZ"> Arizona</td><td><input type="checkbox" id="ar" name="states[]" value="AR"> Arkansas (5)</td><td><input name="states[]" type="checkbox" id="ca" value="CA" checked> 
  California (3)</td><td><input type="checkbox" id="CO" name="states[]" value="CO"> Colorado (6)</td></tr>

<tr><td><input type="checkbox" id="ct" name="states[]" value="CT"> Connecticut (11)</td><td><input type="checkbox" id="de" name="states[]" value="DE"> Delaware (2)</td><td><input type="checkbox" id="fl" name="states[]" value="FL"> Florida (17)</td><td><input type="checkbox" id="ga" name="states[]" value="GA"> Georgia (9)</td></tr>

<tr><td><input type="checkbox" id="hi" name="states[]" value="HI"> Hawaii (7)</td><td><input type="checkbox" id="id" name="states[]" value="ID"> Idaho (3)</td><td><input type="checkbox" id="ks" name="states[]" value="KS"> Kansas (2)</td><td>&nbsp;</td></tr>

</table>
</td></tr>

<tr><td>
<div style="border-top: solid 1px #CCC;">
<table><tr><td><input type="checkbox" id="selectallcheck" name="selectallcheck" value="all" onClick="selectAll(this,'addresslist')"></td><td>Select All<input name="addresslist" id="addresslist" type="hidden" value="address_001|address_002|address_003"></td></tr></table>
<table>
<tr><td><input type="checkbox" id="address_001" name="address[]" value="001"></td><td>125 St. Francis Drive, Los Angeles CA 90035</td></tr>
<tr><td><input type="checkbox" id="address_002" name="address[]" value="002"></td><td>75 Rodeo Blvd, Beverly Hills CA 90210</td></tr>
<tr><td><input type="checkbox" id="address_003" name="address[]" value="003"></td><td>575 San Vicente Blvd, Los Angeles CA 90036</td></tr>

</table>
</div>
</td></tr>

</table>
</div></td>
</tr>
</table>
<?php
}
#Loyalty
else if($type == 'loyalty')
{
?>
<table style="margin-bottom:20px; margin-top:10px;">
<tr><td style="text-align:right;" nowrap>Per transaction spending must exceed:</td><td nowrap="nowrap" style="text-align:left;"><input type="text" class="smalltextfield" id="per_transaction_spending" name="per_transaction_spending" value="" placeholder="$0" style="width:132px;"> <select class="smallselect" name="loyalty_condition_1" id="loyalty_condition_1" style="margin-top:0px;width:65px;padding:5px 5px 5px 0px;">
              <option value="off" selected>OFF</option>
              <option value="or">OR</option>
              <option value="and">AND</option>
  </select></td></tr>
<tr><td style="text-align:right;" nowrap>Lifetime spending must exceed:</td><td style="text-align:left;"><input type="text" class="smalltextfield" id="lifetime_spending" name="lifetime_spending" value="" placeholder="$0" style="width:132px;"> <select class="smallselect" name="loyalty_condition_2" id="loyalty_condition_2" style="margin-top:0px;width:65px;padding:5px 5px 5px 0px;">
              <option value="off" selected>OFF</option>
              <option value="or">OR</option>
              <option value="and">AND</option>
  </select></td></tr>
<tr><td style="text-align:right;" nowrap>Lifetime visits must exceed:</td><td style="text-align:left;"><input type="text" class="smalltextfield" id="lifetime_visits" name="lifetime_visits" value="" placeholder="0" style="width:132px;"> <select class="smallselect" name="loyalty_condition_2" id="loyalty_condition_2" style="margin-top:0px;width:65px;padding:5px 5px 5px 0px;">
              <option value="off" selected>OFF</option>
              <option value="or">OR</option>
              <option value="and">AND</option>
  </select></td></tr>
<tr><td style="text-align:right;" nowrap>Last visit must be:</td><td style="text-align:left;" nowrap> <select class="smallselect" name="loyalty_condition_3" id="loyalty_condition_3" style="margin-top:0px;width:110px;padding:5px 5px 5px 0px;">
              <option value="more_than" selected>More Than</option>
              <option value="less_than">Less Than</option>
  </select> <input type="text" class="smalltextfield" id="last_visit_period" name="last_visit_period" value="" placeholder="0" style="font-size:16px; width:30px;"> <select class="smallselect" name="visit_period_type" id="visit_period_type" style="margin-top:0px;width:90px;padding:5px 5px 5px 0px;">
              <option value="days">Days</option>
              <option value="weeks">Weeks</option>
              <option value="months">Months</option>
              <option value="years">Years</option>
              </select></td></tr>

</table>
<?php
}
#Competitors
else if($type == 'competition')
{
?>
<style>
.contentitemdiv, .deleteitemdiv {
	margin-left: 0px;
	font-family: Arial, Helvetica, sans-serif;
	font-size:14px;
	color: #333;
	min-width: 130px;
	max-width: 130px;
	padding:5px 5px 5px 25px;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left;">
<tr>
<td><table><tr><td style="width:160px;" nowrap>ONLY available to members who visited my competitors:</td><td><input type="radio" id="availablecompetitors_yes" name="availablecompetitors[]" value="yes" onClick="showLayerSet('available_competitors_div')"></td><td>Yes</td><td><input type="radio" id="availablecompetitors_no" name="availablecompetitors[]" value="no" onClick="hideLayerSet('available_competitors_div')" checked></td><td>No</td></tr></table></td>
</tr>
<tr>
<td><div id="available_competitors_div" style="display:none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td style="padding:0px;"><table>
<tr>
    <td><input type="text" name="competitorsearch" id="competitorsearch" value="" placeholder="Search by competitor name" class="searchfield" style="width:330px;"></td>
    </tr>
  
</table></td></tr>
<tr><td>
<table border="0" cellspacing="0" cellpadding="0" class="celltable">
<tr>
  <td><div class="contentitemdiv">Competitor 1</div></td><td><div class="contentitemdiv">Competitor 2</div></td><td><div class="contentitemdiv">Competitor 13</div></td><td><div class="contentitemdiv">Competitor 4</div></td></tr>

<tr><td><div class="contentitemdiv">Competitor 5</div></td><td><div class="contentitemdiv">Competitor 6</div></td><td><div class="contentitemdiv">Competitor 7</div></td><td><div class="contentitemdiv">Competitor 8</div></td></tr>

<tr><td><div class="contentitemdiv">Competitor 9</div></td><td><div class="contentitemdiv">Competitor 10</div></td><td><div class="contentitemdiv">Competitor 11</div></td><td><div class="contentitemdiv">Competitor 12</div></td></tr>

</table>
</td></tr>

<tr><td>
<div style="border-top: solid 1px #CCC;">
  <table>
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0"><tr><td width="1%"><b>Selected:</b></td><td width="99%" align="right"><div class="contentitemdiv"><b>Add all results listed above</b></div></td></tr></table></td>
    </tr>
<tr><td><table border="0" cellspacing="0" cellpadding="0" class="celltable">
<tr>
  <td><div class="deleteitemdiv">Competitor 16</div></td><td><div class="deleteitemdiv">Competitor 18</div></td><td><div class="deleteitemdiv">Competitor 3</div></td><td><div class="deleteitemdiv">Competitor 24</div></td></tr>

<tr><td><div class="deleteitemdiv">Competitor 21</div></td><td><div class="deleteitemdiv">Competitor 20</div></td><td>&nbsp;</td><td>&nbsp;</td></tr>

</table></td></tr>

</table>
</div>
</td></tr>

</table>
</div></td>
</tr>
</table>
<?php
}
#Demographics
else if($type == 'demographics')
{
	
	echo "<table width='100%'><tr><td>".format_notice('WARNING: Projected audience is less than 100 customers per month. Remove some restrictions to widen it.')."</td></tr></table>";
?>
<table style="margin-bottom:20px; margin-top:10px;">
<tr>
  <td style="text-align:right;" nowrap>Age Restriction:</td>
  <td style="text-align:left;"><input type="radio" id="agerestriction_no" name="agerestrictioncheck[]" value="no" onClick="hideLayerSet('agerestriction_div')" checked></td>
  <td style="text-align:left; width:40px;height:30px;">No</td>
  <td style="text-align:left;"><input type="radio" id="agerestriction_yes" name="agerestrictioncheck[]" value="yes" onClick="showLayerSet('agerestriction_div')"></td>
  <td style="text-align:left; width:40px;">Yes</td>
  <td style="text-align:left;"><div id="agerestriction_div" style="display:none;"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap><input name="fromage" type="text" class="textfield" id="fromage" style="width:60px; font-size:12px;" value="" placeholder="From Age"> to <input name="toage" type="text" class="textfield" id="toage" style="width:60px; font-size:12px;" value="" placeholder="To Age"></td>
  </tr></table></div></td>
</tr>


<tr>
  <td style="text-align:right;" nowrap>Gender Restriction:</td>
  <td style="text-align:left;"><input type="radio" id="genderrestriction_no" name="genderrestrictioncheck[]" value="no" onClick="hideLayerSet('genderrestriction_div')" checked></td>
  <td style="text-align:left; width:40px;">No</td>
  <td style="text-align:left;"><input type="radio" id="genderrestriction_yes" name="genderrestrictioncheck[]" value="yes" onClick="showLayerSet('genderrestriction_div')"></td>
  <td style="text-align:left; width:40px;">Yes</td>
  <td style="text-align:left;"><div id="genderrestriction_div" style="display:none;"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap><select class="smallselect" name="gender" id="gender" style="margin-top:0px;width:77px;padding:5px 5px 5px 0px;">
    <option value="" selected>Gender</option>
    <option value="female">Female</option>
    <option value="male">Male</option>
    </select></td>
  </tr></table></div></td></tr>
<tr>
  <td style="text-align:right;" nowrap>Network Size Restriction:</td>
  <td style="text-align:left;"><input type="radio" id="nwsizerestriction_no" name="nwsizerestrictioncheck[]" value="no" onClick="hideLayerSet('nwsizerestriction_div')" checked></td>
  <td style="text-align:left; width:40px;">No</td>
  <td style="text-align:left;"><input type="radio" id="nwsizerestriction_yes" name="nwsizerestrictioncheck[]" value="yes" onClick="showLayerSet('nwsizerestriction_div')"></td>
  <td style="text-align:left; width:40px;">Yes</td>
  <td style="text-align:left;"><div id="nwsizerestriction_div" style="display:none;"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap><select class="smallselect" name="networksizerestriction" id="networksizerestriction" style="margin-top:0px;width:120px;padding:5px 5px 5px 0px;">
    <option value="greater_than" selected>Greater Than</option>
    <option value="less_than">Less Than</option>
    </select></td>
    <td class="ariallabel" style="font-size:14px;padding-top:10px;"  nowrap><input type="text" name="nwsizevalue" id="nwsizevalue" value="" placeholder="0" class="smalltextfield" style="width:40px;"></td>
  </tr></table></div></td>
</tr>
<tr>
  <td valign="top" nowrap style="text-align:right;">Location Restriction:</td>
  <td valign="top" style="text-align:left;"><input type="radio" id="locationrestriction_no" name="locationrestrictioncheck[]" value="no" onClick="hideLayerSet('locationrestriction_div')" checked></td>
  <td valign="top" style="text-align:left; width:40px;">No</td>
  <td valign="top" style="text-align:left;"><input type="radio" id="locationrestriction_yes" name="locationrestrictioncheck[]" value="yes" onClick="showLayerSet('locationrestriction_div')"></td>
  <td valign="top" style="text-align:left; width:40px;">Yes</td>
  <td style="text-align:left;"><div id="locationrestriction_div" style="display:none;"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="ariallabel" style="font-size:14px;"  nowrap><select class="smallselect" name="distancefrom" id="distancefrom" style="margin-top:0px;width:130px;padding:5px 5px 5px 0px;">
    <option value="" selected>Distance</option>
    <option value="0.25">1/4 mile</option>
    <option value="1">1 mile</option>
    <option value="5">5 miles</option>
    <option value="10">10 miles</option>
    <option value="25">25 miles</option>
    <option value="50">50 miles</option>
    <option value="100">100 miles</option>
    <option value="any">Any distance</option>
    </select></td>
  </tr>
  
  <tr><td>
  <table><tr><td>From: </td><td><input type="radio" id="locationorigin_anystore" name="locationorigincheck[]" value="anystore" onClick="hideLayerSet('anaddress_div<>astore_div');" checked></td><td>Any of my stores</td><td><input type="radio" id="locationorigin_astore" name="locationorigincheck[]" value="astore" onClick="showLayerSet('astore_div');hideLayerSet('anaddress_div<>groupstore_div');"></td><td>A store</td>
  <td><input type="radio" id="locationorigin_groupstore" name="locationorigincheck[]" value="groupstore" onClick="showLayerSet('groupstore_div');hideLayerSet('anaddress_div<>astore_div');"></td><td>Group of my stores</td>
  <td><input type="radio" id="locationorigin_anaddress" name="locationorigincheck[]" value="anaddress" onClick="hideLayerSet('astore_div<>groupstore_div');showLayerSet('anaddress_div');"></td><td>An Address</td></tr>
    <tr>
      <td colspan="7" style="width:450px;" nowrap><div id="astore_div" style="display:none;"><input type="text" name="storesearch" id="storesearch" value="" placeholder="Enter a store name" class="searchfield" style="width:360px;"></div>
      
      <div id="groupstore_div" style="display:none;"><input type="text" name="groupstoresearch" id="groupstoresearch" value="" placeholder="Enter store or city name and select" class="searchfield" style="width:360px;"></div>
      
      <div id="anaddress_div" style="display:none;"><select class="smallselect" name="storecountry" id="storecountry">
      <option value="">Country</option>
      <option value="United States">United States</option>
      </select> 
      <select class="smallselect" name="storestate" id="storestate">
      <option value="">State</option>
      <option value="CA">California</option>
      <option value="KY">Kentucky</option>
      <option value="ID">Idaho</option>
      </select> <input type="text" name="cityzipcode" id="cityzipcode" value="" placeholder="Enter a city or zip code(s)" class="searchfield" style="width:200px;"></div></td>
      </tr>
  </table>
  </td></tr>
  </table></div></td>
</tr>

</table>



<?php 
}
#Run Time
else if($type == 'runtime')
{
?>
<table style="margin-bottom:20px; margin-top:10px;">
<tr>
  <td style="text-align:right;" nowrap>Offer Start Date:</td>
  <td style="text-align:left;"><table><tr><td><input type="radio" id="startdatecheck_yes" name="startdatecheck[]" value="yes" onClick="hideLayerSet('startdate_div')" checked></td>
    <td style="width:150px;">When I publish</td><td><input type="radio" id="startdatecheck_no" name="startdatecheck[]" value="no" onClick="showLayerSet('startdate_div')"></td>
    <td>Select Date</td>
    <td><div id="startdate_div" style="display:none;"><input id="startdate" name="startdate" type="text" value="" class="calendartextfield" placeholder="MM / DD / YYYY" style="font-size: 13px; padding: 5px; width:150px;"></div></td>
  </tr>
  </table></td></tr>


<tr>
  <td style="text-align:right;" nowrap>Offer End Date:</td>
  <td style="text-align:left;"><table><tr><td><input type="radio" id="enddatecheck_yes" name="enddatecheck[]" value="yes" onClick="hideLayerSet('enddate_div')" checked></td>
    <td style="width:150px;">When I delete offer</td><td><input type="radio" id="enddatecheck_no" name="enddatecheck[]" value="no" onClick="showLayerSet('enddate_div')"></td>
    <td>Select Date</td>
    <td><div id="enddate_div" style="display:none;"><input id="enddate" name="enddate" type="text" value="" class="calendartextfield" placeholder="MM / DD / YYYY" style="font-size: 13px; padding: 5px; width:150px;"></div></td>
  </tr>
  </table></td></tr>

</table>



<?php 
}
else
{
	echo format_notice('ERROR: Fields are not yet set.');
}
?>