<?php
/**
 * @package ZT Contact pro module for Joomla!
 * @author http://www.zootemplate.com
 * @copyright (C) 2013- ZooTemplate.Com
 * @license PHP files are GNU/GPL
 * */
defined('JPATH_BASE') or die();
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldTypecaptcha extends JFormFieldList
{

    protected $type = 'typecaptcha';

    public function getOptions()
    {
        if (version_compare(JVERSION, '3.0', 'ge'))
        {
            if (!defined('CONTACT_JVERSION'))
                define('CONTACT_JVERSION', '30');
        }

        //Get value of layout style from database
        $db = JFactory::getDBO();
        $cId = JRequest::getVar('cid', '');
        if ($cId != '')
            $cId = $cId[0];
        if ($cId == '')
        {
            $cId = JRequest::getVar('id');
        }
        $query = $db->getQuery(true);
        $query->select('m.params')
                ->from('#__modules AS m')
                ->where('m.id=' . $cId);
        $db->setQuery($query);
        $module = $db->loadObject();
        $params = new JRegistry();
        $params->loadString($module->params);
        $layoutStyle = $params->get('typecaptcha', 'recaptcha');
        //End get value of layout style
        $options = array();
        $val = "captcha";
        $text = "Captcha";
        $options[] = JHTML::_('select.option', $val, JText::_($text));
        $val = "recaptcha";
        $text = "Recaptcha";
        $options[] = JHTML::_('select.option', $val, JText::_($text));
        ?>

        <script type="text/javascript">
            jQuery(window).on('load', function () {
        <?php
        if (CONTACT_JVERSION == 30)
        {
            ?>
                    var Recaptcha = jQuery('#jform_params_recapcha').parent().parent();
                    for (i = 0; i <= 2; i++) {
                        Recaptcha.addClass('recaptcha');
                        Recaptcha = Recaptcha.next();
                    }
                    var Captcha = jQuery('jform_params_captcha').parent().parent();
                    for (i = 0; i <= 8; i++) {
                        Captcha.addClass('captcha');
                        Captcha = Captcha.next();
                    }
        <?php } ?>
                var zt_recaptcha = jQuery('.recaptcha');
                var zt_captcha = jQuery('.captcha');
                var layout = "<?php echo $layoutStyle; ?>";
                var selectStyle = function (style) {
                    switch (style) {
                        case "recaptcha":
                            zt_recaptcha.each(function (item) {
                                jQuery(item).css('display', '');
                            });
                            zt_captcha.each(function (item) {
                                jQuery(item).css('display', 'none');
                            });
                            break;
                        case "captcha":
                            zt_recaptcha.each(function (item) {
                                jQuery(item).css('display', 'none');
                            });
                            zt_captcha.each(function (item) {
                                jQuery(item).css('display', '');
                            });
                            break;
                    }
                    ;
                }
                selectStyle(layout);
        <?php
        if (CONTACT_JVERSION == 30)
        {
            ?>
                    jQuery('#jform_params_typecaptcha').change('change', function () {
                        selectStyle(this.value);
                    });
        <?php }
        ?>
            });
        </script>
        <?php
        return $options;
    }

}
?>
