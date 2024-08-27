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

<!-- Search -->
<section class="py-5">
  <div class="container pt-5">
    <div class="row">
      <div class="col">
        <form method="GET" action="<?= base_url('cari') ?>" autocomplete="off">
          <div class="form-row">
            <div class="col-12 col-md-9 mb-2 mb-md-0">
              <input type="text" class="form-control form-control-lg bg-light" placeholder="Masukkan No. Transaksi Anda..." name="no_transaksi">
            </div>
            <div class="col-12 col-md-2">
              <button type="submit" class="btn btn-block btn-lg btn-primary">Cari!</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Result -->
<section class="pb-5 bg-light" style="min-height: 100px">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="mx-auto pt-4 pb-2">
          <?php if ($tampil == null) : ?>
            <div align="center">
              <p class="mt-2 font-weight-bold" style="color: #6C7A89">Mulai lacak status cucian sepatu Anda dengan memasukkan No. Transaksi pada form di atas.</p>
              <img src="<?= base_url('assets/users/') ?>img/Searching.png" width="200rem">
            </div>
          <?php elseif ($tampil == 'noData') : ?>
            <div align="center">
              <img src="<?= base_url('assets/users/') ?>img/notfound.png" width="300px">
            </div>
          <?php else : ?>
            <div id="toPrint" class="card shadow mb-4">
              <div class="card-header py-3 d-flex">
                <div>
                  <span id="file_name" class="m-0 font-weight-bold text-primary">Transaksi #<?= $transaksi->no_transaksi; ?></span>
                </div>

              </div>
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <tr>
                    <td class="col-sm-3"><strong>No. Transaksi</strong></td>
                    <td class="col-sm-9"> <span><?= $transaksi->no_transaksi; ?></span></td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Transaksi</strong></td>
                    <td><span><?= $transaksi->tgl_dibuat; ?></span></td>
                  </tr>
                  <tr>
                    <td><strong>Nama Pelanggan</strong></td>
                    <td><span><?= $pelanggan->nama; ?></span></td>
                  </tr>
                  <tr>
                    <td><strong>Detail Pesanan</strong></td>
                    <td><span>
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Jenis Layanan</th>
                              <th>Jumlah</th>
                              <th>Harga</th>
                              <th>Sub Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;
                            foreach ($detail_transaksi as $detail) : ?>
                              <!-- get layanan nama -->
                              <?php $layanan = $this->model->get_by('layanan', 'id_layanan', $detail->id_layanan)->row(); ?>
                              <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $layanan->nama; ?></td>
                                <td><?= $detail->jumlah; ?></td>
                                <td><?= 'Rp ' . number_format($layanan->harga, 0, ',', '.'); ?></td>
                                <td><?= 'Rp ' . number_format($detail->sub_total, 0, ',', '.'); ?></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="text-right">Total</td>
                                <td><?= 'Rp ' . number_format($transaksi->total, 0, ',', '.'); ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>

                      </span></td>
                  </tr>
                  <tr>
                    <td><strong>Status Pesanan</strong></td>
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
                  </tr>
                  <tr>
                    <td><strong>Detail Pembayaran</strong></td>
                    <td><span>
                        <table class="table table-bordered table-hover">
                          <tr>
                            <td><strong>No. Invoice Pembayaran</strong></td>
                            <td><span><?= $pembayaran->no_invoice; ?></span></td>
                          </tr>
                          <tr>
                            <td><strong>Tanggal Pembayaran</strong></td>
                            <td><span><?= $pembayaran->tgl_bayar; ?></span></td>
                          </tr>
                          <tr>
                            <td><strong>Metode Pembayaran</strong></td>
                            <?php $nama_bayar = $this->model->get_by('metode_bayar', 'id_metode_bayar', $pembayaran->id_metode_bayar)->row()->nama; ?>
                            <td><span><?= $nama_bayar ?></span></td>
                          </tr>
                          <tr>
                            <td><strong>Status Pembayaran</strong></td>
                            <td><span><?= ($pembayaran->status == 1) ? 'Lunas' : 'Belum Lunas'; ?></span></td>
                          </tr>
                          <tr>
                            <td><strong>Bukti Pembayaran</strong></td>
                            <td><span>
                                <?php if ($pembayaran->bukti_bayar != null) : ?>
                                  <img src="<?= base_url('' . $pembayaran->bukti_bayar); ?>" alt="Bukti Pembayaran" width="500px">
                                <?php else : ?>
                                  <span>Tidak ada bukti pembayaran</span>
                                <?php endif; ?>
                              </span></td>
                          </tr>
                        </table>
                      </span></td>
                  </tr>

                </table>

              </div>

            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
