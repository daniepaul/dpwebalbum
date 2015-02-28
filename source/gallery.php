<?php 
$landingpage = "gallery";
include("includes/header.php"); ?>
<table width="100%"><tr><td width="200" valign="top">
<?php include("gallery_side.php"); ?>
</td><td valign="top">
<div class="titlediv"><div class="l"><div class="r"><div class="t">Albums</div></div></div></div>
<?php
$edit_album = false;
include("showalbums.php"); ?>
</td></tr></table>
<?php include("includes/footer.php"); ?>
