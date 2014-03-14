<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Session extends CI_Session {
    public $CI;
    
    /*
     * Do not update an existing session on ajax calls
     *
     * @access    public
     * @return    void
     */
    function sess_update(){
        $this->CI = & get_instance();

        if(!$this->CI->input->is_ajax_request()){
            parent::sess_update();
        }
    }
}

?>
