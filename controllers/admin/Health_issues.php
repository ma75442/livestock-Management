<?php

 /**
 * Author: Amirul Momenin
 * Desc:Health_issues Controller
 *
 */
class Health_issues extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Health_issues_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of health_issues table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['health_issues'] = $this->Health_issues_model->get_limit_health_issues($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/health_issues/index');
		$config['total_rows'] = $this->Health_issues_model->get_count_health_issues();
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
		
        $data['_view'] = 'admin/health_issues/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save health_issues
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'animal_id' => html_escape($this->input->post('animal_id')),
'issue' => html_escape($this->input->post('issue')),
'treatment' => html_escape($this->input->post('treatment')),
'issue_date' => html_escape($this->input->post('issue_date')),
'status_id' => html_escape($this->input->post('status_id')),
'created' => html_escape($this->input->post('created')),
'modified' => html_escape($this->input->post('modified')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['health_issues'] = $this->Health_issues_model->get_health_issues($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Health_issues_model->update_health_issues($id,$params);
                redirect('admin/health_issues/index');
            }else{
                $data['_view'] = 'admin/health_issues/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $health_issues_id = $this->Health_issues_model->add_health_issues($params);
                redirect('admin/health_issues/index');
            }else{  
			    $data['health_issues'] = $this->Health_issues_model->get_health_issues(0);
                $data['_view'] = 'admin/health_issues/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details health_issues
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['health_issues'] = $this->Health_issues_model->get_health_issues($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/health_issues/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting health_issues
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $health_issues = $this->Health_issues_model->get_health_issues($id);

        // check if the health_issues exists before trying to delete it
        if(isset($health_issues['id'])){
            $this->Health_issues_model->delete_health_issues($id);
            redirect('admin/health_issues/index');
        }
        else
            show_error('The health_issues you are trying to delete does not exist.');
    }
	
	/**
     * Search health_issues
	 * @param $start - Starting of health_issues table's index to get query
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
$this->db->or_like('animal_id', $key, 'both');
$this->db->or_like('issue', $key, 'both');
$this->db->or_like('treatment', $key, 'both');
$this->db->or_like('issue_date', $key, 'both');
$this->db->or_like('status_id', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['health_issues'] = $this->db->get('health_issues')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/health_issues/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('animal_id', $key, 'both');
$this->db->or_like('issue', $key, 'both');
$this->db->or_like('treatment', $key, 'both');
$this->db->or_like('issue_date', $key, 'both');
$this->db->or_like('status_id', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');

		$config['total_rows'] = $this->db->from("health_issues")->count_all_results();
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
		$data['_view'] = 'admin/health_issues/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export health_issues
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'health_issues_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $health_issuesData = $this->Health_issues_model->get_all_health_issues();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Animal Id","Issue","Treatment","Issue Date","Status Id","Created","Modified"); 
		   fputcsv($file, $header);
		   foreach ($health_issuesData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $health_issues = $this->db->get('health_issues')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/health_issues/print_template.php');
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
//End of Health_issues controller