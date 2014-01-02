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

include "settings.php";
include $settings_root_folder . "_Security/conn.php";

//if(session_is_registered('username')){ // DEPRECATED
if(isset($_SESSION['username'])){

	$session_id = session_id();
	$remote_host = $_SERVER['REMOTE_ADDR'];
	
	$sql = "SELECT * FROM users WHERE session_id = '$session_id' AND remote_host = '$remote_host'";
	//$result = mysql_query($sql); // OLD CONNECTION
	//error_handler_sql($result);
	//$rs = mysql_fetch_object($result); // OLD CONNECTION

    // PDO DB
    $sth = $dbh->query($sql);
    $sth->setFetchMode(PDO::FETCH_OBJ);
    $rs = $sth->fetch();
    unset($sth);
    
	if ( is_object($rs) ) { 
	
		// check ssession time 30 min
		if (isset($_SESSION['time']) and (time() - $_SESSION['time'] > 1800)) {
			//include "logout.php";
			include $settings_root_folder . "_Auth/logout.php";
		}
		$_SESSION['time'] = time(); // update last activity time stamp
	
		return true; 
	} else { 
        header( "Location: ".$settings_root_site."index.php" );
		return false; 
	} 

}
else{
	header( "Location: ".$settings_root_site."index.php" );
}

?>