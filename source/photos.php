<?php 
$landingpage = "photos";
include("includes/header.php"); 
$albumid = $_REQUEST['album'];
$initialalbum = mysql_query("select * from albums where albumid='$albumid' and status='0'");
if(mysql_num_rows($initialalbum) > 0)
{
	$albumtype = mysql_result($initialalbum,0,"albumtypeid");
	$authcode = mysql_result($initialalbum,0,"authcode");
	$allow = true;
	switch($albumtype)
	{
		case "1":
		break;
		
		case "2":
		if(isset($_REQUEST['authcode']))
		{
			if($_REQUEST['authcode'] != $authcode)
				$allow = false;
		}
		else
			$allow = false;
		break;
		
		case "3":
		if(isset($_SESSION['uid']) && $_SESSION['uid'] != "")
		{
			$checkifaccess = mysql_query("select * from albumfriends where userid='".$_SESSION['uid']."' and albumid='$albumid'");
			if(mysql_num_rows($checkifaccess) <= 0)
				$allow = false;
		}
		else
			$allow = false;
		break;
	}
	if($allow == false && $_SESSION['isadmin'] != true)
	{
			echo "<span style='color:red; font-size:10pt;'>No Access</span>";
			include("includes/footer.php");
			die();
	}
	$setauthcode = "";
	if(isset($_REQUEST['authcode']))
		$setauthcode = "&authcode=".$_REQUEST['authcode'];
	?>
	<script type="text/javascript" src="<?php echo BASEDIR; ?>js/xmlHTTP.js" ></script>
	<table width="100%" cellspacing="15"><tr><td width="240" valign="top">
    <div class="titlediv"><div class="l"><div class="r"><div class="t">Thumbnails</div></div></div></div>
	<script type="text/javascript">
	document.write("<div id='displaythumbs' class='displaythumbs'></div>");
	thumbnailDiv = "displaythumbs";
	var albumid = <?php echo $_REQUEST['album']; ?>;
	getPage(1,albumid);
	</script>
	<noscript>
	<?php include("showthumbs.php"); ?>
	</noscript>
    <div class="titlediv"><div class="l"><div class="r"><div class="t">Album Options</div></div></div></div><br />
    <div style="margin:opx; padding:0px; padding-left:15px; font-size:9pt;"><a href="fullscreen.php?albumid=<?php echo $albumid; ?>"><img src="themes/<?php echo THEME; ?>/images/fullscreen.jpg" alt="" border="0" style="vertical-align:middle" />&nbsp;View fullscreen</a>&nbsp;&nbsp;<?php if(isset($_SESSION['uid']) && $_SESSION['uid'] != "") { ?><br/><a href="functions.php?action=downloadalbum&albumid=<?php echo $albumid.$setauthcode; ?>" target="_blank"><img src="themes/<?php echo THEME; ?>/images/archive.jpg" alt="" border="0" style="vertical-align:middle" />&nbsp;Download Album</a><?php } ?></div>
	<?php include("albuminfo.php"); ?>
	</td><td valign="top">
    <div class="titlediv"><div class="l"><div class="r"><div class="t">Photo View</div></div></div></div>
	<script type="text/javascript">
	document.write("<div id='displayphoto' class='displayphoto'>Please click on the thumbnails to see the enlarged view</div>");
	displayDiv = "displayphoto";
	<?php if(isset($_REQUEST['photo'])) { ?>
	var photoid = <?php echo $_REQUEST['photo']; ?>;
	initialshow = true;
	getPhoto(photoid);
	<?php } ?>
	</script>
	<noscript>
	<?php include("showphoto.php"); ?>
	</noscript>
	</td></tr></table>
	<img src="images/loader.gif" style="display:none" />
	<?php 
} else { ?>
<span style='color:red; font-size:10pt;'>Requested Album Not Available</span>
<?php }
include("includes/footer.php"); ?>
