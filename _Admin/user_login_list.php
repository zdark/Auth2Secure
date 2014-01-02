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
<?
// HTML ForceHTTPS and Chache
htmlForceHTTPS();
htmlCache();

// HTML Page Start
htmlHeader($settings[1], $settings_root_site, TRUE); //title, siteRootPath, menuShow

?>

		<!-- START INTERNA -->

        <?

        $id = sec_cleanTAGS($_GET["id"]);
        $id = sec_addESC($id);

        $id = sec_cleanTAGS(decryptData(session_id(), $id));

        ?>

        <div class="bloque">
        <p class="titles">Users Login List</p>
        <p class="itemsMenu001"></p>
        </div>

        <div class="centerbox">

        <table>
            <tr class="table_title">
                <td nowrap><b>User Name</b></td>
                <td nowrap><b>Remote Host</b></td>
                <td >Start Session</td>
                <td >Close Session</td>
            </tr>
        <?
        
        $sql = "SELECT * FROM users_audit WHERE user_id = $id ORDER BY id DESC";
        
        //$result = mysql_query($sql); // OLD CONNECTION

        // PDO DB
        $sth = $dbh->query($sql);
        $sth->setFetchMode(PDO::FETCH_OBJ);
        
        while($rs = $sth->fetch()) {
        //while($rs = mysql_fetch_object($result)) { // OLD CONNECTION
        ?>
            <tr class="table-cell-1">
                <td><? echo sec_cleanHTML($rs->username) ?></td>
                <td><? echo sec_cleanHTML($rs->remote_host) ?></td>
                <td ><? echo sec_cleanHTML($rs->start_session) ?></td>
                <td ><? echo sec_cleanHTML($rs->close_session) ?></td>
            </tr>
        <?
        }
        unset($sth);
        ?>
        </table>
        </div>
        
		<!-- END INTERNA -->

<?
// HTML Page End
htmlFooter();
?>