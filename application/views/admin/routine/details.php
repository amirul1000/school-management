<a  href="<?php echo site_url('admin/routine/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Routine'); ?></h5>
<!--Data display of routine with id--> 
<?php
	$c = $routine;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Class Info</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Class_info_model');
									   $dataArr = $this->CI->Class_info_model->get_class_info($c['class_info_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Subjects</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Subjects_model');
									   $dataArr = $this->CI->Subjects_model->get_subjects($c['subjects_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Teachers</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Teachers_model');
									   $dataArr = $this->CI->Teachers_model->get_teachers($c['teachers_id']);
									   echo $dataArr['email'];?>
									</td></tr>

<tr><td>R Date</td><td><?php echo $c['r_date']; ?></td></tr>

<tr><td>R Time</td><td><?php echo $c['r_time']; ?></td></tr>


</table>
<!--End of Data display of routine with id//--> 