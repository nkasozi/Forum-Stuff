// Login Form

$(function() {
    var start_button = $('#start');
    var home_page_image = $('.billboard');
    var home_page_content = $('#content');
	var home_link=$('#home_buttom');
	
	home_page_content.hide();
    start_button.removeAttr('href');
	home_link.removeAttr('href');
	
	
   start_button.mouseup(function() {
        home_page_image.slideUp(1000);
		home_page_content.show();
        start_button.toggleClass('active');
    });
	
	home_link.mouseup(function() {
        home_page_image.slideDown("slow");
        start_button.removeAttr('href');
		home_page_content.hide();
    });
    home_page_image.mouseup(function() { 
        return false;
    });
    /*$(this).mouseup(function(login) {
        if(!($(login.target).parent('#loginButton').length > 0)) {
            button.removeClass('active');
            //box.slideRight(1000);
			
        }
    });*/
});

