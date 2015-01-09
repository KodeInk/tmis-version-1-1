<?php
#If the main or sub menu items are not given, then just assign them an empty string
$main = !empty($main)? $main: "";
$sub = !empty($sub)? $sub: "";
?>

	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/tiptip.css" type="text/css" media="screen" />
    <script src='<?php echo base_url();?>assets/js/jquery.tiptip.minified.js' type='text/javascript'></script>
    <script>
	$(function(){
		$("#user_pop").tipTip({
			maxWidth: "450px", 
			keepAlive: true,
			edgeOffset: 10,
			fadeIn: 0,
			delay: 30,
			activation: "click",
			content: "<table width='100%' cellpadding='5'><tr><td><img src='<?php echo base_url()."assets/uploads/".$_SESSION['photo_url'];?>'></td><td ><?php echo "<b style='font-size:18px;'>".$_SESSION['first_name']." ".$_SESSION['last_name'].
			"</b><br>Logged in as: <b style='font-size:13px;'>".($_SESSION['user_type'] != 'normal'? ucfirst($_SESSION['user_type']): 'User')."</b>";?></td></tr><tr><td colspan='2'><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td><a href='javascript:;'><input type='button' name='mysettings' id='mysettings' value='my settings' class='otherbtn'></a></td><td align='right' style='padding-left:20px;'><a href='<?php echo base_url();?>web/account/logout'><input type='button' name='logout' id='logout' value='logout' class='otherbtn'></a></td></tr></table>"
			});
	});
	
	
	//The default submenu content
	var defaultHtml = "<?php echo !empty($defaultHtml)? $defaultHtml: "";?>";
	var isSubMenuSpecified = "<?php echo (!empty($main) && !empty($sub))? "Y": "N";?>";
	var isDefaultHTMLSpecified = "<?php echo !empty($defaultHtml)? "Y": "N";?>";
	
	//Content for the menu items
	var menuKeys = ["menu_users", "menu_merchants", "menu_agents", "menu_customer_service", "menu_promotions", "menu_transactions", "menu_reports", "menu_advanced_tools", "menu_settings", "menu_groups"];
	var menuContent = [
		/*Users*/
		[
			{menu_link: '<?php echo base_url()."web/account/admin_dashboard";?>', menu_text: 'Overview', is_selected: '<?php echo ($main=='users' && $sub=='overview')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Referrals', is_selected: '<?php echo ($main=='users' && $sub=='referrals')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Communications', is_selected: '<?php echo ($main=='users' && $sub=='communications')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Archive', is_selected: '<?php echo ($main=='users' && $sub=='archive')?'Y':'';?>'}
		],
		/*Merchants*/
		[
			{menu_link: '', menu_text: 'Overview', is_selected: '<?php echo ($main=='merchants' && $sub=='overview')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Store Settings', is_selected: '<?php echo ($main=='merchants' && $sub=='store_settings')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Stores List', is_selected: '<?php echo ($main=='merchants' && $sub=='stores_list')?'Y':'';?>'}
		],
		/*Agents*/
		[
			{menu_link: '', menu_text: 'Overview', is_selected: '<?php echo ($main=='agents' && $sub=='overview')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Agent Tracking', is_selected: '<?php echo ($main=='agents' && $sub=='agent_tracking')?'Y':'';?>'}
		],
		/*Customer Service*/
		[
			{menu_link: '', menu_text: 'Overview', is_selected: '<?php echo ($main=='customer_service' && $sub=='overview')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Issue Tracking', is_selected: '<?php echo ($main=='customer_service' && $sub=='issue_tracking')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Escalation Settings', is_selected: '<?php echo ($main=='customer_service' && $sub=='escalation_settings')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Contact Settings', is_selected: '<?php echo ($main=='customer_service' && $sub=='contact_settings')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Issue Database', is_selected: '<?php echo ($main=='customer_service' && $sub=='issue_database')?'Y':'';?>'}
		],
		/*Promotions*/
		[
			{menu_link: '', menu_text: 'Overview', is_selected: '<?php echo ($main=='promotions' && $sub=='overview')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Display Rules', is_selected: '<?php echo ($main=='promotions' && $sub=='display_rules')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Display Reports', is_selected: '<?php echo ($main=='promotions' && $sub=='display_reports')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Financials', is_selected: '<?php echo ($main=='promotions' && $sub=='financials')?'Y':'';?>'}
		],
		/*Transactions*/
		[
			{menu_link: '', menu_text: 'Overview', is_selected: '<?php echo ($main=='transactions' && $sub=='overview')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Accounts', is_selected: '<?php echo ($main=='transactions' && $sub=='accounts')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Transaction Settings', is_selected: '<?php echo ($main=='transactions' && $sub=='transaction_settings')?'Y':'';?>'},
			{menu_link: '<?php echo base_url()."web/transactions/import_data";?>', menu_text: 'Import Data', is_selected: '<?php echo ($main=='transactions' && $sub=='import_data')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Export Data', is_selected: '<?php echo ($main=='transactions' && $sub=='export_data')?'Y':'';?>'}
		],
		/*Reports*/
		[
			{menu_link: '', menu_text: 'Overview', is_selected: '<?php echo ($main=='reports' && $sub=='overview')?'Y':'';?>'},
			{menu_link: '', menu_text: 'System Perfomance', is_selected: '<?php echo ($main=='reports' && $sub=='system_perfomance')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Membership', is_selected: '<?php echo ($main=='reports' && $sub=='membership')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Security', is_selected: '<?php echo ($main=='reports' && $sub=='security')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Activity Log', is_selected: '<?php echo ($main=='reports' && $sub=='activity_log')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Revenue', is_selected: '<?php echo ($main=='reports' && $sub=='revenue')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Expenses', is_selected: '<?php echo ($main=='reports' && $sub=='expenses')?'Y':'';?>'}
		],
		/*Advanced Tools*/
		[
			{menu_link: '', menu_text: 'Overview', is_selected: '<?php echo ($main=='advanced_tools' && $sub=='overview')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Promotion Matrix', is_selected: '<?php echo ($main=='advanced_tools' && $sub=='promotion_matrix')?'Y':'';?>'},
			{menu_link: '', menu_text: 'System Surveys', is_selected: '<?php echo ($main=='advanced_tools' && $sub=='system_surveys')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Permissions', is_selected: '<?php echo ($main=='advanced_tools' && $sub=='permissions')?'Y':'';?>'}
		],
		/*Settings*/
		[
			{menu_link: '', menu_text: 'Overview', is_selected: '<?php echo ($main=='settings' && $sub=='overview')?'Y':'';?>'},
			{menu_link: '', menu_text: 'My Account Settings', is_selected: '<?php echo ($main=='settings' && $sub=='my_account_settings')?'Y':'';?>'},
			{menu_link: '<?php echo base_url()."web/score/score_settings";?>', menu_text: 'Score Settings', is_selected: '<?php echo ($main=='settings' && $sub=='score_settings')?'Y':'';?>'},
			{menu_link: '<?php echo base_url()."cron/jobs/dashboard";?>', menu_text: 'Cron Jobs', is_selected: '<?php echo ($main=='settings' && $sub=='cron_jobs')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Privacy Settings', is_selected: '<?php echo ($main=='settings' && $sub=='privacy_settings')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Transaction Settings', is_selected: '<?php echo ($main=='settings' && $sub=='transaction_settings')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Inbox <b>(267)</b>', is_selected: '<?php echo ($main=='settings' && $sub=='inbox')?'Y':'';?>'}
		],
		/*Groups*/
		[
			{menu_link: '', menu_text: 'Overview', is_selected: '<?php echo ($main=='groups' && $sub=='overview')?'Y':'';?>'},
			{menu_link: '', menu_text: 'System Groups', is_selected: '<?php echo ($main=='groups' && $sub=='system_groups')?'Y':'';?>'},
			{menu_link: '', menu_text: 'Archive', is_selected: '<?php echo ($main=='groups' && $sub=='archive')?'Y':'';?>'}
		]
	];
	
	
	var menuHTML = new Array();
	
	//Now format in the expected array format
	for(var i=0; i<menuContent.length; i++)
	{
		menuHTML[menuKeys[i]] = "<table border='0' cellspacing='0' cellpadding='15' class='submenu'>"+
	"<tr><?php if(!empty($defaultHtml)){?><td class='activemenu' style='width:48px; padding:0px; height:57px;' nowrap><a href='javascript:void(0);' onclick='returnOriginal()'><img src='<?php echo base_url();?>assets/images/back_arrow_grey.png' border='0'></a></td><?php }?>";
		
		for(var k=0; k<menuContent[i].length; k++)
		{
			//Cater for those menu items without links
			if(menuContent[i][k]['menu_link'] == '')
			{
				menuContent[i][k]['menu_link'] = "javascript:void(0);";
			}
			
			menuHTML[menuKeys[i]] += "<td class='";
			
			if(menuContent[i][k]['is_selected'] == 'Y')
			{
				menuHTML[menuKeys[i]] += "activemenu";
			}
			else
			{
				menuHTML[menuKeys[i]] += "inactivemenu";
			}
			
			menuHTML[menuKeys[i]] += "' onclick=\"document.location.href='"+menuContent[i][k]['menu_link']+"'\" nowrap><a href='javascript:void(0);'>"+menuContent[i][k]['menu_text']+"</a></td>";
		}
		
		menuHTML[menuKeys[i]] += "</tr></table>";
	}
	
	
	$(function(){
		//Hovering over the the menu item
		$("#menu_users").click(function () {
           $('#submenu_content').html(menuHTML['menu_users']);
        });
		
		$("#menu_merchants").click(function () {
           $('#submenu_content').html(menuHTML['menu_merchants']);
        });
        
		$("#menu_agents").click(function () {
           $('#submenu_content').html(menuHTML['menu_agents']);
        });
		
		$("#menu_customer_service").click(function () {
           $('#submenu_content').html(menuHTML['menu_customer_service']);
        });
		
		$("#menu_promotions").click(function () {
           $('#submenu_content').html(menuHTML['menu_promotions']);
        });
		
		$("#menu_transactions").click(function () {
           $('#submenu_content').html(menuHTML['menu_transactions']);
        });
		
		$("#menu_reports").click(function () {
           $('#submenu_content').html(menuHTML['menu_reports']);
        });
		
		$("#menu_advanced_tools").click(function () {
           $('#submenu_content').html(menuHTML['menu_advanced_tools']);
        });
		
		$("#menu_settings").click(function () {
           $('#submenu_content').html(menuHTML['menu_settings']);
        });
		
		$("#menu_groups").click(function () {
           $('#submenu_content').html(menuHTML['menu_groups']);
        });
	});
	
	//Determine if to show submenus and navigation items
	if(isSubMenuSpecified == 'Y')
	{
		defaultHtml = menuHTML['menu_<?php echo $main;?>'];
	}
	
	//Show the default page HTML for sub options
	function returnOriginal()
	{
		 $('#submenu_content').html("<?php echo !empty($defaultHtml)? $defaultHtml: "";?>");
	}
	
	//Show the submenu
	function showSubMenu()
	{
		 var defaultHtml = menuHTML['menu_<?php echo $main;?>'];
		 $('#submenu_content').html(defaultHtml);
	}
	
	//By default load the default content
	$(function(){
		$('#submenu_content').html(defaultHtml);
	});
	</script>

<tr>
    <td style="background-color:#000; height:46px;"><div class='stickyheader'><table width="100%" border="0" cellspacing="0" cellpadding="10" class="menutable">
      <tr>
        <td id="menu_users" <?php echo ($main=='users')? " class='activemenu'":"";?>><a href="javascript:void(0);">Users</a></td>
        
        <td id="menu_merchants" <?php echo ($main=='merchants')? " class='activemenu'":"";?>><a href="javascript:void(0);">Merchants</a></td>
        <td id="menu_agents" <?php echo ($main=='agents')? " class='activemenu'":"";?>><a href="javascript:void(0);">Agents</a></td>
        <td id="menu_customer_service" <?php echo ($main=='customer_service')? " class='activemenu'":"";?> nowrap><a href="javascript:void(0);">Customer Service</a></td>
        <td id="menu_promotions" <?php echo ($main=='promotions')? " class='activemenu'":"";?>><a href="javascript:void(0);">Promotions</a></td>
        <td id="menu_transactions" <?php echo ($main=='transactions')? " class='activemenu'":"";?>><a href="javascript:void(0);">Transactions</a></td>
        <td id="menu_reports" <?php echo ($main=='reports')? " class='activemenu'":"";?>><a href="javascript:void(0);">Reports</a></td>
        <td id="menu_advanced_tools" <?php echo ($main=='advanced_tools')? " class='activemenu'":"";?> nowrap><a href="javascript:void(0);">Advanced Tools</a></td>
        <td id='menu_settings' <?php echo ($main=='settings')? " class='activemenu'":"";?>><a href="javascript:void(0);">Settings</a></td>
        <td id="menu_groups" <?php echo ($main=='groups')? " class='activemenu'":"";?>><a href="javascript:void(0);">Groups</a></td>
        
        <td align="center"  nowrap style="padding-left:40px; padding-right:40px;" id="user_pop"><img src="<?php echo base_url();?>assets/images/down_arrow_lightgrey.png" border="0"/> &nbsp;<a href="javascript:void(0);"><?php echo "<b>".$_SESSION['first_name']." ".$_SESSION['last_name']." (".($_SESSION['user_type'] != 'normal'? ucfirst($_SESSION['user_type']): '').")"."</b>";?></a>
</td>
        <td style="padding:0px; padding-left:30px; padding-right:30px; width:1%; height:40px; text-align:center;"><a href="<?php echo $this->account_manager->get_dashboard();?>"><img src="<?php echo base_url();?>assets/images/logo.png" border="0" height="18"/></a></td>
      </tr>
    </table><input name="layerid" id="layerid" type="hidden" value=""></div></td>
  </tr>
  <tr>
    <td style="background-color:#F1F1F1; padding-left: 15px; padding-right:15px; height:54px;border-bottom: solid 1px #DDD;" id='submenu_content'>&nbsp;</td>
  </tr>