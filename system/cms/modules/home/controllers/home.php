<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('home_model');
        $this->load->model('xpcms/inhalt_model');
        $this->load->helper('filter');
    }

    /**
     * action index
     * 
     * @param string $request Description
     * @return void Description
     */
    public function index() {
//        $script_self = str_replace('index.php', '', $_SERVER['PHP_SELF']) . 'home/';
//        @$request = str_replace($script_self, '', $_SERVER['REDIRECT_URL']);
//        die($request.' - page');

        $this->page();
    }

    /**
     * action page
     * @return void Description
     */
    public function page() {
        
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
        // !!! SQL FILTER !!!
        // if request is not in db or site is deleted then goto home or 404

        $data['feMenu'] = $this->inhalt_model->getMenu();
        $treeData = reset($data['feMenu']);
        $data['feMenu'] = @$treeData['children'];
        if($data['feMenu'] == '') {
           $data['feMenu'] = array('getMenu');
        } 
        $this->load->helper('tree');
        $data['page'] = $request;
        $tmp = $data['template']->template;
        $this->load->view('home_'.$tmp.'_view', $data);
    }

}

/* End of file install.php */
/* Location: ./application/controllers/install.php */
