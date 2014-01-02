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

<? if ($_SESSION["access_level"] != 1) header( "Location: ".$settings_root_site."_Auth/logout.php" ); ?>
<?
htmlForceHTTPS();
htmlCache();

htmlHeader($settings[1], $settings_root_site, TRUE); //title, siteRootPath, menuShow

?>

		<!-- START INTERNA -->
				
		<?
		
		$action = sec_cleanTAGS($_GET["action"]);
		$action = sec_addESC($action);
		
		//$id = sec_cleanTAGS($_GET["id"]);
		//$id = sec_addESC($id);
		$id = sec_cleanTAGS(decryptData(session_id(), $_GET["id"]));
		
		if ($action != "new") {
			$sql = "SELECT * FROM users WHERE id = $id ";
			
            //$result = mysql_query($sql); // OLD CONNECTION
			//$rs = mysql_fetch_object($result); // OLD CONNECTION
            
            // PDO DB
            $sth = $dbh->query($sql);
            $sth->setFetchMode(PDO::FETCH_OBJ);
            $rs = $sth->fetch();
            unset($sth);
            
		}
		?>
		
		<p class="titles">Users Config</p>
		
		<form action="user_action.php" method="POST" autocomplete="off" >
		
		<? show_error(); ?>
		
		<table cellpadding="4" cellspacing="1" border=0>
			<tr>
				<td class="form-cell-1" >User Name: </td>
				<td class="form-cell-2" ><input class="input" type="text" name="username" value="<? if ($action != 'new') echo sec_cleanHTML($rs->username) ?>"></td>
			</tr>
			<tr>
				<td class="form-cell-1" >User Password: </td>
				<td class="form-cell-2" ><input class="input" type="password" name="password" value=""> </td>
			</tr>
			<tr>
				<td class="form-cell-1" >Retype Password: </td>
				<td class="form-cell-2" ><input class="input" type="password" name="password_again" value=""> </td>
			</tr>
			<tr>
				<td class="form-cell-1"  >Access Level: </td>
				<td class="form-cell-2" >
					<select class="input" name="access_level" size="1" >
						<?
							/*
							$arrayAccess = array('Administrator', 'Opeartor' );
							for($i=0;$i<=sizeof($arrayAccess) - 1;$i++)
							{
						?>
							<option value="<? echo $arrayAccess[$i]  ?>" <? if ($rs->access_level == $arrayAccess[$i] ) echo "selected" ?> ><? echo $arrayAccess[$i] ?></option>
						<? 
							} 
							*/
						?>
						<?
							$sql = "SELECT * FROM ac_role";
							//$result_role = mysql_query($sql); // OLD CONNECTION
                            
                            // PDO DB
                            $sth = $dbh->query($sql);
                            $sth->setFetchMode(PDO::FETCH_OBJ);
                            
							while ($rs_role = $sth->fetch()) {
                            //while ($rs_role = mysql_fetch_object($result_role)) { // OLD CONNECTION
								echo "<option value='" . $rs_role->id . "'";
								if ($rs->access_level == $rs_role->id ) echo "selected";
								echo ">" . $rs_role->name_role . "</option>";
							}
                            unset($sth);
                            
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="form-cell-1"  >Email: </td>
				<td class="form-cell-2" ><input class="input" type="text" name="email" value="<? if ($action != 'new') echo sec_cleanHTML($rs->email)?>"></td>
			</tr>
			<tr>
				<td class="form-cell-1" >&nbsp;</td>
				<td class="form-cell-1" ><input class="input" type="submit" value="Save" ></td>
			</tr>
		</table>
		<input type="hidden" name="action" value="<? echo $action ?>" >
		<input type="hidden" name="id" value="<? if ($action != 'new') echo encryptData(session_id(), $id) ?>" >
		</form>
		
		<!-- END INTERNA -->

<?
htmlFooter();
?>