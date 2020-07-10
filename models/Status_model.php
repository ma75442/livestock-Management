<?php

/**
 * Author: Amirul Momenin
 * Desc:Status Model
 */
class Status_model extends CI_Model
{
	protected $status = 'status';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get status by id
	 *@param $id - primary key to get record
	 *
     */
    function get_status($id){
        $result = $this->db->get_where('status',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all status
	 *
     */
    function get_all_status(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('status')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit status
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_status($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('status')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count status rows
	 *
     */
	function get_count_status(){
       $result = $this->db->from("status")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new status
	 *@param $params - data set to add record
	 *
     */
    function add_status($params){
        $this->db->insert('status',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update status
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_status($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('status',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete status
	 *@param $id - primary key to delete record
	 *
     */
    function delete_status($id){
        $status = $this->db->delete('status',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
