<a  href="<?php echo site_url('admin/payments/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Payments'); ?></h5>
<!--Data display of payments with id--> 
<?php
	$c = $payments;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Class Info</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Class_info_model');
									   $dataArr = $this->CI->Class_info_model->get_class_info($c['class_info_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Students</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Students_model');
									   $dataArr = $this->CI->Students_model->get_students($c['students_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>Pay Subject</td><td><?php echo $c['pay_subject']; ?></td></tr>

<tr><td>Amount</td><td><?php echo $c['amount']; ?></td></tr>

<tr><td>Pay Date</td><td><?php echo $c['pay_date']; ?></td></tr>


</table>
<!--End of Data display of payments with id//--> 