<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sorting
 *
 * @author cabag
 */
class Sorting extends CI_Controller {
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('xpcms/index');
        $this->load->model('MPTtree');
        $this->MPTtree->set_opts(array('table' => 'fe_pages'));
        $this->load->helper('debug');
    }
    /**
     * 
     */
    public function index() {        
        $treeData = $this->MPTtree->tree2array();        
        $this->load->helper('tree');
        $treeData = reset($treeData);
        //print_r($treeData);
        $this->load->view('tree_view', array('treeData' => $treeData['children']));
    }

    // call by ajax
    public function rearrangeTree() {
        if ($action = $this->input->post('action')) {
            $this->load->model('MPTtree');
            if ($action == 'insert') {
                debug($this->MPTtree->move_node_after($this->input->post('left'), $this->input->post('nleft')));
            } else if ($action == 'append') {
                debug($this->MPTtree->move_node_append($this->input->post('left'), $this->input->post('nleft')));
            } else if ($action == 'delete') {
                echo $this->MPTtree->delete_node($this->input->post('left'));
            }
        }
    }

}

