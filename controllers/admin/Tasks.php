<?php

 /**
 * Author: Amirul Momenin
 * Desc:Tasks Controller
 *
 */
class Tasks extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Tasks_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of tasks table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['tasks'] = $this->Tasks_model->get_limit_tasks($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/tasks/index');
		$config['total_rows'] = $this->Tasks_model->get_count_tasks();
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
		
        $data['_view'] = 'admin/tasks/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save tasks
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'name' => html_escape($this->input->post('name')),
'short_desc' => html_escape($this->input->post('short_desc')),
'long_desc' => html_escape($this->input->post('long_desc')),
'users_id' => html_escape($this->input->post('users_id')),
'scheduled_date' => html_escape($this->input->post('scheduled_date')),
'created' => html_escape($this->input->post('created')),
'modified' => html_escape($this->input->post('modified')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['tasks'] = $this->Tasks_model->get_tasks($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Tasks_model->update_tasks($id,$params);
                redirect('admin/tasks/index');
            }else{
                $data['_view'] = 'admin/tasks/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $tasks_id = $this->Tasks_model->add_tasks($params);
                redirect('admin/tasks/index');
            }else{  
			    $data['tasks'] = $this->Tasks_model->get_tasks(0);
                $data['_view'] = 'admin/tasks/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details tasks
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['tasks'] = $this->Tasks_model->get_tasks($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/tasks/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting tasks
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $tasks = $this->Tasks_model->get_tasks($id);

        // check if the tasks exists before trying to delete it
        if(isset($tasks['id'])){
            $this->Tasks_model->delete_tasks($id);
            redirect('admin/tasks/index');
        }
        else
            show_error('The tasks you are trying to delete does not exist.');
    }
	
	/**
     * Search tasks
	 * @param $start - Starting of tasks table's index to get query
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
$this->db->or_like('scheduled_date', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['tasks'] = $this->db->get('tasks')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/tasks/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('short_desc', $key, 'both');
$this->db->or_like('long_desc', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('scheduled_date', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');

		$config['total_rows'] = $this->db->from("tasks")->count_all_results();
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
		$data['_view'] = 'admin/tasks/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export tasks
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'tasks_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $tasksData = $this->Tasks_model->get_all_tasks();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Name","Short Desc","Long Desc","Users Id","Scheduled Date","Created","Modified"); 
		   fputcsv($file, $header);
		   foreach ($tasksData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $tasks = $this->db->get('tasks')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/tasks/print_template.php');
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
//End of Tasks controller