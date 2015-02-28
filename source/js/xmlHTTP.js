var thumbnailDiv;
var displayDiv;
var initialshow = false;

function GetXmlHttpObject() {
  var xmlhttp;
  /*@cc_on
  @if (@_jscript_version >= 5)
    try {
      xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (E) {
        xmlhttp = false;
      }
    }
  @else
  xmlhttp = false;
  @end @*/
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    try {
      xmlhttp = new XMLHttpRequest();
    } catch (e) {
      xmlhttp = false;
    }
  }
  return xmlhttp;
}

function setunique()
{
date = new Date(); 
ms = (date.getHours() * 24 * 60 * 1000) + (date.getMinutes() * 60 * 1000) + (date.getSeconds() * 1000) + date.getMilliseconds(); 
return ms;
}

function getPage(page,albumId)
{
	var url = "showthumbs.php?album="+albumId+"&thumbpage="+page+"&rand="+setunique();
	
	xmlHttp=GetXmlHttpObject();
	   if (xmlHttp==null){
  		 alert ("Your browser does not support AJAX!");
		  return;
	   }	
	   document.getElementById(thumbnailDiv).innerHTML = "<table width='220' height='150' style='background-image:url(images/loader.gif); background-position:center center;'><tr><td valign='bottom'><center><span style='font-size:8pt; color:#cccccc'>If it takes too much of time. <a onclick=\"getPage('"+page+"','"+albumId+"')\">Click here</a> to load again.</span></center></td></tr></table>";
		xmlHttp.onreadystatechange=function stateChangedgetchat(){ 
		if (xmlHttp.readyState==4){ 
				if(xmlHttp.responseText != "")
				{
				 getvalue = xmlHttp.responseText;
				 document.getElementById(thumbnailDiv).innerHTML = getvalue;
				}
			}
		};
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}

function getPhoto(PhotoId)
{
	if(!initialshow)
	window.location.href = "#photo="+PhotoId;
	else
	initialshow = false;
	var url = "showphoto.php?photo="+PhotoId+"&rand="+setunique();
	
	xmlHttp2=GetXmlHttpObject();
	   if (xmlHttp2==null){
  		 alert ("Your browser does not support AJAX!");
		  return;
	   }
	   document.getElementById(displayDiv).innerHTML = "<img src='images/loader.gif' alt='Loading...' />";
		xmlHttp2.onreadystatechange=function stateChangedgetchat(){ 
		if (xmlHttp2.readyState==4){ 
				if(xmlHttp2.responseText != "")
				{
				 getvalue = xmlHttp2.responseText;
				 document.getElementById(displayDiv).innerHTML = getvalue;
				}
			}
		};
		xmlHttp2.open("GET",url,true);
		xmlHttp2.send(null);	
}
function postcomment()
{
	var commenttext = document.getElementById("commenttext").value;
	commenttext = commenttext.replace(/\n/g,"<br/>");
	commenttext = commenttext.replace(/&/g,"<~and~>");
	commenttext = commenttext.replace(/#/g,"<~hash~>");
	//commenttext = commenttext.replace(/?/g,"<~qmark~>");
	var photoid = document.getElementById("photoid").value;
	var url = "addcomment.php?photoid="+photoid+"&commenttext="+commenttext+"&rand="+setunique();
	xmlHttp3=GetXmlHttpObject();
	   if (xmlHttp3==null){
  		 alert ("Your browser does not support AJAX!");
		  return;
	   }
	   document.getElementById("addcommentdiv").innerHTML = "<table width='250' height='80' style='background-image:url(images/loader.gif); background-position:center center;'><tr><td>&nbsp;</td></tr></table>";
		xmlHttp3.onreadystatechange=function stateChanged(){ 
		if (xmlHttp3.readyState==4){ 

				if(xmlHttp3.responseText != "")
				{
					 getPhoto(photoid);
		 
				}
			}
		};
		xmlHttp3.open("GET",url,true);
		xmlHttp3.send(null);	
}