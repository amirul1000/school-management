<?php

/**
 * Author: Amirul Momenin
 * Desc:Teachers Model
 */
class Teachers_model extends CI_Model
{
	protected $teachers = 'teachers';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get teachers by id
	 *@param $id - primary key to get record
	 *
     */
    function get_teachers($id){
        $result = $this->db->get_where('teachers',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all teachers
	 *
     */
    function get_all_teachers(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('teachers')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit teachers
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_teachers($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('teachers')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count teachers rows
	 *
     */
	function get_count_teachers(){
       $result = $this->db->from("teachers")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new teachers
	 *@param $params - data set to add record
	 *
     */
    function add_teachers($params){
        $this->db->insert('teachers',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update teachers
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_teachers($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('teachers',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete teachers
	 *@param $id - primary key to delete record
	 *
     */
    function delete_teachers($id){
        $status = $this->db->delete('teachers',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
