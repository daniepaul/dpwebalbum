<?php 
$landingpage = "sharealbum";
$authenticate = "admin";
include("includes/header.php"); 
if(isset($_REQUEST['albumid']))
{
$albumid = $_REQUEST['albumid'];
$albumresult = mysql_query("select * from albums where albumid='$albumid'");
if(mysql_num_rows($albumresult) > 0) {
?>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/jquery.tokeninput.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#friends").tokenInput("getnames.php", {
            hintText: "Type the names of your friends.",
            noResultsText: "No results",
            searchingText: "Searching..."
        });
	});
	
	
function checkfrm()
{
$val = document.getElementById("friends").value;
if($val == "")
{
	alert("Please enter some friends to share");
	return false;
}
else
{
	return true;
}
}
</script>
<span class="title">Share Album</span><br />
<span class="subtitle">Album Name: <b><?php echo mysql_result($albumresult,0,"albumname"); ?></b></span><br /><br />
<div class="addform">
Share the album with your friends.<br /><br />
<?php if(isset($_REQUEST['errormsg'])) { ?><span style="color:red"><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
<?php if(isset($_REQUEST['successmsg'])) { ?><span style="color:green"><?php echo $_REQUEST['successmsg']; ?></span><br /><br /><?php } ?>
<form id="sharefrm" name="sharefrm" action="functions.php" method="post" onsubmit="return checkfrm()">
Share With<br />
<input type="text" id="friends" name="friends"  /><br /><br />
<input type="hidden" name="albumid" id="albumid" value="<?php echo $albumid; ?>" />
<input type="submit" name="sharefriends" id="sharefriends" value="Share and send mail" class="reset" />
</form>
<br /><br />
<a href="photos.php?album=<?php echo $albumid; ?>"><img src="images/view.gif" border="0" alt="" style="vertical-align:middle" /> View the album</a><div style="float:right"><a href="editalbum.php?albumid=<?php echo $albumid; ?>"><img src="images/setting.gif" border="0" alt="" style="vertical-align:middle" /> Edit the album</a></div>
</div>
<?php } else { ?>
Error loading the page.
<?php 
}}
else
{
?>
Error loading the page.
<?php }
include("includes/footer.php"); ?>
