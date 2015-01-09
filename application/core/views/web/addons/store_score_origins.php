<?php 
$tableHTML = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

if(!empty($scoreDetails))
{
	#Level 0 details
	if($area == 'level_0_area')
	{
		$tableHTML .= "<table cellpadding='10'><tr><td><b style='font-size:17px;'>".$scoreDetails['score_value']."</b></td></tr></table>";
	
	} 
	else if($area == 'level_1_area')
	{
		$tableHTML .= "<table width='100%'>";
		#Show the score details
		$counter = 0;
		$boolValues = array('Y'=>"YES", 'N'=>"NO");
		foreach($scoreDetails AS $key=>$scoreValues)
		{
			if(in_array($scoreValues['value'], array('Y', 'N')))
			{
				$scoreValues['value'] = $boolValues[$scoreValues['value']];
			}
			else if(is_numeric($scoreValues['value']))
			{
				$scoreValues['value'] = add_commas($scoreValues['value'],0);
			}
		
			$tableHTML .= "<tr style='".get_row_color($counter, 2)."'><td width='1%' nowrap><b>".$scoreValues['description'].":</b></td><td>";
			#Show the details link if available
			#Starting link part
			$tableHTML .= (in_array($key, $availableLinks) && !empty($scoreValues['value']))? "<a href='".base_url()."web/score/show_score_origins/v/".encrypt_value($key)."/l/".encrypt_value('2')."/u/".encrypt_value($userId)."/t/".encrypt_value('store_score')."/s/".encrypt_value($storeId)."' class='fancybox fancybox.ajax' style='text-decoration:underline;'>": "";
			
			$tableHTML .= ($scoreValues['type'] == 'money'? "$":"").$scoreValues['value'];
			#Ending link part
			$tableHTML .= (in_array($key, $availableLinks) && !empty($scoreValues['value']))? "</a>": "";
			
			$tableHTML .= "</td></tr>";
			$counter++;
		} 
	
		$tableHTML .= "</table>";
	}
	else if($area == 'level_2_area')
	{
		
		
		#Use this area for the following codes
		if(in_array($variable, array('average_cash_balance_last24months', 'average_credit_balance_last24months')))
		{
			$heading = ($variable == 'average_cash_balance_last24months')? 'CASH BALANCE': 'CREDIT BALANCE';
			$field = ($variable == 'average_cash_balance_last24months')? 'cash_amount': 'credit_amount';
			
			$tableHTML .= "<table width='100%'>
			<tr><td colspan='2' nowrap><b style='font-size:17px;'>".$title."</b></td></tr>
			<tr><td colspan='2'>
			<table width='100%' cellpadding='5' cellspacing='0'>
			<tr><td style='background-color:#000;color:#FFF; font-weight:bold;'>Text</td>
			<td style='background-color:#CCC;color:#222; font-weight:bold;'><a href=\"javascript:alert('Coming Soon!');\" style='font-weight:bold;'>Graph</a></td>
			</tr>
			</table>
			</td></tr>
		
			<tr style='".get_row_color(1, 2)."'><td><b>DATE</b></td><td align='right'><b>".$heading."</b></td></tr>";
			#Show the score details
			$counter = 0;
			foreach($scoreDetails AS $key=>$row)
			{
				$tableHTML .= "<tr style='".get_row_color($counter, 2)."'><td width='1%' nowrap><b>".date('M d, Y', strtotime($row['read_date']))."</b></td><td align='right'>$".add_commas($row[$field],2)."</td></tr>";
				$counter++;
			} 
	
			$tableHTML .= "</table>";
		}
		
		
		
		
		
		
		#My store spending and direct-competitors' spending
		else if(in_array($variable, array('my_store_spending_last90days', 'my_store_spending_last12months', 'my_store_spending_lifetime', 'my_direct_competitors_spending_last90days', 'my_direct_competitors_spending_last12months', 'my_direct_competitors_spending_lifetime', 'my_category_spending_last90days', 'my_category_spending_last12months', 'my_category_spending_lifetime', 'related_categories_spending_last90days', 'related_categories_spending_last12months', 'related_categories_spending_lifetime')))
		{
			$tableHTML .= "<table width='100%'>
			<tr><td colspan='7' nowrap><b style='font-size:17px;'>".$title."</b></td></tr>
			<tr><td colspan='7'>
			<table width='100%' cellpadding='5' cellspacing='0'>
			<tr><td style='background-color:#000;color:#FFF; font-weight:bold;'>Text</td>
			<td style='background-color:#CCC;color:#222; font-weight:bold;'><a href=\"javascript:alert('Coming Soon!');\" style='font-weight:bold;'>Graph</a></td>
			</tr>
			</table>
			</td></tr>
		
			<tr style='".get_row_color(1, 2)."'>
			<td><b>Type</b></td>
			<td><b>Date</b></td>
			<td nowrap><b>Item Name</b></td>
			<td><b>Amount</b></td>
			<td><b>Store</b></td>
			<td><b>Status</b></td>
			</tr>";
			
			#Show the score details
			$counter = 0;
			foreach($scoreDetails AS $key=>$row)
			{
				$tableHTML .= "<tr style='".get_row_color($counter, 2)."'>
				<td>".ucfirst($row['transaction_type'])."</td>
				<td width='1%' nowrap><b>".date('M d, Y', strtotime($row['start_date']))."</b></td>
				<td>".$row['item_name']."</td>
				<td>$".add_commas($row['amount'],2)."</td>
				<td>".$row['store_name']."</td>
				<td>".$row['status']."</td>
				</tr>";
				$counter++;
			} 
	
			$tableHTML .= "</table>";
		}
	
	
	}
	

}
else
{
	$tableHTML .= format_notice("ERROR: User score details can not be resolved.");
}

echo $tableHTML;

?>