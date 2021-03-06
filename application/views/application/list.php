<?php echo !empty($msg)?format_notice($this,$msg): "";?> 
<table border="0" cellspacing="0" cellpadding="0" class="listtable">
<?php 
if(!empty($list))
{
	$rowsPerPage = !empty($pagecount)? $pagecount: NUM_OF_ROWS_PER_PAGE;
	$listCount = count($list);
	$page = !empty($page)? $page: 1;
	$stop = ($rowsPerPage >= $listCount && !empty($listid))? "<input name='paginationdiv__".$listid."_stop' id='paginationdiv__".$listid."_stop' type='hidden' value='".$page."' />": "";
	
	echo "<tr class='header'><td>&nbsp;</td><td>Name</td><td>Permission Group</td><td>Email Address</td><td>Telephone</td><td>Last Updated</td></tr>";
	
	# Pick the lesser of the two - since if there is a next page, the list count will come with an extra row
	$maxRows = $listCount < $rowsPerPage? $listCount: $rowsPerPage;
	$listType = " data-type='application' ";
	
	for($i=0; $i<$maxRows; $i++)
	{
		$row = $list[$i];
		echo "<tr class='listrow' ".($i%2 == 1? "style='background-color:#F0F0F0;'": "").">
    <td width='1%' style='padding:0px; padding-top:5px; vertical-align:top;'>";
	
	
	if(!empty($action) && $action == 'update')
	{
		if($row['status'] == 'completed'){
			echo "<div data-val='approve__".$row['id']."' ".$listType." class='approverow confirm' title='Click to approve'></div>
			<div data-val='reject__".$row['id']."' ".$listType." class='rejectrow' title='Click to reject'></div>
			<div data-val='archive__".$row['id']."' ".$listType." class='archiverow confirm' title='Click to archive'></div>";
		}
		else if($row['status'] == 'archived'){
			echo "<div data-val='restore__".$row['id']."' ".$listType." class='restorerow confirm' title='Click to restore'></div>";
		}
	}
	
	echo "</td> 
	<td>".$row['last_name'].", ".$row['first_name']."</td> 
	<td>".$row['user_role']."</td>
	<td>".$row['email_address']."</td>
	<td>".$row['telephone']."</td>
	<td>".format_date($row['last_updated'],'d-M-Y h:ia T').
	"<br><div class='rightnote'><a href='".base_url()."user/add/id/".$row['id']."/action/view' class='shadowbox closable'>details</a></div>".
	
	((check_access($this, 'add_new_user', 'boolean') && !empty($action) && $action == 'update')? "<div class='rightnote'><a href='".base_url()."user/add/id/".$row['id']."/action/edit/actionurl/".$action."' class='shadowbox'>edit</a></div>": "")
	
	."</td></tr>
	<tr><td style='padding:0px;'></td><td colspan='6' style='padding:0px;'><div id='action__".$row['id']."' class='actionrowdiv' style='display:none;'></div>".$stop."</td></tr>";
	
	}  
}
else
{
	$stop = "<input name='paginationdiv__".$listid."_stop' id='paginationdiv__".$listid."_stop' type='hidden' value='1' />";
	echo "<tr><td>".format_notice($this,'WARNING: There are no items in this list.').$stop."</td></tr>";
}
?>

  
</table>