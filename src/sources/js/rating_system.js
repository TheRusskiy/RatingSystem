// Browser detection for when you get desparate. A measure of last resort.
// http://rog.ie/post/9089341529/html5boilerplatejs

// var b = document.documentElement;
// b.setAttribute('data-useragent',  navigator.userAgent);
// b.setAttribute('data-platform', navigator.platform);

// sample CSS: html[data-useragent*='Chrome/13.0'] { ... }


// remap jQuery to $
//(function($){


/* trigger when page is ready */
$(document).ready(function (){
    window.Rating = {};

    // Datepicker
    $(function() {
        $( "#from" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            firstDay: 1,
            dateFormat: "yy-mm-dd",
            onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            firstDay: 1,
            numberOfMonths: 1,
            dateFormat: "yy-mm-dd",
            onClose: function( selectedDate ) {
                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
    });

    Rating.getURLParameter = function(name) {
        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
    };

    Rating.navigateTo = function(params){
        var query = $.param(params);
        var hostAddress= window.location.host.toString();
        window.location="http://"+hostAddress+"/?"+query;
    };

    $('.notice').hide().slideDown(500).delay(4000).slideUp(500);
    $('.error').hide().slideDown(500);
});

/* optional triggers

$(window).load(function() {
	
});

$(window).resize(function() {
	
});

*/


//})(window.jQuery);