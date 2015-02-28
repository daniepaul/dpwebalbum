<?php
include_once("config.php");
include_once("includes/opendb.php");
$photoid = "";
$commenttext = "";
$returnurl = "";
$userid = $_SESSION['uid'];
if(isset($_REQUEST['photoid']))
{
$photoid = $_REQUEST['photoid'];
$commenttext = htmlentities($_REQUEST['commenttext'],ENT_QUOTES);
if(isset($_REQUEST['returnurl']))
$returnurl = $_REQUEST['returnurl'];
}
else if(isset($_POST['photoid']))
{
$photoid = $_POST['photoid'];
$commenttext = htmlentities($_POST['commenttext'],ENT_QUOTES);
$returnurl = $_POST['returnurl'];
}
$commenttext = str_replace("<~and~>","&",$commenttext);
$commenttext = str_replace("<~hash~>","#",$commenttext);
$commenttext = str_replace("<~qmark~>","?",$commenttext);

if(!mysql_query("insert into comments (photoid,uid,comment) values ('$photoid','$userid','$commenttext')"))
echo "0";
else
echo "1";
if(trim($returnurl) != "")
{
header("location:$returnurl");
}
include_once("includes/closedb.php");
?>