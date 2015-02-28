<?php
include_once("config.php");
include_once("opendb.php");
?>

<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title><?php echo SITE_NAME; ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo BASEDIRLINK; ?>themes/<?php echo THEME; ?>/css/mobilemaster.css" />
</head>
<body>
<div class="bodywrap">
<table width="100%" height="250" cellpadding="0" cellspacing="0" align="center" class="index_back">
<tr>
	<td align="center" height="57" valign="top"><?php if($_SESSION['uid'] != NULL && $_SESSION['uid'] != "") { ?>
<div style="float:right; text-align:right; font-size:8pt"><a href="functions.php?action=logout">Logout</a></div>
<?php } ?>
<div id="logoDiv"><span>Angel D Suresh</span></div></td>
</tr>
<tr><td align="center" height="23" valign="top"><table cellpadding="0" cellspacing="0"><tr><td class="menu"><a href="<?php echo BASEDIR; ?>index.php">Home</a>-<a href="<?php echo BASEDIR; ?>about.php">About Me</a>-<a href="<?php echo BASEDIR; ?>gallery.php">Gallery</a>-<a href="<?php echo BASEDIR; ?>interest.php">Interests</a>-<a href="<?php echo BASEDIR; ?>blog.php">Blog</a></td></tr></table></td></tr>
<tr><td valign="top" height="137">