$(document).ready(function(){
	//contact form boxes
	$('form#contact_form').submit(function(e){
		e.preventDefault();
		$('form#contact_form div.form-error').slideUp(100, function(){
			$(this).remove();
		});
		$.ajax({
			url: 'ajax.php',
			method: 'post',
			data: $(this).serialize(),
			success: function(resp){
				$('form#contact_form div.form-error').slideUp(100, function(){
					$(this).remove();
				});
				if (resp.errormsg) {
					var field = $('form#contact_form [name="'+resp.field+'"]');
					var msg = $('<div class="form-error">'+resp.errormsg+'</div>');
					field.after(msg);
					msg.slideDown(200);
					field.focus();
				} else { //successful send
					alert(resp);
					$('div#contact-block div.fields').fadeOut(500);
				}
			}
		});
	});
	$('div#contact-block div.fields input[type="text"], div#contact-block div.fields textarea').focus(function(e){
		if (this.value == this.getAttribute('data-default'))
			this.value = '';
	});
	$('div#contact-block div.fields input[type="text"], div#contact-block div.fields textarea').blur(function(e){
		if (this.value == '')
			this.value = this.getAttribute('data-default');
	});
	
	$('div#header a.logo, div#footer div.top').click(function(e){
		e.preventDefault();
		$('html, body').stop().animate({
			scrollTop: 0
		}, 500);
		window.history.pushState('string', 'Title', '/');
	});
	
	//parallax bg movement
	$(window).scroll(updateBgs);
	$(window).resize(updateBgs);
	
	//portfolio boxes
	$('div#portfolio-block div.portfolio > div.item').mouseenter(function(e){
		$(this).children('div.title').animate({marginTop: 0}, 200);
	});
	$('div#portfolio-block div.portfolio > div.item').mouseleave(function(e){
		$(this).children('div.title').stop().animate({marginTop: -52}, 200);
	});
});

function toggleSmallMenu() {
	var sm = $('div#header ul.small-menu');
	if (!sm.is(':visible'))
		sm.slideDown(200);
	else
		sm.slideUp(200);
}

function updateBgs(){
	var st = $(this).scrollTop();
	//about-us
	$('div#about-us-block div.background').css('top', -st/2);
}
