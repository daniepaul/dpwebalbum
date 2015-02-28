<?php
if($authenticate == "admin" && $_SESSION['isadmin']!="true")
{ ?>
<span style="color:red">No Access</span>
<?php
include("includes/footer.php");
die();
}
?>