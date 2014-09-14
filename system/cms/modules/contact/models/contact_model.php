<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * class Inhalt_model
 * @package system/cms/modules/contact/models
 */
/**
 * Description of contact_model
 *
 * @author Xiaoling
 */


class Contact_model extends CI_model
{
    /**
     *
     * @param string $tbname
     * @param string $key
     * @param string $value
     * @return array
     */
    public function getValue($tbname, $key, $value)
    {
        $this->db->select('*')
                ->where($key, $value);
        $query = $this->db->get($tbname);
        //echo $this->db->last_query();
        return $query->result(); 

    }
    /**
     * 
     * @return array
     */
    public function getAdminmail(){
        $query = $this->db->select('email')
                ->where('uid', 1)
                ->where('admin', 1)
                ->where('deleted', 0)
                ->where('endtime', 0)              
                ->get('be_users');
        return $query->result();

    }

    
}
