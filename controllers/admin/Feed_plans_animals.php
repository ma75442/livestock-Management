<?php

 /**
 * Author: Amirul Momenin
 * Desc:Feed_plans_animals Controller
 *
 */
class Feed_plans_animals extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Feed_plans_animals_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of feed_plans_animals table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['feed_plans_animals'] = $this->Feed_plans_animals_model->get_limit_feed_plans_animals($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/feed_plans_animals/index');
		$config['total_rows'] = $this->Feed_plans_animals_model->get_count_feed_plans_animals();
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
		
        $data['_view'] = 'admin/feed_plans_animals/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save feed_plans_animals
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'feed_plans_id' => html_escape($this->input->post('feed_plans_id')),
'animal_id' => html_escape($this->input->post('animal_id')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['feed_plans_animals'] = $this->Feed_plans_animals_model->get_feed_plans_animals($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Feed_plans_animals_model->update_feed_plans_animals($id,$params);
                redirect('admin/feed_plans_animals/index');
            }else{
                $data['_view'] = 'admin/feed_plans_animals/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $feed_plans_animals_id = $this->Feed_plans_animals_model->add_feed_plans_animals($params);
                redirect('admin/feed_plans_animals/index');
            }else{  
			    $data['feed_plans_animals'] = $this->Feed_plans_animals_model->get_feed_plans_animals(0);
                $data['_view'] = 'admin/feed_plans_animals/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details feed_plans_animals
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['feed_plans_animals'] = $this->Feed_plans_animals_model->get_feed_plans_animals($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/feed_plans_animals/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting feed_plans_animals
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $feed_plans_animals = $this->Feed_plans_animals_model->get_feed_plans_animals($id);

        // check if the feed_plans_animals exists before trying to delete it
        if(isset($feed_plans_animals['id'])){
            $this->Feed_plans_animals_model->delete_feed_plans_animals($id);
            redirect('admin/feed_plans_animals/index');
        }
        else
            show_error('The feed_plans_animals you are trying to delete does not exist.');
    }
	
	/**
     * Search feed_plans_animals
	 * @param $start - Starting of feed_plans_animals table's index to get query
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
$this->db->or_like('feed_plans_id', $key, 'both');
$this->db->or_like('animal_id', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['feed_plans_animals'] = $this->db->get('feed_plans_animals')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/feed_plans_animals/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('feed_plans_id', $key, 'both');
$this->db->or_like('animal_id', $key, 'both');

		$config['total_rows'] = $this->db->from("feed_plans_animals")->count_all_results();
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
		$data['_view'] = 'admin/feed_plans_animals/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export feed_plans_animals
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'feed_plans_animals_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $feed_plans_animalsData = $this->Feed_plans_animals_model->get_all_feed_plans_animals();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Feed Plans Id","Animal Id"); 
		   fputcsv($file, $header);
		   foreach ($feed_plans_animalsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $feed_plans_animals = $this->db->get('feed_plans_animals')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/feed_plans_animals/print_template.php');
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
//End of Feed_plans_animals controller