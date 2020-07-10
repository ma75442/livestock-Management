<?php

/**
 * Author: Amirul Momenin
 * Desc:Addresses Model
 */
class Addresses_model extends CI_Model
{
	protected $addresses = 'addresses';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get addresses by id
	 *@param $id - primary key to get record
	 *
     */
    function get_addresses($id){
        $result = $this->db->get_where('addresses',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all addresses
	 *
     */
    function get_all_addresses(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('addresses')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit addresses
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_addresses($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('addresses')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count addresses rows
	 *
     */
	function get_count_addresses(){
       $result = $this->db->from("addresses")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new addresses
	 *@param $params - data set to add record
	 *
     */
    function add_addresses($params){
        $this->db->insert('addresses',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update addresses
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_addresses($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('addresses',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete addresses
	 *@param $id - primary key to delete record
	 *
     */
    function delete_addresses($id){
        $status = $this->db->delete('addresses',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
