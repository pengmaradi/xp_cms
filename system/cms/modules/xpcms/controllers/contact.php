<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contact
 *
 * @author cabag
 */
class Contact extends CI_Controller{
    private $userarr = array();
    private static $be_users = 'be_users';
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('xpcms/index');
        $this->load->model('inhalt_model');
        $this->userarr = $this->inhalt_model->getValue(self::$be_users , 'username !=', $this->session->userdata('username'));
    }
    public function index() {
        $num = count($this->userarr);
        $mails = array();
        $str = '';
        for($i = 0; $i < $num; $i ++) {
            $str .= $this->userarr[$i]->email.',';
        }
        $mails = explode(',', $str);
        echo $mails[$_POST['usersel'] - 1];
        //echo $_POST['usersel'];
        
        die();
        $this->load->library('email');
        $this->email->from('your@example.com', 'Your Name');
        $this->email->to('someone@example.com');
        $this->email->cc('another@another-example.com');
        $this->email->bcc('them@their-example.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();

        echo $this->email->print_debugger();
    }

}

