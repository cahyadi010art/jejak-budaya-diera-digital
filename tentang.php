<?php
require 'includes/data.php';

$halaman          = 'tentang';
$judulHalaman     = 'Tentang Kami';
$deskripsiHalaman = 'Tujuan JEJAK BUDAYA sebagai media digital untuk mengenalkan dan melestarikan budaya Indonesia.';

include 'includes/navbar.php';
?>

<section class="judul-halaman">
  <div class="wrap">
    <h1>Tentang Kami</h1>
    <p><?= e(TAGLINE) ?></p>
  </div>
</section>

<section class="seksi seksi-rapat">
  <div class="wrap dua-kolom">
    <div class="teks-bacaan">
      <h2>Mengapa JEJAK BUDAYA dibuat</h2>
      <p>JEJAK BUDAYA adalah media digital yang dibuat untuk mengenalkan kekayaan budaya Indonesia dan meningkatkan kesadaran generasi muda mengenai pentingnya pelestarian budaya.</p>
      <p>Indonesia memiliki ribuan tradisi, dari tarian, kain, dan musik hingga rumah adat dan upacara. Banyak di antaranya jarang dikenal oleh anak muda, bahkan oleh orang yang tinggal di daerah asalnya. Website ini mencoba menjadi pintu masuk yang sederhana: ringkas, mudah dibaca, dan menyenangkan dilihat.</p>
      <p>Website ini dikerjakan sebagai proyek sekolah menggunakan HTML, CSS, dan PHP tanpa JavaScript dan tanpa database.</p>
    </div>

    <aside class="fakta">
      <h2>Tujuan kami</h2>
      <ul class="daftar-centang daftar-rapat">
        <li>Mengenalkan budaya Nusantara dengan bahasa yang mudah dipahami.</li>
        <li>Menunjukkan peran teknologi digital dalam pelestarian budaya.</li>
        <li>Mengajak generasi muda ikut menjaga dan mempraktikkan tradisi.</li>
      </ul>
    </aside>
  </div>
</section>

<section class="seksi seksi-krem2">
  <div class="wrap dua-kolom">
    <div class="teks-bacaan">
      <h2>Tentang data dan gambar</h2>
      <p>Informasi budaya disusun dari pengetahuan umum dan dapat disempurnakan. Angka pada bagian statistik mencantumkan sumbernya. Bila Anda menemukan kesalahan, silakan kirim koreksi melalui halaman saran.</p>
      <p>Formulir saran hanya diproses sementara oleh server dan tidak disimpan secara permanen, karena website ini tidak menggunakan database maupun file penyimpanan.</p>
    </div>
    <div class="teks-bacaan">
      <h2>Punya masukan?</h2>
      <p>Kami senang mendengar usulan budaya yang perlu ditambahkan, koreksi informasi, atau ide untuk memperbaiki website ini.</p>
      <p><a class="btn btn-utama" href="saran.php">Kirim Saran</a></p>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
