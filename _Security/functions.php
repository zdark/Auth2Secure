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
function createRandomPassword() { 

    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    while ($i <= 7) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    return $pass; 

} 

function encryptData ($key, $string) {

	//$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
	$encrypted = base64url_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
	return $encrypted;
}

function decryptData ($key, $encrypted) {

	//$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64url_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	return $decrypted;

}

function base64url_encode($data) { 
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
} 

function base64url_decode($data) { 
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
}


function htmlForceHTTPS () {
    if ($_SERVER['SERVER_PORT']!=443) {
        $url = "https://". $_SERVER['SERVER_NAME'] . ":443".$_SERVER['REQUEST_URI'];
        header("Location: $url");
    }
}

function htmlCache () {
    header( 'Pragma: no-cache' );
    header( 'Cache-Control: no-store, no-cache, must-revalidate, post-check=3600, pre-check=3600' );
}

function htmlForceLocation() {
    echo ('
            <script>
            if (top != self) {
              top.location = self.location;
            }
            </script>
        ');
}

function htmlHeader($title, $settings_root_site, $menuShow) {
        
    echo ('
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html>
        <header>
        <title>'.$title.'</title>
        </header>
        <body>

        <link href="'.$settings_root_site.'style.css" rel="stylesheet" type="text/css">

        <table class="table-bk" >
            <tr>
                <td align="center" valign="top"> <!-- TABLE BK -->

                <!-- TABLE CONTENT -->
                
                <table border="0" align="center" cellpadding="0" cellspacing="0" class="table-bk-structure">
                  <tr>
                    <td height="50px" style="padding:14px" align="left"></td>
                  </tr>
                  <tr>
                    <td class="menu_back" height="10px">
            ');
    
    if ($menuShow == TRUE) {
        include $_SERVER["DOCUMENT_ROOT"] . $settings_root_site . "menu.php";
    }
    
    echo ('
                    </td>
                  </tr>
                  <tr>
                    <td class="table-bk-content" align="left">
                
                        <!-- START INTERNA -->				
		');
        
    //include "menu.php";

}

function htmlFooter() {

    echo ('
                            <!-- END INTERNA -->
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:10px" height="10px">&nbsp;</td>
                  </tr>
                </table>
                
                <!-- END TABLE CONTENT -->
                
                </td>
            </tr>
        </table>
        
        </body>
        </html>
            ');

}

?>
