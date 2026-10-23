<?php
require 'includes/data.php';

$halaman          = 'cerita';
$judulHalaman     = 'Cerita Budaya';
$deskripsiHalaman = 'Artikel tentang pentingnya menjaga budaya tradisional di era digital.';

include 'includes/navbar.php';
?>

<section class="judul-halaman">
  <div class="wrap">
    <h1>Cerita Budaya</h1>
    <p>Bacaan singkat tentang makna budaya, peran generasi muda, dan hubungan tradisi dengan teknologi.</p>
  </div>
</section>

<section class="seksi seksi-rapat">
  <div class="wrap">
    <div class="grid grid-3">
      <?php foreach ($artikel as $id => $a): ?>
        <?php kartuArtikel($id, $a); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
