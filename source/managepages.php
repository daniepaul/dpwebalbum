<?php 
$landingpage = "admin_index";
$authenticate = "admin";
include("includes/header.php");?>
<div class="addform">
<span class="title">Manage Pages</span><br />
Select a page below to edit.<br /><br />
<?php if(isset($_REQUEST['successmsg'])) { ?><span style="color:green"><?php echo $_REQUEST['successmsg']; ?></span><br /><br /><?php } ?>
<table width="500" cellpadding="5" cellspacing="2" style="font-size:10pt; margin-left:15px;">
<tr class="manageusers_t"><td>Page Name</td><td>Edit</td><td>Delete</td></tr>
<?php
$sql = "select * from pages where status='0'";
$result = mysql_query($sql);
$color[0] = "#1a1a1a";
$color[1] = "#2a2a2a";
$i = 0;
while($row = mysql_fetch_array($result))
{
$j = $i%2; 
?>
<tr class="manageusers_<?php echo $j; ?>"><td width="70%"><?php echo $row["title"]; ?></td><td width="15%" align="center"><a href="editpage.php?id=<?php echo $row["pageid"]; ?>"><img src="images/edit.gif" alt="Edit Page" border="0" title="Edit Page" /></a></td><td width="15%" align="center"><img src="images/delete.gif" alt="Delete Page" border="0" title="Delete Page" /></td></tr>
<?php $i++; } ?>
</table>
</tr>
<?php include("includes/footer.php"); ?>
