<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rootline
 *
 * @author cabag
 */
class Rootline extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('rootline_model');
    }
    public function index() {
        $this->rootline_model->get_current();
        $data = array(
            'page' => 'my page.'
        );
        $this->load->view('rootline_view',$data);
    }
}

