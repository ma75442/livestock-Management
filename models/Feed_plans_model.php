<?php

/**
 * Author: Amirul Momenin
 * Desc:Feed_plans Model
 */
class Feed_plans_model extends CI_Model
{
	protected $feed_plans = 'feed_plans';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get feed_plans by id
	 *@param $id - primary key to get record
	 *
     */
    function get_feed_plans($id){
        $result = $this->db->get_where('feed_plans',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all feed_plans
	 *
     */
    function get_all_feed_plans(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('feed_plans')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit feed_plans
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_feed_plans($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('feed_plans')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count feed_plans rows
	 *
     */
	function get_count_feed_plans(){
       $result = $this->db->from("feed_plans")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new feed_plans
	 *@param $params - data set to add record
	 *
     */
    function add_feed_plans($params){
        $this->db->insert('feed_plans',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update feed_plans
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_feed_plans($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('feed_plans',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete feed_plans
	 *@param $id - primary key to delete record
	 *
     */
    function delete_feed_plans($id){
        $status = $this->db->delete('feed_plans',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
