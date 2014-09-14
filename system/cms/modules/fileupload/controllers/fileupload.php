<?php

class Fileupload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) redirect('xpcms/index');
        $this->load->helper('form', 'url');
    }
    

    public function index() {
        // it is ok
        $this->load->view('upload_form', array('error' => ''));
        //$this->load->view('upload');
    }

    public function do_upload() {
        $config['upload_path'] = './public_html/xp/xp_cms/images/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = date('YmdHis', time());
        $config['max_size'] = '800';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['remove_spaces'] = TRUE; // 参数为TRUE时，文件名中的空格将被替换为下划线。推荐使用。

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());

            $this->load->view('upload_success', $data);
        }
    }

    public function upload_file() {
        $status = "";
        $msg = "";
        $file_element_name = 'userfile';

        if (empty($_POST['title'])) {
            $status = "error";
            $msg = "Please enter a title";
        }

        if ($status != "error") {
            $config['upload_path'] = './files/';
            $config['allowed_types'] = 'gif|jpg|png|doc|txt';
            $config['max_size'] = 1024 * 8;
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
    
    public function files()
    {
       $files = $this->files_model->get_files();
       $this->load->view('files', array('files' => $files));
    }

}
