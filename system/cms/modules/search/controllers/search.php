<?php

/**
 * Description of search
 *
 * @author xiaoling peng
 */
class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('search_model');
    }
    /**
     * 
     * @param string $action
     */
    public function index($action=''){
        $data = array();
        if($this->input->get('s') != '' ){
            $search_term = $this->input->get('s');
            $data['result'] = $this->search_model->get_result($search_term);           
            $num = count($data['result']);
            $menus = '';
            for($i = 0; $i < $num; $i ++) {
               $ms = $this->search_model->get_menu($data['result'][$i]['pid']);
               $menus .= $ms[0]['url'].',';
            }
            
            $data['menus'] = explode(',', $menus);
            $n = count($data['menus']);
            unset($data['menus'][$n-1]);
            //print_r($data['menus']);
            
        } else {
            $data['result'] = array();
            $data['menus'] = array();
        } 
        $data['action'] = $action;
        $this->load->view('search_view',$data);
    }
    public function get_result(){
        $json = array();
        $json['success'] = FALSE;
        if(isset($_POST['s']) && $_POST['s'] != '') {
            $search_term = $_POST['s'];
            $result = array();
            $result = $this->search_model->get_result($search_term);
            $num = count($result);
            $menus = '';
            for($i = 0; $i < $num; $i ++) {
               $ms = $this->search_model->get_menu($result[$i]['pid']);
               $menus .= $ms[0]['url'].',';
            }            
            $arrmenus = explode(',', $menus);
            $n = count($arrmenus);
            unset($arrmenus[$n-1]);
            $json['result'] = '';
            for ($i = 0; $i < $num; $i++) {                
                $json['result'] .= '<p><a href="home/'.$arrmenus[$i].'">' . $result[$i]['header'] .'</a></p>';
            }
            
            $json['success'] = TRUE;
        }
        echo json_encode($json);
    }

}

