<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->model('account_model','account');
        $this->load->model('request_user_type_model','user_type');
    }
    
    public function index(){
        redirect('account/login');
    }
    
    public function login(){
/*        echo password_hash('Pila.201000148', PASSWORD_DEFAULT, array('cost' => 4));
        $salt = var_export($this->complex_random_string(), true);
        echo 'md5: '. md5('Pila.201000148') . ' ' . strlen(md5('Pila.201000148'));
        echo '<br>export: '. md5('Pila.201000148' . $salt) . ' ' . strlen(md5('Pila.201000148' . $salt));
        echo '<br>moodle: '. md5('Pila.201000148' . 'moodle') . ' ' . strlen(md5('Pila.201000148' . 'moodle'));
        echo '<br>random: '. md5('Pila.201000148' . 'a_very_long_random_string_of_characters#@6&*1') . ' ' . strlen(md5('Pila.201000148' . 'a_very_long_random_string_of_characters#@6&*1'));
*/        $this->authentication->redirect_home();
        
        if($this->input->get('error',TRUE)){
            if($this->session->flashdata('login_error')) $this->data['signin_status'] = FALSE;
            else redirect('account');
        }
        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            if(is_sanitize($username) && $user_id = $this->account->check_username_password($username, $password)){
                $datetime = $this->datetime->format('Y-m-d H:i:s');
                $this->account->update_last_login($user_id, $datetime);
                $this->authentication->set_user_id($user_id); //set session
                $this->session->set_userdata('email_notif',TRUE); 
                $this->authentication->redirect_home();
            }
            else{
                $this->session->set_flashdata('login_error','true'); //set session for login error                
                redirect(base_url() . 'account/login?error=1');
            }
        }
        
        $this->data['secret_questions'] = $this->account->get_secret_questions();
        $this->data['service_types'] = $this->account->get_all_services();
        $this->data['captcha'] = $this->captcha->generate();
        
        $this->view = 'account/login';
    }

    function complex_random_string($length=null) {
        $pool  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $pool .= '`~!@#%^&*()_+-=[];,./<>?:{} ';
        $poollen = strlen($pool);
        mt_srand ((double) microtime() * 1000000);
        if ($length===null) {
            $length = floor(rand(24,32));
        }
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $pool[(mt_rand()%$poollen)];
        }
        return $string;
    }
    
    public function signup(){
        $this->authentication->redirect_home();
        
        if($data = $this->input->post(NULL,TRUE)){
            extract($data);
            
            if(are_sanitize($data, array($password,$confirm_password))){
                $datetime = $this->datetime->format('Y-m-d H:i:s');

                if($user_id = $this->account->add_new_user($first_name, $last_name, $email, $secret_question, $secret_answer, $username, password_hash($password, PASSWORD_DEFAULT, array()), $datetime)){
                    if($user_type < 7) {
                        $this->user_type->add_request($user_id, $user_type, $datetime);

                        if($user_type == 2) { $this->account->add_new_service_detail($user_id, $service_type); }
                        else if($user_type == 3) {
                            $this->account->add_new_user_company_profile($user_id, $company_name, $company_address, $company_email, $company_website, $company_contact_number, $company_position);
                            $this->account->add_new_service_detail($user_id, $company_service_type);
                        }
                    }

                    $this->authentication->set_user_id($user_id);// set session

                    $this->authentication->redirect_home();
                }
            }
            else {
                $this->data['signup_status'] = FALSE;
            }
        }
        
        $this->authentication->redirect_account();
    }
    
//    function password_is_legacy_hash($password) {
//        return (bool) preg_match('/^[0-9a-f]{32}$/', $password);
//    }
    
    public function logout(){
        $this->account->update_last_logout($this->authentication->user_id(), $this->datetime->format('Y-m-d H:i:s'));
        
        $this->authentication->do_logged_out();
        $this->authentication->redirect_account();
    }
    
    /**************************************
     
                AJAX FUNCTIONS
      
     **************************************/
    
    public function ajax_moodle_login(){
        $status = 0;

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            if(is_sanitize($username) && $this->account->check_moodle_username_password($username,$password)){
                $status = 1;
            }
        }
                    
        echo json_encode(array('status' => $status));
        
        $this->view = false;
    }
    
    public function is_username_available(){
        $status = 0;

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);
            
            if(is_sanitize($username) && $this->account->check_username_if_available($username)) $status = 1;
        }
        
        echo json_encode(array('status' => $status));
        
        $this->view = false;
    }
    
    public function check_moodle(){
        if($data = $this->input->post(NULL,TRUE)){
            extract($data);
            
            if($moodle = $this->account->check_user_id_by_moodlesession($moodlesession))
                echo $moodle->firstname.' '.$moodle->lastname;
            else
                echo 0;
        }
        $this->view = false;
    }
    
    public function verify_captcha_and_topic(){
        $captcha  = 0;
        
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));

            $captcha = $this->captcha->validate_captcha($captcha_id, $captcha, $this->input->ip_address());
        }

        echo json_encode(array('status' => $captcha));

        $this->view = false;
    }

    // checks if user is still logged in
    public function is_logged_in(){
        $status = ($this->authentication->is_logged_in()) ? 1 : 0;

        echo json_encode(array('status' => $status));

        $this->view = false;
    }

    # forgot password
    public function forgot_password() {
        $ret = FALSE;
        $user = $new_pwd = NULL;

        if($data = $this->input->post(NULL,TRUE)) {
            $data = sanitize_all($data);
            extract($data);
            $user = $this->forgot_lib->forgot_pwd_request($forgot_password_email_username,$forgot_password_secret_question,$forgot_password_secret_answer);

            if($user == 1) {
                $new_pwd = $this->forgot_lib->reset_password($forgot_password_email_username);

                if(!empty($new_pwd)) {
                    $ret = TRUE;
                }
            }
        }

        echo json_encode(array('status' => $ret, 'password' => $new_pwd, 'usertype' => $user));
        $this->view = FALSE ;
    }

    # send the confirmation code
    public function send_the_confirmation_code() {
        $ret = 0;
        
        if($data = $this->input->post(NULL,TRUE)) {
            $data = sanitize_all($data);
            extract($data);
            $ret = $this->forgot_lib->send_confirmation_code($forgot_secret_answer_email_username);
        }

        echo json_encode(array('status' => $ret));
        $this->view = FALSE;
    }

    # validate confirmation code
    public function validate_confirmation_code() {
        $ret = FALSE;
        
        if($data = $this->input->post(NULL,TRUE)) {
            $data = sanitize_all($data);
            extract($data);

            if($this->forgot_lib->verify_confirmation_code($forgot_secret_answer_email_username,$forgot_secret_answer_confirmation_code)) {
                $ret = TRUE;
            }
        }
        echo json_encode(array('status' => $ret));
        $this->view = FALSE;
    }    

    # forgot secret answer
    public function forgot_secret_answer() {
        $ret = FALSE;

        if($data = $this->input->post(NULL,TRUE)) {
            $data = sanitize_all($data);
            extract($data);

            # if confirmation code was deleted and password was changed
            if($this->account->delete_confirmation_code($forgot_secret_answer_email_username) && $this->forgot_lib->change_password($forgot_secret_answer_email_username,$forgot_secret_answer_new_password)) {
                $ret = TRUE;
            }
        }

        echo json_encode(array('status' => $ret));
        $this->view = FALSE;
    }

    # check if valid email for notification
    public function is_valid_email() {
        $ret = TRUE;
        $email_notif = $this->session->userdata('email_notif');
        $email_notif = sanitize($email_notif);

        if($email_notif) {
            $user_id = $this->authentication->user_id();
            $data = $this->account->check_valid_email($user_id);

            if($data->validemail) {
                $ret = FALSE;
            }        
        }

        echo json_encode(array('invalid' => $ret, 'email_notification' => $email_notif));
        $this->view = FALSE;
    }

    # toggle email notification
    public function toggle_notif() {
        $this->session->unset_userdata('email_notif');
        echo json_encode(array('status' => TRUE));
        $this->view = FALSE;
    }

    # set service url
    public function set_url() {
        $ret = FALSE;

        if($data = $this->input->post(NULL,TRUE)) {
            $data = sanitize_all($data);
            extract($data);
            $ret = $this->account->set_service_url($service_name,$service_url);
        }

        echo json_encode(array('status' => $ret));
        $this->view = FALSE;
    }

     # set new service name
    public function reset_service_name() {
        $ret = FALSE;

        if($data = $this->input->post(NULL,TRUE)) {
            $data = sanitize_all($data);
            extract($data);
            $ret = $this->account->reset_new_service_name($service_name,$new_service_name);
        }

        echo json_encode(array('status' => $ret));
        $this->view = FALSE;
    }

    # delete a service
    public function delete_service() {
        $ret = FALSE;

        if($data = $this->input->post(NULL,TRUE)) {
            $data = sanitize_all($data);
            extract($data);
            $ret = $this->account->delete_service_name($service_name);
        }

        echo json_encode(array('status' => $ret));
        $this->view = FALSE;
    }

    # add a service
    public function add_service() {
        $ret = FALSE;

        if($data = $this->input->post(NULL,TRUE)) {
            $data = sanitize_all($data);
            extract($data);
            $ret = $this->account->add_service_name($service_name);
        }

        echo json_encode(array('status' => $ret));
        $this->view = FALSE;
    }

    # validate user email
    public function validate_email() {
        $ret = 0;

        if($data = $this->input->post(NULL,TRUE)) {
            $data = sanitize_all($data);
            extract($data);
            $ret = $this->forgot_lib->send_validation_code($email);
        }

        echo json_encode(array('status' => $ret));
        $this->view = FALSE;        
    }

    # verify validation code
    public function verify_validation_code() {
        $ret = FALSE;
        
        if($data = $this->input->post(NULL,TRUE)) {
            $data = sanitize_all($data);
            extract($data);

            if($this->forgot_lib->verify_validation_code($email,$validation_code)) {
                $ret = TRUE;
            }
        }
        echo json_encode(array('status' => $ret));
        $this->view = FALSE;        
    }
}
?>
