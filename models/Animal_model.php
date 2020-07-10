<?php

/**
 * Author: Amirul Momenin
 * Desc:Animal Model
 */
class Animal_model extends CI_Model
{
	protected $animal = 'animal';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get animal by id
	 *@param $id - primary key to get record
	 *
     */
    function get_animal($id){
        $result = $this->db->get_where('animal',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all animal
	 *
     */
    function get_all_animal(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('animal')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit animal
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_animal($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('animal')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count animal rows
	 *
     */
	function get_count_animal(){
       $result = $this->db->from("animal")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new animal
	 *@param $params - data set to add record
	 *
     */
    function add_animal($params){
        $this->db->insert('animal',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update animal
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_animal($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('animal',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete animal
	 *@param $id - primary key to delete record
	 *
     */
    function delete_animal($id){
        $status = $this->db->delete('animal',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
