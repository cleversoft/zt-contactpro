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
            $newField.find('[name^="element["]').each(function () {
                var name = $(this).attr('name');
                $(this).attr('name', 'element[' + curField + name.substr(name.indexOf(']')));
            });
            $newField.find('[id^="jform_params_element"]').each(function(){
                var id = $(this).attr('id');
                $(this).attr('id', 'jform_params_element' + curField + id.substr(id.indexOf('required')));
            });
            $newField.find('[for^="jform_params_element"]').each(function(){
                var forAttr = $(this).attr('for');
                $(this).attr('for', 'jform_params_element' + curField + forAttr.substr(forAttr.indexOf('required')));
            });
            $newField.find('.chzn-container').remove();
            $newField.find('.chzn-done').removeClass('chzn-done').css('display', 'block');
            $newField.find('select[name*="][type]"]').chosen();
            $newField.find('.chzn-container').css('width', '220px');
            $newField.find('input[type="text"]').val("");
            $newField.find('input#zt-contact-order')
                    .val(curField)
                    .data('order', curField)
                    .attr('data-order', curField);
            $newField.css('display', 'none');
            $newField.appendTo($('#jvmaincontact'));
            /* Rebin event handler for joomla radio button */
            var $recentField = $('#jvmaincontact').children().last();
            $recentField.find('label[for$="required0"]').on('click', function(){
                var $parent = $(this).closest('fieldset');
                $parent.find('input[type="radio"]').removeAttr('checked');
                $parent.find('input[id$="required0"]').attr('checked', true);
                $parent.find('label[for$="required1"]').removeClass('btn-danger').removeClass('active');
                $parent.find('label[for$="required0"]').addClass('btn-success').addClass('active');
            });
            $recentField.find('label[for$="required1"]').on('click', function(){
                var $parent = $(this).closest('fieldset');
                $parent.find('input[type="radio"]').removeAttr('checked');
                $parent.find('input[id$="required1"]').attr('checked', true);
                $parent.find('label[for$="required0"]').removeClass('btn-success').removeClass('active');
                $parent.find('label[for$="required1"]').addClass('btn-danger').addClass('active');
            });
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
        deleteField: function (thisPtr) {
            this._destroySortable();
            $(thisPtr).closest('.sortable-item').slideUp('slow', function () {
                $(this).remove();
            });
            this._updateHiddenInput();
            this._sortable();
        },
        /**
         * Delete property
         * @param {type} thisPtr
         * @returns {undefined}
         */
        deleteProperty: function(thisPtr){
            $(thisPtr).closest('tr[id^="fieldType"]').remove();
        },
        /**
         * Add new property
         * @param {type} thisPtr
         * @returns {undefined}
         */
        addProperty: function(thisPtr){
            var $container = $(thisPtr).closest('div.sortable-item');
            var elementOrder = $container.find('input#zt-contact-order').data('order');
            var html = '<tr id="fieldType_tr_' + elementOrder + '"><td align="left" style="width: 10%;">Value</td><td align="left" colspan="2"><input type="text" size="30" value="" name="element['+ elementOrder +'][value][]"><a class="delete" href="javascript:void(null);" onclick="ztcontact.deleteProperty(this);">X</a></td></tr>';
            $container.find('table>tbody').append(html);
        },
        /**
         * Change element type
         * @param {type} thisPtr
         * @returns {undefined}
         */
        changeElement: function (thisPtr) {
            /* Find element container */
            var $container = $(thisPtr).closest('div.sortable-item');
            var $jvelement = $container.find('tbody#zt-contact-jvelement');
            var $newProperty = $container.find('a#zt-contact-newpro');
            var elementOrder = $container.find('input#zt-contact-order').data('order');
            var fieldType = $(thisPtr).val();
            switch (fieldType) {
                case 'textfield':
                    $newProperty.css('display', 'none');
                    $jvelement.html("<tr>" +
                            "<td width='15%'>Field name</td>" +
                            "<td colspan='2'><input type='text' name='element[" + elementOrder + "][fieldname]' size='30' value=''/></td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td align='left'>Size</td>" +
                            "<td colspan='2'><input type='text' name='element[" + elementOrder + "][size]' value='' size='10' /></td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td align='left'>Max Length</td>" +
                            "<td colspan='2'><input type='text' name='element[" + elementOrder + "][maxlength]' value='' size='10' /></td>" +
                            "</tr>");
                    break;
                case 'textarea':
                    $newProperty.css('display', 'none');
                    $jvelement.html("<tr>" +
                            "<td width='15%'>Field name</td>" +
                            "<td colspan='2'><input type='text' name='element[" + elementOrder + "][fieldname]' value='' size='30' /></td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td align='left'>Cols</td>" +
                            "<td colspan='2'><input type='text' name='element[" + elementOrder + "][cols]' value='' size='10' /></td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td align='left'>Rows</td>" +
                            "<td colspan='2'><input type='text' name='element[" + elementOrder + "][rows]' value='' size='10' /></td>" +
                            "</tr>");
                    break;
                case 'selected':
                    $newProperty.css('display', 'block');
                    $jvelement.html("<tr id='fieldType_tr_" + elementOrder + "'>" +
                            "<td align='left' style='width: 14%;'>Field name</td>" +
                            "<td align='left' colspan='2' style='width: 80%;'><input type='text' value='' size='30' name='element[" + elementOrder + "][fieldname]'></td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td align='left'>Multiple</td>" +
                            "<td colspan='2'><select name='element[" + elementOrder + "][multi]'><option value='0'>No</option><option value='1'>Yes</option></select></td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td align='left'>Size</td>" +
                            "<td colspan='2'><input type='text' name='element[" + elementOrder + "][size]' value='' size='10' /></td>" +
                            "</tr>" +
                            "<tr id='fieldType_tr_" + elementOrder + "_0'>" +
                            "<td align='left' style='width: 10%;'>Value</td>" +
                            "<td align='left' colspan='2'>" +
                            "<input type='text' size='30' value='' name='element[" + elementOrder + "][value][]'>" +
                            "<a class='delete' href='javascript:void(null);' onclick='ztcontact.deleteProperty(this);'>X</a>" +
                            "</td>" +
                            "</tr>");
                    break;
                case 'checkbox':
                case 'radio':
                    $newProperty.css('display', 'block');
                    $jvelement.html("<tr id='fieldType_tr_" + elementOrder + "'>" +
                            "<td align='left' style='width: 14%;'>Field name</td>" +
                            "<td align='left' colspan='2' style='width: 80%;'><input type='text' value='' size='30' name='element[" + elementOrder + "][fieldname]'></td>" +
                            "</tr>" +
                            "<tr id='fieldType_tr_" + elementOrder + "_0'>" +
                            "<td align='left' style='width: 10%;'>Value</td>" +
                            "<td align='left' colspan='2'>" +
                            "<input type='text' size='30' value='' name='element[" + elementOrder + "][value][]'>" +
                            "<a class='delete' href='javascript:void(null);' onclick='ztcontact.deleteProperty(this);'>X</a>" +
                            "</td>" +
                            "</tr>");
                    break;
                case 'text':
                    $newProperty.css('display', 'none');
                    $jvelement.html("<tr id='fieldType_tr_" + elementOrder + "_0'>" +
                            "<td align='left' style='width: 15%;'>Text</td>" +
                            "<td align='left' colspan='2'>" +
                            "<textarea type='text' cols='57' rows='6' name='element[" + elementOrder + "][fieldtext]'></textarea>" +
                            "</td>" +
                            "</tr>");
                    break;
                default:
                    $newProperty.css('display', 'block');
                    $jvelement.html("<tr id='fieldType_tr_" + elementOrder + "'>" +
                            "<td align='left' style='width: 14%;'>Field name</td>" +
                            "<td align='left' colspan='2' style='width: 80%;'>" +
                            "<input type='text' value='' size='30' name='element[" + elementOrder + "][fieldname]'>" +
                            "</td>" +
                            "</tr>" +
                            "<tr id='fieldType_tr_" + elementOrder + "_0'>" +
                            "<td align='left' style='width: 10%;'>Value</td>" +
                            "<td align='left' colspan='2'>" +
                            "<input type='text' size='30' value='' name='element[" + elementOrder + "][value][]'>" +
                            "<a class='delete' href='javascript:void(null);' onclick='ztcontact.deleteProperty(this);'>X</a>" +
                            "</td>" +
                            "</tr>");
                    break;

            }
        }
    };
    /* Bring ztcontact to a gobal object */
    w.ztcontact = _ztcontact;

    /* Init after document is ready */
    $(document).ready(function () {
        w.ztcontact._init();
    });
})(window, jQuery);