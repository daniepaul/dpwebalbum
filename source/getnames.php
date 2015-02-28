<?php 
include_once("config.php");
include_once("includes/opendb.php");
if(isset($_REQUEST['q']))
{
$q = $_REQUEST['q'];
$table = array("users");
$ids = array("uid","fid");
$values = "";
for($i=0; $i<sizeof($table); $i++)
{
$where = "";
if($ids[$i] == "fid") $where = " and `uid` IS NULL";
$sql = "select ".$ids[$i].",name,email from `".$table[$i]."` where name like '%$q%' and email like '%$q%' $where";
$result=mysql_query($sql);
if(mysql_num_rows($result) > 0)
{
while($row = mysql_fetch_array($result)) { 
$id = $row[$ids[$i]];
if($values != "") $values .= ',';
$values .= '{"id":"'.$id.'","name":"'.$row['name'].' -<i> '.$row['email'].'</i>"}';
}
} } 
 echo '['.$values.']';
 } else { ?>
No values
<?php } 
include_once("includes/closedb.php");
?>