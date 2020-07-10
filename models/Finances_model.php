<?php

/**
 * Author: Amirul Momenin
 * Desc:Finances Model
 */
class Finances_model extends CI_Model
{
	protected $finances = 'finances';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get finances by id
	 *@param $id - primary key to get record
	 *
     */
    function get_finances($id){
        $result = $this->db->get_where('finances',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all finances
	 *
     */
    function get_all_finances(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('finances')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit finances
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_finances($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('finances')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count finances rows
	 *
     */
	function get_count_finances(){
       $result = $this->db->from("finances")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new finances
	 *@param $params - data set to add record
	 *
     */
    function add_finances($params){
        $this->db->insert('finances',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update finances
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_finances($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('finances',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete finances
	 *@param $id - primary key to delete record
	 *
     */
    function delete_finances($id){
        $status = $this->db->delete('finances',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
