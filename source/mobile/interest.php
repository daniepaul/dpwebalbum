<?php 
$landingpage = "aboutme";
include("header.php"); ?>
<?php
$pageid = "2";
$sql = "select * from pages where pageid='$pageid' and status='0'";
$result = mysql_query($sql);
if(mysql_num_rows($result) > 0)
{
?>
<div class="displaypage">
<div class="titlediv"><div class="l"><div class="r"><div class="t"><?php echo mysql_result($result,0,"title"); ?></div></div></div></div>
<?php echo mysql_result($result,0,"content"); ?>
</div>
<?php
}
include("footer.php"); ?>
