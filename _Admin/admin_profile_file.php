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
?>
<?
include "settings.php";
include $settings_root_folder . "_Security/conn.php";
include_once $settings_root_folder . "_Security/security.php";
include_once $settings_root_folder . "_Security/functions.php";
include_once $settings_root_folder . "_Auth/verify.php";
//include $settings_root_folder . "sql_query.php";
?>
<?
if ($_POST["role"] != ""){
	$role = sec_numeric($_POST["role"]);
	$_SESSION["role"] = $role;
} else {
	if ($_SESSION["role"] != "" ) {
		$role = sec_numeric($_SESSION["role"]);
	} else {
		$role = "";
	}
}
?>
<? if ($_SESSION["access_level"] != 1) header( "Location: ../_Auth/logout.php" ); ?>
<?
// HTML ForceHTTPS and Chache
htmlForceHTTPS();
htmlCache();

// HTML Page Start
htmlHeader($settings[1], $settings_root_site, TRUE); //title, siteRootPath, menuShow

?>

                <!-- START INTERNA -->
                
                    <form action="#" method="post">
                        <select class="input" name="role">
                            <option>select</option>
                            <?
                                $sql = "SELECT * FROM ac_role";
                                // $result_role = mysql_query($sql); // OLD CONNECTION
                                
                                // PDO DB
                                $sth = $dbh->query($sql);
                                $sth->setFetchMode(PDO::FETCH_OBJ);
                                
                                while($rs_role = $sth->fetch()) {
                                //while($rs_role = mysql_fetch_object($result_role)) { // OLD CONNECTION
                                    echo "<option value='$rs_role->id' ";
                                    if ($role == $rs_role->id) echo "selected";
                                    echo ">$rs_role->name_role</option>";
                                }
                                unset($sth);
                            ?>
                        </select>
                        <input type="submit" class="input" />
                        </form>
                        <br />
                        <? if ($role != "") { ?>
                        <table border="0" cellspacing="1" cellpadding="1">
                          <tr>
                            <td width="150" bgcolor="#336666" class="table_title">Items</td>
                            <td width="150" bgcolor="#336666" class="table_title">Profile</td>
                          </tr>
                            <?
                                $sql = "SELECT T1.*, T2.* FROM ac_file AS T1
                                        LEFT JOIN ac_mm_role_file AS T2 ON T1.id = T2.file_id AND role_id = $role 
                                        ORDER BY T1.name_file ";
                                
                                //$result = mysql_query($sql); // OLD CONNECTION
                                
                                // PDO DB
                                $sth = $dbh->query($sql);
                                $sth->setFetchMode(PDO::FETCH_OBJ);
            
                                while($rs = $sth->fetch()) {
                                // while($rs = mysql_fetch_object($result)) { // OLD CONNECTION
                            
                            ?>
                          <tr>
                            <td class="table-cell-1">
                                <? 
                                    if ($rs->role_id == "") {
                                        echo "<a href='admin_profile_file_action.php?file_id=".encryptData(session_id(), $rs->id)."&action=add'>" . $rs->name_file . "</a>";
                                    }
                                ?>	</td>
                            <td class="table-cell-1">
                                <? 
                                    if ($rs->role_id != "") {
                                        echo "<a href='admin_profile_file_action.php?file_id=".encryptData(session_id(), $rs->id)."&action=remove'>" . $rs->name_file . "</a>";
                                    }
                                ?>	</td>
                          </tr>
                                <? 
                                } 
                                unset($sth);
                                ?>
                        </table>
                        <? } ?>
                
                
                
                <!-- END INTERNA -->

<?
// HTML Page End
htmlFooter();
?>