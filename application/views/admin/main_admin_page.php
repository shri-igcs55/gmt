<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
        <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Admin Panel</title>
      <script src="<?php echo base_url();?>assets/js/jquery-1.10.2.js"></script>
      <!-- Datatables-->
      <link href="<?php echo base_url();?>assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
      <!-- BOOTSTRAP STYLES-->
      <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" />
       <!-- FONTAWESOME STYLES-->
      <link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet" />
          <!-- CUSTOM STYLES-->
      <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" />
       <!-- GOOGLE FONTS-->
          <!-- MORRIS CHART STYLES-->
      <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
  </head>
  <body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
          <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Get My Truck</a> 
          </div>
          <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">
            <a href="<?php echo site_url('admin/welcome/admin_logout');?>" class="btn btn-danger square-btn-adjust">Logout</a>
          </div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                <li class="text-center">
                    <!-- img src="<?php //echo base_url();?>assets/img/find_user.png" class="user-image img-responsive"/ -->
                    </li>
                        <li>
                        <a href="<?php echo site_url('property/list_of_member_review');?>">Project Review</a>
                        </li>
                        <li>
                        <a href="<?php echo site_url('developer/list_of_developer_review');?>">Developer Review</a>
                        </li>

                        <li>
                        <a href="<?php echo site_url('property/popular_area');?>">Popular Area</a>
                        </li>

                            <li>
                            <a href="<?php echo site_url('search_photo_for_property');?>">Search Photo Property</a>
                            </li>

                             <li>
                            <a href="<?php echo site_url('search_photo_for_developer');?>">Search Photo developer</a>
                            </li>
                            <li>
                            <a href="<?php echo site_url('search_photo_for_loan');?>">Search Photo loan</a>
                            </li>
                            <li>
                            <a href="<?php echo site_url('search_photo_for_other');?>">Search Photo Other</a>
                            </li>
                             <li>
                            <a href="<?php echo site_url('seo');?>">SEO</a>
                            </li>
                             <li>
                            <a href="<?php echo site_url('advertise/list_of_advertise');?>">Advertise</a>
                            </li>
                              
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
          <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                 <h2>Admin Dashboard</h2>   
                    <h5>Welcome <?php echo $user_id_admin;?>, Nice to see you back. </h5>
                </div>
            </div>              
            <!-- /. ROW  -->
            <hr />
            <div class="row">
           
	          </div>
            <!-- /. ROW  -->           
          </div>
          <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="<?php echo base_url();?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/js/dataTables/dataTables.bootstrap.js"></script>
  
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="<?php echo base_url();?>assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="<?php echo base_url();?>assets/js/custom.js"></script>
  </body>
</html>
