<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Createtextimg extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('xpcms/index');
    }
    /**
     * 
     * @param string $action
     * @param string $fieldset
     * @return void Description
     */
    public function index($action = '', $fieldset = '') {
        $this->load->model('xpcms/file_model');
        $data = array(
            'action' => $action,
            'fieldset' => $fieldset,
            'images' => $this->file_model->get_images()
        );
        $this->load->model('xpcms/inhalt_model');
        $temparr = $this->inhalt_model->getValue('template','uid',1);
        $template = $temparr[0]->template;
        $data['template'] = json_decode($template);
        $this->load->view('textimage_view', $data);
    }
    /**
     * action imageInfo get the image information
     * @return string json
     */
    public function imageInfo() {
        $this->load->model('xpcms/inhalt_model');
        if(isset($_POST['title'])){ 
            $title = $_POST['title'];            
        } else {
            $title = 'no title';
        }
        $row = $this->inhalt_model->getValue('files','file_name',$title);
        $data = array(
            'title' => $title,
            'image_width' => $row[0]->image_width,
            'image_height' => $row[0]->image_height
        );
        echo json_encode($data);
    }
}

/* End of file admin.php */
/* Location: ./cms/controllers/admin.php */