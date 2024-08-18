<!-- Contact -->
<div class="harga mb-5">
  <div class="container ">
    <div class="row py-5">
      <div class="col text-center ">
        <h2 class="font-weight-bold text-dark">Daftar Layanan BrightShoeCare</h2>
        <hr width="400px">
      </div>
    </div>
    <div class="row justify-content-center ">
      <div class="col-lg-12">
        <div class="card-columns">
          <?php foreach ($data as $l) : ?>
            <div class="card">
              <img src="<?= base_url($l->gambar) ?>" class="card-img-top" alt="<?= $l->nama ?>">
              <div class="card-body">
                <h5 class="card-title"><?= $l->nama ?></h5>
                <p class="card-text"><?= $l->deskripsi ?></p>
                <p class="card-text"><strong>Rp <?= number_format($l->harga, 0, ',', '.') ?></strong></p>
                <a href="<?= base_url('pesan/' . $l->id_layanan) ?>" class="btn btn-primary btn-block">Pesan Sekarang</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Contact -->