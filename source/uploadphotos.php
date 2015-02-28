<?php 
$landingpage = "uploadphotos";
$authenticate = "admin";
include("includes/header.php"); 
if(isset($_REQUEST['albumid']))
{
$albumid = $_REQUEST['albumid'];
$albumresult = mysql_query("select * from albums where albumid='$albumid'");
if(mysql_num_rows($albumresult) > 0) {
?>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/jquery.uploadify.js"></script>
<span class="title">Upload Photos</span><br />
<span class="subtitle">Album Name: <b><?php echo mysql_result($albumresult,0,"albumname"); ?></b></span><br /><br />
<div class="addform" style="margin-left:25px;">
Browse for photos in your computer to upload them. Use multiple select option.<br /><br />
<?php if(isset($_REQUEST['errormsg'])) { ?><span style="color:red"><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
<div id="test">
<form id="uploadphotosfrm" name="uploadphotosfrm" action="functions.php" method="post">
<div><div style="float:left; width:400px;">
<input type="file" name="fileInput" id="fileInput" />
         <script type="text/javascript">
         $(document).ready(function() {
         $('#fileInput').fileUpload ({
      'uploader':'swf/uploader.swf',
      'script':'upload.php',
	  'scriptData':{'album':'<?php echo $albumid; ?>'},
	  'fileDesc':'Standard Images Only',
      'fileExt':'*.tif;*.png;*.jpg;*.gif;',
      'cancelImg':'images/cancel.png',
      'folder':'./photos/original',
      'wmode':'transparent',
	  'simUploadLimit': 1,
      'width':139,
      'multi':true,
      'auto':false,
      'onComplete': function(event, queueID, fileObj, reposnse, data) {
		  if(reposnse.split(' ').join('') != 'failed')
		  {
			 $('#filesUploaded').append('<div class="uploadthumbs"><center><img src="photos/thumbnails/'+reposnse+'" alt="" width="50" /><br />'+fileObj.name+'</center></div>');
			 $('#files').append(reposnse+',');
		 }
}
         });
         });
         </script>
 <br /> 
  <a href="javascript:$('#fileInput').fileUploadStart();">Upload Files</a> | <a href="javascript:$('#fileInput').fileUploadClearQueue();">Clear Queue</a></div>    
            <div style="float:left">Uploaded Files<br /><div id="filesUploaded" class="uploadedfiles"></div></div></div>
           <br /><div>
           <input type="hidden" name="albumid" id="albumid" value="<?php echo $albumid; ?>" />
           <textarea name="files" id="files" cols="60" rows="5" style="display:none"></textarea>
            <input type="submit"  id="uploadphotos" name="uploadphotos" value="Add Uploaded Photos to Album" class="reset" style="float:right" />
            </div>
      </form>
</div></div>
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
