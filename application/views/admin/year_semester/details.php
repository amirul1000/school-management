<a  href="<?php echo site_url('admin/year_semester/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Year_semester'); ?></h5>
<!--Data display of year_semester with id--> 
<?php
	$c = $year_semester;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Name</td><td><?php echo $c['name']; ?></td></tr>

<tr><td>Description</td><td><?php echo $c['description']; ?></td></tr>


</table>
<!--End of Data display of year_semester with id//--> 