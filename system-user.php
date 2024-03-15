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
          $GetSystemUsers= $dataclass->GetSystemUsers();
        ?>
        <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Sistem Kullanıcıları Listesi</h2>
                </div>
              </div>
            </div>
            <table style="background-color: white;" class="table" id="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Sistem Kullanıcı İsim Soyisim</th>
                  <th scope="col">Sistem Kullanıcı KullanıcıAdı</th>
                  <th scope="col">Sistem Kullanıcı Rolü</th>
                  <th scope="col">Sistem Kullanıcı Ekleyen</th>
                  <th scope="col">Sistem Kullanıcı Eklenme tarihi</th>
                  <th scope="col">İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach($GetSystemUsers as $row) {
                ?>
                  <tr>
                    <th  scope="row"><?= $row["sistem_k_id"]; ?></th>
                    <td><span><?= $row["sistem_k_isim"]." ".$row["sistem_k_soyisim"]; ?></span></td>
                    <td><span><?= $row["sistem_k_kullaniciadi"]; ?></span></td>
                    <td><span style="background-color: #2874E1; padding: 5px; border-radius: 20px; color:white;"><?= $dataclass->SystemRole($row["sistem_k_rol"]) ?></span></td>
                    <td><span><?= $row["sistem_k_kimekledi"]; ?></span></td>
                    <td><span class="text-center"><?= DateFormater($row["sistem_k_kayittarihi"]);  ?></span></td>
                    <td><span><a href="edit-system-user.php?id=<?= $row["sistem_k_id"];?>"><button class="btn purple-button" title="Düzenle"><i class="fa-regular fa-pen-to-square"></i></button></a> <button title="Sil" class="btn btn-danger delete-system-user" data-id="<?= $row["sistem_k_id"]; ?>" ><i class="fa-solid fa-trash"></i></button></span></td>
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
