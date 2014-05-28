<?php
session_start();
if ($_SESSION['auth_admin'] == "yes_auth")
{
	define('myeshop', true);
       
       if (isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }

  $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='orders.php' >Заказы</a>";
  
  include("include/db_connect.php");
  include("include/functions.php"); 
   
   $sort = $_GET["sort"];
   switch ($sort) {

	    case 'all-orders':

	    $sort = "order_id DESC";
        $sort_name = 'От А до Я';

	    break;

	    case 'confirmed':

	    $sort = "order_confirmed = 'yes' DESC";
        $sort_name = 'Обработаные';

	    break;

	    case 'no-confirmed':

	    $sort = "order_confirmed = 'no' DESC";
        $sort_name = 'Не обработаные';

	    break;
        
	    default:
        
        $sort = "order_id DESC";
        $sort_name = 'От А до Я';
        
	    break;

	}    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="jquery_confirm/jquery_confirm.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
    <script type="text/javascript" src="js/script.js"></script> 
    <script type="text/javascript" src="jquery_confirm/jquery_confirm.js"></script> 
    
	<title>Панель Управления - Заказы</title>
</head>
<body>
<div id="block-body">
<?php
	include("include/block-header.php");
    
 $all_count = mysql_query("SELECT * FROM orders",$link);
 $all_count_result = mysql_num_rows($all_count);

 $buy_count = mysql_query("SELECT * FROM orders WHERE order_confirmed = 'yes'",$link);
 $buy_count_result = mysql_num_rows($buy_count);

 $no_buy_count = mysql_query("SELECT * FROM orders WHERE order_confirmed = 'no'",$link);
 $no_buy_count_result = mysql_num_rows($no_buy_count); 
 
?>
<div id="block-content">
<div id="block-parameters">
<ul id="options-list">
<li>Сортировать</li>
<li><a id="select-links" href="#"><? echo $sort_name; ?></a>
<ul id="list-links-sort">
<li><a href="orders.php?sort=all-orders">От А до Я</a></li>
<li><a href="orders.php?sort=confirmed">Обработаные</a></li>
<li><a href="orders.php?sort=no-confirmed">Не обработаные</a></li>

</ul>
</li>
</ul>
</div>
<div id="block-info">
<ul id="review-info-count">
<li>Всего заказов - <strong><? echo $all_count_result; ?></strong></li>
<li>Обработаных - <strong><? echo $buy_count_result; ?></strong></li>
<li>Не обработаных - <strong><? echo $no_buy_count_result; ?></strong></li>

</ul>
</div>
<?php
	$result = mysql_query("SELECT * FROM orders ORDER BY $sort",$link);
 
 If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{
if ($row["order_confirmed"] == 'yes')
{
    $status = '<span class="green">Обработан</span>';
} else
{
    $status = '<span class="red">Не обработан</span>';    
}
  
 echo '
 <div class="block-order">
 
  <p class="order-datetime" >'.$row["order_datetime"].'</p>
  <p class="order-number" >Заказ № '.$row["order_id"].' - '.$status.'</p>
  <p class="order-link" ><a class="green" href="view_order.php?id='.$row["order_id"].'" >Подробнее</a></p>
 </div>
 ';   
    
} while ($row = mysql_fetch_array($result));
}
?>
</div>
</div>
</body>
</html>
<?php
}else
{
    header("Location: login.php");
}
?>