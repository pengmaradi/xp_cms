<?php
/*
 * Model Menu_model
 * @author tz@eb-zuerich.ch
 */
class Menu_model extends CI_Model {

    private $table = 'categories';
  
    private $ID = 'id';
    private $pID = 'parentID';
    private $nods = 'children';
    private $pos = 'lft';

    private $menues = array();
    private $outMenues = array();

    public function __construct($attributes = null) {
        parent::__construct();        
    }
    public function loadAttributes($attributes = null) {
        if(is_array($attributes)) {
            foreach($attributes as $k=>$a) {
                if(isset($this->$k)) $this->$k=$a;
            }
        }
    }
  
    private function _getMenus() {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->order_by($this->pID);
        $this->db->order_by($this->pos);
        return $this->db->get();
    }
  
    public function getMenuFlat() {
        $res = $this->_getMenus();
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $k => $v) {
                $this->menues[$v[$this->ID]] = $v;
            }
        }
        // mit root 
        // $this->_helperMenuFlat(array_shift($this->menues));
        //
        // ohne root
        $this->_helperMenuFlat();
              
        return $this->outMenues;
    }

    private function _helperMenuFlat($cand='0') {
        if(is_array($cand)) {
            $this->outMenues[$cand[$this->ID]] = $cand; 
        } else {
            $cand = array($this->ID=>$cand);
        }
        foreach($this->menues as $m) {
            if($cand[$this->ID]==$m[$this->pID]) {
                $this->outMenues[$cand[$this->ID]][$this->nods] = TRUE;
                $this->_helperMenuFlat($m); 
            } 
        }
    }
 
    public function getMenuTree() {
        $res = $this->_getMenus();
        $items = array();
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $k => $v) {
                $items[ $v[$this->ID] ] = $v;
                // verlinken mit dem elternteil (=& by reference)
                $items[ $v[$this->pID] ][$this->nods][ $v[$this->ID] ] =& $items[ $v[$this->ID] ];
            }
            return $items[0][$this->nods];
        }
    }
}
?>