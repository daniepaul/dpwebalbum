<?php
ob_start();
session_start();
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
define("KEYWORDS", "colourz, photos");
define("DESCRIPTION", "Colourz Web album");
define("WEBMASTER","services@thecolourz.com");
define("TITLE", "ColourzAlbum");

//Location Definations
define("BASEDIR","http://localhost/webalbum/");
define("FILE_UPLOAD_LOCATION",BASEDIR."uploadFile/");
define("IMAGEPATH",BASEDIR."images/");
define("THEME","default");

//Global Definations
define("TITLEDISPLAYCOUNT",150);
define("FROMEMAILADDRESS","me@daniepaul.com");

define("COPYRIGHTYEAR","2015");
define("COPYRIGHTNAME","daniepaul.com");

define("GOOGLEMAPS","false");
define("GOOGLEMAPSAPIKEY","KEY");

//All messages
include('lib/messages.php');
include('lib/userfunctions.php');
?>