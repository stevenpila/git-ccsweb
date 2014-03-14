<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum_model extends CI_Model{
    private $datetime;

    public function __construct() {
        parent::__construct();

        $this->datetime = new DateTime();
    }
    //add new thread / ok
    public function add_new_thread($user_id, $topic, $detail, $all_file_names, $date){
        $data = array(
            'user_id' => $user_id,
            'topic' => strip_tags($topic),
            'detail' => strip_tags($detail,"<b><i><u><font><blockqoute><ul><ol><li><table><thead><tbody><tr><th><td><tfoot><img><span><div><br><br/><br />"),
            'file_attachments' => $all_file_names,
            'perma_link' => strtopermalink(strip_tags($topic)),
            'date_posted' => $date
        );
        
        $this->db->insert('ccs_forum_threads', $data);
        
        //return ($this->db->_error_number())?$this->db->_error_number():1;
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //edit thread by id / ok
    public function edit_thread_by_id($thread_id, $detail, $all_file_names){
        $detail = strip_tags($detail,"<b><i><u><font><blockqoute><ul><ol><li><table><thead><tbody><tr><th><td><tfoot><img><span><div><br><br/><br />");
        
        $this->db->query("UPDATE ccs_forum_threads SET detail = ?, file_attachments = ? WHERE id = ?", array($detail,$all_file_names,$thread_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //delete thread by id / ok
    public function delete_thread_by_id($thread_id){
        $this->db->query("DELETE FROM ccs_forum_threads WHERE id = ?",array($thread_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //get all threads / ok
    public function get_all_thread(){
        $query = $this->db->query("SELECT cft.*, cnu.usertype as author_user_type, cnu.datecreated as author_date_joined, cnu.profilepicture as author_pic, 
            (SELECT COUNT(*) FROM ccs_forum_comments cfc WHERE cfc.topic_id = cft.id) as comments, 
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as author_name
            FROM ccs_forum_threads cft 
            INNER JOIN ccs_nonmoodle_user cnu ON cnu.id = cft.user_id 
            ORDER BY cft.pinned DESC, cft.date_posted DESC, cft.id DESC");
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    //get all threads by permalink
    public function get_all_thread_by_permalink($perma_link){
        $query = $this->db->query("SELECT * FROM ccs_forum_threads WHERE perma_link = ? LIMIT 1",array($perma_link));
        
        return ($query->num_rows())?1:0;
    }
    //get all threads by user id /ok
    public function get_all_thread_by_id($user_id){
        $query = $this->db->query("SELECT * FROM ccs_forum_threads WHERE user_id = ? ORDER BY date_posted DESC, id DESC",array($user_id));
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    //get thread's information by its id / ok
    public function get_thread_by_id($thread_id){
        $query = $this->db->query("SELECT cft.*,cnu.datecreated as date_joined,CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as author_name 
            FROM ccs_forum_threads cft INNER JOIN ccs_nonmoodle_user cnu ON cnu.id = cft.user_id WHERE cft.id = ? LIMIT 1",array($thread_id));
        
        return ($query->num_rows())?$query->row():FALSE;
    }
    //get thread's information by its perma_link / ok
    public function get_thread_by_permalink($perma_link){
        $query = $this->db->query("SELECT cft.*, cnu.profilepicture as author_pic, cnu.datecreated as date_joined, 
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as author_name 
            FROM ccs_forum_threads cft INNER JOIN ccs_nonmoodle_user cnu ON cnu.id = cft.user_id WHERE cft.perma_link = ? LIMIT 1",array($perma_link));
        
        return ($query->num_rows())?$query->row():FALSE;
    }

    public function get_thread_by_topic($topic){
        $query = $this->db->query("SELECT * FROM ccs_forum_threads WHERE topic = ? LIMIT 1", array($topic));

        return ($query->num_rows())?1:0;
    }
    //get all thread's comments by its id / ok
    public function get_all_comments_by_thread_id($thread_id){
        $query = $this->db->query("SELECT cfc.*, cnu.profilepicture as author_pic, 
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as author_name 
            FROM ccs_forum_comments cfc INNER JOIN ccs_nonmoodle_user cnu ON cnu.id = cfc.user_id WHERE cfc.topic_id = ? ORDER BY cfc.suggested DESC, cfc.date_posted DESC, cfc.id DESC", array($thread_id));
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    //get all comments by user id
    public function get_all_comments_by_id($user_id){
        $query = $this->db->query("SELECT cfc.*, cft.topic as thread, cft.perma_link as permalink 
            FROM ccs_forum_comments cfc 
            INNER JOIN ccs_forum_threads cft ON cft.id = cfc.topic_id 
            WHERE cfc.user_id = ? 
            ORDER BY cft.date_posted DESC, cft.id DESC, cfc.date_posted DESC, cfc.id DESC", array($user_id));

        return ($query->num_rows())?$query->result():FALSE;
    }
    //add comment by id / ok
    public function add_new_comment($user_id,$thread_id,$comment,$date_posted){
        $data = array(
            'topic_id' => $thread_id,
            'message' => trim(strip_tags($comment)),
            'user_id' => $user_id,
            'date_posted' => $date_posted
        );
        
        $this->db->insert('ccs_forum_comments',$data);
        
        return ($this->db->affected_rows())?$this->db->insert_id():FALSE;
    }
    //delete comment by id / ok
    public function delete_comment_by_id($comment_id){
        $this->db->query("DELETE FROM ccs_forum_comments WHERE id = ?", array($comment_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //delete comment by thread id /ok
    public function delete_comment_by_thread_id($thread_id){
        $this->db->query("DELETE FROM ccs_forum_comments WHERE topic_id = ?", array($thread_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //edit comment by id
    public function edit_comment_by_id($comment_id,$comment){
        $comment = trim(strip_tags($comment));
        
        $this->db->query("UPDATE ccs_forum_comments SET message = ? WHERE id = ?", array($comment,$comment_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //get comment by id / ok
    public function get_comment_by_id($comment_id){
        $query = $this->db->query("SELECT cfc.*, cft.perma_link as thread_perma_link, cft.user_id as thread_user_id, cft.topic as thread_topic, cnu.profilepicture as author_pic, 
            CONCAT(cnu.firstname,IFNULL(CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as author_name 
            FROM ccs_forum_comments cfc 
            INNER JOIN ccs_forum_threads cft ON cft.id = cfc.topic_id 
            INNER JOIN ccs_nonmoodle_user cnu ON cnu.id = cfc.user_id 
            WHERE cfc.id = $comment_id");
        
        return $query->row();
    }

    //pin thread
    public function pin_forum_by_id($thread_id){
        $pinned = $this->get_pinned_forum($thread_id);

        if($pinned) $this->db->query('UPDATE ccs_forum_threads SET pinned = 0 WHERE id = ?', array($pinned->id));
        $this->db->query('UPDATE ccs_forum_threads SET pinned = 1 WHERE id = ?', array($thread_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }

    //unpin thread
    public function unpin_forum_by_id($thread_id){
        $query = $this->db->query('UPDATE ccs_forum_threads SET pinned = 0 WHERE id = ? LIMIT 1', array($thread_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }

    //get pinned thread
    public function get_pinned_forum(){
        $query = $this->db->query('SELECT * FROM ccs_forum_threads WHERE pinned = 1 LIMIT 1');
        
        return ($query->num_rows())?$query->row():FALSE;
    }

    //suggest comment by id / ok
    public function suggest_comment_by_id($thread_id,$comment_id){
        $suggested = $this->get_suggested_comment_by_id($thread_id);
        
        if($suggested) $this->db->query('UPDATE ccs_forum_comments SET suggested = 0 WHERE id = ?', array($suggested->id));
        $this->db->query('UPDATE ccs_forum_comments SET suggested = 1 WHERE id = ?', array($comment_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //unsuggest comment by id / ok
    public function unsuggest_comment_by_id($comment_id){
        $this->db->query('UPDATE ccs_forum_comments SET suggested = 0 WHERE id = ?', array($comment_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    //get suggested comment / ok
    public function get_suggested_comment_by_id($thread_id){
        $query = $this->db->query('SELECT * FROM ccs_forum_comments WHERE suggested = 1 AND topic_id = ? LIMIT 1', array($thread_id));
        
        return ($query->num_rows())?$query->row():FALSE;
    }

    //upload file attachments /ok
    public function upload_file_attachment($user_or_ann_id, $topic, $detail, $attachments = NULL, $type = 'add'){
        $path = './uploads/files/forum/' . md5(strip_tags($topic)) . '/';
        if(!is_dir($path)) mkdir ($path, 0755, TRUE);
        
        $config['upload_path']      = './uploads/files/forum/' . md5(strip_tags($topic)) . '/';
        $config['allowed_types']    = '*';
        $config['max_size']         = '5000';
        
        $this->load->library('upload', $config);
        
        if(!$this->upload->do_multi_upload('userfile')){
            if($type == 'add') rmdir($path);
            $this->session->set_flashdata('forum_upload_error', $this->upload->display_errors()); //set session for create forum error
            
            redirect(base_url() . 'forum?error=1');
        }
        else{
            if($files = $this->upload->get_multi_upload_data()){
                $file_name = array();

                foreach($files as $file){
                    array_push($file_name, 'uploads/files/forum/' . md5(strip_tags($topic)) . '/' . $file['file_name']);
                }
                $all_file_names = implode(' ', $file_name);
            }
            else{
                $file = $this->upload->data();
                $all_file_names = $file['file_name'];
            }

            $all_file_names .= ($attachments)?" $attachments":"";
            
            if($type == 'add') $this->add_new_thread($user_or_ann_id,$topic,$detail,$all_file_names,$this->datetime->format('Y-m-d H:i:s'));
            else if($type == 'edit') $this->edit_thread_by_id($user_or_ann_id,$detail,$all_file_names);
        }
    }
}
?>
