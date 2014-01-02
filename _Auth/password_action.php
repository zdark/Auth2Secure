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
<? include "settings.php" ?>
<? include "verify.php" ?>
<? include "password_policy.php" ?>
<?
include_once $settings_root_folder . "_Security/conn.php";
include_once $settings_root_folder . "_Security/security.php";

regex_standard($_POST["action"]);
$action = sec_addESC($_POST["action"]);

regex_standard($_POST["username"]);
$username = sec_addESC($_POST["username"]);

regex_standard($_POST["password_old"]);
$password_old = sec_addESC($_POST["password_old"]);

regex_standard($_POST["password"]);
$password = sec_addESC($_POST["password"]);

regex_standard($_POST["password_again"]);
$password_again = sec_addESC($_POST["password_again"]);

// VERIFY OLD PASSWORD

$id_user = $_SESSION["id_user"];
$user = $_SESSION['username'];
$pass = md5($password_old);

$sql = "select * from users where username = '$user' AND password = '$pass' AND id = $id_user ";

//$result = mysql_query($sql); // OLD CONNECTION
//error_handler_sql($result); // OLD CONNECTION

//check that at least one row was returned
// $rowCheck = mysql_num_rows($result); // OLD CONNECTION

$sql = "select count(*) AS num from users where username = '$user' AND password = '$pass' AND id = $id_user ";

// PDO DB
$sth = $dbh->query($sql);
$sth->setFetchMode(PDO::FETCH_OBJ);
//check that at least one row was returned
//$rowCheck = $sth->rowCount();
$rowCheck = $sth->fetch()->num;
unset($sth);

if ($password != "" and $password == $password_again and $rowCheck == 1 ) {

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

	$sql = "SELECT id, username FROM users WHERE username = '".$_SESSION['username']."' AND password = md5('$password_old'); ";

	//$result = mysql_query($sql); // OLD CONNECTION
	//$rs = mysql_fetch_object($result); // OLD CONNECTION
    
    // PDO DB
    $sth = $dbh->query($sql);
    $sth->setFetchMode(PDO::FETCH_OBJ);
    $rs = $sth->fetch();
    unset($sth);
	
	if ($rs->username == $_SESSION['username']) {
		$sql = "UPDATE users SET password = md5('$password') WHERE id = $rs->id ";
		//$result = mysql_query($sql); // OLD CONNECTION
        $sth = $dbh->exec($sql);
        unset($sth);
	}
	
} else{
	header("Location: ".$settings_root_site."msg.php?msg=2"); 
	exit;
}

header("Location: ".$settings_root_site."msg.php?msg=1"); 
exit;

?>