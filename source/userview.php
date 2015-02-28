<?php
$id = base64_decode($_REQUEST['id']);
$file = "userphotos/".$id;
if (file_exists($file)) readfile($file);
else readfile("userphotos/defaultphoto.gif");
?>