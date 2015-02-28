<?php 
$landingpage = "managealbums";
$authenticate = "admin";
include("includes/header.php"); ?>
<table width="100%"><tr><td width="200" valign="top">
<?php 
$edit_album = true;
include("gallery_side.php"); ?>
</td><td>
<?php if(isset($_REQUEST['errormsg'])) { ?><img src="<?php echo BASEDIR; ?>themes/<?php echo THEME; ?>/images/wrong.jpg" alt="" border="0" style="vertical-align:middle" class="profile" />&nbsp;<span style='color:red'><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
<?php if(isset($_REQUEST['successmsg'])) { ?><img src="<?php echo BASEDIR; ?>themes/<?php echo THEME; ?>/images/tick.jpg" alt="" border="0" style="vertical-align:middle" class="profile" />&nbsp;<span style='color:green'><?php echo $_REQUEST['successmsg']; ?></span><br /><br /><?php } ?>
<?php 
include("showalbums.php"); ?>
</td></tr></table>
<?php include("includes/footer.php"); ?>
