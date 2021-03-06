<?php

/**
 * Author: Amirul Momenin
 * Desc:Class Model
 */
class Class_model extends CI_Model
{
	protected $class = 'class';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get class by id
	 *@param $id - primary key to get record
	 *
     */
    function get_class($id){
        $result = $this->db->get_where('class',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all class
	 *
     */
    function get_all_class(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('class')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit class
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_class($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('class')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count class rows
	 *
     */
	function get_count_class(){
       $result = $this->db->from("class")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new class
	 *@param $params - data set to add record
	 *
     */
    function add_class($params){
        $this->db->insert('class',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update class
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_class($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('class',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete class
	 *@param $id - primary key to delete record
	 *
     */
    function delete_class($id){
        $status = $this->db->delete('class',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
