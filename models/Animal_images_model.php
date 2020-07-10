<?php

/**
 * Author: Amirul Momenin
 * Desc:Animal_images Model
 */
class Animal_images_model extends CI_Model
{
	protected $animal_images = 'animal_images';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get animal_images by id
	 *@param $id - primary key to get record
	 *
     */
    function get_animal_images($id){
        $result = $this->db->get_where('animal_images',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all animal_images
	 *
     */
    function get_all_animal_images(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('animal_images')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit animal_images
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_animal_images($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('animal_images')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count animal_images rows
	 *
     */
	function get_count_animal_images(){
       $result = $this->db->from("animal_images")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new animal_images
	 *@param $params - data set to add record
	 *
     */
    function add_animal_images($params){
        $this->db->insert('animal_images',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update animal_images
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_animal_images($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('animal_images',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete animal_images
	 *@param $id - primary key to delete record
	 *
     */
    function delete_animal_images($id){
        $status = $this->db->delete('animal_images',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
