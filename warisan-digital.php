<?php
require 'includes/data.php';

$halaman          = 'warisan';
$judulHalaman     = 'Warisan Digital';
$deskripsiHalaman = 'Arsip digital, virtual tour, media sosial, dan digital storytelling untuk melestarikan budaya.';

include 'includes/navbar.php';
?>

<section class="judul-halaman">
  <div class="wrap">
    <h1>Warisan Budaya di Era Digital</h1>
    <p>Empat cara teknologi membantu budaya tetap dikenal, dipelajari, dan dirayakan.</p>
  </div>
</section>

<section class="seksi seksi-rapat">
  <div class="wrap">
    <div class="grid grid-2">
      <?php foreach ($warisanDigital as $w): ?>
        <?php kartuDigital($w); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="seksi seksi-krem2">
  <div class="wrap dua-kolom">
    <header class="judul-seksi judul-kiri">
      <h2>Membagikan budaya dengan bijak</h2>
      <p>Teknologi mempermudah penyebaran, tetapi tanggung jawab tetap ada pada kita.</p>
    </header>
    <ul class="daftar-centang">
      <li><strong>Cek kebenaran informasi.</strong> Pastikan cerita dan makna budaya berasal dari sumber yang dapat dipercaya.</li>
      <li><strong>Hormati pemilik budaya.</strong> Mintalah izin kepada pengrajin, seniman, atau komunitas sebelum merekam dan menyebarkan karyanya.</li>
      <li><strong>Sebutkan sumbernya.</strong> Cantumkan nama pembuat foto, penulis, dan daerah asal budaya.</li>
      <li><strong>Datang dan alami langsung.</strong> Dokumentasi digital melengkapi, bukan menggantikan, pengalaman menyaksikan tradisi secara langsung.</li>
    </ul>
  </div>
</section>

<section class="ajakan">
  <div class="wrap ajakan-dalam">
    <h2>Budaya Kita, Identitas Kita</h2>
    <p>Di tengah pesatnya perkembangan teknologi, warisan budaya tetap menjadi bagian penting dari identitas bangsa. Mari mengenal, menghargai, dan melestarikannya bersama.</p>
    <a class="btn btn-emas" href="budaya.php">Jelajahi Budaya</a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
