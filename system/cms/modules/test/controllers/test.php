<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->model('test_model');
    }

    public function index() {
        //$this->load->view('test');
        echo 'just testing';
    }

    public function run() {
        
    }

}

/* End of file test.php */
/* Location: ./cms/controllers/test.php */