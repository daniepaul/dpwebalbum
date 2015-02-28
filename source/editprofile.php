<?php 
$landingpage = "changepassword";
include("includes/header.php");
if(isset($_SESSION['uid']) && $_SESSION['uid'] != "") {
$getuserdetails = mysql_query("select * from users where uid='".$_SESSION['uid']."'");
if(mysql_num_rows($getuserdetails) > 0) {
?>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/mootools.v1.11.js"></script>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/DatePicker.js"></script>
<script type="text/javascript">
window.addEvent('domready', function(){
	$$('input.DatePicker').each( function(el){
		new DatePicker(el);
	});
});

function showupload()
{
document.getElementById("showphoto").style.display='none';
document.getElementById("showupload").style.display='block';
}
function showphoto()
{
document.getElementById("showupload").style.display='none';
document.getElementById("showphoto").style.display='block';
document.getElementById("userphoto").value='';
}
</script>
<form id="editprofilefrm" name="editprofilefrm" action="functions.php" method="post" enctype="multipart/form-data">
<div class="titlediv"><div class="l"><div class="r"><div class="t">Edit Profile</div></div></div></div><br />
<div class="addform">
<?php if(isset($_REQUEST['errormsg'])) { ?><img src="<?php echo BASEDIR; ?>themes/<?php echo THEME; ?>/images/wrong.jpg" alt="" border="0" style="vertical-align:middle" class="profile" />&nbsp;<span style='color:red'><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
<?php if(isset($_REQUEST['successmsg'])) { ?><img src="<?php echo BASEDIR; ?>themes/<?php echo THEME; ?>/images/tick.jpg" alt="" border="0" style="vertical-align:middle" class="profile" />&nbsp;<span style='color:green'><?php echo $_REQUEST['successmsg']; ?></span><br /><br /><?php } ?>
Name<br />
<input type="text" name="uname" id="uname" value="<?php echo mysql_result($getuserdetails,0,"name"); ?>" /><br /><br />
Date of Birth<br />
<input type="text" name="dob" id="dob" class="DatePicker" alt="{format:'mm/dd/yyyy',yearOrder:'desc',yearRange:90,yearStart:2000}" value="<?php echo date("m/d/Y",strtotime(mysql_result($getuserdetails,0,"dob"))); ?>" /><br /><br />
Location<br />
<input type="text" name="location" id="location" value="<?php echo mysql_result($getuserdetails,0,"location"); ?>" /><br /><br />
Country<br />
<input type="text" name="country" id="country" value="<?php echo mysql_result($getuserdetails,0,"country"); ?>" /><br /><br />
Photo<br />
<div id="showphoto"><a href="javascript:void(0);" onclick="showupload();"><img src="userphotos/<?php echo mysql_result($getuserdetails,0,"photo"); ?>" alt="" border="0" /><br />Change Photo</a></div>
<div id="showupload" style="display:none"><input type="file" name="userphoto" id="userphoto" value=""  /><br /><a href="javascript:void(0);" onclick="showphoto();">Cancel Photo Change</a></div>
<br /><br />
<input type="submit" name="editprofile" id="editprofile" value="Edit Profile" class="reset" />&nbsp;<a href="index.php">Cancel</a>
</div>
</form>
<?php } else { ?>
<span style="color:red; font-size:10pt;">No user available.</span>
<?php } } else { ?>
<span style="color:red; font-size:10pt;">No Access. Please login to access this page.</span>
<?php
} include("includes/footer.php"); ?>
