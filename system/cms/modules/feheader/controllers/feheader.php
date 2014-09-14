<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feheader extends CI_Controller {
    /**
     * action __construct
     * @return void Description
     */
    public function __construct() {
        parent::__construct();
    }
    /**
     * action index print frontend header
     * @param array $data Description
     * @return void
     */
    public function index($title,$keywords,$description,$google,$icon,$page,$body_color,$header_color,$logo){   
        $data = array(
            'title' =>$title,    
            'keywords' =>$keywords,
            'description' =>$description,
            'google_verification'=>$google,
            'icon' =>$icon,
            'page' =>$page,
            'body_color' => $body_color,
            'header_color' => $header_color,
            'logo' => $logo
        );
        
        $this->load->view('feheader_view',$data);
    }
}

