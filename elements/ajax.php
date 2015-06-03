<?php

/**
 * @package ZT Contact pro module for Joomla!
 * @author http://www.zootemplate.com
 * @copyright (C) 2010- ZooTemplate.Com
 * @license PHP files are GNU/GPL
 * */
//Initiate environment
define('DS', DIRECTORY_SEPARATOR);
$rootFolder = explode(DS, dirname(__FILE__));
//current level in diretoty structure
$currentfolderlevel = 3;
array_splice($rootFolder, -$currentfolderlevel);
$base_folder = implode(DS, $rootFolder);
if (is_dir($base_folder . DS . 'libraries' . DS . 'joomla'))
{
    define('_JEXEC', 1);
    define('JPATH_BASE', implode(DS, $rootFolder));
    require_once ( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
    require_once ( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );
    require_once(JPATH_BASE . DS . 'libraries/joomla/factory.php');
    $app = JFactory::getApplication('site');
    $app->initialise();
    jimport('joomla.filesystem.file');
    jimport('joomla.filesystem.folder');

    class ZTContactXml
    {

        var $moduleId;
        var $element;

        function __construct($element, $moduleId)
        {
            $this->moduleId = $moduleId;
            $this->element = $element;
        }

        function writeXmlData()
        {
            $valid = 1;
            if (count($this->element))
            {
                $fileOrder = JRequest::getVar('fieldorder');
                $exfield = explode('|', $fileOrder);
                $data = "<contact version=\"1\" xmlns=\"http://xspf.org/ns/0/\">
	 						<elementList>\n";
                foreach ($exfield as $order)
                {
                    if ($order != '')
                    {
                        if (@$this->element[$order]['type'] != '')
                        {
                            $data .= "<param>\n
						 								<type>" . $this->element[$order]['type'] . "</type>\n";
                            if ($this->element[$order]['type'] != 'text')
                            {
                                $data .= "<fieldtitle><![CDATA[" . $this->element[$order]['fieldtitle'] . "]]></fieldtitle>\n
						 								<fieldname><![CDATA[" . $this->element[$order]['fieldname'] . "]]></fieldname>\n
						 								<valid>" . $this->element[$order]['required'] . "</valid>\n";
                            }
                            if ($this->element[$order]['type'] == 'textfield')
                            {
                                $data .= "<size>" . $this->element[$order]['size'] . "</size>\n
						 								<length>" . $this->element[$order]['maxlength'] . "</length>\n";
                            }
                            if ($this->element[$order]['type'] == 'textarea')
                            {
                                $data .= "<cols>" . $this->element[$order]['cols'] . "</cols>\n
					 					        		<rows>" . $this->element[$order]['rows'] . "</rows>\n";
                            }
                            if ($this->element[$order]['type'] == 'radio')
                            {
                                foreach ($this->element[$order]['value'] as $value)
                                {
                                    $data .= "<value><![CDATA[" . $value . "]]></value>\n";
                                }
                            }
                            if ($this->element[$order]['type'] == 'selected')
                            {
                                $data .= "<size>" . $this->element[$order]['size'] . "</size>\n
						 					  			<multi>" . $this->element[$order]['multi'] . "</multi>\n";
                                foreach ($this->element[$order]['value'] as $value)
                                {
                                    $data .= "<value><![CDATA[" . $value . "]]></value>\n";
                                }
                            }
                            if ($this->element[$order]['type'] == 'checkbox')
                            {
                                foreach ($this->element[$order]['value'] as $value)
                                {
                                    $data .= "<value><![CDATA[" . $value . "]]></value>\n";
                                }
                            }
                            if ($this->element[$order]['type'] == 'text')
                            {
                                $data .= "<intro><![CDATA[" . $this->element[$order]['fieldtext'] . "]]></intro>\n";
                            }
                            $data .="</param>\n";
                        }
                    }
                }

                $data.="</elementList>
	 					</contact>";
                $this->exeWriteXmlData($data);
            } else
            {
                $valid = 0;
            }
            return $valid;
        }

        function exeWriteXmlData($data)
        {
            $xml = JPATH_BASE . DS . 'modules' . DS . 'mod_zt_contact_pro' . DS . 'assets' . DS . 'data' . DS . 'contact' . $this->moduleId . '.xml';
            if (JFile::write($xml, $data))
                return true;
            else
            {
                echo 'Write file error';
            }
        }

    }

    $element = JRequest::getVar('element');
    $moduleId = JRequest::getVar('module_id');
    $ztContactXml = new ZTContactXml($element, $moduleId);
    $valid = $ztContactXml->writeXmlData();
}
