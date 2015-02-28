<?php 
$landingpage = "index";
include("header.php"); ?>
<?php if($_SESSION['uid'] == NULL || $_SESSION['uid'] == "") { ?>
<form id="loginfrm" name="loginfrm" action="functions.php" method="post">
<table width="100%" align="center" class="logintable">
<?php if($_REQUEST['error'] != NULL && $_REQUEST['error'] != "") { ?>
<tr><td colspan="2" align="right" style="color:red"><?php echo $_REQUEST['error']; ?></td></tr>
<?php } ?>
<tr><td colspan="2" align="center"><span id="title">Login</span></td></tr>
<tr><td align="right">E-Mail Address</td><td align="right"><input type="text" name="email" id="email"  style="width:auto" /></td></tr>
<tr><td align="right">Password</td><td align="right"><input type="password" name="password" id="password"  style="width:auto"/></td></tr>
<tr><td align="right" colspan="2"><input type="checkbox" name="isalive" id="isalive" />Keep Alive  <input type="hidden" id="login" name="login" value="Login" class="reset" />
<input type="hidden" id="returnurl" name="returnurl" value="<?php echo selfURL(); ?>" /><input type="image" name="loginbut" id="loginbut" value="Login" src="<?php echo BASEDIRLINK; ?>themes/<?php echo THEME; ?>/images/login.gif" alt="Login" style="background-color:transparent;" /></td></tr>
</table>
</form>
<?php } else {?>
<span style="font-size:9pt;">Logged-in.<br /><a href="functions.php?action=logout">Logout</a></span>
<? } ?>
<?php include("footer.php"); ?>