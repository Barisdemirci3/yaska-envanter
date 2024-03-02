<?php require_once("resources/header.php"); ?>

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
                  <h2>Sisteme Kullanıcı Ekle</h2>
                </div>
              </div>
            </div>
            <!-- row -->

            <!-- 2 column grid layout with text inputs for the first and last names -->
            <form id="user_add_form" onsubmit="return false;" enctype="multipart/form-data" >
              <div class="row mb-4">
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" id="name" placeholder="İsim" class="form-control" />
                    <label class="form-label" for="form6Example1">İsim - <code>Zorunlu</code></label>
                  </div>
                </div>
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" id="surname" placeholder="Soyisim" class="form-control" />
                    <label class="form-label" for="form6Example2">Soyisim - <code>Zorunlu</code></label>
                  </div>
                </div>
              </div>

              <!-- Text input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="nickname" placeholder="Kullanıcı Adı" class="form-control" />
                <label class="form-label" for="form6Example3">Kullanıcı Adı - <code>Zorunlu</code></label>
              </div>

              <!-- Text input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" placeholder="Şifre" id="password" class="form-control" />
                <label class="form-label" for="form6Example4">Şifre - <code>Zorunlu</code></label>
              </div>

              <div data-mdb-input-init class="form-outline mb-4">
                <select name="rol" id="rol" class="form-control">
                  <option value="0">Görüntüleyici</option>
                  <option value="1">Düzenleyici</option>
                  <option value="2">Admin</option>
                </select>
                <label class="form-label" for="form6Example6">Rolü - <code>Zorunlu</code></label>
              </div>

              <div data-mdb-input-init class="form-outline mb-4">
                <input type="file" id="file" class="form-control" />
                <label class="form-label" for="form6Example6">Profil Fotoğrafı - <code>Zorunlu Değil</code></label>
              </div>


              <button type="submit" class="btn btn-success btn-block mb-4" style="padding: 15px;">Sisteme Kullanıcı Ekle</button>
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