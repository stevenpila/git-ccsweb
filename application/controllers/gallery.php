<?php

class Gallery extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->model('gallery_model','gallery');
    }
    
    public function index(){
        if($this->input->get(NULL,TRUE)){
            extract($this->input->get(NULL,TRUE));

            if($action == 'rename' || $action == 'delete' || $action == 'create' || $action == 'albums') $this->session->set_flashdata('action','ok');

            redirect('gallery');
        }

    }
    
    /**************************************
     
                 AJAX FUNCTIONS
      
     **************************************/
    
    public function create_album(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            
            if($this->gallery->create_album($albumname)){
                redirect('gallery/' . $albumname);
            }
        }
    }
    
    public function check_if_album_exist(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            if((is_dir('./uploads/albums/'.$albumname.'/'))){
                $status = 1;
            }
            else{
                $status = 0;
            }
            
            echo json_encode(array('status'=>$status));
        }
        $this->view = FALSE;
    }
    
    public function delete_album(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            if($this->gallery->delete_album($albumname)){
                $status = 1;
            }
            else{
                $status = 0;
            }
            echo json_encode(array('status'=>$status));
        }
        $this->view = FALSE;
    }

    public function delete_albums(){
        $status = 0;
        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            if($this->gallery->delete_albums($delete)){
                $status = 1;
            }
            
            echo json_encode(array('status'=>$status));
        }
        $this->view = FALSE;
    }
    
    public function rename_album(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            if($this->gallery->rename_album($albumname,$newalbumname)){
                $status = 1;
            }
            else{
                $status = 0;
            }
            echo json_encode(array('status'=>$status));
        }
        $this->view = FALSE;
    }
    
    public function delete_picture(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            if($this->gallery->delete_picture($albumname,$imagename)){
                $status = 1;
            }
            else{
                $status = 0;
            }
            echo json_encode(array('status'=>$status));
        }
        $this->view = FALSE;
    }

    public function set_album_cover(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            if($this->gallery->set_album_cover($albumname,$imagename)){
                $status = 1;
            }
            else{
                $status = 0;
            }
            echo json_encode(array('status'=>$status));
        }
        $this->view = FALSE;
    }

    public function add_to_slides(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            if($this->gallery->add_to_slides($albumname,$imagename)){
                $status = 1;
            }
            else{
                $status = 0;
            }
            echo json_encode(array('status'=>$status));
        }
        $this->view = FALSE;
    }
    
    public function add_many_to_slides(){
        if($this->input->post(NULL,TRUE)){
            extract($this->input->post(NULL,TRUE));
            //print_array($this->input->post(NULL,TRUE));
            if($this->gallery->add_many_to_slides($slides)){
                $status = 1;
            }
            else{
                $status = 0;
            }
            echo json_encode(array('status'=>$status));
        }

        $this->view = FALSE;
    }

    public function delete_many_photos(){
        $status = 0;

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            if($this->gallery->delete_many_photos($delete)){
                $status = 1;
            }

            echo json_encode(array('status' => $status));
        }

        $this->view = FALSE;
    }
    
}
?>
