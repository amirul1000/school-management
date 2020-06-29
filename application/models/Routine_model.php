<?php

/**
 * Author: Amirul Momenin
 * Desc:Routine Model
 */
class Routine_model extends CI_Model
{
	protected $routine = 'routine';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get routine by id
	 *@param $id - primary key to get record
	 *
     */
    function get_routine($id){
        $result = $this->db->get_where('routine',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all routine
	 *
     */
    function get_all_routine(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('routine')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit routine
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_routine($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('routine')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count routine rows
	 *
     */
	function get_count_routine(){
       $result = $this->db->from("routine")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new routine
	 *@param $params - data set to add record
	 *
     */
    function add_routine($params){
        $this->db->insert('routine',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update routine
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_routine($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('routine',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete routine
	 *@param $id - primary key to delete record
	 *
     */
    function delete_routine($id){
        $status = $this->db->delete('routine',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
