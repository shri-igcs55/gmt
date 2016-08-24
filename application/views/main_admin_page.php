<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Bootstrap Admin Template : Binary Admin</title>
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
                <a class="navbar-brand" href="index.html">Binary admin</a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> <a href="<?php echo site_url('welcome/admin_logout');?>" class="btn btn-danger square-btn-adjust">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                <li class="text-center">
                    <img src="<?php echo base_url();?>assets/img/find_user.png" class="user-image img-responsive"/>
                    </li>
                
                    <?php //if($logged_in=="no") {
                        ?>
                    
                  <!--   <li>
                        <a  href="index.html"><i class="fa fa-dashboard fa-3x"></i>Dashboard</a>
                    </li> -->
                   
                      <li>
                                <a href="#">Developer<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="<?php echo site_url('developer/developer_detail');?>">Add Developer </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('developer/developer_list');?>">Developer List</a>
                                    </li>
                                </ul>
                            </li>

                          <li>
                                <a href="#">Property<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="<?php echo site_url('property/property_detail');?>">Add Property </a>
                                    </li>
                                   <li>
                                        <a href="<?php echo site_url('property/property_list');?>">Property List</a>
                                  </li>
                                </ul>
                          </li>
                         <!--  <li>
                                <a href="#">Plots<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="<?php echo site_url('plots/add_plots');?>">Add Plots</a>
                                    </li>
                                   <li>
                                        <a href="<?php echo site_url('plots/plots_list');?>">Plots List</a>
                                  </li>
                                </ul>
                          </li> -->

                     
                                       
                    
                      <?php //}?>
                      
                        <!-- <li>
                        <a href="<?php echo site_url('property/photo_slider');?>">Photo Slider</a>
                        </li> -->

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
                                <a href="#">Master Entry<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                  <li>
                                        <a href="<?php echo site_url('master/state/list_of_state');?>">State</a>
                                    </li>
                                   <li>
                                        <a href="<?php echo site_url('master/city/list_of_city');?>">City</a>
                                  </li>
                                  <li>
                                        <a href="<?php echo site_url('master/location/list_of_location');?>">Location</a>
                                  </li>
                                  <li>
                                        <a href="<?php echo site_url('master/figure/list_of_figure');?>">Figure</a>
                                  </li>
                                  <li>
                                        <a href="<?php echo site_url('master/seo/list_of_seo');?>">Seo</a>
                                  </li>
                                  <li>
                                        <a href="<?php echo site_url('master/pro_use/list_of_pro_use');?>">Property Use</a>
                                  </li>
                                

                                </ul>
                               
                            </li>

                              <li>
                                <a href="#">List <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="<?php echo site_url('user/list_of_bookcab');?>">Bookcab</a>
                                    </li>
                                   <li>
                                        <a href="<?php echo site_url('user/list_of_otherservices');?>">Other Services</a>
                                  </li>
                                  <li>
                                        <a href="<?php echo site_url('user/list_of_contact');?>">contact</a>
                                  </li>
                                  <li>
                                        <a href="<?php echo site_url('user/view_list_of_property');?>">List of Property</a>
                                  </li>
                                   <li>
                                        <a href="<?php echo site_url('user/view_list_of_advertise');?>">List of Adveritse</a>
                                  </li>

                                  <li>
                                        <a href="<?php echo site_url('user/view_list_of_createfreealert');?>">List of Create Free alert</a>
                                  </li>
                                  <li>
                                        <a href="<?php echo site_url('user/view_list_of_joingroup');?>">List of join Group member</a>
                                  </li>
                                  
                                

                                </ul>
                               
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
                            <!-- <li>
                            <a href="<?php echo site_url('property/site_visit');?>">Site Visit</a>
                            </li> -->

                            <!--  <li>
                                <a href="<?php echo site_url('property/list_of_video');?>">City</a>
                            </li>

                            <li>
                            <a href="<?php echo site_url('plots_details');?>">Plots Details</a>
                            </li> -->


                        <!-- <li>
                        <a class="active-menu"  href="blank.html"><i class="fa fa-square-o fa-3x"></i> Blank Page</a>
                        </li>  -->  
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Admin Dashboard</h2>   
                        <h5>Welcome <?php echo $user_id_admin;?>, Love to see you back. </h5>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
               <!--  <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <i class="fa fa-envelope-o"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">120 New</p>
                    <p class="text-muted">Messages</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-bars"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">30 Tasks</p>
                    <p class="text-muted">Remaining</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-bell-o"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">240 New</p>
                    <p class="text-muted">Notifications</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-brown set-icon">
                    <i class="fa fa-rocket"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">3 Orders</p>
                    <p class="text-muted">Pending</p>
                </div>
             </div>
		     </div> -->
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
