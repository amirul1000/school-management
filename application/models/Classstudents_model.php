<?php

/**
 * Author: Amirul Momenin
 * Desc:Classstudents Model
 */
class Classstudents_model extends CI_Model
{
	protected $classstudents = 'classstudents';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get classstudents by id
	 *@param $id - primary key to get record
	 *
     */
    function get_classstudents($id){
        $result = $this->db->get_where('classstudents',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all classstudents
	 *
     */
    function get_all_classstudents(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('classstudents')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit classstudents
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_classstudents($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('classstudents')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count classstudents rows
	 *
     */
	function get_count_classstudents(){
       $result = $this->db->from("classstudents")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new classstudents
	 *@param $params - data set to add record
	 *
     */
    function add_classstudents($params){
        $this->db->insert('classstudents',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update classstudents
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_classstudents($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('classstudents',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete classstudents
	 *@param $id - primary key to delete record
	 *
     */
    function delete_classstudents($id){
        $status = $this->db->delete('classstudents',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
