<?php

class Poll_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    // add new poll /ok
    public function add_new_poll($user_id,$topic,$date,$expire){
        $data = array(
            'user_id' => $user_id,
            'topic' => strip_tags($topic),
            'date_posted' => $date,
            'expiration' => ($expire) ? $expire : NULL
        );

        $this->db->insert('ccs_polls',$data);
        
        return ($this->db->affected_rows())?$this->db->insert_id():FALSE;
    }
    // add new options of poll by poll id /ok
    public function add_poll_options_by_id($poll_id,$option){
        $data = array(
            'poll_id' => $poll_id,
            'option' => strip_tags($option)
        );
        
        $this->db->insert('ccs_poll_options', $data);
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    // add new voter /ok
    public function add_new_poll_voter_by_id($user_id,$poll_id,$option_id){
        $data = array(
            'user_id' => $user_id,
            'poll_id' => $poll_id,
            'option_id' => $option_id
        );
        
        $this->db->insert('ccs_poll_voters',$data);
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    // update poll option vote by id
    public function update_poll_option_vote_by_id($option_id){
        $this->db->query("UPDATE ccs_poll_options SET votes = votes + 1 WHERE id = $option_id");
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    // update close or open poll by id
    public function update_close_open_poll_by_id($poll_id,$status){
        $this->db->query("UPDATE ccs_polls SET status = ? WHERE id = ?", array($status, $poll_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    // delete poll by its id /ok
    public function delete_poll_by_id($poll_id){
        $this->db->query("DELETE FROM ccs_polls WHERE id = ?", array($poll_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    // delete options of poll by poll id
    public function delete_poll_options_by_id($poll_id){
        $this->db->query("DELETE FROM ccs_poll_options WHERE poll_id = ?", array($poll_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    // delete voters of option by
    public function delete_poll_option_voters_by_id($poll_id){
        $this->db->query("DELETE FROM ccs_poll_voters WHERE poll_id = ?", array($poll_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    // get all options of poll by poll id /ok
    public function get_all_poll_options_by_id($poll_id){
        $query = $this->db->query("SELECT * FROM ccs_poll_options WHERE poll_id = $poll_id");
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    // get all polls /ok
    public function get_all_polls(){
        $query = $this->db->query("SELECT cp.*, cnu.usertype as author_user_type, cnu.datecreated as date_joined, cnu.profilepicture as author_pic,  
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as author_name
            FROM ccs_polls cp 
            INNER JOIN ccs_nonmoodle_user cnu ON cnu.id = cp.user_id 
            ORDER BY cp.date_posted DESC, cp.id DESC");
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    // get poll by topic name
    public function get_poll_by_name($topic){
        $query = $this->db->query("SELECT * FROM ccs_polls WHERE topic = ? LIMIT 1", array($topic));
        
        return ($query->num_rows())?$query->row():FALSE;
    }

    //ccs.com
    // get status of poll by id /ok
    public function get_poll_status_by_id($poll_id){
        $query = $this->db->query("SELECT * FROM ccs_polls WHERE id = ? LIMIT 1", array($poll_id));

        return ($query->num_rows())?$query->row()->status:FALSE;
    }
    // has user voted this poll /ok
    public function is_user_voted_poll_by_id($user_id, $poll_id){
        $query = $this->db->query("SELECT * FROM ccs_poll_voters WHERE user_id = ? AND poll_id = ?", array($user_id,$poll_id));
        
        return ($query->num_rows())?TRUE:FALSE;
    }
    // has user voted this poll option /ok
    public function is_user_voted_poll_option_by_id($user_id, $poll_id, $option_id){
        $query = $this->db->query("SELECT * FROM ccs_poll_voters WHERE user_id = ? AND poll_id = ? AND option_id = ? LIMIT 1", array($user_id,$poll_id,$option_id));
        
        return ($query->num_rows())?TRUE:FALSE;
    }
    // close all poll if expiration date is met
    public function close_poll_by_expiration_date($date){
        $query = $this->db->query("UPDATE ccs_polls SET status = 'Closed' WHERE expiration <= ?", array($date));
    }
}
?>
