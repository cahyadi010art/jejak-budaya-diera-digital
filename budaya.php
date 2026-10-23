<?php
require 'includes/data.php';

$halaman          = 'budaya';
$judulHalaman     = 'Jelajah Budaya';
$deskripsiHalaman = 'Temukan budaya Indonesia berdasarkan kategori atau kata kunci.';

/* ---- Membaca dan memvalidasi parameter GET ---- */
$kategoriDipilih = '';
$kategoriTidakDikenal = false;
if (isset($_GET['kategori']) && is_string($_GET['kategori']) && $_GET['kategori'] !== '') {
    if (array_key_exists($_GET['kategori'], $daftarKategori)) {
        $kategoriDipilih = $_GET['kategori'];
    } else {
        $kategoriTidakDikenal = true;   // nilai ?kategori= tidak ada di daftar
    }
}

$kataKunci = (isset($_GET['q']) && is_string($_GET['q'])) ? trim($_GET['q']) : '';
$kataKunci = function_exists('mb_substr') ? mb_substr($kataKunci, 0, 60) : substr($kataKunci, 0, 60);

/* ---- Menyaring data ---- */
$hasil = saringBudaya($budaya, $kategoriDipilih, $kataKunci);

include 'includes/navbar.php';
?>

<section class="judul-halaman">
  <div class="wrap">
    <h1>Jelajah Budaya</h1>
    <p>Cari berdasarkan nama atau daerah, atau pilih kategori untuk mempersempit hasil.</p>
  </div>
</section>

<section class="seksi seksi-rapat">
  <div class="wrap">

    <form class="cari" action="budaya.php" method="get" role="search">
      <label class="sr-only" for="q">Cari budaya</label>
      <input type="search" id="q" name="q" value="<?= e($kataKunci) ?>" placeholder="Cari nama, daerah, atau kata kunci" maxlength="60">
      <?php if ($kategoriDipilih !== ''): ?>
        <input type="hidden" name="kategori" value="<?= e($kategoriDipilih) ?>">
      <?php endif; ?>
      <button class="btn btn-utama" type="submit">Cari</button>
    </form>

    <nav class="filter" aria-label="Filter kategori">
      <?php
      // Tautan "Semua" mempertahankan kata kunci pencarian
      $parameterSemua = $kataKunci !== '' ? '?' . http_build_query(['q' => $kataKunci]) : '';
      ?>
      <a href="budaya.php<?= e($parameterSemua) ?>"<?= $kategoriDipilih === '' ? ' class="aktif" aria-current="true"' : '' ?>>Semua</a>
      <?php foreach ($daftarKategori as $kunci => $namaKategori): ?>
        <?php
        $parameter = ['kategori' => $kunci];
        if ($kataKunci !== '') { $parameter['q'] = $kataKunci; }
        ?>
        <a href="budaya.php?<?= e(http_build_query($parameter)) ?>"<?= $kategoriDipilih === $kunci ? ' class="aktif" aria-current="true"' : '' ?>><?= e($namaKategori) ?></a>
      <?php endforeach; ?>
    </nav>

    <?php if ($kategoriTidakDikenal): ?>
      <p class="pesan pesan-info" role="status">Kategori yang diminta tidak dikenal, jadi semua kategori ditampilkan.</p>
    <?php endif; ?>

    <p class="info-hasil" role="status">
      Menampilkan <strong><?= count($hasil) ?></strong> budaya<?php if ($kategoriDipilih !== ''): ?>
        pada kategori <strong><?= e($daftarKategori[$kategoriDipilih]) ?></strong><?php endif; ?><?php if ($kataKunci !== ''): ?>
        dengan kata kunci <strong><?= e($kataKunci) ?></strong><?php endif; ?>.
      <?php if ($kategoriDipilih !== '' || $kataKunci !== ''): ?>
        <a href="budaya.php">Hapus filter</a>
      <?php endif; ?>
    </p>

    <?php if (count($hasil) > 0): ?>
      <div class="grid grid-3">
        <?php foreach ($hasil as $id => $b): ?>
          <?php kartuBudaya($id, $b, $daftarKategori); ?>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="kosong">
        <h2>Belum ada budaya yang cocok</h2>
        <p>Coba kata kunci lain, misalnya nama daerah seperti "Bali" atau "Jawa", atau lihat semua budaya.</p>
        <a class="btn btn-garis" href="budaya.php">Tampilkan Semua Budaya</a>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
