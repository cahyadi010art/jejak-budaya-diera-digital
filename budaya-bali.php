<?php
require 'includes/data.php';

$halaman          = 'bali';
$judulHalaman     = 'Budaya Bali';
$deskripsiHalaman = 'Tari Kecak, ogoh-ogoh, arsitektur pura, gamelan Bali, serta tradisi dan upacara adat.';

$budayaBali = array_filter($budaya, fn($b) => $b['bali']);

include 'includes/navbar.php';
?>

<section class="bali-kepala">
  <div class="wrap">
    <h1>Budaya Bali</h1>
    <p>Di Bali, seni dan keyakinan berjalan bersama. Tari, musik, bangunan, dan upacara bukan pertunjukan yang terpisah dari hidup, melainkan bagian dari cara masyarakat merawat hubungan dengan Tuhan, sesama, dan alam.</p>
    <p class="bali-catatan">UNESCO menetapkan tiga genre tari tradisional Bali sebagai Warisan Budaya Takbenda pada tahun 2015.</p>
  </div>
</section>

<?php $nomor = 0; ?>
<?php foreach ($budayaBali as $id => $b): ?>
  <?php $nomor++; ?>
  <section class="editorial<?= $nomor % 2 === 0 ? ' editorial-balik' : '' ?>">
    <div class="wrap editorial-grid">
      <figure class="editorial-gambar">
        <?= tampilGambar($b['gambar'], $b['nama'], $b['hue']) ?>
      </figure>
      <div class="editorial-teks">
        <p class="meta"><?= e($daftarKategori[$b['kategori']] ?? '') ?></p>
        <h2><?= e($b['nama']) ?></h2>
        <p class="lead"><?= e($b['ringkas']) ?></p>
        <p><?= e($b['isi'][0]) ?></p>
        <a class="btn btn-garis" href="detail-budaya.php?id=<?= (int) $id ?>">Baca Detail<span class="sr-only">: <?= e($b['nama']) ?></span></a>
      </div>
    </div>
  </section>
<?php endforeach; ?>

<section class="ajakan">
  <div class="wrap ajakan-dalam">
    <h2>Masih banyak budaya lain</h2>
    <p>Bali hanya satu dari ribuan cerita budaya Nusantara. Lanjutkan penjelajahan ke daerah lain.</p>
    <a class="btn btn-emas" href="budaya.php">Jelajahi Budaya</a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
