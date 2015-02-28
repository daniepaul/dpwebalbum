<?php
if(isset($_REQUEST['rand']))
{
include_once("config.php");
include_once("includes/opendb.php");
}

include("lib/uploadfunctions.php");
if (isset($_REQUEST['file']) && isset($_REQUEST['angle'])) {
$file = $_REQUEST['file'];
$angle = $_REQUEST['angle'];
	$targetFile =  "photos/original/" .$file;
	$downloadpath = "photos/download/".$file;
	$thumbpath = "photos/thumbnails/".$file;
	$mediumpath = "photos/medium/".$file;
rotate_image($targetFile,$angle);
smart_resize_image($targetFile,1600,0,true,'file',false,false,$downloadpath,false);
smart_resize_image($downloadpath,600,0,true,'file',false,false,$mediumpath,false);
smart_resize_image($mediumpath,50,0,true,'file',false,false,$thumbpath,true);
?>

<?php 
$random = rand(0,time());
$reviewresult = mysql_query("select * from photos where filename='$file' and status='0'"); 
if(mysql_num_rows($reviewresult) > 0)
{
	while($rowreview = mysql_fetch_assoc($reviewresult))
	{
	?>
	<div><img src="photos/medium/<?php echo $rowreview['filename']; ?>?rand=<?php echo $random; ?>" alt=""/></div>
    <img src="images/rc.gif" alt="Rotate Clockwise" title="Rotate Clockwise" border="0" class="reset" id="rc-<?php echo $rowreview['photoid']; ?>" onClick="rotate('<?php echo $rowreview['filename']; ?>','270','r-<?php echo $rowreview['photoid']; ?>')"/>&nbsp;&nbsp;&nbsp;<img src="images/rcc.gif" alt="Rotate Counter-Clockwise" title="Rotate Counter-Clockwise" border="0" class="reset" onClick="rotate('<?php echo $rowreview['filename']; ?>','90','r-<?php echo $rowreview['photoid']; ?>')"/>&nbsp;&nbsp;&nbsp;<img src="images/delete.gif" alt="Delete Photo" title="Delete Photo" border="0" class="reset"/>&nbsp;&nbsp;&nbsp;<a href="reviewalbum.php?albumid=<?php echo $_REQUEST['albumid']; ?>&setcover=<?php echo $rowreview['filename']; ?>"><img src="images/cover_g.gif" alt="Set as cover" title="Set as cover" border="0" class="reset" /></a><br/>
    <input type="hidden" name="p-<?php echo $rowreview['photoid']; ?>" id="photoid[]" value="<?php echo $rowreview['photoid']; ?>" /><textarea id="c-<?php echo $rowreview['photoid']; ?>" name="caption[]" cols="50" rows="4" onchange="savecaption('<?php echo $rowreview['photoid']; ?>',this.id,'status-<?php echo $rowreview['photoid']; ?>')"><?php echo $rowreview['caption']; ?></textarea><div id="status-<?php echo $rowreview['photoid']; ?>" style="float:right; vertical-align:bottom"></div>
    </div>
    <?php
	}
}
?>

<?php
}

if(isset($_REQUEST['rand']))
{
include_once("includes/closedb.php");
}
?>