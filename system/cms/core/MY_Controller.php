<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_controller extends CI_Controller
{
    /**
     *
     * @var array $headerData
     */
    protected $headerData = array();
    /**
     *
     */
    public function __construct($current = 'home',$loadControllerJs = false,$sLoadControllerModel = false)
    {
        parent::__construct();
        $this->load->library('menu', array('current' => $current));

        $this->headerData['menu'] = $this->menu->render();

        $this->headerData['cmstitle'] = $current;
        $this->headerData['css_files'] = array(
                                            'base' => 'all',
                                            'content' => 'all',
                                            'layout' => 'all',
                                            'print' => 'print'
                                            );
        $this->headerData['js_files'] = array('jquery.php');

        $loadControllerJs === true
                and $this->headerData['js_files'][] = $current . '.js';
        $sLoadControllerModel === true
                and $this->load->model($current . '_model', 'Model');

        //$this->load->model('Seiten_Model');
        //$this->output->enable_profiler(true);
    }

    /**
     *
     * @param type $template
     * @param type $content
     */
    public function my_renderAll($template, $content = array())
    {
        $this->load->view('header', $this->headerData);
        $this->load->view($template, $content);
        $this->load->view('footer');
    }
}

