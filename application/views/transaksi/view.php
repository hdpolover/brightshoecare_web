<style type="text/css">
  .progress-container {
    display: flex;
    justify-content: space-between;
    width: 80%;
    max-width: 800px;
    position: relative;
  }

  .step {
    text-align: center;
    position: relative;
    flex: 1;
  }

  .step .circle {
    width: 30px;
    height: 30px;
    margin: 0 auto;
    background-color: #ddd;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-weight: bold;
    color: #fff;
    margin-bottom: 10px;
  }

  .step .label {
    font-size: 12px;
    color: #333;
  }

  .step.active .circle {
    background-color: #4caf50;
  }

  .step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 15px;
    left: 50%;
    width: 100%;
    height: 3px;
    background-color: #ddd;
    z-index: -1;
  }

  .step.active:not(:last-child)::after {
    background-color: #4caf50;
  }
</style>


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
        <a class="btn btn-sm btn-primary text-light" href="<?= base_url('admin/transaksi/tambah') ?>"><i class="fa fa-plus"></i> <b>Tambah Transaksi</b></a>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th width="20px">No. Transaksi</th>
              <th>Tanggal Pemesanan</th>
              <th style="text-align: center;">Status Pesanan</th>
              <th>Status Pembayaran</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($tampil as $t) {
              $id = str_replace(['=', '+', '/'], ['-', '_', '~'], $this->encryption->encrypt($t->id_transaksi));

              foreach ($pembayaran as $p) {
                if ($p->id_transaksi == $t->id_transaksi) {
                  $status_pembayaran = $p->status;
                }
              }

              foreach ($status as $s) {
                if ($s->id_transaksi == $t->id_transaksi) {
                  $status_pesanan = $s;
                }
              }
            ?>
              <tr>
                <td><?= $t->no_transaksi ?></td>
                <td><?= $t->tgl_dibuat ?></td>
                <td>
                  <div class="progress-container">
                    <div class="step <?= ($status_pesanan->dibuat == 1) ? 'active' : ''; ?>">
                      <div class="circle">1</div>
                      <div class="label">Menunggu</div>
                    </div>
                    <div class="step <?= ($status_pesanan->menunggu == 1) ? 'active' : ''; ?>">
                      <div class="circle">2</div>
                      <div class="label">Proses</div>
                    </div>
                    <div class="step <?= ($status_pesanan->siap == 1) ? 'active' : ''; ?>">
                      <div class="circle">3</div>
                      <div class="label">Siap </div>
                    </div>
                    <div class="step <?= ($status_pesanan->selesai == 1) ? 'active' : ''; ?>">
                      <div class="circle">4</div>
                      <div class="label">Selesai</div>
                    </div>
                  </div>
                </td>
                <td><?= ($status_pembayaran == 1) ? 'Lunas' : 'Belum Lunas'; ?></td>
                <td>
                  <!-- <button class="btn btn-sm btn-info viewDetail" title="Detail" id="viewDetail" value="<?= $id ?>"><i class="fa fa-eye"></i></button> -->
                  <a href="<?= base_url('admin/transaksi/detail/' . $id) ?>" class="btn btn-sm btn-primary" title="Detail"><i class="fa fa-eye"></i></a>
                 <!-- <a href="<?= base_url('admin/transaksi/delete/' . $id) ?>" class="btn btn-sm btn-danger" title="Print" title="Hapus" data-target="#modalDelete" data-toggle="modal"><i class="fa fa-trash"></i></a> -->
                </td>
              </tr>
            <?php
            } ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>


  <!-- Modal -->
  <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLongTitle"><strong>Detail Data Laundry</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-hover">
            <tr>
              <td class="col-sm-3"><strong>No. Transaksi</strong></td>
              <td class="col-sm-9"> <span id="id_transaksi"></span></td>
            </tr>
            <tr>
              <td><strong>Nama</strong></td>
              <td><span id='nama'></span></td>
            </tr>
            <tr>
              <td><strong>Tanggal Transaksi</strong></td>
              <td><span id='tgl_transaksi'></span></td>
            </tr>
            <tr>
              <td><strong>Jam Transaksi</strong></td>
              <td><span id='jam_transaksi'></span></td>
            </tr>
            <tr>
              <td><strong>Paket</strong></td>
              <td><span id='paket_transaksi'></span></td>
            </tr>
            <tr>
              <td><strong>Jumlah/Berat</strong></td>
              <td><span id='berat_jumlah'></span></td>
            </tr>
            <tr>
              <td><strong>Detail Pakaian</strong></td>
              <td>
                <div class="ml-2"><span id='detail'></span></div>
              </td>
            </tr>
            <tr>
              <td><strong>Total Transaksi</strong></td>
              <td><span id='total_transaksi'></span></td>
            </tr>

          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

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
          <a href="<?= base_url('admin/transaksi/delete/' . $id) ?>" type="button" class="btn btn-danger" id="hapus">Hapus</a>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Delete -->


  <script>
    $(document).ready(function() {
      $('.viewDetail').click(function() {
        let id = $(this).val();
        $.ajax({
          type: 'GET',
          url: `<?= base_url('admin/transaksi/detail/') ?>${id}`,
          success: function(res) {
            res = JSON.parse(res);
            if (res.success) {
              var detail = '';
              for (var item of res.data.detail) {
                detail += `<li>${item.nama_d} (${item.jumlah_d})</li>`;
              };

              $('#modalView').modal('show');
              $('#id_transaksi').html(res.data.id_transaksi);
              $('#nama').html(res.data.nama);
              $('#tgl_transaksi').html(res.data.tgl_transaksi);
              $('#jam_transaksi').html(res.data.jam_transaksi);
              $('#paket_transaksi').html(res.data.paket_transaksi);
              $('#berat_jumlah').html(res.data.berat_jumlah);
              $('#total_transaksi').html(res.data.total_transaksi);
              $('#detail').html(detail)
            }
          }
        });

      });

    });
  </script>