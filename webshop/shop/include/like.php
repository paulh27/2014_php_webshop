<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
define('myeshop', true);    
session_start();
if ($_SESSION['likeid'] != (int)$_POST["id"])
{
	 include("db_connect.php");
  
     $id = (int)$_POST["id"];	
	
$result = mysql_query("SELECT * FROM table_products WHERE products_id = '$id'",$link);
If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result); 
   
$new_count = $row["yes_like"] + 1;
$update = mysql_query ("UPDATE table_products SET yes_like='$new_count' WHERE products_id='$id'",$link);
echo $new_count;
   
}
$_SESSION['likeid'] = (int)$_POST["id"]; 
}
else
{
    echo 'no';
}
}
?>