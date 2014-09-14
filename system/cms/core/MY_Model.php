<?php

!defined('BASEPATH') and exit('No direct script access allowed');

class MY_Model extends CI_Model
{

    /**
     * name:        getAssoc
     *
     * get associative array width data from selected Records
     *
     * @param       string  $table    database table name
     * @param       array   $fields   fieldnames
     * @param       string  $where    string for WHERE-CLause
     * @param       string  $order    string for ORDER BY-part
     *
     * @return      array
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20111209
     *
     * */
    public function getAssoc($table, $fields = array(), $where = '', $order = 'RAND()')
    {
        $items = array();
        $this->db->from($table);
        $this->db->select(implode(',', $fields), FALSE);
        if ($where != '')
        {
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->order_by($order);
        $result = $this->db->get();
        $aKeys = array();
        if ($result->num_rows() > 0)
        {
            foreach ($result->result() as $i => $row)
            {
                $i == 0 and $aKeys = array_keys(get_object_vars($row));
                $items[$row->$aKeys[0]] = $row->$aKeys[1];
            }
        }
        return $items;
    }

    /**
     * name:        getCol
     *
     * get array width data from selected Records
     *
     * @param       string  $table    database table name
     * @param       string  $field    fieldname
     * @param       string  $where    string for WHERE-CLause
     * @param       string  $order    string for ORDER BY-part
     *
     * @return      array
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20111209
     *
     * */
    public function getCol($table, $field, $where = '', $order = 'RAND()')
    {
        $items = array();
        $this->db->from($table);
        $this->db->select($field);
        if ($where != '')
        {
            $this->db->where($where, NULL, FALSE);
        }
        $this->db->order_by($order);
        $result = $this->db->get();
        if ($result->num_rows() > 0)
        {
            foreach ($result->result() as $row)
            {
                $items[] = $row->$field;
            }
        }
        return $items;
    }

    /**
     * name:        getRow
     *
     * get associative array width data from one Record
     *
     * @param       string  $table     database table name
     * @param       string  $fields    fieldnames, comma separated
     * @param       array   $where_array data for WHERE-Clause, key =
     *                                   fieldname, value = search string
     * @return      array
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20111209
     *
     * */
    public function getRow($table, $fields, $where_array)
    {
        $this->db->select($fields, false);
        $this->db->where($where_array, false);
        return $this->db->get($this->db->dbprefix . $table)->row_array();
    }

    /**
     * name:        getOne
     *
     * get value of one field
     *
     * @param       string  $table    database table name
     * @param       string  $field    fieldname
     * @param       string  $where    string for WHERE-CLause
     * @return      string
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20111209
     *
     * */
    public function getOne($table, $field, $where = '', $sort = '')
    {
        $this->db->from($table);
        $this->db->select($field);
        $where != '' and $this->db->where($where, NULL, FALSE);
        $sort != '' and $this->db->order_by($sort);
        $this->db->limit(1);
        $result = $this->db->get();
        if ($result->num_rows() > 0)
        {
            $row = $result->result();
            return $row[0]->$field;
        }
        return '';
    }

    /**
     * name:        countEntries
     *
     * count all Records
     *
     * @param       string  $table    database table name
     * @return      integer
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20111209
     */
    function countEntries($table)
    {
        return $this->db->count_all($table);
    }

    /**
     * name:        deleteRecord
     *
     * delete one record by ID
     *
     * @param       string  $sTable      database table name
     * @param       integer $iId         ID of Record to delete
     * @param       string  $sWhere      WHERE Clause for UpdateSort
     * @param       boolean $bUpdateSort Update Sort Yes / No?
     * @return      boolean
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20120115
     */
    public function deleteRecord($sTable, $iId, $sWhere = '', $bUpdateSort = true)
    {
        $bUpdateSort and $this->updateSort($sTable, $iId, $sWhere);
        $this->db->where('id', $iId);
        return $this->db->delete($sTable);
    }

    /**
     * name:        updateSort
     *
     * Reduces the Value of the sort field by 1 for all
     * Records following the one to be deleted
     *
     * @param       string  $sTable      database table name
     * @param       integer $iId         ID of Record to delete
     * @param       string  $sWhere      WHERE Clause for UpdateSort
     * @param       string  $sIdField    Name of field which has to match $iId
     * @return      boolean
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20120115
     */
    public function updateSort($sTable, $iId, $sWhere = '', $sIdField = 'id')
    {
        $iCurrentSort = $this->getOne($sTable, 'sort', $sIdField . '=' . $iId);
        $sSql = 'UPDATE ' . $this->db->dbprefix($sTable) . '
             SET sort = sort - 1
             WHERE sort > ' . $iCurrentSort;
        $sWhere != '' and $sSql .= ' AND ' . $sWhere;
        return $this->db->query($sSql);
    }

    /**
     * name:        getRowsByWhereIn
     *
     * get array width data from selected Records
     *
     * @param       string  $table    database table name
     * @param       string  $field    name of field fpr WHERE IN query
     * @param       array   $wherein_array array with values for WHERE clause
     * @param       string  $order    string for ORDER BY-part
     * @return      array
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20111209
     */
    public function getRowsByWhereIn($table, $field, $wherein_array, $order)
    {
        $this->db->where_in($field, $wherein_array);
        $this->db->order_by($order);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    /**
     * Make sure that the incoming array does not contain any
     * fields which are not in the target table.
     *
     * @access      public
     * @param       string
     * @param       array (call by reference)
     *
     */
    public function filterDataArray($table, &$data)
    {
        $fields = $this->db->list_fields($table);
        foreach ($data as $k => $v)
        {
            if (in_array($k, $fields) == false)
            {
                unset($data[$k]);
            }
        }
        return $data;
    }

    public function saveRecord($table, $data_array, $item_id = -1, $id_field_name = 'id')
    {
        $this->filterDataArray($table, $data_array);
        if ($item_id != -1)
        {
            $this->db->where($id_field_name, $item_id);
            $this->db->update($table, $data_array);
        } else
        {
            $this->db->insert($table, $data_array);
            $item_id = $this->db->insert_id();
        }
        return $item_id;
    }

    /**
     * name:        saveOrder
     *
     * Updates sort field for all records matching
     * values (IDs) in aIds-Array: starts with 1 and increments
     * sort field of every next record by 1
     * If ID is not the primary key, the WHERE Clause will
     * help to determine which records are affected
     *
     * @access      public
     * @param       string  $sTable    database table name
     * @param       array   $aIds      data-Array to be saved
     * @param       string  $sWhere    WHERE clause
     * @param       string  $sIdField  Name of field which has to match $iId
     *
     * @return      true
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20120115
     *
     */
    public function saveOrder($sTable, $aIds, $sWhere = '', $sIdField = 'id')
    {
        if (count($aIds) > 0)
        {
            foreach ($aIds as $i => $iId)
            {
                $sWhere != '' and $this->db->where($sWhere);
                $this->db->where($sIdField, $iId);
                $this->db->update($sTable, array('sort' => ($i + 1)));
            }
        }
        return true;
    }

    /**
     * name:        getNextId
     *
     * Gets next ID value for sTable
     *
     * @access      public
     * @param       string  $sTable    database table name
     * @param       string  $sWhere    WHERE clause
     *
     * @return      integer ID
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20120115
     *
     */
    public function getNextId($sTable = 'workshop', $sWhere = '')
    {
        return $this->getNextValue($sTable, 'id', $sWhere);
    }

    /**
     * name:        getNextSort
     *
     * Gets next sort field value for sTable
     *
     * @access      public
     * @param       string  $sTable    database table name
     * @param       string  $sWhere    WHERE clause
     *
     * @return      integer Sortfield value
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20120115
     *
     */
    public function getNextSort($sTable = 'workshop', $sWhere = '')
    {
        return $this->getNextValue($sTable, 'sort', $sWhere);
    }

    /**
     * name:        getNextValue
     *
     * Gets next value value for sFieldname in sTable
     *
     * @access      public
     * @param       string  $sTable      database table name
     * @param       string  $sFieldname  name of field for which next value will be calculated
     * @param       string  $sWhere      WHERE clause
     *
     * @return      integer next value or -1
     *
     * @author      Roger Klein - rklein [at] klik-info [dot] ch
     * @date        20120115
     *
     */
    public function getNextValue($sTable = '', $sFieldname = 'id', $sWhere = '')
    {
        if ($sTable == '')
        {
            return -1;
        }
        $iReturnValue = 1;
        $this->db->select_max($sFieldname, 'max');
        $sWhere != '' and $this->db->where($sWhere);
        $oResult = $this->db->get($sTable)->result();
        isset($oResult[0]) and $iReturnValue = $oResult[0]->max + 1;
        return $iReturnValue;
    }

}