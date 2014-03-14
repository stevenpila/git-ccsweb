<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha{

    private $CI;
    
    public function __construct(){
        $this->CI = & get_instance();
    }

    public function generate(){
    	$captcha = $this->initialize_captcha();
    	$captcha_id = $this->save_captcha($captcha);

    	return array(
            'captcha_id' => $captcha_id,
            'captcha' => $captcha['image']
        );
    }

    public function initialize_captcha(){
    	$data = array(
		    'img_path' => './captcha/',
		    'img_url' => base_url() . 'captcha/',
		    'font_path' => './system/fonts/texb.ttf',
		    'img_width' => '150',
		    'img_height' => 30,
		    'expiration' => 7200
	    );

	    return create_captcha($data);
    }

    public function validate_captcha($captcha_id, $captcha, $ip_address){
    	// first, delete old captchas
		$expire = time() - 7200; // Two hour limit
		$this->delete_captcha($expire);

		// then see if a captcha exists
		$query = $this->CI->db->query("SELECT COUNT(*) AS count FROM ccs_captcha WHERE word = ? AND ip_address = ? AND time > ? AND id = ?", array($captcha, $ip_address, $expire, $captcha_id));

		return ($query->row()->count == 0) ? 0 : 1;
    }

    public function save_captcha($captcha){
    	$data = array(
    		'time' => $captcha['time'],
    		'ip_address' => $this->CI->input->ip_address(),
    		'word' => $captcha['word']
		);

    	$query = $this->CI->db->insert_string('ccs_captcha', $data);
    	$this->CI->db->query($query);

        return $this->CI->db->insert_id();
    }

    public function delete_captcha($expire){
		$this->CI->db->query("DELETE FROM ccs_captcha WHERE time < " . $expire);
    }
}
?>