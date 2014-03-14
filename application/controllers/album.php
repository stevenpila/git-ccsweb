<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->model('gallery_model','gallery');
    }
    public function index($album_name){
        $this->data['error'] = $this->session->flashdata('album_upload_error');
        $this->data['album_name'] = str_replace('_',' ',$album_name);
    }
    
    public function upload($album_name){
        $temp = str_replace("_", " ", $album_name);
        if (!empty($_FILES['images']['name'][0])){
            if ($this->gallery->upload_picture($temp, $_FILES['images'])){
                $this->session->set_flashdata('album_upload_error', 1);
            }
            else{
                $this->session->set_flashdata('album_upload_error', 0);
            }
        }

        redirect('gallery/'.$album_name);
    }
    
    public function download($album_name,$image_name){
        $this->load->helper('download');
        $data = file_get_contents(base_url()."uploads/albums/".str_replace(' ','_',$album_name).'/'.$image_name);
        $name = str_replace(' ','_',$image_name);
        force_download($name, $data);
    }
}

?>