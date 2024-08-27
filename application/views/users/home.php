<!-- Masthead -->
<header class="masthead text-white text-center" style="background: url('<?= base_url('assets/users/') ?>img/baru.jpg') no-repeat center center; background-size: cover;">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-xl-9 text-left mx-auto">
        <h1>Sepatu Bersih, Seperti Baru!</h1>
        <p class="mb-5" style="margin-top: -10px; font-size: 18px;">Layanan cuci sepatu terbaik, membuat sepatu Anda tampak seperti baru lagi.</p>
      </div>
      <div class="col-md-10 col-lg-8 col-xl-9 mx-auto">
        <form method="GET" action="<?= base_url('cari') ?>">
          <div class="form-row">
            <div class="col-12 col-md-9 mb-2 mb-md-0">
              <input type="text" name="idOrder" class="form-control form-control-lg" placeholder="Masukkan No. Transaksi..." onkeypress="return inputAngka(event)" autocomplete="off">
            </div>
            <div class="col-12 col-md-3">
              <button type="submit" class="btn btn-block btn-lg tombol-cari">Cari!</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</header>


<!-- Icons Grid -->
<section class="features-icons text-center" style="background-color: rgba(65,188,234,.07)">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <h3>Sepatu Dibersihkan Sempurna</h3>
        <p class="lead mb-0">Dibersihkan dan direstorasi dengan teliti oleh para profesional.</p>
      </div>
      <div class="col-lg-4">
        <h3>Segar dan Higienis</h3>
        <p class="lead mb-0">Disanitasi secara menyeluruh untuk memastikan kebersihan dan kesegaran.</p>
      </div>
      <div class="col-lg-4">
        <h3>Wangi Tahan Lama</h3>
        <p class="lead mb-0">Menggunakan pewangi premium yang membuat sepatu tetap harum dalam waktu lama.</p>
      </div>
    </div>
  </div>
</section>

<!-- Image Showcases -->
<section class="showcase">
  <div class="container-fluid p-0">
    <div class="row no-gutters">

      <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('<?= base_url('assets/users/') ?>img/cuci.jpeg');"></div>
      <div class="col-lg-6 order-lg-1 my-auto showcase-text">
        <h2>Sepatu Dijamin Bersih</h2>
        <p class="lead mb-0">Sepatu dicuci menggunakan mesin dan deterjen khusus yang mampu mengangkat kotoran dan noda dengan efektif.</p>
      </div>
    </div>
    <div class="row no-gutters">
      <div class="col-lg-6 text-white showcase-img" style="background-image: url('<?= base_url('assets/users/') ?>img/kering.jpg'); "></div>
      <div class="col-lg-6 my-auto showcase-text">
        <h2>Pengeringan Optimal</h2>
        <p class="lead mb-0">Sepatu dikeringkan dengan teknik khusus yang memastikan sepatu tetap dalam kondisi terbaik tanpa merusak bahan.</p>
      </div>
    </div>
    <div class="row no-gutters">
      <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('<?= base_url('assets/users/') ?>img/wangi.jpeg');"></div>
      <div class="col-lg-6 order-lg-1 my-auto showcase-text">
        <h2>Sepatu Menjadi Lebih Wangi</h2>
        <p class="lead mb-0">Dicuci menggunakan pewangi khusus sepatu yang tidak merusak bahan dan membuat sepatu wangi lebih lama.</p>
      </div>
    </div>
  </div>
</section>


<!-- Testimonials -->
<section class="testimonials text-center" style="background-color: rgba(65,188,234,.07)">
  <div class="container">
    <h2 class="mb-5">Apa yang orang-orang katakan...</h2>
    <div class="row">
      <div class="col-lg-4">
        <div class="testimonial-item mx-auto mb-5 mb-lg-0">
          <img class="img-fluid rounded-circle mb-3" src="<?= base_url('assets/users/') ?>img/testimonials-1.jpg" alt="">
          <h5>Rinna Novitasari</h5>
          <p class="font-weight-light mb-0">"Sepatu saya jadi seperti baru lagi! Bersih dan wangi. Sangat direkomendasikan!"</p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="testimonial-item mx-auto mb-5 mb-lg-0">
          <img class="img-fluid rounded-circle mb-3" src="<?= base_url('assets/users/') ?>img/testimonials-2.jpg" alt="">
          <h5>Andang Wijaksana</h5>
          <p class="font-weight-light mb-0">"Layanan terbaik! Sepatu saya benar-benar bersih dan harum."</p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="testimonial-item mx-auto mb-5 mb-lg-0">
          <img class="img-fluid rounded-circle mb-3" src="<?= base_url('assets/users/') ?>img/testimonials-3.jpg" alt="">
          <h5>Sarah Wulandari</h5>
          <p class="font-weight-light mb-0">"Pelayanan cepat dan hasilnya memuaskan. Sepatu jadi rapi dan wangi!"</p>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
  function inputAngka(evt) {
    var charCode = (evt.charCode);
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
      return false;
    } else {
      return true;
    }
  }
</script>