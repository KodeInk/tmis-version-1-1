<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>favicon.ico">
	<title><?php echo SITE_TITLE.": Dashboard";?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.css" type="text/css" media="screen" />
     <?php echo "<link href=\"//fonts.googleapis.com/css?family=Roboto:400,300\" rel=\"stylesheet\" type=\"text/css\">";?>
    <script src='<?php echo base_url();?>assets/js/jquery.min.js' type='text/javascript'></script>
    <script src='<?php echo base_url();?>assets/js/clout.js' type='text/javascript'></script>
	<?php 
		echo get_ajax_constructor(TRUE);
	?>
    
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php 
  #WARNING: All HTML should be on one line or the string properly broken to avoid 
  #upsetting its display javascript
  $defaultHtml = "<table border='0' cellspacing='0' cellpadding='15' class='submenu'>".
  "<tr>".
  "<td class='activemenu' nowrap><a href='javascript:void(0);'>Summary</a></td>".
  "<td class='inactivemenu' nowrap><a href='javascript:void(0);'>Graph</a></td>".
  "<td class='activemenu' style='width:48px; padding:0px; height:57px;' nowrap><a href='javascript:void(0);' onclick='showSubMenu()'><img src='".base_url()."assets/images/front_arrow_grey.png' border='0'></a></td>".
  "</tr>".
  "</table>";
  
  $this->load->view('web/addons/header_admin', array('main'=>'users', 'sub'=>'', 'defaultHtml'=>$defaultHtml));?>
  <tr>
    <td style="padding:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" valign="top"><table border="0" cellspacing="0" cellpadding="8" class="bodytable">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class='largefont' nowrap>Users</td>
                <td align="right" nowrap><a href="javascript:void(0);">Today</a> / <a href="javascript:void(0);">Month</a> / <a href="javascript:void(0);" class='activelink'>All Time</a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><input name="totalusers" type="text" class="textfield" id="totalusers" value='174,874' size="35" readonly></td>
          </tr>
          <tr>
            <td class='largefont'>Invites Pending</td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><input name="totalpendinginvites" type="text" class="textfield" id="totalpendinginvites" size="35" value='348,874' readonly></td>
          </tr>
          <tr>
            <td class='largefont'>Invites Sent</td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><input name="totalinvitessent" type="text" class="textfield" id="totalinvitessent" size="35" value='584,874' readonly></td>
          </tr>
        </table></td>
        <td width="1%" style="padding-left:20px;" valign="top"><table border="0" cellspacing="0" cellpadding="8" class="bodytable">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class='largefont' nowrap>Imported Contacts</td>
                <td align="right" nowrap><a href="javascript:void(0);">Today</a> / <a href="javascript:void(0);">Month</a> / <a href="javascript:void(0);" class='activelink'>All Time</a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><input name="totalimportedcontacts" type="text" class="textfield" id="totalimportedcontacts" size="35" value='10,547,542' readonly></td>
          </tr>
          <tr>
            <td class='largefont'>Emails</td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><input name="totalemails" type="text" class="textfield" id="totalemails" size="35" value='9,892,578' readonly></td>
          </tr>
          <tr>
            <td class='largefont'>Phone Numbers</td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><input name="totalphonenumbers" type="text" class="textfield" id="totalphonenumbers" size="35" value='1,023,655' readonly></td>
          </tr>
        </table></td>
        <td valign="top" style="padding-left:20px;"><table border="0" cellspacing="0" cellpadding="8" width="100%" class="bodytable">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" nowrap class='largefont'>Search Tags</td>
                <td style="padding-right:8px;" align="right"><a href="javascript:void(0);">Add</a> / <a href="javascript:void(0);">Delete</a> / <a href="javascript:void(0);">Rename</a></td>
                <td width="1%" align="right" nowrap><input name="searchtags" type="text" class="searchfield" id="searchtags" value='' placeholder="search by tag.." size="17">
               </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td style="width:20px">&nbsp;</td>
                  <td style="width:100px;cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Name <img src="<?php echo base_url();?>assets/images/down_arrow_grey.png" border="0"/></a></td>
                  <td><a href="javascript:void(0);" class='activelink'>Description</a></td>
                </tr>
         </table></td>
  </tr>
  <tr>
    <td><div id='search_tags_div' style='max-height:162px; overflow:auto;'>
              <table width="100%" border="0" cellspacing="0" cellpadding="5" class='listtable'>
                <tr>
                  <td valign="top" style="width:20px"><input type="checkbox" name="searchtag1" id="searchtag1"></td>
                  <td valign="top" style="width:100px">High Scorers</td>
                  <td valign="top">Users with Clout scores above 1,000</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag6" id="searchtag6"></td>
                  <td valign="top">Fast Climbers</td>
                  <td valign="top">Users with a score jump of at least 50% in the last month.</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag2" id="searchtag2"></td>
                  <td valign="top">Forced Closure</td>
                  <td valign="top">Users whose accounts were closed by the system admin</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top">Power Players</td>
                  <td valign="top">Users with over 1,000 contacts</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag4" id="searchtag4"></td>
                  <td valign="top">Store Owners</td>
                  <td valign="top">Users who own a store account.</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag5" id="searchtag5"></td>
                  <td valign="top">Store Staff</td>
                  <td valign="top">Users attached to a specific store as a staff member.</td>
                </tr>
                
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag7" id="searchtag7"></td>
                  <td valign="top">Executive Team</td>
                  <td valign="top">Members of the Clout executive team.</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag8" id="searchtag8"></td>
                  <td valign="top">Money Members</td>
                  <td valign="top">Users with cash balance above $100,000</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag9" id="searchtag9"></td>
                  <td valign="top">Complaints</td>
                  <td valign="top">Members with average of more than 10 complaints last month</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag10" id="searchtag10"></td>
                  <td valign="top">Active Users</td>
                  <td valign="top">Users who are currently active</td>
                </tr>
              </table>
            </div></td>
  </tr>
</table>
</td>
          </tr>
        </table></td>
        <td valign="top" style="padding-left:20px;"><table border="0" cellspacing="0" cellpadding="8" width="100%" class="bodytable">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" nowrap class='largefont'>Flags</td>
                <td style="padding-right:8px;" align="right"><a href="javascript:void(0);">Add</a> / <a href="javascript:void(0);">Delete</a> / <a href="javascript:void(0);">Rename</a></td>
                <td width="1%" align="right" nowrap><input name="searchtags" type="text" class="searchfield" id="searchtags" value='' placeholder="search by flag.." size="17">
               </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td style="padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                  <td style="width:20px">&nbsp;</td>
                  <td style="width:100px;cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Name <img src="<?php echo base_url();?>assets/images/down_arrow_grey.png" border="0"/></a></td>
                  <td><a href="javascript:void(0);" class='activelink'>Description</a></td>
                </tr>
         </table></td>
  </tr>
  <tr>
    <td><div id='search_tags_div' style='max-height:162px; overflow:auto;'>
              <table width="100%" border="0" cellspacing="0" cellpadding="5" class='listtable'>
                <tr>
                  <td valign="top" style="width:20px"><input type="checkbox" name="searchtag1" id="searchtag1"></td>
                  <td valign="top" style="width:100px">Review</td>
                  <td valign="top">Review note attached to user's account</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag6" id="searchtag6"></td>
                  <td valign="top">Complaint</td>
                  <td valign="top">User filed a complaint</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag2" id="searchtag2"></td>
                  <td valign="top">Tech Support</td>
                  <td valign="top">User needs tech support</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag3" id="searchtag3"></td>
                  <td valign="top">Help Desk</td>
                  <td valign="top">User has a help request.</td>
                </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag4" id="searchtag4"></td>
                  <td valign="top">Sales</td>
                  <td valign="top">Sales needs to address.</td>
                  </tr>
                <tr>
                  <td valign="top"><input type="checkbox" name="searchtag5" id="searchtag5"></td>
                  <td valign="top">Fraud</td>
                  <td valign="top">User's account marked for fraud check.</td>
                </tr>
                </table>
            </div></td>
  </tr>
</table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="padding:20px; padding-top:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="8" class="bodytable">
      <tr>
        <td style="padding-bottom:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class='largefont' nowrap>System Users</td>
    <td width="1%" style="padding-right:10px;"><input type="button" name="suspend" id="suspend" value="suspend" class="lightredbtn"></td>
    <td width="1%" style="padding-right:10px;"><input type="button" name="addflag" id="addflag" value="add flag" class="otherbtn"></td>
    <td width="1%" style="padding-right:10px;"><input type="button" name="addtogroup" id="addtogroup" value="add to group" class="otherbtn"></td>
    <td width="1%" style="padding-right:10px;"><input type="button" name="addsearchtag" id="addsearchtag" value="add search tag" class="otherbtn"></td>
    
    <td width="1%" style="padding-left:60px; padding-right:0px;" align="right"><input name="searchusers" type="text" class="searchfield" id="searchusers" value='' placeholder="search.." size="30"></td>
  </tr>
</table>
</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div id='search_list_div' style='overflow: auto; overflow-y: hidden; -ms-overflow-y: hidden;'>
              <table width="100%" border="0" cellspacing="0" cellpadding="5" class='listtable'>
                <thead>
                <tr>
                  <td valign="bottom" width="1%"><input type="checkbox" name="selectall" id="selectall"></td>
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>First Name</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Last Name</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Email Address</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Date Joined</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_blue.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Mobile Phone</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Date of Birth</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Gender</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Address</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>City</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>State</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
                  
                  
                  <td valign="bottom" style="cursor:pointer;"><a href="javascript:void(0);" class='activelink'>Country</a> 
                  <table align="center" class='clearborders'>
                  <tr>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/down_arrow_big_grey.png" border="0"/></a>
                  </td>
                  <td><a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/images/up_arrow_big_grey.png" border="0"/></a>
                  </td>
                  </tr>
                  </table>
                  </td>
                  
               </tr>
                </thead>
                
                
                
                
                
                <?php
				foreach($pageList AS $row)
				{
					echo "<tr>
                  <td valign='top'><input type='checkbox' name='user_".$row['id']."' id='user_".$row['id']."'></td>
                  <td valign='top'>".$row['first_name']."</td>
                  <td valign='top'>".$row['last_name']."</td>
                  <td valign='top'>".$row['email_address']."</td>
                  <td valign='top'>".date('m/d/Y', strtotime($row['date_added']))."</td>
                  <td valign='top'>".format_phone_number($row['mobile_phone'])."</td>
                  <td valign='top'>".($row['birthday'] != '0000-00-00'? date('m/d/Y', strtotime($row['birthday'])): '&nbsp;')."</td>
                  <td valign='top'>".ucfirst($row['gender'])."</td>
                  <td valign='top'>".$row['address_line_1'].(!empty($row['address_line_2'])? "<br>".$row['address_line_2']: "")."</td>
                  <td valign='top'>".$row['city']."</td>
                  <td valign='top'>".$row['state']."</td>
                  <td valign='top'>".$row['country']."</td>
                </tr>";
				}
				
				?>
                
                
              </table>
            </div></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table></td>
      </tr>
      <tr>
      <td align="right" style="padding-top:0px;"><a href="javascript:void(0);">more <img src="<?php echo base_url();?>assets/images/down_arrow_big_blue.png" border="0" height="7"/></a></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>