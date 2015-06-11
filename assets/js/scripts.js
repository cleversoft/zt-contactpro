(function(w, $){
    
    if(typeof($) === 'undefined'){
        console.log('jQuery was not loaded.');
    }
    $(document).ready(function(){
        $('#jvmaincontact').sortable({
            forcePlaceholderSize: true,
            stop: function(event, ui){
                var startValue = 0;
                var fieldOrder = $('#zt_drapdrop').find('#fieldorder');
                fieldOrder.val('');
                $('#jvmaincontact').find('input#zt-contact-order').each(function(){
                    $(this).closest('.sortable-item').find('#textorder').html(startValue);
                    fieldOrder.val(fieldOrder.val()+ '|' + $(this).data('order'));                    
                    $(this).val(startValue++);
                });
                fieldOrder.val(fieldOrder.val().substr(1));
            }
        });
    });

    
})(window, jQuery);