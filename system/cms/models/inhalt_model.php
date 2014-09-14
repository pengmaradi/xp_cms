<?php

class Inhalt_model extends CI_model
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
        $this->db->where($key, $value);
        $this->db->select('*');
        $query = $this->db->get($tbname);
        return $query->result(); // 返回数组 array(1){[0]=> object{}} $array[0]->name
//        return $query->row(); // 返回对象 $obj->name
//        return $query->result_array();
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

    /*
      public function getTeil($tbname,$per_page){
      $this->db->select('*');
      $query = $this->db->get($tbname);
      $num = $query->num_rows();
      $this->db->limit($per_page,$num);
      $query = $this->db->get($tbname);
      return $query->result();
      }
     */
    /**
     *
     * @param type $tbname
     * @param type $start_row
     * @param type $limit
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
     * @param type $tbname
     * @return type
     */
    public function countRows($tbname)
    {
        return $this->db->count_all($tbname);
    }

    /**
     *
     * @param type $tbname
     * @param type $arr
     * @return boolean
     */
    public function can_log_in($tbname, $arr)
    {
        //        $arr = array(
        //          'name' => $this->input->post('name'),
        //          'password' => $this->input->post('password'),
        //        );
        foreach ($arr as $key => $value)
        {
            $this->db->where($key, $value);
        }
        $query = $this->db->get($tbname);
        if ($query->num_rows() == 1)
        {

            return true;
        } else
        {

            return false;
        }
    }
    /**
     *
     * @param type $tbname
     * @param type $key
     * @param type $value
     * @param type $data
     */
    public function updateInhalt($tbname, $key, $value, $data)
    {
        $this->db->where($key, $value);
        $this->db->update($tbname, $data);
    }
    /**
     *
     * @param type $tbname
     * @param type $data
     */
    public function insertValue($tbname, $data)
    {
        $this->db->insert($tbname, $data);
    }
    /**
     *
     * @param type $tbname
     * @param type $key
     * @param type $value
     */
    public function deleteValue($tbname, $key, $value)
    {
        $this->db->where($key, $value);
        $this->db->delete($tbname);
    }

    public function getMenu(){
        $this->db->select(array('title','description', 'url'))
                ->where('deleted', 0)
                ->where('hidden', 0)
                ->order_by('uid');
        $query = $this->db->get('fe_pages');
        return $query->result_array();
    }
}
