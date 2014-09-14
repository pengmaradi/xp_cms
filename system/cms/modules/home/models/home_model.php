<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of home_model
 *
 * @author xiaoling peng
 */
class home_model extends CI_Model{

    public function __construct() {
        
    }
    public function getPage($url = '') {
   /**
    * # pid is the uid of the fe_psges
    * # 1. check if starttime > time() then do not select
    * # SELECT * FROM content WHERE starttime < 'time()'
    * # SELECT * FROM `content` WHERE pid = 11 AND (endtime = 0 OR endtime > 'time()')
    * # 2. if enttime = 0 then select all
    * # SELECT * FROM `content` WHERE `endtime` =0
    * # 3. if enttime > 0 then select > time()
    * # SELECT * FROM `content` WHERE `endtime` > 'time()'
    */  

        $pid = $this->_getPageId($url);
        if(empty($pid)){
            $pid = 0;
       }
       $sql = 'SELECT * FROM content WHERE pid = '.$pid.' AND starttime < '.time().' AND (endtime = 0 OR endtime > '.time().' ) AND display =1 AND deleted = 0 ';
       $query = $this->db->query($sql);

       /*
        $query =  $this->db
                ->select('*')
                ->where('pid', $pid)
                ->where('display', 1)
                ->where('deleted', 0)
                //->where('endtime', 0)
                //->or_where('endtime >', time())
                ->get('content');
        */
//        echo $this->db->last_query();
        return $query->result_array();      
    }
    /**
     * 
     * @param string $url
     * @return boolean
     */
    private function _isPageValid($url = 'page') {

        $this->db
            ->where('url', $url)
            ->where('hidden', 0)
            ->where('nav_hidden', 0)
            ->where('deleted', 0);

        $query = $this->db->get('fe_pages');
        if ($query->num_rows() == 1)
        {
            return true;
        }        
        return FALSE;
    }
    /**
     * action _getPageId get uid from fe_pages where menu is $url
     * @param string $url
     * @return int
     */
    private function _getPageId($url){
        if($this->_isPageValid($url)) {
            $this->db->select('uid')
                ->where('url', $url)
                ->where('deleted',0);
            $query = $this->db->get('fe_pages');
            
            $row = $query->result();

            return $row[0]->uid;
        }
    }
    /**
     * action _getContentKeys get array keys from menu:url
     * @param string $url
     * @param string $key
     * @return array
     */
    private function _getContentKeys($key='',$url = '') {
        $pid = $this->_getPageId($url);
        $query = $this->db
                ->select($key)
                ->where('pid', $pid)
                ->get('content');
        $row = $query->result();
//      echo $this->db->last_query();
        return $row;
        //$row[0]->$key ,$row[1]->$key, ...
    }
    
}

