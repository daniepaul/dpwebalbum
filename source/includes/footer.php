</td></tr>
<tr><td valign="bottom" height="120">
<table width="100%"><tr><td align="left" valign="bottom">
<div style="float:left"><span class="copyrightC">&copy; <?php echo COPYRIGHTYEAR; ?></span><br /><span class="copyright"><?php echo COPYRIGHTNAME; ?></span></div>
</td><td align="right">
<?php if($_SESSION['uid'] == NULL || $_SESSION['uid'] == "") { ?>
<form id="loginfrm" name="loginfrm" action="functions.php" method="post">
<table width="300" align="right" class="logintable">
<?php if($_REQUEST['error'] != NULL && $_REQUEST['error'] != "") { ?>
<tr><td colspan="2" align="right" style="color:red"><?php echo $_REQUEST['error']; ?></td></tr>
<?php } ?>
<tr><td colspan="2" align="right"><span id="title">Login</span></td></tr>
<tr><td align="right">E-Mail Address</td><td align="right"><input type="text" name="email" id="email" /></td></tr>
<tr><td align="right">Password</td><td align="right"><input type="password" name="password" id="password" /></td></tr>
<tr><td align="right" colspan="2"><input type="checkbox" name="isalive" id="isalive" />Keep Alive&nbsp;&nbsp;<input type="hidden" id="login" name="login" value="Login" />
<input type="hidden" id="returnurl" name="returnurl" value="<?php echo selfURL(); ?>" /><input type="image" name="loginbut" id="loginbut" value="Login" src="themes/<?php echo THEME; ?>/images/login.gif" alt="Login" style="background-color:transparent;" /></td></tr>
</table>
</form>
<?php } ?>
</td></tr></table>
</td></tr></table>
</div>
</body>
</html>
<?php
//if($authenticate != "admin")
//$ppicture->protect();
?>
<?php
include("includes/closedb.php");
?>