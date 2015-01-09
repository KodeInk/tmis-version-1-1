<?php

if(!empty($sectionList) && $sectionType=='network')
{
	
	#Do not show this part if the user is not reloading the entire section
	if(empty($sectionArea))
	{
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%" id="network_list_table" class="networklisttable">
        
        <tr><td><input name="searchnetwork" type="text" class="searchfield" id="searchnetwork" value='' placeholder="Search by name or email" onkeyup="startInstantSearch('searchnetwork', 'searchby', '<?php echo base_url().'web/search/load_results/type/my_direct_network/layer/network_list';?>');updateFieldValue('network_list_table_noofentries', '10');showOnePageNav('navtablecontainer')" style="font-size: 14px;width:190px;"><input name="searchby" type="hidden" id="searchby" value="U.first_name__U.middle_name__U.last_name__U.email_address" /></td><td style="font-weight:bold;width:100px;">Last Activity</td><td style="font-weight:bold; width:60px;">Network</td><td style="font-weight:bold;  width:50px;">Invites</td></tr>
       <tr>
          <td colspan="4" style="padding:0px;">
          <div id="network_list">
<?php }?>
          <table border="0" cellspacing="0" cellpadding="0" width="100%" class="networklisttable" style="border:0px;">
	   <?php
	   $counter = 0;
	   foreach($sectionList AS $row)
	   {
		   echo "<tr ".($counter%2 == 0? " style='background-color:#FFF;'": "").">
          <td>";
		  if(!empty($row['photo_url']) && strpos(strtolower($row['photo_url']), 'http') !== FALSE)
		  {
			  $imgUrl = $row['photo_url'];
		  }
		  else if(!empty($row['photo_url']))
		  {
			  $imgUrl = base_url()."assets/uploads/images/".$row['photo_url'];
		  }
		  else
		  {
			  $imgUrl = base_url().'assets/uploads/images/default_network_user_icon.png';
		  }
		  
		  echo "<div class='circular' style='background: url(".$imgUrl.") no-repeat; display:inline-block;'></div><div style='display:inline-block; vertical-align:top; padding-left:10px; padding-top:10px;'><span style='font-weight:bold;'>".$row['name']."</span><br>
<span class='smalltxt'>".$row['email_address']."</span></div>
</td>
          <td style='width:100px;'>".(!empty($row['last_activity_date'])? format_date_interval($row['last_activity_date'], date('Y-m-d H:i:s', strtotime('now')), FALSE, TRUE, 'days'): 'never')."</td>
          <td style='width:60px;'>".format_number($row['total_network'],6)."</td>
          <td style='width:50px;border-right:0px;'>".format_number($row['total_invites'],6)."</td>
        </tr>";
        	
        	$counter++;
	   }
	   ?></table>
       
       
<?php 
#Do not show this part if the user is not reloading the entire section
if(empty($sectionArea))
{
?>
       </div>
 			</td>
        </tr>
        <tr>
          <td colspan="4" style="border-right: 0px solid #CCC;">
          <div style="display:inline-block; padding-top:3px; vertical-align:middle;" id="navtablecontainer">
          <?php 
		  
		  $currentPage = !empty($currentPage)? $currentPage: 1;
		  $noPerPage = !empty($noPerPage)? $noPerPage: 5;
		  $itemCount = !empty($itemCount)? $itemCount: 0;
		  $noOfPages = ceil($itemCount/$noPerPage);
		 
		  echo ($itemCount > $noPerPage)? pagination($itemCount, $noPerPage, $currentPage, 'network_list_table__pagination'): '';
		  
		  ?><input name="network_list_table_totalpageno" id="network_list_table_totalpageno" type="hidden" value="<?php echo !empty($noOfPages)? $noOfPages: 0;?>" />
<input name="network_list_table_showdiv" id="network_list_table_showdiv" type="hidden" value="network_list" />
<input name="network_list_table_action" id="network_list_table_action" type="hidden" value="<?php echo base_url().'web/network/show_part_of_network_list';?>" />
		</div>
        <div style="display:inline-block;float:right;">Show <select name="network_list_table_noofentries" id="network_list_table_noofentries" class="selecttextfield" onchange="updateFieldLayer('<?php echo base_url().'web/network/show_part_of_network_list';?>','network_list_table_noofentries','','section_list_container','')" style="width:60px; font-size:13px;">
      <?php
	  echo "<option value='5' ".($noPerPage+0 == 5? ' selected': '').">5</option>
      <option value='10' ".($noPerPage+0 == 10? ' selected': '').">10</option>
      <option value='20' ".($noPerPage+0 == 20? ' selected': '').">20</option>
      <option value='50' ".($noPerPage+0 == 50? ' selected': '').">50</option>";
	  ?>
      
      </select> entries
        </div>
</td>
          </tr>
        
        
        </table>

<?php }
}





else if(!empty($sectionList) && $sectionType=='invites')
{
	
	#Do not show this part if the user is not reloading the entire section
	if(empty($sectionArea))
	{
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%" id="invite_list_table" class="networklisttable">
        
        <tr><td><input name="searchinvites" type="text" class="searchfield" id="searchinvites" value='' placeholder="Search by name or email" onkeyup="startInstantSearch('searchinvites', 'invitesearchby', '<?php echo base_url().'web/search/load_results/type/my_invites/layer/invite_list';?>');updateFieldValue('invite_list_table_noofentries', '10');showOnePageNav('invitetablecontainer')" style="font-size: 14px;width:190px;"><input name="invitesearchby" type="hidden" id="invitesearchby" value="I.first_name__I.middle_name__I.last_name__I.email_address" /></td><td style="font-weight:bold;  width:100px;">Last Invite</td><td style="font-weight:bold;width:50px;">Invites</td><td style="font-weight:bold;  width:60px;">Status</td></tr>
       <tr>
          <td colspan="4" style="padding:0px;">
          <div id="invite_list">
<?php }?>
          <table border="0" cellspacing="0" cellpadding="0" width="100%" class="networklisttable" style="border:0px;">
	   <?php
	   $counter = 0;
	   foreach($sectionList AS $row)
	   {
		   echo "<tr ".($counter%2 == 0? " style='background-color:#FFF;'": "").">
          <td>";
		  if(!empty($row['photo_url']) && strpos(strtolower($row['photo_url']), 'http') !== FALSE)
		  {
			  $imgUrl = $row['photo_url'];
		  }
		  else if(!empty($row['photo_url']))
		  {
			  $imgUrl = base_url()."assets/uploads/images/".$row['photo_url'];
		  }
		  else
		  {
			  $imgUrl = base_url().'assets/uploads/images/default_network_user_icon.png';
		  }
		  
		  echo "<div class='circular' style='background: url(".$imgUrl.") no-repeat; display:inline-block;'></div><div style='display:inline-block; vertical-align:top; padding-left:10px; padding-top:10px;'><span style='font-weight:bold;'>".$row['name']."&nbsp;</span><br>
<span class='smalltxt'>".$row['email_address']."</span></div>
</td>
          <td style='width:100px;'>".((!empty($row['last_activity_date']) && $row['last_activity_date'] != '0000-00-00 00:00:00')? format_date_interval($row['last_activity_date'], date('Y-m-d H:i:s', strtotime('now')), FALSE, TRUE, 'days'): 'never')."</td>
          <td style='width:50px;'>".format_number($row['total_invites'],6)."</td>
		  <td style='width:60px;border-right:0px;'>".format_status($row['invitation_status'])."</td>
        </tr>";
        	
        	$counter++;
	   }
	   ?></table>
       
       
<?php 
#Do not show this part if the user is not reloading the entire section
if(empty($sectionArea))
{
?>
       </div>
 			</td>
        </tr>
        <tr>
          <td colspan="4" style="border-right: 0px solid #CCC;">
          <div style="display:inline-block; padding-top:3px; vertical-align:middle;" id="invitetablecontainer">
          <?php 
		  
		  $currentPage = !empty($currentPage)? $currentPage: 1;
		  $noPerPage = !empty($noPerPage)? $noPerPage: 5;
		  $itemCount = !empty($itemCount)? $itemCount: 0;
		  $noOfPages = ceil($itemCount/$noPerPage);
		  
		  echo ($itemCount > $noPerPage)? pagination($itemCount, $noPerPage, $currentPage, 'invite_list_table__pagination'): '';
		  
		  ?><input name="invite_list_table_totalpageno" id="invite_list_table_totalpageno" type="hidden" value="<?php echo !empty($noOfPages)? $noOfPages: 0;?>" />
<input name="invite_list_table_showdiv" id="invite_list_table_showdiv" type="hidden" value="invite_list" />
<input name="invite_list_table_action" id="invite_list_table_action" type="hidden" value="<?php echo base_url().'web/network/show_part_of_network_list/t/invites';?>" />
		</div>
        <div style="display:inline-block;float:right;">Show <select name="invite_list_table_noofentries" id="invite_list_table_noofentries" class="selecttextfield" onchange="updateFieldLayer('<?php echo base_url().'web/network/show_part_of_network_list/t/invites';?>','invite_list_table_noofentries','','invite_list_container','')" style="width:60px; font-size:13px;">
      <?php
	  echo "<option value='5' ".($noPerPage+0 == 5? ' selected': '').">5</option>
      <option value='10' ".($noPerPage+0 == 10? ' selected': '').">10</option>
      <option value='20' ".($noPerPage+0 == 20? ' selected': '').">20</option>
      <option value='50' ".($noPerPage+0 == 50? ' selected': '').">50</option>";
	  ?>
      
      </select> entries
        </div>
</td>
          </tr>
        
        
        </table>

<?php }
	
}
?>
