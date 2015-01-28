<?php echo !empty($msg)?format_notice($this,$msg): "";?> 
<table border="0" cellspacing="0" cellpadding="0" class="listtable">
<?php 
if(!empty($list))
{
	$rowsPerPage = !empty($pagecount)? $pagecount: NUM_OF_ROWS_PER_PAGE;
	$listCount = count($list);
	$page = !empty($page)? $page: 1;
	$stop = ($rowsPerPage >= $listCount && !empty($listid))? "<input name='paginationdiv__".$listid."_stop' id='paginationdiv__".$listid."_stop' type='hidden' value='".$page."' />": "";
	
	echo "<tr class='header'><td>&nbsp;</td><td>Name</td><td>Permission Group</td><td>Email Address</td><td>Telephone</td><td>Status</td><td>Last Updated</td></tr>";
	
	# Pick the lesser of the two - since if there is a next page, the list count will come with an extra row
	$maxRows = $listCount < $rowsPerPage? $listCount: $rowsPerPage;
	for($i=0; $i<$maxRows; $i++)
	{
		$row = $list[$i];
		echo "<tr class='listrow'>
    <td width='1%' style='padding:0px; padding-top:5px; vertical-align:top;'>";
	
	$listType = " data-type='user' ";
	if(!empty($action) && $action == 'update')
	{
		if($row['status'] == 'complete'){
			echo "<div data-val='approve__".$row['id']."' ".$listType." class='approverow confirm'></div>
			<div data-val='reject__".$row['id']."' ".$listType." class='rejectrow'></div>
			<div data-val='archive__".$row['id']."' ".$listType." class='archiverow confirm'></div>";
		}
		else if($row['status'] == 'active'){
			echo "<div data-val='block__".$row['id']."' ".$listType." class='blockrow confirm'></div>
			<div data-val='archive__".$row['id']."' ".$listType." class='archiverow confirm'></div>";
		}
		else if($row['status'] == 'archived'){
			echo "<div data-val='restore__".$row['id']."' ".$listType." class='restorerow confirm'></div>";
		}
		else if($row['status'] == 'blocked'){
			echo "<div data-val='approve__".$row['id']."' ".$listType." class='approverow confirm'></div>";
		}
	} 
	else if(!empty($action) && $action == 'archive')
	{
		if($row['status'] == 'archived'){
			echo "<div data-val='restore__".$row['id']."' ".$listType." class='restorerow confirm'></div>";
		} 
		else if(in_array($row['status'], array('active', 'completed'))){
			echo "<div data-val='archive__".$row['id']."' ".$listType." class='archiverow confirm'></div>";
		}
	}
	
	echo "</td>
	<td>".$row['last_name']." ".$row['first_name']."</td>";
	
	
	echo "<td>";
	if(!empty($action) && $action == 'setpermission')
	{
		echo "<div id='userpermission_".$row['id']."'></div><input type='text' id='userpermission_".$row['id']."__roles' name='userpermission_".$row['id']."__roles' title='The User Permission Group' placeholder='Select Permission' class='textfield selectfield' onchange=\"updateFieldLayer('".base_url()."user/set_permissions/set_id/".$row['id']."','userpermission_".$row['id']."__roles','','userpermission_".$row['id']."','')\" value='".$row['user_role']."'/>";
	}
	else
	{
		echo $row['user_role'];
	}
	echo "</td>
	<td>".$row['email_address']."</td>
	<td>".$row['telephone']."</td>
	<td>".$row['status']."</td>
	<td>".(!empty($row['last_updated']) && $row['last_updated'] != '0000-00-00 00:00:00'? date('d-M-Y h:i:sa T', strtotime($row['last_updated'])): '&nbsp;')."
	<br><div class='rightnote'><a href='".base_url()."user/details/id/".$row['id']."' class='shadowbox closable'>details</a></div>".(check_access($this, 'add_new_user', 'boolean')? "<div class='rightnote'><a href='".base_url()."user/add/id/".$row['id']."' class='shadowbox'>edit</a></div>": "")."
	</td></tr>
	<tr><td style='padding:0px;'></td><td colspan='6' style='padding:0px;'><div id='action__".$row['id']."' class='actionrowdiv' style='display:none;'></div>".$stop."</td></tr>";
	
	}  
}
else
{
	echo "<tr><td>".format_notice($this,'WARNING: There are no items in this list.')."</td></tr>";
}
?>

  
</table>