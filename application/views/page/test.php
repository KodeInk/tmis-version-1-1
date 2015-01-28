<?php
require_once(HOME_URL."external_libraries/dompdf/dompdf_config.inc.php");

$page_HTML = "<table width='100%'>
<tr>
	<td style='padding-left:20px; padding-right:20px; background-color:#303192; text-align:center;font-family:Verdana, Verdana, Arial, Helvetica, sans-serif; font-weight:bold; font-size:28px; color:#FFFFFF;'>
		SOQ Profile<br />
    	<i style='font-size:13px; color:#FFFFFF;'>THIS IS AL ZZIWA</i>
	</td>
</tr>
</table>";


if(get_magic_quotes_gpc()) $page_HTML = stripslashes($page_HTML);
  
 	$dompdf = new DOMPDF();
 	$dompdf->load_html($page_HTML);
 	$dompdf->set_paper('A4', 'portrait');
 	$dompdf->render();
	
	#Store the entire PDF as a string in $pdf
	$pdf = $dompdf->output();
	#Write $pdf to disk
	file_put_contents(UPLOAD_DIRECTORY.'documents/test_gen_08234520006.pdf', $pdf);
	
	#$dompdf->stream($filename, array("Attachment" => true));

 	# exit(0);
	echo "IT WORKED";
?>