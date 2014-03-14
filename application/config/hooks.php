<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = array(
  'class'    => 'Xsrf',
  'function' => 'validate_token',
  'filename' => 'xsrf.php',
  'filepath' => 'hooks'
);
 
$hook['post_controller_constructor'][] = array(
  'class'    => 'Xsrf',
  'function' => 'generate_token',
  'filename' => 'xsrf.php',
  'filepath' => 'hooks'
);
 
$hook['display_override'] = array(
  'class'    => 'Xsrf',
  'function' => 'inject_token',
  'filename' => 'xsrf.php',
  'filepath' => 'hooks'
);


/* End of file hooks.php */
/* Location: ./application/config/hooks.php */