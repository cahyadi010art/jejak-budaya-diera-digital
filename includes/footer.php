<?php
/**
 * includes/footer.php
 * Menampilkan footer lalu menutup <main>, <body>, dan <html>
 * yang dibuka oleh includes/navbar.php.
 */
?>
</main>

<footer class="footer">
  <div class="wrap footer-grid">
    <div class="footer-merek">
      <a class="logo logo-terang" href="index.php" aria-label="JEJAK BUDAYA, kembali ke Beranda">
        <svg class="logo-tanda" viewBox="0 0 40 40" aria-hidden="true">
          <g fill="none" stroke="currentColor" stroke-width="1.6">
            <ellipse cx="20" cy="10" rx="5" ry="9"/>
            <ellipse cx="20" cy="30" rx="5" ry="9"/>
            <ellipse cx="10" cy="20" rx="9" ry="5"/>
            <ellipse cx="30" cy="20" rx="9" ry="5"/>
          </g>
          <rect x="16.5" y="16.5" width="7" height="7" fill="#D9B45F"/>
        </svg>
        <span class="logo-teks"><strong>JEJAK BUDAYA</strong></span>
      </a>
      <p>Media digital untuk mengenal, mendokumentasikan, dan melestarikan kekayaan budaya Indonesia. Dikerjakan sebagai proyek sekolah.</p>
    </div>

    <nav class="footer-menu" aria-label="Navigasi footer">
      <h2>Jelajahi</h2>
      <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="budaya.php">Jelajah Budaya</a></li>
        <li><a href="budaya-bali.php">Budaya Bali</a></li>
        <li><a href="warisan-digital.php">Warisan Digital</a></li>
        <li><a href="cerita.php">Cerita Budaya</a></li>
        <li><a href="tentang.php">Tentang Kami</a></li>
        <li><a href="saran.php">Kirim Saran</a></li>
      </ul>
    </nav>

    <div class="footer-catatan">
      <h2>Catatan</h2>
      <p>Formulir saran hanya diproses sementara di server dan tidak disimpan secara permanen.</p>
    </div>
  </div>

  <div class="footer-bawah">
    <div class="wrap">
      <p>&copy; <?= date('Y') ?> JEJAK BUDAYA. Seluruh hak dilindungi.</p>
      <p>Dibuat untuk mengenal dan melestarikan budaya Indonesia</p>
    </div>
  </div>
</footer>
</body>
</html>
