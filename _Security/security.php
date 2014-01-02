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

# [Muestra los tags HTML sin ejecutarlos.] 
function sec_cleanHTML ($var) {
	$var = str_replace("'", "", $var);
	return htmlentities($var);
	//return htmlspecialchars($str);
}

# [Quita todos los tags HTML y PHP de la variable.] 
function sec_cleanTAGS ($var) {
	$var = strip_tags($var);
	$var = str_replace("'", "", $var);
	$var = str_replace("\"", "", $var);
	$var = str_replace(";", "", $var);
	//return htmlentities($var);
	return strip_tags($var);
}


# [Agrega escape de caracteres especiales SQL -> \' ]
function sec_addESC($var) {

    $var = mysql_real_escape_string($var);

    return $var;

}

function regex_autocomplete($var) {

    $regex = "/(?i)(^[a-z0-9\-\_\.\+, ]{1,20}$)|(^$)/";
	
    if (preg_match($regex, $var) == 0) {
	exit;
    }

	return $var;
}

# [Verifica characteres -> [a-z0-9] ]
function regex_standard($var) {

    $regex = "/(?i)(^[a-z0-9\-\_\.\+, ]{1,20}$)|(^$)/";

    $referer = $_SERVER['HTTP_REFERER'];
    //echo $referer."<br>";
    if (preg_match($regex, $var) == 0) {
	header("Location: ".$referer."?error=1");
	exit;
    }

}

# [Verifica numbers -> [0-9] ]
function regex_numbers($var) {

    $regex = "/(?i)(^[0-9 ]{1,20}$)|(^$)/";

    $referer = $_SERVER['HTTP_REFERER'];

    if (preg_match($regex, $var) == 0) {
	header("Location: ".$referer."&error=1");
	exit;
    }

}

# [Verifica where -> [a-b0-9 \[\]\%] ]
function regex_where($var) {

    $regex = "/(?i)(^[a-z0-9 \[\]\(\)\%\=\.]{1,}$)/";

    $referer = $_SERVER['HTTP_REFERER'];
    //echo $var;
    if (preg_match($regex, $var) == 0) {
	header("Location: ".$referer."&error=1");
	exit;
    }

}

# [Verifica regex -> [a-b0-9 \[\]\%] ]
function regex_regex($var) {

    $regex = "/(?i)(^[a-z0-9 \[\]\(\)\%\=\|\.]{1,}$)|(^$)/";

    $referer = $_SERVER['HTTP_REFERER'];
    //echo $var;
    if (preg_match($regex, $var) == 0) {
	header("Location: ".$referer."&error=1");
	exit;
    }

}

# [Verifica email -> [a-b0-9\@\.\-\_] ]
function regex_email($var) {

    $regex = "/(?i)(^[a-z0-9\@\.\-\_,]{1,}$)|(^$)/";

    $referer = $_SERVER['HTTP_REFERER'];
    //echo $var;
    if (preg_match($regex, $var) == 0) {
	header("Location: ".$referer."&error=1");
	exit;
    }

}

# Muestra error de INPUT
function show_error() {

    if ($_GET["error"] == 1) {
	echo "<b>Bad Input...</b><br><br>";
    }
}

# Verifica que la tabla log_ exista
function table_exists($tabla) {

    $sql = "show tables like 'log_".$tabla."'";
    $result = mysql_query($sql);
    return mysql_num_rows($result);

}

# Verifica permiso asignado al ROLE
function rac_verify($rac) {

	if (in_array( $rac, $_SESSION["rac"] )) {
		return True;
	} else {
		return False;
	}

}

# ERROR HANDLER SQL
function error_handler_sql($result) {
    
    include "settings.php";

    if (!$result) {
		echo "<img src='icons/error.jpg' border=0>";
		echo "<script>window.location = '".$settings_root_site."msg.php?msg=3';</script>";
		die(' *ERROR* ');
		exit;
	}

}

function sec_numeric($var) {

    include "settings.php";

    if (is_numeric($var) or $var == "") {
		return $var;
	} else {
		//return 0;
		//header("Location: msg.php?msg=3");
		echo "<script>window.location = '".$settings_root_site."msg.php?msg=3';</script>";
		die(' *ERROR NUM* ');
		exit;
	}

}

?>
