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

include "settings.php";
include $settings_root_folder . "_Security/conn.php";

//start the session
session_start();

//check to make sure the session variable is registered
if(isset($_SESSION["username"])) {
	
	// UPDATE close_session IN users_audit
	include "conn.php";
	$username = $_SESSION["username"];
	$session_id = session_id();
	
	$fecha = date("Y-m-d H:i:s");
	
	$sql = "UPDATE users_audit SET close_session = '$fecha' WHERE session_id = '$session_id' AND username = '$username' ";
	//$conn = mysql_query($sql); // OLD CONNECTION
    // PDO DB
    $sth = $dbh->exec($sql);
	unset($sth);
    
	$sql = "UPDATE users SET session_id = '', remote_host = '' WHERE session_id = '$session_id' AND username = '$username' ";
	//$conn = mysql_query($sql); // OLD CONNECTION
	// PDO DB
    $sth = $dbh->exec($sql);
    unset($sth);
    
	//session variable is registered, the user is ready to logout
	session_unset();
	session_destroy();
	
	// TOP PAGE LOGOUT ----------------->
	header( "Location: ".$settings_root_site."index.php" );
	// END TOP PAGE LOGOUT ----------------->
}
else{

	//the session variable isn't registered, the user shouldn't even be on this page
	header( "Location: ".$settings_root_site."index.php" );
}

?> 