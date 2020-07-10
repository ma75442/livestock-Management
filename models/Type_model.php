<?php

/**
 * Author: Amirul Momenin
 * Desc:Type Model
 */
class Type_model extends CI_Model
{
	protected $type = 'type';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get type by id
	 *@param $id - primary key to get record
	 *
     */
    function get_type($id){
        $result = $this->db->get_where('type',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all type
	 *
     */
    function get_all_type(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('type')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit type
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_type($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('type')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count type rows
	 *
     */
	function get_count_type(){
       $result = $this->db->from("type")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new type
	 *@param $params - data set to add record
	 *
     */
    function add_type($params){
        $this->db->insert('type',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update type
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_type($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('type',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete type
	 *@param $id - primary key to delete record
	 *
     */
    function delete_type($id){
        $status = $this->db->delete('type',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
