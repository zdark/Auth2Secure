<? include_once "verify.php"; ?>
<? include_once "security.php"; ?>
<? include_once "settings.php"; ?>
<? include_once "functions.php"; ?>

<span style="vertical-align: middle">
<img src='icons/user-icon.png' alt='tasks' title='<?="Last Login: " . sec_cleanHTML($_SESSION["last_login"]); ?>' width='18' height='18' border='0' />
</span>

<span>
<?=sec_cleanHTML($_SESSION["username"])?>
<? //=" [ ".sec_cleanHTML($_SESSION["username"])." ] " ?>
</span>
