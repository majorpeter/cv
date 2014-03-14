/**
*	Major Péter
*	(c) MP 2014
*/

$(document).ready(function(){
	$('div.popuptitle').click(function(e){
		var id = $(this).parent().data('id');
		if (!id) return;
		
		if (!$('div#pd'+id).is(':visible')) {
			$('div#pd'+id).slideDown(300);
			$(this).children('span.toggle').animate({ borderSpacing: 90 }, {
			    step: function(now,fx) {
			      $(this).css('-webkit-transform','rotate('+now+'deg)'); 
			      $(this).css('-moz-transform','rotate('+now+'deg)');
			      $(this).css('transform','rotate('+now+'deg)');
			    },
			    duration: 300,
			    complete: function() {
					$(this).css('-webkit-transform','rotate(0deg)'); 
			      	$(this).css('-moz-transform','rotate(0deg)');
			     	$(this).css('transform','rotate(0deg)');
			     	$(this).css('background', 'url(img/tree_open.png)');
			    }
			},'linear');
		}
		else {
			$('div#pd'+id).slideUp(300);
			var toggle = $(this).children('span.toggle');
			toggle.css('-webkit-transform','rotate(90deg)'); 
	      	toggle.css('-moz-transform','rotate(90deg)');
	     	toggle.css('transform','rotate(90deg)');
			toggle.css('background', 'url(img/tree_closed.png)');
			toggle.animate({ borderSpacing: 0 }, {
			    step: function(now,fx) {
			      $(this).css('-webkit-transform','rotate('+now+'deg)'); 
			      $(this).css('-moz-transform','rotate('+now+'deg)');
			      $(this).css('transform','rotate('+now+'deg)');
			    },
			    duration: 300,
			    complete: function() {
					$(this).css('-webkit-transform','rotate(0deg)'); 
			      	$(this).css('-moz-transform','rotate(0deg)');
			     	$(this).css('transform','rotate(0deg)');
		    	},
			},'linear');
		}
	}).mouseenter(function(e){
		$(this).children('span.toggle.hide').fadeIn(150);
	}).mouseleave(function(e){
		$(this).children('span.toggle.hide').stop().fadeOut(150);
	});
});
