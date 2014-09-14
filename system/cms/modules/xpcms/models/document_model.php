<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of document_model
 *
 * @author Xiaoling
 */
class Document_model  extends CI_Model {

    private $gallery_path;
    private $gallery_path_url;
    public function __construct() {
        parent::__construct();
        $this->gallery_path = 'public_html/files';
        $this->gallery_path_url = base_url() . 'public_html/files/';
    }
    /**
     * do_upload
     */
    public function do_upload() {
        $config = array(
            'allowed_types'  => 'pdf|txt|doc|docx|xml',
            'upload_path'    => $this->gallery_path,
            'max_size'       => 1024*10000
        );

        $this->load->library('upload', $config);
        $upload_success = $this->upload->do_upload('dument');
     
        $document_data = $this->upload->data();
        $now = time();
        $data = array(
            'id' => NULL,
            'file_name' => $document_data['file_name'],
            'file_type' => $document_data['file_type'],
            'file_path' => $this->gallery_path,
            'file_size' => $document_data['file_size'],
            'up_time' => $now
        );
        
        if($document_data['file_name'] && $upload_success) {
           $this->db->insert('files', $data);
        }
        
    }
    /**
     * get_documents
     * @return string
     */
    public function get_documents() {
        $files = scandir($this->gallery_path);
        $files = array_diff($files, array('.', '..'));
        //print_r($files);
        $documents = array();
		//echo count($files);die('.');
        if(!empty($files)) {
            foreach ($files as $file) {
                    $query = $this ->db->select('file_size')->where('file_name',$file)->get('files');
                    $rows = $query->result();
                    $file_size = $rows[0]->file_size;
                    $documents [] = array(
                            'file' =>$file,
                            'url' => $this->gallery_path_url . $file,
                            'file_size' => $this->_getFilesize($file_size)
                    );				
            }
        }
        
        return $documents;
    }
    /**
     * 
     * @param int $filesize
     * @param int $digits
     * @return string
     */
    private function _getFilesize($filesize,$digits = 2) {
        $sizes = array("TB","GB","MB","KB","B");
        $total = count($sizes);
        while ($total-- && $filesize > 1024) {
            $filesize /= 1024;
        }
        return round($filesize, $digits)." ".$sizes[$total];
    }
    /**
     * 
     * @param type $file_name
     * @return boolean
     */
    public function do_delete($file_name) {        
        //
        //$sysfold = str_replace('index.php','',$_SERVER['PHP_SELF']);
        if(is_file($this->gallery_path.'/'.$file_name)) {            
            $this->db->where('file_name', $file_name)->delete('files');            
//            unlink($_SERVER['DOCUMENT_ROOT'].$sysfold.$this->gallery_path.'/'.$file_name);
            unlink($this->gallery_path.'/'.$file_name);
            return TRUE;
        }else{
            return FALSE;
        }
       //return $this->gallery_path.'/'.$file_name;  
    }
}

/* End of file document_model.php */
