<?php

class Profile extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->model('profile_model','profile');
        $this->load->model('forum_model','forum');
    }
    
    public function index($username = FALSE){
        if($username){
            if($user = $this->profile->get_all_user_information_by_username($username)){ 
                $user_id = $user->profile_user_id;
                $this->data['is_search'] = TRUE;
            }
            else 
                $user_id = $this->authentication->user_id();
        }
        else{
            $user_id = $this->authentication->user_id();
        }

        $this->data['profile_details'] = $user_info = $this->profile->get_all_user_information_by_id($user_id);
        $this->data['forums'] = $this->forum->get_all_thread_by_id($user_id);
        $this->data['comments'] = $this->forum->get_all_comments_by_id($user_id);

        $this->data['status'] = $this->session->flashdata('profile_update');
    }
    
    public function upload(){
        $user_id = $this->authentication->user_id();
        $this->profile->upload_profile_picture($user_id);
        
//        $this->view = false;
        redirect('profile');
    }
    
    public function update_information(){
        $status = 0;

        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            $user_id = $this->authentication->user_id();
            
            $birthdate = ($birthdate) ? ($birthdate == '' || $birthdate == '0000-00-00') ? NULL : $birthdate : NULL;


            $data = array(
                'firstname' => $firstname,
                'middlename' => (trim($middlename) != '')?$middlename:NULL,
                'lastname' => $lastname,
                'birthdate' => $birthdate
            );
            
            if($this->account->update_user($user_id,$data)) $status = 1;
        }

        $this->session->set_flashdata('profile_update', $status);
        
        redirect('profile');
        // echo json_encode(array('status' => $status));
        
        // $this->view = false;
    }

    public function update_account(){
        $status = 0;

        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            $user_id = $this->authentication->user_id();
            
            $data = array(
                'password' => $newpassword
            );
            
            if($this->account->update_user($user_id,$data)) $status = 1;
        }

        $this->session->set_flashdata('profile_update', $status);
        
        redirect('profile');
    }

    public function update_email(){
        $status = 0;

        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            $user_id = $this->authentication->user_id();

            $data = array(
                'email' => $newemail
            );
            
            if($this->account->update_user($user_id,$data)) $status = 1;
        }

        $this->session->set_flashdata('profile_update', $status);
        
        redirect('profile');
    }
    
    public function update_company(){
        $status = 0;

        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            $user_id = $this->authentication->user_id();

            $data = array(
                'companyname' => $cname,
                'companyaddress' => $caddress,
                'companyemail' => $cemail,
                'companywebsite' => $cwebsite,
                'companycontactnumber' => $cnumber,
                'companyposition' => $cposition
            );
        
            
            if($this->account->update_user_company_profile($user_id,$data)) $status = 1;
        }

        $this->session->set_flashdata('profile_update', $status);
        
        redirect('profile');
    }

     public function get_all_users(){
        $user_id = $this->authentication->user_id();

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            $users = $this->profile->get_all_users_by_name($search);
        }
        
        // $users = $this->profile->get_all_users($user_id);

        echo json_encode($users);

        $this->view = false;
     }
    
    /********************
      
        AJAX FUNCTION
     
     *********************/
    
    
    public function update_current_profile_picture(){
        $user_id = $this->authentication->user_id();
        if($this->input->post('key')){
            extract($this->input->post(NULL,TRUE));
            if($this->profile->update_profile_picture($key,$user_id)){
                $status = 1;
            }
            else{
                $status = 0;
            }
            echo json_encode(array('status'=>$status));
        }
        
        $this->view = false;
    }
    
    public function check_if_password_is_correct(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            $user_id = $this->authentication->user_id();

            if(password_verify($password, $this->authentication->user_data()->password)){
                $status = 1;
            }
            else{
                $status = 0;
            }
            
            echo json_encode(array('status'=>$status));
        }
        
        $this->view = false;
    }

    public function remove_current_profile_picture(){
        $user_id = $this->authentication->user_id();
        if($this->input->post('key')){
            extract($this->input->post(NULL,TRUE));
            if($this->profile->remove_profile_picture($key,$user_id)){
                $status = 1;
            }
            else{
                $status = 0;
            }
            echo json_encode(array('status'=>$status));
        }
        
        $this->view = false;
    }
    
}
?>
