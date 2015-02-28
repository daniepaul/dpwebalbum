<?php
$columns = 5;
$rows = 1;
$where = "";
if(isset($_REQUEST['album']))
{
$countthumbs =  $columns*$rows;
$showthumbs = new paging($countthumbs,0, "prev", "next", "(%%number%%)","thumbpage","getPage(<page>,'".$_REQUEST['album']."');");
$resultshowthumbs = $showthumbs->query("select * from photos where albumid='".$_REQUEST['album']."' and status='0' order by `order`,`photoid`"); 
if($showthumbs->result_count() > 0)
{
?>
<table cellpadding="5" cellspacing="0" class="thumbstable" align="center" width="100%">
<?php
$setcolumn = 1;
$setrow=1;
while($rowshowthumbs = $showthumbs->result_assoc())
{
if($setcolumn == 1)
{ ?>
<tr>
<?php } ?>
<td align="center"><a href="photos.php?album=<?php echo $_REQUEST['album'];?>&photo=<?php echo $rowshowthumbs['photoid']; ?>#showphoto"><img src="<?php echo BASEDIRLINK; ?>photos/thumbnails/<?php echo $rowshowthumbs['filename']; ?>" alt="" border="0" width="35" /></a></td>
<?php
if($setcolumn == $columns)
{
?>
</tr>
<?php
$setrow++;
$setcolumn = 1;} else { $setcolumn++; }
?>
<?php
} ?>
<?php if($setcolumn != 1) { for($i=$setcolumn;$i<=$columns;$i++) {?>
<td> </td>
<?php } ?>
</tr>
<?php } ?>
<tr><td colspan="<?php echo $columns; ?>">
<?php echo $showthumbs->print_link() ?>
</td></tr>
</table>
<?php }
else
	echo "<span style='color:red; font-size:10pt;'>No Photos</span>";
 }
else
	echo "<span style='color:red; font-size:10pt;'>Error</span>";
?>