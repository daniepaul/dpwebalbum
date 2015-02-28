<?PHP 
session_start();
ob_start();
global $configuration;
date_default_timezone_set("Asia/Calcutta");
//  DataBase Variables declars 
$configuration['host'] = 'localhost';
$configuration['user'] = 'root';
$configuration['pass'] ='';
$configuration['db'] = 'colourzwebalbums';

//Generic Definations
define("SITE_NAME", "The Colourz Web Albums");
define("AUTHOR", "Colourz Technologies Private Limited");
define("SITE_OWNER", "www.thecolourz.com");
define("KEYWORDS", "angelegna, angel ,personal site, photos");
define("DESCRIPTION", "Angelegna is the personal site of Angel D. Suresh");
define("WEBMASTER","services@thecolourz.com");
define("TITLE", "ColourzAlbum");

//Location Definations
define("BASEDIR","http://localhost/ca/mobile/");
define("BASEDIRLINK","http://localhost/ca/");
define("FILE_UPLOAD_LOCATION",BASEDIR."uploadFile/");
define("IMAGEPATH",BASEDIR."images/");
define("THEME","angel");

//Global Definations
define("TITLEDISPLAYCOUNT",150);
define("FROMEMAILADDRESS","angel@angelegna.com");

define("COPYRIGHTYEAR","2009");
define("COPYRIGHTNAME","www.thecolourz.com");

define("GOOGLEMAPS","false");
define("GOOGLEMAPSAPIKEY","ABQIAAAA9u4Hk7vTh_KnhbivPY2fxRSJ6AlPoY4vheG_rQySbS08svioixStJTyqGbqjRsOeMkssCTPkJcmEEQ");

//All messages
include('messages.php');
include('userfunctions.php');
?>