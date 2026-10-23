<?php
require 'includes/data.php';

$halaman = 'budaya';

/* ---- Validasi parameter ?id= ---- */
$id   = ambilIdDariUrl();
$item = ($id !== null && isset($budaya[$id])) ? $budaya[$id] : null;

if ($item === null) {
    http_response_code(404);        // data tidak ditemukan
    $judulHalaman = 'Budaya tidak ditemukan';
} else {
    $judulHalaman     = $item['nama'];
    $deskripsiHalaman = $item['ringkas'];

    // Budaya terkait: utamakan kategori yang sama, lalu lengkapi dengan lainnya sampai 3 kartu
    $terkait = [];
    foreach ($budaya as $idLain => $lain) {
        if ($idLain !== $id && $lain['kategori'] === $item['kategori']) { $terkait[$idLain] = $lain; }
    }
    foreach ($budaya as $idLain => $lain) {
        if (count($terkait) >= 3) { break; }
        if ($idLain !== $id && !isset($terkait[$idLain])) { $terkait[$idLain] = $lain; }
    }
    $terkait = array_slice($terkait, 0, 3, true);
}

include 'includes/navbar.php';
?>

<?php if ($item === null): ?>

  <section class="seksi">
    <div class="wrap kosong">
      <h1>Budaya tidak ditemukan</h1>
      <p>Alamat yang Anda buka tidak cocok dengan data budaya kami. Mungkin tautannya salah ketik.</p>
      <a class="btn btn-utama" href="budaya.php">Kembali ke Jelajah Budaya</a>
    </div>
  </section>

<?php else: ?>

  <article>
    <header class="detail-kepala">
      <div class="wrap">
        <a class="kembali" href="budaya.php">Kembali ke Jelajah Budaya</a>
        <p class="meta"><?= e($item['daerah']) ?> &middot; <?= e($daftarKategori[$item['kategori']] ?? '') ?></p>
        <h1><?= e($item['nama']) ?></h1>
        <p class="detail-lead"><?= e($item['ringkas']) ?></p>
      </div>
    </header>

    <div class="wrap detail-grid">
      <div class="detail-isi">
        <figure class="detail-gambar">
          <?= tampilGambar($item['gambar'], $item['nama'], $item['hue'], false) ?>
        </figure>
        <?php foreach ($item['isi'] as $paragraf): ?>
          <p><?= e($paragraf) ?></p>
        <?php endforeach; ?>
      </div>

      <aside class="fakta" aria-label="Fakta singkat">
        <h2>Fakta singkat</h2>
        <dl>
          <?php foreach ($item['fakta'] as [$label, $nilai]): ?>
            <div>
              <dt><?= e($label) ?></dt>
              <dd><?= e($nilai) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
        <?php if ($item['bali']): ?>
          <a class="tautan-lanjut" href="budaya-bali.php">Lihat halaman Budaya Bali</a>
        <?php endif; ?>
      </aside>
    </div>
  </article>

  <section class="seksi seksi-krem2">
    <div class="wrap">
      <header class="judul-seksi">
        <h2>Budaya lainnya</h2>
      </header>
      <div class="grid grid-3">
        <?php foreach ($terkait as $idLain => $lain): ?>
          <?php kartuBudaya($idLain, $lain, $daftarKategori); ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
