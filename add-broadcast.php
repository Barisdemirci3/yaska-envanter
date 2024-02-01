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
                  <h2>Duyuru</h2>
                </div>
              </div>
            </div>
            <!-- row -->
              <?php $dbclass = new DatabaseClass;
                $write_text = $dbclass->GetUpdateText();
              ?>
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <form id="duyuru" onsubmit="return false;">
              <div class="row mb-4">
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" value="<?= $write_text["duyuru_text"]; ?>" id="duyuru-isim" placeholder="Duyuru" class="form-control" />
                    <label class="form-label" for="form6Example1">Duyuru - <code>Maksimum 90 karakter</code>  </label>
                  </div>
                  <button type="submit" class="btn btn-success btn-block mb-4" style="padding: 15px;">Duyuruyu Kaydet</button>
                </div>
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