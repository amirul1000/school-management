<a  href="<?php echo site_url('admin/class_info/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Class_info'); ?></h5>
<!--Data display of class_info with id--> 
<?php
	$c = $class_info;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Year Semester</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Year_semester_model');
									   $dataArr = $this->CI->Year_semester_model->get_year_semester($c['year_semester_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>Name</td><td><?php echo $c['name']; ?></td></tr>

<tr><td>Description</td><td><?php echo $c['description']; ?></td></tr>


</table>
<!--End of Data display of class_info with id//--> 