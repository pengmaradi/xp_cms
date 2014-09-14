<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Createpage extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('xpcms/index');
    }
    /**
     * 
     * @param string $action
     * @param string $fieldset
     */
    public function index($action = '', $fieldset = '') {
        $this->load->model('xpcms/inhalt_model');
        $temparr = $this->inhalt_model->getValue('template','uid',1);
        $template = $temparr[0]->template;
        $data = array(
            'template' => json_decode($template)
        );
        //print_r($data['template']);
        $this->load->helper('ckeditor');

        //$images = 'public_html/images/?CKEditor=content&CKEditorFuncNum=1';
        $images = 'xpcms/files';
        //http://localhost/xp_cms/public_html/images/?CKEditor=content&CKEditorFuncNum=1&langCode=en
        $data['ckeditor'] = array(
            //ID of the textarea that will be replaced
            'id' => 'content',
            'path' => 'js/ckeditor',
            //Optionnal values
            'config' => array(
               // 'filebrowserImageUploadUrl' => 'http://localhost/xp_cms/xpcms/fileUpload',
                'filebrowserUploadUrl' => $images,
                'filebrowserImageBrowseUrl' => $images,
                'filebrowserImageWindowWidth' => '50%',
                'filebrowserImageWindowHeight' => '20%',
                'toolbar' => "Full", //Using the Full toolbar
                'width' => "100%", //550pxSetting a custom width
                'height' => '100px', //Setting a custom height
            ),
            //Replacing styles from the "Styles tool"
            'styles' => array(
                //Creating a new style named "style 1"
                'style 1' => array(
                    'name' => 'Red Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Red',
                        'font-weight' => 'bold',
                        'text-decoration' => 'underline'
                    )
                ),
                
                'style 2' => array(
                    'name' => 'Blue Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Blue',
                        'font-weight' => 'bold'
                    )
                ),
                //Creating a new style named "style 2"
                
                'style 3' => array(
                    'name' => 'Yellow Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Yellow',
                        'font-weight' => 'bold'
                    )
                ),
                
                'style 4' => array(
                    'name' => 'Green Title',
                    'element' => 'h3',
                    'styles' => array(
                        'color' => 'Green',
                        'font-weight' => 'bold'
                    )
                )
                
            )
        );
/*
        $data['ckeditor_1'] = array(
            //ID of the textarea that will be replaced
            'id' => 'content_1',
            'path' => 'js/ckeditor',
            //Optionnal values
            'config' => array(
                'width' => "80%", // 550pxSetting a custom width
                'height' => '50px', //Setting a custom height
                'toolbar' => array(//Setting a custom toolbar
                    array('Bold', 'Italic'),
                    array('Underline', 'Strike', 'FontSize'),
                    array('Smiley'),
                    '/'
                )
            ),
            //Replacing styles from the "Styles tool"
            'styles' => array(
                //Creating a new style named "style 1"
                'style 3' => array(
                    'name' => 'Green Title',
                    'element' => 'h3',
                    'styles' => array(
                        'color' => 'Green',
                        'font-weight' => 'bold'
                    )
                )
            )
        );
        */
        $data['action'] = $action;
        $data['fieldset'] = $fieldset;
        $this->load->view('createpage_view', $data);
    }

}

/* End of file admin.php */
/* Location: ./cms/modules/createpage/controllers/createsearch.php */