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

  $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='tovar.php' >Товары</a>";
  
  include("include/db_connect.php");
  include("include/functions.php"); 
   
$cat = $_GET["cat"]; 
$type = $_GET["type"]; 
 
if (isset($cat))
{
   switch ($cat) {

	    case 'all':

        $cat_name = 'Все товары';
        $url = "cat=all&";
	    $cat = ""; 
              

	    break;

	    case 'mobile':

        $cat_name = 'Мобильные телефоны';
        $url = "cat=mobile&";
	    $cat = "WHERE type_tovara='mobile'"; 
             

	    break;
        
	    case 'notebook':

        $cat_name = 'Ноутбуки';
        $url = "cat=notebook&";
	    $cat = "WHERE type_tovara='notebook'"; 
             

	    break; 
        
	    case 'notepad':

        $cat_name = 'Планшеты';
        $url = "cat=notepad&";
	    $cat = "WHERE type_tovara='notepad'"; 
             

	    break;                
        
	    default:
        
        $cat_name = $cat;
     
        $url = "type=".clear_string($type)."&cat=".clear_string($cat)."&";
        $cat = "WHERE type_tovara='".clear_string($type)."' AND brand='".clear_string($cat)."'"; 
        
             
	    break;

	} 
    
}
else
{
        $cat_name = 'Все товары';
        $url = "";
        $cat = "";        
} 


$action = $_GET["action"];
if (isset($action))
{
   $id = (int)$_GET["id"]; 
   switch ($action) {

	    case 'delete':
   if ($_SESSION['delete_tovar'] == '1')
   {

           $delete = mysql_query("DELETE FROM table_products WHERE products_id = '$id'",$link);  
    
   }else
   {
      $msgerror = 'У вас нет прав на удаление товаров!';
   }
	    break;
        
	} 
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
    
	<title>Панель Управления</title>
</head>
<body>
<div id="block-body">
<?php
	include("include/block-header.php");
    
 $all_count = mysql_query("SELECT * FROM table_products",$link);
 $all_count_result = mysql_num_rows($all_count);
?>
<div id="block-content">
<div id="block-parameters">
<ul id="options-list">
<li>Товары</li>
<li><a id="select-links" href="#"><? echo $cat_name; ?></a>
<div id="list-links" >
<ul>
<li><a href="tovar.php?cat=all"><strong>Все товары</strong></a></li>
<li><a href="tovar.php?cat=mobile"><strong>Телефоны</strong></a></li>
<?php


 $result1 = mysql_query("SELECT * FROM category WHERE type='mobile'",$link);
  If (mysql_num_rows($result1) > 0)
{
$row1 = mysql_fetch_array($result1);
do
{
    
 echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';   
    
} while ($row1 = mysql_fetch_array($result1));
}
?>
</ul>
<ul>
<li><a href="tovar.php?cat=notebook"><strong>Ноутбуки</strong></a></li>
<?php
 $result1 = mysql_query("SELECT * FROM category WHERE type='notebook'",$link);
  If (mysql_num_rows($result1) > 0)
{
$row1 = mysql_fetch_array($result1);
do
{
    
 echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';   
    
} while ($row1 = mysql_fetch_array($result1));
}
?>
</ul>
<ul>
<li><a href="tovar.php?cat=notepad"><strong>Планшеты</strong></a></li>
<?php
 $result1 = mysql_query("SELECT * FROM category WHERE type='notepad'",$link);
  If (mysql_num_rows($result1) > 0)
{
$row1 = mysql_fetch_array($result1);
do
{
    
 echo '<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>';   
    
} while ($row1 = mysql_fetch_array($result1));
}
?>
</ul>
</div>
</li>
</ul>
</div>
<div id="block-info">
<p id="count-style">Всего товаров - <strong><?php echo $all_count_result; ?></strong></p>
<p align="right" id="add-style" ><a href="add_product.php" >Добавить товар</a></p>
</div>

 <ul id="block-tovar">
<?php
if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';

$num = 8;

$page = (int)$_GET['page'];              

$count = mysql_query("SELECT COUNT(*) FROM table_products $cat",$link);
$temp = mysql_fetch_array($count);
$post = $temp[0];
// Находим общее число страниц
$total = (($post - 1) / $num) + 1;
$total =  intval($total);
// Определяем начало сообщений для текущей страницы
$page = intval($page);
// Если значение $page меньше единицы или отрицательно
// переходим на первую страницу
// А если слишком большое, то переходим на последнюю
if(empty($page) or $page < 0) $page = 1;
  if($page > $total) $page = $total;
// Вычисляем начиная с какого номера
// следует выводить сообщения
$start = $page * $num - $num;
	
if ($temp[0] > 0)   
{
$result = mysql_query("SELECT * FROM table_products $cat ORDER BY products_id DESC LIMIT $start, $num",$link);
 
 If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{
    if  (strlen($row["image"]) > 0 && file_exists("../uploads_images/".$row["image"]))
{
$img_path = '../uploads_images/'.$row["image"];
$max_width = 160; 
$max_height = 160; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
// New dimensions 
$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
}else
{
$img_path = "./images/no-image-90.png";
$width = 90;
$height = 164;
}
  
 echo '
 <li>

 <p>'.$row["title"].'</p>
<center>
 <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
</center>
<p align="center" class="link-action" >
<a class="green" href="edit_product.php?id='.$row["products_id"].'">Изменить</a> | <a rel="tovar.php?'.$url.'id='.$row["products_id"].'&action=delete" class="delete" >Удалить</a>
</p>
 </li> 
 ';   
    
} while ($row = mysql_fetch_array($result));
echo'
</ul>
';
} 
}  
    
if ($page != 1) $pervpage = '<li><a class="pstr-prev" href="tovar.php?'.$url.'page='. ($page - 1) .'" />Назад</a></li>';

if ($page != $total) $nextpage = '<li><a class="pstr-next" href="tovar.php?'.$url.'page='. ($page + 1) .'"/>Вперёд</a></li>';

// Находим две ближайшие станицы с обоих краев, если они есть
if($page - 5 > 0) $page5left = '<li><a href="tovar.php?'.$url.'page='. ($page - 5) .'">'. ($page - 5) .'</a></li>';
if($page - 4 > 0) $page4left = '<li><a href="tovar.php?'.$url.'page='. ($page - 4) .'">'. ($page - 4) .'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="tovar.php?'.$url.'page='. ($page - 3) .'">'. ($page - 3) .'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="tovar.php?'.$url.'page='. ($page - 2) .'">'. ($page - 2) .'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="tovar.php?'.$url.'page='. ($page - 1) .'">'. ($page - 1) .'</a></li>';

if($page + 5 <= $total) $page5right = '<li><a href="tovar.php?'.$url.'page='. ($page + 5) .'">'. ($page + 5) .'</a></li>';
if($page + 4 <= $total) $page4right = '<li><a href="tovar.php?'.$url.'page='. ($page + 4) .'">'. ($page + 4) .'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="tovar.php?'.$url.'page='. ($page + 3) .'">'. ($page + 3) .'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="tovar.php?'.$url.'page='. ($page + 2) .'">'. ($page + 2) .'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="tovar.php?'.$url.'page='. ($page + 1) .'">'. ($page + 1) .'</a></li>';

if ($page+5 < $total)
{
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="tovar.php?'.$url.'page='.$total.'">'.$total.'</a></li>';
}else
{
    $strtotal = ""; 
}

   
?>
<div id="footerfix"></div>
<?php
	if ($total > 1)
{
    echo '
    <center>
    <div class="pstrnav">
    <ul>   
    ';
    echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='tovar.php?".$url."page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$nextpage;
    echo '
    </center>   
    </ul>
    </div>
    ';
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