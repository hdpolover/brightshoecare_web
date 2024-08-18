<body id="page-top" style="background-image: url('<?= base_url('assets/users/') ?>img/baru.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh; margin: 0;">

  <div class="container mt-5" style="background-color: rgba(255, 255, 255, 0.8); border-radius: 8px; padding: 2rem; max-width: 600px;">
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-12 col-lg-12 col-md-12">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-4">
                  <div class="text-center mb-4">
                    <h1 class="h4 text-gray-900 font-weight-bolder">Selamat Datang!</h1>
                    <p class="text-muted">Masukkan email dan password Anda untuk masuk.</p>
                  </div>
                  <form class="user" method="POST" action="<?= base_url('pelanggan/login') ?>">
                    <?= $this->session->flashdata('flash') ?>
                    <div class="form-group">
                      <label for="email" class="font-weight-bold">Email</label>
                      <input type="email" class="form-control form-control-user" id="email" placeholder="Masukkan Email Anda..." name="email" value="<?= set_value('email') ?>" required>
                      <?= form_error('email', "<small class='text-danger'>", "</small>")  ?>
                    </div>
                    <div class="form-group">
                      <label for="password" class="font-weight-bold">Password</label>
                      <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password" required>
                      <?= form_error('password', "<small class='text-danger'>", "</small>") ?>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
