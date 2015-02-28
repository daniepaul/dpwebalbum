<?php
include("config.php");
include("opendb.php");

//Login Function
//#############################################################
if(isset($_POST['login']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];
	$isalive = $_POST['isalive'];
	$error = "";

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
				header("location:index.php");
			}
			else
				$error = $messages["errorBlockedUser"];
		}
		else
			$error = $messages["errorWrongCredentials"];
	}
	else
		$error = $messages["errorNoCredentials"];
if($error != "")		
	header("location:index.php?error=".$error);
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

include("closedb.php");
?>