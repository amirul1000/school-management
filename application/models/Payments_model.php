<?php

/**
 * Author: Amirul Momenin
 * Desc:Payments Model
 */
class Payments_model extends CI_Model
{
	protected $payments = 'payments';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get payments by id
	 *@param $id - primary key to get record
	 *
     */
    function get_payments($id){
        $result = $this->db->get_where('payments',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all payments
	 *
     */
    function get_all_payments(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('payments')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit payments
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_payments($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('payments')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count payments rows
	 *
     */
	function get_count_payments(){
       $result = $this->db->from("payments")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new payments
	 *@param $params - data set to add record
	 *
     */
    function add_payments($params){
        $this->db->insert('payments',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update payments
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_payments($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('payments',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete payments
	 *@param $id - primary key to delete record
	 *
     */
    function delete_payments($id){
        $status = $this->db->delete('payments',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
