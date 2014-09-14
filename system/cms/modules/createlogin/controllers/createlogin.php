<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Createlogin extends CI_Controller {
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
        $this->load->model('xpcms/inhalt_model');
        $temparr = $this->inhalt_model->getValue('template','uid',1);
        $template = $temparr[0]->template;
        $data['template'] = json_decode($template);
        $data['action'] = $action;
        $data['fieldset'] = $fieldset;
        $this->load->view('createlogin_view', $data);
    }

    
}

/* End of file admin.php */
/* Location: ./cms/modules/createlogin/createlogin.php */