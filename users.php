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
        <?php 
          $dataclass = new DatabaseClass;
          $GetUsers= $dataclass->GetPersonel(0);
        ?>
        <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Personeller Listesi</h2>
                </div>
              </div>
            </div>
            <table style="background-color: white;" class="table" id="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Personel Adı ve Soyadı</th>
                  <th scope="col">İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach($GetUsers as $row) {
                ?>
                  <tr>
                    <th  scope="row"><?= $row["kullanici_id"] ?></th>
                    <td><span><?= $row["kullanici_isim"]." ".$row["kullanici_soyisim"] ?></span></td>
                    <td><span><button data-id="<?= $row["kullanici_id"]; ?>" name="review" title="İncele" class="btn purple-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <a href="edit-user.php?id=<?= $row["kullanici_id"] ?>"><button name="edit_personel" title="Düzenle" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></button></a>
                    <button class="btn" name="delete-personel" data-id="<?= $row["kullanici_id"]; ?>" < style="background-color: #F31212" title="Sil"><i class="fa-solid fa-trash"></i></button></span></td>
                    
                  </tr>
                <?php } ?>
              </tbody>
            </table>
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
<script>
$('#table').DataTable({
  language: {
      url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json'
    }
});
</script>
