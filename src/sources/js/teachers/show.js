$(document).ready(function (){
    Rating.sequence = 0;
    Rating.next_id = function(){
        Rating.sequence++;
        return Rating.sequence ;
    };
    Rating.assign_datepicker = function(element){
        element = typeof element !== 'undefined' ?
            $(element).find('input[data-type="date"]').
                // datepicker fucks up template, gotta clean it:
                removeClass('hasDatepicker').removeAttr('id')
            : $('input[data-type="date"]');
        element.datepicker({
            changeMonth: true,
            changeYear: true,
            firstDay: 1,
            numberOfMonths: 1,
            dateFormat: "yy-mm-dd"
        });
    };

    Rating.assign_delete = function(element){
        var link = typeof element !== 'undefined' ?
            $(element).find('a.delete_record') :
            $('a.delete_record');
        link.on('click', function(){
            if (confirm('Вы уверены?')){
                var record = link.parent();
                record.fadeOut();
                if (record.data('action')==='create'){
                    record.remove();
                } else {
                    record.data('action', 'delete');
                }
            }
        });
    };

    Rating.assign_datepicker(); // Assign datepicker to all existing records
    Rating.assign_delete(); // Assign delete record script to all existing records

    $('.new_record').on('click', function(){
        var $this = $(this);
        var id = $this.data('id');
        //var next_id = Rating.next_id();
        var new_record = $('#template_'+id).children().first().clone();
        new_record.addClass("record");
        new_record.data('action', 'create');
        $this.before(new_record);
        Rating.assign_datepicker(new_record);
        Rating.assign_delete(new_record);
    });

    $('#save_criteria').on('click', function(){
        if (confirm('Вы уверены?')){
            var records = [];
            var staff_id = Rating.getURLParameter('id');
            $('.record').each(function(){
                var $this = $(this);
                var record = {
                    criteria_id : $this.data('criteria'),
                    staff_id: staff_id,
                    date : $this.find('input[data-type="date"]').val(),
                    value : $this.find('input[data-type="value"], select[data-type="value"]').val(),
                    action : $this.data('action')
                };
                records.push(record);
            });
            alert(JSON.stringify(records));
            var params = {
                controller: "teachers",
                action: "save_records",
                records: records,
                staff_id: staff_id
            };
            Rating.navigateTo(params);
        } else {
            return false;
        }
    });
});

