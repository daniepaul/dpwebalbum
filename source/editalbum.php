<?php 
$landingpage = "createalbum";
$authenticate = "admin";
include("includes/header.php");
if(isset($_REQUEST['albumid']))
{
$albumid = $_REQUEST['albumid'];
$albumresult = mysql_query("select * from albums where albumid='".$_REQUEST['albumid']."'");
if(mysql_num_rows($albumresult) > 0) {
?>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/mootools.v1.11.js"></script>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/DatePicker.js"></script>
<script type="text/javascript">
window.addEvent('domready', function(){
	$$('input.DatePicker').each( function(el){
		new DatePicker(el);
	});
});
</script>
<script type="text/javascript">
function checkform()
{
var fields = new Array("albumtitle","albumdate","albumtype");
var errors = new Array("Album title cannot be empty","Please enter a date","Select a type of Album");
var errormsg = "";
for(var i=0; i<fields.length;i++)
{
	var obj = document.getElementById(fields[i]);
	if(obj)
	{
		switch(obj.type)
		{
			case "select-one":
				if (obj.selectedIndex == -1 || obj.options[obj.selectedIndex].text == ""){
					errormsg += " - " + errors[i] + "\n";
				}
			break;
			
			case "select-multiple":
			break;
				if (obj.selectedIndex == -1){
					errormsg += " - " + errors[i] + "\n";
				}
				break;
			case "text":
			case "textarea":
				if (obj.value == "" || obj.value == null){
					errormsg += " - " + errors[i] + "\n";
				}
				break;
			break;
			
			case "undefined":
				var blnchecked = false;
				for (var j = 0; j < obj.length; j++){
					if (obj[j].checked){
						blnchecked = true;
					}
				}
				if (!blnchecked){
					errormsg += " - " + errors[i] + "\n";
				}
			break;
		}
	}
}
if(errormsg != "")
{
	alert(errormsg);
	return false;
}
}

function confirmdelete(id,id2)
{
if(window.confirm("Are you sure you want to delete the album?"))
	window.location = "functions.php?action=deletealbum&id="+id+"&auth="+id2;
else
	return false;
}
</script>
<span class="title">Create New Album</span><br />
<div class="addform">
<form id="editalbumfrm" id="editalbumfrm" method="post" action="functions.php" onsubmit="return checkform();">
<input type="hidden" id="albumid" name="albumid" value="<?php echo $_REQUEST['albumid']; ?>" />
Enter Details for the new album<br /><br />
<?php if(isset($_REQUEST['errormsg'])) { ?><span style="color:red"><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
Title<br /><input type="text" name="albumtitle" id="albumtitle" value="<?php echo mysql_result($albumresult,0,"albumname"); ?>" /><br /><br />
Date<br /><input type="text" name="albumdate" id="albumdate" class="DatePicker" alt="{format:'mm/dd/yyyy'}" value="<?php echo date("m/d/Y",strtotime(mysql_result($albumresult,0,"albumdate"))); ?>" /><br /><br />
Description (Optional)<br /><textarea name="albumdesc" id="albumdesc"><?php echo mysql_result($albumresult,0,"albumdescription"); ?></textarea><br /><br />
Place Taken (Optional)<br /><input type="text" name="albumlocation" id="albumlocation" value="<?php echo mysql_result($albumresult,0,"albumlocation"); ?>" /><br /><br />
Visibility of the album<br />
<input type="radio" name="albumtype" id="albumtype" value="1" <?php if(mysql_result($albumresult,0,"albumtypeid") == "1") { ?> checked="checked" <?php } ?> class="reset" />Public<br />
<input type="radio" name="albumtype" id="albumtype" value="2" <?php if(mysql_result($albumresult,0,"albumtypeid") == "2") { ?> checked="checked" <?php } ?> class="reset" />Unlisted<br />
<input type="radio" name="albumtype" id="albumtype" value="3" <?php if(mysql_result($albumresult,0,"albumtypeid") == "3") { ?> checked="checked" <?php } ?> class="reset" />Sign-in Required<br /><br />
<br />
<input type="submit" value="Save Changes" id="editalbum" name="editalbum" class="reset" />&nbsp;&nbsp;&nbsp;<input type="button" name="EditPhotos" id="EditPhotos" value="Edit Photos"  class="reset" onclick="window.location='reviewalbum.php?albumid=<?php echo $_REQUEST['albumid']; ?>'"/>&nbsp;&nbsp;&nbsp;<input type="button" name="DeleteAlbum" id="DeleteAlbum" value="Delete Album"  class="reset" onclick="return confirmdelete('<?php echo $_REQUEST['albumid']; ?>','<?php echo base64_encode($_REQUEST['albumid']);?>');"/>
</form>
<br /><br />
<a href="photos.php?album=<?php echo $albumid; ?>"><img src="images/view.gif" border="0" alt="" style="vertical-align:middle" /> View the album</a><div style="float:right"><a href="share.php?albumid=<?php echo $albumid; ?>"><img src="images/invite.gif" border="0" alt="" style="vertical-align:middle" /> Share the album</a></div>
</div>
<?php } else {?>
No album found.
<?php } } else {?>
Error Loading the page.
<?php } ?>
<?php include("includes/footer.php"); ?>
