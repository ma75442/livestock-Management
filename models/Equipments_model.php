<?php

/**
 * Author: Amirul Momenin
 * Desc:Equipments Model
 */
class Equipments_model extends CI_Model
{
	protected $equipments = 'equipments';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get equipments by id
	 *@param $id - primary key to get record
	 *
     */
    function get_equipments($id){
        $result = $this->db->get_where('equipments',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all equipments
	 *
     */
    function get_all_equipments(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('equipments')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit equipments
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_equipments($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('equipments')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count equipments rows
	 *
     */
	function get_count_equipments(){
       $result = $this->db->from("equipments")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new equipments
	 *@param $params - data set to add record
	 *
     */
    function add_equipments($params){
        $this->db->insert('equipments',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update equipments
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_equipments($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('equipments',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete equipments
	 *@param $id - primary key to delete record
	 *
     */
    function delete_equipments($id){
        $status = $this->db->delete('equipments',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
