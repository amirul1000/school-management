<?php

/**
 * Author: Amirul Momenin
 * Desc:Subjects Model
 */
class Subjects_model extends CI_Model
{
	protected $subjects = 'subjects';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get subjects by id
	 *@param $id - primary key to get record
	 *
     */
    function get_subjects($id){
        $result = $this->db->get_where('subjects',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all subjects
	 *
     */
    function get_all_subjects(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('subjects')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit subjects
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_subjects($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('subjects')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count subjects rows
	 *
     */
	function get_count_subjects(){
       $result = $this->db->from("subjects")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new subjects
	 *@param $params - data set to add record
	 *
     */
    function add_subjects($params){
        $this->db->insert('subjects',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update subjects
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_subjects($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('subjects',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete subjects
	 *@param $id - primary key to delete record
	 *
     */
    function delete_subjects($id){
        $status = $this->db->delete('subjects',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
