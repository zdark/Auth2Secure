<?
/*
	Auth2Secure provides a base schema for authentication, security and audit.
	Auth2Secure is based on Auth2DB authentication and security modules.

	Copyright (c) 2010-2014 Julia Calvo, zDark (zdarkprojects [_AT_] gmail.com)

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<title>MENU</title>

		<link rel="stylesheet" href="<?=$settings_root_site;?>js/menu/dropSlideMenu.css" type="text/css" media="all">
		<link rel="stylesheet" href="<?=$settings_root_site;?>js/menu/jquery.dropSlideMenu.css" type="text/css" media="all">

		<script type="text/javascript" src="<?=$settings_root_site;?>js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="<?=$settings_root_site;?>js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="<?=$settings_root_site;?>js/menu/jquery.event.hover.js"></script>
		<script type="text/javascript" src="<?=$settings_root_site;?>js/menu/jquery.dropSlideMenu.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				$("#navigation").dropSlideMenu({
					indicators: true, // adds a div to the list items for attaching indicators (arrows)
					clickstream: true, // highlights the clickstream in a menu by comparing the links to the current URL path
					openEasing: "easeOutQuad", // open animation effect
					closeEasing: "easeInQuad", // close animation effect
					duration: 600, // speed of drop down animation (in milliseconds)
					delay: 800, // delay before the drop down closes (in milliseconds)
					hideSelects: true // hide all select elements on the page when the menu is active (IE6 only)
				});
			});
		</script>

	</head>

	<body>

		<div id="_container">
			
			<div id="navigation">
				<ul style="margin:0px; padding:0px;">

					<? if (rac_verify(3)) { ?>
					<li style="margin-right:1px"><a href="<?=$settings_root_site;?>home.php">Home</a></li>
                    <? } ?>
                    
					<? if (rac_verify(1)) { ?>
					<li style="margin-right:1px"><a href="<?=$settings_root_site;?>_Logs/logs.php">Logs</a>
					</li>
					<? } ?>
                    
                    <? if (rac_verify(1)) { ?>
					<li style="margin-right:1px"><a href="#">Admin</a>
						<ul style="margin:0px; padding:0px;">
							<? if (rac_verify(1)) { ?>
							<li><a href="<?=$settings_root_site;?>_Admin/user_config_list.php">Users</a></li>
							<? } ?>
							<? if (rac_verify(1)) { ?>
							<li><a href="<?=$settings_root_site;?>_Admin/admin_profile.php">Profiles</a></li>
							<? } ?>
                            <? if (rac_verify(1)) { ?>
							<li><a href="<?=$settings_root_site;?>_Admin/admin_profile_file.php">Profiles F</a></li>
							<? } ?>
						</ul>
					</li>
					<? } ?>
					
                    <? if (rac_verify(4)) { ?>
					<li style="margin-right:1px"><a href="<?=$settings_root_site?>_Auth/password.php">Password</a></li>
					<? } ?>

					<li style="margin-right:1px"><a href="<?=$settings_root_site?>_Auth/logout.php">Logout</a></li>
                    
					<li class="last-login"><? //include "user_last_login.php"; ?></li>
				</ul>
				
			</div>
			
		</div>
		
		
	</body>
</html>