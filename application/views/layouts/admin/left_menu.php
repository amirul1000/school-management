<!--Left Menu-->
<nav>
    <ul class="sidebar-menu" data-widget="tree">
        <li class="sidemenu-user-profile d-flex align-items-center">
            <div class="user-thumbnail">
                <?php
				  if(is_file(APPPATH.'../public/'.$this->session->userdata['file_picture'])&&file_exists(APPPATH.'../public/'.$this->session->userdata['file_picture']))
				   {
				 ?>
					  <img  src="<?php echo base_url().'public/'.$this->session->userdata['file_picture']?>" alt="">
				<?php
					}
					else
					{
				?>
					  <img class="border-radius-50" src="<?php echo base_url()?>public/uploads/no_image.jpg">
				<?php		
					}
				  ?>
            </div>
            <div class="user-content">
                <h6><?php echo $this->session->userdata['first_name']?> <?php echo $this->session->userdata['last_name']?></h6>
                <!--<span>Pro User</span>-->
            </div>
        </li>
        <li <?php if($this->router->fetch_class()=="homecontroller"){?>
					class="active" <?php }?>><a href="<?php echo site_url('homecontroller'); ?>"><i class="icon_lifesaver"></i> <span>Dashboard</span></a></li>
        <?php
		     $menu_open =  false; 
		     if($this->router->fetch_class()=="profile" ||
			    $this->router->fetch_class()=="country" ||
				$this->router->fetch_class()=="company" ||
				$this->router->fetch_class()=="users" 
			 )
			 {
				$menu_open =  true; 
			 }
		?>
        <li class="treeview <?php if($menu_open==true){?>menu-open<?php }?>">
            <a href="javascript:void(0)"><i class="icon_document_alt"></i> <span>Settings</span> <i class="fa fa-angle-right"></i></a>
            <ul class="treeview-menu" <?php if($menu_open==true){?>style="display: block;"<?php }?>>
                <li <?php if($this->router->fetch_class()=="profile"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/profile/index'); ?>">- Profile</a></li>
                <li <?php if($this->router->fetch_class()=="country"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/country/index'); ?>">- Country</a></li>
                <li <?php if($this->router->fetch_class()=="company"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/company/index'); ?>">- Company</a></li>
                <li <?php if($this->router->fetch_class()=="users"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/users/index'); ?>">- Users</a></li>
            </ul>
        </li> 
        <li <?php if($this->router->fetch_class()=="attendence"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/attendence/index'); ?>"><i class="icon_table"></i>Attendence</a></li>
<li <?php if($this->router->fetch_class()=="class_info"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/class_info/index'); ?>"><i class="icon_table"></i>Class Info</a></li>
<li <?php if($this->router->fetch_class()=="classstudents"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/classstudents/index'); ?>"><i class="icon_table"></i>Classstudents</a></li>
<li <?php if($this->router->fetch_class()=="payments"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/payments/index'); ?>"><i class="icon_table"></i>Payments</a></li>
<li <?php if($this->router->fetch_class()=="routine"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/routine/index'); ?>"><i class="icon_table"></i>Routine</a></li>
<li <?php if($this->router->fetch_class()=="students"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/students/index'); ?>"><i class="icon_table"></i>Students</a></li>
<li <?php if($this->router->fetch_class()=="subjects"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/subjects/index'); ?>"><i class="icon_table"></i>Subjects</a></li>
<li <?php if($this->router->fetch_class()=="teachers"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/teachers/index'); ?>"><i class="icon_table"></i>Teachers</a></li>
<li <?php if($this->router->fetch_class()=="year_semester"){?>class="active"<?php }?>><a href="<?php echo site_url('admin/year_semester/index'); ?>"><i class="icon_table"></i>Year Semester</a></li>

    </ul>
</nav>
<!--End of Left Menu//-->