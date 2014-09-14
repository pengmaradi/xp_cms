<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search_model
 *
 * @author cabag
 */
class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    /**
     * 
     * @param init $uid
     * @return array
     */
    
    /**
     * 
     * @param string $user
     * @return array
     */
    public function can_login($user = '') {
        
        if ($user != '') {
            
            $query = $this->db->query($sql);
            echo $this->db->last_query();
            return $query->result_array();
        }else {
            return array();
        }
        
    }
}

