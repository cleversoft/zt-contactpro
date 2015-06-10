<?php
/**
 * @package ZT Contact pro module for Joomla 
 * @author http://www.zootemplate.com
 * @copyright (C) 2010- ZooTemplate.Com
 * @license PHP files are GNU/GPL
 * */
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_zt_contact_pro/assets/css/ztform.css');

$document->addScript(JURI::base() . 'modules/mod_zt_contact_pro/assets/js/jquery.validate.js');
require_once (JPATH_SITE . DS . 'modules' . DS . 'mod_zt_contact_pro' . DS . 'assets' . DS . 'recaptchalib.php');
$publickey = $params->get('publickey');
$privatekey = $params->get('privatekey');
$displayrecapcha = $params->get('recapcha');
$displaycapcha = $params->get('captcha');
$title_captcha = $params->get('title_captcha');
$urlRedirect = $params->get('redirect');
$user = JFactory::getUser();
$username = $user->name;
$useremail = $user->email;
$error = Null;
?>
<script type="text/javascript">
    var RecaptchaOptions = {
        theme: "white",
        lang: "en"
    };
</script>
<div style="display: none;"><a href="http://www.joomvision.com" title="Joomla Templates">Joomla Templates</a> and Joomla Extensions by JoomVision.Com</div>
<div id="zt_contact_pro_<?php echo $module_id; ?>" class="jvformcontact<?php echo $params->get('moduleclass_sfx') ?>">
    <form id='myForm' class="myForm" action="index.php" method="post">
        <div id="vehicles_list"></div>
        <div class="main-success">
            <?php
            $i = 0;
            foreach ($list as $item)
            {
                $required = '';
                $poin = '';
                if ($item->valid > 0)
                {
                    if ($item->fieldname == 'email')
                    {
                        $required .= 'required email';
                    } else
                    {
                        $required .= 'required';
                    }
                    $poin .= '*';
                }
                ?>
                <?php
                if ($item->type == 'textfield')
                {
                    ?>
                    <p>
                        <label><?php echo $item->fieldtitle . ' ' . $poin . ''; ?></label>
                        <?php
                        if ($item->fieldname == 'name')
                        {
                            ?>
                            <input class="<?php echo $required; ?> form-control" type="text" value="<?php echo $username; ?>" title="<?php echo $item->fieldtitle; ?> Invalid" name="<?php echo $item->fieldname; ?>" size="<?php echo $item->size; ?>" maxlength="<?php echo $item->length; ?>" id="<?php echo $item->fieldname; ?>">
                            <?php
                        } else if ($item->fieldname == 'email')
                        {
                            ?>
                            <input class="<?php echo $required; ?> form-control" type="text" value="<?php echo $useremail; ?>" title="<?php echo $item->fieldtitle; ?> Invalid" name="<?php echo $item->fieldname; ?>" size="<?php echo $item->size; ?>" maxlength="<?php echo $item->length; ?>" id="<?php echo $item->fieldname; ?>">
                            <?php
                        } else
                        {
                            ?>
                            <input class="<?php echo $required; ?> form-control" type="text" value="" title="<?php echo $item->fieldtitle; ?> Invalid" name="<?php echo $item->fieldname; ?>" size="<?php echo $item->size; ?>" maxlength="<?php echo $item->length; ?>" id="<?php echo $item->fieldname; ?>">
                        <?php } ?>
                    </p>
                    <?php
                } else if ($item->type == 'selected')
                {
                    $multiple = '';
                    $multisize = '';
                    if ($item->multi != 0)
                    {
                        $multiple .= 'multiple="multiple"';
                        $multisize .= $item->size;
                    }
                    ?>
                    <p>
                        <label><?php echo $item->fieldtitle . ' ' . $poin . ''; ?></label>
                        <select <?php echo $multiple; ?> class="<?php echo $required; ?>" title="<?php echo $item->fieldtitle; ?> Invalid" name="<?php echo $item->fieldname; ?><?php
                        if ($item->multi != 0)
                        {
                            ?>[]<?php } ?>" size="<?php echo $multisize; ?>">
                            <option value="">--Please select--</option>
                            <?php
                            for ($j = 0; $j < count($item->value); $j++)
                            {
                                $valueExplode = explode('|', $item->value[$j]);
                                if (@$valueExplode[1] == '')
                                {
                                    ?>
                                    <option value="<?php echo $valueExplode[0]; ?>"><?php echo $valueExplode[0]; ?></option>
                                    <?php
                                } else
                                {
                                    ?>
                                    <option value="<?php echo $valueExplode[0]; ?>"><?php echo $valueExplode[1]; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </p>
                    <?php
                } else if ($item->type == 'radio')
                {
                    ?>
                    <p>
                        <label><?php echo $item->fieldtitle . ' ' . $poin . ''; ?></label>
                        <?php
                        for ($j = 0; $j < count($item->value); $j++)
                        {
                            $valueExplode = explode('|', $item->value[$j]);
                            ?>
                            <input class="<?php echo $required; ?> form-control" type="radio" value="<?php echo $valueExplode[0]; ?>" name="<?php echo $item->fieldname; ?>" title="<?php echo $item->fieldtitle; ?> Invalid"> <?php
                            if (@$valueExplode[1] == '')
                            {
                                echo $valueExplode[0];
                            } else
                            {
                                echo $valueExplode[1];
                            }
                            ?>
                        <?php } ?>
                    </p>
                    <?php
                } else if ($item->type == 'checkbox')
                {
                    ?>
                    <p>
                        <label><?php echo $item->fieldtitle . ' ' . $poin . ''; ?></label>
                        <?php
                        for ($j = 0; $j < count($item->value); $j++)
                        {
                            $valueExplode = explode('|', $item->value[$j]);
                            ?>
                            <input class="<?php echo $required; ?> form-control" type="checkbox" value="<?php echo $valueExplode[0]; ?>" name="<?php echo $item->fieldname; ?>[]" title="<?php echo $item->fieldtitle; ?> Invalid"> <?php
                            if (@$valueExplode[1] == '')
                            {
                                echo $valueExplode[0];
                            } else
                            {
                                echo $valueExplode[1];
                            }
                            ?>
                        <?php } ?>
                    </p>
                    <?php
                } else if ($item->type == 'textarea')
                {
                    ?>
                    <p>
                        <label><?php echo $item->fieldtitle . ' ' . $poin . ''; ?></label>
                        <textarea class="<?php echo $required; ?> form-control" name="<?php echo $item->fieldname; ?>" title="<?php echo $item->fieldtitle; ?> Invalid" cols="<?php echo $item->cols; ?>" rows="<?php echo $item->rows; ?>"></textarea>
                    </p>
                    <?php
                } else if ($item->type == 'text')
                {
                    ?>
                    <p><?php echo $item->intro; ?></p>
                    <?php
                }
                $i++;
            }
            ?>
            <?php
            if ($params->get('typecaptcha') == 'recaptcha')
            {
                ?>
                <?php
                if ($displayrecapcha > 0)
                {
                    ?>
                    <p><?php echo recaptcha_get_html($publickey, $error); ?></p>
                <?php } ?>
                <?php
            } else
            {
                ?>
                <?php
                if ($displaycapcha)
                {
                    ?>
                    <p>
                        <label class="title-cpt"><?php echo $title_captcha; ?></label>
                        <?php echo $captcha; ?>
                    </p>
                <?php } ?>
            <?php } ?>
            <p>
                <input type="submit" class="button" value="<?php echo JText::_('Submit'); ?>" class="submit" />
            </p>
            <input type="hidden" name="module_id" value="<?php echo $module_id; ?>"/>
            <input type="hidden" name="valid" id="valid" value=""/>
            <input type="hidden" id="check" value="<?php echo $displayrecapcha; ?>" />
        </div>
        <input type="hidden" name="redirect" id="redirect" value="<?php echo $urlRedirect; ?>"/>
    </form>
</div>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(function ($) {
        var v = $("#myForm").validate({
            submitHandler: function (form) {
                var mainform = $(".main-success");
                var log = $('#vehicles_list').addClass('loading');
                var url = '<?php echo JURI::root(); ?>modules/mod_zt_contact_pro/ajax.php';
                var data = $('#myForm').serialize();
                $.ajax({
                    url: url,
                    dataType: 'json',
                    data: data,
                    type: 'post',
                    success: function (data) {
                        if (data.status == 'unsuccess') {
                            log.removeClass('loading');
                            log.html(data.message);
                            if ($('#check').val() > 0) {
                                Recaptcha.reload();
                            }
                        } else {
                            log.remove();
                            mainform.html(data.message);
                        }
                        checkurl = $('#redirect').val();
                        if (checkurl != '') {
                            window.location = checkurl;
                        }
                    }
                });
            }
        });
    });
</script>
