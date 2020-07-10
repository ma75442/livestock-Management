<?php

 /**
 * Author: Amirul Momenin
 * Desc:Animal Controller
 *
 */
class Animal extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Animal_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of animal table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['animal'] = $this->Animal_model->get_limit_animal($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/animal/index');
		$config['total_rows'] = $this->Animal_model->get_count_animal();
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
		
        $data['_view'] = 'admin/animal/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save animal
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'users_id' => html_escape($this->input->post('users_id')),
'name' => html_escape($this->input->post('name')),
'short_desc' => html_escape($this->input->post('short_desc')),
'long_desc' => html_escape($this->input->post('long_desc')),
'ear_tag' => html_escape($this->input->post('ear_tag')),
'reg' => html_escape($this->input->post('reg')),
'birth_date' => html_escape($this->input->post('birth_date')),
'sex' => html_escape($this->input->post('sex')),
'breed' => html_escape($this->input->post('breed')),
'blood_line' => html_escape($this->input->post('blood_line')),
'color' => html_escape($this->input->post('color')),
'weight' => html_escape($this->input->post('weight')),
'weight_type' => html_escape($this->input->post('weight_type')),
'birth_weight' => html_escape($this->input->post('birth_weight')),
'birth_weight_type' => html_escape($this->input->post('birth_weight_type')),
'horn_status' => html_escape($this->input->post('horn_status')),
'fathers' => html_escape($this->input->post('fathers')),
'father_other' => html_escape($this->input->post('father_other')),
'mothers' => html_escape($this->input->post('mothers')),
'mother_other' => html_escape($this->input->post('mother_other')),
'breeder' => html_escape($this->input->post('breeder')),
'owner' => html_escape($this->input->post('owner')),
'herd' => html_escape($this->input->post('herd')),
'tracking_device' => html_escape($this->input->post('tracking_device')),
'how_acquired' => html_escape($this->input->post('how_acquired')),
'how_acquired_date' => html_escape($this->input->post('how_acquired_date')),
'how_disposed' => html_escape($this->input->post('how_disposed')),
'how_disposed_date' => html_escape($this->input->post('how_disposed_date')),
'deactive' => html_escape($this->input->post('deactive')),
'deactive_reason' => html_escape($this->input->post('deactive_reason')),
'type_id' => html_escape($this->input->post('type_id')),
'subtypes' => html_escape($this->input->post('subtypes')),
'comments' => html_escape($this->input->post('comments')),
'created' => html_escape($this->input->post('created')),
'modified' => html_escape($this->input->post('modified')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['animal'] = $this->Animal_model->get_animal($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Animal_model->update_animal($id,$params);
                redirect('admin/animal/index');
            }else{
                $data['_view'] = 'admin/animal/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $animal_id = $this->Animal_model->add_animal($params);
                redirect('admin/animal/index');
            }else{  
			    $data['animal'] = $this->Animal_model->get_animal(0);
                $data['_view'] = 'admin/animal/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details animal
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['animal'] = $this->Animal_model->get_animal($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/animal/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting animal
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $animal = $this->Animal_model->get_animal($id);

        // check if the animal exists before trying to delete it
        if(isset($animal['id'])){
            $this->Animal_model->delete_animal($id);
            redirect('admin/animal/index');
        }
        else
            show_error('The animal you are trying to delete does not exist.');
    }
	
	/**
     * Search animal
	 * @param $start - Starting of animal table's index to get query
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
$this->db->or_like('short_desc', $key, 'both');
$this->db->or_like('long_desc', $key, 'both');
$this->db->or_like('ear_tag', $key, 'both');
$this->db->or_like('reg', $key, 'both');
$this->db->or_like('birth_date', $key, 'both');
$this->db->or_like('sex', $key, 'both');
$this->db->or_like('breed', $key, 'both');
$this->db->or_like('blood_line', $key, 'both');
$this->db->or_like('color', $key, 'both');
$this->db->or_like('weight', $key, 'both');
$this->db->or_like('weight_type', $key, 'both');
$this->db->or_like('birth_weight', $key, 'both');
$this->db->or_like('birth_weight_type', $key, 'both');
$this->db->or_like('horn_status', $key, 'both');
$this->db->or_like('fathers', $key, 'both');
$this->db->or_like('father_other', $key, 'both');
$this->db->or_like('mothers', $key, 'both');
$this->db->or_like('mother_other', $key, 'both');
$this->db->or_like('breeder', $key, 'both');
$this->db->or_like('owner', $key, 'both');
$this->db->or_like('herd', $key, 'both');
$this->db->or_like('tracking_device', $key, 'both');
$this->db->or_like('how_acquired', $key, 'both');
$this->db->or_like('how_acquired_date', $key, 'both');
$this->db->or_like('how_disposed', $key, 'both');
$this->db->or_like('how_disposed_date', $key, 'both');
$this->db->or_like('deactive', $key, 'both');
$this->db->or_like('deactive_reason', $key, 'both');
$this->db->or_like('type_id', $key, 'both');
$this->db->or_like('subtypes', $key, 'both');
$this->db->or_like('comments', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['animal'] = $this->db->get('animal')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/animal/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('short_desc', $key, 'both');
$this->db->or_like('long_desc', $key, 'both');
$this->db->or_like('ear_tag', $key, 'both');
$this->db->or_like('reg', $key, 'both');
$this->db->or_like('birth_date', $key, 'both');
$this->db->or_like('sex', $key, 'both');
$this->db->or_like('breed', $key, 'both');
$this->db->or_like('blood_line', $key, 'both');
$this->db->or_like('color', $key, 'both');
$this->db->or_like('weight', $key, 'both');
$this->db->or_like('weight_type', $key, 'both');
$this->db->or_like('birth_weight', $key, 'both');
$this->db->or_like('birth_weight_type', $key, 'both');
$this->db->or_like('horn_status', $key, 'both');
$this->db->or_like('fathers', $key, 'both');
$this->db->or_like('father_other', $key, 'both');
$this->db->or_like('mothers', $key, 'both');
$this->db->or_like('mother_other', $key, 'both');
$this->db->or_like('breeder', $key, 'both');
$this->db->or_like('owner', $key, 'both');
$this->db->or_like('herd', $key, 'both');
$this->db->or_like('tracking_device', $key, 'both');
$this->db->or_like('how_acquired', $key, 'both');
$this->db->or_like('how_acquired_date', $key, 'both');
$this->db->or_like('how_disposed', $key, 'both');
$this->db->or_like('how_disposed_date', $key, 'both');
$this->db->or_like('deactive', $key, 'both');
$this->db->or_like('deactive_reason', $key, 'both');
$this->db->or_like('type_id', $key, 'both');
$this->db->or_like('subtypes', $key, 'both');
$this->db->or_like('comments', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');

		$config['total_rows'] = $this->db->from("animal")->count_all_results();
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
		$data['_view'] = 'admin/animal/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export animal
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'animal_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $animalData = $this->Animal_model->get_all_animal();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Id","Name","Short Desc","Long Desc","Ear Tag","Reg","Birth Date","Sex","Breed","Blood Line","Color","Weight","Weight Type","Birth Weight","Birth Weight Type","Horn Status","Fathers","Father Other","Mothers","Mother Other","Breeder","Owner","Herd","Tracking Device","How Acquired","How Acquired Date","How Disposed","How Disposed Date","Deactive","Deactive Reason","Type Id","Subtypes","Comments","Created","Modified"); 
		   fputcsv($file, $header);
		   foreach ($animalData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $animal = $this->db->get('animal')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/animal/print_template.php');
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
//End of Animal controller