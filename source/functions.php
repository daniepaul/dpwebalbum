<?php
include("config.php");
include("includes/opendb.php");

//Login Function
//#############################################################
if(isset($_POST['login']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];
	$isalive = $_POST['isalive'];
	$returnurl = $_POST['returnurl'];
	$error = "";
	if(strchr($returnurl,"&error="))
	{
		$ep = explode("&error=",$returnurl);
		$returnurl = $ep[0];
	}
	if(strchr($returnurl,"?error="))
	{
		$ep = explode("?error=",$returnurl);
		$returnurl = $ep[0];
	}
	if(trim($email) != "" && trim($password) != "")
	{
		$sql_login = "select * from users where `email`='$email' and `password`='$password'";
		$result_login = mysql_query($sql_login);
		if(mysql_num_rows($result_login) > 0)
		{
			if(mysql_result($result_login,0,"status") == "1" || mysql_result($result_login,0,"status") == "4")
			{
				$_SESSION['uid'] = mysql_result($result_login,0,"uid");
				$_SESSION['email'] = mysql_result($result_login,0,"email");
				$_SESSION['name'] = mysql_result($result_login,0,"name");
				$_SESSION['photo'] = mysql_result($result_login,0,"photo");
				if(mysql_result($result_login,0,"status") == "4")
					$_SESSION['isadmin'] = "true";
				else
					$_SESSION['isadmin'] = "false";
				if(strtolower(trim($isalive)) == "on")
					{
						$Month = 2592000 + time();
						//this adds 30 days to the current time
						setcookie("cookieeemail", $email, $Month);
						setcookie("cookieepassword", base64_encode($password), $Month);
					}
				header("location:$returnurl");
			}
			else
				$error = $messages["errorBlockedUser"];
		}
		else
			$error = $messages["errorWrongCredentials"];
	}
	else
		$error = $messages["errorNoCredentials"];
if(!strchr($returnurl,"?"))
	$returnurl .= "?";
else
	$returnurl .= "&";
if($error != "")		
	header("location:".$returnurl."error=".$error);
}

//Logout Function
//#############################################################
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "logout")
{
$_SESSION['uid'] = "";
$_SESSION['email'] = "";
$_SESSION['name'] = "";
$_SESSION['isadmin'] = "";
session_destroy();
$Month = time() - 2592000;
setcookie("cookieeemail", "", $Month);
setcookie("cookieepassword","",$Month);
header("location:index.php");
}

//Change Password Function
//#############################################################
if(isset($_POST['changepassword']))
{
	$oldpassword = $_POST['oldpassword'];
	$newpassword = $_POST['newpassword'];
	$cnewpassword = $_POST['cnewpassword'];
	$uuid = $_SESSION['uid'];
	if($cnewpassword == $newpassword)
	{
		$sql = mysql_query("select * from users where uid='$uuid' and password='$oldpassword'");
		if(mysql_num_rows($sql) > 0)
		{
			if(!mysql_query("update users set password='$newpassword' where uid='$uuid'"))
				header("location:changepassword.php?errormsg=Some Problem Occured. Password not changed.");
			else
				header("location:changepassword.php?successmsg=Password changed successfully!");
		}
		else
			header("location:changepassword.php?errormsg=Invalid Old Password");
	}
	else
		header("location:changepassword.php?errormsg=New Passwords Mis-match");
}

//Edit Profile Function
//#############################################################
if(isset($_POST['editprofile']))
{
	$uname = $_POST['uname'];
	$location = $_POST['location'];
	$country = $_POST['country'];
	$dob = $_POST['dob'];
		$splitdate = split("/",$dob);
		$dob = $splitdate[2]."/".$splitdate[0]."/".$splitdate[1];
	$uuid = $_SESSION['uid'];
	if(trim($uname) != "")
	{
		if(!mysql_query("update users set name='$uname', location ='$location', country='$country',dob='$dob' where uid='$uuid'"))
			header("location:editprofile.php?errormsg=Error changing data. Please try again..");
		else
		{
			$_SESSION['name'] = $uname;
			if(!empty($_FILES['userphoto'])) {
				include("lib/uploadfunctions.php");
				$tempFile = $_FILES['userphoto']['tmp_name'];
				$ext = strtolower(pathinfo($_FILES['userphoto']['name'], PATHINFO_EXTENSION));  //figures out the extension
				$newFileName = md5($tempFile.time()).'.'.$ext; //generates random filename, then adds the file extension
				$targetFile =  "userphotos/buffer/" .$newFileName;
				if(move_uploaded_file($tempFile,$targetFile))
				{
					smart_resize_image($targetFile,500,0,true,'file',false,false,$targetFile,false);
					header("location:cropphoto.php?successmsg=Edited Successfully.&file=$newFileName");
				}
				else
					header("location:editprofile.php?successmsg=Edited Successfully. No File Uploaded");
			}
			else
				header("location:editprofile.php?successmsg=Edited Successfully.");
		}
	}
	else
		header("location:editprofile.php?errormsg=Name cannot be empty.");
}

//Crop image Function
//#############################################################
if(isset($_POST['cropimage']))
{
$x = $_POST['x'];
$y = $_POST['y'];
$w = $_POST['w'];
$h = $_POST['h'];
$uuid = $_SESSION['uid'];
$photofile = $_POST['filename'];
	
	$pervsql = mysql_query("select photo from users where uid='$uuid'");
	$pervphoto = "";
	if(mysql_result($pervsql,0,"photo") != "defaultphoto.gif")
		$pervphoto = "userphotos/".mysql_result($pervsql,0,"photo");
	
$source = "userphotos/buffer/".$_POST['filename'];
$dest = "userphotos/".$_POST['filename'];
include("lib/cropfunction.php");
$crop = true;
if($_POST['keeporiginal'] == "on")
	$crop = false;
smart_crop( $source,100,$dest,$crop, $x, $y, $w, $h);
if(!mysql_query("update users set photo='$photofile' where uid='$uuid'"))
	header("location:editprofile.php?errormsg=File Not Uploaded");
else
	{
	$_SESSION['photo'] = $_POST['filename'];
		if($pervphoto != "")
			unlink($pervphoto);
		header("location:editprofile.php?successmsg=File Saved Successfully");
	}
}

//Download Album Function
//#############################################################
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "downloadalbum" && isset($_REQUEST['albumid']))
{
include("lib/zipfile.inc.php");
$albumid = $_REQUEST['albumid'];
$getalbumdetails = mysql_query("select * from photos where albumid='$albumid' and status='0' order by `order`,`photoid`");
$getalbuminfo = mysql_query("select * from albums where albumid='$albumid'");
$albumtype = mysql_result($getalbuminfo,0,"albumtypeid");
$authcode = mysql_result($getalbuminfo,0,"authcode");
$allow = true;
if(isset($_SESSION['uid']) && $_SESSION['uid'] != "")
{
	switch($albumtype)
	{
		case "1":
		break;
		
		case "2":
		if(isset($_REQUEST['authcode']))
		{
			if($_REQUEST['authcode'] != $authcode)
				$allow = false;
		}
		else
			$allow = false;
		break;
		
		case "3":
			if(isset($_SESSION['uid']) && $_SESSION['uid'] != "")
			{
				$checkifaccess = mysql_query("select * from albumfriends where userid='".$_SESSION['uid']."' and albumid='$albumid'");
				if(mysql_num_rows($checkifaccess) <= 0)
					$allow = false;
			}
			else
				$allow = false;
		break;
	}
}
else
	$allow = false;
if($allow == false && $_SESSION['isadmin'] != true)
{
		echo "<span style='color:red;'>No Access</span>";
		die();
}
if(mysql_num_rows($getalbumdetails) > 0)
{
$i = 0;
$file_names=array();
$searcharray = array("\\","/","*","?","\"",":","<",">","|",".");
$zippname = $albumid."_".mysql_result($getalbuminfo,0,"albumname");
$zippname = str_replace("  "," ",$zippname);
$zippname = str_replace(" ","_",$zippname);
$zippname = str_replace($searcharray,"#",$zippname);
$albumname = $zippname;
$zippname .= ".zip";
$file_path = "photos/download/";
$archive_file_name = "photos/archives/".$zippname;
		while($rowdata = mysql_fetch_array($getalbumdetails))
		{
			$url = "photos/download/".$rowdata["filename"];
			if(file_exists($url))
			{
			$file_names[$i] = $rowdata["filename"];
			}
		$i++;
		}
	if(sizeof($file_names) > 0)
	{
		$ip = getRealIpAddr();
		$userid = $_SESSION['uid'];
		$status = '0';
		if($_SESSION['isadmin'])
			$status = '1';
		mysql_query("insert into `downloadlog` (userid,ipaddress,file,status,downloadedtime) values ('$userid','$ip','$archive_file_name','$status',now())");
		if(!file_exists($archive_file_name))
		{
			$zipfile = new zipfile();  			
			// add the subdirectory ... important!
			$zipfile -> add_dir($albumname."/");
			
			// add the binary data stored in the string 'filedata'
			for($i = 0; $i < sizeof($file_names); $i++)
			{
				if(file_exists($file_path.$file_names[$i]))
				{
				$filedata = file_get_contents($file_path.$file_names[$i]);  
				$ext = strtolower(pathinfo($file_path.$file_names[$i], PATHINFO_EXTENSION)); 
				$filename = "Photo_".($i+1).".".$ext;
				$zipfile -> add_file($filedata, $albumname."/".$filename);  
				}
			}
			$f = fopen($archive_file_name,"a");
			fwrite($f,$zipfile -> file());
			fclose($f);
		}
		
			// the next three lines force an immediate download of the zip file:
			header("Content-type: application/zip");  
			header("Content-disposition: attachment; filename=".$archive_file_name);  
			header("Pragma: no-cache");
			header("Expires: 0");
			readfile("$archive_file_name");
	
		//zipFilesAndDownload($file_names,$archive_file_name,$file_path,$albumname);
	}
	else
		echo "No files to archive";
}
else
	echo "Album Not Found";
}

if($_SESSION['isadmin']=="true") //Admin Functions
{
//Create Album Function
//#############################################################
if(isset($_POST['createalbum']))
{
$albumtitle = trim(htmlentities($_POST['albumtitle'],ENT_QUOTES));
$albumdate = trim(htmlentities($_POST['albumdate'],ENT_QUOTES));
	$splitdate = split("/",$albumdate);
	$albumdate = $splitdate[2]."/".$splitdate[0]."/".$splitdate[1];
$albumdesc = trim(htmlentities($_POST['albumdesc'],ENT_QUOTES));
$albumlocation = trim(htmlentities($_POST['albumlocation'],ENT_QUOTES));
$albumtype = $_POST['albumtype'];
if($albumtitle != "" && $albumdate != "" && $albumtype != "")
{
	$authcode = md5("daniepaul".$albumtitle."Daniel");
	$addseq = "insert into albums (albumname, albumlocation,albumdescription, albumdate, albumtypeid, authcode) values ('$albumtitle','$albumlocation','$albumdesc','$albumdate','$albumtype','$authcode')";
	if(!mysql_query($addseq))
	{
		header("location:createalbum.php?errormsg=".$messages["errorCreatingAlbum"]);	
	}
	else
	{
		$albumid = mysql_insert_id();
		header("location:uploadphotos.php?albumid=$albumid");
	}
}
else
{
header("location:createalbum.php?errormsg=".$messages["errorMissingFormData"]);
}
}

//Adding Uploaded Photo Function
//#############################################################
if(isset($_POST['uploadphotos']))
{
$albumid = $_POST['albumid'];
$files = $_POST['files'];
$singlefiles = explode(",",$files);
$insertvalues = "";
	for($i=0; $i<sizeof($singlefiles);$i++)
	{
		if(trim($singlefiles[$i]) != "")
		{
			if(trim($insertvalues) != "")
			{
			$insertvalues .= ",";
			}
			$insertvalues .= "('".$albumid."','".$singlefiles[$i]."')";
		}
	}
	if(trim($insertvalues) != "")
	{
		$sql = "insert into `photos` (`albumid`,`filename`) values ".trim($insertvalues).";";
		if(!mysql_query($sql))
		{
			header("location:uploadphotos.php?albumid=".$albumid."&errormsg=".$messages["errorPhotoUpload"]);
		}
		else
		{
			header("location:reviewalbum.php?albumid=".$albumid);
		}
	}
	else
	{
		header("location:uploadphotos.php?albumid=".$albumid."&errormsg=".$messages["errorPhotoUploadNofile"]);
	}
}

//Adding New User Function
//#############################################################
if(isset($_POST['adduser']))
{
	$uname = $_POST['uname'];
	$uemail = $_POST['uemail'];
	$upassword = substr(rand(0,time()),0,5).substr(md5("daniepaul-daniel"),3,3).substr(rand(0,time()),6,2);
	$muserpage = $_POST['muserpage'];
	if(trim($uname) != "" && trim($uemail) != "")
	{
		$sql = mysql_query("select * from users where email='".trim($uemail)."'");
		if(mysql_num_rows($sql) == 0)
		{
			if(!mysql_query("insert into users (name,email,password) values ('$uname','$uemail','$upassword')"))
				header("location:manageusers.php?muserpage=$muserpage&errormsg=".$messages["errorAddingUser"]);
			else
				header("location:manageusers.php?muserpage=$muserpage&successmsg=Added Successfully");
		}
		else
			header("location:manageusers.php?muserpage=$muserpage&errormsg=".$messages["errorEmailInUse"]);
	}
	else
		header("location:manageusers.php?muserpage=$muserpage&errormsg=".$messages["errorMissingFormData"]);
}

//Editing User Function
//#############################################################
if(isset($_POST['edituser']))
{
	$uname = $_POST['uname'];
	$uemail = $_POST['uemail'];
	$upassword = $_POST['upassword'];
	$muserpage = $_POST['muserpage'];
	$uuid = $_POST['uuid'];
	if(trim($uname) != "" && trim($uemail) != "")
	{
		if(trim($upassword) != "")
			$q = "update users set name='$uname',email='$uemail',password='$upassword' where uid='$uuid'";
		else
			$q = "update users set name='$uname',email='$uemail' where uid='$uuid'";
			if(!mysql_query($q))
				header("location:manageusers.php?muserpage=$muserpage&uid=$uid&errormsg=".$messages["errorAddingUser"]);
			else
				header("location:manageusers.php?muserpage=$muserpage&uid=$uid&successmsg=Edited Successfully");

	}
	else
		header("location:manageusers.php?muserpage=$muserpage&uid=$uid&errormsg=".$messages["errorMissingEditData"]);
}

//Edit Album Function
//#############################################################
if(isset($_POST['editalbum']))
{
$albumtitle = trim(htmlentities($_POST['albumtitle'],ENT_QUOTES));
$albumdate = trim(htmlentities($_POST['albumdate'],ENT_QUOTES));
	$splitdate = split("/",$albumdate);
	$albumdate = $splitdate[2]."/".$splitdate[0]."/".$splitdate[1];
$albumdesc = trim(htmlentities($_POST['albumdesc'],ENT_QUOTES));
$albumlocation = trim(htmlentities($_POST['albumlocation'],ENT_QUOTES));
$albumtype = $_POST['albumtype'];
$albumid = $_POST['albumid'];
if($albumtitle != "" && $albumdate != "" && $albumtype != "")
{
	$addseq = "update albums set albumname='$albumtitle',albumlocation='$albumlocation',albumdescription='$albumdesc',albumdate='$albumdate',albumtypeid='$albumtype' where albumid='$albumid'";
	if(!mysql_query($addseq))
	{
		header("location:editalbum.php?errormsg=".$messages["errorCreatingAlbum"]);	
	}
	else
	{
		header("location:reviewalbum.php?albumid=$albumid");
	}
}
else
{
header("location:editalbum.php?errormsg=".$messages["errorMissingFormData"]);
}
}

//Share With Friends Function
//#############################################################
if(isset($_POST['sharefriends']))
{
$albumid = $_POST['albumid'];
$friends = explode(",",$_POST['friends']);
$fromemail = FROMEMAILADDRESS;
$albumresult = mysql_query("select * from albums where albumid='$albumid' and status='0'");
	if(mysql_num_rows($albumresult) > 0)
	{
	$albumtypeid = mysql_result($albumresult,0,"albumtypeid");
	$authcode = mysql_result($albumresult,0,"authcode");
	$albumdescription = mysql_result($albumresult,0,"albumdescription");
	$albumlocation = mysql_result($albumresult,0,"albumlocation");
	$albumdate = date("M j, Y",strtotime(mysql_result($albumresult,0,"albumdate")));
	$albumname = mysql_result($albumresult,0,"albumname");
	$coverphoto = mysql_result($albumresult,0,"albumcoverphoto");
	$url = BASEDIR."photos.php?album=".$albumid;
		switch($albumtypeid)
		{
		case "1":
			$url .= "&authentication=open";
		break;
		
		case "2":
			$url .= "&authcode=".$authcode;
			$url .= "&authentication=signin&share=closed";
		break;
		
		case "3":
			$url .= "&authentication=signin&share=closed";
		break;
		}
	$message = generateinvite($url,$coverphoto,$albumname,$albumdate,$albumlocation,$albumdescription);
	$subject = $messages["albuminvitemailsubject"].$albumname;
	$sendMailStatus = true;
	$addingtodb = true;
	for($i=0; $i<sizeof($friends); $i++)
	{
		if(trim($friends[$i]) != "")
		{
			$friendid = $friends[$i];
			$getfrienddetails = mysql_query("select * from users where uid='".$friends[$i]."' and status='1'");
			if(mysql_num_rows($getfrienddetails) > 0)
			{
				if(mysql_num_rows(mysql_query("select * from albumfriends where albumid='$albumid' and userid='$friendid'")) == 0)
				{
					if(!mysql_query("insert into albumfriends (albumid,userid) values ('$albumid','$friendid')"))
					{
						$addingtodb = false;
					}
					else
					{
					$friendname = mysql_result($getfrienddetails,0,"name");
					$friendemail = mysql_result($getfrienddetails,0,"email");
						if(!sendemail($fromemail,$friendemail,$subject,$message))
						{
							$sendMailStatus = false;
						}
					}
				}
			}
		}
	}
	if(!$addingtodb)
		header("location:share.php?albumid=".$albumid."&errormsg=".$messages["errorAddingUser"]);
	elseif(!$sendMailStatus)
		header("location:share.php?albumid=".$albumid."&errormsg=".$messages["errorSendingMail"]);
	else
		header("location:share.php?albumid=".$albumid."&successmsg=Sharing Success!!! You Can Share More People");
	}
	else
		header("location:share.php?albumid=".$albumid."&errormsg=".$messages["errorInvalidAlbum"]);
}

//Edit Page Function
//#############################################################
if(isset($_POST['editpage']))
{
$title = $_POST['pagetitle'];
$content = $_POST['content'];
$pageid = $_POST['pageid'];
if(trim($title) != "")
{
	if(!mysql_query("update pages set title='$title', content='$content' where pageid='$pageid'"))
		header("location:editpage.php?id=$pageid&errormsg=Cannot Save Data. Please try again.");
	else
		header("location:managepages.php?successmsg=Data Edited Successfully!!!");
}
else
	header("location:editpage.php?id=$pageid&errormsg=Title can`t be empty. Re-enter Data");
}

//Activate User Function
//#############################################################
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "activateuser")
{
$auth = base64_decode($_REQUEST['authcode']);
$user = $_REQUEST['user'];
if($user == $auth)
{
$upassword = substr(rand(0,time()),0,5).substr(md5("daniepaul-daniel"),3,3).substr(rand(0,time()),6,2);
mysql_query("update users set password='$upassword' where uid='$user'");
$result = mysql_query("select * from users where uid='$user'");
	if(mysql_num_rows($result) > 0)
	{
		$to = mysql_result($result,0,"email");
		$name = mysql_result($result,0,"name");
		$password = mysql_result($result,0,"password");
		$fromemail = FROMEMAILADDRESS;
		$message = "Dear $name,<br/><br/>I have started my own web album and i would like you to be there in my site. Below are the login details for my site. I registered you because i don't want you to be troubled with a registration. :)<br/><br/>  Email Address : <b>$to</b><br/>  Password : <b>$password</b><br/>  Site url: <a href='".BASEDIR."' target='_blank'>".BASEDIR."</a><br/><br/>Hope to see you soon in my site.<br/><br/>With Regards,<br/>Daniepaul.";
		$subject = "### FROM Daniepaul Web Album ### Login Details of my wesite.";
		if(!mysql_query("update users set status='1' where uid='$user'"))
			header("location:manageusers.php?errormsg=User Activation Failed");
		else
		{
			if(!sendemail($fromemail,$to,$subject,$message))
			{
				header("location:manageusers.php?errormsg=Mail Sending Failed");
			}
			else
			{
				header("location:manageusers.php?successmsg=User Activated Successfully");
			}
		}
	}
	else
		header("location:manageusers.php?errormsg=User Not Available");
}
}

//Delete Album
//#############################################################
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "deletealbum")
{
$auth = base64_decode($_REQUEST['auth']);
$id = $_REQUEST['id'];
if($id == $auth)
{
	$sql_selectphotos = mysql_query("select * from photos where albumid='$id'");
	if(mysql_num_rows($sql_selectphotos) > 0)
	{
		while($row_data = mysql_fetch_array($sql_selectphotos))
		{
			if($row_data['filename'] != "")
			{
				if(file_exists("photos/thumbnails/".$row_data['filename']))
						unlink("photos/thumbnails/".$row_data['filename']);
				if(file_exists("photos/medium/".$row_data['filename']))
						unlink("photos/medium/".$row_data['filename']);
				//if(file_exists("photos/download/".$row_data['filename']))
						//unlink("photos/download/".$row_data['filename']);
				if(file_exists("photos/original/".$row_data['filename']))
						unlink("photos/original/".$row_data['filename']);
			}
		}
	}
	if(!mysql_query("delete from albums where albumid='$id'"))
		header("location:managealbums.php?errormsg=Problem in deleting the album.");
	else
		header("location:managealbums.php?successmsg=Album Deleted Successfully.");	
}
}

//Delete User
//#############################################################
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "deleteuser")
{
$auth = base64_decode($_REQUEST['auth']);
$id = $_REQUEST['id'];
if($id == $auth)
{
	if(!mysql_query("delete from users where uid='$id'"))
		header("location:manageusers.php?errormsg=Problem in deleting the album.");
	else
		header("location:manageusers.php?successmsg=Album Deleted Successfully.");	
}
}

//Block User Function
//#############################################################
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "blockuser")
{
$auth = base64_decode($_REQUEST['authcode']);
$user = $_REQUEST['user'];
$status = $_REQUEST['status'];
$block = 3;
if($status == "3")
	$block = 1;
if($user == $auth)
{
$result = mysql_query("select * from users where uid='$user'");
	if(mysql_num_rows($result) > 0)
	{
		if(!mysql_query("update users set status='$block' where uid='$user'"))
			header("location:manageusers.php?errormsg=User Activation Failed");
		else
			header("location:manageusers.php");
	}
	else
		header("location:manageusers.php?errormsg=User Not Available");
}
}

}
include("includes/closedb.php");
?>