<?php 
$landingpage = "cropphoto";
include("includes/header.php");
if(isset($_SESSION['uid']) && $_SESSION['uid'] != "" && isset($_REQUEST['file'])) {
$file = "userphotos/buffer/".$_REQUEST['file'];
    	$info = getimagesize($file);
    list($width, $height) = $info;
$getuserdetails = mysql_query("select * from users where uid='".$_SESSION['uid']."'");
if(mysql_num_rows($getuserdetails) > 0) {
?>
<script src="<?php echo BASEDIR; ?>js/jquery.min1.js"></script>
<script src="<?php echo BASEDIR; ?>js/jquery.Jcrop.js"></script>
<script language="Javascript">

	// Remember to invoke within jQuery(window).load(...)
	// If you don't, Jcrop may not initialize properly
	jQuery(window).load(function(){

		jQuery('#cropbox').Jcrop({
			setSelect: [ 0, 0, 100, 100 ],
			onChange: showPreview,
			onSelect: updateCoords,
			aspectRatio: 1
		});

	});
	
				function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};
			
	function checkCoords()
			{
				if (parseInt($('#w').val())) alert($('#w').val());
				return false;
			};

	// Our simple event handler, called from onChange and onSelect
	// event handlers, as per the Jcrop invocation above
	function showPreview(coords)
	{
		if (parseInt(coords.w) > 0)
		{
			var rx = 100 / coords.w;
			var ry = 100 / coords.h;

			jQuery('#preview').css({
				width: Math.round(rx * <?php echo $width; ?>) + 'px',
				height: Math.round(ry * <?php echo $height; ?>) + 'px',
				marginLeft: '-' + Math.round(rx * coords.x) + 'px',
				marginTop: '-' + Math.round(ry * coords.y) + 'px'
			});
		}
	}

</script>
<form id="cropphotofrm" name="cropphotofrm" action="functions.php" method="post" enctype="multipart/form-data">
<div class="titlediv"><div class="l"><div class="r"><div class="t">Crop Photo</div></div></div></div><br />
<div class="addform">
<?php if(isset($_REQUEST['errormsg'])) { ?><img src="<?php echo BASEDIR; ?>themes/<?php echo THEME; ?>/images/wrong.jpg" alt="" border="0" style="vertical-align:middle" class="profile" />&nbsp;<span style='color:red'><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
<?php if(isset($_REQUEST['successmsg'])) { ?><img src="<?php echo BASEDIR; ?>themes/<?php echo THEME; ?>/images/tick.jpg" alt="" border="0" style="vertical-align:middle" class="profile" />&nbsp;<span style='color:green'><?php echo $_REQUEST['successmsg']; ?></span><br /><br /><?php } ?>
		<table width="650" style="font-size:10pt;">
		<tr>
		<td>
		<img src="<?php echo $file; ?>" id="cropbox" />
		</td>
		<td valign="top" width="125" align="center">
        Preview
		<div style="width:100px;height:100px;overflow:hidden;">
			<img src="<?php echo $file; ?>" id="preview" />
		</div>
		
		</td>
		</tr>
		</table><br /><br />
        	<input type="hidden" name="filename" id="filename" value="<?php echo $_REQUEST['file']; ?>" />
        	<input type="hidden" id="x" name="x" value="0" />
			<input type="hidden" id="y" name="y" value="0" />
			<input type="hidden" id="w" name="w" value="100" />
			<input type="hidden" id="h" name="h" value="100" />
            <input type="checkbox" name="keeporiginal" id="keeporiginal" class="reset"  />&nbsp;Apply auto crop.<br /><br />
			<input type="submit" value="Crop Image" class="reset" name="cropimage" id="cropimage" />
</div>
</form>
<?php } else { ?>
<span style="color:red; font-size:10pt;">No user available.</span>
<?php } } else { ?>
<span style="color:red; font-size:10pt;">No Access. Please login to access this page.</span>
<?php
} include("includes/footer.php"); ?>
