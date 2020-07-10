<?php

/**
 * Author: Amirul Momenin
 * Desc:Feeds Model
 */
class Feeds_model extends CI_Model
{
	protected $feeds = 'feeds';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get feeds by id
	 *@param $id - primary key to get record
	 *
     */
    function get_feeds($id){
        $result = $this->db->get_where('feeds',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all feeds
	 *
     */
    function get_all_feeds(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('feeds')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit feeds
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_feeds($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('feeds')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count feeds rows
	 *
     */
	function get_count_feeds(){
       $result = $this->db->from("feeds")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new feeds
	 *@param $params - data set to add record
	 *
     */
    function add_feeds($params){
        $this->db->insert('feeds',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update feeds
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_feeds($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('feeds',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete feeds
	 *@param $id - primary key to delete record
	 *
     */
    function delete_feeds($id){
        $status = $this->db->delete('feeds',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
