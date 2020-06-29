<?php

 /**
 * Author: Amirul Momenin
 * Desc:Payments Controller
 *
 */
class Payments extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Payments_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of payments table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['payments'] = $this->Payments_model->get_limit_payments($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/payments/index');
		$config['total_rows'] = $this->Payments_model->get_count_payments();
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
		
        $data['_view'] = 'admin/payments/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save payments
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'class_info_id' => html_escape($this->input->post('class_info_id')),
'students_id' => html_escape($this->input->post('students_id')),
'pay_subject' => html_escape($this->input->post('pay_subject')),
'amount' => html_escape($this->input->post('amount')),
'pay_date' => html_escape($this->input->post('pay_date')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['payments'] = $this->Payments_model->get_payments($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Payments_model->update_payments($id,$params);
				$this->session->set_flashdata('msg','Payments has been updated successfully');
                redirect('admin/payments/index');
            }else{
                $data['_view'] = 'admin/payments/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $payments_id = $this->Payments_model->add_payments($params);
				$this->session->set_flashdata('msg','Payments has been saved successfully');
                redirect('admin/payments/index');
            }else{  
			    $data['payments'] = $this->Payments_model->get_payments(0);
                $data['_view'] = 'admin/payments/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details payments
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['payments'] = $this->Payments_model->get_payments($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/payments/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting payments
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $payments = $this->Payments_model->get_payments($id);

        // check if the payments exists before trying to delete it
        if(isset($payments['id'])){
            $this->Payments_model->delete_payments($id);
			$this->session->set_flashdata('msg','Payments has been deleted successfully');
            redirect('admin/payments/index');
        }
        else
            show_error('The payments you are trying to delete does not exist.');
    }
	
	/**
     * Search payments
	 * @param $start - Starting of payments table's index to get query
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
$this->db->or_like('pay_subject', $key, 'both');
$this->db->or_like('amount', $key, 'both');
$this->db->or_like('pay_date', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['payments'] = $this->db->get('payments')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/payments/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('class_info_id', $key, 'both');
$this->db->or_like('students_id', $key, 'both');
$this->db->or_like('pay_subject', $key, 'both');
$this->db->or_like('amount', $key, 'both');
$this->db->or_like('pay_date', $key, 'both');

		$config['total_rows'] = $this->db->from("payments")->count_all_results();
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
		$data['_view'] = 'admin/payments/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export payments
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'payments_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $paymentsData = $this->Payments_model->get_all_payments();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Class Info Id","Students Id","Pay Subject","Amount","Pay Date"); 
		   fputcsv($file, $header);
		   foreach ($paymentsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $payments = $this->db->get('payments')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/payments/print_template.php');
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
//End of Payments controller