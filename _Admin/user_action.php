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
include_once $settings_root_folder . "_Security/security.php";
include_once $settings_root_folder . "_Security/functions.php";
include_once $settings_root_folder . "_Auth/verify.php";
//include $settings_root_folder . "sql_query.php";
?>

<? include $settings_root_folder . "_Auth/password_policy.php" ?>

<? if ($_SESSION["access_level"] != 1) header( "Location: ".$settings_root_site."logout.php" ); ?>
<?

if ($_POST["action"] != "") {
    regex_standard($_POST["action"]);
    $action = sec_addESC($_POST["action"]);
} else {
    regex_standard($_GET["action"]);
    $action = sec_addESC($_GET["action"]);
}

//regex_standard($_POST["id"]);
//$id = sec_addESC($_POST["id"]);

if ($_POST["id"] != "") {
    $id = sec_cleanTAGS(decryptData(session_id(), $_POST["id"]));
} else {
    $id = sec_cleanTAGS(decryptData(session_id(), $_GET["id"]));
}

regex_standard($_POST["username"]);
$username = sec_addESC($_POST["username"]);

regex_standard($_POST["password"]);
$password = sec_addESC($_POST["password"]);

regex_standard($_POST["password_again"]);
$password_again = sec_addESC($_POST["password_again"]);

regex_standard($_POST["access_level"]);
$access_level = sec_addESC($_POST["access_level"]);

regex_email($_POST["email"]);
$email = sec_addESC($_POST["email"]);


if ($action == "edit" ){
	$sql = "UPDATE users SET username = '$username', access_level = '$access_level', email = '$email' WHERE id = '$id' ";
	//$conn = mysql_query($sql); // OLD CONNECTION
    // PDO DB
    $sth = $dbh->exec($sql);
	unset($sth);
    
	if ($password != "" AND $password == $password_again) {
	
		// PASSWORD POLICY
		$policy = new PasswordPolicy();
		
		$policy->min_length = 8;
		$policy->min_lowercase_chars = 1;
		$policy->min_uppercase_chars = 1;
		$policy->min_numeric_chars = 1;
		//$policy->min_nonalphanumeric_chars = 1;
		
		if( $policy->validate($password) ) { 
			//echo "Password OK!";
		} else {
			foreach( $policy->get_errors() as $id=>$rule ) {
				echo "<p id=\"$id\">$rule</p>";
			}
			exit;
		}
	
		$sql = "UPDATE users SET password = md5('$password') WHERE id = '$id' ";
		//$conn = mysql_query($sql); // OLD CONNECTION
        // PDO DB
        $sth = $dbh->exec($sql);
        unset($sth);
	}
	
} else if ($action == "new" ){
	if ($password != "" AND $password == $password_again) {
		$sql = "INSERT INTO users (username,password,access_level, email) VALUES ('$username',md5('$password'),'$access_level','$email')";
		//$conn = mysql_query($sql); // OLD CONNECTION
        
        // PDO DB
        $sth = $dbh->exec($sql);
        unset($sth);
        
	} else {
		header("Location: error.php"); 
    }

} else if ($action == "delete" ){
    if ($id != 1) {
		$sql = "DELETE FROM users WHERE id = '$id' ";
		//$conn = mysql_query($sql); // OLD CONNECTION
                
        // PDO DB
        $sth = $dbh->exec($sql);
        unset($sth);
    }

}

header("Location: user_config_list.php"); 

?>