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
                  <h2>Personel Ekle</h2>
                </div>
              </div>
            </div>
            <!-- row -->

            <!-- 2 column grid layout with text inputs for the first and last names -->
            <form id="personel_add_form" onsubmit="return false;">
              <div class="row mb-4">
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" id="isim" placeholder="İsim" class="form-control" />
                    <label class="form-label" for="form6Example1">İsim - <code>Zorunlu</code></label>
                  </div>
                </div>
                <div class="col">
                  <div data-mdb-input-init class="form-outline">
                    <input type="text" id="soyisim" placeholder="Soyisim" class="form-control" />
                    <label class="form-label" for="form6Example2">Soyisim - <code>Zorunlu</code></label>
                  </div>
                </div>
              </div>

              <!-- Text input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="callintech_mail" placeholder="Callintech Mail" class="form-control" />
                <label class="form-label" for="form6Example3">Callintech mail adresi <code>Zorunlu Değil</code></label>
              </div>

              <!-- Text input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="callintech_sifre" placeholder="Callintech Sifre" class="form-control" />
                <label class="form-label" for="form6Example4">Callintech şifresi <code>Zorunlu Değil</code></label>
              </div>

              <!-- Email input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="mail_sender_nick" placeholder="Mail Sender kullanıcı adı" class="form-control" />
                <label class="form-label" for="form6Example5">Mail Sender kullanıcı adı <code>Zorunlu Değil</code></label>
              </div>

              <!-- Number input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="mail_sender_sifre" placeholder="Mail Sender Şifre" class="form-control" />
                <label class="form-label" for="form6Example6">Mail Sender şifre <code>Zorunlu Değil</code> </label>
              </div>

              <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" id="slack_mail" placeholder="Slack Mail" class="form-control" />
                <label class="form-label" for="form6Example6">Slack Mail - <code>Zorunlu</code></label>
              </div>

              <div data-mdb-input-init class="form-outline mb-4">
                <select name="rol" id="rol" class="form-control">
                  <option value=""></option>
                  <option value="3">asdsa</option>
                  <option value=""></option>
                </select>
                <label class="form-label" for="form6Example6">Rolü - <code>Zorunlu</code></label>
              </div>


              <button type="submit" class="btn btn-success btn-block mb-4" style="padding: 15px;">Personeli Kaydet</button>
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