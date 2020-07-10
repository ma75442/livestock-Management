<?php

/**
 * Author: Amirul Momenin
 * Desc:Phinxlog Model
 */
class Phinxlog_model extends CI_Model
{
	protected $phinxlog = 'phinxlog';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get phinxlog by id
	 *@param $id - primary key to get record
	 *
     */
    function get_phinxlog($id){
        $result = $this->db->get_where('phinxlog',array('id'=>$id))->row_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all phinxlog
	 *
     */
    function get_all_phinxlog(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('phinxlog')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit phinxlog
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_phinxlog($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('phinxlog')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count phinxlog rows
	 *
     */
	function get_count_phinxlog(){
       $result = $this->db->from("phinxlog")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new phinxlog
	 *@param $params - data set to add record
	 *
     */
    function add_phinxlog($params){
        $this->db->insert('phinxlog',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update phinxlog
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_phinxlog($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('phinxlog',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete phinxlog
	 *@param $id - primary key to delete record
	 *
     */
    function delete_phinxlog($id){
        $status = $this->db->delete('phinxlog',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
