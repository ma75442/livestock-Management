<?php

/**
 * Author: Amirul Momenin
 * Desc:Animals Model
 */
class Animals_model extends CI_Model
{
	protected $animals = 'animals';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get animals by id
	 *@param $id - primary key to get record
	 *
     */
    function get_animals($id){
        $result = $this->db->get_where('animals',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all animals
	 *
     */
    function get_all_animals(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('animals')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit animals
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_animals($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('animals')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count animals rows
	 *
     */
	function get_count_animals(){
       $result = $this->db->from("animals")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new animals
	 *@param $params - data set to add record
	 *
     */
    function add_animals($params){
        $this->db->insert('animals',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update animals
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_animals($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('animals',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete animals
	 *@param $id - primary key to delete record
	 *
     */
    function delete_animals($id){
        $status = $this->db->delete('animals',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
