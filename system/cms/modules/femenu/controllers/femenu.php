<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Femenu extends CI_Controller {
    /**
     * action __construct
     * @return void Description
     */
    public function __construct() {
        parent::__construct();
    }
    /**
     * action index print frontend menu 
     * @return void
     */
    public function index(){
        $this->load->model('femenu_model');
        $data['menuItems'] = $this->femenu_model->getNavItems();
        //print_r($data);
        $this->load->view('femenu_view',$data);
    }
}

