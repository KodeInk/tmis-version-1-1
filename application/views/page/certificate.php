<?php
require_once(HOME_URL."external_libraries/dompdf/dompdf_config.inc.php");
$assetFolder = HOME_URL.'assets/';


$document = "<table width='100%' cellpadding='0' cellspacing='0'>
<tr><td valign='top' align='left'><img src='".$assetFolder."images/top_left_corner.png' border='0'  height='50'/></td><td><table width='100%' cellpadding='5' cellspacing='0'>
  <tr>
    <td style='padding-top: 0px; padding-bottom: 0px; text-align:center; line-height:160%;'><img src='".$assetFolder."images/coat_of_arms.png' border='0' height='100'/> <br />
      <span  style='font-family:&quot;Times New Roman&quot;, Times, serif; font-size: 20px; text-align:center;'>REPUBLIC OF UGANDA</span><br>
<span style='font-family:&quot;Times New Roman&quot;, Times, serif; font-size: 20px; text-align:center; color:#999; ' nowrap>MINISTRY OF EDUCATION AND SPORTS</span></td>
  </tr>
</table></td><td valign='top' align='right'><img src='".$assetFolder."images/top_right_corner.png' border='0' height='50' /></td></tr>
<tr><td colspan='3' align='center'><table width='90%' cellpadding='5' cellspacing='0' align='center'>

  <tr>
    <td style='text-align:center;padding-bottom:0px;'><img src='".$assetFolder."images/certificate_heading.png' height='70'/><br>
	<span style='font-family:&quot;Times New Roman&quot;, Times, serif; font-size: 20px; text-align:center; padding-top:0px;padding-bottom:50px;'>(Issued under Sections 11, 12 and 13 of the Education Act, 2008)</span></td>
  </tr>
  <tr>
    <td style='font-family:&quot;Times New Roman&quot;, Times, serif; height:75px; padding-bottom:10px; font-size: 40px; text-align:center; vertical-align:bottom;'>This is to certify that</td>
  </tr>
  <tr>
    <td style='font-family:Arial, Helvetica, sans-serif; padding-bottom:10px; font-size: 30px; text-align:center; border-bottom: solid 2px #333;'>WAMUYU JAMES</td>
  </tr>
  <tr>
    <td style='font-family:&quot;Times New Roman&quot;, Times, serif; font-size: 18px; text-align:center; padding-bottom:0px; line-height:160%;'>Having completed a teacher training course approved by the Ministry has been registered<br />
       as a <b>PRIMARY EDUCATION - GRADUATE TEACHER</b> with effect from 19-JAN-2014 as number <b>20067834028654</b>.</td>
  </tr>
  <tr>
    <td><table width='100%' cellpadding='5' cellspacing='0'>
      <tr>
        <td style='font-family:&quot;Times New Roman&quot;, Times, serif; font-size: 20px; text-align:left; color:#999; '>03-FEB-2015</td>
        <td style='width:400px;'>For
          <div style='border-bottom: 1px solid #000; padding-bottom: 2px; width: 95%; margin-left:10px; display:inline-block;'><img src='".$assetFolder."uploads/images/file_1422931566.jpg' border='0' style='height:80px;' /></div>
          <br />
          <span style='&quot;Times New Roman&quot;, Times, serif; font-size: 12px;'>DIRECTOR FOR HIGHER TECHNICAL, VOCATIONAL AND EDUCATIONAL TRAINING.</span></td>
      </tr>
    </table></td>
  </tr>
</table></td>
  </tr>
<tr><td valign='bottom' align='left' style='padding-top:0px;'><img src='".$assetFolder."images/bottom_left_corner.png' border='0' height='50' /></td>
  <td style='text-align:center;padding-top:0px; padding-bottom:0px;'>&nbsp;</td>
  <td valign='bottom' align='right' style='padding-top:0px;'><img src='".$assetFolder."images/bottom_right_corner.png' border='0' height='50' /></td></tr>
</table>
";
#echo $document;
$document = get_magic_quotes_gpc()? stripslashes($document): $document;
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($document);
		$dompdf->set_paper('A4', 'landscape');
		$dompdf->render();
	
		# Store the entire PDF as a string in $pdf
		$pdf = $dompdf->output();
		# Write $pdf to disk
		file_put_contents($assetFolder.'uploads/documents/certificate.pdf', $pdf);

		# If the user wants to download the file, then stream it; otherwise display it in the browser as is.
		$dompdf->stream('certificate.pdf', array("Attachment" => true));
		exit(0);
?>
