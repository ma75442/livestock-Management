<?php

/**
 * Author: Amirul Momenin
 * Desc:Animals_images Model
 */
class Animals_images_model extends CI_Model
{
	protected $animals_images = 'animals_images';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get animals_images by id
	 *@param $id - primary key to get record
	 *
     */
    function get_animals_images($id){
        $result = $this->db->get_where('animals_images',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all animals_images
	 *
     */
    function get_all_animals_images(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('animals_images')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit animals_images
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_animals_images($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('animals_images')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count animals_images rows
	 *
     */
	function get_count_animals_images(){
       $result = $this->db->from("animals_images")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new animals_images
	 *@param $params - data set to add record
	 *
     */
    function add_animals_images($params){
        $this->db->insert('animals_images',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update animals_images
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_animals_images($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('animals_images',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete animals_images
	 *@param $id - primary key to delete record
	 *
     */
    function delete_animals_images($id){
        $status = $this->db->delete('animals_images',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
