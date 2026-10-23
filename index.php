<?php
require 'includes/data.php';

$halaman          = 'beranda';
$judulHalaman     = 'Menelusuri Jejak Budaya';
$deskripsiHalaman = 'Jelajahi kekayaan budaya Nusantara dan temukan bagaimana teknologi digital membantu menjaga tradisi tetap hidup.';

// Ambil hanya budaya unggulan untuk ditampilkan di Beranda
$budayaUnggulan = array_filter($budaya, fn($b) => $b['unggulan']);

include 'includes/navbar.php';
?>

<!-- ============ HERO ============ -->
<section class="hero">
  <div class="wrap hero-grid">
    <div class="hero-teks">
      <h1>Menelusuri Jejak Budaya, Menjaga Warisan Masa Depan</h1>
      <p class="hero-lead">Jelajahi kekayaan budaya Nusantara dan temukan bagaimana teknologi digital membantu menjaga tradisi tetap hidup di tengah perkembangan zaman.</p>
      <div class="tombol-baris">
        <a class="btn btn-utama" href="budaya.php">Jelajahi Budaya</a>
        <a class="btn btn-garis" href="warisan-digital.php">Kenali Warisan Kita</a>
      </div>
    </div>

    <div class="hero-visual">
      <div class="bingkai">
        <div class="lengkung">
          <?= tampilGambar('hero-budaya', 'Kekayaan budaya Nusantara', 30, false) ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ JELAJAH BUDAYA ============ -->
<section class="seksi">
  <div class="wrap">
    <header class="judul-seksi">
      <h2>Jelajah Budaya</h2>
      <p>Enam warisan dari berbagai penjuru Nusantara. Pilih salah satu untuk membaca ceritanya.</p>
    </header>

    <div class="grid grid-3">
      <?php foreach ($budayaUnggulan as $id => $b): ?>
        <?php kartuBudaya($id, $b, $daftarKategori); ?>
      <?php endforeach; ?>
    </div>

    <p class="seksi-aksi"><a class="btn btn-garis" href="budaya.php">Lihat Semua Budaya</a></p>
  </div>
</section>

<!-- ============ WARISAN DIGITAL ============ -->
<section class="seksi seksi-nila">
  <div class="wrap">
    <header class="judul-seksi">
      <h2>Warisan Budaya di Era Digital</h2>
      <p>Teknologi tidak menggantikan tradisi. Ia membantu tradisi dicatat, dikenal, dan dibagikan.</p>
    </header>
    <div class="grid grid-4">
      <?php foreach ($warisanDigital as $w): ?>
        <?php kartuDigital($w); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ CERITA BUDAYA ============ -->
<section class="seksi">
  <div class="wrap">
    <header class="judul-seksi">
      <h2>Cerita Budaya</h2>
      <p>Bacaan singkat tentang mengapa budaya perlu dijaga dan bagaimana kita bisa ikut serta.</p>
    </header>
    <div class="grid grid-3">
      <?php foreach ($artikel as $id => $a): ?>
        <?php kartuArtikel($id, $a); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ STATISTIK ============ -->
<section class="seksi seksi-gelap">
  <div class="wrap">
    <header class="judul-seksi">
      <h2>Statistik Budaya</h2>
      <p>Gambaran keragaman budaya Indonesia berdasarkan data resmi.</p>
    </header>
    <?php blokStatistik($statistik, $catatanStatistik); ?>
  </div>
</section>

<!-- ============ AJAKAN ============ -->
<section class="ajakan">
  <div class="wrap ajakan-dalam">
    <h2>Budaya Kita, Identitas Kita</h2>
    <p>Di tengah pesatnya perkembangan teknologi, warisan budaya tetap menjadi bagian penting dari identitas bangsa. Mari mengenal, menghargai, dan melestarikannya bersama.</p>
    <a class="btn btn-emas" href="budaya.php">Jelajahi Budaya</a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
