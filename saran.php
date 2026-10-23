<?php
require 'includes/data.php';

$halaman          = '';
$judulHalaman     = 'Kirim Saran';
$deskripsiHalaman = 'Kirim saran, koreksi, atau usulan budaya untuk JEJAK BUDAYA.';

/* ---- Pengaturan formulir ---- */
$pilihanTopik = [
    'konten'  => 'Saran untuk konten',
    'koreksi' => 'Koreksi informasi',
    'usulan'  => 'Usulan budaya baru',
    'lainnya' => 'Lainnya',
];

$nilai    = ['nama' => '', 'email' => '', 'topik' => 'konten', 'pesan' => ''];
$galat    = [];       // pesan kesalahan per kolom
$berhasil = false;
$ringkasan = [];

/** Mengambil nilai teks dari $_POST dengan aman (menolak array). */
function ambilPost(string $kunci): string
{
    return (isset($_POST[$kunci]) && is_string($_POST[$kunci])) ? trim($_POST[$kunci]) : '';
}

/** Menghitung panjang teks (mendukung karakter Unicode bila mbstring aktif). */
function panjang(string $teks): int
{
    return function_exists('mb_strlen') ? mb_strlen($teks) : strlen($teks);
}

/* ---- Pemrosesan formulir (hanya saat metode POST) ---- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nilai['nama']  = ambilPost('nama');
    $nilai['email'] = ambilPost('email');
    $nilai['topik'] = ambilPost('topik');
    $nilai['pesan'] = ambilPost('pesan');

    // Validasi nama: wajib, 2 sampai 50 karakter
    if ($nilai['nama'] === '') {
        $galat['nama'] = 'Nama wajib diisi.';
    } elseif (panjang($nilai['nama']) < 2 || panjang($nilai['nama']) > 50) {
        $galat['nama'] = 'Nama harus terdiri dari 2 sampai 50 karakter.';
    }

    // Validasi email: boleh kosong, tetapi bila diisi harus berformat benar
    if ($nilai['email'] !== '' && !filter_var($nilai['email'], FILTER_VALIDATE_EMAIL)) {
        $galat['email'] = 'Format email belum benar. Contoh: nama@contoh.com';
    }

    // Validasi topik: harus salah satu pilihan yang tersedia
    if (!array_key_exists($nilai['topik'], $pilihanTopik)) {
        $galat['topik'] = 'Pilih salah satu topik yang tersedia.';
        $nilai['topik'] = 'konten';
    }

    // Validasi pesan: wajib, 10 sampai 500 karakter
    if ($nilai['pesan'] === '') {
        $galat['pesan'] = 'Pesan wajib diisi.';
    } elseif (panjang($nilai['pesan']) < 10) {
        $galat['pesan'] = 'Pesan terlalu pendek. Tulis minimal 10 karakter.';
    } elseif (panjang($nilai['pesan']) > 500) {
        $galat['pesan'] = 'Pesan terlalu panjang. Maksimal 500 karakter.';
    }

    if (count($galat) === 0) {
        $berhasil  = true;
        $ringkasan = $nilai;   // simpan sementara hanya untuk ditampilkan pada halaman ini
        $nilai     = ['nama' => '', 'email' => '', 'topik' => 'konten', 'pesan' => ''];
        // Catatan: data TIDAK disimpan ke database maupun file.
    }
}

include 'includes/navbar.php';
?>

<section class="judul-halaman">
  <div class="wrap">
    <h1>Kirim Saran</h1>
    <p>Punya koreksi, usulan budaya, atau ide untuk website ini? Tulis di sini.</p>
  </div>
</section>

<section class="seksi seksi-rapat">
  <div class="wrap dua-kolom dua-kolom-form">

    <div>
      <?php if ($berhasil): ?>
        <div class="pesan pesan-sukses" role="status">
          <h2>Terima kasih, <?= e($ringkasan['nama']) ?>.</h2>
          <p>Saran Anda sudah diterima oleh server dan lolos validasi. Ringkasannya:</p>
          <dl class="ringkasan">
            <div><dt>Topik</dt><dd><?= e($pilihanTopik[$ringkasan['topik']]) ?></dd></div>
            <?php if ($ringkasan['email'] !== ''): ?>
              <div><dt>Email</dt><dd><?= e($ringkasan['email']) ?></dd></div>
            <?php endif; ?>
            <div><dt>Pesan</dt><dd><?= nl2br(e($ringkasan['pesan'])) ?></dd></div>
          </dl>
          <p><strong>Perlu diketahui:</strong> website ini tidak memakai database, sehingga saran ini <strong>tidak disimpan secara permanen</strong> dan akan hilang setelah halaman ditutup.</p>
        </div>
      <?php elseif (count($galat) > 0): ?>
        <div class="pesan pesan-galat" role="alert">
          <h2>Formulir belum bisa dikirim</h2>
          <p>Perbaiki bagian berikut, lalu kirim lagi:</p>
          <ul>
            <?php foreach ($galat as $kolom => $pesanGalat): ?>
              <li><a href="#<?= e($kolom) ?>"><?= e($pesanGalat) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form class="formulir" action="saran.php" method="post" novalidate>
        <div class="kolom">
          <label for="nama">Nama</label>
          <input type="text" id="nama" name="nama" value="<?= e($nilai['nama']) ?>" maxlength="50" required
                 autocomplete="name"<?= isset($galat['nama']) ? ' aria-invalid="true" aria-describedby="galat-nama"' : '' ?>>
          <?php if (isset($galat['nama'])): ?><p class="galat" id="galat-nama"><?= e($galat['nama']) ?></p><?php endif; ?>
        </div>

        <div class="kolom">
          <label for="email">Email <span class="opsional">(boleh dikosongkan)</span></label>
          <input type="email" id="email" name="email" value="<?= e($nilai['email']) ?>" maxlength="100"
                 autocomplete="email"<?= isset($galat['email']) ? ' aria-invalid="true" aria-describedby="galat-email"' : '' ?>>
          <?php if (isset($galat['email'])): ?><p class="galat" id="galat-email"><?= e($galat['email']) ?></p><?php endif; ?>
        </div>

        <div class="kolom">
          <label for="topik">Topik</label>
          <select id="topik" name="topik"<?= isset($galat['topik']) ? ' aria-invalid="true" aria-describedby="galat-topik"' : '' ?>>
            <?php foreach ($pilihanTopik as $kunci => $label): ?>
              <option value="<?= e($kunci) ?>"<?= $nilai['topik'] === $kunci ? ' selected' : '' ?>><?= e($label) ?></option>
            <?php endforeach; ?>
          </select>
          <?php if (isset($galat['topik'])): ?><p class="galat" id="galat-topik"><?= e($galat['topik']) ?></p><?php endif; ?>
        </div>

        <div class="kolom">
          <label for="pesan">Pesan</label>
          <textarea id="pesan" name="pesan" rows="6" maxlength="500" required
                    <?= isset($galat['pesan']) ? 'aria-invalid="true" aria-describedby="galat-pesan"' : 'aria-describedby="bantu-pesan"' ?>><?= e($nilai['pesan']) ?></textarea>
          <?php if (isset($galat['pesan'])): ?>
            <p class="galat" id="galat-pesan"><?= e($galat['pesan']) ?></p>
          <?php else: ?>
            <p class="bantu" id="bantu-pesan">Tulis 10 sampai 500 karakter.</p>
          <?php endif; ?>
        </div>

        <button class="btn btn-utama" type="submit">Kirim Saran</button>
      </form>
    </div>

    <aside class="fakta">
      <h2>Sebelum mengirim</h2>
      <p>Formulir ini hanya untuk latihan dan masukan. Data diperiksa oleh server (validasi sisi server), lalu ditampilkan kembali sebagai konfirmasi.</p>
      <p><strong>Data tidak disimpan secara permanen.</strong> Website ini tidak memakai database atau file penyimpanan, jadi tidak ada yang tersimpan setelah halaman ditutup.</p>
      <p>Jangan menulis data pribadi yang sensitif di formulir ini.</p>
    </aside>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
