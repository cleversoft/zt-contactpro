<?php

/**
 * @package ZT Contact Pro module for Joomla! 2.5
 * @author http://www.zootemplate.com
 * @copyright (C) 2010- ZooTemplate.Com
 * @license PHP files are GNU/GPL
 * */
defined('_JEXEC') or die('Restricted access');
require_once __DIR__ . '/helper.php';
global $module_id;
if (version_compare(JVERSION, '3.0', 'ge'))
{
    define('CONTACT_JVERSION', '30');
}
$session =  JFactory::getSession();
$module_id = $module->id;
$helper = new modzt_contact_proHelper($params);
if ($session->get('cptch_str_key') == '' || $session->get('cptch_str_key_time') < time() - ( 24 * 60 * 60 ))
{
    $helper->generateKey();
}

$list = $helper->getList();
$captcha = $helper->displayCaptcha();
require(JModuleHelper::getLayoutPath('mod_zt_contact_pro'));
