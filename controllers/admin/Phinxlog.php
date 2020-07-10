<?php

 /**
 * Author: Amirul Momenin
 * Desc:Phinxlog Controller
 *
 */
class Phinxlog extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Phinxlog_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of phinxlog table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['phinxlog'] = $this->Phinxlog_model->get_limit_phinxlog($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/phinxlog/index');
		$config['total_rows'] = $this->Phinxlog_model->get_count_phinxlog();
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
		
        $data['_view'] = 'admin/phinxlog/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save phinxlog
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'version' => html_escape($this->input->post('version')),
'start_time' => html_escape($this->input->post('start_time')),
'end_time' => html_escape($this->input->post('end_time')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['phinxlog'] = $this->Phinxlog_model->get_phinxlog($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Phinxlog_model->update_phinxlog($id,$params);
                redirect('admin/phinxlog/index');
            }else{
                $data['_view'] = 'admin/phinxlog/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $phinxlog_id = $this->Phinxlog_model->add_phinxlog($params);
                redirect('admin/phinxlog/index');
            }else{  
			    $data['phinxlog'] = $this->Phinxlog_model->get_phinxlog(0);
                $data['_view'] = 'admin/phinxlog/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details phinxlog
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['phinxlog'] = $this->Phinxlog_model->get_phinxlog($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/phinxlog/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting phinxlog
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $phinxlog = $this->Phinxlog_model->get_phinxlog($id);

        // check if the phinxlog exists before trying to delete it
        if(isset($phinxlog['id'])){
            $this->Phinxlog_model->delete_phinxlog($id);
            redirect('admin/phinxlog/index');
        }
        else
            show_error('The phinxlog you are trying to delete does not exist.');
    }
	
	/**
     * Search phinxlog
	 * @param $start - Starting of phinxlog table's index to get query
     */
	function search($start=0){
		if(!empty($this->input->post('key'))){
			$key =$this->input->post('key');
			$_SESSION['key'] = $key;
		}else{
			$key = $_SESSION['key'];
		}
		
		$limit = 10;		
		$this->db->or_like('version', $key, 'both');
$this->db->or_like('start_time', $key, 'both');
$this->db->or_like('end_time', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['phinxlog'] = $this->db->get('phinxlog')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/phinxlog/search');
		$this->db->reset_query();		
		$this->db->or_like('version', $key, 'both');
$this->db->or_like('start_time', $key, 'both');
$this->db->or_like('end_time', $key, 'both');

		$config['total_rows'] = $this->db->from("phinxlog")->count_all_results();
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
		$data['_view'] = 'admin/phinxlog/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export phinxlog
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'phinxlog_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $phinxlogData = $this->Phinxlog_model->get_all_phinxlog();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Version","Start Time","End Time"); 
		   fputcsv($file, $header);
		   foreach ($phinxlogData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $phinxlog = $this->db->get('phinxlog')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/phinxlog/print_template.php');
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
//End of Phinxlog controller