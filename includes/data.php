<?php
/**
 * includes/data.php
 * ------------------------------------------------------------
 * Pusat data dan fungsi bantu untuk website JEJAK BUDAYA.
 * Semua halaman memanggil file ini dengan: require 'includes/data.php';
 *
 * Isi file:
 *   1. Konstanta dan fungsi bantu (e, tampilGambar, cariGambar)
 *   2. Data (array PHP): kategori, budaya, artikel, statistik, warisan digital
 *   3. Fungsi pencarian/penyaringan
 *   4. Fungsi tampilan kartu yang dipakai ulang di beberapa halaman
 * ------------------------------------------------------------
 */

const NAMA_SITUS = 'JEJAK BUDAYA';
const TAGLINE    = 'Menjaga Warisan, Menyambut Masa Depan.';
const DIR_GAMBAR = __DIR__ . '/../img/';

/* ============================================================
   1. FUNGSI BANTU
   ============================================================ */

/** Singkatan htmlspecialchars() agar penulisan di template lebih ringkas. */
function e($teks): string
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

/** Mencari file gambar di folder img/ (jpg, jpeg, png, atau webp). */
function cariGambar(string $nama): ?string
{
    foreach (['jpg', 'jpeg', 'png', 'webp'] as $ekstensi) {
        if (is_file(DIR_GAMBAR . $nama . '.' . $ekstensi)) {
            return 'img/' . $nama . '.' . $ekstensi;
        }
    }
    return null;
}

/**
 * Menampilkan gambar. Jika file belum ada di folder img/,
 * ditampilkan panel pengganti bermotif batik (fallback tanpa JavaScript).
 */
function tampilGambar(string $nama, string $alt, int $hue = 30, bool $lazy = true): string
{
    $path = cariGambar($nama);
    if ($path !== null) {
        $loading = $lazy ? ' loading="lazy"' : '';
        return '<img src="' . e($path) . '" alt="' . e($alt) . '"' . $loading . '>';
    }
    return '<div class="ph" style="--h:' . (int) $hue . '" role="img" aria-label="' . e($alt) . '">'
         . '<span>' . e($alt) . '</span></div>';
}

/** Mengecek apakah $teks mengandung $kata (tidak peka huruf besar/kecil). */
function mengandung(string $teks, string $kata): bool
{
    if (function_exists('mb_stripos')) {
        return mb_stripos($teks, $kata) !== false;
    }
    return stripos($teks, $kata) !== false;
}

/** Membaca parameter ?id= dari URL. Mengembalikan angka bulat atau null bila tidak valid. */
function ambilIdDariUrl(): ?int
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    return ($id === false || $id === null || $id < 1) ? null : $id;
}

/* ============================================================
   2. DATA
   ============================================================ */

$daftarKategori = [
    'seni'       => 'Seni Pertunjukan',
    'kriya'      => 'Kriya & Busana',
    'arsitektur' => 'Arsitektur',
    'musik'      => 'Musik',
    'tradisi'    => 'Tradisi & Upacara',
];

/*
 * Data budaya. Kunci array = ID budaya (dipakai pada detail-budaya.php?id=...).
 * unggulan => tampil di Beranda | bali => tampil di halaman Budaya Bali
 */
$budaya = [
    1 => [
        'nama' => 'Tari Kecak', 'daerah' => 'Bali', 'kategori' => 'seni',
        'ringkas' => 'Tarian massal dengan puluhan penari laki-laki yang duduk melingkar dan melantunkan "cak" secara bersahut-sahutan, tanpa iringan gamelan.',
        'isi' => [
            'Tari Kecak dikenal lewat suara. Puluhan penari laki-laki duduk melingkar dan mengulang kata "cak" dengan irama yang saling bersahutan. Suara itulah yang menggantikan gamelan, sehingga pertunjukan terasa seperti satu tubuh besar yang bernapas bersama.',
            'Kecak berkembang di Bali pada tahun 1930-an dari ritual sanghyang, yaitu upacara yang melibatkan keadaan trans. Pada masa itu, seniman Bali bekerja sama dengan pelukis asal Jerman, Walter Spies, untuk mengolahnya menjadi pertunjukan yang memuat kisah Ramayana, seperti penculikan Sita dan peran Hanoman.',
            'Kini Kecak dapat ditonton di banyak tempat di Bali. Salah satu pertunjukan yang terkenal digelar menjelang matahari terbenam di kawasan Pura Uluwatu.',
        ],
        'fakta' => [['Asal', 'Bali'], ['Iringan', 'Suara penari (tanpa gamelan)'], ['Cerita', 'Episode Ramayana'], ['Akar tradisi', 'Ritual sanghyang']],
        'gambar' => 'kecak', 'hue' => 18, 'unggulan' => true, 'bali' => true,
    ],
    2 => [
        'nama' => 'Batik', 'daerah' => 'Jawa', 'kategori' => 'kriya',
        'ringkas' => 'Kain bergambar yang dibuat dengan teknik menutup bagian kain memakai malam (lilin) sebelum diwarnai. Setiap motif punya makna.',
        'isi' => [
            'Batik dibuat dengan menutup bagian kain menggunakan malam atau lilin panas, lalu kain dicelup pewarna. Bagian yang tertutup malam tidak menyerap warna, sehingga terbentuklah gambar. Proses ini diulang beberapa kali untuk menghasilkan banyak warna.',
            'Ada tiga cara pembuatan yang umum: batik tulis memakai canting, batik cap memakai stempel tembaga, dan batik kombinasi memakai keduanya. Motif seperti parang, kawung, dan mega mendung masing-masing punya cerita dan daerah yang berbeda.',
            'UNESCO menetapkan batik Indonesia sebagai Warisan Budaya Takbenda pada 2 Oktober 2009. Tanggal itu kini diperingati sebagai Hari Batik Nasional.',
        ],
        'fakta' => [['Asal', 'Jawa dan berbagai daerah lain'], ['Alat utama', 'Canting, malam, dan pewarna'], ['Motif terkenal', 'Parang, kawung, mega mendung'], ['UNESCO', '2 Oktober 2009']],
        'gambar' => 'batik', 'hue' => 38, 'unggulan' => true, 'bali' => false,
    ],
    3 => [
        'nama' => 'Rumah Gadang', 'daerah' => 'Sumatera Barat', 'kategori' => 'arsitektur',
        'ringkas' => 'Rumah adat Minangkabau berbentuk panggung dengan atap gonjong yang melengkung runcing ke atas.',
        'isi' => [
            'Rumah Gadang adalah rumah adat suku Minangkabau. Ciri yang paling mudah dikenali adalah atap gonjong, yaitu atap melengkung dengan ujung runcing yang sering dikaitkan dengan bentuk tanduk kerbau.',
            'Rumah ini berbentuk panggung dan dihiasi ukiran kayu pada dindingnya. Dalam adat Minangkabau yang menganut garis keturunan ibu (matrilineal), rumah gadang diwariskan melalui perempuan dan menjadi pusat kehidupan keluarga besar.',
            'Rumah Gadang bukan hanya tempat tinggal. Di sanalah musyawarah keluarga dan berbagai upacara adat dilaksanakan.',
        ],
        'fakta' => [['Suku', 'Minangkabau'], ['Ciri utama', 'Atap gonjong'], ['Bentuk', 'Rumah panggung berukir'], ['Pewarisan', 'Garis keturunan ibu']],
        'gambar' => 'rumah-gadang', 'hue' => 8, 'unggulan' => true, 'bali' => false,
    ],
    4 => [
        'nama' => 'Angklung', 'daerah' => 'Jawa Barat', 'kategori' => 'musik',
        'ringkas' => 'Alat musik dari tabung bambu yang berbunyi ketika digoyangkan. Satu angklung biasanya menghasilkan satu nada.',
        'isi' => [
            'Angklung terbuat dari tabung-tabung bambu yang dirangkai pada bingkai. Ketika digoyangkan, tabung bambu bergetar dan menghasilkan nada. Karena satu angklung umumnya hanya memiliki satu nada, sebuah lagu baru terdengar utuh bila banyak orang memainkannya bersama.',
            'Pada tahun 1938, Daeng Soetigna memperkenalkan angklung dengan tangga nada diatonis sehingga bisa memainkan lagu-lagu populer dan musik dunia. Sejak itu angklung dipelajari di banyak sekolah.',
            'UNESCO mengakui angklung sebagai Warisan Budaya Takbenda pada tahun 2010. Bermain angklung melatih kekompakan, karena setiap pemain bertanggung jawab atas nadanya masing-masing.',
        ],
        'fakta' => [['Bahan', 'Bambu'], ['Cara bermain', 'Digoyangkan'], ['Pelopor angklung diatonis', 'Daeng Soetigna (1938)'], ['UNESCO', '2010']],
        'gambar' => 'angklung', 'hue' => 85, 'unggulan' => true, 'bali' => false,
    ],
    5 => [
        'nama' => 'Wayang Kulit', 'daerah' => 'Jawa', 'kategori' => 'seni',
        'ringkas' => 'Pertunjukan bayangan dari boneka kulit yang digerakkan dalang, diiringi gamelan, dengan kisah yang sarat nilai kehidupan.',
        'isi' => [
            'Dalam wayang kulit, dalang menggerakkan boneka kulit yang ditatah halus di belakang layar putih (kelir). Cahaya lampu menyorot dari belakang sehingga penonton melihat bayangan tokoh-tokohnya. Dalang juga mengisi suara, memimpin gamelan, dan mengatur jalan cerita.',
            'Kisah yang dibawakan banyak berasal dari Mahabharata dan Ramayana, lalu diolah dengan konteks lokal. Tokoh punakawan seperti Semar, Gareng, Petruk, dan Bagong menjadi penyampai nasihat sekaligus humor.',
            'UNESCO mengakui wayang Indonesia sebagai Warisan Budaya Takbenda pada tahun 2008. Kini dalang juga mulai menghadirkan wayang melalui siaran daring agar mudah dinikmati generasi muda.',
        ],
        'fakta' => [['Pelaku utama', 'Dalang'], ['Bahan boneka', 'Kulit yang ditatah'], ['Iringan', 'Gamelan'], ['UNESCO', '2008']],
        'gambar' => 'wayang-kulit', 'hue' => 30, 'unggulan' => true, 'bali' => false,
    ],
    6 => [
        'nama' => 'Tenun Ikat', 'daerah' => 'Nusa Tenggara Timur', 'kategori' => 'kriya',
        'ringkas' => 'Kain tenun yang motifnya dibentuk dengan mengikat dan mewarnai benang sebelum ditenun.',
        'isi' => [
            'Pada tenun ikat, motif dibuat lebih dulu pada benang. Benang diikat pada bagian tertentu, lalu dicelup pewarna. Bagian yang terikat tidak terkena warna. Setelah benang dilepas dan ditenun, motif muncul pada kain.',
            'Di Nusa Tenggara Timur, tenun ikat dibuat di banyak wilayah, di antaranya Sumba, Flores, Timor, dan Rote. Setiap daerah punya warna, motif, dan makna sendiri. Kain tenun dipakai dalam upacara adat, pernikahan, dan sebagai tanda identitas.',
            'Pewarna alami dari tumbuhan, seperti nila (indigo) untuk warna biru, masih digunakan oleh banyak penenun. Satu helai kain dapat dikerjakan berminggu-minggu bahkan lebih lama.',
        ],
        'fakta' => [['Asal', 'Nusa Tenggara Timur'], ['Teknik', 'Benang diikat lalu dicelup'], ['Fungsi', 'Busana adat dan penanda identitas'], ['Pewarna tradisional', 'Tumbuhan, misalnya nila']],
        'gambar' => 'tenun-ikat', 'hue' => 355, 'unggulan' => true, 'bali' => false,
    ],
    7 => [
        'nama' => 'Ogoh-ogoh', 'daerah' => 'Bali', 'kategori' => 'tradisi',
        'ringkas' => 'Patung raksasa yang diarak keliling desa pada malam sebelum Nyepi sebagai lambang sifat-sifat buruk.',
        'isi' => [
            'Ogoh-ogoh adalah patung besar berwujud makhluk menyeramkan yang menggambarkan bhuta kala, yaitu kekuatan negatif dalam kepercayaan Hindu Bali. Patung dibuat berkelompok oleh pemuda banjar, dengan rangka bambu dan hiasan yang dikerjakan berminggu-minggu.',
            'Pada malam pengerupukan, sehari sebelum Nyepi, ogoh-ogoh diarak keliling desa diiringi gamelan baleganjur dan obor. Arak-arakan ini menjadi simbol mengusir pengaruh buruk sebelum memasuki hari Nyepi yang hening.',
            'Ogoh-ogoh menunjukkan bagaimana tradisi hidup bersama kreativitas anak muda. Setiap tahun bentuk, ukuran, dan temanya berbeda.',
        ],
        'fakta' => [['Waktu', 'Malam pengerupukan, sehari sebelum Nyepi'], ['Makna', 'Menggambarkan bhuta kala'], ['Pembuat', 'Pemuda banjar'], ['Iringan', 'Gamelan baleganjur']],
        'gambar' => 'ogoh-ogoh', 'hue' => 280, 'unggulan' => false, 'bali' => true,
    ],
    8 => [
        'nama' => 'Arsitektur Pura', 'daerah' => 'Bali', 'kategori' => 'arsitektur',
        'ringkas' => 'Tempat ibadah umat Hindu Bali yang ditata dalam beberapa halaman, dengan gerbang berukir dan bangunan bertingkat.',
        'isi' => [
            'Pura di Bali umumnya terdiri atas tiga halaman yang disebut tri mandala: nista mandala (halaman luar), madya mandala (halaman tengah), dan utama mandala (halaman dalam yang paling suci). Semakin ke dalam, semakin suci ruangnya.',
            'Pintu masuk ke halaman tengah biasanya berupa candi bentar, yaitu gerbang yang seperti satu bangunan yang dibelah. Di halaman utama terdapat pelinggih dan meru, bangunan beratap tumpang bersusun yang menjadi tempat persemayaman dewa-dewi.',
            'Bahan yang banyak digunakan adalah batu padas dan bata merah dengan ukiran halus. Sistem irigasi subak di Bali dan beberapa pura di dalamnya ditetapkan UNESCO sebagai Warisan Dunia pada tahun 2012.',
        ],
        'fakta' => [['Tata ruang', 'Tri mandala'], ['Gerbang', 'Candi bentar dan kori agung'], ['Bangunan khas', 'Meru dan pelinggih'], ['Warisan Dunia UNESCO', 'Lanskap Budaya Provinsi Bali, 2012']],
        'gambar' => 'pura', 'hue' => 45, 'unggulan' => false, 'bali' => true,
    ],
    9 => [
        'nama' => 'Gamelan Bali', 'daerah' => 'Bali', 'kategori' => 'musik',
        'ringkas' => 'Ansambel alat musik pukul dengan tempo cepat dan pola bersahutan yang dinamis.',
        'isi' => [
            'Gamelan Bali terdiri atas alat-alat pukul seperti gong, metalofon (gangsa), kendang, dan cengceng. Dibandingkan gamelan Jawa yang terkesan mengalun, gamelan Bali terkenal dengan perubahan tempo dan dinamika yang tajam.',
            'Salah satu ciri khasnya adalah kotekan, yaitu dua pemain atau lebih memainkan pola yang berbeda dan saling mengisi hingga terdengar seperti satu melodi yang cepat. Gaya gong kebyar berkembang pada awal abad ke-20 dan sangat berpengaruh.',
            'Gamelan dimainkan dalam upacara keagamaan, mengiringi tari, dan dalam pertunjukan. UNESCO menetapkan gamelan sebagai Warisan Budaya Takbenda pada tahun 2021.',
        ],
        'fakta' => [['Alat utama', 'Gong, gangsa, kendang, cengceng'], ['Teknik khas', 'Kotekan'], ['Gaya populer', 'Gong kebyar'], ['UNESCO', '2021']],
        'gambar' => 'gamelan-bali', 'hue' => 48, 'unggulan' => false, 'bali' => true,
    ],
    10 => [
        'nama' => 'Tradisi dan Upacara Adat Bali', 'daerah' => 'Bali', 'kategori' => 'tradisi',
        'ringkas' => 'Rangkaian upacara yang mengatur hubungan manusia dengan Tuhan, sesama, dan alam, seperti Nyepi, Galungan, dan ngaben.',
        'isi' => [
            'Kehidupan masyarakat Hindu Bali berjalan bersama rangkaian upacara yang disebut yadnya. Ada lima jenis yadnya (panca yadnya) yang ditujukan kepada Tuhan, para resi, leluhur, sesama manusia, dan alam.',
            'Nyepi adalah Tahun Baru Saka. Pada hari itu umat menjalankan catur brata penyepian: tidak menyalakan api atau lampu, tidak bekerja, tidak bepergian, dan tidak bersenang-senang. Pulau menjadi sunyi selama sehari. Galungan dan Kuningan memperingati kemenangan kebaikan atas keburukan. Ngaben adalah upacara untuk mengantar leluhur yang telah meninggal.',
            'Upacara-upacara ini melibatkan banyak seni sekaligus: sesajen, tari, musik gamelan, dan busana adat. Itulah sebabnya budaya Bali terasa menyatu dengan kehidupan sehari-hari.',
        ],
        'fakta' => [['Konsep', 'Panca yadnya'], ['Tahun Baru', 'Nyepi (Tahun Baru Saka)'], ['Upacara kematian', 'Ngaben'], ['Hari raya', 'Galungan dan Kuningan']],
        'gambar' => 'upacara-bali', 'hue' => 22, 'unggulan' => false, 'bali' => true,
    ],
];

/* Artikel budaya. Kunci array = ID artikel (detail-artikel.php?id=...) */
$artikel = [
    1 => [
        'judul' => 'Mengapa Budaya Tradisional Harus Tetap Hidup?',
        'ringkas' => 'Budaya menyimpan cara berpikir, nilai, dan pengetahuan yang dibangun leluhur. Jika berhenti dipraktikkan, semuanya ikut hilang.',
        'penulis' => 'Tim Jejak Budaya', 'baca' => '3 menit', 'gambar' => 'cerita-1', 'hue' => 30,
        'isi' => [
            'Budaya tradisional bukan sekadar benda lama di museum. Di dalam sebuah kain batik ada pengetahuan tentang pewarna alam. Di dalam sebuah tarian ada cerita tentang cara masyarakat memandang alam dan sesamanya. Di dalam sebuah rumah adat ada pelajaran tentang cara hidup bersama.',
            'Pengetahuan seperti ini biasanya diwariskan dari mulut ke mulut dan dari tangan ke tangan. Karena itu ia sangat bergantung pada orang yang masih mempraktikkannya. Ketika penenun terakhir berhenti menenun, atau ketika dalang tidak lagi punya murid, pengetahuan itu bisa hilang tanpa sempat tertulis.',
            'Budaya yang hidup juga memberi manfaat nyata. Ia menumbuhkan rasa memiliki, memperkuat identitas, dan menjadi sumber penghasilan bagi pengrajin dan seniman. Kuncinya adalah menjaga makna aslinya sambil membuka ruang agar tradisi bisa berkembang.',
            'Melestarikan bukan berarti membekukan. Budaya tetap hidup ketika masih dipakai, diajarkan, dan dinikmati oleh generasi yang baru.',
        ],
    ],
    2 => [
        'judul' => 'Peran Generasi Muda dalam Melestarikan Budaya',
        'ringkas' => 'Pelestarian tidak harus dimulai dari hal besar. Belajar, mendokumentasikan, dan membagikan sudah menjadi langkah nyata.',
        'penulis' => 'Tim Jejak Budaya', 'baca' => '3 menit', 'gambar' => 'cerita-2', 'hue' => 210,
        'isi' => [
            'Generasi muda sering dianggap jauh dari budaya tradisional. Padahal anak muda punya kekuatan yang sangat dibutuhkan: kemampuan memakai teknologi dan jaringan pertemanan yang luas.',
            'Langkah pertama adalah belajar. Ikut sanggar, belajar bermain angklung di sekolah, atau bertanya kepada kakek dan nenek tentang tradisi di kampung. Langkah kedua adalah mendokumentasikan: merekam wawancara dengan pengrajin, memotret proses pembuatan kain, atau menulis ulang cerita rakyat.',
            'Langkah ketiga adalah berbagi. Konten yang disusun dengan menghormati sumbernya dapat membuat budaya daerah dikenal oleh teman di kota lain. Pastikan informasi sudah dicek dan sebutkan siapa yang mengajarkannya.',
            'Setiap orang bisa mengambil peran, sekecil apa pun. Yang penting adalah mulai dari budaya yang paling dekat dengan kita.',
        ],
    ],
    3 => [
        'judul' => 'Dari Tradisi ke Teknologi: Budaya dalam Dunia Digital',
        'ringkas' => 'Arsip daring, tur virtual, dan media sosial membuka cara baru untuk mengenal budaya tanpa meninggalkan akarnya.',
        'penulis' => 'Tim Jejak Budaya', 'baca' => '4 menit', 'gambar' => 'cerita-3', 'hue' => 255,
        'isi' => [
            'Teknologi digital memberi budaya tempat baru untuk hidup. Foto, video, dan rekaman suara dapat menyimpan pertunjukan yang dahulu hanya bisa disaksikan langsung. Data tentang motif, alat, dan cerita dapat dikumpulkan dalam arsip daring sehingga lebih mudah dipelajari.',
            'Tur virtual memungkinkan orang menjelajahi situs budaya dari rumah. Media sosial membantu seniman muda memperkenalkan karyanya. Cerita digital menyampaikan dongeng dan sejarah dengan cara yang akrab bagi anak-anak sekarang.',
            'Meski begitu, teknologi tidak boleh menggantikan pengalaman aslinya. Layar tidak dapat menghadirkan aroma dupa di pura atau getaran gamelan di dada. Ada pula hal yang perlu dijaga, yaitu hak cipta, izin dari komunitas, dan ketepatan informasi.',
            'Teknologi sebaiknya diposisikan sebagai jembatan. Ia membawa orang kepada budaya, lalu mengajak mereka datang, belajar, dan ikut merawatnya.',
        ],
    ],
];

/* Statistik budaya. Setiap angka disertai konteks dan sumber. */
$statistik = [
    ['angka' => '1.340', 'label' => 'suku bangsa',
     'konteks' => 'Jumlah suku bangsa di Indonesia yang disebut oleh Menteri Kebudayaan.',
     'sumber' => 'Kementerian Kebudayaan RI, dilaporkan RRI (9 November 2025)'],
    ['angka' => '718', 'label' => 'bahasa daerah',
     'konteks' => 'Bahasa daerah di Indonesia, sekitar 10 persen dari seluruh bahasa di dunia menurut pernyataan yang sama.',
     'sumber' => 'Kementerian Kebudayaan RI, dilaporkan RRI (9 November 2025)'],
    ['angka' => '2.727', 'label' => 'Warisan Budaya Takbenda Indonesia',
     'konteks' => 'Total yang ditetapkan secara nasional, setelah penambahan 514 elemen baru pada 2025.',
     'sumber' => 'Kementerian Kebudayaan RI, dilaporkan RRI (15 Desember 2025)'],
    ['angka' => '16', 'label' => 'elemen diakui UNESCO',
     'konteks' => 'Warisan budaya takbenda Indonesia yang telah diakui UNESCO menurut keterangan pemerintah.',
     'sumber' => 'Kementerian Kebudayaan RI, dilaporkan RRI (15 Desember 2025)'],
];
$catatanStatistik = 'Angka diambil dari pernyataan resmi pemerintah per Desember 2025 dan dapat berubah. Cara menghitung elemen UNESCO juga berbeda antar sumber, jadi periksa ich.unesco.org untuk data terbaru.';

/* Bagian Warisan Budaya di Era Digital. Ikon SVG statis (tanpa JavaScript). */
$warisanDigital = [
    [
        'judul' => 'Arsip Digital',
        'isi' => 'Dokumentasi dan penyimpanan informasi budaya dalam bentuk foto, video, rekaman suara, dan naskah. Arsip yang rapi membantu generasi mendatang mempelajari tradisi yang mungkin sudah jarang dipraktikkan.',
        'contoh' => 'Contoh: merekam proses membatik lengkap dengan penjelasan pengrajinnya.',
        'ikon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="5" rx="1"/><path d="M5 9v9a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9"/><path d="M10 13h4"/></svg>',
    ],
    [
        'judul' => 'Virtual Tour',
        'isi' => 'Mengenal situs budaya melalui pengalaman virtual. Foto 360 derajat, video, dan model 3D memungkinkan orang menjelajahi candi, museum, atau rumah adat dari mana saja.',
        'contoh' => 'Contoh: menelusuri halaman-halaman pura lewat tur foto panorama.',
        'ikon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.7 3.8 5.7 3.8 9s-1.3 6.3-3.8 9c-2.5-2.7-3.8-5.7-3.8-9S9.5 5.7 12 3z"/></svg>',
    ],
    [
        'judul' => 'Media Sosial',
        'isi' => 'Memperkenalkan tradisi kepada generasi muda lewat platform yang mereka gunakan setiap hari. Konten singkat yang menarik dapat membuka rasa ingin tahu tentang budaya daerah.',
        'contoh' => 'Contoh: video singkat tentang cara memainkan angklung.',
        'ikon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="6" r="2.5"/><circle cx="18" cy="18" r="2.5"/><path d="M8.2 10.8l7.6-3.6M8.2 13.2l7.6 3.6"/></svg>',
    ],
    [
        'judul' => 'Digital Storytelling',
        'isi' => 'Menyampaikan cerita budaya melalui media digital, seperti video, animasi, podcast, atau buku interaktif. Cerita yang disusun baik membuat nilai tradisi lebih mudah dipahami.',
        'contoh' => 'Contoh: animasi pendek tentang kisah punakawan dalam wayang.',
        'ikon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5h7a3 3 0 0 1 3 3v11a2 2 0 0 0-2-2H4z"/><path d="M20 5h-3a3 3 0 0 0-3 3"/><path d="M20 5v12h-4"/></svg>',
    ],
];

/* ============================================================
   3. FUNGSI PENCARIAN DAN PENYARINGAN
   ============================================================ */

/** Menyaring daftar budaya berdasarkan kategori dan kata kunci. */
function saringBudaya(array $daftar, string $kategori = '', string $kataKunci = ''): array
{
    $hasil = [];
    foreach ($daftar as $id => $item) {
        if ($kategori !== '' && $item['kategori'] !== $kategori) {
            continue;
        }
        if ($kataKunci !== '') {
            $gabungan = $item['nama'] . ' ' . $item['daerah'] . ' ' . $item['ringkas'];
            if (!mengandung($gabungan, $kataKunci)) {
                continue;
            }
        }
        $hasil[$id] = $item;
    }
    return $hasil;
}

/* ============================================================
   4. FUNGSI TAMPILAN (dipakai ulang agar kartu tidak ditulis berulang)
   ============================================================ */

/** Kartu budaya. Dipakai di Beranda, Jelajah Budaya, dan halaman detail. */
function kartuBudaya(int $id, array $b, array $daftarKategori): void
{
    ?>
    <article class="kartu kartu-budaya">
      <a class="kartu-media" href="detail-budaya.php?id=<?= $id ?>" tabindex="-1" aria-hidden="true">
        <?= tampilGambar($b['gambar'], $b['nama'], $b['hue']) ?>
      </a>
      <div class="kartu-isi">
        <p class="meta"><?= e($b['daerah']) ?> &middot; <?= e($daftarKategori[$b['kategori']] ?? '') ?></p>
        <h3><a href="detail-budaya.php?id=<?= $id ?>"><?= e($b['nama']) ?></a></h3>
        <p><?= e($b['ringkas']) ?></p>
        <a class="tautan-lanjut" href="detail-budaya.php?id=<?= $id ?>">Pelajari Lebih Lanjut<span class="sr-only">: <?= e($b['nama']) ?></span></a>
      </div>
    </article>
    <?php
}

/** Kartu artikel. Dipakai di Beranda dan halaman Cerita Budaya. */
function kartuArtikel(int $id, array $a): void
{
    ?>
    <article class="kartu kartu-artikel">
      <a class="kartu-media" href="detail-artikel.php?id=<?= $id ?>" tabindex="-1" aria-hidden="true">
        <?= tampilGambar($a['gambar'], $a['judul'], $a['hue']) ?>
      </a>
      <div class="kartu-isi">
        <p class="meta">Waktu baca <?= e($a['baca']) ?></p>
        <h3><a href="detail-artikel.php?id=<?= $id ?>"><?= e($a['judul']) ?></a></h3>
        <p><?= e($a['ringkas']) ?></p>
        <a class="tautan-lanjut" href="detail-artikel.php?id=<?= $id ?>">Baca Artikel<span class="sr-only">: <?= e($a['judul']) ?></span></a>
      </div>
    </article>
    <?php
}

/** Kartu Warisan Digital (ikon SVG statis). */
function kartuDigital(array $w): void
{
    ?>
    <article class="kartu kartu-digital">
      <span class="ikon"><?= $w['ikon'] /* SVG statis dari data.php, bukan input pengguna */ ?></span>
      <h3><?= e($w['judul']) ?></h3>
      <p><?= e($w['isi']) ?></p>
      <p class="contoh"><?= e($w['contoh']) ?></p>
    </article>
    <?php
}

/** Blok statistik lengkap dengan konteks dan sumber. */
function blokStatistik(array $statistik, string $catatan): void
{
    ?>
    <div class="statistik-grid">
      <?php foreach ($statistik as $s): ?>
        <figure class="statistik">
          <p class="angka"><?= e($s['angka']) ?></p>
          <figcaption>
            <strong><?= e($s['label']) ?></strong>
            <span><?= e($s['konteks']) ?></span>
            <small>Sumber: <?= e($s['sumber']) ?></small>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
    <p class="catatan-statistik"><?= e($catatan) ?></p>
    <?php
}
