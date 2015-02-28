<?php
$f = fopen("http://www.facebook.com/feeds/notifications.php?id=525110089&viewer=525110089&key=52d5787916&format=rss20","r");
$r = stream_get_contents($f);
echo $r;
?>
