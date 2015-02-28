<?php 
$landingpage = "changepassword";
include("includes/header.php");
if(isset($_SESSION['uid']) && $_SESSION['uid'] != "") {
?>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/passwordmeter.js"></script>
<form id="changepwordfrm" name="changepwordfrm" action="functions.php" method="post">
<div class="titlediv"><div class="l"><div class="r"><div class="t">Change Password</div></div></div></div><br />
<div class="addform">
<?php if(isset($_REQUEST['errormsg'])) { ?><img src="<?php echo BASEDIR; ?>themes/<?php echo THEME; ?>/images/wrong.jpg" alt="" border="0" style="vertical-align:middle" class="profile" />&nbsp;<span style='color:red'><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
<?php if(isset($_REQUEST['successmsg'])) { ?><img src="<?php echo BASEDIR; ?>themes/<?php echo THEME; ?>/images/tick.jpg" alt="" border="0" style="vertical-align:middle" class="profile" />&nbsp;<span style='color:green'><?php echo $_REQUEST['successmsg']; ?></span><br /><br /><?php } ?>
Old Password<br />
<input type="password" name="oldpassword" id="oldpassword" value="" /><br /><br />
New Password<br />
<input type="password" name="newpassword" id="newpassword" value=""  onkeyup="runPassword(this.value, 'mypassword');" />
<br /> 
			<div style="width: 500px;"> 
				<div id="mypassword_text" style="font-size: 10px;">&nbsp;</div> 
				<div id="mypassword_bar" style="font-size: 1px; height: 2px; width: 0px; border: 1px solid white;">&nbsp;</div> 
			</div> 
<br />
Confirm New Password<br />
<input type="password" name="cnewpassword" id="cnewpassword" value="" /><br /><br />
<input type="submit" name="changepassword" id="changepassword" value="Change Password" class="reset" />&nbsp;<a href="index.php">Cancel</a>
</div>
</form>
<?php } else { ?>
<span style="color:red; font-size:10pt;">No Access. Please login to access this page.</span>
<?php
} include("includes/footer.php"); ?>
