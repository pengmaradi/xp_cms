<?php
/*
 * Model Blog_model
 * @author Fabian Wesner kontakt@fabian-wesner.de
 * 
 */
class Activerecords_model extends CI_Model {

  private $mTableName1 = 'postkarten';
  private $mTableName2 = 'kategorien';
   
  /**
   * Konstruktor
   */
  public function __construct() {
    parent::__construct();
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
   * @param       boolean
   * @return      array
   *
   */
  protected function getArray($use_id_as_key = true) {
      $res = $this->db->get();
      $items = array();
      
      if ($res->num_rows() > 0) {
          foreach ($res->result_array() as $k => $v) {
              foreach ($v as $kk => $vv) {
                  if($use_id_as_key === true) $items[$v['id']][$kk] = $vv;
                  else $items[$k][$kk] = $vv;
              }
          }
      } 
      return $items;
  } 
  
   /**
   * SELECT *
   */
  public function selectAll($tableName) {
    return $this->db->get($tableName)->result_array();
  }
  
  /**
   * SELECT Custom
   */
  function selectCustom($tableName, $where = '', $fields = array(), $order = '', $limit = '', $startRecord = '') {
    $this->db->from($tableName);
    $this->db->select('kat_id, bild');
    $this->db->where('kat_id < ', 3);
    $this->db->where('bild != ', '""');
    $this->db->order_by('kat_id ASC');
    $this->db->order_by('bild DESC');
    $this->db->limit(3);
    
    return $this->db->get()->result_array();
    
    // $fields = array('kat_id <' => 3, 'bild != ' => '""');
    // $this->db->get($tableName, $whereArray, $per_page, $cur_page);
  }
  
  /**
   * SELECT Join
   */
  function selectJoin($tableName1, $tableName2) {
    $this->db->from($tableName1);
    $this->db->join($tableName2, $tableName1 . '.kat_id = ' . $tableName2 . '.id');
    $this->db->select('kategorie, bild');
    $this->db->limit(4, 5);
    
    return $this->db->get()->result_array();
  }
  
  function selectCustomWhere($tableName) {
    $this->db->from($tableName);
    $this->db->where('kat_id IN (1, 2) AND RIGHT(bild, 3) = "jpg"');
    $this->db->select('kat_id, bild');
    
    return $this->db->get()->result_array();    
  }
 

  /**
   * Zaehlt alle Datensaetze
   */
  function countEntries() {
    return $this->db->count_all($tableName);
  }

  /**
   * Loescht Datensatz
   */
  function deleteRecord($tableName, $id) {
    $this->db->where('id', $id); 
    $this->db->delete($tableName);
  }
  
  /**
   * Liefert einen Datensatz
   */
  function getRecord($tableName, $id) {
    $this->db->where('id', $id);
    $query = $this->db->get($tableName);
    return array_pop($query->result_array());
  }
  
  function getOne($tableName, $fieldName, $where = '', $orderBy = 'RAND()') {
      $this->db->from($tableName);
    $this->db->select($fieldName);
    if ($where != '') {
        $this->db->where($where);
    }
    $this->db->order_by($orderBy);
    
    $row = array_shift($this->db->get()->result());
    
    return $row->$fieldName;
  }
  
  function getAssoc($tableName, $fields = array(), $where = '', $orderBy = 'RAND()') {
      $items = array();

    $this->db->from($tableName);
    $this->db->select(implode(',', $fields));
    if ($where != '') {
        $this->db->where($where);
    }
    $this->db->order_by($orderBy);
    
    $result = $this->db->get();
    
    if ($result->num_rows() > 0) {
        foreach ($result->result() as $row) {
           $items[$row->$fields[0]] = $row->$fields[1];
        }
    }
    return $items;
  }
 
}

?>