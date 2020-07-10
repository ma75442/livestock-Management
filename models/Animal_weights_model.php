<?php

/**
 * Author: Amirul Momenin
 * Desc:Animal_weights Model
 */
class Animal_weights_model extends CI_Model
{
	protected $animal_weights = 'animal_weights';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get animal_weights by id
	 *@param $id - primary key to get record
	 *
     */
    function get_animal_weights($id){
        $result = $this->db->get_where('animal_weights',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all animal_weights
	 *
     */
    function get_all_animal_weights(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('animal_weights')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit animal_weights
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_animal_weights($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('animal_weights')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count animal_weights rows
	 *
     */
	function get_count_animal_weights(){
       $result = $this->db->from("animal_weights")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new animal_weights
	 *@param $params - data set to add record
	 *
     */
    function add_animal_weights($params){
        $this->db->insert('animal_weights',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update animal_weights
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_animal_weights($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('animal_weights',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete animal_weights
	 *@param $id - primary key to delete record
	 *
     */
    function delete_animal_weights($id){
        $status = $this->db->delete('animal_weights',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
