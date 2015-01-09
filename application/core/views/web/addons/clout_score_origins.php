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
			$tableHTML .= (in_array($key, $availableLinks) && !empty($scoreValues['value']))? "<a href='".base_url()."web/score/show_score_origins/v/".encrypt_value($key)."/l/".encrypt_value('2')."/u/".encrypt_value($userId)."/t/".encrypt_value('clout_score')."' class='fancybox fancybox.ajax' style='text-decoration:underline;'>": "";
			
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
		
		
		
		
		else if($variable == 'number_of_surveys_answered_in_last90days')
		{
			$tableHTML .= "<table width='100%'>
			<tr><td colspan='5' nowrap><b style='font-size:17px;'>".$title."</b></td></tr>
			<tr><td colspan='5'>
			<table width='100%' cellpadding='5' cellspacing='0'>
			<tr><td style='background-color:#000;color:#FFF; font-weight:bold;'>Text</td>
			<td style='background-color:#CCC;color:#222; font-weight:bold;'><a href=\"javascript:alert('Coming Soon!');\" style='font-weight:bold;'>Graph</a></td>
			</tr>
			</table>
			</td></tr>
		
			<tr style='".get_row_color(1, 2)."'>
			<td><b>Survey</b></td>
			<td><b>Type</b></td>
			<td nowrap><b>Response Date</b></td>
			<td nowrap><b>Total Impressions</b></td>
			<td nowrap><b>Total Responses</b></td>
			</tr>";
			
			#Show the score details
			$counter = 0;
			foreach($scoreDetails AS $key=>$row)
			{
				$tableHTML .= "<tr style='".get_row_color($counter, 2)."'>
				<td width='1%' nowrap><b>".$row['survey_name']."</b></td>
				<td>".$row['survey_type']."</td>
				<td>".date('M d, Y', strtotime($row['response_date']))."</td>
				<td>".$row['total_impressions']."</td>
				<td>".$row['total_responses']."</td>
				</tr>";
				$counter++;
			} 
	
			$tableHTML .= "</table>";
			
			
		}
		
		
		
		
		#Spending (direct and ad-related)
		else if(in_array($variable, array('spending_last180days', 'spending_last360days', 'spending_total', 'ad_spending_last180days', 'ad_spending_last360days', 'ad_spending_total')))
		{
			$tableHTML .= "<table width='100%'>
			<tr><td colspan='6' nowrap><b style='font-size:17px;'>".$title."</b></td></tr>
			<tr><td colspan='6'>
			<table width='100%' cellpadding='5' cellspacing='0'>
			<tr><td style='background-color:#000;color:#FFF; font-weight:bold;'>Text</td>
			<td style='background-color:#CCC;color:#222; font-weight:bold;'><a href=\"javascript:alert('Coming Soon!');\" style='font-weight:bold;'>Graph</a></td>
			</tr>
			</table>
			</td></tr>
		
			<tr style='".get_row_color(1, 2)."'>
			<td><b>Date</b></td>
			<td><b>Advert</b></td>
			<td><b>Amount</b></td>
			<td nowrap><b>Item Name</b></td>
			<td><b>Store</b></td>
			<td><b>Status</b></td>
			</tr>";
			
			#Show the score details
			$counter = 0;
			foreach($scoreDetails AS $key=>$row)
			{
				$tableHTML .= "<tr style='".get_row_color($counter, 2)."'>
				<td width='1%' nowrap><b>".date('M d, Y', strtotime($row['transaction_date']))."</b></td>
				<td>".$row['advert_name']."</td>
				<td>$".add_commas($row['amount'],2)."</td>
				<td>".$row['item_name']."</td>
				<td>".$row['store_name']."</td>
				<td>".$row['status']."</td>
				</tr>";
				$counter++;
			} 
	
			$tableHTML .= "</table>";
		}
		
		
		
		
		#Direct/Network Referrals
		else if(in_array($variable, array('number_of_direct_referrals_last180days', 'number_of_direct_referrals_last360days', 'total_direct_referrals', 'number_of_network_referrals_last180days', 'total_network_referrals')))
		{
			$tableHTML .= "<table width='100%'>
			<tr><td colspan='6' nowrap><b style='font-size:17px;'>".$title."</b></td></tr>
			<tr><td colspan='6'>
			<table width='100%' cellpadding='5' cellspacing='0'>
			<tr><td style='background-color:#000;color:#FFF; font-weight:bold;'>Text</td>
			<td style='background-color:#CCC;color:#222; font-weight:bold;'><a href=\"javascript:alert('Coming Soon!');\" style='font-weight:bold;'>Graph</a></td>
			</tr>
			</table>
			</td></tr>
		
			<tr style='".get_row_color(1, 2)."'>
				<td><b>Name</b></td>
				".((strpos($variable, 'network_') !== FALSE)? "<td><b>Level</b></td>": "")."
				<td nowrap><b>Referrer Type</b></td>
				<td nowrap><b>Referrence By</b></td>
				<td nowrap><b>Activation Date</b></td>
			</tr>";
			
			#Get level tracking for network referrals
			$levelTracking = (strpos($variable, 'network_') !== FALSE)? $scoreDetails['levels']: array();
			$scoreDetails = (strpos($variable, 'network_') !== FALSE)? $scoreDetails['list']: $scoreDetails;
			
			#Show the score details
			$counter = 0;
			foreach($scoreDetails AS $key=>$row)
			{
				#Get the user level for network referrals
				if(strpos($variable, 'network_') !== FALSE)
				{
					$userLevel = "";
					foreach($levelTracking AS $level=>$usersInLevel)
					{
						if(in_array($row['user_id'], $usersInLevel))
						{
							$userLevel = $level;
							break;
						}
					}
				}
				
				$tableHTML .= "<tr style='".get_row_color($counter, 2)."'>
					<td nowrap>".$row['first_name']." ".$row['last_name']."</td>
					".((strpos($variable, 'network_') !== FALSE)? "<td>".$userLevel."</td>": "")."
					<td>".ucfirst(str_replace('_', ' ', $row['referrer_type']))."</td>
					<td>".ucfirst(str_replace('_', ' ', $row['referrence_by']))."</td>
					<td width='1%' nowrap><b>".date('M d, Y', strtotime($row['activation_date']))."</b></td>
				</tr>";
				$counter++;
			} 
	
			$tableHTML .= "</table>";
		}
		
		#Referral spending
		else if(in_array($variable, array('spending_of_direct_referrals_last180days', 'spending_of_direct_referrals_last360days', 'total_spending_of_direct_referrals', 'spending_of_network_referrals_last180days', 'spending_of_network_referrals_last360days', 'total_spending_of_network_referrals')))
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
			<td nowrap><b>User Name</b></td>
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
				<td>".$row['first_name']." ".$row['last_name']."</td>
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