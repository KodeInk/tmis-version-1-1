<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Dashboard";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
     <?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
    <script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
	<?php 
		echo get_ajax_constructor(TRUE);
	?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/component.css" />
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php $this->load->view('web/addons/header_admin', array('main'=>'transactions'));?>

<tr>
<td class='sticky_table'>
<table>
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Mobile</th>
						</tr>
					</thead>
					<tbody>
						<tr><td class="user-name">gary coleman</td><td class="user-email">gary.coleman21@example.com</td><td class="user-phone">(398)-332-5385</td><td class="user-mobile">(888)-677-3719</td></tr>
						<tr><td class="user-name">rose parker</td><td class="user-email">rose.parker16@example.com</td><td class="user-phone">(293)-873-2247</td><td class="user-mobile">(216)-889-4933</td></tr>
						<tr><td class="user-name">chloe nelson</td><td class="user-email">chloe.nelson18@example.com</td><td class="user-phone">(957)-213-3499</td><td class="user-mobile">(207)-516-4474</td></tr>
						<tr><td class="user-name">eric bell</td><td class="user-email">eric.bell16@example.com</td><td class="user-phone">(897)-762-9782</td><td class="user-mobile">(565)-627-3002</td></tr>
						<tr><td class="user-name">douglas hayes</td><td class="user-email">douglas.hayes92@example.com</td><td class="user-phone">(231)-391-6269</td><td class="user-mobile">(790)-838-2130</td></tr>
						<tr><td class="user-name">cameron brown</td><td class="user-email">cameron.brown32@example.com</td><td class="user-phone">(204)-488-5204</td><td class="user-mobile">(508)-463-6811</td></tr>
						<tr><td class="user-name">nevaeh diaz</td><td class="user-email">nevaeh.diaz99@example.com</td><td class="user-phone">(436)-578-2946</td><td class="user-mobile">(906)-412-3302</td></tr>
						<tr><td class="user-name">kathy miller</td><td class="user-email">kathy.miller62@example.com</td><td class="user-phone">(724)-705-3555</td><td class="user-mobile">(764)-841-2531</td></tr>
						<tr><td class="user-name">susan king</td><td class="user-email">susan.king88@example.com</td><td class="user-phone">(774)-205-7754</td><td class="user-mobile">(639)-267-9728</td></tr>
						<tr><td class="user-name">jeffery ramirez</td><td class="user-email">jeffery.ramirez83@example.com</td><td class="user-phone">(723)-243-7706</td><td class="user-mobile">(172)-597-3422</td></tr>
						<tr><td class="user-name">gary coleman</td><td class="user-email">gary.coleman21@example.com</td><td class="user-phone">(398)-332-5385</td><td class="user-mobile">(888)-677-3719</td></tr>
						<tr><td class="user-name">rose parker</td><td class="user-email">rose.parker16@example.com</td><td class="user-phone">(293)-873-2247</td><td class="user-mobile">(216)-889-4933</td></tr>
						<tr><td class="user-name">chloe nelson</td><td class="user-email">chloe.nelson18@example.com</td><td class="user-phone">(957)-213-3499</td><td class="user-mobile">(207)-516-4474</td></tr>
						<tr><td class="user-name">eric bell</td><td class="user-email">eric.bell16@example.com</td><td class="user-phone">(897)-762-9782</td><td class="user-mobile">(565)-627-3002</td></tr>
						<tr><td class="user-name">douglas hayes</td><td class="user-email">douglas.hayes92@example.com</td><td class="user-phone">(231)-391-6269</td><td class="user-mobile">(790)-838-2130</td></tr>
						<tr><td class="user-name">cameron brown</td><td class="user-email">cameron.brown32@example.com</td><td class="user-phone">(204)-488-5204</td><td class="user-mobile">(508)-463-6811</td></tr>
						<tr><td class="user-name">nevaeh diaz</td><td class="user-email">nevaeh.diaz99@example.com</td><td class="user-phone">(436)-578-2946</td><td class="user-mobile">(906)-412-3302</td></tr>
						<tr><td class="user-name">kathy miller</td><td class="user-email">kathy.miller62@example.com</td><td class="user-phone">(724)-705-3555</td><td class="user-mobile">(764)-841-2531</td></tr>
						<tr><td class="user-name">susan king</td><td class="user-email">susan.king88@example.com</td><td class="user-phone">(774)-205-7754</td><td class="user-mobile">(639)-267-9728</td></tr>
						<tr><td class="user-name">jeffery ramirez</td><td class="user-email">jeffery.ramirez83@example.com</td><td class="user-phone">(723)-243-7706</td><td class="user-mobile">(172)-597-3422</td></tr>
						<tr><td class="user-name">gary coleman</td><td class="user-email">gary.coleman21@example.com</td><td class="user-phone">(398)-332-5385</td><td class="user-mobile">(888)-677-3719</td></tr>
						<tr><td class="user-name">rose parker</td><td class="user-email">rose.parker16@example.com</td><td class="user-phone">(293)-873-2247</td><td class="user-mobile">(216)-889-4933</td></tr>
						<tr><td class="user-name">chloe nelson</td><td class="user-email">chloe.nelson18@example.com</td><td class="user-phone">(957)-213-3499</td><td class="user-mobile">(207)-516-4474</td></tr>
						<tr><td class="user-name">eric bell</td><td class="user-email">eric.bell16@example.com</td><td class="user-phone">(897)-762-9782</td><td class="user-mobile">(565)-627-3002</td></tr>
						<tr><td class="user-name">douglas hayes</td><td class="user-email">douglas.hayes92@example.com</td><td class="user-phone">(231)-391-6269</td><td class="user-mobile">(790)-838-2130</td></tr>
						<tr><td class="user-name">cameron brown</td><td class="user-email">cameron.brown32@example.com</td><td class="user-phone">(204)-488-5204</td><td class="user-mobile">(508)-463-6811</td></tr>
						<tr><td class="user-name">nevaeh diaz</td><td class="user-email">nevaeh.diaz99@example.com</td><td class="user-phone">(436)-578-2946</td><td class="user-mobile">(906)-412-3302</td></tr>
						<tr><td class="user-name">kathy miller</td><td class="user-email">kathy.miller62@example.com</td><td class="user-phone">(724)-705-3555</td><td class="user-mobile">(764)-841-2531</td></tr>
						<tr><td class="user-name">susan king</td><td class="user-email">susan.king88@example.com</td><td class="user-phone">(774)-205-7754</td><td class="user-mobile">(639)-267-9728</td></tr>
						<tr><td class="user-name">jeffery ramirez</td><td class="user-email">jeffery.ramirez83@example.com</td><td class="user-phone">(723)-243-7706</td><td class="user-mobile">(172)-597-3422</td></tr>
					</tbody>
				</table>
				
		<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.stickyheader.js"></script>
</td>
</tr>
</table>
</body>
</html>