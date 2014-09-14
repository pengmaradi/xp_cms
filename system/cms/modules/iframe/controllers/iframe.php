<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Iframe extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    /**
     * action index
     * @return void Description
     */
    public function index() {       
        $this->load->view('iframe_view');
    }

}
/* End of file install.php */
/* Location: ./application/controllers/install.php */
