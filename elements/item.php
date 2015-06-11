<?php
/**
 * @package ZT Contact pro module for Joomla!
 * @author http://www.zootemplate.com
 * @copyright (C) 2010- ZooTemplate.Com
 * @license PHP files are GNU/GPL
 * */
defined('_JEXEC') or die('Restricted access');
if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
jimport('joomla.form.formfield');

class JFormFieldItem extends JFormField
{

    protected $type = 'Item';
    
    /**
     * Load mootools framework
     */
    private function _loadMooTools(){
        $doc = JFactory::getDocument();
        $mootoolsCoreLoaded = false;
        $mootoolsMoreLoaded = false;
        foreach($doc->_scripts as $key => $value){
            if(basename($key) == 'mootools-core.js'){
                $mootoolsCoreLoaded = true;
            }
            if(basename($key) == 'mootools-more.js'){
                $mootoolsMoreLoaded = true;
            }            
        } 
        if(!$mootoolsCoreLoaded){
            $doc->addScript(JUri::root() . 'media/system/js/mootools-core.js');
        }
        if(!$mootoolsMoreLoaded){
            $doc->addScript(JUri::root() . 'media/system/js/mootools-more.js');
        }    
    }
    
    protected function getInput()
    {
        if (version_compare(JVERSION, '3.0', 'ge'))
        {
            if (!defined('CONTACT_JVERSION'))
                define('CONTACT_JVERSION', '30');
        }

        $db = JFactory::getDBO();
        $doc = JFactory::getDocument();
        $cId = JRequest::getVar('cid', '');
        if ($cId != '')
            $cId = $cId[0];
        if ($cId == '')
        {
            $cId = JRequest::getVar('id');
        }
        $folder = '../modules/mod_zt_contact_pro/assets/data/';
        $file = 'contact' . $cId . '.xml';
        if (is_file($folder . DS . $file))
        {
            $api_url = JURI::root() . 'modules/mod_zt_contact_pro/assets/data/contact' . $cId . '.xml';
            $xml = simplexml_load_file($api_url);
        } else
        {
            $api_url = JURI::root() . 'modules/mod_zt_contact_pro/assets/data/contact.xml';
            $xml = simplexml_load_file($api_url);
        }
        $elementlist = count($xml->elementList->param);
        $doc->addScript(JUri::root() . 'modules/mod_zt_contact_pro/assets/js/vendor/jquery-ui/jquery-ui.min.js');
        $doc->addScript(JUri::root() . 'modules/mod_zt_contact_pro/assets/js/scripts.js');
        $doc->addStyleSheet(JUri::root() . 'modules/mod_zt_contact_pro/assets/css/adminformcss.css');
        $ajax = JURI::root() . "modules/mod_zt_contact_pro/elements/ajax.php";
        $options = array();
        $val = '';
        $text = "--Select Type--";
        $options[] = JHTML::_('select.option', $val, JText::_($text));
        $val = 'textfield';
        $text = "Text Field";
        $options[] = JHTML::_('select.option', $val, JText::_($text));
        $val = 'selected';
        $text = "Drop-down selection";
        $options[] = JHTML::_('select.option', $val, JText::_($text));
        $val = 'radio';
        $text = "Radio buttons";
        $options[] = JHTML::_('select.option', $val, JText::_($text));
        $val = 'checkbox';
        $text = "Checkbox buttons";
        $options[] = JHTML::_('select.option', $val, JText::_($text));
        $val = 'textarea';
        $text = "Textarea";
        $options[] = JHTML::_('select.option', $val, JText::_($text));
        $val = 'text';
        $text = "Text";
        $options[] = JHTML::_('select.option', $val, JText::_($text));
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
        <?php
        if (CONTACT_JVERSION == 30)
        {
            ?>
                    $save = jQuery('div#toolbar-save button');
                    $apply = jQuery('div#toolbar-apply button');
        <?php }
        ?>
                $save.on('click', function () {
                    console.log(jQuery('#module-form').serialize());
                    jQuery.ajax({
                        url: '<?php echo $ajax; ?>',
                        data: jQuery('#module-form').serialize(),
                        method: 'post',
                        update: 'vehicles_list'
                    }).done(function(){
                        submitbutton1('apply');
                    });
                });
                $apply.on('click', function (el) {
                    jQuery.ajax({
                        url: '<?php echo $ajax; ?>',
                        data: jQuery('#module-form').serialize(),
                        method: 'post',
                        update: 'vehicles_list'
                    }).done(function(){
                        submitbutton1('apply');
                    });
                });
            });
            function submitbutton(pressbutton) {
                var form = document.adminForm;
                if (pressbutton == 'cancel') {
                    submitform(pressbutton);
                    return;
                }
            }
            function submitbutton1(pressbutton) {
                var form = document.adminForm;
                submitform(pressbutton);
            }
        </script>
        <?php
        $html = '<div id="vehicles_list"></div>';

        $html .='<div id="zt_drapdrop">
			 <div id="jvmaincontact" class="zt-container">';
        for ($i = 0; $i < $elementlist; $i++)
        {
            $listvalue = count($xml->elementList->param[$i]->value);
            $checkvalid = $xml->elementList->param[$i]->valid;
            $checkproperty = $xml->elementList->param[$i]->type;
            $control_name = 'element[' . $i . ']';
            $control_name_field = 'element' . $i . 'required';
            $html .= '<div class="sortable-item">'
                    . '<input type="hidden" name="order[]" id="zt-contact-order" value="' . $i . '" data-order="'. $i .'">'
                    . '<table width="30%" cellspacing="0" cellpadding="0" border="0" class="adminform" id="fileType_' . $i . '">
								<thead width="30%">
								   <tr>
								   	<td colspan="3">
									   	<div class="ztmove">
											<h2>Order <span id="textorder">' . $i . '</span></h2>
										</div>
								   	</td>
								   </tr>
									<tr>
										<td width="10%">Field Type</td>
										<td align="left" width="35%">';
            $html .=@JHTML::_('select.genericlist', $options, '' . $control_name . '[type]', 'onchange="changeElement(' . $i . ', value);"', 'value', 'text', $checkproperty, $control_name);
            $html .='</td>
										<td class="ps" align="left" width="55%"><a class="btn active btn-success" href="javascript:newFieldtype(' . $i . ');">Add Field</a>
										';
            $html .= '| <a id="deletepro' . $i . '" class="btn active btn-danger" href="javascript:deleteFieldtype(' . $i . ')">Delete Field</a> ';

            if ($xml->elementList->param[$i]->type != 'textfield' && $xml->elementList->param[$i]->type != 'textarea' && $xml->elementList->param[$i]->type != 'text')
            {
                $html .= '| <a id="newpro' . $i . '" class="btn active btn-success" href="javascript:newValue(' . $i . ');">New value</a>';
            } else
            {
                $html .= '<a class="btn active btn-success" style="opacity: 0;" id="newpro' . $i . '" href="javascript:newValue(' . $i . ');">| New value</a>';
            }
            $html .= '</td>
									</tr>';
            if ($checkproperty != 'text')
            {
                $html .= '<tr id="fieldType_tr_' . $i . '_0">
										<td align="left" style="width: 15%;">Field Title</td>
										<td align="left" width="35%"><input type="text" value="' . $xml->elementList->param[$i]->fieldtitle . '" size="30" name="' . $control_name . '[fieldtitle]"></td>';
                if (CONTACT_JVERSION == 30)
                {
                    $html .= '<td align="left"  width="55%"><span class="feildset">Required:</br>
                        <fieldset id="jform_params_' . $control_name_field . '" class="radio btn-group btn-group-yesno">
                            <input type="radio" id="jform_params_' . $control_name_field . '0" name="' . $control_name . '[required]" value="1"';
                    if ($checkvalid == '1')
                    {
                        $html .= 'checked="checked"';
                    } $html .='>';
                    $html .='<label for="jform_params_' . $control_name_field . '0" class="btn">Yes</label>
                            <input type="radio" id="jform_params_' . $control_name_field . '1" name="' . $control_name . '[required]" value="0"';
                    if ($checkvalid == '0')
                    {
                        $html .= 'checked="checked"';
                    } $html .='>';
                    $html .='<label for="jform_params_' . $control_name_field . '1" class="btn">No</label>
                        </fieldset></span>
                ';
                }
            }
            $html .='</thead>
								<tbody id="jvelement' . $i . '">';
            if ($checkproperty != 'text')
            {
                $html .= '<tr id="fieldType_tr_' . $i . '">
										<td align="left" style="width: 15%;">Field Name</td>';
                $html .= '<td align="left" style="width: 80%;" colspan="2"><input type="text" value="' . $xml->elementList->param[$i]->fieldname . '" size="30" name="' . $control_name . '[fieldname]">';
                $html .= '</td>
									</tr>';
            }
            if ($checkproperty == 'selected')
            {
                $html .='<tr>
						                <td align="left">Multiple</td>';
                if ($xml->elementList->param[$i]->multi > 0)
                {
                    $html .='<td colspan="2"><select name="' . $control_name . '[multi]"><option value="0">No</option><option selected="selected" value="1">Yes</option></select></td>';
                } else
                {
                    $html .='<td colspan="2"><select name="' . $control_name . '[multi]"><option selected="selected" value="0">No</option><option value="1">Yes</option></select></td>';
                }
                $html .='</tr>';
                $html .='<tr>
						                <td align="left">Size</td>
						   				<td colspan="2"><input type="text" name="' . $control_name . '[size]" value="' . $xml->elementList->param[$i]->size . '" size="10" /></td>
						   			</tr>';
            }
            if ($checkproperty == 'textfield')
            {
                $html .='<tr>
						                <td align="left">Size</td>
						   				<td colspan="2"><input type="text" name="' . $control_name . '[size]" value="' . $xml->elementList->param[$i]->size . '" size="10" /></td>
						   			</tr>';
                $html .='<tr>
						                <td align="left">Max Length</td>
						   				<td colspan="2"><input type="text" name="' . $control_name . '[maxlength]" value="' . $xml->elementList->param[$i]->length . '" size="10" /></td>
						   			</tr>';
            }
            if ($checkproperty == 'textarea')
            {
                $html .='<tr>
						                <td align="left">Cols</td>
						   				<td colspan="2"><input type="text" name="' . $control_name . '[cols]" value="' . $xml->elementList->param[$i]->cols . '" size="10" /></td>
						   			</tr>';
                $html .='<tr>
						                <td align="left">Rows</td>
						   				<td colspan="2"><input type="text" name="' . $control_name . '[rows]" value="' . $xml->elementList->param[$i]->rows . '" size="10" /></td>
						   			</tr>';
            }
            if ($checkproperty == 'text')
            {
                $html .='<tr>
						                <td align="left" width="15%">Text </td>
						   				<td colspan="2"><textarea name="' . $control_name . '[fieldtext]" rows="6" cols="55">' . $xml->elementList->param[$i]->intro . '</textarea></td>
						   			</tr>';
            }
            for ($j = 0; $j < $listvalue; $j++)
            {
                $value = $xml->elementList->param[$i]->value[$j];
                $html .= '<tr id="fieldType_tr_' . $i . '_' . $j . '">
										<td align="left">Value</td>
										<td width="35%" align="left">
											<input type="text" size="25" value="' . $value . '" name="' . $control_name . '[value][]">';
                if ($i > 0)
                {
                    $html .= '<a class="delete" href="javascript:deleteProperty(' . $i . ', \'' . $i . '_' . $j . '\');">X</a>';
                }
                $html .= '</td>
								    </tr>';
            }
            $html .= '</tbody>
						</table>
                                                </div>';
        }
        $orderfield = '';
        $checklist = $elementlist - 1;
        for ($e = 0; $e < $elementlist; $e++)
        {
            if ($e == '' . $checklist . '')
            {
                $orderfield .= $e;
            } else
            {
                $orderfield .= $e . '|';
            }
        }
        $html .='
				</div>
				 <input type="hidden" value="1" id="isNew" name="isNew">
				 <input type="hidden" value="Field" name="js_lbl_type">
				 <input type="hidden" value="Field Name" name="js_lbl_fieldname">
				 <input type="hidden" value="Field Title" name="js_lbl_fieldtitle">
				 <input type="hidden" value="Requiet" name="js_lbl_requie">
			     <input type="hidden" value="Value" name="js_lbl_property">
			     <input type="hidden" value="New Value" name="jv_value_new">
			     <input type="hidden" value="Add Field" name="jv_fieldtype_new">
			     <input type="hidden" value="Delete Field" name="jv_fieldtype_delete">
			     <input type="hidden" value="' . $cId . '" name="module_id">
			     <input type="hidden" value="' . $elementlist . '" id="countType" name="countType">
			     <input type="hidden" name="fieldorder" value="' . $orderfield . '" id="fieldorder" />
				</div>';
        return $html;
    }

}
?>