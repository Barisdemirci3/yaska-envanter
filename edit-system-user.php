<?php
function RoleWrite($rolid)
{
  switch ($rolid) {
    case '0':
      return '<option value="0" selected>Görüntüleyici</option> <option value="1">Moderatör</option> <option value="2">Admin</option> ';
      break;
    case '1':
      return '<option value="0">Görüntüleyici</option> <option value="1" selected>Moderatör</option> <option value="2">Admin</option> ';
      break;
    case '2':
      return '<option value="0">Görüntüleyici</option> <option value="1">Moderatör</option> <option selected value="2">Admin</option>';
      break;
  }
};

require_once("resources/header.php");
if (!$_GET["id"]) {
  header("Location: system-user.php?id=nodata");
} else {
  $id = Get("id");
  if (empty($id)) {
    header("Location: system-user.php?id=empty");
  } else {
    if (!(int)$id) {
      header("Location: system-user.php?id=noint");
    } else {
      $dataclass = new DatabaseClass;
      $GetSystemUser = $dataclass->CheckUser($id);
      if (empty($GetSystemUser)) {
        header("Location: system-user.php?id=notfound");
      }
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
        <?php require_once("resources/topbar.php"); ?>
        <!-- end topbar -->
        <!-- dashboard inner -->
        <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Sistem Kullanıcısı Düzenle</h2>
                </div>
              </div>
            </div>
            <!-- row -->

            <!-- 2 column grid layout with text inputs for the first and last names -->
            <form id="user_update_form" onsubmit="return false;" enctype="multipart/form-data">
              <div class="row mb-4">
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" value="<?= $GetSystemUser["sistem_k_isim"]; ?>" id="name" placeholder="İsim" class="form-control" />
                    <label class="form-label" for="form6Example1">İsim - <code>Zorunlu</code></label>
                  </div>
                </div>
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" id="surname" placeholder="Soyisim" value="<?= $GetSystemUser["sistem_k_soyisim"]; ?>" class="form-control" />
                    <label class="form-label" for="form6Example2">Soyisim - <code>Zorunlu</code></label>
                  </div>
                </div>
              </div>

              <!-- Text input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="nickname" placeholder="Kullanıcı Adı" value="<?= $GetSystemUser["sistem_k_kullaniciadi"]; ?>" class="form-control" />
                <label class="form-label" for="form6Example3">Kullanıcı Adı - <code>Zorunlu</code></label>
              </div>

              <div data-mdb-input-init class="form-outline mb-4">
                <select name="rol" id="rol" class="form-control">
                  <?= RoleWrite($GetSystemUser["sistem_k_rol"]); ?>
                </select>
                <label class="form-label" for="form6Example6">Rolü - <code>Zorunlu</code></label>
              </div>

              <div data-mdb-input-init class="form-outline mb-4">
                <input type="file" id="file" class="form-control" />
                <label class="form-label" for="form6Example6">Profil Fotoğrafı - <code>Zorunlu Değil</code></label>
              </div>
              <div>
                <label class="form-label">Varsayılan Profil Fotoğrafı:</label> <br>
                <img src="<?= $GetSystemUser["sistem_k_profil"] ?>" width="256px" height="256px" alt="" style="margin:20px;">
              </div>
            <input type="hidden" id="user_id" value="<?= $GetSystemUser["sistem_k_id"]; ?>">

              <button type="submit" class="btn btn-success btn-block mb-4" style="padding: 15px;">Sistem Kullanıcısını Güncelle</button>
            </form>
            <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Şifre Değiştir</h2>
                </div>
              </div>
            </div>
            <!-- row -->

            <!-- 2 column grid layout with text inputs for the first and last names -->
            <form id="user_update_password" onsubmit="return false;">
              <div class="row mb-4">
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="password" id="user_password" placeholder="Şifre" class="form-control" />
                    <label class="form-label" for="form6Example1">Şifre - <code>Zorunlu</code></label>
                    <input type="hidden" name="user_id" value="<?= $id ?>">
              <button type="submit" class="btn btn-success btn-block mb-4" style="padding: 15px;">Şifreyi Değiştir</button>
            </form>
            <!-- end row -->
          </div>
          <!-- footer -->
          <?php require_once("resources/footer.php"); ?>
        </div>
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