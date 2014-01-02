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
<? include_once "_Auth/verify.php" ?>
<? include_once "_Auth/password_policy.php" ?>
<? include_once "_Security/security.php" ?>

<?
htmlForceHTTPS();
htmlCache();

htmlHeader($settings[1], $settings_root_site, TRUE); //title, siteRootPath, menuShow

htmlForceLocation();

?>

                <!-- START INTERNA -->
                
                <?
                    $msg[0] = "Access Denied";
                    $msg[1] = "Your password has been changed";
                    $msg[2] = "Password error, please try again";
                    $msg[3] = "Parameter error, please try again";
                    
                    $value = trim(sec_cleanHTML($_GET["msg"]));
                    if ($value == "") $value = 0;

                    if (is_numeric($value) and strlen($value) <= 2) {
                        if ($msg[$value] != "") {
                            echo sec_cleanHTML($msg[$value]);
                        } else {
                            echo "undefined error, please try again";
                        }
                    } else {
                        echo "Why are you trying to hack me?";
                    }
                    
                    /*
                    $msg = sec_cleanHTML($_GET["msg"]);
                    if ($msg == 1) {
                        echo "Your password has been changed";
                    } else if ($msg == 2) {
                        echo "Password error, please try again";
                    }
                    */
                    
                ?>
                
                <!-- END INTERNA -->
<?
htmlFooter();
?>