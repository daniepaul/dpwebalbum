<?php 
$landingpage = "photos";
include("header.php"); 
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
	<table width="100%"><tr><td valign="top"><div class="titlediv"><div class="l"><div class="r"><div class="t">Thumbnails</div></div></div></div>
	<?php include("showthumbs.php"); ?>
	</td></tr><tr><td valign="top">
    <div class="titlediv"><div class="l"><div class="r"><div class="t">Photo View</div></div></div></div>
	<?php include("showphoto.php"); ?>
	</td></tr></table>
	<?php 
} else { ?>
<span style='color:red; font-size:10pt;'>Requested Album Not Available</span>
<?php }
include("footer.php"); ?>
