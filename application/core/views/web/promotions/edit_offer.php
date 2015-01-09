<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="3%" onClick="updateFieldLayer('<?php echo base_url()."web/promotions/update_promotion_by_score/t/".encrypt_value('200');?>','','','containerdiv','')"><a href="javascript:;"><img src="<?php echo base_url();?>assets/images/back_arrow_grey.png" border="0"></a></td>
    <td width="3%"><table border="0" cellspacing="0" cellpadding="2" class="rewardcardbig greenbg" style="width:90px;">
  <tr>
    <td class="toprow"></td>
  </tr>
  <tr>
    <td class="bottomrow" style="text-align:left; padding-left:5px;" nowrap><input type="text" name="editofferpercent" id="editofferpercent" value="5" class="textfield" style="width:52px; padding:4px;">%</td>
  </tr>
</table></td>
    <td align="left" class="pagesubtitle" style="padding-top:5px; text-align:left;">Cash Back<br>
<span class="opensansmedium">200+ points</span></td>
    <td width="1%" style="min-width:100px;"><input type="button" name="savebtn" id="savebtn" value="Save" class="forrestgreenbtn" style="width:100px;"></td>
    <td width="1%" style="min-width:100px;"><input type="button" name="deletebtn" id="deletebtn" value="Delete" class="greybtn" style="width:100px;"></td>
  </tr>
</table>

</td></tr>

<tr><td style="padding-top:10px;padding-left:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="tabgroup" style="padding-left:10px; text-align:left;"><div id="daystimes_tab" class="currenttabcell" onClick="updateTabColors('daystimes_tab','currenttabcell','tabcell');updateFieldLayer('<?php echo base_url()."web/promotions/show_edit_fields/t/".encrypt_value('daystimes');?>','','','tab_content_div','')">days/times</div><div id="locations_tab" class="tabcell" onClick="updateTabColors('locations_tab','currenttabcell','tabcell');updateFieldLayer('<?php echo base_url()."web/promotions/show_edit_fields/t/".encrypt_value('locations');?>','','','tab_content_div','');">locations</div><div id="loyalty_tab" class="tabcell" onClick="updateTabColors('loyalty_tab','currenttabcell','tabcell');updateFieldLayer('<?php echo base_url()."web/promotions/show_edit_fields/t/".encrypt_value('loyalty');?>','','','tab_content_div','')">loyalty</div><div id="competition_tab" class="tabcell" onClick="updateTabColors('competition_tab','currenttabcell','tabcell');updateFieldLayer('<?php echo base_url()."web/promotions/show_edit_fields/t/".encrypt_value('competition');?>','','','tab_content_div','')">competition</div><div id="demographics_tab" class="tabcell" onClick="updateTabColors('demographics_tab','currenttabcell','tabcell');updateFieldLayer('<?php echo base_url()."web/promotions/show_edit_fields/t/".encrypt_value('demographics');?>','','','tab_content_div','')">demographics</div><div id="runtime_tab" class="righttab tabcell" onClick="updateTabColors('runtime_tab','currenttabcell','tabcell');updateFieldLayer('<?php echo base_url()."web/promotions/show_edit_fields/t/".encrypt_value('runtime');?>','','','tab_content_div','')">run time</div></td>
  </tr>
  <tr>
    <td class="tabcontent" style="border-top: solid 1px #CCC; color:#333;">
    <div id="tab_content_div">
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

    </div>
    </td>
  </tr>
</table></td></tr>

</table>