<?php 
$landingpage = "editpage";
$authenticate = "admin";
include("includes/header.php");
$pageid = $_REQUEST['id'];
$sql = mysql_query("select * from pages where pageid='$pageid' and status='0'");
if(mysql_num_rows($sql) > 0)
{
include("fckeditor.php") ;
?>
<div class="addform">
<span class="title">Edit Page</span><br /><br />
<?php if(isset($_REQUEST['errormsg'])) { ?><span style="color:red"><?php echo $_REQUEST['errormsg']; ?></span><br /><br /><?php } ?>
<form name="editpagefrm" id="editpagefrm" action="functions.php" method="post">
Page Title<br />
<input type="text" name="pagetitle" id="pagetitle" value="<?php echo mysql_result($sql,0,"title"); ?>" /><br /><br />
Page Content<br />
<?php
	$sBasePath = $_SERVER['PHP_SELF'] ;
	$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
	$oFCKeditor = new FCKeditor('content') ;
	$oFCKeditor->BasePath	= $sBasePath ;
	$oFCKeditor->Value		= mysql_result($sql,0,"content") ;
	$oFCKeditor->Create() ;
?>
<br /><br />
<input type="hidden" name="pageid" id="pageid" value="<?php echo $pageid; ?>" />
<input type="submit" name="editpage" id="editpage" value="Edit Page" class="reset" />&nbsp;<a href="managepages.php">Cancel</a>
</form>
</div>
<?php 
} else { ?>
<span style="color:#FF0000">Error Loading Page</span>
<?php }
include("includes/footer.php"); ?>
