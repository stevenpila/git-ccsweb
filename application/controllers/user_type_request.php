<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_type_request extends MY_Controller{
    public function __construct() {
        parent::__construct();

        $this->load->model('account_model','account');
        $this->load->model('request_user_type_model','user_type');
    }
    
    public function index(){
        $this->data['user_type_requests'] = $this->user_type->get_all_requests();
    }

    public function show_user_request_information(){
    	if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));

            $this->data['user_request'] = $request = $this->user_type->get_request_by_id($req_id);
            $this->data['user_types'] = $this->user_type->get_all_user_types();
            $this->data['services'] = $this->account->get_all_services();

            if($request->usertypeid == 3){
                $this->data['service_type'] = $this->account->get_service_type_by_id($request->userid);
                $this->data['company_profile'] = $this->account->get_company_data_by_id($request->userid);
            }elseif($request->usertypeid == 2) $this->data['service_type'] = $this->account->get_service_type_by_id($request->userid);
        }

        $this->view = 'user_type_request/show_user_request_information';
    }

    /***********************************

                AJAX FUNCTION

    ***********************************/

    public function approve_decline_recall_request(){
        $status = 0;

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            if($this->user_type->approve_deny_request_by_id(($confirm == 0)?NULL:$user_type_id, $req_id, $this->datetime->format('Y-m-d H:i:s'), $confirm)) $status = 1;

            if($confirm == 0){
                if($user_type_id == 2 || $user_type_id == 3) $this->account->approve_deny_service_request_by_id($service_detail_id, $confirm, NULL);
                $this->account->update_user_type_by_id($user_id, 7);
                $user_type = $this->authentication->user_type($cur_user_type_id);
            }else{
                if($user_type_id == 2 || $user_type_id == 3) $this->account->approve_deny_service_request_by_id($service_detail_id, $confirm, $service_type_id);
                if($user_type_id == 3 && $confirm == 2){
                    if(!$this->account->get_company_data_by_id($user_id)) $this->account->add_new_user_company_profile($user_id,NULL,NULL,NULL,NULL,NULL,NULL);
                }
                $user_type = $this->authentication->user_type($user_type_id);
                $this->account->update_user_type_by_id($user_id, $user_type_id);
            }
        }

        echo json_encode(array('status' => $status, 'date_affirmed' => $this->datetime->format('F d, Y'), 'user_type' => $user_type));

        $this->view = false;
    }
}
?>