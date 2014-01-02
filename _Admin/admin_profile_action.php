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
session_start();
?>
<?
include "settings.php";
include $settings_root_folder . "_Security/conn.php";
include_once $settings_root_folder . "_Security/security.php";
include_once $settings_root_folder . "_Security/functions.php";
include_once $settings_root_folder . "_Auth/verify.php";
//include $settings_root_folder . "sql_query.php";
?>
<? if ($_SESSION["access_level"] != 1) header( "Location: logout.php" ); ?>
<?
//include "conn.php";

$role = sec_numeric($_SESSION["role"]);
//$item_id = sec_cleanTAGS($_GET["item_id"]);
$item_id = sec_cleanTAGS(decryptData(session_id(), $_GET["item_id"]));
$action = sec_cleanTAGS($_GET["action"]);

if ($action == "add") {
	$sql = "INSERT INTO ac_mm_role_item (role_id, item_id) VALUES ($role,$item_id)";
	//$result = mysql_query($sql); // OLD CONNECTION
    // PDO DB
    $sth = $dbh->exec($sql);
    unset($sth);
    
} else if ($action == "remove") {
	$sql = "DELETE FROM ac_mm_role_item WHERE role_id = $role AND item_id = $item_id";
	//$result = mysql_query($sql); // OLD CONNECTION
    // PDO DB
    $sth = $dbh->exec($sql);
    unset($sth);
    
}

header( "Location: admin_profile.php" );
?>