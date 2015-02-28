<?php
$id = base64_decode($_GET['id']);
$file = "photos/medium/".$id;
if (file_exists($file)) readfile($file);
?>