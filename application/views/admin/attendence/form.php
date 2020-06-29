<a  href="<?php echo site_url('admin/attendence/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Attendence'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/attendence/save/'.$attendence['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
                                    <label for="Class Info" class="col-md-4 control-label">Class Info</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Class_info_model'); 
             $dataArr = $this->CI->Class_info_model->get_all_class_info(); 
          ?> 
          <select name="class_info_id"  id="class_info_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($attendence['class_info_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="Subjects" class="col-md-4 control-label">Subjects</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Subjects_model'); 
             $dataArr = $this->CI->Subjects_model->get_all_subjects(); 
          ?> 
          <select name="subjects_id"  id="subjects_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($attendence['subjects_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                       <label for="R Date" class="col-md-4 control-label">R Date</label> 
            <div class="col-md-8"> 
           <input type="text" name="r_date"  id="r_date"  value="<?php echo ($this->input->post('r_date') ? $this->input->post('r_date') : $attendence['r_date']); ?>" class="form-control-static datepicker"/> 
            </div> 
           </div>
<div class="form-group"> 
          <label for="R Time" class="col-md-4 control-label">R Time</label> 
          <div class="col-md-8"> 
           <input type="text" name="r_time" value="<?php echo ($this->input->post('r_time') ? $this->input->post('r_time') : $attendence['r_time']); ?>" class="form-control" id="r_time" /> 
          </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($attendence['id'])){?>Save<?php }else{?>Update<?php } ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->	
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>  			