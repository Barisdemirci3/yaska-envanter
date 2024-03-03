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
        <?php $getRole = new DatabaseClass;
       $writerole = $getRole->GetRols();
        ?>
        <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Rol Listesi</h2>
                </div>
              </div>
            </div>
            <table style="background-color: white;" class="table" id="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Rol İsim</th>
                  <th scope="col">İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach($writerole as $row) {
                ?>
                  <tr>
                    <th  scope="row"><span><?= $row["rol_id"]; ?></span></th>
                    <td><span><?= $row["rol_name"]; ?></span></td>
                    <td><button title="Düzenle" class="btn purple-button" name="rol_edit" data-id="<?= $row["rol_id"]; ?>" style><i class="fa-solid fa-pen-to-square"></i></button> <button title="Sil" data-id="<?= $row["rol_id"]; ?>" name="sil" id="sil" class="btn btn-danger delete-button-rol"><i class="fa-solid fa-trash"></i></button></td>
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
