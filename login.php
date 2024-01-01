<?php 
include "classes/include.php";
$database = new DatabaseClass;
$database->CheckKullanici("barisdemirci","barisbaba3");
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title>Pluto - Responsive Bootstrap Admin Panel Templates</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- site icon -->
   <link rel="icon" href="images/fevicon.png" type="image/png" />
   <!-- bootstrap css -->
   <link rel="stylesheet" href="css/bootstrap.min.css" />
   <!-- site css -->
   <link rel="stylesheet" href="style.css" />
   <!-- responsive css -->
   <link rel="stylesheet" href="css/responsive.css" />
   <!-- color css -->
   <link rel="stylesheet" href="css/colors.css" />
   <!-- select bootstrap -->
   <link rel="stylesheet" href="css/bootstrap-select.css" />
   <!-- scrollbar css -->
   <link rel="stylesheet" href="css/perfect-scrollbar.css" />
   <!-- custom css -->
   <link rel="stylesheet" href="css/custom.css" />
   <!-- calendar file css -->
   <link rel="stylesheet" href="js/semantic.min.css" />
   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>
<body class="inner_page login">
   <div class="full_container">
      <div class="container">
         <div class="center verticle_center full_height">
            <div class="login_section">
               <div class="logo_login">
                  <div class="center">
                     <h2 style="color: white; font-size: 32pt; font-family:Arial, Helvetica, sans-serif;">Yaska Group <br> <br> Çalışan paneli girişi</h2>
                  </div>
               </div>
               <form style="padding: 40px;">
                  <div class="form-group">
                     <label for="exampleInputEmail1">Kullanıcı adı</label>
                     <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Kullanıcı Adı">
                     <small id="emailHelp" class="form-text text-muted">Size verilen kullanıcı adını giriniz.</small>
                  </div>
                  <div class="form-group">
                     <label for="exampleInputPassword1">Şifre</label>
                     <input type="password" id="password" class="form-control" id="exampleInputPassword1" placeholder="Şifre">
                     <button type="button" id="showpasswordbutton" class="btn btn-primary" style="float: right; margin-top:12px;"><i class="fa fa-eye" aria-hidden="true"></i></button> <br><br><br>
                  </div>
                  <button style="float: right;" type="button" class="btn btn-primary">Giriş Yap</button>
               </form>
            </div>
         </div>
      </div>
   </div>
   </div>
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
   <script src="js/jquery.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <!-- wow animation -->
   <script src="js/animate.js"></script>
   <!-- select country -->
   <script src="js/bootstrap-select.js"></script>
   <!-- nice scrollbar -->
   <script src="js/perfect-scrollbar.min.js"></script>
   <script>
      var ps = new PerfectScrollbar('#sidebar');
   </script>
   <!-- custom js -->
   <script src="js/custom.js"></script>
   <script src="js/project.js"></script>
</body>

</html>


