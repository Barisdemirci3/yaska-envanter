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
        $writedata = $databaseclass->GetLogs();
        ?>
        <!-- end topbar -->
        <!-- dashboard inner -->

        <div class="midde_cont">
          <div class="container-fluid">
            <div class="row column_title">
              <div class="col-md-12">
                <div class="page_title">
                  <h2>Log Listesi</h2>
                </div>
              </div>
            </div>
            <table style="background-color: white;" class="table" id="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Log Metini</th>
                  <th scope="col">Log oluşturulma tarihi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($writedata as $row) {?>
                  <tr>
                    <th  scope="row"><?= $row["log_id"]; ?></th>
                    <td><?= $row["log_metin"] ?></td>
                    <td><?= $databaseclass->DateFormater($row["log_olusturulma_tarih"])?></td>
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
