<?php

/**
 * @package ZT Contact Pro module for Joomla!
 * @author http://www.zootemplate.com
 * @copyright (C) 2015- ZooTemplate.Com
 * @license PHP files are GNU/GPL
 * */
defined('_JEXEC') or die('Restricted access');
if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

class modzt_contact_proHelper
{

    private $_params;

    public function __construct($params)
    {
        $this->_params = $params;
    }

    public function getList()
    {
        global $mainframe, $module_id;
        $db = JFactory::getDBO();
        $user = JFactory::getUser();
        $folder = JPATH_SITE . DS . 'modules' . DS . 'mod_zt_contact_pro' . DS . 'assets' . DS . 'data';
        $file = 'contact' . $module_id . '.xml';
        if (is_file($folder . DS . $file))
        {
            $api_url = JURI::root() . 'modules/mod_zt_contact_pro/assets/data/contact' . $module_id . '.xml';
            $xml = simplexml_load_file($api_url);
        } else
        {
            $api_url = JURI::root() . 'modules/mod_zt_contact_pro/assets/data/contact.xml';
            $xml = simplexml_load_file($api_url);
        }
        $elementlist = count($xml->elementList->param);
        $lists = array();
        for ($i = 0; $i < $elementlist; $i++)
        {
            $item = new stdClass();

            $item->type = $xml->elementList->param[$i]->type;
            $item->value = $xml->elementList->param[$i]->value;
            $item->fieldtitle = $xml->elementList->param[$i]->fieldtitle;
            $item->fieldname = $xml->elementList->param[$i]->fieldname;
            $item->valid = $xml->elementList->param[$i]->valid;
            $item->size = $xml->elementList->param[$i]->size;
            $item->length = $xml->elementList->param[$i]->length;
            $item->cols = $xml->elementList->param[$i]->cols;
            $item->rows = $xml->elementList->param[$i]->rows;
            $item->multi = $xml->elementList->param[$i]->multi;
            $item->intro = $xml->elementList->param[$i]->intro;

            $lists[$i] = $item;
        }
        return $lists;
    }

    public function generateKey($lenght = 15)
    {
        $time = 86400;
        $options = array(
            "expire" => $time,
        );
        $session = JFactory::getSession($options);
        $simbols = JURI::getInstance()->toString() . time();
        $simbols_lenght = strlen($simbols);
        $simbols_lenght--;
        $str_key = NULL;
        for ($x = 1; $x <= $lenght; $x++)
        {
            $position = rand(0, $simbols_lenght);
            $str_key .= substr($simbols, $position, 1);
        }

        $session->set('cptch_str_key', md5($str_key));
        $session->set('cptch_str_key_time', time());
    }

    public function wordConverting($number_string)
    {
        if (1 == $this->_params->get('cptch_difficulty_word'))
        {
            $htmlspecialchars_array = array();
            $htmlspecialchars_array['a'] = '&#97;';
            $htmlspecialchars_array['b'] = '&#98;';
            $htmlspecialchars_array['c'] = '&#99;';
            $htmlspecialchars_array['d'] = '&#100;';
            $htmlspecialchars_array['e'] = '&#101;';
            $htmlspecialchars_array['f'] = '&#102;';
            $htmlspecialchars_array['g'] = '&#103;';
            $htmlspecialchars_array['h'] = '&#104;';
            $htmlspecialchars_array['i'] = '&#105;';
            $htmlspecialchars_array['j'] = '&#106;';
            $htmlspecialchars_array['k'] = '&#107;';
            $htmlspecialchars_array['l'] = '&#108;';
            $htmlspecialchars_array['m'] = '&#109;';
            $htmlspecialchars_array['n'] = '&#110;';
            $htmlspecialchars_array['o'] = '&#111;';
            $htmlspecialchars_array['p'] = '&#112;';
            $htmlspecialchars_array['q'] = '&#113;';
            $htmlspecialchars_array['r'] = '&#114;';
            $htmlspecialchars_array['s'] = '&#115;';
            $htmlspecialchars_array['t'] = '&#116;';
            $htmlspecialchars_array['u'] = '&#117;';
            $htmlspecialchars_array['v'] = '&#118;';
            $htmlspecialchars_array['w'] = '&#119;';
            $htmlspecialchars_array['x'] = '&#120;';
            $htmlspecialchars_array['y'] = '&#121;';
            $htmlspecialchars_array['z'] = '&#122;';

            $simbols_lenght = strlen($number_string);
            $simbols_lenght--;
            $number_string_new = str_split($number_string);
            $converting_letters = rand(1, $simbols_lenght);
            while ($converting_letters != 0)
            {
                $position = rand(0, $simbols_lenght);
                $number_string_new[$position] = isset($htmlspecialchars_array[$number_string_new[$position]]) ? $htmlspecialchars_array[$number_string_new[$position]] : $number_string_new[$position];
                $converting_letters--;
            }
            $number_string = '';
            foreach ($number_string_new as $key => $value)
            {
                $number_string .= $value;
            }
            return $number_string;
        } else
            return $number_string;
    }

    public function displayCaptcha()
    {
        global $str_key, $cptch_time;
        $session = JFactory::getSession();

        $cptch_time = $session->get('cptch_str_key_time');
        $str_key = $session->get('cptch_str_key');

        // In letters presentation of numbers 0-9
        $number_string = array();
        $number_string[0] = 'zero';
        $number_string[1] = 'one';
        $number_string[2] = 'two';
        $number_string[3] = 'three';
        $number_string[4] = 'four';
        $number_string[5] = 'five';
        $number_string[6] = 'six';
        $number_string[7] = 'seven';
        $number_string[8] = 'eight';
        $number_string[9] = 'nine';
        // In letters presentation of numbers 11 -19
        $number_two_string = array();
        $number_two_string[1] = 'eleven';
        $number_two_string[2] = 'twelve';
        $number_two_string[3] = 'thirteen';
        $number_two_string[4] = 'fourteen';
        $number_two_string[5] = 'fifteen';
        $number_two_string[6] = 'sixteen';
        $number_two_string[7] = 'seventeen';
        $number_two_string[8] = 'eighteen';
        $number_two_string[9] = 'nineteen';
        // In letters presentation of numbers 10, 20, 30, 40, 50, 60, 70, 80, 90
        $number_three_string = array();
        $number_three_string[1] = 'ten';
        $number_three_string[2] = 'twenty';
        $number_three_string[3] = 'thirty';
        $number_three_string[4] = 'forty';
        $number_three_string[5] = 'fifty';
        $number_three_string[6] = 'sixty';
        $number_three_string[7] = 'seventy';
        $number_three_string[8] = 'eighty';
        $number_three_string[9] = 'ninety';
        // The array of math actions
        $math_actions = array();

        // If value for Plus on the settings page is set
        if (1 == $this->_params->get('cptch_math_action_plus'))
            $math_actions[] = '&#43;';
        // If value for Minus on the settings page is set
        if (1 == $this->_params->get('cptch_math_action_minus'))
            $math_actions[] = '&minus;';
        // If value for Increase on the settings page is set
        if (1 == $this->_params->get('cptch_math_action_increase'))
            $math_actions[] = '&times;';

        // Which field from three will be the input to enter required value
        $rand_input = rand(0, 2);
        // Which field from three will be the letters presentation of numbers
        $rand_number_string = rand(0, 2);
        // If don't check Word in setting page - $rand_number_string not display
        if (0 == $this->_params->get('cptch_difficulty_word'))
            $rand_number_string = -1;
        // Set value for $rand_number_string while $rand_input = $rand_number_string
        while ($rand_input == $rand_number_string)
        {
            $rand_number_string = rand(0, 2);
        }
        // What is math action to display in the form
        $rand_math_action = rand(0, count($math_actions) - 1);

        $array_math_expretion = array();

        // Add first part of mathematical expression
        $array_math_expretion[0] = rand(1, 9);
        // Add second part of mathematical expression
        $array_math_expretion[1] = rand(1, 9);
        // Calculation of the mathematical expression result
        switch ($math_actions[$rand_math_action])
        {
            case "&#43;":
                $array_math_expretion[2] = $array_math_expretion[0] + $array_math_expretion[1];
                break;
            case "&minus;":
                // Result must not be equal to the negative number
                if ($array_math_expretion[0] < $array_math_expretion[1])
                {
                    $number = $array_math_expretion[0];
                    $array_math_expretion[0] = $array_math_expretion[1];
                    $array_math_expretion[1] = $number;
                }
                $array_math_expretion[2] = $array_math_expretion[0] - $array_math_expretion[1];
                break;
            case "&times;":
                $array_math_expretion[2] = $array_math_expretion[0] * $array_math_expretion[1];
                break;
        }

        // String for display
        $str_math_expretion = "";
        // First part of mathematical expression
        if (0 == $rand_input)
            $str_math_expretion .= "<input id=\"cptch_input\" type=\"text\" autocomplete=\"off\" name=\"cptch_number\" value=\"\" maxlength=\"2\" size=\"2\" aria-required=\"true\" required=\"required\" style=\"margin-bottom:0;display:inline;font-size: 12px;width: 40px;\" class='required number form-control' />";
        else if (0 == $rand_number_string || 0 == $this->_params->get('cptch_difficulty_number'))
            $str_math_expretion .= $this->wordConverting($number_string[$array_math_expretion[0]]);
        else
            $str_math_expretion .= $array_math_expretion[0];

        // Add math action
        $str_math_expretion .= " " . $math_actions[$rand_math_action];

        // Second part of mathematical expression
        if (1 == $rand_input)
            $str_math_expretion .= " <input id=\"cptch_input\" type=\"text\" autocomplete=\"off\" name=\"cptch_number\" value=\"\" maxlength=\"2\" size=\"2\" aria-required=\"true\" required=\"required\" style=\"margin-bottom:0;display:inline;font-size: 12px;width: 40px;\" class='required number form-control' />";
        else if (1 == $rand_number_string || 0 == $this->_params->get('cptch_difficulty_number'))
            $str_math_expretion .= " " . $this->wordConverting($number_string[$array_math_expretion[1]]);
        else
            $str_math_expretion .= " " . $array_math_expretion[1];

        // Add =
        $str_math_expretion .= " = ";

        // Add result of mathematical expression
        if (2 == $rand_input)
        {
            $str_math_expretion .= " <input id=\"cptch_input\" type=\"text\" autocomplete=\"off\" name=\"cptch_number\" value=\"\" maxlength=\"2\" size=\"2\" aria-required=\"true\" required=\"required\" style=\"margin-bottom:0;display:inline;font-size: 12px;width: 40px;\" class='required number form-control' />";
        } else if (2 == $rand_number_string || 0 == $this->_params->get('cptch_difficulty_number'))
        {
            if ($array_math_expretion[2] < 10)
                $str_math_expretion .= " " . $this->wordConverting($number_string[$array_math_expretion[2]]);
            else if ($array_math_expretion[2] < 20 && $array_math_expretion[2] > 10)
                $str_math_expretion .= " " . $this->wordConverting($number_two_string[$array_math_expretion[2] % 10]);
            else
            {
                $str_math_expretion .= " " . $this->wordConverting($number_three_string[$array_math_expretion[2] / 10]) . " " . ( 0 != $array_math_expretion[2] % 10 ? $this->wordConverting($number_string[$array_math_expretion[2] % 10]) : '' );
            }
        } else
        {
            $str_math_expretion .= $array_math_expretion[2];
        }
        // Add hidden field with encoding result

        $str_math_expretion .= "<input type=\"hidden\" name=\"cptch_result\" value=" . $str = $this->encode($array_math_expretion[$rand_input], $str_key, $cptch_time) . "  class='required number form-control' />";
        $str_math_expretion .= "<input type=\"hidden\" name=\"cptch_time\" value=" . $cptch_time . " />";
        return $str_math_expretion;
    }

    public function encode($String, $Password, $cptch_time)
    {
        // Check if key for encoding is empty
        if (!$Password)
            die(JText::_("Encryption password is not set"));

        $Salt = md5($cptch_time, true);
        $String = substr(pack("H*", sha1($String)), 0, 1) . $String;
        $StrLen = strlen($String);
        $Seq = $Password;
        $Gamma = '';
        while (strlen($Gamma) < $StrLen)
        {
            $Seq = pack("H*", sha1($Seq . $Gamma . $Salt));
            $Gamma.=substr($Seq, 0, 8);
        }

        return base64_encode($String ^ $Gamma);
    }

}
