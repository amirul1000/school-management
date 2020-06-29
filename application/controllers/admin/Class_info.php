<?php

 /**
 * Author: Amirul Momenin
 * Desc:Class_info Controller
 *
 */
class Class_info extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Class_info_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of class_info table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['class_info'] = $this->Class_info_model->get_limit_class_info($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/class_info/index');
		$config['total_rows'] = $this->Class_info_model->get_count_class_info();
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
		
        $data['_view'] = 'admin/class_info/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save class_info
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'year_semester_id' => html_escape($this->input->post('year_semester_id')),
'name' => html_escape($this->input->post('name')),
'description' => html_escape($this->input->post('description')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['class_info'] = $this->Class_info_model->get_class_info($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Class_info_model->update_class_info($id,$params);
				$this->session->set_flashdata('msg','Class_info has been updated successfully');
                redirect('admin/class_info/index');
            }else{
                $data['_view'] = 'admin/class_info/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $class_info_id = $this->Class_info_model->add_class_info($params);
				$this->session->set_flashdata('msg','Class_info has been saved successfully');
                redirect('admin/class_info/index');
            }else{  
			    $data['class_info'] = $this->Class_info_model->get_class_info(0);
                $data['_view'] = 'admin/class_info/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details class_info
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['class_info'] = $this->Class_info_model->get_class_info($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/class_info/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting class_info
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $class_info = $this->Class_info_model->get_class_info($id);

        // check if the class_info exists before trying to delete it
        if(isset($class_info['id'])){
            $this->Class_info_model->delete_class_info($id);
			$this->session->set_flashdata('msg','Class_info has been deleted successfully');
            redirect('admin/class_info/index');
        }
        else
            show_error('The class_info you are trying to delete does not exist.');
    }
	
	/**
     * Search class_info
	 * @param $start - Starting of class_info table's index to get query
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
$this->db->or_like('year_semester_id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('description', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['class_info'] = $this->db->get('class_info')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/class_info/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('year_semester_id', $key, 'both');
$this->db->or_like('name', $key, 'both');
$this->db->or_like('description', $key, 'both');

		$config['total_rows'] = $this->db->from("class_info")->count_all_results();
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
		$data['_view'] = 'admin/class_info/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export class_info
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'class_info_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $class_infoData = $this->Class_info_model->get_all_class_info();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Year Semester Id","Name","Description"); 
		   fputcsv($file, $header);
		   foreach ($class_infoData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $class_info = $this->db->get('class_info')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/class_info/print_template.php');
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
//End of Class_info controller