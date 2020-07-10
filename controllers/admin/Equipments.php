<?php

 /**
 * Author: Amirul Momenin
 * Desc:Equipments Controller
 *
 */
class Equipments extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Equipments_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of equipments table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['equipments'] = $this->Equipments_model->get_limit_equipments($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/equipments/index');
		$config['total_rows'] = $this->Equipments_model->get_count_equipments();
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
		
        $data['_view'] = 'admin/equipments/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save equipments
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'name' => html_escape($this->input->post('name')),
'short_desc' => html_escape($this->input->post('short_desc')),
'long_desc' => html_escape($this->input->post('long_desc')),
'users_id' => html_escape($this->input->post('users_id')),
'created' => html_escape($this->input->post('created')),
'modified' => html_escape($this->input->post('modified')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['equipments'] = $this->Equipments_model->get_equipments($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Equipments_model->update_equipments($id,$params);
                redirect('admin/equipments/index');
            }else{
                $data['_view'] = 'admin/equipments/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $equipments_id = $this->Equipments_model->add_equipments($params);
                redirect('admin/equipments/index');
            }else{  
			    $data['equipments'] = $this->Equipments_model->get_equipments(0);
                $data['_view'] = 'admin/equipments/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details equipments
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['equipments'] = $this->Equipments_model->get_equipments($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/equipments/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting equipments
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $equipments = $this->Equipments_model->get_equipments($id);

        // check if the equipments exists before trying to delete it
        if(isset($equipments['id'])){
            $this->Equipments_model->delete_equipments($id);
            redirect('admin/equipments/index');
        }
        else
            show_error('The equipments you are trying to delete does not exist.');
    }
	
	/**
     * Search equipments
	 * @param $start - Starting of equipments table's index to get query
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
$this->db->or_like('name', $key, 'both');
$this->db->or_like('short_desc', $key, 'both');
$this->db->or_like('long_desc', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['equipments'] = $this->db->get('equipments')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/equipments/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('short_desc', $key, 'both');
$this->db->or_like('long_desc', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');

		$config['total_rows'] = $this->db->from("equipments")->count_all_results();
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
		$data['_view'] = 'admin/equipments/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export equipments
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'equipments_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $equipmentsData = $this->Equipments_model->get_all_equipments();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Name","Short Desc","Long Desc","Users Id","Created","Modified"); 
		   fputcsv($file, $header);
		   foreach ($equipmentsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $equipments = $this->db->get('equipments')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/equipments/print_template.php');
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
//End of Equipments controller