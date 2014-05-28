$(document).ready(function() {

	$('.delete').click(function(){
		
		var rel = $(this).attr("rel");
		
		$.confirm({
			'title'		: 'Подтверждение удаления',
			'message'	: 'После удаления восстановление будет невозможно! Продолжить?',
			'buttons'	: {
				'Да'	: {
					'class'	: 'blue',
					'action': function(){
						location.href = rel;
					}
				},
				'Нет'	: {
					'class'	: 'gray',
					'action': function(){}
				}
			}
		});
		
	});
    
  $('#select-links').click(function(){
 $("#list-links,#list-links-sort").slideToggle(200);     
 });   


 $('.h3click').click(function(){ 
 $(this).next().slideToggle(400); 
 });


  var count_input = 1;

  $("#add-input").click(function(){
    
  count_input++;  
  
  $('<div id="addimage'+count_input+'" class="addimage"><input type="hidden" name="MAX_FILE_SIZE" value="2000000"/><input type="file" name="galleryimg[]" /><a class="delete-input" rel="'+count_input+'" >Удалить</a></div>').fadeIn(300).appendTo('#objects'); 
   
  }); 

  $('.delete-input').live('click',function(){
    
	var rel = $(this).attr("rel");
  
	$("#addimage"+rel).fadeOut(300,function(){	   
    $("#addimage"+rel).remove();      
	});

});

  $('.del-img').click(function(){
    var img_id = $(this).attr("img_id");
    var title_img = $("#del"+img_id+" > img").attr("title");
    
  $.ajax({
  type: "POST",
  url: "./actions/delete-gallery.php",
  data: "id="+img_id+"&title="+title_img,
  dataType: "html",
  cache: false,
  success: function(data) { 
  if (data == "delete")
  {
     $("#del"+img_id).fadeOut(300);
  }
                          }

});
   
 });


$('.delete-cat').click(function(){
    
   var selectid = $("#cat_type option:selected").val();
     
   if (!selectid)
   {
       $("#cat_type").css("borderColor","#F5A4A4");
   }else
   {
  $.ajax({
  type: "POST",
  url: "./actions/delete-category.php",
  data: "id="+selectid,
  dataType: "html",
  cache: false,
  success: function(data) {
    
  if (data == "delete")
  {
     $("#cat_type option:selected").remove();
  }
                          }
         });       
   }
              
});
 
   $('.block-clients').click(function(){

 $(this).find('ul').slideToggle(300);
   
 });
 
 
 $('#select-all').click(function(){
    $(".privilege input:checkbox").attr('checked', true);           
});

$('#remove-all').click(function(){
    $(".privilege input:checkbox").attr('checked', false);           
});
 
 
   
 });