<?php
if(isset($_REQUEST['rand']))
{
include_once("config.php");
include_once("includes/opendb.php");
}
$columns = 4;
$rows = 5;
$where = "";

if(isset($_REQUEST['album']))
{
$albumid = $_REQUEST['album'];
$albumdetailssql = "select * from albums where albumid='$albumid' and status='0'";
$resultalbumdetail = mysql_query($albumdetailssql);
if(mysql_num_rows($resultalbumdetail) > 0)
{
?>
<div class="albuminfo"><br />
<div class="titlediv"><div class="l"><div class="r"><div class="t">Album Info</div></div></div></div><br/>
<center><img src="albumview.php?id=<?php echo base64_encode(mysql_result($resultalbumdetail,0,"albumcoverphoto")); ?>" alt=""  /><br /><b><?php echo strtolower(mysql_result($resultalbumdetail,0,"albumname")); ?></b></center><br />Location:<i><?php echo mysql_result($resultalbumdetail,0,"albumlocation"); ?></i><br/>
<?php if(GOOGLEMAPS == "true") { ?><div id="map_canvas" style="width: 220px; height: 220px; overflow:hidden" class="gmapclass"></div>
<script type="text/javascript"> 
     var map = null;
    var geocoder = null;
	var address = "<?php echo mysql_result($resultalbumdetail,0,"albumlocation"); ?>";
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_canvas"));
		geocoder = new GClientGeocoder();
        if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
			document.getElementById("map_canvas").innerHTML = "Not able to map the location";
			document.getElementById("map_canvas").style.height = "auto";
			document.getElementById("map_canvas").style.color = "black";
            } else {
              map.setCenter(point, 15);
              var marker = new GMarker(point);
              map.addOverlay(marker);
            }
          }
        );
      }
      }
</script>
<?php }?>
<br /><?php echo mysql_result($resultalbumdetail,0,"albumdescription"); ?>
</div>

<?php }?>
<?php }

if(isset($_REQUEST['rand']))
{
include_once("includes/closedb.php");
}
?>
 