<?php 
$landingpage = "errorpage";
include_once("config.php");
?>
<html>
<head>
<title><?php echo SITE_NAME; ?></title>
<meta name="description" content="<?php echo DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo KEYWORDS; ?>" />
<meta name="author" content="<?php echo AUTHOR; ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo BASEDIR; ?>css/master.css" media="screen" />
<!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="<?php echo BASEDIR; ?>css/ie-master.css" media="screen" />
<![endif]-->
</head>
<body>
<table width="900" height="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="index_back">
<tr><td valign="top" align="center" height="122">
<?php if($_SESSION['name'] != NULL && $_SESSION['name'] != "") { ?>
<div style="float:right; text-align:right; line-height:200%" class="welcomemsg"><?php if($_SESSION['isadmin']=="true") { ?><a href="admin_index.php">Admin Menu</a> | <?php }?>Welcome <b><?php echo $_SESSION['name']; ?></b> | <a href="functions.php?action=logout">Logout</a><br/><a href="changepassword.php">Change Password</a> | <a href="editprofile.php">Edit Profile</a></div>
<?php } ?>
<div id="logoDiv"><span>AngelegnA</span></div>
</td></tr>
<tr><td valign="middle" height="<?php if($landingpage == "index") { ?>350<?php } else { ?>50<?php } ?>" align="center">
<!--############### MENU ###############--><div align="center" style="width:800px">
<ul class="<?php if($landingpage == "index") { ?>indexmenu<?php } else { ?>menu<?php } ?>">
	<li id="home"><a href="<?php echo BASEDIR; ?>index.php"><div><span>Home</span></div></a></li>
<li id="about"><a href="<?php echo BASEDIR; ?>about.php"><div><span>About Me</span></div></a></li>
<li id="gallery"><a href="<?php echo BASEDIR; ?>gallery.php"><div><span>Gallery</span></div></a></li>
<li id="interest"><a href="<?php echo BASEDIR; ?>interest.php"><div><span>Interests</span></div></a></li>
<li id="guestbook"><a href="<?php echo BASEDIR; ?>blog.php"><div><span>Blog</span></div></a></li>
</ul></div>
</td></tr>
<tr><td valign="top">
<div class="addform">
<h1>Internal Server Error</h1>

<p>Some error occured during processing. Please check the settings.</p>
</div>
</td></tr>
<tr><td valign="bottom">
<table width="100%"><tr><td align="left" valign="bottom">
<div style="float:left"><span class="copyrightC">&copy; 2009</span><br /><span class="copyright">www.angelegna.com</span></div>
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
<input type="hidden" id="returnurl" name="returnurl" value="<?php echo selfURL(); ?>" /><input type="image" name="loginbut" id="loginbut" value="Login" src="<?php echo IMAGEPATH; ?>login.jpg" alt="Login" /></td></tr>
</table>
</form>
<?php } ?>
</td></tr></table>
</td></tr></table>
</body>
</html>
