$(document).ready(function() {
	$('ul#menu ul').css('display', 'none');
	$('ul#menu li').click(function() {
		if ($(this).children('ul').css('display') == 'none') {
			$(this).children('ul').slideDown(300).css('display', 'block');
		} else {
			$(this).children('ul').slideUp(300, function() {
				$(this).css('display', 'none');
			});
		}
	});
});
