<?php

 /**
 * Author: Amirul Momenin
 * Desc:Animals_images Controller
 *
 */
class Animals_images extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Animals_images_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of animals_images table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['animals_images'] = $this->Animals_images_model->get_limit_animals_images($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/animals_images/index');
		$config['total_rows'] = $this->Animals_images_model->get_count_animals_images();
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
		
        $data['_view'] = 'admin/animals_images/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save animals_images
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		$file_id = "";
 
		
		
		$params = array(
					 'animal_id' => html_escape($this->input->post('animal_id')),
'name' => html_escape($this->input->post('name')),
'file_id' => $file_id,
'created' => html_escape($this->input->post('created')),
'modified' => html_escape($this->input->post('modified')),

				);
		<file_upload> 
		<careated_at_updated_at> 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['animals_images'] = $this->Animals_images_model->get_animals_images($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Animals_images_model->update_animals_images($id,$params);
                redirect('admin/animals_images/index');
            }else{
                $data['_view'] = 'admin/animals_images/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $animals_images_id = $this->Animals_images_model->add_animals_images($params);
                redirect('admin/animals_images/index');
            }else{  
			    $data['animals_images'] = $this->Animals_images_model->get_animals_images(0);
                $data['_view'] = 'admin/animals_images/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details animals_images
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['animals_images'] = $this->Animals_images_model->get_animals_images($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/animals_images/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting animals_images
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $animals_images = $this->Animals_images_model->get_animals_images($id);

        // check if the animals_images exists before trying to delete it
        if(isset($animals_images['id'])){
            $this->Animals_images_model->delete_animals_images($id);
            redirect('admin/animals_images/index');
        }
        else
            show_error('The animals_images you are trying to delete does not exist.');
    }
	
	/**
     * Search animals_images
	 * @param $start - Starting of animals_images table's index to get query
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
$this->db->or_like('name', $key, 'both');
$this->db->or_like('file_id', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['animals_images'] = $this->db->get('animals_images')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/animals_images/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('animal_id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('file_id', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');

		$config['total_rows'] = $this->db->from("animals_images")->count_all_results();
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
		$data['_view'] = 'admin/animals_images/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export animals_images
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'animals_images_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $animals_imagesData = $this->Animals_images_model->get_all_animals_images();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Animal Id","Name","File Id","Created","Modified"); 
		   fputcsv($file, $header);
		   foreach ($animals_imagesData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $animals_images = $this->db->get('animals_images')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/animals_images/print_template.php');
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
//End of Animals_images controller