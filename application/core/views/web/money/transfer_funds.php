<?php 
$systemJavascript = "<script src='".base_url()."assets/js/jquery.min.js' type='text/javascript'></script>
<script src='".base_url()."assets/js/clout.js' type='text/javascript'></script>";

$systemCss = "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />"; 

echo $systemCss;

if(!empty($action) && $action == "submit")
{
	echo "<table border='0' cellpadding='0' cellspacing='0' align='right' style='border: solid 1px #DDDDDD;
	background-color: #FFF;
	font-family:Arial, Helvetica, sans-serif;
	font-size: 15px;padding:4px; margin-bottom:15px;'>
	<tr>
	<td>".format_notice("Your funds have been sent. <br>Please wait 3-5 business days for the money to be available <br>on your account.")."</td>
	<td style='padding-left:15px;' valign='top'><input type='button' id='donetransfer' name='donetransfer' value='Done' class='bluebtn' style='width:100px;' onClick=\"hideLayerSet('transfer_funds_section');showLayerSet('transfer_funds_btn');\"/></td>
	</tr>
	</table>";
}
else
{
echo "<table border='0' cellpadding='0' cellspacing='0' align='right' style='border: solid 1px #DDDDDD;
	background-color: #FFF;
	font-family:Arial, Helvetica, sans-serif;
	font-size: 15px;padding:4px; margin-bottom:15px;'>
	<tr>
	<td><input type='radio' id='transfer_all' name='transfers' value='all' onclick=\"clearOnActionCheck(this, 'otheramount', '')\" checked></td>
  	<td nowrap>Transfer All <span style='font-weight:bold;'>($906.45)</span> &nbsp;</td>
	<td><input type='radio' id='transfer_amount' name='transfers' value='amount'></td>
	<td nowrap><span class='greysectionheader'>$</span><input type='text' id='otheramount' name='otheramount' class='textfield' style='width:120px;' value='' placeholder='Enter Amount' onkeyup=\"checkIfNotEmpty('otheramount', 'transfer_amount');\"  onkeypress=\"return onlyNumbers(event);\"/></td>
	<td style='padding-left:15px;'><input type='button' id='submittransfer' name='submittransfer' value='Submit' class='bluebtn' style='width:90px;' onClick=\"updateFieldLayer('".base_url()."web/money/transfer_funds/a/".encrypt_value('submit')."','','','transfer_funds_section','');\"/></td>
	<td style='padding-left:5px;'><input type='button' id='canceltransfer' name='canceltransfer' value='Cancel' class='greybtn' style='width:90px;' onclick=\"hideLayerSet('transfer_funds_section');showLayerSet('transfer_funds_btn')\" /></td>
	</tr>
	</table>";
}
?>