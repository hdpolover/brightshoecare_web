<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<?= $this->session->flashdata('flash') ?>

<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg-11">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">
                Data Pembayaran Transaksi
                <span class="font-weight-bold text-primary">#<?= htmlspecialchars($no_transaksi) ?></span>
              </h1>
            </div>
            <form class="bayar" method="POST" action="<?= base_url('admin/transaksi/save_bayar') ?>" enctype="multipart/form-data">
              <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">
              <!-- Transaction Details Section -->
              <div id="transaction-details">
                <h5 class="text-dark mb-3"><strong>Detail Transaksi</strong></h5>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">No. </th>
                      <th scope="col">Layanan</th>
                      <th scope="col">Jumlah</th>
                      <th scope="col">Sub Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($transaksi_detail as $detail) : ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $this->model->get_by('layanan', 'id_layanan', $detail->id_layanan)->row()->nama ?></td>
                        <td><?= $detail->jumlah ?></td>
                        <td>Rp <?= number_format($detail->sub_total, 0, ',', '.') ?></td>
                      </tr>
                    <?php endforeach; ?>
                    <tr>
                      <th colspan="3">Total Harga</th>
                      <td>Rp <?= number_format($total_price, 0, ',', '.') ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Select Payment Method -->
              <div class="form-group mb-3">
                <label class="text-dark">Pilih Metode Pembayaran</label>
                <select class="form-control bayar-select" name="id_metode_bayar" id="id_metode_bayar">
                  <option value="">Cari dan Pilih Metode Pembayaran</option>
                  <?php foreach ($metode_bayar as $p) : ?>
                    <option value="<?= $p->id_metode_bayar ?>" style="text-transform: uppercase; font-weight: bold; color: #333;">
                      <?= strtoupper($p->kategori) . " | " . $p->nama . " - " . $p->deskripsi ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Upload Payment Proof -->
              <div class="form-group mb-3">
                <label class="text-dark">Upload Bukti Pembayaran</label>
                <input type="file" class="form-control-file" name="bukti_pembayaran" accept="image/*,application/pdf">
              </div>

              <!-- Set Payment Status -->
              <div class="form-group mb-3">
                <label class="text-dark">Status Pembayaran</label>
                <select class="form-control" name="status_pembayaran" id="status_pembayaran">
                  <option value="0">Menunggu</option>
                  <option value="1">Berhasil</option>
                </select>
              </div>

              <div class="form-group mt-3">
                <label class="text-dark">Catatan</label>
                <textarea class="form-control" name="catatan" id="catatan" rows="3" placeholder="Masukkan catatan jika ada"></textarea>
              </div>

              <hr>

              <div class="d-flex">
                <button type="submit" class="btn btn-primary mr-3">Simpan</button>
              </div>
            </form>
            <a href="<?= base_url('admin/transaksi') ?>" class="btn btn-secondary">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<script>
  $(document).ready(function() {
    $('.user-select').select2({
      placeholder: 'Cari dan Pilih Pelanggan',
      allowClear: true
    });

    $('#id_pelanggan').change(function() {
      const selectedOption = $(this).find('option:selected');
      const selectedUserId = $(this).val();

      if (selectedUserId) {
        const userName = selectedOption.data('name');
        const userEmail = selectedOption.data('email');
        const userPhone = selectedOption.data('phone');
        const userAddress = selectedOption.data('address');

        // Update user details or set to "-" if not available
        $('#user-name').text(userName || "-");
        $('#user-email').text(userEmail || "-");
        $('#user-phone').text(userPhone || "-");
        $('#user-address').text(userAddress || "-");

        $('#user-details').show();
      } else {
        $('#user-details').hide();
      }
    });
  });

  $(document).ready(function() {
    // Function to update the total price
    function updateTotalPrice() {
      let total = 0;

      // Loop through each service row and calculate total
      $('#transaction-details-container .transaction-details').each(function() {
        const serviceSelect = $(this).find('.service-select');
        const quantityInput = $('#quantity').val(); // Use the single quantity input

        const price = parseFloat(serviceSelect.find('option:selected').data('price')) || 0;
        const quantity = parseInt(quantityInput, 10) || 0;

        total += price * quantity;
      });

      // Display the total price
      $('#total-price').val('Rp ' + total.toLocaleString());
      $('#total-price-input').val(total); // Update hidden field
    }

    // Event listener for changes in service selection or quantity
    $('#transaction-details-container').on('change', '.service-select', function() {
      updateTotalPrice();
    });

    $('#quantity').on('input', function() {
      updateTotalPrice();
    });

    // Add new service section
    $('#add-service-btn').click(function() {
      const newServiceSection = `
        <div class="transaction-details mt-3">
          <div class="form-group mb-3">
            <label class="text-dark">Pilih Layanan</label>
            <select class="form-control service-select" name="services[]">
              <option value="">Cari dan Pilih Layanan</option>
              <?php foreach ($layanan as $l) : ?>
                <option value="<?= $l->id_layanan ?>" data-price="<?= $l->harga ?>"><?= $l->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      `;

      $('#transaction-details-container').append(newServiceSection);
      updateTotalPrice(); // Update total price when a new service is added
    });
  });
</script>