<?= $this->session->flashdata('flash') ?>

<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg-11">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Update Data <?= $section ?></h1>
            </div>
            <form class="user" method="POST" action="<?= base_url('admin/pelanggan/update') ?>">
              <?php foreach ($tampil as $t) : ?>

                <div class="form-group mb-3">
                  <label class="text-dark">Nama Lengkap</label>
                  <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" value="<?= set_value('nama', $t->nama) ?>">
                  <?= form_error('nama', "<small class='text-danger'>", '</small>') ?>
                </div>
                <div class="form-group mb-3">
                  <label class="text-dark">Email</label>
                  <input type="text" class="form-control" placeholder="Email" name="email" value="<?= set_value('email', $t->email) ?>">
                  <?= form_error('email', "<small class='text-danger'>", '</small>') ?>
                </div>
                <div class="form-group mb-3">
                  <label class="text-dark">No. HP</label>
                  <input type="number" class="form-control" placeholder="No. HP" name="no_hp" value="<?= set_value('no_hp', $t->no_hp) ?>">
                  <?= form_error('no_hp', "<small class='text-danger'>", '</small>') ?>
                </div>
                <div class="form-group mb-3">
                  <label class="text-dark">Alamat</label>
                  <input type="text" class="form-control" placeholder="Alamat" name="alamat" value="<?= set_value('alamat', $t->alamat) ?>">
                  <?= form_error('alamat', "<small class='text-danger'>", '</small>') ?>
                </div>
                <hr>
                <div class="d-flex">
                  <button type="submit" class="btn btn-success mr-3">Update</button>
                <?php endforeach ?>
            </form>
            <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


</div>