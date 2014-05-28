// jTabs Plugin for jQuery - Version 0.3
// by Angel Grablev for Enavu Web Development network (enavu.com)
// Dual license under MIT and GPL :) enjoy
/*

To use simply call .jTabs() on the element that holds your tabs and pass in content for the element that holds your tabs content:
$("ul.tabs").jTabs({content: "content_class"}); 

you can specify the following options:
content = the element that will hold the divs with the content of each tab
equal_height = true/false to enable the columns to find the highest tab and set the height across all tabs
cookies = true/false will use browser cookies to store which tab the user is on
animate = true/false if you would like to use an animation effect when you switch tabs
effect = which animation effect would you like to use (default is fade) other option includes slide
speed = if you have animation to true you can choose how long to take the effect to take place

*/
(function($){
    $.fn.jTabs = function(options) {
        var defaults = {
            content: "div.content",
			equal_height: false,
			cookies: false,
			animate: false,
			effect: "fade",
			speed: 400
        };
        var options = $.extend(defaults, options);

        return this.each(function() {
            // object is the selected pagination element list
            obj = $(this);
            
			var objTabs = $(options.content);
			var number_of_items = obj.children("li").size();
			var tabIndex = [];
			var tabs = [];
			
			
			// create array of tab index items
			for (i=1;i<=number_of_items;i++) { tabIndex[i] = obj.find("li:nth-child("+i+")"); tabIndex[i].attr("title", i); }
			
			// create array tabs
			for (i=1;i<=number_of_items;i++) { tabs[i] = $(options.content + "> div:nth-child("+i+")"); }
			
			// if equal height on
			if(options.equal_height) {
				var maxHeight = 0;
				$(options.content).children("div").each(function(){
				   if ($(this).outerHeight() > maxHeight) { maxHeight = $(this).outerHeight(); }
				});
				$(options.content).height(maxHeight);
			}
			
			// initiate the current tab
			if (options.cookies) {
				if (getCookie("page")) { showTab(getCookie("page")); }
				else { setCookie("page",1,999); showTab(1);	}
			} else {
				showTab(1);
			}
			
			function showTab(num) {
				tabIndex[num].addClass("active").siblings().removeClass("active");
				if(!options.animate) { tabs[num].show().siblings().hide(); }
				else {
				
					switch (options.effect) {
						case "fade":
							tabs[num].fadeIn(options.speed).siblings().hide();
							break;
						case "slide":
							tabs[num].slideDown(options.speed).siblings().hide();
							break;
					}
				
				}
			}
			
            
			obj.find("li").live("click", function(e){
				e.preventDefault();
				var tab_num = $(this).attr("title");
				showTab(tab_num);
				if (options.cookies) setCookie("page",tab_num,999);
			});
			
			
			/* code to handle cookies */
			function setCookie(c_name,value,expiredays)
			{
				var exdate=new Date();exdate.setDate(exdate.getDate()+expiredays);document.cookie=c_name+"="+escape(value)+
((expiredays==null)?"":";expires="+exdate.toUTCString());
			}
			function getCookie(c_name)
			{
				if(document.cookie.length>0)
				{c_start=document.cookie.indexOf(c_name+"=");if(c_start!=-1)
				{c_start=c_start+c_name.length+1;c_end=document.cookie.indexOf(";",c_start);if(c_end==-1)c_end=document.cookie.length;return unescape(document.cookie.substring(c_start,c_end));}}
				return"";
			}
        });
        
       
    };
})(jQuery);