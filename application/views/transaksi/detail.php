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
    <h1 class="h3 mb-5 text-gray-800">Detail Transaksi</h1>
    <?= $this->session->flashdata('flash') ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <div>
                <span class="m-0 font-weight-bold text-primary">Transaksi #<?= $transaksi->no_transaksi; ?></span>
            </div>
            <div class="ml-auto">
                <a class="btn btn-sm btn-primary text-light" href="<?= base_url('admin/transaksi/tambah') ?>"><i class="fa fa-plus"></i> <b>Tambah Transaksi</b></a>
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
                    <td><strong>Status Pembayaran</strong></td>
                    <td><span>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Status</th>
                                        <th>Bukti Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($pembayaran as $bayar) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $bayar->metode; ?></td>
                                            <td><?= ($bayar->status == 1) ? 'Lunas' : 'Belum Lunas'; ?></td>
                                            <td>
                                                <?php if ($bayar->bukti_pembayaran != null) : ?>
                                                    <a href="<?= base_url('assets/bukti_pembayaran/' . $bayar->bukti_pembayaran); ?>" target="_blank">Lihat Bukti Pembayaran</a>
                                                <?php else : ?>
                                                    <span>Tidak ada bukti pembayaran</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                        </span></td>
                </tr>

            </table>

        </div>

    </div>