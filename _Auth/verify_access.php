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
// VERIFY SCRIPT ACCESS
session_start();
$access_level = $_SESSION["access_level"];

include_once "settings.php";
include $settings_root_folder . "_Security/conn.php";

$php_file = $_SERVER["SCRIPT_NAME"];
$break = explode('/',$php_file);
$php_file  = $break[count($break) - 1];
//echo $php_file . "<br>";

$sql = "SELECT * FROM ac_file WHERE name_file = '$php_file'";
//$result = mysql_query($sql); // OLD CONNECTION
//$rs = mysql_fetch_object($result); // OLD CONNECTION

// PDO DB
$sth = $dbh->query($sql);
$sth->setFetchMode(PDO::FETCH_OBJ);
$rs = $sth->fetch();
unset($sth);

if ( is_object($rs) ) {
	//echo "FILE: " . $rs->name_file;
	
	$sql = "SELECT * FROM ac_mm_role_file WHERE role_id = $access_level AND file_id = $rs->id";
	//$result = mysql_query($sql); // OLD CONNECTION
	//$rs_ac = mysql_fetch_object($result); // OLD CONNECTION
    
    // PDO DB
    $sth = $dbh->query($sql);
    $sth->setFetchMode(PDO::FETCH_OBJ);
    $rs_ac = $sth->fetch();
    unset($sth);
    
	if ( is_object($rs_ac) ) {
		//echo "access ok";
	} else {
		echo "access denied";
		header( "Location: ".$settings_root_site."msg.php?msg=0" );
	}
	
} else {
	//echo "NO AC FILE";
}

?>