<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Xmodel extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        log_message('debug', "Extended XModel->Model Class Initialized");
    }
    
    /**
     * Make sure that the incoming array does not contain any
     * fields which are not in the target table.
     * Additionally, input can be XSS filtered.
     *
     * @access      protected
     * @param       string
     * @param       array
     * @param   boolean
     * @return      array
     *
     */     
    protected function filterInputArray($table, $data, $xss_clean = false) {
        $fields = $this->db->list_fields($table);

        foreach ($data as $k => $v) {
            if(in_array($k, $fields) == false){
                unset($data[$k]);
            } else {
                if($xss_clean === true) $data[$k] = $this->input->xss_clean($v);
            }
        }
        return $data;
    }

    /**
     * Similar to active record's get method.
     * Will always return an array, even if the query did not yield any results.
     * By default, the reulting array's keys are equal to 'id'. That feature may
     * be disabled by passing false as an optional parameter.
     *
     * @access      protected
     * @param       string
     * @param       boolean
     * @return      array
     *
     */
    protected function getArray($id = 'id', $use_id_as_key = true) {
        $res = $this->db->get();
        $items = array();

        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $k => $v) {
                foreach ($v as $kk => $vv) {
                    if($use_id_as_key === true) $items[$v[$id]][$kk] = $vv;
                    else $items[$k][$kk] = $vv;
                }
            }
        } 
        return $items;
    }
    
}