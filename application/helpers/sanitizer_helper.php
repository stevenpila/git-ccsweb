<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function sanitize($input = NULL) {
    	if(!empty($input)) {
	    	return filter_var(stripslashes(strip_quotes(reduce_double_slashes(trim_slashes(trim($input))))),FILTER_SANITIZE_STRIPPED);
		} 

		return FALSE;
	}

    function sanitize_all($inputs = array()) {
    	if(!empty($inputs)) {
	    	if(is_array($inputs)) {
		    	$temp = array();

			    foreach ($inputs as $key => $value) {
			    	$temp[$key] = sanitize($value);
			    }

		    	return $temp;
		    }
		    else {
		    	return sanitize($inputs);
		    }
		}

		return FALSE;
	}

    function is_sanitize($input = NULL) {
    	if(!empty($input)) {
	    	return ($input === sanitize($input));
		}

		return FALSE;
	}


    function are_sanitize($inputs = array(),$exclude = array()) {
		if(!empty($inputs)) {
			$ret = TRUE;

	    	if(is_array($inputs)) {
		    	foreach ($inputs as $key => $value) {
					$temp = TRUE;

		    		foreach ($exclude as $xkey => $xvalue) {
		    			if($value === $xvalue) {
		    				$temp = FALSE;
		    				break;
		    			}
		    		}

		    		if($temp && !is_sanitize($value)) {
		    			$ret = FALSE;
		    			break;
		    		}
		    	}
			}
			else {
				$ret = FALSE;
			}

	    	return $ret;
    	}

    	return FALSE;
	}

	function create_pass_code($len = 6) {
    	return random_string('alnum',$len);
    }

?>