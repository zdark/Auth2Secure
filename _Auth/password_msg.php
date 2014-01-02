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
<? include "verify.php" ?>
<? include "password_policy.php" ?>
<? include "security.php" ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MSG</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table class="table-bk" ><tr><td align="center" valign="top"> <!-- TABLE BK -->

<!-- TABLE CONTENT -->

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td style="padding:10px" align="left">
	<img src="icons/hsbc_logo.jpg"/><img src="icons/isr_label.jpg"/></td>
  </tr>
  <tr>
    <td class="menu_back"><? include_once "menu-ajax.php"; ?></td>
  </tr>
  <tr>
    <td style="padding:10px" height="400px" align="center" class="titles">

		<!-- START INTERNA -->
		
		<?
			$msg = sec_cleanHTML($_GET["msg"]);
			if ($msg == 1) {
				echo "Your password has been changed";
			} else if ($msg == 2) {
				echo "Password error, please try again";
			}
		?>
		
		<!-- END INTERNA -->
	</td>
  </tr>
  <tr>
    <td style="padding:10px">&nbsp;</td>
  </tr>
</table>

<!-- END TABLE CONTENT -->

</td></tr></table> <!-- END TABLE BK -->


</body>
</html>
