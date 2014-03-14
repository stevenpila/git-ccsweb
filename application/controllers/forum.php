<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->model('forum_model','forum');
    }

    public function index(){
        if($this->input->get('error',TRUE)){
            if($this->session->flashdata('forum_upload_error')) $this->data['upload_forum_status'] = $this->session->flashdata('forum_upload_error');
            else if($this->session->flashdata('forum_download_error')) $this->data['download_forum_status'] = FALSE;
            else if($this->session->flashdata('forum_view_error')) $this->data['view_forum_status'] = FALSE;
        }

        $this->data['forums'] = $this->forum->get_all_thread();
        $this->data['captcha'] = $this->captcha->generate();
    }

    public function create_forum(){
        if($data = $this->input->post()){
            extract($data);
            $user_id = $this->authentication->user_id();

            if(isset($_FILES['userfile']))
                foreach($_FILES['userfile']['name'] as $key => $name) echo $_FILES['userfile']['name'][$key] = $this->security->sanitize_filename($name);
            
            if($add_attachment == 1) $this->forum->upload_file_attachment($user_id,$topic,trim($detail));
            else $this->forum->add_new_thread($user_id,$topic,trim($detail),NULL,$this->datetime->format('Y-m-d H:i:s'));
        }
        
        redirect('forum');
    }

    public function edit_forum(){
        if($data = $this->input->post()){
            extract($data);

            if(isset($_FILES['userfile']))
                foreach($_FILES['userfile']['name'] as $key => $name) echo $_FILES['userfile']['name'][$key] = $this->security->sanitize_filename($name);

            $path = './uploads/files/forum/' . md5(strip_tags($topic)) . '/';

            if(isset($attachments)){
                if(is_dir($path)){
                    $files = glob($path . '*');
                    if($files){
                        foreach($files as $file){
                            if(is_file($file)){
                                $match = false;

                                foreach($attachments as $attachment){
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


            if($add_attachment == 1) $this->forum->upload_file_attachment($thread_id,$topic,trim($detail),(isset($attachments))?implode(' ',$attachments):NULL,'edit');
            else $this->forum->edit_thread_by_id($thread_id,trim($detail),(isset($attachments))?implode(' ',$attachments):NULL);
        }

        redirect('forum/' . strtopermalink($topic));
    }

    public function view_forum($topic){
        $user_id = $this->authentication->user_id();

        $redirect = ($this->input->get('id',TRUE)) ? $this->input->get('id',TRUE) : FALSE;
        $this->data['forum'] = $topic = $this->forum->get_thread_by_permalink($topic);
        if(!$topic){
            $this->session->set_flashdata('forum_view_error','true');
            redirect(base_url() . 'forum?error=1');
        }

        $this->data['comments'] = $this->forum->get_all_comments_by_thread_id($topic->id);
        $this->data['is_edit'] = ($redirect == md5($topic->id) && $user_id == $topic->user_id && $this->authentication->is_authorized_by_name('Forun','edit_forum')) ? TRUE : FALSE;
    }

    public function pin_forum(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            
            $this->forum->pin_forum_by_id($thread_id);
        }

        redirect('forum');
    }

    public function unpin_forum(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            
            $this->forum->unpin_forum_by_id($thread_id);
        }

        redirect('forum');
    }

    public function suggest_comment(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            
            $this->forum->suggest_comment_by_id($topic_id,$comment_id);

            redirect(base_url() . 'forum/' . $perma_link);
        }

        redirect('forum');
    }

    public function unsuggest_comment(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            
            $this->forum->unsuggest_comment_by_id($comment_id);

            redirect(base_url() . 'forum/' . $perma_link);
        }

        redirect('forum');
    }

    public function download_file_attachment(){
        if($this->input->get('file',TRUE)){
            $file = $this->input->get('file',TRUE);
            $data = file_get_contents('./' . $file); // Read the file's contents
            
            if(!$data){
                $this->session->set_flashdata('forum_download_error', 'true');
                
                redirect(base_url () . 'forum?error=1');
            }
            
            force_download(basename($file), $data); 
        }
        
        $this->view = false;
    }

    /*-------------------------------
    
             AJAX Functions
    
    --------------------------------*/

    public function delete_forum($redirect = FALSE){
        $status  = 0;

        if($this->input->post(NULL,TRUE) || $redirect){
            if($this->input->post(NULL,TRUE)) extract($this->input->post(NULL,TRUE));
            if($redirect && $this->input->post('is_delete') == '1') $thread_id = $redirect;

            $topic = $this->forum->get_thread_by_id($thread_id)->topic;

            if($this->forum->delete_thread_by_id($thread_id)){
                $path = './uploads/files/forum/' . md5($topic) . '/';
                
                if(is_dir($path)){
                    $files = glob($path . '*');
                    if($files){
                        foreach($files as $file)
                            if(is_file($file)) unlink ($file);
                    }

                    rmdir($path);
                }
                
                $this->forum->delete_comment_by_thread_id($thread_id);

                $status = 1;
            }
        }

        if($redirect && $this->input->post('is_delete') == '1') redirect('forum');
        else if(!$redirect){
            echo json_encode(array('status' => $status));

            $this->view = false;
        }
        else{
            redirect(base_url() . 'forum?error=1');
        }
    }

    public function create_comment(){
        $status  = 0;

        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));

            $user_id = $this->authentication->user_id();

            if($comment_id = $this->forum->add_new_comment($user_id,$topic_id,$comment,$this->datetime->format('Y-m-d H:i:s'))) $status = $comment_id;
        }

        echo json_encode(array('status' => $status));

        $this->view = false;
    }

    public function edit_comment(){
        $status = 0;

        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));

            if($this->forum->edit_comment_by_id($comment_id,$comment)) $status = 1;
        }

        echo json_encode(array('status' => $status));

        $this->view = false;
    }

    public function delete_comment(){
        $status  = 0;
        
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));

            if($this->forum->delete_comment_by_id($comment_id)){
                $status = 1;
            }
        }

        echo json_encode(array('status' => $status));

        $this->view = false;
    }

    public function view_comment(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));

            $this->data['comment'] = $this->forum->get_comment_by_id($comment_id);
        }

        $this->view = 'forum/view_comment';
    }

    public function verify_captcha_and_topic(){
        $captcha  = 0;
        $title = 0;
        
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));

            $captcha = $this->captcha->validate_captcha($captcha_id, $captcha, $this->input->ip_address());
            $title = $this->forum->get_thread_by_topic($topic);
        }

        echo json_encode(array('captcha' => $captcha, 'topic' => $title));

        $this->view = false;
    }
}
?>