<?php 
$whereset = "(albumid in (select albumid from albumfriends where userid='".$_SESSION['uid']."') or albumtypeid='1')";
if($edit_album == true || $_SESSION['isadmin'] == true) {
$whereset = " albumtypeid<>'5' "; }
$gal_query = "select count(*)albums,YEAR(`createddate`)year, MONTH(`createddate`)month from albums where $whereset group by YEAR(`createddate`), MONTH(`createddate`) order by YEAR(`createddate`), MONTH(`createddate`) desc";
$galresult = mysql_query($gal_query) or die(mysql_error());
$previousyear = "";
if(mysql_num_rows($galresult) > 0)
{
?>
<div align="left">
<div class="titlediv"><div class="l"><div class="r"><div class="t">Archives</div></div></div></div>
<?php
while($galrow = mysql_fetch_array($galresult))
{
if($galrow["year"] != $previousyear)
{
?>
<?php if($previousyear != "") { ?></ul></div><?php } ?>
<div class="sidemenu"><?php echo $galrow["year"]; ?><ul>
<?php
}
$link = "gallery.php";
if($edit_album == true) {
$link = "managealbums.php";
}
?>
<li><a href="<?php echo $link; ?>?albummonth=<?php echo $galrow["month"]."-".$galrow["year"]; ?>"><?php echo getMonthName($galrow["month"],"long"); ?> (<?php echo $galrow["albums"]; ?>)</a></li>
<?php 
$previousyear = $galrow["year"];
} ?>
</ul></div></div>
<?php } ?>