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
<?
if ($_SERVER['SERVER_PORT']!=443)
{
$url = "https://". $_SERVER['SERVER_NAME'] . ":443".$_SERVER['REQUEST_URI'];
header("Location: $url");
}
?>
<?
session_start();
include "settings.php";
include_once $settings_root_folder . "_Auth/login_check.php";
include_once $settings_root_folder . "_Auth/verify_access.php";
include_once $settings_root_folder . "_Logs/logs_action.php";
?>
<? //include "login_check.php"; ?>
<? //include "verify_access.php"; ?>
