<?php
$id = base64_decode($_GET['id']);
$file = "photos/download/".$id;
if (file_exists($file)) readfile($file);
?>