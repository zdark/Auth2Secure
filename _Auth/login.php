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
include $settings_root_folder . "_Auth/login_brute_force.php";
//include $settings_root_folder . "_Auth/sql_query.php";
?>
<?

$username = sec_cleanTAGS($_POST["username"]);
$username = sec_addESC($username);

$password = sec_cleanTAGS($_POST["password"]);
$password = sec_addESC($password);

//check that the user is calling the page from the login form and not accessing it directly
//and redirect back to the login form if necessary
if (!isset($username) || !isset($password)) {
	header( "Location: ".$settings_root_site."index.php" );
}
//check that the form fields are not empty, and redirect back to the login page if they are
elseif (empty($username) || empty($password)) {
	header( "Location: ".$settings_root_site."index.php" );

} else {

	$user = $username;
	$pass = md5($password);
	
	$sql = "select T1.*, T2.readonly  from users as T1
			LEFT JOIN ac_role AS T2 ON T2.id = T1.access_level
			where T1.username = '$user' AND T1.password = '$pass' ";
	
	//$result = mysql_query($sql); // OLD CONNECTION
	//error_handler_sql($result); // OLD CONNECTION
	
	//check that at least one row was returned

    //$rowCheck = mysql_num_rows($result); // OLD CONNECTION    
    
    $sql = "select count(*) as num from users as T1
        LEFT JOIN ac_role AS T2 ON T2.id = T1.access_level
        where T1.username = '$user' AND T1.password = '$pass' ";
    
    // PDO DB
    $sth = $dbh->query($sql);
    $sth->setFetchMode(PDO::FETCH_OBJ);
	//$rowCheck = $sth->rowCount();
    $rowCheck = $sth->fetch()->num;
        
	if($rowCheck > 0){
		
        $sql = "select T1.*, T2.readonly  from users as T1
			LEFT JOIN ac_role AS T2 ON T2.id = T1.access_level
			where T1.username = '$user' AND T1.password = '$pass' ";
                
        // PDO DB
        $sth = $dbh->query($sql);
        $sth->setFetchMode(PDO::FETCH_OBJ);
        
        while($row = $sth->fetch()) {
		//while($row = mysql_fetch_object($result)){ // OLD DB WHILE

			//start the session and register a variable

			session_start();
			session_regenerate_id();
			
			// SECURE SESSION COOKIE
			$currentCookieParams = session_get_cookie_params();  
			$sidvalue = session_id();  
			setcookie(  
				'PHPSESSID',//name  
				$sidvalue,//value  
				0,//expires at end of session  
				$currentCookieParams['path'],//path  
				$currentCookieParams['domain'],//domain  
				true, //secure
				true //HttpOnly 
			);  
			
			$_SESSION["username"] = $user;
			$_SESSION["id_user"] = $row->id;
			$_SESSION["access_level"] = $row->access_level;
			$_SESSION['time'] = time(); // session expire
			$_SESSION['readonly'] = $row->readonly; 
			
			// LAST LOGIN
			$sql = "select start_session from users_audit WHERE user_id = " .$row->id . " ORDER BY id DESC LIMIT 1";
			//$result = mysql_query($sql); // OLD CONNECTION
			//$rsLast = mysql_fetch_object($result); // OLD CONNECTION
            
            // PDO DB
            $sth = $dbh->query($sql);
            $sth->setFetchMode(PDO::FETCH_OBJ);
            $rsLast = $sth->fetch();
            
			$_SESSION["last_login"] = $rsLast->start_session;
			
			// ------- RAC ------------------>
			// Asigna los permisos a la variable SESSION->RAC
			$sql = "SELECT item_id FROM ac_mm_role_item WHERE role_id = ". $row->access_level;
			//$result = mysql_query($sql); // OLD CONNECTION
			//error_handler_sql($result); // OLD CONNECTION
            
            // PDO DB
            $sth = $dbh->query($sql);
            $sth->setFetchMode(PDO::FETCH_OBJ);

			while($rs_rac = $sth->fetch()) {
			//while($rs_rac = mysql_fetch_object($result)) { // OLD DB WHILE
				$_SESSION["rac"][] = $rs_rac->item_id;
			}
			// ------- RAC END -------------->
			
			// WEEK
			
			if (date('w') == 1) {
				$_SESSION["cookie_week"] = date("Y-m-d", strtotime( "today" ));
			} else {
				$_SESSION["cookie_week"] = date("Y-m-d", strtotime( "previous monday" ));
			}
			
			// INSERT users_audit
			$fecha = date("Y-m-d H:i:s");
			
			if ( isset($_SERVER['HTTP_X_FORWARDED_FOR'] )) { 
			$ip_real = $_SERVER['HTTP_X_FORWARDED_FOR']; 
			} 
			elseif ( isset($_SERVER['HTTP_CLIENT_IP'] )) { 
			$ip_real = $_SERVER['HTTP_CLIENT_IP']; 
			} 
			else { 
			$ip_real = $_SERVER['REMOTE_ADDR']; 
			} 
			
			$session_id = session_id();
			
			$user_id = $row->id;
			
			$sql = "INSERT INTO users_audit (user_id, username,remote_host,start_session,session_id) VALUES ('$user_id', '$user','$ip_real','$fecha','$session_id')";
			//$conn = mysql_query($sql); // OLD CONNECTION
			//error_handler_sql($conn); // OLD CONNECTION
			//$dbh->exec($sql);
            $sth = $dbh->query($sql);
            
			$sql = "UPDATE users SET session_id = '$session_id', remote_host = '$ip_real' WHERE id = $user_id"; 
			//$conn = mysql_query($sql); // OLD CONNECTION
			//error_handler_sql($conn); // OLD CONNECTION
			//$dbh->exec($sql);
            $sth = $dbh->query($sql);
                        
			//we will redirect the user to another page where we will make sure they're logged in
			$attempt = 'success';
			include $settings_root_folder . "_Auth/login_brute_force.php";
			            
			if ($_SESSION["access_level"] == 1 or $_SESSION["access_level"] == 7) {
				header( "Location: ".$settings_root_site."home.php" );
			} else if ($_SESSION["access_level"] == 9 or $_SESSION["access_level"] == 10 or $_SESSION["access_level"] == 11) {
				header( "Location: ".$settings_root_site."home.php" );
			} else {
                header( "Location: ".$settings_root_site."home.php" );
			}
			
		}

	}	else {

		//if nothing is returned by the query, unsuccessful login code goes here...
		//echo 'Incorrect login name or password. Please try again.';
		$attempt = 'fail';
		include $settings_root_folder . "_Auth/login_brute_force.php";
		header( "Location: ".$settings_root_site."index.php?error=1" );
	}
}
  ?> 
