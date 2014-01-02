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
?>
<?

$user = $_SESSION["username"];
$user_id = $_SESSION["id_user"];
$url = $_SERVER['PHP_SELF'];
$params_get = http_build_query($_GET);
$params_post = http_build_query($_POST);
$params_request = http_build_query($_REQUEST);
$log_date = date("Y/m/d : H:i:s", time());
$method = $_SERVER['REQUEST_METHOD'];
/*

echo "PHP_SELF:" . $_SERVER['PHP_SELF'];
echo "<br>";
echo "query: " . $_SERVER['REQUEST_URI'];
echo "<br>POST: ";
print_r($_POST);
echo "<br>GET: ";
print_r($_GET);

echo "<br><br>IMPLODE_POST: ";
echo implode("||", $_POST);
echo "<br>IMPLODE_GET: ";
echo implode("||", $_GET);
echo "<br><br>";

echo "<br><br>BUILD_POST: ";
echo http_build_query($_POST);
echo "<br>BUILD_GET: ";
echo http_build_query($_GET);

exit;
*/

$sql = "INSERT INTO audit_logs (user, user_id, url, params_request, params_get, params_post, log_date, method) 
        VALUES 
        ('$user','$user_id','$url','$params_request','$params_get','$params_post','$log_date', '$method')";
//$results = mysql_query($sql); // OLD CONNECTION
// PDO DB
//$sth = $dbh->query($sql);
$sth = $dbh->exec($sql);
unset($sth);

?>