<?php

 /**
 * Author: Amirul Momenin
 * Desc:Year_semester Controller
 *
 */
class Year_semester extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Year_semester_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of year_semester table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['year_semester'] = $this->Year_semester_model->get_limit_year_semester($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/year_semester/index');
		$config['total_rows'] = $this->Year_semester_model->get_count_year_semester();
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
		
        $data['_view'] = 'admin/year_semester/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save year_semester
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'name' => html_escape($this->input->post('name')),
'description' => html_escape($this->input->post('description')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['year_semester'] = $this->Year_semester_model->get_year_semester($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Year_semester_model->update_year_semester($id,$params);
				$this->session->set_flashdata('msg','Year_semester has been updated successfully');
                redirect('admin/year_semester/index');
            }else{
                $data['_view'] = 'admin/year_semester/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $year_semester_id = $this->Year_semester_model->add_year_semester($params);
				$this->session->set_flashdata('msg','Year_semester has been saved successfully');
                redirect('admin/year_semester/index');
            }else{  
			    $data['year_semester'] = $this->Year_semester_model->get_year_semester(0);
                $data['_view'] = 'admin/year_semester/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details year_semester
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['year_semester'] = $this->Year_semester_model->get_year_semester($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/year_semester/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting year_semester
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $year_semester = $this->Year_semester_model->get_year_semester($id);

        // check if the year_semester exists before trying to delete it
        if(isset($year_semester['id'])){
            $this->Year_semester_model->delete_year_semester($id);
			$this->session->set_flashdata('msg','Year_semester has been deleted successfully');
            redirect('admin/year_semester/index');
        }
        else
            show_error('The year_semester you are trying to delete does not exist.');
    }
	
	/**
     * Search year_semester
	 * @param $start - Starting of year_semester table's index to get query
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
$this->db->or_like('description', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['year_semester'] = $this->db->get('year_semester')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/year_semester/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('description', $key, 'both');

		$config['total_rows'] = $this->db->from("year_semester")->count_all_results();
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
		$data['_view'] = 'admin/year_semester/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export year_semester
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'year_semester_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $year_semesterData = $this->Year_semester_model->get_all_year_semester();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Name","Description"); 
		   fputcsv($file, $header);
		   foreach ($year_semesterData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $year_semester = $this->db->get('year_semester')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/year_semester/print_template.php');
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
//End of Year_semester controller