<?php

 /**
 * Author: Amirul Momenin
 * Desc:Animal_weights Controller
 *
 */
class Animal_weights extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Animal_weights_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of animal_weights table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['animal_weights'] = $this->Animal_weights_model->get_limit_animal_weights($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/animal_weights/index');
		$config['total_rows'] = $this->Animal_weights_model->get_count_animal_weights();
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
		
        $data['_view'] = 'admin/animal_weights/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save animal_weights
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'animal_id' => html_escape($this->input->post('animal_id')),
'weight_date' => html_escape($this->input->post('weight_date')),
'value' => html_escape($this->input->post('value')),
'value_type' => html_escape($this->input->post('value_type')),
'comments' => html_escape($this->input->post('comments')),
'created' => html_escape($this->input->post('created')),
'modified' => html_escape($this->input->post('modified')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['animal_weights'] = $this->Animal_weights_model->get_animal_weights($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Animal_weights_model->update_animal_weights($id,$params);
                redirect('admin/animal_weights/index');
            }else{
                $data['_view'] = 'admin/animal_weights/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $animal_weights_id = $this->Animal_weights_model->add_animal_weights($params);
                redirect('admin/animal_weights/index');
            }else{  
			    $data['animal_weights'] = $this->Animal_weights_model->get_animal_weights(0);
                $data['_view'] = 'admin/animal_weights/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details animal_weights
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['animal_weights'] = $this->Animal_weights_model->get_animal_weights($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/animal_weights/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting animal_weights
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $animal_weights = $this->Animal_weights_model->get_animal_weights($id);

        // check if the animal_weights exists before trying to delete it
        if(isset($animal_weights['id'])){
            $this->Animal_weights_model->delete_animal_weights($id);
            redirect('admin/animal_weights/index');
        }
        else
            show_error('The animal_weights you are trying to delete does not exist.');
    }
	
	/**
     * Search animal_weights
	 * @param $start - Starting of animal_weights table's index to get query
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
$this->db->or_like('weight_date', $key, 'both');
$this->db->or_like('value', $key, 'both');
$this->db->or_like('value_type', $key, 'both');
$this->db->or_like('comments', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['animal_weights'] = $this->db->get('animal_weights')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/animal_weights/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('animal_id', $key, 'both');
$this->db->or_like('weight_date', $key, 'both');
$this->db->or_like('value', $key, 'both');
$this->db->or_like('value_type', $key, 'both');
$this->db->or_like('comments', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');

		$config['total_rows'] = $this->db->from("animal_weights")->count_all_results();
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
		$data['_view'] = 'admin/animal_weights/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export animal_weights
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'animal_weights_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $animal_weightsData = $this->Animal_weights_model->get_all_animal_weights();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Animal Id","Weight Date","Value","Value Type","Comments","Created","Modified"); 
		   fputcsv($file, $header);
		   foreach ($animal_weightsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $animal_weights = $this->db->get('animal_weights')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/animal_weights/print_template.php');
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
//End of Animal_weights controller