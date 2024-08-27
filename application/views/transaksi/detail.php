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
    <!-- create a row for buttons here and align to the right -->
    <div class="row mb-3">
        <!-- give space for the buttons -->
        <div class="col">
            <a class="btn btn-sm btn-primary text-light float-right" onclick="saveAsPDF('toPrint')"><i class="fa fa-print"></i> <b>Cetak Transaksi</b></a>
            <a class="btn btn-sm btn-warning text-light float-right mr-2" data-target="#exampleModalLong<?= $transaksi->id_transaksi ?>" data-toggle="modal"><i class=" fa fa-edit"></i> <b>Ubah Status Pesanan</b></a>
        </div>
    </div>
    <?= $this->session->flashdata('flash') ?>
    <!-- DataTales Example -->
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

</div>

<div class="modal fade" id="exampleModalLong<?= $transaksi->id_transaksi ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Ubah Status Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?= base_url('admin/transaksi/ubah_status') ?>">
                <div class="modal-body">
                    <!-- create a dropdown for the status here -->
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $transaksi->id_transaksi ?>">
                        <label for="status">Status Pesanan</label>
                        <select name="status" class="form-control" id="status">
                            <option value="1">Dibuat</option>
                            <option value="2">Menunggu</option>
                            <option value="3">Proses</option>
                            <option value="4">Siap</option>
                            <option value="5">Selesai</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-info" id="add">Update</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

<script>
    function saveAsPDF(divId) {
        var element = document.getElementById(divId);

        // Get the transaction number from your page
        var transactionNumber = document.getElementById('file_name').textContent;

        // Generate the filename using the transaction number
        var fileName = transactionNumber + '.pdf';

        html2pdf(element, {
            // margin: 0.5,
            filename: fileName,
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                // make sure content is rendered properly on the PDF file by using the scale option and fit the content to the page
                scale: 3,
            },
            // make sure the format and orientation are correct
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            }
        });
    }

    function printDiv(divId) {
        var divContents = document.getElementById(divId).innerHTML;

        // Open a new window with larger dimensions
        var printWindow = window.open('BrightShoeCare.com', '', 'height=1000,width=1400');

        // Write the head of the document with styles
        printWindow.document.write('<html><head><title>Cetak Transaksi</title>');

        // Copy all stylesheets and inline styles from the original document
        var styles = document.querySelectorAll('link[rel="stylesheet"], style[type="text/css"], style');
        styles.forEach(function(style) {
            printWindow.document.write(style.outerHTML);
        });

        printWindow.document.write('</head><body >');

        // Add the content to print
        printWindow.document.write(divContents);

        printWindow.document.write('</body></html>');

        // Close the document to finish the writing
        printWindow.document.close();

        // Wait for the content to load before printing
        printWindow.focus();
        printWindow.onload = function() {
            printWindow.print();
        };
    }
</script>