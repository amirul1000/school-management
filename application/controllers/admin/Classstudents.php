<?php

 /**
 * Author: Amirul Momenin
 * Desc:Classstudents Controller
 *
 */
class Classstudents extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Classstudents_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of classstudents table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['classstudents'] = $this->Classstudents_model->get_limit_classstudents($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/classstudents/index');
		$config['total_rows'] = $this->Classstudents_model->get_count_classstudents();
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
		
        $data['_view'] = 'admin/classstudents/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save classstudents
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'class_info_id' => html_escape($this->input->post('class_info_id')),
'students_id' => html_escape($this->input->post('students_id')),
'description' => html_escape($this->input->post('description')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['classstudents'] = $this->Classstudents_model->get_classstudents($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Classstudents_model->update_classstudents($id,$params);
				$this->session->set_flashdata('msg','Classstudents has been updated successfully');
                redirect('admin/classstudents/index');
            }else{
                $data['_view'] = 'admin/classstudents/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $classstudents_id = $this->Classstudents_model->add_classstudents($params);
				$this->session->set_flashdata('msg','Classstudents has been saved successfully');
                redirect('admin/classstudents/index');
            }else{  
			    $data['classstudents'] = $this->Classstudents_model->get_classstudents(0);
                $data['_view'] = 'admin/classstudents/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details classstudents
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['classstudents'] = $this->Classstudents_model->get_classstudents($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/classstudents/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting classstudents
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $classstudents = $this->Classstudents_model->get_classstudents($id);

        // check if the classstudents exists before trying to delete it
        if(isset($classstudents['id'])){
            $this->Classstudents_model->delete_classstudents($id);
			$this->session->set_flashdata('msg','Classstudents has been deleted successfully');
            redirect('admin/classstudents/index');
        }
        else
            show_error('The classstudents you are trying to delete does not exist.');
    }
	
	/**
     * Search classstudents
	 * @param $start - Starting of classstudents table's index to get query
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
$this->db->or_like('students_id', $key, 'both');
$this->db->or_like('description', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['classstudents'] = $this->db->get('classstudents')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/classstudents/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('class_info_id', $key, 'both');
$this->db->or_like('students_id', $key, 'both');
$this->db->or_like('description', $key, 'both');

		$config['total_rows'] = $this->db->from("classstudents")->count_all_results();
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
		$data['_view'] = 'admin/classstudents/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export classstudents
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'classstudents_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $classstudentsData = $this->Classstudents_model->get_all_classstudents();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Class Info Id","Students Id","Description"); 
		   fputcsv($file, $header);
		   foreach ($classstudentsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $classstudents = $this->db->get('classstudents')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/classstudents/print_template.php');
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
//End of Classstudents controller