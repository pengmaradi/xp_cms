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
class Search_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    /**
     * 
     * @param init $uid
     * @return array
     */
    public function get_menu($uid) {
        $query = $this->db->select('url')
                ->where('uid',$uid)
                ->get('fe_pages');
        return $query->result_array();
    }

    /**
     * 
     * @param string $search_term
     * @return array
     */
    public function get_result($search_term = '') {
        /**
SELECT endtime ,
CASE
WHEN endtime =0
OR endtime > NOW( )
THEN 0
ELSE NOW( )
END AS newtime
FROM content
         * 
         */
        if ($search_term != '') {
            $sql = 'SELECT * 
            FROM content 
            WHERE display = 1 
            AND deleted = 0 
            AND endtime = 0
            AND uid != 1
            AND body_text
            LIKE \'%'.$search_term.' %\' ';
        $sql .= 'UNION 
            SELECT * 
            FROM content 
            WHERE display = 1 
            AND deleted = 0 
            AND endtime >= '.time().'
            AND uid != 1
            AND body_text 
            LIKE \'%'.$search_term.'%\'';
        
            $query = $this->db->query($sql);
            //echo $this->db->last_query();
            return $query->result_array();
        }else {
            return array();
        }
        
    }
}

