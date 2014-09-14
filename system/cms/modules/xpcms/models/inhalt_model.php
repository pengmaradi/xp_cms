<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * class Inhalt_model
 * @package system/cms/modules/xpcms/models
 */
class Inhalt_model extends CI_model
{
    /**
     *
     * @var intger 
     */
    private $_time;
    /**
     *
     * @var boolean 
     */
    private $canLogin = FALSE;
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->_time = time();
    }
    
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
     * @param string $tbname
     * @param string $key
     * @param string $value
     * @return array
     */
    public function getAdmin($tbname, $key, $value){
        $query = $this->db->select('*')
                ->where($key, $value)
                ->where('admin', 1)
                ->where('deleted', 0)
                ->where('endtime', 0)
                ->or_where('endtime > ', $this->_time)                
                ->get($tbname);
        
        //echo $this->db->last_query(); die();        
        // return array
        //return $query->result_array();        
        // return object
        return $query->result();

    }

    /**
     *
     * @param string $tbname
     * @return array
     */
    public function getAll($tbname)
    {
        $this->db->select('*');
        $query = $this->db->get($tbname);
        return $query->result();
    }


    /**
     *
     * @param string $tbname
     * @param string $start_row
     * @param int $limit
     * @return array
     */
    public function getTeil($tbname, $start_row, $limit)
    {
        //$this->db->order_by('id'); // nachname
        $sql = "SELECT * FROM $tbname limit $start_row, $limit ";
        //$query = $this->db->get($tbname,$start_row, $limit);
        $query = $this->db->query($sql);
        return $query->result();
    }
    /**
     *
     * @param string $tbname
     * @return int
     */
    public function countRows($tbname) {
        return $this->db->count_all($tbname);
    }

    /**
     *
     * @param type $tbname
     * @param type $arr
     * @return boolean
     */
    public function can_log_in($tbname, $arr) {
        $this->db->select('*')
                ->where('username', $arr['username'])
                ->where('password',$arr['password'])
                ->where('endtime NOT BETWEEN 1 AND '.$this->_time)
                ->where('deleted', 0)
                ->where('admin', 1)
                ->where('starttime <= ', $this->_time);
        $query = $this->db->get($tbname);
        //echo $this->db->last_query();

        //return true;
        if ($query->num_rows() == 1) {            
            $this->canLogin = TRUE;
        } 
        return $this->canLogin;
    }
    
    /**
     *
     * @param string $tbname the name of table 
     * @param string $what => key = value or key != value
     * @param string $data $data = $key.' = '.$key. -2;
     */
    public function updateColumn($tbname, $what, $data) {
        $sql = 'UPDATE '.$tbname.' SET '.$data. 'WHERE '.$what;
        $this->db->query($sql);
        //echo $this->db->last_query();
    }

    /**
     *
     * @param string $tbname the name of table 
     * @param string $key the name of colum
     * @param string $value 
     * @param array $data array('tel' => '0123','name' => 'the update name');
     * @return int last id
     */
    public function updateInhalt($tbname, $key, $value, $data)
    {
        $this->db->where($key, $value);
        $this->db->update($tbname, $data);
        return $this->db->affected_rows();
        //echo $this->db->last_query();
    }
    /**
     * Update_Batch
     *
     * Compiles an update string and runs the query
     *
     * @param	string	the table to retrieve the results from
     * @param	array	an associative array of update values
     * @param	string	the where key
     * @return	object
     */
    public function updateBatches($bdtable, $data, $where) {
        $this->db->update_batch($bdtable, $data, $where); 
        echo $this->db->last_query();
    }
    /**
     *
     * @param string $tbname
     * @param array $data
     * @return init Description
     */
    public function insertValue($tbname, $data)
    {
        $this->db->insert($tbname, $data);
        return $this->db->insert_id();
    }
    /**
     *
     * @param string $tbname
     * @param string $key
     * @param string $value
     */
    public function deleteValue($tbname, $key, $value)
    {
        $this->db->where($key, $value);
        $this->db->delete($tbname);
    }
    /**
     * action getMenu
     * @return array
     */
    public function getMenu(){
        //SELECT * FROM fe_pages WHERE deleted = 0 AND hidden = 0 AND lft BETWEEN 1 AND 16 ORDER BY lft ASC 
        $firstrow = $this->getValue('fe_pages', 'uid', 1);
        $firstRgt = $firstrow[0]->rgt;
        $this->db->select('*')
                ->where('lft BETWEEN 1 AND '.$firstRgt)
                ->where('deleted', 0)
                ->where('hidden', 0)
                //->where('nav_hidden', 0)
                ->order_by('lft','ASC');
        $query = $this->db->get('fe_pages');
        //echo $this->db->last_query();
        //return $myquery->result_array();
        
        $right = array();
        $result = array();
        $current = & $result;
        $stack = array();
        $stack[0] = & $result;
        $lastlevel = 0;
        foreach ($query->result_array() as $row) {
            if (count($right)) {
                while ($right[count($right) - 1] < $row['rgt']) {
                    array_pop($right);
                }
            }
            // Go one level deeper?
            if (count($right) > $lastlevel) {
                end($current);
                $current[key($current)]['children'] = array();
                $stack[count($right)] = & $current[key($current)]['children'];
            }
            // the stack contains all parents, current and maybe next level
            $current = & $stack[count($right)];
            // add the data
            $current[] = $row;
            // go one level deeper with the index
            $lastlevel = count($right);
            $right[] = $row['rgt'];
        }
        //echo $this->db->last_query();
        //print_r($result);
        return $result;
    }
}
