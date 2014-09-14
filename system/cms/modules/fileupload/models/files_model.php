<?php

class Files_Model extends CI_Model {

    public function insert_file($filename, $title) {
        $data = array(
            'filename' => $filename,
            'title' => $title
        );
        $this->db->insert('files', $data);
        return $this->db->insert_id();
    }

    public function delete_file($file_id) {
        $file = $this->get_file($file_id);
        if (!$this->db->where('id', $file_id)->delete('files')) {
            return FALSE;
        }
        unlink('./files/' . $file->filename);
        return TRUE;
    }

    public function get_file($file_id) {
        return $this->db->select()
                        ->from('files')
                        ->where('id', $file_id)
                        ->get()
                        ->row();
    }

}