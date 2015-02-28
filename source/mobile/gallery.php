<?php 
$landingpage = "gallery";
include("header.php"); ?>
<table width="100%"><tr><td>
<div class="titlediv"><div class="l"><div class="r"><div class="t">Albums</div></div></div></div>
<?php
$edit_album = false;
include("showalbums.php"); ?>
</td></tr></table>
<?php include("footer.php"); ?>
