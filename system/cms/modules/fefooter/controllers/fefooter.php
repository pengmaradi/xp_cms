<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fefooter extends CI_Controller {
    /**
     * action __construct
     * @return void Description
     */
    public function __construct() {
        parent::__construct();
    }
    /**
     * action index print frontend footer 
     * @return void
     */
    public function index(
            $google_analitytics,
            $web_copyright,
            $social_netzwork,
            $web_address,
            $footer_color)
    {
        $data = array(
           'google_analitytics' => $google_analitytics,
           'web_copyright' =>  $web_copyright,
           'social_netzwork' =>  $social_netzwork,
           'web_address' =>  $web_address,
           'footer_color' =>  $footer_color
        );
        $this->load->view('fefooter_view',$data);
    }
}

