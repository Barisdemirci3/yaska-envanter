<?php 
require_once("classes/include.php");
$ClassVariable = new DatabaseClass;

ob_start();
session_start();
if(!$_SESSION["nick"]){
   header("Location: login.php");
}
$datas = $ClassVariable->GetUserProperties($_SESSION["nick"]);

?>
<nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        <a href="index.html"><img class="logo_icon img-responsive" src="images/logo/logo_icon.png" alt="#" /></a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img"><img class="img-responsive" src="images/layout_img/user_img.jpg" alt="#" /></div>
                        <div class="user_info">
                           <h6>Hoşgeldiniz</h6>
                           <p><?php echo $datas["sistem_k_isim"]." ".$datas["sistem_k_soyisim"]; ?></p>
                           <p style="color: white; opacity: 100%; font-size: 10pt">Yetkiniz: <span style="opacity: 100%"><?= $ClassVariable->SystemRole($datas["sistem_k_rol"]) ?> </span></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  
                  <ul class="list-unstyled components">
                     <li class="active">
                        <a href="index.php"><i  class="fa fa-dashboard white_color"></i> <span>Gösterge Paneli</span></a>
                     </li>
                     <li><a href="add-personel.php"><i style="color: white" class="fa-solid fa-user-plus"></i> <span>Personel Ekle</span></a></li>
                     <li><a href="add-to-system.php"><i style="color: white" class="fa-solid fa-user-plus"></i> <span>Sisteme Kullanıcı Ekle</span></a></li>
                     <li><a href="add-category.php"><i class="fa-solid fa-list" style="color: white;"></i> <span>Kategori Ekle</span></a></li>
                     <li><a href="add-status-for-object.php"><i class="fa-solid fa-list" style="color: white;"></i> <span>Durum Ekle</span></a></li>
                     <li><a href="add-object.php"><i class="fa-solid fa-computer" style="color: white;"></i> <span>Cihaz Ekle</span></a></li>
                     <li><a href="add-role.php"><i class="fa-solid fa-pen-to-square" style="color: white;"></i> <span>Personel Rolü Ekle</span></a></li>
                     <li><a href="add-broadcast.php"><i class="fa-solid fa-bell" style="color: white;"></i> <span>Duyuru Ekle</span></a></li>
                     <li><a href="category-list.php"><i class="fa-solid fa-table" style="color: white;"></i> <span>Kategorileri Listele</span></a></li>
                     <li><a href="status-list.php"><i class="fa-solid fa-table" style="color: white;"></i> <span>Durumları Listele</span></a></li>
                     <li><a href="add-category.php"><i class="fa-solid fa-table" style="color: white;"></i><span>Eşyaları Listele</span></a></li>
                     <li><a href="rols.php"><i class="fa-solid fa-table" style="color: white;"></i><span>Rolleri Listele</span></a></li>
                     <li><a href="system-user.php"><i class="fa-solid fa-table" style="color: white;"></i> <span>Sistem kullanıcılarını listele</span></a></li>
                     <li><a href="users.php"><i class="fa-solid fa-table" style="color: white;"></i> <span>Personelleri listele</span></a></li>
                  </ul>
               </div>
            </nav>