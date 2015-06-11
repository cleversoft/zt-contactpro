(function (w, $) {

    if (typeof ($) === 'undefined') {
        console.log('jQuery was not loaded.');
    }

    var _ztcontact = {
        /**
         * Init function
         * @returns {undefined}
         */
        _init: function () {
            this._sortable();
        },
        /**
         * jQuery sortable init
         * @returns {undefined}
         */
        _sortable: function () {
            $('#jvmaincontact').sortable({
                forcePlaceholderSize: true,
                stop: function (event, ui) {
                    var startValue = 0;
                    var fieldOrder = $('#zt_drapdrop').find('#fieldorder');
                    fieldOrder.val('');
                    $('#jvmaincontact').find('input#zt-contact-order').each(function () {
                        $(this).closest('.sortable-item').find('#textorder').html(startValue);
                        fieldOrder.val(fieldOrder.val() + '|' + $(this).data('order'));
                        $(this).val(startValue++);
                    });
                    fieldOrder.val(fieldOrder.val().substr(1));
                }
            });
        },
        /**
         * Flush sortable
         * @returns {undefined}
         */
        _flushSortAble: function () {
            $('#jvmaincontact').sortable('destroy');
            this._sortable();
        }

    };
    
    /* Bring ztcontact to a gobal object */
    w.ztcontact = _ztcontact;

    /* Init after document is ready */
    $(document).ready(function () {
        w.ztcontact._init();
    });
    
})(window, jQuery);