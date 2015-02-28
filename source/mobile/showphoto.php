<?php
$columns = 5;
$rows = 1;
$where = "";

if(isset($_REQUEST['photo']))
{
$photoid = $_REQUEST['photo'];
$sqlphoto = "select * from photos where photoid='$photoid' and status='0'";
$resultphoto = mysql_query($sqlphoto);
if(mysql_num_rows($resultphoto) > 0)
{
	$previous_photo = true;
	$next_photo = true;
	$albumstatus = mysql_query("select photoid from photos where albumid='".mysql_result($resultphoto,0,"albumid")."' and status='0' order by `order`,`photoid`");
	if(mysql_result($albumstatus,0,"photoid") == $photoid)
	{
		$previous_photo = false;
	}
	if(mysql_result($albumstatus,(mysql_num_rows($albumstatus)-1),"photoid") == $photoid)
	{
		$next_photo = false;
	}
	$i = 0;
	for($i = 0; $i < mysql_num_rows($albumstatus); $i++)
	{
		if(mysql_result($albumstatus,$i,"photoid") == $photoid)
		 break;
	}
	
?>
<table cellpadding="5" cellspacing="0" class="phototable" align="center" width="100%" style="font-size:8pt;">
<tr><td align="left"><?php if($previous_photo) { ?>
<a onclick="getPhoto('<?php echo mysql_result($albumstatus,($i-1),"photoid"); ?>'); return false;" href="photos.php?album=<?php echo mysql_result($resultphoto,0,"albumid");?>&photo=<?php echo mysql_result($albumstatus,($i-1),"photoid"); ?>#showphoto"><img src="<?php echo BASEDIRLINK; ?>themes/<?php echo THEME; ?>/images/previous.jpg" alt="" border="0" style="vertical-align:middle" class="profile" width="15" /> Previous</a> <?php } ?><a name="showphoto"> </a>
</td><td align="right"><?php if($next_photo) { ?>
<a onclick="getPhoto('<?php echo mysql_result($albumstatus,($i+1),"photoid"); ?>'); return false;" href="photos.php?album=<?php echo mysql_result($resultphoto,0,"albumid");?>&photo=<?php echo mysql_result($albumstatus,($i+1),"photoid"); ?>#showphoto">Next <img src="<?php echo BASEDIRLINK; ?>themes/<?php echo THEME; ?>/images/next.jpg" alt="" border="0" style="vertical-align:middle" class="profile" width="15"  /></a><?php } ?>
</td></tr>
<tr><td align="center" colspan="2">
<img src="<?php echo BASEDIRLINK; ?>photos/medium/<?php echo mysql_result($resultphoto,0,"filename"); ?>" alt="" border="0" width="200"/>
</td></tr>
<tr><td align="center" colspan="2">
<?php echo html_entity_decode(mysql_result($resultphoto,0,"caption")); ?>
</td></tr>
<tr><td colspan="2"><div class="titlediv"><div class="l"><div class="r"><div class="t">Friends Comments</div></div></div></div></td></tr>
<?php } ?>
<?php 
$sqlcomments = "select a.*,(select name from users where uid=a.uid)name,(select photo from users where uid=a.uid)photo from comments as a where a.photoid='$photoid' and a.status='0'";
$resultcomments = mysql_query($sqlcomments);
if(mysql_num_rows($resultcomments) > 0)
{
	while($rowcomment = mysql_fetch_assoc($resultcomments))
	{ ?>
	<tr><td width="75" align="center" style="font-size:8pt;border-bottom:1px dashed #666666"><img src="<?php echo BASEDIRLINK; ?>userphotos/<?php echo $rowcomment["photo"]; ?>" alt="" class="profile" height="40"/><br /><?php echo nl2br(substr(html_entity_decode($rowcomment["name"]),0,10)); ?></td><td valign="top" style="border-bottom:1px dashed #666666"><?php echo nl2br(html_entity_decode($rowcomment["comment"])); ?></td></tr>
	<?php }
}
else
{
?>
<tr><td colspan="2">No comments added yet.</td></tr>
<?php } ?>
<tr><td colspan="2"><br /><div class="titlediv"><div class="l"><div class="r"><div class="t">Add Comment</div></div></div></div></td></tr>
<?php if(isset($_SESSION['uid']) && $_SESSION['uid'] != "") { ?>
<tr><td width="75" align="center"><?php echo substr($_SESSION['name'],0,10); ?></td><td valign="middle" id="addcommentdiv">
<?php if(!isset($_REQUEST['rand'])) { ?><form id="commentfrm" name="commentfrm" action="addcomment.php" method="post"><?php } ?>
<input type="hidden" id="photoid" name="photoid" value="<?php echo $photoid; ?>" />
<input type="hidden" id="returnurl" name="returnurl" value="<?php echo selfURL();?>" />
<textarea name="commenttext" id="commenttext" rows="2" cols="15"></textarea><br /><input type="submit" name="postcomment" id="postcomment" value="Post" style="width:60px" />
<?php if(!isset($_REQUEST['rand'])) { ?></form><?php } ?></td></tr>
<?php } else {?>
<tr><td colspan="2">Please Login to post your comments.</td></tr>
<?php } ?>
</table>
<?php } else { ?>
Please click on the thumbnails to see the enlarged view

<?php }
?>