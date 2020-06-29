<?php

/**
 * Author: Amirul Momenin
 * Desc:Class_info Model
 */
class Class_info_model extends CI_Model
{
	protected $class_info = 'class_info';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get class_info by id
	 *@param $id - primary key to get record
	 *
     */
    function get_class_info($id){
        $result = $this->db->get_where('class_info',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all class_info
	 *
     */
    function get_all_class_info(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('class_info')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit class_info
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_class_info($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('class_info')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count class_info rows
	 *
     */
	function get_count_class_info(){
       $result = $this->db->from("class_info")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new class_info
	 *@param $params - data set to add record
	 *
     */
    function add_class_info($params){
        $this->db->insert('class_info',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update class_info
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_class_info($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('class_info',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete class_info
	 *@param $id - primary key to delete record
	 *
     */
    function delete_class_info($id){
        $status = $this->db->delete('class_info',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
