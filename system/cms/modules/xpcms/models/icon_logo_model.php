<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }
/* Location: ./system/cms/modules/xpcms/models/icon_logo_model.php */
class icon_logo_model extends CI_Model {
    private $gallery_path;
    private $gallery_path_url;
    public function __construct() {
        parent::__construct();
        $this->gallery_path = 'public_html/ui';
        $this->gallery_path_url = base_url() . 'public_html/ui/';
    }
    /**
     * 
     * @param string $file
     */
    public function set_logo($file) {
        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->gallery_path,
            'max_size' => 2000,
            'overwrite' => TRUE,
            'encrypt_name' => FALSE,
            'file_name' => 'xp_cms_logo'
        );

        $this->load->library('upload', $config);
        
        $this->upload->do_upload($file);
        $image_data = $this->upload->data();

        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $this->gallery_path ,
            'maintain_ration' => true,
            'width' => 200,
            'height' => 100
        );

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        //print_r($image_data);
        $data = array(
            'logo' => $image_data['file_name'],
            'last_update' => time()
        );
        
        $this->db->where('uid', 1 )->update('web_info', $data);
        echo $this->upload->display_errors('', '');
    }
    /**
     * 
     * @param string $file
     */
    public function set_icon($file) {
        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->gallery_path,
            'max_size' => 2000,
            'overwrite' => TRUE,
            'encrypt_name' => FALSE,
            'file_name' => 'xp_cms_icon'
        );

        $this->load->library('upload', $config);
        
        $this->upload->do_upload($file);
        $image_data = $this->upload->data();

        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $this->gallery_path ,
            'maintain_ration' => true,
            'width' => 20,
            'height' => 20
        );

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        //print_r($image_data);
        $data = array(
            'icon' => $image_data['file_name'],
            'last_update' => time()
        );
        $this->db->where('uid', 1 )->update('web_info', $data);
        echo $this->upload->display_errors('', '');
    }    
}

/* End of file icon_logo_model.php */
