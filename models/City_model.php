<?php

/**
 * Author: Amirul Momenin
 * Desc:City Model
 */
class City_model extends CI_Model
{
	protected $city = 'city';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get city by id
	 *@param $id - primary key to get record
	 *
     */
    function get_city($id){
        $result = $this->db->get_where('city',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all city
	 *
     */
    function get_all_city(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('city')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit city
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_city($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('city')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count city rows
	 *
     */
	function get_count_city(){
       $result = $this->db->from("city")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new city
	 *@param $params - data set to add record
	 *
     */
    function add_city($params){
        $this->db->insert('city',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update city
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_city($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('city',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete city
	 *@param $id - primary key to delete record
	 *
     */
    function delete_city($id){
        $status = $this->db->delete('city',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
