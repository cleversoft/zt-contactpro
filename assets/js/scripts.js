(function(w, $){
    
    if(typeof($) === 'undefined'){
        console.log('jQuery was not loaded.');
    }
    $(document).ready(function(){
        $('#jvmaincontact').sortable();
    });

    
})(window, jQuery);