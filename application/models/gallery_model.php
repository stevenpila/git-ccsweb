<?php

class Gallery_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function create_album($album_name){
        $flag = false;
        $path = './uploads/albums/'.$album_name;
        if(mkdir($path, 0755, TRUE)){
            $album_cover = $path.'/album_cover.txt';
            $handle = fopen($album_cover, 'w+');
            $flag = true;
        }
        
        return $flag;
    }
    
    public function delete_album($album_name){
        $flag = false;
        $path = './uploads/albums/'.$album_name;
        $pictures = glob('uploads/albums/'.$album_name.'/*');
        if(count($pictures)){
            foreach($pictures as $picture){
                unlink($picture);
            }
            if(rmdir($path))
                $flag = true;
        }
        else{
            if(rmdir($path))
                $flag = true;
        }
        return $flag;
    }

    public function delete_albums($album_names){
        $flag = false;

        foreach($album_names as $album_name){
            $path = './uploads/albums/' . $album_name;

            if(is_dir($path)){
                $pictures = glob('./uploads/albums/'.$album_name.'/*');
                
                if(count($pictures)){
                    foreach($pictures as $picture){
                        unlink($picture);
                    }
                    if(rmdir($path))
                        $flag = true;
                }
                else{
                    if(rmdir($path))
                        $flag = true;
                }
            }
        }

        return $flag;
    }
    
    public function rename_album($album_name, $new_album_name){
        $flag = false;
        $path = './uploads/albums/';
        if(rename($path.$album_name, $path.$new_album_name)){
            $flag = true;
        }
        
        return $flag;
    }
    
    public function delete_picture($album_name, $image_name){
        $flag = false;
        $path = './uploads/albums/'.$album_name.'/';
        $data = file_get_contents($path.'album_cover.txt');
        if($data == $image_name){
            $album_cover = fopen($path.'album_cover.txt', 'w+');
            fwrite($album_cover, '');
        }
        if(unlink($path.$image_name)){
            return true;
        }
        
        return $flag;
    }

    public function set_album_cover($album_name, $image_name){
        $flag = false;
        $path = './uploads/albums/'.$album_name.'/album_cover.txt';

        if(file_exists($path)){
            $content = $image_name;
            $album_cover = fopen($path, 'w+');
            fwrite($album_cover, $content);
            $flag = true;
        }

        return $flag;
    }
    
    public function upload_picture($album_name, $files){
        $config = array(
        'upload_path'   => './uploads/albums/'.$album_name.'/',
        'allowed_types' => 'jpg|gif|png|jpeg',
        'overwrite'     => FALSE,
        'max_size'      => '0'
        );

        $this->load->library('upload', $config);

        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];

            $config['file_name'] = $album_name.'_'.$image;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('images[]')) {
                return false;
            }
        }

        return true;
    }

    public function add_to_slides($album_name, $image_name){
        $path = './uploads/albums/'.$album_name.'/'.$image_name;
        $destination_path = './uploads/albums/slides/'.$image_name;
        $flag = true;
        if(!copy($path, $destination_path)){
           $flag = false; 
        }
        
        return $flag;
    }
    
    public function add_many_to_slides($images_name){
        $path = './uploads/albums/';
        $destination_path = './uploads/albums/slides/';
        
        foreach($images_name as $image){
            $flag = true;
            $new_image = explode('/', $image);
            if(!copy($path.$image, $destination_path.$new_image[1])){
               $flag = false;
               break;
            }
        }
        
        return $flag;
    }

    public function delete_many_photos($images){
        $flag = FALSE;

        foreach($images as $image){
            $path = './uploads/albums/' . $image;

            if(file_exists($path)){
                if(unlink($path)) $flag = TRUE;
            }
        }

        return $flag;
    }
    
}

?>