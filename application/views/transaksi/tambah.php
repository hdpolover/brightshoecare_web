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
              <h1 class="h4 text-gray-900 mb-4">Tambah Data <?= $section ?></h1>
            </div>
            <form class="user" method="POST" action="<?= base_url('admin/transaksi/pesan') ?>">
              <div class="form-group mb-3">
                <label class="text-dark">Pilih Pelanggan</label>
                <select class="form-control user-select" name="id_pelanggan" id="id_pelanggan">
                  <option value="">Cari dan Pilih Pelanggan</option>
                  <?php foreach ($pelanggan as $p) : ?>
                    <?php if ($p->username !== 'admin') : ?>
                      <option value="<?= $p->id ?>" data-name="<?= $p->nama ?>" data-email="<?= $p->email ?>" data-phone="<?= $p->no_hp ?>" data-address="<?= $p->alamat ?>">
                        <?= $p->nama ?>
                      </option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- User Details Section -->
              <div id="user-details" style="display: none;">
                <h5 class="text-dark"><strong>Detail Pelanggan</strong></h5>
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th scope="row">Nama</th>
                      <td id="user-name"></td>
                    </tr>
                    <tr>
                      <th scope="row">Email</th>
                      <td id="user-email"></td>
                    </tr>
                    <tr>
                      <th scope="row">No. HP</th>
                      <td id="user-phone"></td>
                    </tr>
                    <tr>
                      <th scope="row">Alamat</th>
                      <td id="user-address"></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <hr>

              <h5 class="text-dark"><strong>Detail Layanan</strong></h5>
              <div id="transaction-details-container" class="border border-primary bg-light p-3">
                <!-- Initial Service Section -->
                <div class="transaction-details">
                  <div class="form-group mb-3">
                    <label class="text-dark">Pilih Layanan</label>
                    <select class="form-control service-select" name="services[]">
                      <option value="">Cari dan Pilih Layanan</option>
                      <?php foreach ($layanan as $l) : ?>
                        <option value="<?= $l->id_layanan ?>" data-price="<?= $l->harga ?>"><?= $l->nama . " - Rp " . number_format($l->harga, 0, ',', '.') ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="text-end mt-3">
                <button type="button" id="add-service-btn" class="btn btn-primary">Tambah Layanan</button>
              </div>

              <div class="form-group mt-3">
                <label class="text-dark">Jumlah sepatu (pasang)</label>
                <input type="number" class="form-control" name="quantity" id="quantity" min="1" placeholder="Jumlah">
              </div>

              <div class="form-group mt-3">
                <label class="text-dark">Catatan</label>
                <textarea class="form-control" name="catatan" id="catatan" rows="3" placeholder="Masukkan catatan jika ada"></textarea>
              </div>

              <div class="form-group mt-3">
                <label class="text-dark">Total Harga</label>
                <input type="text" class="form-control" id="total-price" readonly>
              </div>

              <input type="hidden" name="total_price" id="total-price-input" value="">

              <hr>
              <div class="d-flex">
                <button type="submit" class="btn btn-primary mr-3">Pesan</button>
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

    $('.service-select').select2({
      placeholder: 'Cari dan Pilih Layanan',
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
    function updateTotalPrice() {
      let total = 0;
      const quantity = parseInt($('#quantity').val(), 10) || 0; // Get quantity from input field

      $('#transaction-details-container .transaction-details').each(function() {
        const serviceSelect = $(this).find('.service-select');
        const price = parseFloat(serviceSelect.find('option:selected').data('price')) || 0;

        total += price * quantity;
      });

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
              <option value="<?= $l->id_layanan ?>" data-price="<?= $l->harga ?>"><?= $l->nama . " - Rp " . number_format($l->harga, 0, ',', '.') ?></option>
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