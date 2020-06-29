<?php

/**
 * Author: Amirul Momenin
 * Desc:Year_semester Model
 */
class Year_semester_model extends CI_Model
{
	protected $year_semester = 'year_semester';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get year_semester by id
	 *@param $id - primary key to get record
	 *
     */
    function get_year_semester($id){
        $result = $this->db->get_where('year_semester',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all year_semester
	 *
     */
    function get_all_year_semester(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('year_semester')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit year_semester
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_year_semester($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('year_semester')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count year_semester rows
	 *
     */
	function get_count_year_semester(){
       $result = $this->db->from("year_semester")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new year_semester
	 *@param $params - data set to add record
	 *
     */
    function add_year_semester($params){
        $this->db->insert('year_semester',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update year_semester
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_year_semester($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('year_semester',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete year_semester
	 *@param $id - primary key to delete record
	 *
     */
    function delete_year_semester($id){
        $status = $this->db->delete('year_semester',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
