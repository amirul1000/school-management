<?php

/**
 * Author: Amirul Momenin
 * Desc:Students Model
 */
class Students_model extends CI_Model
{
	protected $students = 'students';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get students by id
	 *@param $id - primary key to get record
	 *
     */
    function get_students($id){
        $result = $this->db->get_where('students',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all students
	 *
     */
    function get_all_students(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('students')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit students
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_students($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('students')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count students rows
	 *
     */
	function get_count_students(){
       $result = $this->db->from("students")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new students
	 *@param $params - data set to add record
	 *
     */
    function add_students($params){
        $this->db->insert('students',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update students
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_students($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('students',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete students
	 *@param $id - primary key to delete record
	 *
     */
    function delete_students($id){
        $status = $this->db->delete('students',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
