<?php
 if($_SERVER["REQUEST_METHOD"] == "POST")
{
 define('myeshop', true);
 include("db_connect.php");
 include("../functions/functions.php");

 $search = iconv("UTF-8", "cp1251",strtolower(clear_string($_POST['text'])));
 
 $result = mysql_query("SELECT * FROM table_products WHERE title LIKE '%$search%' AND visible = '1'",$link);
 
 If (mysql_num_rows($result) > 0)
{
$result = mysql_query("SELECT * FROM table_products WHERE title LIKE '%$search%'  AND visible = '1' LIMIT 10",$link);
$row = mysql_fetch_array($result);
do
{
echo '
<li><a href="search.php?q='.$row["title"].'">'.$row["title"].'</a></li>
';
}
 while ($row = mysql_fetch_array($result));

}
 }



?>