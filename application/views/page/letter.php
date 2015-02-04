<?php
require_once(HOME_URL."external_libraries/dompdf/dompdf_config.inc.php");
$assetFolder = HOME_URL.'assets/';#base_url().'assets/';
$trackingNumber = "091234567890";

$document = "
<table width='100%' cellpadding='5' cellspacing='0' style=\"font-family: Georgia, 'Times New Roman', Times, serif;\">
<tr><td align='left' valign='top'><table width='100%' cellpadding='5' cellspacing='0' style='border-bottom: solid 3px #000;'>
  <tr>
    <td valign='top' style='padding-top: 20px; padding-bottom: 0px; text-align:left;'><table border='0' cellspacing='0' cellpadding='2' align='left' style='font-weight:bold;'>
      <tr>
        <td>Telephone:</td>
        <td>0412 34451/4</td>
      </tr>
      <tr>
        <td>Fax:</td>
        <td>0412 234920</td>
      </tr>
      <tr>
        <td>Email:</td>
        <td>pro@education.co.ug</td>
      </tr>
      <tr>
        <td>Website:</td>
        <td>www.education.co.ug</td>
      </tr>
    </table></td>
    <td style='padding-top: 0px; padding-bottom: 0px; text-align:center;' nowrap><img src='".$assetFolder."images/coat_of_arms.png' border='0'/><br /><span  style=\"font-family:'Times New Roman', Times, serif; font-size: 12px; font-weight:bold; text-align:center;\">REPUBLIC OF UGANDA</span></td>
    <td style='padding-top: 20px; padding-bottom: 10px; text-align:right;'><table border='0' cellspacing='0' cellpadding='2' style='font-weight:bold;' align='right'>
      <tr>
        <td nowrap>Ministry of Education and Sports</td>
        </tr>
      <tr>
        <td>Embassy House</td>
        </tr>
      <tr>
        <td>P.O. Box 7063</td>
        </tr>
      <tr>
        <td>Kampala Uganda</td>
        </tr>
    </table></td>
    </tr>
</table></td></tr>
<tr>
  <td>
  
  <table width='100%' cellpadding='5' cellspacing='0'>
  <tr><td><table border='0' cellspacing='0' cellpadding='3' style='font-weight:bold;'>
      <tr>
        <td colspan='2' style='height:40px; color:#999; vertical-align:top;'>3rd February 2015</td>
        </tr>
      <tr>
        <td colspan='2' style='font-weight:normal;'>Wamuyu James</td>
        </tr>
      <tr>
        <td colspan='2' style='height:40px; vertical-align:top;'>Laboratory Assistant</td>
        </tr>
      <tr>
        <td valign='top' width='1%'>Thru:</td>
        <td width='99%' style='font-weight:normal; line-height:160%;'>The Head Teacher,<br />
Kirinya C.O.U S.S<br />
P.O.Box 8055 Kampala, Uganda</td>
      </tr>
    </table></td><td valign='top'><table border='0' cellspacing='0' cellpadding='0' align='right'>
      <tr>
        <td style='height:30px; color:#999;'>&nbsp;</td>
      </tr>
      <tr>
        <td style='font-weight:normal;'><img src='".base_url()."external_libraries/phpqrcode/qr_code.php?value=".$trackingNumber."' /></td>
      </tr>
      <tr>
        <td style=\"font-family:'Courier New', Courier, monospace; text-align:center;color:#999;\">".$trackingNumber."<br />
          <span style='font-size:9px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;'><br />QUOTE TRACKING NUMBER IN <br />FUTURE CORRESPONDENCE.</span></td>
      </tr>
    </table></td></tr>
  </table>
  

  </td>
</tr>


<tr><td>&nbsp;</td></tr>


<tr>
  <td style='line-height:160%;'><span style='font-weight:bold'>RE: CONFIRMATION OF APPOINTMENT</span><br />
    I am pleased to inform you that the Education Service Commission under Minute No. 188/2015(29)(i), directed that you be confirmed in your appointment as <span style='font-weight:bold;'>Laboratory Assistant</span> and admitted to the permanent and pensionable establishment of the Public Service with effect from the date of appointment on probation.<br />
    <br />
    Your attention is drawn to the Uganda Public Service Standing Orders 2010 Section <span style='font-weight:bold;'>a-e</span> paragraphs <span style='font-weight:bold;'>10-13</span> which explain the effect of confirmation.<br />
    <br />
    Yours faithfully,</td>
</tr>
<tr>
  <td><br /><img src='".$assetFolder."uploads/images/file_1422931566.jpg' border='0' style='height:80px;' />
<br /><br />Katushabe Monica
<br /><span style='font-weight:bold;'>For: PERMANENT SECRETARY</span></td>
</tr>
<tr>
  <td style='line-height:160%;'>C.C: The Auditor General, Audit Commission <br />
    C.C: 
    Permanent Secretary, Ministry of Public Service<br />
    C.C: Secretary, Education Service Commission<br />
    C.C: Personal File
  </td>
</tr>
<tr>
  <td style='border-top: solid 3px #000;'><table border='0' cellspacing='0' cellpadding='0' width='100%' style='font-weight:bold;'>
    <tr>
      <td style='font-size:9px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#999;'>THIS LETTER HAS AN ELECTRONIC RECORD. MODIFICATION OR FORGERY IS PUNISHABLE BY LAW.</td>
      <td style='font-size:9px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:right;'>FORM: C-510A &nbsp;&nbsp; 01-DEC-2014</td>
    </tr>
  </table></td>
</tr>
</table>";
#echo $document;
$document = get_magic_quotes_gpc()? stripslashes($document): $document;
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($document);
		$dompdf->set_paper('A4', 'portrait');
		$dompdf->render();
	
		# Store the entire PDF as a string in $pdf
		$pdf = $dompdf->output();
		# Write $pdf to disk
		file_put_contents($assetFolder.'uploads/documents/letter.pdf', $pdf);

		# If the user wants to download the file, then stream it; otherwise display it in the browser as is.
		$dompdf->stream('letter.pdf', array("Attachment" => true));
		exit(0);
?>
