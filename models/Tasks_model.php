<?php

/**
 * Author: Amirul Momenin
 * Desc:Tasks Model
 */
class Tasks_model extends CI_Model
{
	protected $tasks = 'tasks';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get tasks by id
	 *@param $id - primary key to get record
	 *
     */
    function get_tasks($id){
        $result = $this->db->get_where('tasks',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all tasks
	 *
     */
    function get_all_tasks(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('tasks')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit tasks
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_tasks($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('tasks')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count tasks rows
	 *
     */
	function get_count_tasks(){
       $result = $this->db->from("tasks")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new tasks
	 *@param $params - data set to add record
	 *
     */
    function add_tasks($params){
        $this->db->insert('tasks',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update tasks
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_tasks($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('tasks',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete tasks
	 *@param $id - primary key to delete record
	 *
     */
    function delete_tasks($id){
        $status = $this->db->delete('tasks',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
