<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Creatfilelinks extends CI_Controller {
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
        $this->load->model('xpcms/document_model');
        $temparr = $this->inhalt_model->getValue('template','uid',1);
        $template = $temparr[0]->template;
        $data = array(
            'template' => json_decode($template),
            'documents' => $this->document_model->get_documents()
        );       
        $data['action'] = $action;
        $data['fieldset'] = $fieldset;
        $this->load->view('creatfilelinks_view', $data);
    }
    public function upfile() {
        header('Content-type: text/javascript');
        $status = '';
        $msg = '';
        $file_element_name = 'file';

        if ($status != "error") {
            $config['upload_path'] = './public_html/files';
            $config['allowed_types'] = 'doc|txt|pdf|mp3|mp4';
            $config['max_size'] = 1024 * 10;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();
                $file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
                if ($file_id) {
                    $status = "success";
                    $msg = "File successfully uploaded";
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }
            }
            @unlink($_FILES[$file_element_name]);
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

}

/* End of file admin.php */
/* Location: ./cms/modules/createpage/controllers/creatfilelinks.php */