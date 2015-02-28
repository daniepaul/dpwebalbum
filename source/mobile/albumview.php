<?php
$id = base64_decode($_GET['id']);
$file = BASEDIRLINK."albumcovers/".$id;
if (file_exists($file)) readfile($file);
?>