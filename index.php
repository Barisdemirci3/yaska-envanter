  <?php 
  include "resources/header.php";
  include "resources/sidebar.php";
  include "resources/topbar.php";
require_once("classes/include.php");
$createClass = new DatabaseClass;
$createDashboardClass = new DashboardClass;
  session_start();
  ?>
  <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <div id="content">
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Gösterge Paneli</h2>
                           </div>
                        </div>
                     </div>
                    <div class="white_shd full margin_bottom_30  ">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Duyuru</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                             <li>
                                                <?php $write_duyuru= $createClass->GetUpdateText(); ?>
                                                <span>
                                                <span class="name_user"><?= $write_duyuru["duyuru_text"]; ?></span>

                                                <span class="time_ago"> <?= DateFormater($write_duyuru["duyuru_date"]);  ?></span>
                                                </span>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                     <div class="row column1">
                     <div class="col-md-6 col-lg-3 p-2">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                 <i class="fa-solid fa-user-tie" style="color: black"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?= $createDashboardClass->GetSystemUserCount(); ?></p>
                                    <p class="head_couter">Sistem Kullanıcısı Sayısı</p>
                                 </div>
                              </div>

                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3 p-2">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-user yellow_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?= $createClass->GetPersonel(1); ?></p>
                                    <p class="head_couter">Personel Sayısı</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3 p-2">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                 <i class="fa fa-laptop" style="color:royalblue;"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?= $createDashboardClass->GetObjectCount(); ?></p>
                                    <p class="head_couter">Toplam Cihaz Sayısı</p>
                                 </div>
                              </div>
                              
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3 p-2">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-comments-o red_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no">Buraya</p>
                                    <p class="head_couter">Cevaplanan talep sayısı</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Last Comments</h2>
                                 </div>
                              </div>
                              <div class="full progress_bar_inner">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="msg_list_main">
                                          <ul class="msg_list">
                                             <li>
                                                <span>
                                                <span class="name_user">Herman Beck</span>
                                                <span class="msg_user">Sed ut perspiciatis unde omnis.</span>
                                                <span class="time_ago">12 min ago</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">John Smith</span>
                                                <span class="msg_user">On the other hand, we denounce.</span>
                                                <span class="time_ago">12 min ago</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">John Smith</span>
                                                <span class="msg_user">Sed ut perspiciatis unde omnis.</span>
                                                <span class="time_ago">12 min ago</span>
                                                </span>
                                             </li>
                                             <li>
                                                <span>
                                                <span class="name_user">John Smith</span>
                                                <span class="msg_user">On the other hand, we denounce.</span>
                                                <span class="time_ago">12 min ago</span>
                                                </span>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                     <!-- graph -->
                     
                  <!-- footer -->
                  <?php require_once("resources/footer.php"); ?>
               </div>
               <!-- end dashboard inner -->
            </div>
         </div>
      </div>
      <!-- jQuery -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="js/animate.js"></script>
      <!-- select country -->
      <script src="js/bootstrap-select.js"></script>
      <!-- owl carousel -->
      <script src="js/owl.carousel.js"></script> 
      <!-- chart js -->
      <script src="js/Chart.min.js"></script>
      <script src="js/Chart.bundle.min.js"></script>
      <script src="js/utils.js"></script>
      <script src="js/analyser.js"></script>
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="js/chart_custom_style1.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>