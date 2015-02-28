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
	var url = "reviewphotos.php?album="+albumId+"&reviewpage="+page+"&rand="+setunique();
	
	xmlHttp=GetXmlHttpObject();
	   if (xmlHttp==null){
  		 alert ("Your browser does not support AJAX!");
		  return;
	   }	
	   document.getElementById("reviewalbum").innerHTML = "<table width='220' height='150' style='background-image:url(images/loader.gif); background-position:center center;'><tr><td valign='bottom'><center><span style='font-size:8pt; color:#cccccc'>If it takes too much of time. <a onclick=\"getPage('"+page+"','"+albumId+"')\">Click here</a> to load again.</span></center></td></tr></table>";
		xmlHttp.onreadystatechange=function stateChangedgetchat(){ 
		if (xmlHttp.readyState==4){ 
				if(xmlHttp.responseText != "")
				{
				 getvalue = xmlHttp.responseText;
				 document.getElementById("reviewalbum").innerHTML = getvalue;
				}
			}
		};
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}

function rotate(file,angle,id)
{
	var url = 'rotate.php?file='+file+'&angle='+angle+'&rand='+setunique();
	
	xmlHttp=GetXmlHttpObject();
	   if (xmlHttp==null){
  		 alert ("Your browser does not support AJAX!");
		  return;
	   }	
	   document.getElementById(id).innerHTML = "<table width='100%' height='150' style='background-image:url(images/loader.gif); background-position:center center;'><tr><td valign='bottom'>&nbsp</td></tr></table>";
		xmlHttp.onreadystatechange=function stateChangedgetchat(){ 
		if (xmlHttp.readyState==4){ 
				if(xmlHttp.responseText != "")
				{
				 getvalue = xmlHttp.responseText;
				 document.getElementById(id).innerHTML = getvalue;
				}
			}
		};
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}

function deletephotos(photoid,id)
{
	var url = 'deletephoto.php?photoid='+photoid+'&rand='+setunique();
if(confirm("Are you sure you wanna delete?"))
{
	xmlHttp=GetXmlHttpObject();
	   if (xmlHttp==null){
  		 alert ("Your browser does not support AJAX!");
		  return;
	   }	
	   document.getElementById(id).innerHTML = "<table width='100%' height='150' style='background-image:url(images/loader.gif); background-position:center center;'><tr><td valign='bottom'>&nbsp</td></tr></table>";
		xmlHttp.onreadystatechange=function stateChangedgetchat(){ 
		if (xmlHttp.readyState==4){ 
				if(xmlHttp.responseText != "")
				{
				 getvalue = xmlHttp.responseText;
				 //alert(getvalue);
				 if(getvalue.split(' ').join('').split('\n').join('').split('\r').join('') != '#')
				 {
					 obj = document.getElementById("reviewalbum");
					 remobj = document.getElementById(id);
					 obj.removeChild(remobj);
				 }
				 else
				 {
					 document.getElementById(id).innerHTML = getvalue;
				 }
				}
			}
		};
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}
else
{
	return false;
}
}

function savecaption(id,textid,status)
{
	var commenttext = document.getElementById(textid).value;
	var checktext = commenttext.split(' ').join('');
	checktext = checktext.split('\n').join('');
	if(checktext != "")
	{
	commenttext = commenttext.replace(/\n/g,"<br/>");
	commenttext = commenttext.replace(/&/g,"<~and~>");
	commenttext = commenttext.replace(/#/g,"<~hash~>");
	
	var url = 'savecaption.php?photoid='+id+'&caption='+commenttext+'&rand='+setunique();
	xmlHttp=GetXmlHttpObject();
	   if (xmlHttp==null){
  		 alert ("Your browser does not support AJAX!");
		  return;
	   }	
	   document.getElementById(status).innerHTML = "<table width='25' height='25' style='background-image:url(images/small_loader.gif); background-position:center center;'><tr><td valign='bottom'>&nbsp</td></tr></table>";
		xmlHttp.onreadystatechange=function stateChangedgetchat(){ 
		if (xmlHttp.readyState==4){ 
				if(xmlHttp.responseText != "")
				{
				 getvalue = xmlHttp.responseText;
				 if(getvalue.split(' ').join('').split('\n').join('').split('\r').join('') == '#')
				 {
					 document.getElementById(status).innerHTML = "<img src='images/tick.gif' alt='' class='reset' /> Saved.";
				 }
				 else
				 {
					 document.getElementById(status).innerHTML = "<span style='color:red'>Failed</span>";
					 document.getElementById(textid).value = "";
				 }
				}
			}
		};
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
}