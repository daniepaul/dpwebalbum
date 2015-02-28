<?php
if(isset($_REQUEST['rand']))
{
include_once("config.php");
include_once("includes/opendb.php");
}

if(isset($_REQUEST['albumid']))
{
	if(isset($_REQUEST['setcover']))
	{
		$resultcover = mysql_query("select albumcoverphoto from albums where albumid='".$_REQUEST['albumid']."'");
		$oldfile = mysql_result($resultcover,0,"albumcoverphoto");
		$filename = $_REQUEST['setcover'];
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$albumcover = md5($_REQUEST['albumid']."_cover").".".$ext;
		include("lib/uploadfunctions.php");
		$filepath = "photos/medium/".$filename;
		$dest = "albumcovers/".$albumcover;
		smart_resize_image($filepath,150,0,true,'file',false,false,$dest,true);
		if(!mysql_query("update albums set albumcoverphoto='$albumcover' where albumid='".$_REQUEST['albumid']."'"))
		{
		}
		else
		{
			unlink($oldfile);
		}
		header("location:reviewalbum.php?albumid=".$_REQUEST['albumid']);
	}
?>
<?php 
$reviewalbum = new paging(25,0, "prev", "next", "(%%number%%)","reviewpage","");
$reviewresult = $reviewalbum->query("select * from photos where albumid='".$_REQUEST['albumid']."' and status='0'"); 
if($reviewalbum->result_count() > 0)
{
	while($rowreview = $reviewalbum->result_assoc())
	{
	?>
    <div class="reviewalbumdiv" id="r-<?php echo $rowreview['photoid']; ?>"><div><img src="photos/medium/<?php echo $rowreview['filename']; ?>" alt=""/></div>
    <img src="images/rc.gif" alt="Rotate Clockwise" title="Rotate Clockwise" border="0" class="reset" id="rc-<?php echo $rowreview['photoid']; ?>" onClick="rotate('<?php echo $rowreview['filename']; ?>','270','r-<?php echo $rowreview['photoid']; ?>')"/>&nbsp;&nbsp;&nbsp;<img src="images/rcc.gif" alt="Rotate Counter-Clockwise" title="Rotate Counter-Clockwise" border="0" class="reset" onClick="rotate('<?php echo $rowreview['filename']; ?>','90','r-<?php echo $rowreview['photoid']; ?>')"/>&nbsp;&nbsp;&nbsp;<img src="images/delete.gif" alt="Delete Photo" title="Delete Photo" border="0" class="reset" onClick="deletephotos('<?php echo $rowreview['photoid']; ?>','r-<?php echo $rowreview['photoid']; ?>');"/>&nbsp;&nbsp;&nbsp;<a href="reviewalbum.php?albumid=<?php echo $_REQUEST['albumid']; ?>&setcover=<?php echo $rowreview['filename']; ?>"><img src="images/cover_g.gif" alt="Set as cover" title="Set as cover" border="0" class="reset" /></a><br/>
    <input type="hidden" name="p-<?php echo $rowreview['photoid']; ?>" id="photoid[]" value="<?php echo $rowreview['photoid']; ?>" /><textarea id="c-<?php echo $rowreview['photoid']; ?>" name="caption[]" cols="50" rows="4" onchange="savecaption('<?php echo $rowreview['photoid']; ?>',this.id,'status-<?php echo $rowreview['photoid']; ?>')"><?php echo $rowreview['caption']; ?></textarea><div id="status-<?php echo $rowreview['photoid']; ?>" style="float:right; vertical-align:bottom"></div>
    </div>
    <?php
	}
}
?>
<div><?php echo $reviewalbum->print_link() ?></div>
<?php }

if(isset($_REQUEST['rand']))
{
include_once("includes/closedb.php");
}
?>