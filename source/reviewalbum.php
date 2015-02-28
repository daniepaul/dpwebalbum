<?php 
$landingpage = "reviewalbum";
$authenticate = "admin";
include("includes/header.php"); 
if(isset($_REQUEST['albumid']))
{
$albumid = $_REQUEST['albumid'];
$albumresult = mysql_query("select * from albums where albumid='$albumid'");
if(mysql_num_rows($albumresult) > 0) {
?>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/reviewalbum.js" ></script>
<span class="title">Review Album</span><br />
<span class="subtitle">Album Name: <b><?php echo mysql_result($albumresult,0,"albumname"); ?></b></span><br /><br />
<div class="addform">
<div style="float:right"><a href="uploadphotos.php?albumid=<?php echo $albumid; ?>"><img src="images/add.gif" alt="" border="0" style="vertical-align:middle" />&nbsp;Add More Photos</a></div>
Review the album by adding captions and editing the photos.<br /><br />
<?php if(isset($_REQUEST['errormsg'])) { ?><span style="color:red"><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
<div id="reviewalbum">
<?php include("reviewphotos.php"); ?>
</div>
<a href="photos.php?album=<?php echo $albumid; ?>"><img src="images/view.gif" border="0" alt="" style="vertical-align:middle" /> View the album</a><div style="float:right"><a href="share.php?albumid=<?php echo $albumid; ?>"><img src="images/invite.gif" border="0" alt="" style="vertical-align:middle" /> Share the album</a></div>
</div>
<?php } else { ?>
Error loading the page.
<?php 
}}
else
{
?>
<img src="images/loader.gif" style="display:none" />
Error loading the page.
<?php }
include("includes/footer.php"); ?>
