<?php 
$landingpage = "index";
include("includes/header.php"); ?><br />
<script type="text/javascript">
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

function getfacebookStatus()
{
	var url = "facebookstatus.php?rand="+setunique();
	
	xmlHttp=GetXmlHttpObject();
	   if (xmlHttp==null){
		  return false;
	   }	
		xmlHttp.onreadystatechange=function stateChangedgetchat(){ 
		if (xmlHttp.readyState==4){ 
				if(xmlHttp.responseText != "")
				{
				 getvalue = xmlHttp.responseText;
				 var splitv = getvalue.split('<span class="entry-content">');
				 var fina = splitv[1].split('</span>');
				 document.getElementById("facebookstatus").innerHTML = fina[0];
				}
			}
		};
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}
</script>
<br />
<br />
<br />
<center>
  <table class="birthday" width="100%" cellspacing="15">
    <tr>
      <td width="25%" align="center"><a href="about.php"><img src="themes/<?php echo THEME; ?>/images/about.jpg" alt="About Me" border="0" /><div class="titlediv"><div class="l"><div class="r"><div class="t">About Me</div></div></div></div></a></td>
      <td width="25%" align="center"><a href="interest.php"><img src="themes/<?php echo THEME; ?>/images/interest.jpg" alt="About Me" border="0" /><div class="titlediv"><div class="l"><div class="r"><div class="t">My Interests</div></div></div></div></a></td>
      <td width="25%" align="center"><a href="gallery.php"><img src="themes/<?php echo THEME; ?>/images/gallery.jpg" alt="Gallery" border="0" /><div class="titlediv"><div class="l"><div class="r"><div class="t">Gallery</div></div></div></div></a></td>
      <td width="25%" align="center"><a href="blog.php"><img src="themes/<?php echo THEME; ?>/images/blog.jpg" alt="Blog" border="0" /><div class="titlediv"><div class="l"><div class="r"><div class="t">My Blog</div></div></div></div></a></td>
    </tr>
        <tr>
      <td colspan="4" align="center"><div align="center" id="facebookstatus"></div></td>
    </tr>
    <?php
$todayday = date("d");
$todaymonth = date("m");
$birthday = mysql_query("select * from users where (MONTH(`dob`) = MONTH(now()) and DAY(`dob`) = DAY(now()))");
if(mysql_num_rows($birthday)>0) {
?>
    <tr>
      <td colspan="4" align="center"><div align="center" id="facebookstatus"></div></td>
    </tr>
    <?php } ?>
  </table>
</center>
<!--<script type="text/javascript">getfacebookStatus();</script>-->
<?php include("includes/footer.php"); ?>
