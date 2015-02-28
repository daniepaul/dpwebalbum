<?php
include_once("config.php");
include_once("includes/opendb.php");
$showstatus = true;
echo '<?xml version="1.0" encoding="UTF-8"?>
<gallery frameColor="0xFFFFFF" frameWidth="5" imagePadding="20" displayTime="6" enableRightClickOpen="false">';
if(isset($_REQUEST['albumid']))
{
$albumid = $_REQUEST['albumid'];
$getalbumdetails = mysql_query("select * from photos where albumid='$albumid' and status='0' order by `order`,`photoid`");
if(mysql_num_rows($getalbumdetails) > 0)
{
$notfount = 0;
while($rowdata = mysql_fetch_array($getalbumdetails))
{
$url = "photos/download/".$rowdata["filename"];
if(file_exists($url))
{
$surl = "photoviewbig.php?id=".base64_encode($rowdata["filename"]);
$info = getimagesize($url);
list($width, $height) = $info;
$width = $width * .6;
$height = $height * .6;
$caption = $rowdata["caption"];
?>
<image>
   <url><?php echo $surl; ?></url>
   <caption><![CDATA[<font size="15"><?php echo $caption; ?></font>]]></caption>
   <width><?php echo $width; ?></width>
   <height><?php echo $height; ?></height>
</image>
<?php
}
else
	$notfount++;
}
if($notfount == mysql_num_rows($getalbumdetails))
	$showstatus = false;
}
else
	$showstatus = false;
}
else
	$showstatus = false;
include_once("includes/closedb.php");
if(!$showstatus) {
?>
<image>
   <url>images/angel.gif</url>
   <caption>No photos available</caption>
   <width>500</width>
   <height>218</height>
</image>
<?php } ?>
</gallery>