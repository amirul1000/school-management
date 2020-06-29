<?php

/**
 * Author: Amirul Momenin
 * Desc:Attendence Model
 */
class Attendence_model extends CI_Model
{
	protected $attendence = 'attendence';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get attendence by id
	 *@param $id - primary key to get record
	 *
     */
    function get_attendence($id){
        $result = $this->db->get_where('attendence',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all attendence
	 *
     */
    function get_all_attendence(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('attendence')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit attendence
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_attendence($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('attendence')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count attendence rows
	 *
     */
	function get_count_attendence(){
       $result = $this->db->from("attendence")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new attendence
	 *@param $params - data set to add record
	 *
     */
    function add_attendence($params){
        $this->db->insert('attendence',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update attendence
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_attendence($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('attendence',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete attendence
	 *@param $id - primary key to delete record
	 *
     */
    function delete_attendence($id){
        $status = $this->db->delete('attendence',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
