<?php

class Request_user_type_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    //add new request /ok
    public function add_request($userid, $usertypeid, $daterequested){
        $data = array(
            'userid' => $userid,
            'usertypeid' => $usertypeid,
            'daterequested' => $daterequested
        );
        
        $this->db->insert('ccs_request_user_types',$data);
        
        return ($this->db->affected_rows())?TRUE:FALSE;
        
    }
    //get all requests
    public function get_all_requests(){
        $query = $this->db->query("SELECT crut.*, (SELECT cut.name FROM ccs_user_types cut WHERE crut.usertypeid = cut.id) as user_type, 
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as requestor_name 
            FROM ccs_request_user_types crut 
            INNER JOIN ccs_nonmoodle_user cnu ON crut.userid = cnu.id
            ORDER BY crut.status DESC, crut.daterequested DESC, crut.id DESC");
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    //get all pending requests / ok
    public function get_all_pending_requests(){
        $query = $this->db->query("SELECT crut.*, (SELECT cut.name FROM ccs_user_types cut WHERE crut.usertypeid = cut.id) as user_type, 
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as requestor_name 
            FROM ccs_request_user_types crut 
            INNER JOIN ccs_nonmoodle_user cnu ON crut.userid = cnu.id
            WHERE crut.status = 'Pending'
            ORDER BY crut.daterequested DESC, crut.id DESC");
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    //get all affirmed requests
    public function get_all_affirmed_requests(){
        $query = $this->db->query("SELECT crut.*, 
            (SELECT cut.name FROM ccs_user_types cut WHERE crut.affirmedusertypeid = cut.id) as user_type, 
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as requestor_name 
            FROM ccs_request_user_types crut 
            INNER JOIN ccs_nonmoodle_user cnu ON crut.userid = cnu.id
            WHERE crut.status != 'Pending'
            ORDER BY crut.daterequested DESC, crut.id DESC");
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    // get request by its id /ok
    public function get_request_by_id($requestid){
        $query = $this->db->query("SELECT crut.*, cnu.profilepicture as profile_pic, 
            (SELECT cut.name FROM ccs_user_types cut WHERE crut.usertypeid = cut.id) as user_type, 
            (SELECT cut.name FROM ccs_user_types cut WHERE crut.affirmedusertypeid = cut.id) as affirmed_user_type, 
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as requestor_name 
            FROM ccs_request_user_types crut 
            INNER JOIN ccs_nonmoodle_user cnu ON crut.userid = cnu.id
            WHERE crut.id = ? LIMIT 1", array($requestid));
        
        return $query->row();
    }
    // affirm request
    public function approve_deny_request_by_id($usertypeid, $requestid, $date, $affirmrequest){
        if($affirmrequest == 2) $affirmrequest = 'Approved';
        elseif($affirmrequest == 1) $affirmrequest = 'Denied';
        else $affirmrequest = 'Pending';
        
        $this->db->query("UPDATE ccs_request_user_types set affirmedusertypeid = ?, status = ?, dateaffirmed = ? WHERE id = ?", array($usertypeid, $affirmrequest, $date, $requestid));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    
    // get all user types
    public function get_all_user_types(){
        $query = $this->db->query("SELECT * FROM ccs_user_types");
        
        return $query->result();
    }
    // get user type by its id
    public function get_user_type_by_id($usertypeid){
        $query = $this->db->query("SELECT * FROM ccs_user_types WHERE id = ? LIMIT 1", array($usertypeid));
        
        return $query->row();
    }
}
?>
