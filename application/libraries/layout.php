<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layout{
    private $data = array();
    private $CI, $user_type_id;

    public function __construct(){
        $this->CI = & get_instance();        
        $this->CI->load->model('account_model','account');
    }
    
    public function view($page_path, $page_contents = "", $flag = FALSE) {
        $this->data['title'] = ucwords(str_replace("_", " ", get_class($this->CI)));
        $this->data['content'] = $this->CI->load->view($page_path, $page_contents, TRUE); 
        $this->data['approved_services'] = $this->get_services();
        $this->data['urls'] = $this->get_urls();
        $this->data['is_super'] = $this->user_type_id;
        
        return $this->CI->load->view('shared/layout', $this->data, $flag);
    }

    public function get_services() {
        $services = array();
        $this->user_type_id = $this->CI->authentication->user_type_id();
        $user_id = $this->CI->authentication->user_id();

        if($this->user_type_id != 1) {
            $temp = $this->CI->account->get_affirmed_service($user_id);
            //$services = explode(",","1,10,11");
            
            if(!empty($temp) && $temp->status == "Approved" && !empty($temp->affirmed_service_id)) {
                $services = explode(",", $temp->affirmed_service_id);
            }

        }

        return $services;
    }

    public function get_urls() {
        return $this->CI->account->get_all_urls();
    }
}
?>
