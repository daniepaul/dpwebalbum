<?php 
$columns = 4;
$where = "";
if(isset($_REQUEST['albummonth']))
{
$splitvalue = split("-",$_REQUEST['albummonth']);
if(sizeof($splitvalue) == 2)
{
$where = " and YEAR(`createddate`)='".$splitvalue[1]."' and MONTH(`createddate`)='".$splitvalue[0]."'";
}
}
$whereset = "(albumid in (select albumid from albumfriends where userid='".$_SESSION['uid']."') or albumtypeid='1')";
if($edit_album == true || $_SESSION['isadmin'] == true) {
$whereset = " albumtypeid<>'5' ";
}
$sql_showalbum = "select * from albums where $whereset".$where." order by YEAR(`createddate`), MONTH(`createddate`) desc";
//echo $sql_showalbum;
$showalbumresult = mysql_query($sql_showalbum) or die(mysql_error());
if(mysql_num_rows($showalbumresult) > 0)
{
?>
<table cellpadding="5" cellspacing="0" class="albumtable" align="center" width="100%">
<?php
$setcolumn = 1;
while($showalbumrow = mysql_fetch_array($showalbumresult))
{
$authcode = "";
if($showalbumrow['albumtypeid'] == '2')
	$authcode = "&authcode=".$showalbumrow['authcode'];
if($setcolumn == 1)
{ ?>
<tr>
<?php } ?>
<td align="center" width="<?php echo 100/$columns ?>%"><a href="photos.php?album=<?php echo $showalbumrow['albumid'].$authcode; ?>"><img src="albumview.php?id=<?php echo base64_encode($showalbumrow['albumcoverphoto']); ?>" alt="" border="0" /><br /><?php echo strtolower($showalbumrow['albumname']); ?></a><?php if($edit_album == true) { ?><div style="float:right"><a href="editalbum.php?albumid=<?php echo $showalbumrow['albumid']; ?>"><img src="images/edit.gif" width="15" alt="" border="0" />Edit</a></div><?php } ?></td>
<?php
if($setcolumn == $columns)
{
?>
</tr>
<?php
$setcolumn = 1;} else { $setcolumn++; }
?>
<?php
} ?>
<?php if($setcolumn != 1) { for($i=$setcolumn;$i<=$columns;$i++) {?>
<td>&nbsp;</td>
<?php } ?>
</tr>
<?php } ?>
</table>
<?php } else { ?>
<span style="font-size:10pt; margin:5px;">No albums</span>
<?php } ?>