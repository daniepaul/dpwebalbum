<?php 
$landingpage = "profile";
include("includes/header.php"); ?>
<?php
if(isset($_SESSION['uid']) && $_SESSION['uid'] != "") {
$getuserdetails = mysql_query("select * from users where uid='".$_SESSION['uid']."'");
if(mysql_num_rows($getuserdetails) > 0) {
?>
<div class="addform">
<span class="title">Edit Profile</span><br /><br />
<?php if(isset($_REQUEST['errormsg'])) { ?><span style='color:red'><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
<?php if(isset($_REQUEST['successmsg'])) { ?><span style='color:green'><?php echo $_REQUEST['successmsg']; ?></span><br /><br /><?php } ?>
Name<br />
<?php echo mysql_result($getuserdetails,0,"name"); ?><br /><br />
Date of Birth<br />
<?php echo date("m/d/Y",strtotime(mysql_result($getuserdetails,0,"dob"))); ?><br /><br />
Location<br />
<?php echo mysql_result($getuserdetails,0,"location"); ?><br /><br />
Country<br />
<?php echo mysql_result($getuserdetails,0,"country"); ?><br /><br />
Photo<br />
<img src="userphotos/<?php echo mysql_result($getuserdetails,0,"photo"); ?>" alt="" border="0" /><br /><br />
</div>
<?php } else { ?>
<span style="color:red; font-size:10pt;">No user available.</span>
<?php } } else { ?>
<span style="color:red; font-size:10pt;">No Access. Please login to access this page.</span>
<?php } include("includes/footer.php"); ?>
