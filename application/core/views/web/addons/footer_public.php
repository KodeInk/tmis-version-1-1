<?php
$bold = " style='font-weight:600;'";
?>

<div class="robototext whitemediumtext translucentbg">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:20px;">
    <tr>
      <td width="5%">&nbsp;</td>
      <td width="10%" style="text-align:left;" nowrap>Clout &copy; <?php echo date('Y');?></td>
      <td width="5%">&nbsp;</td>
      <td width="75%" style="text-align:right;" nowrap><a href="<?php echo base_url();?>" <?php echo (!empty($area) && $area == 'home')? $bold: '';?>>Home</a>  &nbsp; | &nbsp;  <a href="<?php echo base_url()."web/page/terms_of_reference";?>" <?php echo (!empty($area) && $area == 'terms')? $bold: '';?>>Terms</a>  &nbsp; | &nbsp;  <a href="<?php echo base_url()."web/page/privacy_policy";?>" <?php echo (!empty($area) && $area == 'privacy')? $bold: '';?>>Privacy</a>  &nbsp; | &nbsp;  <a href="<?php echo base_url()."web/page/show_merchant_home";?>" <?php echo (!empty($area) && $area == 'business')? $bold: '';?>>Business</a>  &nbsp; | &nbsp;  <a href="<?php echo base_url()."web/page/show_affiliate_home";?>" <?php echo (!empty($area) && $area == 'affiliates')? $bold: '';?>>Affiliates</a>  &nbsp; | &nbsp;  <a href="<?php echo base_url()."web/page/show_agent_home";?>" <?php echo (!empty($area) && $area == 'agents')? $bold: '';?>>Agents</a></td>
      <td width="5%">&nbsp;</td>
    </tr>
  </table>
</div>