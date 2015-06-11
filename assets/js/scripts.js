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
         * 
         * @returns {undefined}
         */
        _updateHiddenInput: function () {
            var startValue = 0;
            var fieldOrder = $('#zt_drapdrop input#fieldorder');
            fieldOrder.val('');
            $('#jvmaincontact input#zt-contact-order').each(function () {
                $(this).closest('.sortable-item').find('span#textorder').html(startValue);
                fieldOrder.val(fieldOrder.val() + '|' + $(this).data('order'));
                $(this).val(startValue++);
            });
            fieldOrder.val(fieldOrder.val().substr(1));
        },
        /**
         * jQuery sortable init
         * @returns {undefined}
         */
        _sortable: function () {
            var self = this;
            $('#jvmaincontact').sortable({
                forcePlaceholderSize: true,
                stop: function (event, ui) {
                    self._updateHiddenInput();
                }
            });
        },
        /**
         * Flush sortable
         * @returns {undefined}
         */
        _destroySortable: function () {
            $('#jvmaincontact').sortable('destroy');
        },
        /**
         * Add new field
         * @returns {undefined}
         */
        addField: function () {
            var curField = $('#jvmaincontact div.sortable-item').length;
            var $newField = $('#jvmaincontact')
                    .children()
                    .last()
                    .clone();
            this._destroySortable();
            /* Update field's name */
            $newField.find('[name^="element["]').each(function(){
                var name = $(this).attr('name');
                $(this).attr('name', 'element[' + curField + name.substr(name.indexOf(']')));
            });
            $newField.find('input#zt-contact-order')
                    .val(curField)
                    .data('order', curField)
                    .attr('data-order', curField);
            $newField.css('display', 'none');
            $newField.appendTo($('#jvmaincontact'));
            this._updateHiddenInput();
            $('#jvmaincontact')
                    .children()
                    .last()
                    .fadeIn('slow');
            this._sortable();            
        },
        /**
         * Delete field
         * @param {type} thisPtr
         * @returns {undefined}
         */
        deleteField: function(thisPtr) {
            this._destroySortable();
            $(thisPtr).closest('.sortable-item').slideUp('slow', function(){
                $(this).remove();
            });                    
            this._updateHiddenInput();
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