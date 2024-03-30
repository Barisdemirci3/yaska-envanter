<?php require_once("resources/header.php"); 
if(!$_GET["id"]){
  header("Location: index.php");
}
else{
  if(!is_numeric($_GET["id"])){
    header("Location: index.php");
  }
  else{
    $dataclass = new DatabaseClass;
    $GetUser= $dataclass->GetPersonelProperties($_GET["id"]);
    if($GetUser == 0){
      header("Location: index.php");
    }else{
      $takeID = Get("id");
    }
  }
}
?>

<body class="inner_page map">
  <div class="full_container">
    <div class="inner_container">
      <!-- Sidebar  -->
      <?php require_once("resources/sidebar.php"); ?>
      <!-- end sidebar -->
      <!-- right content -->
      <div id="content">
        <!-- topbar -->
        <?php require_once("resources/topbar.php"); 
        $databaseclass = new DatabaseClass;
        $writerols = $databaseclass->GetRols();
        ?>
        <!-- end topbar -->
        <!-- dashboard inner -->
        <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Personel Düzenle</h2>
                </div>
              </div>
            </div>
            <!-- row -->

            <!-- 2 column grid layout with text inputs for the first and last names -->
            <form id="personel_edit_form" onsubmit="return false;">
              <div class="row mb-4">
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" required name="edit_isim" value="<?= $GetUser["kullanici_isim"] ?>" placeholder="İsim" class="form-control" />
                    <label class="form-label" for="form6Example1">İsim - <code>Zorunlu</code></label>
                  </div>
                </div>
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" required name="edit_soyisim" placeholder="Soyisim" value="<?= $GetUser["kullanici_soyisim"] ?>" class="form-control" />
                    <label class="form-label" for="form6Example2">Soyisim - <code>Zorunlu</code></label>
                  </div>
                </div>
              </div>

              <!-- Text input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" name="edit_callintech_mail" placeholder="Callintech Mail" value="<?= $GetUser["kullanici_callintech"] ?>" class="form-control" />
                <label class="form-label" for="form6Example3">Callintech mail adresi <code>Zorunlu Değil</code></label>
              </div>

              <!-- Text input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" name="edit_callintech_password" placeholder="Callintech Sifre" value="<?= $GetUser["kullanici_callintech_sifre"] ?>" class="form-control" />
                <label class="form-label" for="form6Example4">Callintech şifresi <code>Zorunlu Değil</code></label>
              </div>

              <!-- Email input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" name="edit_mail_sender_nick" placeholder="Mail Sender kullanıcı adı" value="<?= $GetUser["kullanici_mailsender"] ?>" class="form-control" />
                <label class="form-label" for="form6Example5">Mail Sender kullanıcı adı <code>Zorunlu Değil</code></label>
              </div>

              <!-- Number input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" name="edit_mail_sender_sifre" placeholder="Mail Sender Şifre" value="<?= $GetUser["kullanici_mailsender_sifre"] ?>" class="form-control" />
                <label class="form-label" for="form6Example6">Mail Sender şifre <code>Zorunlu Değil</code> </label>
              </div>

              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" required name="edit_slack_mail" placeholder="Slack Mail" value="<?= $GetUser["kullanici_slack_mail"] ?>" class="form-control" />
                <label class="form-label" for="form6Example6">Slack Mail - <code>Zorunlu</code></label>
              </div>

              <div data-mdb-input-init class="form-outline mb-4">
                <select name="rol" id="rol" class="form-control">
                <?php foreach ($writerols as $row) { 
                  if($row["rol_id"] == $GetUser["kullanici_rol"]){
                    echo '<option value="'.$row["rol_id"].'" selected>'.$row["rol_name"].'</option>';
                  }
                  else{
                    echo '<option value="'.$row["rol_id"].'">'.$row["rol_name"].'</option>';
                  }
                  ?>
                  <?php } ?>
                </select>
                <label class="form-label" for="form6Example6">Rolü - <code>Zorunlu</code></label>
              </div>
                  <input type="hidden" name="edit_user_id" value="<?= $takeID ?>">
              <button type="submit" class="btn btn-success btn-block mb-4" style="padding: 15px;">Personeli Kaydet</button>
            </form>
            <!-- end row -->
          </div>
          <!-- footer -->
          <?php require_once("resources/footer.php"); ?>
        </div>
        <!-- end dashboard inner -->
      </div>
    </div>
  </div>

</body>

</html>