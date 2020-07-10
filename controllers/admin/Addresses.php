<?php

 /**
 * Author: Amirul Momenin
 * Desc:Addresses Controller
 *
 */
class Addresses extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Addresses_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of addresses table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['addresses'] = $this->Addresses_model->get_limit_addresses($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/addresses/index');
		$config['total_rows'] = $this->Addresses_model->get_count_addresses();
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
		
        $data['_view'] = 'admin/addresses/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save addresses
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'users_id' => html_escape($this->input->post('users_id')),
'address1' => html_escape($this->input->post('address1')),
'address2' => html_escape($this->input->post('address2')),
'address3' => html_escape($this->input->post('address3')),
'city_id' => html_escape($this->input->post('city_id')),
'city_other' => html_escape($this->input->post('city_other')),
'state_id' => html_escape($this->input->post('state_id')),
'state_other' => html_escape($this->input->post('state_other')),
'country_id' => html_escape($this->input->post('country_id')),
'zip' => html_escape($this->input->post('zip')),
'created' => html_escape($this->input->post('created')),
'modified' => html_escape($this->input->post('modified')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['addresses'] = $this->Addresses_model->get_addresses($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Addresses_model->update_addresses($id,$params);
                redirect('admin/addresses/index');
            }else{
                $data['_view'] = 'admin/addresses/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $addresses_id = $this->Addresses_model->add_addresses($params);
                redirect('admin/addresses/index');
            }else{  
			    $data['addresses'] = $this->Addresses_model->get_addresses(0);
                $data['_view'] = 'admin/addresses/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details addresses
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['addresses'] = $this->Addresses_model->get_addresses($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/addresses/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting addresses
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $addresses = $this->Addresses_model->get_addresses($id);

        // check if the addresses exists before trying to delete it
        if(isset($addresses['id'])){
            $this->Addresses_model->delete_addresses($id);
            redirect('admin/addresses/index');
        }
        else
            show_error('The addresses you are trying to delete does not exist.');
    }
	
	/**
     * Search addresses
	 * @param $start - Starting of addresses table's index to get query
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
$this->db->or_like('address1', $key, 'both');
$this->db->or_like('address2', $key, 'both');
$this->db->or_like('address3', $key, 'both');
$this->db->or_like('city_id', $key, 'both');
$this->db->or_like('city_other', $key, 'both');
$this->db->or_like('state_id', $key, 'both');
$this->db->or_like('state_other', $key, 'both');
$this->db->or_like('country_id', $key, 'both');
$this->db->or_like('zip', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['addresses'] = $this->db->get('addresses')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/addresses/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('users_id', $key, 'both');
$this->db->or_like('address1', $key, 'both');
$this->db->or_like('address2', $key, 'both');
$this->db->or_like('address3', $key, 'both');
$this->db->or_like('city_id', $key, 'both');
$this->db->or_like('city_other', $key, 'both');
$this->db->or_like('state_id', $key, 'both');
$this->db->or_like('state_other', $key, 'both');
$this->db->or_like('country_id', $key, 'both');
$this->db->or_like('zip', $key, 'both');
$this->db->or_like('created', $key, 'both');
$this->db->or_like('modified', $key, 'both');

		$config['total_rows'] = $this->db->from("addresses")->count_all_results();
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
		$data['_view'] = 'admin/addresses/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export addresses
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'addresses_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $addressesData = $this->Addresses_model->get_all_addresses();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Users Id","Address1","Address2","Address3","City Id","City Other","State Id","State Other","Country Id","Zip","Created","Modified"); 
		   fputcsv($file, $header);
		   foreach ($addressesData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $addresses = $this->db->get('addresses')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/addresses/print_template.php');
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
//End of Addresses controller