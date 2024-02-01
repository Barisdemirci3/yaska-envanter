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
        <?php require_once("resources/topbar.php"); 
        $databaseclass = new DatabaseClass();
        $category_write = $databaseclass->GetCategory();
        $status_write = $databaseclass->CheckStatus(2);
        $system_write = $databaseclass->CheckSistemKullanici("",0);
        ?>
        <!-- end topbar -->
        <!-- dashboard inner -->
        <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Sisteme Cihaz Ekle</h2>
                </div>
              </div>
            </div>
            <!-- row -->

            <!-- 2 column grid layout with text inputs for the first and last names -->
            <form id="object_add_form" onsubmit="return false;">
              <div class="row mb-4">
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" id="cihaz_seri_no" placeholder="Cihaz Seri Numarası" class="form-control" />
                    <label class="form-label" for="form6Example1">Cihaz Seri No - <code>Zorunlu</code></label>
                  </div>
                </div>
              </div>

              <!-- Select Box -->
              <div data-mdb-input-init class="form-outline mb-4">
                <div data-mdb-input-init class="form-outline mb-4">
                  <select name="cihaz_kategorisi" id="cihaz_kategori" class="form-control">
                    <?php foreach ($category_write as $row ) {
                      echo '<option value='.$row["kategori_id"].'>'.$row["kategori_isim"].'</option>';
                    } ?>
                    
                  </select>
                  <label class="form-label" for="form6Example3">Cihaz Kategorisi - <code>Zorunlu</code></label>
                </div>
                <div class="row mb-4">
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <textarea id="cihaz_aciklama" placeholder="Cihaz İçin Açıklama" class="form-control" /> </textarea>
                    <label class="form-label" for="form6Example1">Cihazın Açıklaması - <code>Zorunlu</code></label>
                  </div>
                </div>
              </div>
                <!-- Select Box -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <div data-mdb-input-init class="form-outline mb-4">
                    <select name="cihaz_durumu" id="cihaz_durum" class="form-control">
                    <?php foreach ($status_write as $row ) {
                      echo '<option value='.$row["durum_id"].'>'.$row["durum_isim"].'</option>';
                    } ?>
                    </select>
                    <label class="form-label" for="form6Example3">Cihaz Durumu - <code>Zorunlu</code></label>
                  </div>
                  <!-- Select Box -->
                  <div data-mdb-input-init class="form-outline mb-4">
                    <div data-mdb-input-init class="form-outline mb-4">
                      <select name="cihaz_ekleyen_kisi" id="cihaz_ekleyen_kisi" class="form-control">
                      <?php foreach ($system_write as $row ) {
                      echo '<option value='.$row["sistem_k_id"].'>'.$row["sistem_k_kullaniciadi"].'</option>';
                    } ?>
                      </select>
                      <label class="form-label" for="form6Example3">Cihazı Ekleyen Kişi - <code>Zorunlu</code></label>
                    </div>
                    <!-- File UP -->
                    <div data-mdb-input-init class="form-outline mb-4">
                      <input type="text" id="mail_sender_sifre" placeholder="Mail Sender Şifre" class="form-control" />
                      <label class="form-label" for="form6Example6">Cihazın var ise fotoğrafı - <code>Zorunlu Değil</code> </label>
                    </div>
                    <!-- File UP -->
                    <button type="submit" class="btn btn-success btn-block mb-4" style="padding: 15px;">Cihazı Kaydet</button>
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