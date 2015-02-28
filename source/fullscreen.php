<?php
include_once("config.php");
$returnpath = 'index.php';
if(isset($_REQUEST['albumid']))
{
$returnpath = 'photos.php?album='.$_REQUEST['albumid'];
$albumid = $_REQUEST['albumid'];
$rand = rand(0,time());
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo SITE_NAME; ?></title>
<script type="text/javascript" src="<?php echo BASEDIR; ?>js/swfobject.js"></script>
<style type="text/css">	
	/* hide from ie on mac \*/
	html {
		height: 100%;
		overflow: hidden;
	}	
	#flashcontent {
		height: 100%;
	}
	/* end hide */
	body {
		height: 100%;
		margin: 0;
		padding: 0;
		background-color: #181818;
		color:#ffffff;
		font-family:sans-serif;
		font-size:20;
	}	
	a {	
		color:#cccccc;
	}
</style>
</head>
<body>
<a href="<?php echo $returnpath; ?>" style="float:left; position:absolute; z-index:1001;">Back to album</a>
	<div id="flashcontent">AutoViewer requires JavaScript and the Flash Player. <a href="http://www.macromedia.com/go/getflashplayer/">Get Flash here.</a> </div>	
	<script type="text/javascript">
		var fo = new SWFObject("swf/autoviewer.swf", "Fullscreen Viewer", "100%", "100%", "8", "#181818");		
				
		//Optional Configuration
		//fo.addVariable("langOpenImage", "");
		//fo.addVariable("langAbout", "About");	
		fo.addVariable("xmlURL", "fullscreen_xml.php?albumid=<?php echo $albumid; ?>&rand=<?php echo $rand; ?>");					
		
		fo.write("flashcontent");	
		
	</script>	
</body>
</html>