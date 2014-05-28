<?php	
   define('myeshop', true);
   include("include/db_connect.php");
   include("functions/functions.php");
   session_start();
   include("include/auth_cookie.php");
  
   $id = clear_string($_GET["id"]); 

     $seoquery = mysql_query("SELECT seo_words,seo_description FROM table_products WHERE products_id='$id' AND visible='1'",$link);
     
     If (mysql_num_rows($seoquery) > 0)
     {
        $resquery = mysql_fetch_array($seoquery);
     }   
   
  If ($id != $_SESSION['countid'])
{
$querycount = mysql_query("SELECT count FROM table_products WHERE products_id='$id'",$link);
$resultcount = mysql_fetch_array($querycount); 

$newcount = $resultcount["count"] + 1;

$update = mysql_query ("UPDATE table_products SET count='$newcount' WHERE products_id='$id'",$link);  
}

$_SESSION['countid'] = $id; 
      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
    
    <meta name="Description" content="<? echo $resquery["seo_description"]; ?>"/>
    <meta name="keywords" content="<? echo $resquery["seo_words"]; ?>" /> 
    
    <link href="http://shop//css/reset.css" rel="stylesheet" type="text/css" />
    <link href="http://shop//css/style.css" rel="stylesheet" type="text/css" />
    <link href="http://shop//trackbar/trackbar.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript" src="http://shop//js/jquery-1.8.2.min.js"></script> 
    <script type="text/javascript" src="http://shop//js/jcarousellite_1.0.1.js"></script> 
    <script type="text/javascript" src="http://shop//js/shop-script.js"></script>
    <script type="text/javascript" src="http://shop//js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="http://shop//trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript" src="http://shop//js/TextChange.js"></script>
    
    <link rel="stylesheet" type="text/css" href="http://shop//fancybox/jquery.fancybox.css" />
    <script type="text/javascript" src="http://shop//fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="http://shop//js/jTabs.js"></script>
    
	<title>Интернет-Магазин Цифровой Техники</title>


<script type="text/javascript">
$(document).ready(function(){
 
    $("ul.tabs").jTabs({content: ".tabs_content", animate: true, effect:"fade"}); 
    $(".image-modal").fancybox(); 
    $(".send-review").fancybox();
	
});	
</script> 
</head>
<body>
<div id="block-body">
<?php	
    include("include/block-header.php");    
?>
<div id="block-right">
<?php	
    include("include/block-category.php");  
    include("include/block-parameter.php");  
    include("include/block-news.php"); 
?>
</div>
<div id="block-content">
<?php
$result1 = mysql_query("SELECT * FROM table_products WHERE products_id='$id' AND visible='1'",$link);
If (mysql_num_rows($result1) > 0)
{
$row1 = mysql_fetch_array($result1);
do
{   
if  (strlen($row1["image"]) > 0 && file_exists("./uploads_images/".$row1["image"]))
{
$img_path = './uploads_images/'.$row1["image"];
$max_width = 300; 
$max_height = 300; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 

$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
}else
{
$img_path = "/images/no-image.png";
$width = 110;
$height = 200;
}     

// Количество отзывов 
$query_reviews = mysql_query("SELECT * FROM table_reviews WHERE products_id = '$id' AND moderat='1'",$link);  
$count_reviews = mysql_num_rows($query_reviews);


echo  '

<div id="block-breadcrumbs-and-rating">
<p id="nav-breadcrumbs2"><a href="view_cat.php?type=mobile">Мобильные телефоны</a> \ <span>'.$row1["brand"].'</span></p>
<div id="block-like">
<p id="likegood" tid="'.$id.'" >Нравится</p><p id="likegoodcount" >'.$row1["yes_like"].'</p>
</div>
</div>

<div id="block-content-info">

<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />

<div id="block-mini-description">

<p id="content-title">'.$row1["title"].'</p>

<ul class="reviews-and-counts-content">
<li><img src="/images/eye-icon.png" /><p>'.$row1["count"].'</p></li>
<li><img src="/images/comment-icon.png" /><p>'.$count_reviews.'</p></li>
</ul>


<p id="style-price" >'.group_numerals($row1["price"]).' руб</p>

<a class="add-cart" id="add-cart-view" tid="'.$row1["products_id"].'" ></a>

<p id="content-text">'.$row1["mini_description"].'</p>

</div>

</div>

';

   
}
 while ($row1 = mysql_fetch_array($result1));


 $result = mysql_query("SELECT * FROM uploads_images WHERE products_id='$id'",$link);
If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
echo '<div id="block-img-slide">
      <ul>';
do
{
    
$img_path = './uploads_images/'.$row["image"];
$max_width = 70; 
$max_height = 70; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 

$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
    
    
echo '
<li>
<a class="image-modal" href="#image'.$row["id"].'"><img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" /></a>
</li>
<a style="display:none;" class="image-modal" rel="group" id="image'.$row["id"].'" ><img  src="./uploads_images/'.$row["image"].'" /></a>
';
}
 while ($row = mysql_fetch_array($result));
 echo '
 </ul>
 </div>    
        ';
}

$result = mysql_query("SELECT * FROM table_products WHERE products_id='$id' AND visible='1'",$link);
$row = mysql_fetch_array($result);

echo '

<ul class="tabs">
    <li><a class="active" href="#" >Описание</a></li>
    <li><a href="#" >Характеристики</a></li>
    <li><a href="#" >Отзывы</a></li>   
</ul>

<div class="tabs_content">

<div>'.$row["description"].'</div>
<div>'.$row["features"].'</div>
<div>
<p id="link-send-review" ><a class="send-review" href="#send-review" >Написать отзыв</a></p>
';

$query_reviews = mysql_query("SELECT * FROM table_reviews WHERE products_id='$id' AND moderat='1' ORDER BY reviews_id DESC",$link);

If (mysql_num_rows($query_reviews) > 0)
{
$row_reviews = mysql_fetch_array($query_reviews);
do
{

echo '
<div class="block-reviews" >
<p class="author-date" ><strong>'.$row_reviews["name"].'</strong>, '.$row_reviews["date"].'</p>
<img src="/images/plus-reviews.png" />
<p class="textrev" >'.$row_reviews["good_reviews"].'</p>
<img src="/images/minus-reviews.png" />
<p class="textrev" >'.$row_reviews["bad_reviews"].'</p>

<p class="text-comment">'.$row_reviews["comment"].'</p>
</div>

';
        
}
 while ($row_reviews = mysql_fetch_array($query_reviews));
}
else
{
    echo '<p class="title-no-info" >Отзывов нет</p>';
} 



echo '
</div>

</div>


    <div id="send-review" >
    
    <p align="right" id="title-review">Публикация отзыва производится после предварительной модерации.</p>
    
    <ul>
    <li><p align="right"><label id="label-name" >Имя<span>*</span></label><input maxlength="15" type="text"  id="name_review" /></p></li>
    <li><p align="right"><label id="label-good" >Достоинства<span>*</span></label><textarea id="good_review" ></textarea></p></li>    
    <li><p align="right"><label id="label-bad" >Недостатки<span>*</span></label><textarea id="bad_review" ></textarea></p></li>     
    <li><p align="right"><label id="label-comment" >Комментарий</label><textarea id="comment_review" ></textarea></p></li>     
    </ul>
    <p id="reload-img"><img src="/images/loading.gif"/></p> <p id="button-send-review" iid="'.$id.'" ></p>
    </div>



';

}
	
?>
</div>

<?php	
    include("include/block-footer.php");    
?>
</div>

</body>
</html>