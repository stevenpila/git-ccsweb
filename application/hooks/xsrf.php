<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xsrf
{
    private $CI;
    private static $token_name = 'xsrf_token';
    private static $token;

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function generate_token() {        
        $temp = $this->CI->session->userdata(self::$token_name);

        if ($temp === FALSE || empty($temp)) {
            $rand_str = random_string('unique');
            self::$token = 'd3rp' . sha1($rand_str . 'c00lk!d') . md5('c00lk!d' . $rand_str);
            $this->CI->session->set_userdata(self::$token_name, self::$token);
        }
        else {
            self::$token = $temp;
        }
    }
  
    public function validate_token() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $posted_token = $this->CI->input->post(self::$token_name);
            $temp = $this->CI->session->userdata(self::$token_name);

            if (empty($posted_token) || $posted_token != $temp) {
                show_error('Bad request. Access denied!', 400);
            }
        }
    }

    public function inject_token() {
        $output = $this->CI->output->get_output();
  
        // Inject into <form>
        $output = preg_replace('/(<\/(form|FORM)>)/',
                             '<input type="hidden" name="' . self::$token_name . '" value="' . self::$token . '">' . '$0',
                             $output);

        // Inject into <head>
        // '<meta name="xsrf-name" content="' . self::$token_name . '">' . "\n" . 
        $output = preg_replace('/(<\/(head|HEAD)>)/',
                             '<meta name="xsrf-token" content="' . self::$token . '">' . "\n" . '$0',
                             $output);

        $this->CI->output->_display($output);
    }
}