<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Createform extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('xpcms/index');
    }
    /**
     * 
     * @param array $data
     * @return void Description
     */
    public function index($action = '', $fieldset = '') {
        $data['action'] = $action;
        $data['fieldset'] = $fieldset;
        $this->load->view('createform_view',$data);
    }

}

/* End of file createform.php */
/* Location: ./cms/modules/createform/controllers/createform.php */