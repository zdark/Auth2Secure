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
// HTML ForceHTTPS and Chache
htmlForceHTTPS();
htmlCache();

// HTML Page Start
htmlHeader($settings[1] . " [Users]", $settings_root_site, TRUE); //title, siteRootPath, menuShow

?>

		<!-- START INTERNA -->
		
		
		<?
			//include "conn.php";
            
			?>
			
			<p class="titles">Users Config</p>
			<a href="user_add.php?action=new"><img src="../icons/edit.png" border=1 ></a> Add New User
			<br><br>
			<table>
				<tr class="filasTituloMain01">
					<td width="80" nowrap bgcolor="#336666" class="table_title"><b>User Name</b></td>
					<td width="80" nowrap bgcolor="#336666" class="table_title"><b>Access Level</b></td>
					<td width="80" nowrap bgcolor="#336666" class="table_title">First Name </td>
					<td width="80" nowrap bgcolor="#336666" class="table_title">Last Name </td>
					<td width="20" bgcolor="#336666" class="table_title">&nbsp;</td>
					<td width="20" bgcolor="#336666" class="table_title">&nbsp;</td>
					<td width="20" bgcolor="#336666" class="table_title">&nbsp;</td>
				</tr>
			<?
            
            $sql = "SELECT T1.*, T2.name_role FROM users AS T1
					LEFT JOIN ac_role AS T2 ON T1.access_level = T2.id ORDER BY T1.access_level";
			//$result = mysql_query($sql); // OLD CONNECTION
			
            // PDO DB
            $sth = $dbh->query($sql);
            $sth->setFetchMode(PDO::FETCH_OBJ);
            
			while($rs = $sth->fetch())
			//while($rs = mysql_fetch_object($result)) // OLD CONNECTION
			{
			?>
				<tr style="background: #555555">
					<td class="table-cell-1"><?=sec_cleanHTML($rs->username) ?></td>
					<td class="table-cell-1"><?=sec_cleanHTML($rs->name_role) ?></td>
					<td class="table-cell-1" nowrap ><?=sec_cleanHTML($rs->firstname) ?></td>
					<td class="table-cell-1" nowrap ><?=sec_cleanHTML($rs->lastname) ?></td>
					<td class="table-cell-1" align="center"><a href="user_add.php?action=edit&id=<?=encryptData(session_id(), $rs->id) ?>"><img src="../icons/edit.png" border=0 height=12></a></td>
                    <? if ($rs->id != 1) { ?>
					<td class="table-cell-1" align="center"><a href="user_action.php?action=delete&id=<?=encryptData(session_id(), $rs->id) ?>"><img src="../icons/cancel.png" border=0 height=12></a></td>
                    <? } else { ?>
					<td class="table-cell-1" align="center"></td>
                    <? } ?>
					<td class="table-cell-1" nowrap><a href="user_login_list.php?id=<?=encryptData(session_id(), $rs->id) ?>">View Logins</a></td>
				</tr>
			<?
            }
            unset($sth);
			?>
			</table>
		
        
		<!-- END INTERNA -->

<?
// HTML Page End
htmlFooter();
?>
