<?php
include("lib/uploadfunctions.php");
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$rand = rand(0,time());
	$targetPath = $_GET['folder'] . '/';
	$d = $_GET['album'] . '_';
	   $ext = strtolower(pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION));  //figures out the extension
   
   $newFileName = $d.md5($rand).'.'.$ext; //generates random filename, then adds the file extension
	$targetFile =  "photos/original/" .$newFileName;
	$download = "photos/download/".$newFileName;
	$thumbpath = "photos/thumbnails/".$newFileName;
	$mediumpath = "photos/medium/".$newFileName;
	
	//chmod($targetFile,0777);
	//chmod($thumbpath,0777);
	//chmod($mediumpath,0777);
	
	// Uncomment the following line if you want to make the directory if it doesn't exist
	// mkdir(str_replace('//','/',$targetPath), 0755, true);
	
	if(move_uploaded_file($tempFile,$targetFile))
	{
		smart_resize_image($targetFile,1600,0,true,'file',false,false,$download,false);
		smart_resize_image($download,600,0,true,'file',false,false,$mediumpath,false);
		smart_resize_image($mediumpath,50,0,true,'file',false,false,$thumbpath,true);
		if ($newFileName)
		   echo $newFileName;
		else
			echo "1";
	}
	else
	{
		echo "failed";
	}
}
?>