$(document).ready(function (){
    Rating.sequence = 0;
    Rating.next_id = function(){
        Rating.sequence++;
        return Rating.sequence ;
    };
    Rating.assign_datepicker = function(element){
        element = typeof element !== 'undefined' ?
            // datepicker fucks up template, gotta clean it:
            element.removeClass('hasDatepicker').removeAttr('id')
            : $('input[data-type="date"]');
        element.datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            firstDay: 1,
            numberOfMonths: 1,
            dateFormat: "yy-mm-dd"
        });
    };
    Rating.assign_datepicker();

    $('.new_record').on('click', function(){
        var $this = $(this);
        var id = $this.data('id');
        //var next_id = Rating.next_id();
        var new_record = $('#template_'+id).children().first().clone();
        $this.before(new_record);
        Rating.assign_datepicker(new_record.find('input[data-type="date"]'));
    });
});

