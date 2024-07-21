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
              <th>Nama Layanan</th>
              <th>Harga</th>
              <th>Deskripsi</th>
              <th>Gambar</th>
              <th width="100px" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            function formatRupiah($amount)
            {
              return 'Rp.' . number_format($amount, 2, ',', '.');
            }
            ?>

            <?php
            $no = 1;
            foreach ($tampil as $t) {
              $id = str_replace(['=', '+', '/'], ['-', '_', '~'], $this->encryption->encrypt($t->id_layanan));
              $idd = $t->id_layanan;
            ?>
              <tr>
                <td align="center"><?= $no ?></td>
                <td><?= $t->nama ?></td>
                <td><?= formatRupiah($t->harga) ?></td>
                <td><?= $t->deskripsi ?></td>
                <td><img src="<?= base_url('/' . $t->gambar) ?>" width="200px" height="200px"></td>
                <td><button class="btn btn-sm btn-warning" title="Edit" data-target="#exampleModalLong<?= $idd ?>" data-toggle="modal">Edit</button>
                  <button href="" onclick="deleteConfirm('<?= base_url('admin/layanan/delete/' . $id) ?>')" class="btn btn-sm btn-danger" title="Hapus" data-target="#modalDelete" data-toggle="modal">Hapus</button>
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
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Tambah Data Layanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="<?= base_url('admin/layanan/add') ?>" enctype="multipart/form-data" class="add-form">
        <div class="modal-body">
          <div class="form-group">
            <label for="kategori_layanan">Kategori Layanan</label>
            <select name="kategori_layanan" class="form-control" id="kategori_layanan" required>
              <?php foreach ($kategori_layanan as $kategori) : ?>
                <option value="<?= $kategori->id_kategori_layanan ?>"><?= $kategori->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="nama">Nama Layanan</label>
            <input type="text" name="nama" placeholder="Nama Layanan" class="form-control" id="nama" required>
          </div>
          <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <input type="text" name="deskripsi" placeholder="Deskripsi" class="form-control" id="deskripsi" required>
          </div>
          <div class="form-group">
            <label for="harga">Harga</label>
            <input type="text" name="harga" placeholder="Harga" class="form-control harga-input" id="harga" required>
          </div>
          <div class="form-group">
            <label for="image">Upload Gambar</label>
            <input type="file" name="image" class="form-control-file" id="image" accept="image/*" required>
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

<!-- Modal Edit -->
<?php foreach ($tampil as $tm) {
  $a = $tm->id_layanan;
  $iid = str_replace(['=', '+', '/'], ['-', '_', '~'], $this->encryption->encrypt($tm->id_layanan));
?>
  <div class="modal fade" id="exampleModalLong<?= $a ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Data Layanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="<?= base_url('admin/layanan/edit') ?>" enctype="multipart/form-data" class="edit-form">
          <div class="modal-body">
            <input type="hidden" name="id_layanan" value="<?= $tm->id_layanan ?>">
            <div class="form-group">
              <label for="nama">Nama Layanan</label>
              <input type="text" name="nama" placeholder="Nama Layanan" class="form-control" id="nama" value="<?= $tm->nama ?>">
              <input type="hidden" name="old_nama" value="<?= $tm->nama ?>">
            </div>
            <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
              <input type="text" name="deskripsi" placeholder="Deskripsi" class="form-control" id="deskripsi" value="<?= $tm->deskripsi ?>">
            </div>
            <div class="form-group">
              <label for="harga1">Harga</label>
              <input type="text" name="harga1" placeholder="Harga1" class="form-control harga-input" id="harga1" value="<?= $tm->harga ?>">
            </div>
            <div class="form-group">
              <label for="image">Gambar</label><br>
              <?php if (!empty($tm->gambar) && file_exists(FCPATH . $tm->gambar)) : ?>
                <img src="<?= base_url($tm->gambar) ?>" alt="Current Image" class="img-fluid mb-2">
                <input type="hidden" name="old_gambar" value="<?= $tm->gambar ?>">
              <?php endif; ?>
              <input type="file" name="image" class="form-control-file" id="image">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-info" id="update">Update</button>
          </div>
        </form>
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

  function formatRupiah(amount) {
    // Your formatting logic here
    // Example logic:
    return 'Rp ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
  }

  document.addEventListener("DOMContentLoaded", function() {
    // Attach event listeners for each harga input field
    var hargaInputs = document.querySelectorAll(".harga-input");

    hargaInputs.forEach(function(hargaInput) {
      hargaInput.addEventListener("input", function() {
        var value = this.value.replace(/[^\d]/g, ""); // Remove non-numeric characters
        if (value) {
          this.value = formatRupiah(value, "Rp. ");
        } else {
          this.value = "";
        }
      });
    });

    function formatRupiah(angka, prefix) {
      var numberString = angka.replace(/[^,\d]/g, "").toString(),
        split = numberString.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        var separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
      }

      rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
      return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
    }

    // Attach form submit event listener to remove formatting before submitting
    var forms = document.querySelectorAll("form.edit-form, form.add-form");

    forms.forEach(function(form) {
      form.addEventListener("submit", function(event) {
        var hargaInput = form.querySelector(".harga-input");
        if (hargaInput) {
          hargaInput.value = hargaInput.value.replace(/[^\d]/g, ""); // Remove formatting before submitting
        }
      });
    });
  });

  // document.addEventListener("DOMContentLoaded", function() {
  //   var hargaInput = document.getElementById("harga")

  //   hargaInput.addEventListener("input", function() {
  //     var value = this.value.replace(/[^\d]/g, ""); // Remove non-numeric characters
  //     if (value) {
  //       this.value = formatRupiah(value, "Rp. ");
  //     } else {
  //       this.value = "";
  //     }
  //   });

  //   function formatRupiah(angka, prefix) {
  //     var numberString = angka.replace(/[^,\d]/g, "").toString(),
  //       split = numberString.split(","),
  //       sisa = split[0].length % 3,
  //       rupiah = split[0].substr(0, sisa),
  //       ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  //     if (ribuan) {
  //       var separator = sisa ? "." : "";
  //       rupiah += separator + ribuan.join(".");
  //     }

  //     rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  //     return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
  //   }

  //   var form = document.querySelector("form");
  //   form.addEventListener("submit", function(event) {
  //     hargaInput.value = hargaInput.value.replace(/[^\d]/g, ""); // Remove formatting before submitting
  //   });
  // });

  // document.addEventListener("DOMContentLoaded", function() {
  //   var hargaInput1 = document.getElementById("harga1")

  //   hargaInput1.addEventListener("input", function() {
  //     var value = this.value.replace(/[^\d]/g, ""); // Remove non-numeric characters
  //     if (value) {
  //       this.value = formatRupiah(value, "Rp. ");
  //     } else {
  //       this.value = "";
  //     }
  //   });

  //   function formatRupiah(angka, prefix) {
  //     var numberString = angka.replace(/[^,\d]/g, "").toString(),
  //       split = numberString.split(","),
  //       sisa = split[0].length % 3,
  //       rupiah = split[0].substr(0, sisa),
  //       ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  //     if (ribuan) {
  //       var separator = sisa ? "." : "";
  //       rupiah += separator + ribuan.join(".");
  //     }

  //     rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  //     return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
  //   }

  //   var form = document.querySelector("form");
  //   form.addEventListener("submit", function(event) {
  //     hargaInput1.value = hargaInput1.value.replace(/[^\d]/g, ""); // Remove formatting before submitting
  //   });
  // });
</script>