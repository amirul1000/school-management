<?php

 /**
 * Author: Amirul Momenin
 * Desc:Attendence Controller
 *
 */
class Attendence extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Attendence_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of attendence table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['attendence'] = $this->Attendence_model->get_limit_attendence($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/attendence/index');
		$config['total_rows'] = $this->Attendence_model->get_count_attendence();
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
		
        $data['_view'] = 'admin/attendence/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save attendence
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'class_info_id' => html_escape($this->input->post('class_info_id')),
'subjects_id' => html_escape($this->input->post('subjects_id')),
'r_date' => html_escape($this->input->post('r_date')),
'r_time' => html_escape($this->input->post('r_time')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['attendence'] = $this->Attendence_model->get_attendence($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Attendence_model->update_attendence($id,$params);
				$this->session->set_flashdata('msg','Attendence has been updated successfully');
                redirect('admin/attendence/index');
            }else{
                $data['_view'] = 'admin/attendence/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $attendence_id = $this->Attendence_model->add_attendence($params);
				$this->session->set_flashdata('msg','Attendence has been saved successfully');
                redirect('admin/attendence/index');
            }else{  
			    $data['attendence'] = $this->Attendence_model->get_attendence(0);
                $data['_view'] = 'admin/attendence/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details attendence
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['attendence'] = $this->Attendence_model->get_attendence($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/attendence/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting attendence
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $attendence = $this->Attendence_model->get_attendence($id);

        // check if the attendence exists before trying to delete it
        if(isset($attendence['id'])){
            $this->Attendence_model->delete_attendence($id);
			$this->session->set_flashdata('msg','Attendence has been deleted successfully');
            redirect('admin/attendence/index');
        }
        else
            show_error('The attendence you are trying to delete does not exist.');
    }
	
	/**
     * Search attendence
	 * @param $start - Starting of attendence table's index to get query
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
$this->db->or_like('class_info_id', $key, 'both');
$this->db->or_like('subjects_id', $key, 'both');
$this->db->or_like('r_date', $key, 'both');
$this->db->or_like('r_time', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['attendence'] = $this->db->get('attendence')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/attendence/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('class_info_id', $key, 'both');
$this->db->or_like('subjects_id', $key, 'both');
$this->db->or_like('r_date', $key, 'both');
$this->db->or_like('r_time', $key, 'both');

		$config['total_rows'] = $this->db->from("attendence")->count_all_results();
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
		$data['_view'] = 'admin/attendence/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export attendence
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'attendence_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $attendenceData = $this->Attendence_model->get_all_attendence();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Class Info Id","Subjects Id","R Date","R Time"); 
		   fputcsv($file, $header);
		   foreach ($attendenceData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $attendence = $this->db->get('attendence')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/attendence/print_template.php');
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
//End of Attendence controller