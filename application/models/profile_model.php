<?php

class Profile_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_user_information_by_id($user_id){
        $query = $this->db->query("SELECT cnu.*, cucp.*, cnu.id as profile_user_id, cut.id as user_type_id, cut.name as user_type, cs.id as service_type_id, cs.name as service_type, 
            CONCAT(cnu.firstname,IF(cnu.middlename IS NOT NULL,CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as full_name, 
            (SELECT COUNT(*) FROM ccs_forum_threads cftc WHERE cftc.user_id = cnu.id) as forum_posts, 
            (SELECT COUNT(*) FROM ccs_forum_comments cfcc WHERE cfcc.user_id = cnu.id) as comment_posts, 
            (SELECT COUNT(*) FROM ccs_polls cp WHERE cp.user_id = cnu.id) as poll_posts, 
            (SELECT MAX(cft.date_posted) FROM ccs_forum_threads cft WHERE cft.user_id = cnu.id GROUP BY cft.user_id) as last_thread_post, 
            (SELECT MAX(cfc.date_posted) FROM ccs_forum_comments cfc WHERE cfc.user_id = cnu.id GROUP BY cfc.user_id) as last_comment_post
            FROM ccs_nonmoodle_user cnu 
            LEFT JOIN ccs_user_types cut ON cut.id = cnu.usertype
            LEFT JOIN ccs_user_company_profile cucp on cucp.userid = cnu.id 
            LEFT JOIN ccs_service_details csd ON csd.user_id = cnu.id
            LEFT JOIN ccs_services cs ON cs.id = csd.affirmed_service_id
            WHERE cnu.id = ?", array($user_id));
        
        return $query->row();
    }

    public function get_all_user_information_by_username($username){
        $query = $this->db->query("SELECT cnu.*, cucp.*, cnu.id as profile_user_id, cut.id as user_type_id, cut.name as user_type, cs.id as service_type_id, cs.name as service_type, 
            (SELECT COUNT(*) FROM ccs_forum_threads cftc WHERE cftc.user_id = cnu.id) as forum_posts, 
            (SELECT COUNT(*) FROM ccs_forum_comments cfcc WHERE cfcc.user_id = cnu.id) as comment_posts, 
            (SELECT COUNT(*) FROM ccs_polls cp WHERE cp.user_id = cnu.id) as poll_posts, 
            (SELECT MAX(cft.date_posted) FROM ccs_forum_threads cft WHERE cft.user_id = cnu.id GROUP BY cft.user_id) as last_thread_post, 
            (SELECT MAX(cfc.date_posted) FROM ccs_forum_comments cfc WHERE cfc.user_id = cnu.id GROUP BY cfc.user_id) as last_comment_post
            FROM ccs_nonmoodle_user cnu 
            LEFT JOIN ccs_user_types cut ON cut.id = cnu.usertype
            LEFT JOIN ccs_user_company_profile cucp on cucp.userid = cnu.id 
            LEFT JOIN ccs_service_details csd ON csd.user_id = cnu.id
            LEFT JOIN ccs_services cs ON cs.id = csd.affirmed_service_id
            WHERE cnu.username = ? LIMIT 1", array($username));
        
        return ($query->num_rows())?$query->row():FALSE;
    }
    
    public function upload_profile_picture($user_id){
        $CI = &get_instance();
        $path = './uploads/users/'.md5($CI->authentication->user_data()->username);
        if(!is_dir($path)){
          mkdir($path, 0755, TRUE);
        }

        $config['upload_path'] = './uploads/users/'.md5($CI->authentication->user_data()->username).'/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '0';
        
        $this->load->library('upload', $config);
        $files = glob('uploads/users/'.md5($CI->authentication->user_data()->username).'/*');
        natcasesort($files);
        foreach($files as $file) {
            unlink($file);
        }
        
        if(!$this->upload->do_upload()){
            echo $this->upload->display_errors('<div class="alert alert-danger">','</div>');
        
            return false;
        }
        else{
            $images = $this->upload->data();
            $this->update_profile_picture($images['file_name'], $user_id);
//            $this->profile->resize_profile_picture($image,'xxxlarge',1800,1350);//xxxlarge
//            $this->profile->resize_profile_picture($image,'xxlarge',1300,975);//xxlarge
//            $this->profile->resize_profile_picture($image,'xlarge',1000,750);//xlarge
//            $this->profile->resize_profile_picture($image,'large',700,525);//large
//            $this->profile->resize_profile_picture($image,'medium',300,225);//medium
//            $this->profile->resize_profile_picture($image,'small',200,150);//small
//            $this->profile->resize_profile_picture($images['file_name'],'xsmall',140,105);//xsmall
            
            return true;
        }
    }
    public function update_profile_picture($image, $user_id){
        $CI = &get_instance();
        $avatars = glob('assets/img/avatars/*');
        $path = 'uploads/users/'.md5($CI->authentication->user_data()->username).'/';
        
        foreach($avatars as $avatar){
            $path_parts = pathinfo($avatar); 
            $filename = $path_parts['filename'];
            $extension = $path_parts['extension'];
//            echo $filename.'.'.$extension;
            if($image == $filename.'.'.$extension){
                $path = 'assets/img/avatars/';
                break;
            }       
        }
        $data = array(
            'profilepicture' => $path.$image
        );
        
        $this->db->where('id', $user_id);
        $this->db->update('ccs_nonmoodle_user', $data);
    
        return ($this->db->affected_rows())?TRUE:FALSE;
        
    }
    public function remove_profile_picture($image, $user_id){    
        $CI = &get_instance();
        
//        echo '<script>alert(uploads/users/'.  md5($CI->authentication->user_data()->username).'/'.$image.')</script>';
        $files = glob('uploads/users/'.md5($CI->authentication->user_data()->username).'/*');
        natcasesort($files);
        foreach($files as $file) {
            unlink($file);
        }
        $data = array(
            'profilepicture'=>'assets/img/default_profile_picture.jpg'
        );
//        if($CI->authentication->user_data()->profilepicture == ){
        $this->db->where('id', $user_id);
        $this->db->update('ccs_nonmoodle_user', $data);
    
        
        $files = glob('uploads/users/'.md5($CI->authentication->user_data()->username).'/*');
        natcasesort($files);
        foreach($files as $file) {
            $path_parts = pathinfo($file); 
            $filename = $path_parts['filename'];
            $extension = $path_parts['extension'];
            if($filename.'.'.$extension == $image){
                unlink($file);
            }
        }
        return ($this->db->affected_rows())?TRUE:FALSE;
        
    }
    
    public function download_profile_picture($image){
        $CI = &get_instance();
        $this->load->helper('download');
        $data = file_get_contents("uploads/users/".  md5($CI->authentication->user_data()->username).'/'.$image);
        $name = md5($CI->authentication->user_data()->username).'_'.$image;
        force_download($name, $data);
        
        if(force_download($name, $data))
            return true;
        else
            return false;
    }
    public function get_all_users($user_id){
        $query = $this->db->query("SELECT cnu.username, cnu.profilepicture, 
        CONCAT(cnu.firstname,IF(cnu.middlename IS NOT NULL,CONCAT(' ',cnu.middlename),''),' ',cnu.lastname) as full_name
        FROM ccs_nonmoodle_user cnu WHERE cnu.id != ?
        ORDER BY cnu.firstname, cnu.lastname, cnu.middlename, cnu.id", array($user_id));
    
        return ($query->num_rows())?$query->result_array():FALSE;
    }
    
    //get user profile by name
    public function get_all_users_by_name($name){
        $query = $this->db->query("SELECT *, 
            CONCAT(firstname,IF(middlename IS NOT NULL,CONCAT(' ',middlename),''),' ',lastname) as full_name 
            FROM ccs_nonmoodle_user 
            WHERE (CONCAT(firstname,IF(middlename IS NOT NULL,CONCAT(' ',middlename),''),' ',lastname) 
            LIKE '%$name%' OR CONCAT(firstname,' ',lastname) 
            LIKE '%$name%') AND id != ?
            ORDER BY firstname, middlename, lastname, id",array($this->authentication->user_id()));
        
        return ($query->num_rows())?$query->result():FALSE;
    }
}
?>
