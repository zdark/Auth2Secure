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

htmlHeader($settings[1] . " [Logs]", $settings_root_site, TRUE); //title, siteRootPath, menuShow

?>

                <!-- START INTERNA -->
              
              <div align="center" valign="top">
              
              <?
            $page_name="logs.php"; //  If you use this code with a different page ( or file ) name then change this 
            $start = sec_cleanTAGS($_GET['start']);
            if(strlen($start) > 0 and !is_numeric($start)) {
                echo "Data Error";
                exit;
            }
                
            $eu = ($start - 0); 
            $limit = 50;                                 // No of records to be shown per page.
            $this1 = $eu + $limit; 
            $back = $eu - $limit; 
            $next = $eu + $limit; 
            
            
            /////////////// WE have to find out the number of records in our table. We will use this to break the pages///////
            $sql=" SELECT * from audit_logs ";
            
            //$result2=mysql_query($sql2); // OLD CONNECTION
            //error_handler_sql($result2); // OLD CONNECTION
            //$nume=mysql_num_rows($result2); // OLD CONNECTION
            
            $sql=" SELECT count(*) AS num from audit_logs ";
            
            // PDO DB
            $sth = $dbh->query($sql);
            $sth->setFetchMode(PDO::FETCH_OBJ);
            //$rs = $sth->fetch();
            //$nume = $sth->rowCount();
            $nume = $sth->fetch()->num;
            unset($sth);
            
            /////// The variable nume above will store the total number of records in the table////
        ?>
        
              <table width="1000px" border="0" cellpadding="1" cellspacing="1">
                <tr>
                  <td><?

            if($nume > $limit ){ // Let us display bottom links if sufficient records are there for paging
            
            /////////////// Start the bottom links with Prev and next link with page numbers /////////////////
            echo "<table align = 'left' ><tr><td  align='left' valign='top'  width='40'>";
            //// if our variable $back is equal to 0 or more then only we will display the link to move back ////////
            if($back >=0) { 
                print "<a href='$page_name?start=$back'><font face='Verdana' size='1'>PREV</font></a>"; 
            } 
            //////////////// Let us display the page links at  center. We will not display the current page as a link ///////////
            echo "</td><td align=center >";
            $i=0;
            $l=1;
            for($i=0;$i < $nume;$i=$i+$limit){
            
                if($i <> $eu){
                    echo " <a href='$page_name?start=$i'><font face='Verdana' size='1'>$l</font></a> ";
                } else { 
                    echo "<font face='Verdana' size='1' color=red>$l</font>";
                }        /// Current page is not displayed as link and given font color red
                    $l=$l+1;
                }
                
                echo "</td><td  align='center' valign='top' width='40'>";
                ///////////// If we are not in the last page then Next link will be displayed. Here we check that /////
                if($this1 < $nume) { 
                    print "<a href='$page_name?start=$next'><font face='Verdana' size='1'>NEXT</font></a>";
                } 
                echo "</td></tr></table>";
            
            }
            
            // end of if checking sufficient records are there to display bottom navigational link. 	
            
        ?>
                      <br />
                    <br />
                  </td>
                </tr>
                <tr>
                  <td>.</td>
                </tr>
                <table width="100%" border="0" cellpadding="1" cellspacing="1">
                  <tr>
                    <td class="table_title" width="60" bgcolor="#336666" ><span class="style3">Date</span></td>
                    <td class="table_title" width="60" nowrap="nowrap" bgcolor="#336666"><span class="style3"> User </span></td>
                    <td class="table_title" width="100" nowrap="nowrap" bgcolor="#336666"><span class="style3">URL</span></td>
                    <td class="table_title" width="40" bgcolor="#336666"><span class="style3">Method </span></td>
                    <td class="table_title" width="200" bgcolor="#336666"><span class="style3">REQUEST </span></td>
                  </tr>
                  <?
            $sql = "SELECT * FROM audit_logs ORDER by id DESC limit $eu, $limit ";
            //$results = mysql_query($sql); // OLD CONNECTION
            
            // PDO DB
            $sth = $dbh->query($sql);
            $sth->setFetchMode(PDO::FETCH_OBJ);
            
            while ($rs = $sth->fetch()) {
            //while ($rs = mysql_fetch_object($results)) { // OLD CONNECTION
            
        ?>
                  <tr>
                    <td nowrap="nowrap" class="table-cell-1"><?=sec_cleanHTML($rs->log_date)?></td>
                    <td class="table-cell-1"><b>
                      <?=sec_cleanHTML($rs->user)?>
                    </b></td>
                    <td class="table-cell-1"><b>
                      <?=sec_cleanHTML($rs->url)?>
                    </b></td>
                    <td class="table-cell-1"><b>
                      <?=sec_cleanHTML(str_replace("&"," &",$rs->method))?>
                    </b></td>
                    <td class="table-cell-1"><b>
                      <?=sec_cleanHTML(str_replace("&"," &",$rs->params_request))?>
                    </b></td>
                  </tr>
            <? 
            } 
            unset($sth);
            ?>
                </table>
                <tr>
                  <td></td>
                
                <tr>
                  <td></tr>
              </table>
            </div>
            
             <!-- END INTERNA -->
            
<?
htmlFooter();
?>