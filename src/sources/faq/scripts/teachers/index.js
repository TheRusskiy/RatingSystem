$(document).ready(function (){
   $('.calculation_link').each(function(){
       $(this).on("click", function(){
           var $this = $(this);
           $this.hide();
           $.ajax({
               url: $this.attr('href'),
               context: document.body
           }).done(function(data) {
                   $this.after(data);
               });
           return false;
       });
   })
});

