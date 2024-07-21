<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-5 text-gray-800">Overview Data <?= $section ?></h1>
  <?= $this->session->flashdata('flash') ?>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
      <div>
        <span class="m-0 font-weight-bold text-primary">Data <?= $section ?></span>
      </div>
      <div class="ml-auto">
        <a class="btn btn-sm btn-primary text-light" href="<?= base_url('admin/pelanggan/add') ?>"><i class="fa fa-plus"></i> <b>Tambah</b></a>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="30px">No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Alamat</th>
              <th>No. HP</th>
              <th>Tanggal Daftar</th>
              <th width="100px" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($tampil as $t) {
              if ($t->username === 'admin') {
                continue; // Skip this iteration if the name is 'admin'
              }
              $id = str_replace(['=', '+', '/'], ['-', '_', '~',], $this->encryption->encrypt($t->id));
            ?>
              <tr>
                <td align="center"><?= $no++ ?></td>
                <td><?= $t->nama ?></td>
                <td><?= $t->email ?></td>
                <td><?= $t->alamat ?></td>
                <td><?= $t->no_hp ?></td>
                <td><?= $t->tgl_dibuat ?></td>
                <td>
                  <a href="<?= base_url('admin/pelanggan/edit/' . $id) ?>" class="btn btn-sm btn-warning" title="Edit Data">Edit Data</a>
                  <a href="<?= base_url('admin/pelanggan/reset/' . $id) ?>" class="btn btn-sm btn-info" title="Reset Password">Reset Password</a>
                  <!-- <a href="" onclick="deleteConfirm('<?= base_url('admin/pelanggan/delete/' . $id) ?>')" class="btn btn-sm btn-danger" title="Hapus Data" data-target="#deleteModal" data-toggle="modal">Hapus</a> -->
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>


<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold">Hapus Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin ingin menghapus data ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <a class="btn btn-sm btn-danger btn-ok" id="btn-delete">Hapus</a>
      </div>
    </div>
  </div>
</div>

<script>
  function deleteConfirm(url) {
    $('#btn-delete').attr('href', url);
    $('#deleteModal').modal();
  };
</script>