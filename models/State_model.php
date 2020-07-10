<?php

/**
 * Author: Amirul Momenin
 * Desc:State Model
 */
class State_model extends CI_Model
{
	protected $state = 'state';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get state by id
	 *@param $id - primary key to get record
	 *
     */
    function get_state($id){
        $result = $this->db->get_where('state',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all state
	 *
     */
    function get_all_state(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('state')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit state
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_state($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('state')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count state rows
	 *
     */
	function get_count_state(){
       $result = $this->db->from("state")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new state
	 *@param $params - data set to add record
	 *
     */
    function add_state($params){
        $this->db->insert('state',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update state
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_state($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('state',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete state
	 *@param $id - primary key to delete record
	 *
     */
    function delete_state($id){
        $status = $this->db->delete('state',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
