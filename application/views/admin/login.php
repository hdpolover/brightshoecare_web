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
                    <p class="text-muted">Masukkan username dan password Anda untuk masuk.</p>
                  </div>
                  <form class="user" method="POST" action="<?= base_url('admin/auth/login') ?>">
                    <?= $this->session->flashdata('flash') ?>
                    <div class="form-group">
                      <label for="username" class="font-weight-bold">Username</label>
                      <input type="text" class="form-control form-control-user" id="username" placeholder="Masukkan Username Anda..." name="username" value="<?= set_value('username') ?>" required>
                      <?= form_error('username', "<small class='text-danger'>", "</small>")  ?>
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
