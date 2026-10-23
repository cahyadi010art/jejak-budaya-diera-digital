<?php
require 'includes/data.php';

$halaman = 'cerita';

/* ---- Validasi parameter ?id= ---- */
$id     = ambilIdDariUrl();
$bacaan = ($id !== null && isset($artikel[$id])) ? $artikel[$id] : null;

if ($bacaan === null) {
    http_response_code(404);
    $judulHalaman = 'Artikel tidak ditemukan';
} else {
    $judulHalaman     = $bacaan['judul'];
    $deskripsiHalaman = $bacaan['ringkas'];
}

include 'includes/navbar.php';
?>

<?php if ($bacaan === null): ?>

  <section class="seksi">
    <div class="wrap kosong">
      <h1>Artikel tidak ditemukan</h1>
      <p>Artikel yang Anda cari tidak ada. Mungkin tautannya salah ketik.</p>
      <a class="btn btn-utama" href="cerita.php">Kembali ke Cerita Budaya</a>
    </div>
  </section>

<?php else: ?>

  <article>
    <header class="detail-kepala">
      <div class="wrap">
        <a class="kembali" href="cerita.php">Kembali ke Cerita Budaya</a>
        <p class="meta">Oleh <?= e($bacaan['penulis']) ?> &middot; Waktu baca <?= e($bacaan['baca']) ?></p>
        <h1><?= e($bacaan['judul']) ?></h1>
        <p class="detail-lead"><?= e($bacaan['ringkas']) ?></p>
      </div>
    </header>

    <div class="wrap artikel-isi">
      <figure class="detail-gambar">
        <?= tampilGambar($bacaan['gambar'], $bacaan['judul'], $bacaan['hue'], false) ?>
      </figure>
      <?php foreach ($bacaan['isi'] as $paragraf): ?>
        <p><?= e($paragraf) ?></p>
      <?php endforeach; ?>
      <p class="tombol-baris">
        <a class="btn btn-garis" href="cerita.php">Kembali</a>
        <a class="btn btn-utama" href="budaya.php">Jelajahi Budaya</a>
      </p>
    </div>
  </article>

  <section class="seksi seksi-krem2">
    <div class="wrap">
      <header class="judul-seksi">
        <h2>Artikel lainnya</h2>
      </header>
      <div class="grid grid-2">
        <?php foreach ($artikel as $idLain => $lain): ?>
          <?php if ($idLain !== $id) { kartuArtikel($idLain, $lain); } ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
