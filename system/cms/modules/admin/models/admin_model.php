<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class admin_model extends CI_Model{
    /**
     *
     * @var string 
     */
    private static $_table;
    /**
     * __construct
     */
    public function __construct() {
        parent::__construct();
        self::$_table = 'be_users';
    }
    public function get_value($key, $value) {
        $query = $this->db
                ->select('*')
                ->where($key, $value)
                ->where('deleted', 0)
                ->get(self::$_table);
        return $query->result();
    }

    /**
     * 
     * @param string $user
     * @return boolean
     */
    public function can_create_user($user)
    {
        $query = $this->db
                ->where('username', $user)
                ->get(self::$_table);
        if ($query->num_rows() == 1)
        {
            return false;
        } else
        {
            return true;
        }
    }
    /**
     * 
     * @param array $data
     * @return int insert id
     */
    public function set_user(array $data) {
        $this->db->insert(self::$_table,$data);
        return $this->db->insert_id();
    }
    /**
     * 
     * @param int $uid
     * @param array $data
     * @return boolean
     */
    public function reset_user($uid = 0, array $data) {
        $this->db->where('uid',$uid)->update(self::$_table,$data);
        if($this->db->affected_rows() > 0){
            return TRUE;
        }  else {
            return FALSE;
        }
    }
    /**
     * 
     * @param type $uid
     * @return object
     */
    public function get_user($uid){
        $query = $this->db
                ->select('*')
                ->where('uid',$uid)
                ->get(self::$_table);
        return $query->result();
    }
}

/**
 * modules/admin/admin_model.php
 */