<?php
if(isset($_REQUEST['rand']))
{
include_once("config.php");
include_once("includes/opendb.php");
}

if (isset($_REQUEST['photoid'])) {
$photoid = $_REQUEST['photoid'];

		$random = rand(0,time());
	$reviewresult = mysql_query("select * from photos where photoid='$photoid' and status='0'"); 
	if(mysql_num_rows($reviewresult) > 0)
	{
		if(!mysql_query("delete from photos where photoid='$photoid'"))
		{
				while($rowreview = mysql_fetch_assoc($reviewresult))
				{
				?>
				<div><img src="photos/medium/<?php echo $rowreview['filename']; ?>?rand=<?php echo $random; ?>" alt=""/></div>
				<img src="images/rc.gif" alt="Rotate Clockwise" title="Rotate Clockwise" border="0" class="reset" id="rc-<?php echo $rowreview['photoid']; ?>" onClick="rotate('<?php echo $rowreview['filename']; ?>','270','r-<?php echo $rowreview['photoid']; ?>')"/>&nbsp;&nbsp;&nbsp;<img src="images/rcc.gif" alt="Rotate Counter-Clockwise" title="Rotate Counter-Clockwise" border="0" class="reset" onClick="rotate('<?php echo $rowreview['filename']; ?>','90','r-<?php echo $rowreview['photoid']; ?>')"/>&nbsp;&nbsp;&nbsp;<img src="images/delete.gif" alt="Delete Photo" title="Delete Photo" border="0" class="reset"/><br/>
				<input type="hidden" name="p-<?php echo $rowreview['photoid']; ?>" id="photoid[]" value="<?php echo $rowreview['photoid']; ?>" /><textarea id="c-<?php echo $rowreview['photoid']; ?>" name="caption[]" cols="50" rows="4"><?php echo $rowreview['caption']; ?></textarea>
				</div>
				<?php
				}
		}
		else
		{
			$filename = mysql_result($reviewresult,0,'filename');
			$original = "photos/original/".$filename;
			$downloadpath = "photos/download/".$filename;
			$medium = "photos/medium/".$filename;
			$thumb = "photos/thumbnails/".$filename;
			unlink($thumb);
			unlink($medium);
			//unlink($downloadpath);
			unlink($original);
			echo "#";
		}
}
else
{
	echo "<span style='color:red'>Error Occured</span>";
}
}

if(isset($_REQUEST['rand']))
{
include_once("includes/closedb.php");
}
?>