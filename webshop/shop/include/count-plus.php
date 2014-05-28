<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
define('myeshop', true);  
include("db_connect.php");
include("../functions/functions.php");

$id = clear_string($_POST["id"]);

$result = mysql_query("SELECT * FROM cart WHERE cart_id = '$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);    
$new_count = $row["cart_count"] + 1;
$update = mysql_query ("UPDATE cart SET cart_count='$new_count' WHERE cart_id='$id' AND cart_ip = '{$_SERVER['REMOTE_ADDR']}'",$link);
echo $new_count;    
}
}
?>