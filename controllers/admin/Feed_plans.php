<?php

 /**
 * Author: Amirul Momenin
 * Desc:Feed_plans Controller
 *
 */
class Feed_plans extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Feed_plans_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of feed_plans table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['feed_plans'] = $this->Feed_plans_model->get_limit_feed_plans($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/feed_plans/index');
		$config['total_rows'] = $this->Feed_plans_model->get_count_feed_plans();
		$config['per_page'] = 10;
		//Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';		
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
        $data['_view'] = 'admin/feed_plans/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save feed_plans
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'users_id' => html_escape($this->input->post('users_id')),
'name' => html_escape($this->input->post('name')),
'from_date' => html_escape($this->input->post('from_date')),
'to_date' => html_escape($this->input->post('to_date')),
'cost' => html_escape($this->input->post('cost')),
'animal_count' => html_escape($this->input->post('animal_count')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['feed_plans'] = $this->Feed_plans_model->get_feed_plans($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Feed_plans_model->update_feed_plans($id,$params);
                redirect('admin/feed_plans/index');
            }else{
                $data['_view'] = 'admin/feed_plans/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $feed_plans_id = $this->Feed_plans_model->add_feed_plans($params);
                redirect('admin/feed_plans/index');
            }else{  
			    $data['feed_plans'] = $this->Feed_plans_model->get_feed_plans(0);
                $data['_view'] = 'admin/feed_plans/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details feed_plans
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['feed_plans'] = $this->Feed_plans_model->get_feed_plans($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/feed_plans/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting feed_plans
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $feed_plans = $this->Feed_plans_model->get_feed_plans($id);

        // check if the feed_plans exists before trying to delete it
        if(isset($feed_plans['id'])){
            $this->Feed_plans_model->delete_feed_plans($id);
            redirect('admin/feed_plans/index');
        }
        else
            show_error('The feed_plans you are trying to delete does not exist.');
    }
	
	/**
     * Search feed_plans
	 * @param $start - Starting of feed_plans table's index to get query
     */
	function search($start=0){
		if(!empty($this->input->post('key'))){
			$key =$this->input->post('key');
			$_SESSION['key'] = $key;
		}else{
			$key = $_SESSION['key'];
		}
		
		$limit = 10;		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('from_date', $key, 'both');
$this->db->or_like('to_date', $key, 'both');
$this->db->or_like('cost', $key, 'both');
$this->db->or_like('animal_count', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['feed_plans'] = $this->db->get('feed_plans')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/feed_plans/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('from_date', $key, 'both');
$this->db->or_like('to_date', $key, 'both');
$this->db->or_like('cost', $key, 'both');
$this->db->or_like('animal_count', $key, 'both');

		$config['total_rows'] = $this->db->from("feed_plans")->count_all_results();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		$config['per_page'] = 10;
		// Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
		$data['key'] = $key;
		$data['_view'] = 'admin/feed_plans/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export feed_plans
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'feed_plans_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $feed_plansData = $this->Feed_plans_model->get_all_feed_plans();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Id","Name","From Date","To Date","Cost","Animal Count"); 
		   fputcsv($file, $header);
		   foreach ($feed_plansData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $feed_plans = $this->db->get('feed_plans')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/feed_plans/print_template.php');
			$html = ob_get_clean();
			include(APPPATH."third_party/mpdf60/mpdf.php");					
			$mpdf=new mPDF('','A4'); 
			//$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
			//$mpdf->mirrorMargins = true;
		    $mpdf->SetDisplayMode('fullpage');
			//==============================================================
			$mpdf->autoScriptToLang = true;
			$mpdf->baseScript = 1;	// Use values in classes/ucdn.php  1 = LATIN
			$mpdf->autoVietnamese = true;
			$mpdf->autoArabic = true;
			$mpdf->autoLangToFont = true;
			$mpdf->setAutoBottomMargin = 'stretch';
			$stylesheet = file_get_contents(APPPATH."third_party/mpdf60/lang2fonts.css");
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->WriteHTML($html);
			//$mpdf->AddPage();
			$mpdf->Output($filePath);
			$mpdf->Output();
			//$mpdf->Output( $filePath,'S');
			exit;	
	  }
	   
	}
}
//End of Feed_plans controller