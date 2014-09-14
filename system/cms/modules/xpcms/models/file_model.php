<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/* Location: ./system/cms/modules/xpcms/models/file_model.php */

class File_model extends CI_Model {

    private $gallery_path;
    private $gallery_path_url;
    public function __construct() {
        parent::__construct();
        $this->gallery_path = 'public_html/images';
        $this->gallery_path_url = base_url() . 'public_html/images/';
    }
    /**
     * do_upload
     */
    public function do_upload() {
        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->gallery_path,
            'max_size' => 1024*10000
        );

        $this->load->library('upload', $config);
        $this->upload->do_upload();
        $image_data = $this->upload->data();
        //print_r($image_data);
        $now = time();
        $data = array(
            'id' => NULL, 
            'file_name' => $image_data['file_name'], 
            'file_type' => $image_data['file_type'], 
            'file_path' => $this->gallery_path, 
            'file_size' => $image_data['file_size'], 
            'image_width' => $image_data['image_width'], 
            'image_height' => $image_data['image_height'],
            'up_time' => $now
        );
        $this->db->insert('files', $data);
        //
        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $this->gallery_path . '/thumbs',
            'maintain_ration' => true,
            'width' => 150,
            'height' => 100
        );

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }
    /**
     * get_images
     * @return string
     */
    public function get_images() {

        $files = scandir($this->gallery_path);
        $files = array_diff($files, array('.', '..', 'thumbs'));
        //print_r($files);
        $images = array();
        foreach ($files as $file) {
            $images [] = array(
                'file' =>$file,
                'url' => $this->gallery_path_url . $file,
                'thumb_url' => $this->gallery_path_url . 'thumbs/' . $file
            );
        }

        return $images;
    }
    
    public function do_delete($file_name) {        
        //$sysfold = str_replace('index.php','',$_SERVER['PHP_SELF']);
        if(getimagesize($this->gallery_path_url.$file_name)) {            
            $this->db->where('file_name', $file_name)->delete('files');
            // $_SERVER['DOCUMENT_ROOT'].$sysfold.
            unlink($this->gallery_path.'/'.$file_name);
            // $_SERVER['DOCUMENT_ROOT'].$sysfold.
            unlink($this->gallery_path.'/thumbs/'.$file_name);
            return TRUE;
        }else{
            return FALSE;
        }
         
    }
}

/* End of file file_model.php */