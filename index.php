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
include "_Security/functions.php"; 

htmlForceHTTPS();
htmlCache();

htmlHeader($settings[1], $settings_root_site, FALSE); //title, siteRootPath

htmlForceLocation();

?>

                <!-- START INTERNA -->
                
				<table style="top:0px;left:0px;height:400px;width:100%;">
				  <tr align="center">
					<td valign="top">
						<div class="_testcard" align="center">
							<div class="loginbox" align="center"> <br />
								<br />
								<span style="font-family:verdana;font-weight:bold;color:red;font-size:15px;"></span>
                                <br />
								<br />
								<span style="font-family:arial;color:black;font-weight:bold;font-size:10px;"><? echo $settings[1]; ?></span><br>
							  <br>
								<form method="POST" action="_Auth/login.php" autocomplete="off">
								  <table align="center">
									<tr>
									  <td>Username: </td>
									  <td><input class="input" type="text" name="username" size="20" ></td>
									</tr>
									<tr>
									  <td>Password: </td>
									  <td><input class="input" type="password" name="password" size="20"></td>
									</tr>
									<tr>
									  <td></td>
									  <td><br />
										  <input class="input" type="submit" value="Submit" name="login"></td>
									</tr>
								  </table>
								</form>
								<?
									$error = $_GET["error"];
									if ( $error == 1) {
										echo "Incorrect login name or password. Please try again.";
									} else if ( $error == 2) {
										echo "Your IP has been blocked.";
									}
								?>
							</div>
						</div>
						</td>
					  </tr>
					</table>
                    
                <!-- END INTERNA -->                    
                
<?
htmlFooter();
?>				
				