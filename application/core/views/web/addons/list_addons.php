<?php 
$jquery = "<script src='".base_url()."assets/js/jquery.min.js' type='text/javascript'></script>";
$javascript = "<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>".get_AJAX_constructor(TRUE); 

$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

if(!empty($area) && $area == "show_bigger_image")
{
	$tableHTML .= "<table width='530' height='398' border='0' cellspacing='0' cellpadding='0'><tr><td><img src='".$url."' border='0' /></td></tr></table>"; 
}



else if(!empty($area) && $area == "transactions_list") 
{
	$tableHTML .= "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
  <tr>
    <td style='text-align:left;'>Transactions list here</td>
    </tr>
</table>";
	
}




else if(!empty($area) && $area == "search_transaction_list") 
{
	if(!empty($pageList))
	{
		$tableHTML .= "<table border='0' width='100%' cellspacing='0' cellpadding='0' id='transactions_list' class='scrollablelisttable'>
					<thead>
						<tr class='tableheaderrow'>
                          <th width='1%' style='padding-left:3px;padding-right:3px;'><a href='javascript:;'>Select All</a><br>
<input id='selectallbtn' name='selectallbtn' type='checkbox' value='selectall' class='selectallcheck' onClick=\"selectAllByClass('selectallbtn', 'bigcheckbox');\"><label for='selectallbtn'></label></th>
							<th><a href='javascript:;'>Date</a></th>
                            <th class='sortcolumn'><a href='javascript:;'>User</a></th>
							<th class='sortcolumn'><a href='javascript:;'>Store</a></th>
							<th><a href='javascript:;'>Amount</a></th>
							<th class='sortcolumn'><a href='javascript:;'>Type</a></th>
							<th><a href='javascript:;'>Item Details</a></th>
                            <th><a href='javascript:;'>Address</a></th>
						</tr>
					</thead>
					<tbody id='listbody'>";
					foreach($pageList AS $row)
					{
						$tableHTML .= "<tr>
						  <td width='1%'><input id='select_".$row['id']."' name='selectall[]' type='checkbox' value='".$row['id']."' class='bigcheckbox'><label for='select_".$row['id']."'></label></td>
					    <td nowrap>".((!empty($row['start_date']) || $row['start_date'] == '0000-00-00 00:00:00')? date('D, M j, Y', strtotime($row['start_date'])): '&nbsp;')."</td>
						<td style='min-width:140px;'>".ucwords(html_entity_decode($row['user_name'], ENT_QUOTES))."</td>
						<td>".html_entity_decode($row['store_name'], ENT_QUOTES)."</td>
						<td>$".add_commas($row['amount'] < 0? (0-$row['amount']): $row['amount'])."</td>
					    <td>".($row['transaction_type'] == 'buy'? 'Withdrawal': 'Deposit')."</td>
						<td>".$row['item_details']."</td>
						<td>".$row['store_address']."</td>
						</tr>";
					}
                        
                        
         $tableHTML .= "</tbody>
				</table>";
	}
	else
	{
		$tableHTML .= format_notice('WARNING: No results match your search');
	}
	
	
}





else if(!empty($area) && $area == "table_list_items")
{
	$tableHTML = (!empty($tableListItems))? $tableListItems: "<input type='hidden' id='".$tableName."_stop_load' name='".$tableName."_stop_load' value='Y' />";
}





















echo $tableHTML;
?>