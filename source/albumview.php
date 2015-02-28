<?php
$id = base64_decode($_GET['id']);
$file = "albumcovers/".$id;
if (file_exists($file)) readfile($file);
?>