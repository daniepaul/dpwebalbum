<?php
include_once("config.php");
include_once("includes/opendb.php");
$photoid = "";
$caption = "";
$returnurl = "";
if(isset($_REQUEST['photoid']))
{
$photoid = $_REQUEST['photoid'];
$caption = htmlentities($_REQUEST['caption'],ENT_QUOTES);
$caption = str_replace("<~and~>","&",$caption);
$caption = str_replace("<~hash~>","#",$caption);
$caption = str_replace("<~qmark~>","?",$caption);

if(!mysql_query("update photos set `caption`='$caption' where photoid='$photoid'"))
echo '0';
else
echo '#';
include_once("includes/closedb.php");
}
?>