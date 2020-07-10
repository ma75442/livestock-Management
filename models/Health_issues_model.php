<?php

/**
 * Author: Amirul Momenin
 * Desc:Health_issues Model
 */
class Health_issues_model extends CI_Model
{
	protected $health_issues = 'health_issues';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get health_issues by id
	 *@param $id - primary key to get record
	 *
     */
    function get_health_issues($id){
        $result = $this->db->get_where('health_issues',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all health_issues
	 *
     */
    function get_all_health_issues(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('health_issues')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit health_issues
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_health_issues($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('health_issues')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count health_issues rows
	 *
     */
	function get_count_health_issues(){
       $result = $this->db->from("health_issues")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new health_issues
	 *@param $params - data set to add record
	 *
     */
    function add_health_issues($params){
        $this->db->insert('health_issues',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update health_issues
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_health_issues($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('health_issues',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete health_issues
	 *@param $id - primary key to delete record
	 *
     */
    function delete_health_issues($id){
        $status = $this->db->delete('health_issues',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
