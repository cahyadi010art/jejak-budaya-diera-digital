<?php
/**
 * includes/navbar.php
 * Membuka dokumen HTML (<head>, <body>) dan menampilkan navigasi.
 * Variabel yang diatur oleh halaman sebelum include:
 *   $halaman          : kunci menu aktif (beranda, budaya, bali, warisan, cerita, tentang)
 *   $judulHalaman     : judul tab browser
 *   $deskripsiHalaman : deskripsi singkat untuk mesin pencari (opsional)
 * Penutupnya ada di includes/footer.php
 */
$halaman          = $halaman ?? '';
$judulHalaman     = $judulHalaman ?? NAMA_SITUS;
$deskripsiHalaman = $deskripsiHalaman ?? 'Website pelestarian budaya Indonesia di era digital.';

$menu = [
    'beranda' => ['index.php',           'Beranda'],
    'budaya'  => ['budaya.php',          'Jelajah Budaya'],
    'bali'    => ['budaya-bali.php',     'Budaya Bali'],
    'warisan' => ['warisan-digital.php', 'Warisan Digital'],
    'cerita'  => ['cerita.php',          'Cerita Budaya'],
    'tentang' => ['tentang.php',         'Tentang Kami'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($judulHalaman) ?> | <?= e(NAMA_SITUS) ?></title>
  <meta name="description" content="<?= e($deskripsiHalaman) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<a class="lompat" href="#konten">Lewati ke konten utama</a>

<header class="navbar">
  <div class="wrap navbar-dalam">
    <a class="logo" href="index.php" aria-label="JEJAK BUDAYA, kembali ke Beranda">
      <svg class="logo-tanda" viewBox="0 0 40 40" aria-hidden="true">
        <g fill="none" stroke="currentColor" stroke-width="1.6">
          <ellipse cx="20" cy="10" rx="5" ry="9"/>
          <ellipse cx="20" cy="30" rx="5" ry="9"/>
          <ellipse cx="10" cy="20" rx="9" ry="5"/>
          <ellipse cx="30" cy="20" rx="9" ry="5"/>
        </g>
        <rect x="16.5" y="16.5" width="7" height="7" fill="#3F3B8F"/>
      </svg>
      <span class="logo-teks"><strong>JEJAK BUDAYA</strong><small>Menjaga Warisan, Menyambut Masa Depan.</small></span>
    </a>

    <!-- Menu responsif tanpa JavaScript: checkbox + label (teknik "checkbox hack") -->
    <input type="checkbox" id="menu-toggle" class="menu-check">
    <label for="menu-toggle" class="menu-tombol">
      <span class="sr-only">Buka atau tutup menu</span>
      <span class="garis"></span>
    </label>

    <nav class="menu" aria-label="Navigasi utama">
      <ul>
        <?php foreach ($menu as $kunci => [$tautan, $nama]): ?>
          <li>
            <a href="<?= e($tautan) ?>"<?= $kunci === $halaman ? ' class="aktif" aria-current="page"' : '' ?>><?= e($nama) ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
  </div>
</header>

<main id="konten">
