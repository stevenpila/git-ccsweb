<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Announcement extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->model('announcement_model','announcement');
    }
    
    public function index(){
        if($this->input->get('error',TRUE)){
            if($this->session->flashdata('announcement_upload_error')) $this->data['upload_announcement_status'] = $this->session->flashdata('announcement_upload_error');
            else if($this->session->flashdata('announcement_download_error')) $this->data['download_announcement_status'] = FALSE;
        }
        
        $this->data['announcements'] = $this->announcement->get_all_announcements();
        $this->data['captcha'] = $this->captcha->generate();
    }
    
    public function create_announcement(){
        if($data = $this->input->post()){
            extract($data);
            $user_id = $this->authentication->user_id();

            if(isset($_FILES['userfile'])) {
                foreach($_FILES['userfile']['name'] as $key => $name) {
                    $_FILES['userfile']['name'][$key] = $this->security->sanitize_filename($name);
                }
            }

            if($add_attachment == 1) $this->announcement->upload_file_attachment($user_id,$topic,trim($detail));
            else $this->announcement->add_new_announcement($user_id,$topic,trim($detail),NULL,$this->datetime->format('Y-m-d H:i:s'));
        }
        
        redirect('announcement');
    }
    
    public function edit_announcement(){
        if($data = $this->input->post()){
            extract($data);

            if(isset($_FILES['userfile']))
                foreach($_FILES['userfile']['name'] as $key => $name) echo $_FILES['userfile']['name'][$key] = $this->security->sanitize_filename($name);

            $path = './uploads/files/announcement/' . md5(strip_tags($topic)) . '/';

            if(isset($attachments)){
                if(is_dir($path)){
                    $files = glob($path . '*');
                    if($files){
                        foreach($files as $file){
                            if(is_file($file)){
                                $match = false;

                                foreach($attachments as $attachment){
                                    echo basename($file) . ':' . basename($attachment);
                                    if(basename($file) == basename($attachment)) $match = true;
                                }

                                if(!$match) unlink($file);
                            }
                        }
                    }
                }
            }
            else{
                if(is_dir($path)){
                    $files = glob($path . '*');

                    if($files){
                        foreach($files as $file){
                            if(is_file($file)) unlink($file); 
                        }
                    }
                }
            }

            if($add_attachment == 1) $this->announcement->upload_file_attachment($ann_id,$topic,trim($detail),(isset($attachments))?implode(' ',$attachments):NULL,'edit');
            else $this->announcement->edit_announcement_by_id($ann_id,trim($detail),(isset($attachments))?implode(' ',$attachments):NULL); 
        
            $this->session->set_flashdata('ccs-announcement-edit-status', '1');
        }
        
        redirect(base_url() . 'announcement#' . $ann_id);
    }
    
    public function pin_announcement(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            
            $this->announcement->pin_announcement_by_id($ann_id);
        }
        
        redirect('announcement');
    }
    
    public function unpin_announcement(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            
            $this->announcement->unpin_announcement_by_id($ann_id);
        }
        
        redirect('announcement');
    }
    
    public function download_file_attachment(){
        if($this->input->get('file',TRUE)){
            $file = $this->input->get('file',TRUE);
            $data = file_get_contents('./' . $file); // Read the file's contents
            
            if(!$data){
                $this->session->set_flashdata('announcement_download_error', 'true');
                
                redirect(base_url () . 'announcement?error=1');
            }
            
            force_download(basename($file), $data); 
        }
        
        $this->view = false;
    }
    
    /*-------------------------------
    
             AJAX Functions
    
    --------------------------------*/
    
    public function delete_announcement(){
        $status  = 0;
        
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));

            $topic = $this->announcement->get_announcement_by_id($ann_id)->topic;
            
            if($this->announcement->delete_announcement_by_id($ann_id)){
                $path = './uploads/files/announcement/' . md5($topic) . '/';
                
                if(is_dir($path)){
                    $files = glob($path . '*');
                    if($files){
                        foreach($files as $file)
                            if(is_file($file)) unlink ($file);
                    }

                    rmdir($path);
                }
                
                $status = 1;
            }
        }
        
        echo json_encode(array('status' => $status));
        
        $this->view = false;
    }

    public function verify_captcha_and_topic(){
        $captcha  = 0;
        $title = 0;
        
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));

            $captcha = $this->captcha->validate_captcha($captcha_id, $captcha, $this->input->ip_address());
            $title = $this->announcement->get_announcement_by_topic($topic);
        }

        echo json_encode(array('captcha' => $captcha, 'topic' => $title));

        $this->view = false;
    }
}
?>
