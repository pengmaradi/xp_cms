<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
/* Location: ./system/cms/modules/xpcms/controllers/pages_edtor.php */ 

class Pages_edtor extends CI_Controller{
    /**
     * 
     */
    public function __construct() {
        parent::__construct();        
        // get session page protected
        if (!$this->session->userdata('logged_in')) redirect('xpcms/index');        
    }
    /**
     * 
     */
    public function index() {
        
        $url = '';
        if(isset($_REQUEST['url'])) {
            $url = $_REQUEST['url'];
        }
        $this->load->model('inhalt_model');
        $this->load->model('xpcms/file_model');
        $this->load->model('xpcms/document_model');
        // get template
        $temparr = $this->inhalt_model->getValue('template','uid',1);
        $template = $temparr[0]->template;
        $data = array(
            'template' => json_decode($template),
            'gallery' => $this->file_model->get_images(),
            'documents' => $this->document_model->get_documents()
        );

        // get fe menu
        $menurows = $this->inhalt_model->getValue('fe_pages','url', $url);

        $pid = $menurows[0]->uid;
        
        $data['content'] = $this->inhalt_model->getValue('content','pid',$pid);
        // editor
        $this->load->helper('ckeditor');

        $this->load->view('pages_edtor_view',$data);
    }
    /**
     * 
     */
    /*$data['menus'] = $this->inhalt_model->getMenu();
        $data['num'] = count($data['menus']);*/
    public function order() {
        $order = $_POST['order'];
        $children = isset($order['children']) ? (int) $order['children'] : 0;
        print_r($children);
        die('just stop');
    }
    
    /**
     * action get uid and if text content set editor
     */
    public function get_uid() {
        //header('Content-type: text/javascript');
        $uid = @$_REQUEST['uid'];
        return $uid;
    }
}

