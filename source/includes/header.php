<?php
include_once("config.php");
//if($authenticate != "admin")
//{
//require_once("class_protect_picture.php");
//$ppicture = new protect_picture(session_id());
//}
include_once("includes/opendb.php");
if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
	if(isset($_COOKIE['cookieeemail']) && isset($_COOKIE['cookieepassword']))
	{
		$email = $_COOKIE['cookieeemail'];
		$password = base64_decode($_COOKIE['cookieepassword']);
		$isalive = "on";
		cookieelogin($email,$password,$isalive);
	}
}
?>
<html>
<head>
<title><?php echo SITE_NAME; ?></title>
<meta name="description" content="<?php echo DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo KEYWORDS; ?>" />
<meta name="author" content="<?php echo AUTHOR; ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo BASEDIR; ?>themes/<?php echo THEME; ?>/css/master.css" media="screen" />
<!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="<?php echo BASEDIR; ?>themes/<?php echo THEME; ?>/css/ie-master.css" media="screen" />
<![endif]-->
<?php if($landingpage == "uploadphotos") { ?><link type="text/css" href="<?php echo BASEDIR; ?>css/uploadify.css" rel="stylesheet" /><?php } ?>
<?php if($landingpage == "sharealbum") { ?><link type="text/css" href="<?php echo BASEDIR; ?>css/token-input.css" rel="stylesheet" /><?php } ?>
<?php if($landingpage == "cropphoto") { ?><link rel="stylesheet" href="<?php echo BASEDIR; ?>css/jquery.Jcrop.css" type="text/css" /><?php } ?>
<?php if($landingpage == "photos") { ?>
<script type="text/javascript">
if(document.URL.indexOf("#") > -1)
{
	spliter = document.URL.split("#");
	var url = spliter[0]+"&";
	if(spliter[0].indexOf("photo=") > -1)
	{
		l = spliter[0].split("photo=");
		url = l[0];
	}
	url += spliter[1];
	window.location = url;
}
</script>
<?php if(GOOGLEMAPS == "true") { ?>
    <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=<?php echo GOOGLEMAPSAPIKEY; ?>" type="text/javascript"></script> 
<?php } ?>
<?php } ?>
</head>
<body  <?php if($landingpage == "photos") { ?>onunload="GUnload()"<?php } ?>>
<div class="bodywrap">
<table width="900" height="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="index_back">
<tr><td valign="top" align="center" height="113">
<?php if($_SESSION['name'] != NULL && $_SESSION['name'] != "") { ?>
<div style="float:right; text-align:right; line-height:200%" class="welcomemsg"><?php if($_SESSION['isadmin']=="true") { ?><a href="admin_index.php">Admin Menu</a> | <?php }?>Welcome <b><?php echo $_SESSION['name']; ?></b> | <a href="functions.php?action=logout">Logout</a><br/><a href="changepassword.php">Change Password</a> | <a href="editprofile.php">Edit Profile</a></div>
<?php } ?>
<div id="logoDiv"><span>AngelegnA</span></div>
</td></tr>
<tr><td valign="top" height="50" align="center">
<!--############### MENU ###############-->
<?php if($landingpage != "index") { ?><div align="center" style="width:900px">
<ul class="menu">
<li id="home"><a href="<?php echo BASEDIR; ?>index.php"><div><span>Home</span></div></a></li>
<li id="about"><a href="<?php echo BASEDIR; ?>about.php"><div><span>About Me</span></div></a></li>
<li id="gallery"><a href="<?php echo BASEDIR; ?>gallery.php"><div><span>Gallery</span></div></a></li>
<li id="interest"><a href="<?php echo BASEDIR; ?>interest.php"><div><span>Interests</span></div></a></li>
<li id="guestbook"><a href="<?php echo BASEDIR; ?>blog.php"><div><span>Blog</span></div></a></li>
</ul></div>
<?php } ?>
<?php if($authenticate == "admin" && $_SESSION['isadmin']=="true") { ?>
<div align="center" style="width:800px; margin:0px">
<ul class="menu" style="padding:0px;">
<li style="padding-left:10px"><a href="<?php echo BASEDIR; ?>createalbum.php"><div><span>Create New Album</span></div></a></li>
<li style="padding-left:10px"><a href="<?php echo BASEDIR; ?>manageusers.php"><div><span>Manage Users</span></div></a></li>
<li style="padding-left:10px"><a href="<?php echo BASEDIR; ?>managepages.php"><div><span>Manage Pages</span></div></a></li>
<li style="padding-left:10px"><a href="<?php echo BASEDIR; ?>managealbums.php"><div><span>Manage Albums</span></div></a></li>
</ul></div>
<?php } ?>
</td></tr>
<tr><td valign="top">
<?php include("includes/checkadmin.php"); ?>