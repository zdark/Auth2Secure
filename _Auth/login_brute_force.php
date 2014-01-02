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
include_once "settings.php";
include_once $settings_root_folder . "_Security/conn.php";
$remote_host = $_SERVER['REMOTE_ADDR'];

$sql = "SELECT * FROM login_attempt WHERE remote_host = '$remote_host'";
//$result = mysql_query($sql);
//$rs = mysql_fetch_object($result);

// PDO DB
$sth = $dbh->query($sql);
$sth->setFetchMode(PDO::FETCH_OBJ);
$rs = $sth->fetch();
unset($sth);

if ($rs->login_attempt >= 5) { 
	header( "Location: ".$settings_root_site."index.php?error=2" );
	exit;
}

if ($attempt == 'fail') { 
	if ( is_object($rs) ) { 
		$sql = "UPDATE login_attempt SET login_attempt = (login_attempt + 1) WHERE id = $rs->id ";
	} else {
		$sql = "INSERT INTO login_attempt (remote_host, login_attempt) VALUES ('$remote_host', 1)";
	}
	//$result = mysql_query($sql); // OLD CONNECTION
    $sth = $dbh->exec($sql);
    unset($sth);
    
} else if ($attempt == 'success') {
	$sql = "UPDATE login_attempt SET login_attempt = 0 WHERE id = $rs->id ";
	//$result = mysql_query($sql); // OLD CONNECTION
    $sth = $dbh->exec($sql);
    unset($sth);
    
}

 
?>