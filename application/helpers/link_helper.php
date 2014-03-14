<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * string to permalink
 * 
 * converts a string to a user friendly perma link
 * 
 * @source  string  http://www.tuttoaster.com/how-to-create-a-forum-in-php-from-scratch/
 * @param   string
 * @return  link   
 */

if(!function_exists('strtopermalink')){
    function strtopermalink($str){
		$permalink = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$permalink = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $permalink);
		$permalink = strtolower(trim($permalink, '-'));
		$permalink = preg_replace("/[\/_|+ -]+/", '_', $permalink);

		return $permalink;
    }
}

/**
 * 
 * string clean
 * 
 * remove slashes if magic_quotes_gpc is enabled and escaping some characters with mysql_real_escape_string
 * 
 * @source  string  http://www.tuttoaster.com/how-to-create-a-forum-in-php-from-scratch/
 * @param   string
 * @return  string   
 */

if(!function_exists('strclean')){
    function strclean($value){
	// Stripslashes
	if (get_magic_quotes_gpc()){
            $value = stripslashes( $value );
	}

	// Quote if not a number or a numeric string
	if (!is_numeric($value) && !empty($value)){
            $value = mysql_real_escape_string($value);
	}
        
	return $value;
    }
}
