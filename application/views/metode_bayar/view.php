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
        <a class="btn btn-sm btn-primary text-light" href="" data-target="#addModal" data-toggle="modal"><i class="fa fa-plus"></i> <b>Tambah</b></a>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="30px">No</th>
              <th>Nama Metode Pembayaran</th>
              <th>Deskripsi</th>
              <th>Kategori</th>
              <th width="100px" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($tampil as $t) {
              $id = str_replace(['=', '+', '/'], ['-', '_', '~'], $this->encryption->encrypt($t->id_metode_bayar));
              $idd = $t->id_metode_bayar;
            ?>
              <tr>
                <td align="center"><?= $no ?></td>
                <td><?= $t->nama ?></td>
                <td><?= $t->deskripsi ?></td>
                <td><?= $t->kategori ?></td>
                <td><button class="btn btn-sm btn-warning" title="Edit" data-target="#exampleModalLong<?= $idd ?>" data-toggle="modal">Edit</button>
                  <button href="" onclick="deleteConfirm('<?= base_url('admin/metode_bayar/delete/' . $id) ?>')" class="btn btn-sm btn-danger" title="Hapus" data-target="#modalDelete" data-toggle="modal">Hapus</button>
                </td>
              </tr>

            <?php $no++;
            }; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>


<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Tambah Data Metode Pembayaran </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?= base_url('admin/metode_bayar/add') ?>">
        <div class="modal-body">
          <div class="form-group">
            <label for="nama">Nama Metode Pembayaran</label>
            <input type="text" name="nama" placeholder="Nama Metode Pembayaran" class="form-control" id="nama" required>
          </div>
          <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <input type="text" name="deskripsi" placeholder="Deskripsi" class="form-control" id="deskripsi" required>
          </div>
          <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" class="form-control" id="kategori" required>
              <option value="transfer">Transfer</option>
              <option value="tunai">Tunai</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-info" id="add">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal Add -->



<!-- Modal Edit-->
<?php foreach ($tampil as $tm) {
  $a    = $tm->id_metode_bayar;
  $iid   = str_replace(['=', '+', '/'], ['-', '_', '~'], $this->encryption->encrypt($tm->id_metode_bayar));
?>
  <div class="modal fade" id="exampleModalLong<?= $a ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="<?= base_url('admin/kategori_layanan/edit') ?>">
          <div class="modal-body">
            <div class="form-group">
              <label for="nama">Nama Metode Pembayaran</label>
              <input type="hidden" name="oldNama" value="<?= $tm->nama ?>">
              <input type="text" name="nama" placeholder="Nama Metode Pembayaran" class="form-control" id="nama" value="<?= $tm->nama ?>">
            </div>
            <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
              <input type="text" name="deskripsi" placeholder="Deskripsi" class="form-control" id="deskripsi" value="<?= $tm->deskripsi ?>">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-sm btn-info" id="add">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  </div>
<?php } ?>

<!-- End Modal Edit -->


<!-- Modal Delete -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Anda Yakin ingin Menghapus Data?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <a type="button" class="btn btn-danger" id="hapus">Hapus</a>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Delete -->


<script>
  function deleteConfirm(url) {
    $('#hapus').attr('href', url);
    $('#modalDelete').modal();
  }
</script>