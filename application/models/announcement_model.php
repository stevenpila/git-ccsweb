<?php

class Announcement_model extends CI_Model{
    private $datetime;

    public function __construct() {
        parent::__construct();

        $this->datetime = new DateTime();
    }
    
    //create new announcement
    public function add_new_announcement($user_id, $topic, $detail, $all_file_names, $date){
        $data = array(
            'user_id' => $user_id,
            'topic' => strip_tags($topic),
            'detail' => strip_tags($detail,"<b><i><u><font><blockqoute><ul><ol><li><table><thead><tbody><tr><th><td><tfoot><img><span><div><br><br/><br />"),
            'file_attachments' => $all_file_names,
            'date_posted' => $date
        );
        
        $this->db->insert('ccs_announcements',$data);
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    
    //edit announcement by id
    public function edit_announcement_by_id($ann_id, $detail, $all_file_names){
        $detail = strip_tags($detail,"<b><i><u><font><blockqoute><ul><ol><li><table><thead><tbody><tr><th><td><tfoot><img><span><div><br><br/><br />");
        
        $this->db->query("UPDATE ccs_announcements SET detail = ?, file_attachments = ? WHERE id = ?", array($detail, $all_file_names, $ann_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    
    //delete announcement by id
    public function delete_announcement_by_id($ann_id){
        $this->db->query("DELETE FROM ccs_announcements WHERE id = ?", array($ann_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    
    //get all announcements
    public function get_all_announcements(){
        $query = $this->db->query("SELECT ca.*, cnu.datecreated as author_date_joined, cnu.usertype as author_user_type, cnu.profilepicture as author_pic, 
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as author_name,
            (SELECT COUNT(*) FROM ccs_announcements cca WHERE cca.id = ca.id) as posts 
            FROM ccs_announcements ca 
            INNER JOIN ccs_nonmoodle_user cnu ON cnu.id = ca.user_id 
            ORDER BY ca.pinned DESC, ca.date_posted DESC, ca.id DESC");
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    
    //get announcement by id
    public function get_announcement_by_id($ann_id){
        $query = $this->db->query("SELECT ca.*, cnu.datecreated as date_joined, cnu.profilepicture as author_pic, 
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as author_name
            FROM ccs_announcements ca 
            INNER JOIN ccs_nonmoodle_user cnu ON cnu.id = ca.user_id WHERE ca.id = ? LIMIT 1", array($ann_id));
        
        return $query->row();
    }
    
    //get announcement by title / ok
    public function get_announcement_by_topic($topic){
        $query = $this->db->query("SELECT * FROM ccs_announcements WHERE topic = ? LIMIT 1", array(trim(strip_tags($topic))));
        
        return ($query->num_rows())?1:0;
    }
    
    //pin announcement by id
    public function pin_announcement_by_id($ann_id){
        $pinned = $this->get_pinned_announcement();
        
        if($pinned) $this->db->query('UPDATE ccs_announcements SET pinned = 0 WHERE id = ?', array($pinned->id));
        
        $this->db->query('UPDATE ccs_announcements SET pinned = 1 WHERE id = ?', array($ann_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    
    //unpin announcement by id
    public function unpin_announcement_by_id($ann_id){
        $this->db->query('UPDATE ccs_announcements SET pinned = 0 WHERE id = ?', array($ann_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    
    //get pinned announcement
    public function get_pinned_announcement(){
        $query = $this->db->query('SELECT * FROM ccs_announcements WHERE pinned = 1 LIMIT 1');
        
        return ($query->num_rows())?$query->row():FALSE;
    }

    public function upload_file_attachment($user_or_ann_id, $topic, $detail, $attachments = NULL, $type = 'add'){
        $path = './uploads/files/announcement/' . md5(strip_tags($topic)) . '/';
        if(!is_dir($path)) mkdir ($path, 0755, TRUE);
        
        $config['upload_path']      = './uploads/files/announcement/' . md5(strip_tags($topic)) . '/';
        $config['allowed_types']    = '*';
        $config['max_size']         = '5000';
        
        $this->load->library('upload', $config);
        
        if(!$this->upload->do_multi_upload('userfile')){
            if($type == 'add') rmdir($path);
            $this->session->set_flashdata('announcement_upload_error', $this->upload->display_errors()); //set session for create announcement error
            
            redirect(base_url() . 'announcement?error=1');
        }
        else{
            if($files = $this->upload->get_multi_upload_data()){
                $file_name = array();

                foreach($files as $file){
                    array_push($file_name, 'uploads/files/announcement/' . md5(strip_tags($topic)) . '/' . $file['file_name']);
                }
                $all_file_names = implode(' ', $file_name);
            }
            else{
                $file = $this->upload->data();
                $all_file_names = $file['file_name'];
            }

            $all_file_names .= ($attachments)?" $attachments":"";
            
            if($type == 'add') $this->add_new_announcement($user_or_ann_id,$topic,$detail,$all_file_names,$this->datetime->format('Y-m-d H:i:s'));
            else if($type == 'edit') $this->edit_announcement_by_id($user_or_ann_id,$detail,$all_file_names);
        }
    }
}
?>
