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
        $writedata = $databaseclass->GetObjects(0,0);
        ?>
        <!-- end topbar -->
        <!-- dashboard inner -->

        <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Cihaz Listesi</h2>
                </div>
              </div>
            </div>
            <table style="background-color: white;" class="table" id="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Cihaz seri numarası</th>
                  <th scope="col">Cihaz fotoğrafı</th>
                  <th scope="col">İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($writedata as $row) {?>
                  <tr>
                    <th  scope="row"><?= $row["esya_id"]; ?></th>
                    <td><span><?= $row["esya_seri_no"] ?></span></td>
                    <td><span><?= $row["esya_fotograf"]; ?></span></td>
                    <td><span><button data-id="<?= $row["esya_id"]; ?>" name="review-object" title="İncele" class="btn purple-button" ><i class="fa-solid fa-magnifying-glass"></i></button> <button data-id="" name="edit-object" title="Düzenle" class="btn btn-primary" ><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i></button> <button class="btn" name="delete-object" data-id="<?= $row["esya_id"]; ?>" < style="background-color: #F31212" title="Sil"><i class="fa-solid fa-trash"></i></button></span></td>
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
