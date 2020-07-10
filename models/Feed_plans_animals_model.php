<?php

/**
 * Author: Amirul Momenin
 * Desc:Feed_plans_animals Model
 */
class Feed_plans_animals_model extends CI_Model
{
	protected $feed_plans_animals = 'feed_plans_animals';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get feed_plans_animals by id
	 *@param $id - primary key to get record
	 *
     */
    function get_feed_plans_animals($id){
        $result = $this->db->get_where('feed_plans_animals',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all feed_plans_animals
	 *
     */
    function get_all_feed_plans_animals(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('feed_plans_animals')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit feed_plans_animals
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_feed_plans_animals($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('feed_plans_animals')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count feed_plans_animals rows
	 *
     */
	function get_count_feed_plans_animals(){
       $result = $this->db->from("feed_plans_animals")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new feed_plans_animals
	 *@param $params - data set to add record
	 *
     */
    function add_feed_plans_animals($params){
        $this->db->insert('feed_plans_animals',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update feed_plans_animals
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_feed_plans_animals($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('feed_plans_animals',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete feed_plans_animals
	 *@param $id - primary key to delete record
	 *
     */
    function delete_feed_plans_animals($id){
        $status = $this->db->delete('feed_plans_animals',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
