<?php require_once("resources/header.php"); 
if(!$_GET["id"] && !is_numeric($_GET["id"])){
  header("Location: objects.php");
}
else{
  $id = Get("id");
  $databaseclass = new DatabaseClass();
  $write_object_data = $databaseclass->GetObjects(1,$id);
}
if(!$write_object_data){
  header("Location: objects.php");
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
        $databaseclass = new DatabaseClass();
        $category_write = $databaseclass->GetCategory();
        $status_write = $databaseclass->CheckStatus(2);
        $system_write = $databaseclass->GetPersonel(0);
        ?>
        <!-- end topbar -->
        <!-- dashboard inner -->
        <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Cihaz Düzenleme</h2>
                </div>
              </div>
            </div>
            <!-- row -->

            <!-- 2 column grid layout with text inputs for the first and last names -->
            <form id="object_update_form" onsubmit="return false;">
              <div class="row mb-4">
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" value="<?= $write_object_data["esya_seri_no"] ?>" name="cihaz_seri_no" id = "cihaz_seri_no" placeholder="Cihaz Seri Numarası" class="form-control" />
                    <label class="form-label" for="form6Example1">Cihaz Seri No - <code>Zorunlu</code></label>
                  </div>
                </div>
              </div>

              <!-- Select Box -->
              <div data-mdb-input-init class="form-outline mb-4">
                <div data-mdb-input-init class="form-outline mb-4">
                  <select name="cihaz_kategorisi" id="cihaz_kategori" class="form-control">
                    <?php foreach ($category_write as $row ) {
                      if($row["kategori_id"] == $write_object_data["esya_kategori_id"]){
                        echo '<option value='.$row["kategori_id"].' selected>'.$row["kategori_isim"].'</option>';
                      }
                      else{
                      echo '<option value='.$row["kategori_id"].'>'.$row["kategori_isim"].'</option>';
                      }
                    } ?>
                    
                  </select>
                  <label class="form-label" for="form6Example3">Cihaz Kategorisi - <code>Zorunlu</code></label>
                </div>
                <div class="row mb-4">
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <textarea id="cihaz_aciklama" name="cihaz_aciklama" placeholder="Cihaz İçin Açıklama" class="form-control" ><?= $write_object_data["esya_aciklama"]; ?></textarea>
                    <label class="form-label" for="form6Example1">Cihazın Açıklaması - <code>Zorunlu</code></label>
                  </div>
                </div>
              </div>
                <!-- Select Box -->
                <div data-mdb-input-init class="form-outline mb-4">
                  <div data-mdb-input-init class="form-outline mb-4">
                    <select name="cihaz_durumu" id="cihaz_durum" class="form-control">
                    <?php foreach ($status_write as $row ) {
                      if($status_write["durum_id"] == $write_object_data["esya_durumu"]){
                        echo '<option value='.$row["durum_id"].' selected>'.$row["durum_isim"].'</option>';
                      }
                      else{
                      echo '<option value='.$row["durum_id"].'>'.$row["durum_isim"].'</option>';
                      }
                    } ?>
                    </select>
                    <label class="form-label" for="form6Example3">Cihaz Durumu - <code>Zorunlu</code></label>
                  </div>
                  <!-- Select Box -->
                  <div data-mdb-input-init class="form-outline mb-4">
                    <div data-mdb-input-init class="form-outline mb-4">
                      <select name="cihaz_zimmet_kisi" id="cihaz_zimmet_kisi" class="form-control">
                      <?php foreach ($system_write as $row ) {
                        if($row["kullanici_id"] == $write_object_data["esya_ait_personel_id"]){
                          echo '<option value='.$row["kullanici_id"].' selected>'.CharUpper($row["kullanici_isim"])." ".CharUpper($row["kullanici_soyisim"]).'</option>';
                        }
                        else{
                        echo '<option value='.$row["kullanici_id"].'>'.CharUpper($row["kullanici_isim"])." ".CharUpper($row["kullanici_soyisim"]).'</option>';
                        }
                      } ?>
                      </select>
                      <label class="form-label" for="form6Example3">Cihazın Zimmetlendiği kişi - <code>Zorunlu</code></label>
                    </div>
                    <input type="hidden" id="cihaz_id" value="<?= $id ?>">
                    <button type="submit" class="btn btn-success btn-block mb-4" style="padding: 15px;">Değişiklikleri Kaydet</button>
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