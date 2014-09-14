<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Createpage extends CI_Controller {

    public function index($action = '', $fieldset = '') {
        $this->load->helper('ckeditor');

        $data = $_SERVER;
        // print_r($data);
//Ckeditor's configuration
        $data['ckeditor'] = array(
            //ID of the textarea that will be replaced
            'id' => 'content',
            'path' => 'js/ckeditor',
            //Optionnal values
            'config' => array(
                'toolbar' => "Full", //Using the Full toolbar
                'width' => "100%", //550pxSetting a custom width
                'height' => '100px', //Setting a custom height
            ),
            //Replacing styles from the "Styles tool"
            'styles' => array(
                //Creating a new style named "style 1"
                'style 1' => array(
                    'name' => 'Blue Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Blue',
                        'font-weight' => 'bold'
                    )
                ),
                //Creating a new style named "style 2"
                'style 2' => array(
                    'name' => 'Red Title',
                    'element' => 'h2',
                    'styles' => array(
                        'color' => 'Red',
                        'font-weight' => 'bold',
                        'text-decoration' => 'underline'
                    )
                )
            )
        );

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
        $data['action'] = $action;
        $data['fieldset'] = $fieldset;
        $this->load->view('createpage_view', $data);
    }

}

/* End of file admin.php */
/* Location: ./cms/controllers/admin.php */