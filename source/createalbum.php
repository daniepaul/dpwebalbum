<?php 
$landingpage = "createalbum";
$authenticate = "admin";
include("includes/header.php"); ?>
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
</script>
<span class="title">Create New Album</span><br />
<div class="addform">
<form id="createalbumfrm" id="" method="post" action="functions.php" onsubmit="return checkform();" >
Enter Details for the new album<br /><br />
<?php if(isset($_REQUEST['errormsg'])) { ?><span style="color:red"><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
Title<br /><input type="text" name="albumtitle" id="albumtitle" value="Untitled Album" /><br /><br />
Date<br /><input type="text" name="albumdate" id="albumdate" class="DatePicker" alt="{format:'mm/dd/yyyy'}" value="<?php echo date("m/d/Y"); ?>" /><br /><br />
Description (Optional)<br /><textarea name="albumdesc" id="albumdesc"></textarea><br /><br />
Place Taken (Optional)<br /><input type="text" name="albumlocation" id="albumlocation" /><br /><br />
Visibility of the album<br />
<input type="radio" name="albumtype" id="albumtype" value="1" checked="checked" class="reset" />Public<br />
<input type="radio" name="albumtype" id="albumtype" value="2" class="reset" />Unlisted<br />
<input type="radio" name="albumtype" id="albumtype" value="3" class="reset" />Sign-in Required<br /><br />
<br />
<input type="submit" value="Continue" id="createalbum" name="createalbum" class="reset" />
</form>
</div>
<?php include("includes/footer.php"); ?>
