<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication{
    private $CI;
    
    public function __construct(){
        $this->CI = & get_instance();
        
        $this->CI->load->model('account_model','account');
        $this->CI->load->model('request_user_type_model','user_type');
        $this->CI->load->model('privileges_model','privileges');
    }
    
    public function user_data(){
        $user_info = $this->CI->account->get_user_data_by_id($this->user_id());
        
        return $user_info;
    }
    
    public function user_name(){
        $user_name = $this->user_data();
        $user_name_middle = (!$user_name->middlename) ? ' ' : ' ' . $user_name->middlename . ' ';
        
        return ucwords($user_name->firstname . $user_name_middle . $user_name->lastname);
    }
    
    public function user_type_id(){
        if($this->is_logged_in())
            return $this->user_data()->usertype;
        
        return FALSE;
    }
    
    public function user_type($user_type_id = FALSE){
        $user_type = $this->CI->user_type->get_user_type_by_id((!$user_type_id) ? $this->user_type_id() : $user_type_id);
        
        return $user_type->name;
    }

    public function service_type($service_id){
        $service_type = $this->CI->account->get_service_type_by_its_id($service_id);

        return $service_type;
    }

    public function is_authorized($module, $method){
        $user_type_id = $this->user_type_id();
        $module_detail_id = $this->CI->privileges->get_service_and_service_function_by_id($module, $method);

        if($this->CI->privileges->is_user_privileges_exists_by_id($module_detail_id)){
            return $this->CI->privileges->is_user_privileges_exists($user_type_id, $module_detail_id);
        }else return TRUE;
    }

    public function is_authorized_by_name($module, $method){
        $module_id = $this->CI->privileges->get_services_by_name($module);
        $method_id = $this->CI->privileges->get_services_function_by_name($method);

        return $this->is_authorized($module_id, $method_id);
    }

    public function is_authorized_function_by_name($method_module_label){
        $module_method = explode('/', $method_module_label);
        $module = $module_method[0];
        $method = (isset($module_method[1]))?$module_method[1]:'index';

        return $this->is_authorized_by_name($module, $method);
    }

    public function is_authorized_link_by_name($method_module_label, $label, $class){
        $module_method = explode('/', $method_module_label);
        $module = $module_method[0];
        $method = (isset($module_method[1]))?$module_method[1]:'index';

        return ($this->is_authorized_by_name(ucwords(str_replace('_', ' ', $module)), $method))?'<li class="' . $class . '" style="display: list-item"><a href="' . base_url() . $method_module_label . '">' . $label . '</a></li>':'';
    }
    
    public function user_profile_picture(){
        $user_profile_picture = $this->user_data();
        
        return base_url() . $user_profile_picture->profilepicture;
    }

    public function user_id(){
        $user_id = $this->CI->session->userdata('user_id');
        
        return ($user_id)?$user_id:FALSE;
    }
    
    public function set_user_id($user_id){
        $this->CI->session->set_userdata('user_id', $user_id);
    }
    
    public function is_logged_in(){
        return ($this->CI->session->userdata('user_id'))?TRUE:FALSE;
    }
    
    public function do_logged_out(){
        $this->CI->session->unset_userdata('user_id');
        $this->CI->session->sess_destroy();
    }
    
    public function redirect_account(){
        if(!$this->is_logged_in())
            redirect('account');
    }
    
    public function redirect_home(){
        if($this->is_logged_in())
            redirect('home');
    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
