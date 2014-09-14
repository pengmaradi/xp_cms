<?php

/**
 * Description of login
 *
 * @author xiaoling peng
 */
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('login_model');
        $this->load->model('home/home_model');
        $this->load->model('xpcms/inhalt_model');
        $this->load->helper('filter');
    }
    /**
     * 
     * @param string $action
     */
    public function index(){
        $data = array();
        if($this->input->get('login') != '' ){
            $search_term = $this->input->get('login');
            $data['result'] = $this->login_model->can_login($user);           
        }   
        $data['action'] = $action;
        $this->load->view('login_view',$data);
    }
    /**
     * 
     */
    public function get_login(){
        $json = array();
        $json['success'] = FALSE;
        if(isset($_POST['login']) && $_POST['login'] != '') {            
            $json['success'] = TRUE;
        }
        echo json_encode($json);
    }
    public function check_login() {
        echo 'check_login';
    }

    public function registry() {
        $temparr = $this->inhalt_model->getValue('template','uid',1);
        $template = $temparr[0]->template;
        $header = $temparr[0]->header;        
        $content = $temparr[0]->content;
        $footer = $temparr[0]->footer;
        $sidebar = $temparr[0]->sidebar;
        $data = array(
            'template' => json_decode($template),
            'header' => json_decode($header),
            'content' => json_decode($content),
            'footer' => json_decode($footer),
            'sidebar' => json_decode($sidebar)
        );
       
        $data['web_info'] = $this->inhalt_model->getValue('web_info','uid',1);        
        $script_self = str_replace('index.php', '', $_SERVER['PHP_SELF']) . 'home/';
        $request = str_replace($script_self, '', $_SERVER['REQUEST_URI']);
        $request = sqlFilter($request);
        
        if ($request == '') {
            $request = 'xpcms';
        }

        $data['contents'] = $this->home_model->getPage($request);
        $data['num'] = count($data['contents']);

        $data['feMenu'] = $this->inhalt_model->getMenu();
        $treeData = reset($data['feMenu']);
        $data['feMenu'] = @$treeData['children'];
        if($data['feMenu'] == '') {
           $data['feMenu'] = array(getMenu
           );
        } 
        $this->load->helper('tree');
        $data['page'] = $request;
        $this->load->view('registry_view',$data);
    }

}

