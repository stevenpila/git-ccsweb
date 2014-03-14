<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privileges extends MY_Controller{
    public function __construct() {
        parent::__construct();

        $this->load->model('privileges_model','privileges');
    }

    public function index(){
    	$this->data['user_privileges'] = $this->privileges->get_all_user_privileges();
    	$this->data['privileges'] = $this->privileges->get_all_privileges();
    	$this->data['user_types'] = $this->user_type->get_all_user_types();
    }

    public function set_privileges(){
    	if($data = $this->input->post(NULL,TRUE)){
    		extract($data);

    		foreach($user_types as $user_type){
                foreach($privileges as $privilege){
                    if($this->privileges->is_user_privileges_exists($user_type, $privilege)) continue;
                    
                    $this->privileges->add_user_privileges($user_type, $privilege);
                }
            }
    	}

    	redirect('privileges');
    }

    public function delete_privileges(){
        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            foreach($delete_privileges as $key => $delete_privilege)
            $this->privileges->delete_user_privileges($delete_privilege);
        }

        redirect('privileges');
    }
}
?>