<?php

 /**
 * Author: Amirul Momenin
 * Desc:Finances Controller
 *
 */
class Finances extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Finances_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of finances table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['finances'] = $this->Finances_model->get_limit_finances($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/finances/index');
		$config['total_rows'] = $this->Finances_model->get_count_finances();
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
		
        $data['_view'] = 'admin/finances/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save finances
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'users_id' => html_escape($this->input->post('users_id')),
'date' => html_escape($this->input->post('date')),
'type' => html_escape($this->input->post('type')),
'amount' => html_escape($this->input->post('amount')),
'comments' => html_escape($this->input->post('comments')),
'credit_debit' => html_escape($this->input->post('credit_debit')),
'created' => html_escape($this->input->post('created')),
'modified' => html_escape($this->input->post('modified')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['finances'] = $this->Finances_model->get_finances($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Finances_model->update_finances($id,$params);
                redirect('admin/finances/index');
            }else{
                $data['_view'] = 'admin/finances/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $finances_id = $this->Finances_model->add_finances($params);
                redirect('admin/finances/index');
            }else{  
			    $data['finances'] = $this->Finances_model->get_finances(0);
                $data['_view'] = 'admin/finances/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details finances
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['finances'] = $this->Finances_model->get_finances($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/finances/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting finances
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $finances = $this->Finances_model->get_finances($id);

        // check if the finances exists before trying to delete it
        if(isset($finances['id'])){
            $this->Finances_model->delete_finances($id);
            redirect('admin/finances/index');
        }
        else
            show_error('The finances you are trying to delete does not exist.');
    }
	
	/**
     * Search finances
	 * @param $start - Starting of finances table's index to get query
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
$this->db->or_like('date', $key, 'both');
$this->db->or_like('type', $key, 'both');
$this->db->or_like('amount', $key, 'both');
$this->db->or_like('comments', $key, 'both');
$this->db->or_like('credit_debit', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['finances'] = $this->db->get('finances')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/finances/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('date', $key, 'both');
$this->db->or_like('type', $key, 'both');
$this->db->or_like('amount', $key, 'both');
$this->db->or_like('comments', $key, 'both');
$this->db->or_like('credit_debit', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');

		$config['total_rows'] = $this->db->from("finances")->count_all_results();
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
		$data['_view'] = 'admin/finances/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export finances
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'finances_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $financesData = $this->Finances_model->get_all_finances();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Id","Date","Type","Amount","Comments","Credit Debit","Created","Modified"); 
		   fputcsv($file, $header);
		   foreach ($financesData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $finances = $this->db->get('finances')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/finances/print_template.php');
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
//End of Finances controller