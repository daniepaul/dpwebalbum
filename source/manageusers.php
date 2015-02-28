<?php 
$landingpage = "admin_index";
$authenticate = "admin";
include("includes/header.php");
$currentpage = 0;
if(isset($_REQUEST['muserpage'])) $currentpage = $_REQUEST['muserpage']-1;
?>
<script language="JavaScript" src="<?php echo BASEDIR; ?>js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" src="<?php echo BASEDIR; ?>js/jquery.columnfilters.js"></script>
<script type="text/javascript">
function confirmdeleteuser(id,id2)
{
if(window.confirm("Are you sure you want to delete the Contact from the list?"))
	window.location = "functions.php?action=deleteuser&id="+id+"&auth="+id2;
else
	return false;
}
</script>
<div class="addform">
<span class="title">Manage Users</span><br />
Select an user below to edit.<br /><br />
<?php
$uname = "";
$uemail = "";
if(isset($_REQUEST['uuid'])) {
$sql = mysql_query("select * from users where uid='".$_REQUEST['uuid']."'");
if(mysql_num_rows($sql) > 0)
{
	$uname = mysql_result($sql,0,"name");
	$uemail = mysql_result($sql,0,"email");
}
else
{
	echo "<span style='color:red'>Error in the edit data</span>";
}
}
?>
<?php if(isset($_REQUEST['errormsg'])) { ?><span style='color:red'><?php echo $_REQUEST['errormsg']; ?></span><?php } ?>
<?php if(isset($_REQUEST['successmsg'])) { ?><span style='color:green'><?php echo $_REQUEST['successmsg']; ?></span><?php } ?>
<form id="usersfrm" name="usersfrm" action="functions.php" method="post">
<input type="hidden" id="muserpage" name="muserpage" value="<?php echo $currentpage+1; ?>"  />
<table width="100%" cellpadding="3" cellspacing="2" style="font-size:10pt; margin-left:15px;">
<tr><td>Name:<br /><input type="text" name="uname" id="uname" class="reset"  value="<?php echo $uname; ?>" style="width:230px" /></td>
<td>Email Address<br /><input type="text" name="uemail" id="uemail" class="reset" value="<?php echo $uemail; ?>" style="width:230px" /></td>
<td>Password<br /><input type="text" name="upassword" id="upassword" class="reset" <?php if(!isset($_REQUEST['uuid'])) { ?>disabled="disabled" value=""<?php } ?>  /></td>
<td valign="bottom"><?php if(isset($_REQUEST['uuid'])) { ?><input type="hidden" id="uuid" name="uuid" value="<?php echo $_REQUEST['uuid']; ?>"  /><?php } ?><input type="submit" <?php if(isset($_REQUEST['uuid'])) { ?>name="edituser" id="edituser" value="Edit"<?php } else { ?>name="adduser" id="adduser" value="Add"<?php } ?> class="reset" style="float:left" /><input type="reset" name="resetfrm" id="resetfrm" value="Reset" class="reset" onclick="window.location='manageusers.php?muserpage=<?php echo $currentpage+1; ?>'" style="float:left; margin-left:5px" /></td></tr> 
</table>
</form>
<table id="filterTable1"  width="100%" cellpadding="5" cellspacing="2" style="font-size:10pt; margin-left:15px;">
<thead>
<tr class="manageusers_t"><th width="3%">&nbsp;</th><th width="35%">Users</th><th width="37%">Email</th><th width="25%">Action</th></tr>
</thead>
<tfoot></tfoot>
<tbody>
<?php
$count = 2000;
$manageusers = new paging($count,0, "prev", "next", "(%%number%%)","muserpage","");
$manageusers->query("select * from users order by email");
$result = mysql_query($sql);
$i = $currentpage*$count+1;
while($row = $manageusers->result_assoc())
{
$j = $i%2; 
if($row["status"] == "3")
	$applycolor = "#A80000";
?>
<tr class="manageusers_<?php echo $j; ?>"><td width="3%"><?php echo $i; ?></td><td width="35%"><?php echo $row["name"]; if($row["status"] == "1" || $row["status"] == "4") { ?><img src="images/user.gif" alt="Is User" title="Is User" style="vertical-align:middle" /><?php } ?></td><td width="37%"><?php echo $row["email"]; ?></td><td width="25%" align="left"><a href="manageusers.php?muserpage=<?php echo $currentpage+1; ?>&uuid=<?php echo $row["uid"]; ?>"><img src="images/setting.gif" alt="Edit User" border="0" title="Edit User" /></a>&nbsp;<a href="javascript:void(0)" onclick="return confirmdeleteuser('<?php echo $row["uid"]; ?>','<?php echo base64_encode($row["uid"]);?>');"><img src="images/recycle.gif" alt="Delete User" border="0" title="Delete User" /></a>&nbsp;<?php if($row["status"] == "1" || $row["status"] == "4" || $row["status"] == "3") { ?><a href="functions.php?action=blockuser&user=<?php echo $row["uid"]; ?>&authcode=<?php echo base64_encode($row["uid"]); ?>&status=<?php echo $row["status"]; ?>"><img src="images/block.gif" alt="Block User" border="0" title="Block User" /></a><?php } ?><?php if($row["status"] != "1" && $row["status"] != "4" && $row["status"] != "3") { ?>&nbsp;<a href="functions.php?action=activateuser&user=<?php echo $row["uid"]; ?>&authcode=<?php echo base64_encode($row["uid"]); ?>"><img src="images/key.gif" alt="Activate User" border="0" title="Activate User" /></a><?php } ?></td></tr>
<?php $i++; } ?>
<tr><td colspan="4" align="center"><?php echo $manageusers->print_link() ?></td></tr>
</tbody>
</table>
</div>
<script>
	$(document).ready(function() {
		$('table#filterTable1').columnFilters({caseSensitive:false, excludeColumns:[0,3]});
	});
</script>
<?php include("includes/footer.php"); ?>
