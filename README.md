# Widget Aksesibilitas Indonesia 🇮🇩

**Widget aksesibilitas ringan, gratis, dan bebas dependensi untuk website pemerintah dan umum.**  
*Lightweight, free, zero-dependency accessibility widget for Indonesian government and general websites.*

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Ukuran](https://img.shields.io/badge/ukuran-%3C25KB-green)](widget-aksesibilitas.min.js)
[![Dependensi](https://img.shields.io/badge/dependensi-tidak%20ada-brightgreen)](widget-aksesibilitas.js)

---

## Demo

Lihat langsung di: **[disdik.sumbarprov.go.id](https://disdik.sumbarprov.go.id)**

---

## Fitur

| Fitur | Deskripsi |
|---|---|
| 🔡 Perbesar / perkecil teks | Sesuaikan ukuran font halaman |
| ↔ Spasi teks | Tambah letter-spacing dan word-spacing |
| ↕ Jarak baris | Perbesar line-height untuk keterbacaan |
| ◉ Area klik besar | Perbesar area sentuh tombol & link (min 44×44px, standar WCAG) |
| Ð Font disleksia | Ganti font ke OpenDyslexic khusus penderita disleksia |
| ◑ Inversi warna | Balik warna halaman |
| ☽ Latar gelap | Dark mode via filter CSS |
| □ Abu-abu | Mode grayscale seluruh halaman |
| ● Filter buta warna | Tiga mode: Deuteranopia, Protanopia, Tritanopia |
| ⊟ Sembunyikan gambar | Menyembunyikan semua gambar tanpa merusak layout |
| ⏹ Stop GIF / video | Bekukan animasi GIF dan hentikan video autoplay |
| ▣ Mode fokus | Sembunyikan elemen non-konten untuk fokus membaca |
| ↖ Kursor besar | Ganti kursor dengan ukuran lebih besar |
| ═ Panduan baca | Garis horizontal mengikuti gerakan kursor |
| ⏸ Stop animasi | Hentikan semua animasi dan transisi CSS |
| ⊡ Aktifkan CC | Paksa subtitle/caption video aktif |
| ↺ Reset semua | Kembalikan semua pengaturan ke default |
| 🖱 Tombol dapat diseret | Pindahkan tombol ke mana saja di layar |
| 💾 Simpan preferensi | Pengaturan tersimpan otomatis via localStorage |

---

## Instalasi

### Cara 1 — CDN (paling mudah)

```html
<script src="https://cdn.jsdelivr.net/gh/godzam/widget-aksesibilitas@latest/widget-aksesibilitas.min.js" defer></script>
```

> Ganti `godzam` dengan username GitHub Anda setelah upload.

### Cara 2 — Self-host (direkomendasikan untuk instansi pemerintah)

1. Download `widget-aksesibilitas.min.js`
2. Upload ke server Anda
3. Tambahkan tag script sebelum `</body>`:

```html
<script src="/path/to/widget-aksesibilitas.min.js" defer></script>
```

### Cara 3 — WordPress via WPCode

1. Install plugin **WPCode** (gratis)
2. WPCode → Add Snippet → HTML Snippet
3. Tempel tag script di atas
4. Pilih lokasi **Footer**
5. Save & Activate

### Cara 4 — WordPress via `functions.php`

```php
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script(
        'widget-aksesibilitas',
        get_stylesheet_directory_uri() . '/js/widget-aksesibilitas.min.js',
        [],
        '1.0',
        true // load di footer
    );
});
```

---

## Konfigurasi

Edit bagian `CFG` di baris paling atas file `widget-aksesibilitas.js`:

```javascript
var CFG = {
  color:  '#1a6fb5',  // Warna tombol utama (hex)
  vside:  'bottom',   // Posisi vertikal: 'bottom' atau 'top'
  hside:  'left',     // Posisi horizontal: 'left' atau 'right'
  vval:   '24px',     // Jarak dari tepi vertikal
  hval:   '24px',     // Jarak dari tepi horizontal
  cols:   3,          // Jumlah kolom grid menu: 2, 3, atau 4
  lang:   'id-ID'     // Kode bahasa (tidak dipakai saat ini, untuk pengembangan)
};
```

Setelah edit, simpan file dan upload ulang ke server.

---

## Cara Kerja

Widget berjalan sepenuhnya di sisi klien (browser). Tidak ada data yang dikirim ke server manapun. Semua preferensi disimpan di `localStorage` browser pengguna.

**Font disleksia** (OpenDyslexic) dimuat secara *lazy* — hanya diunduh dari jsDelivr saat pengguna pertama kali mengaktifkan fitur tersebut, menggunakan FontFace API untuk memastikan font siap sebelum diterapkan.

**Filter buta warna** menggunakan SVG `feColorMatrix` yang diinjeksi ke DOM — tidak butuh library eksternal, tidak ada request jaringan tambahan.

---

## Kompatibilitas Browser

| Browser | Dukungan |
|---|---|
| Chrome / Edge 79+ | ✅ Penuh |
| Firefox 75+ | ✅ Penuh |
| Safari 14+ | ✅ Penuh |
| Samsung Internet | ✅ Penuh |
| IE 11 | ❌ Tidak didukung |

---

## Standar Aksesibilitas

Widget ini mendukung (sebagian) standar berikut:
- **WCAG 2.1** Level AA
- **Peraturan Menteri Kominfo No. 5 Tahun 2021** tentang penyelenggaraan telekomunikasi
- **UU No. 8 Tahun 2016** tentang Penyandang Disabilitas

> ⚠️ **Catatan penting:** Widget aksesibilitas adalah pelengkap, bukan pengganti HTML yang aksesibel. Untuk kepatuhan penuh, pastikan markup HTML Anda sudah semantik, gambar memiliki `alt` yang bermakna, dan navigasi keyboard berfungsi dengan baik. Gunakan alat audit seperti [axe DevTools](https://www.deque.com/axe/) atau [Lighthouse](https://developer.chrome.com/docs/lighthouse/) untuk memeriksa halaman Anda.

---

## Pengembangan

```bash
# Clone repo
git clone https://github.com/godzam/widget-aksesibilitas.git
cd widget-aksesibilitas

# Edit file utama
# widget-aksesibilitas.js — versi terbaca (untuk pengembangan)
# widget-aksesibilitas.min.js — versi produksi (untuk deployment)
```

Tidak ada build tool yang dibutuhkan. Widget ditulis dalam vanilla JavaScript ES5 agar kompatibel dengan browser lama dan tidak memerlukan transpiler.

---

## Struktur File

```
widget-aksesibilitas/
├── widget-aksesibilitas.js       # Source utama (terbaca, berkommentar)
├── widget-aksesibilitas.min.js   # Versi produksi (diminifikasi)
├── demo/
│   └── index.html                # Halaman demo
├── LICENSE                       # MIT License
└── README.md                     # Dokumentasi ini
```

---

## Kontribusi

Kontribusi sangat disambut! Silakan:

1. Fork repo ini
2. Buat branch baru: `git checkout -b fitur/nama-fitur`
3. Commit perubahan: `git commit -m 'Tambah fitur: ...'`
4. Push ke branch: `git push origin fitur/nama-fitur`
5. Buat Pull Request

### Yang bisa dikontribusikan

- Perbaikan bug
- Fitur aksesibilitas baru
- Terjemahan label ke bahasa daerah (Minangkabau, Jawa, dll.)
- Perbaikan dokumentasi
- Contoh integrasi dengan CMS lain (Joomla, Drupal, dll.)

---

## Lisensi

[MIT License](LICENSE) — bebas digunakan, dimodifikasi, dan didistribusikan, termasuk untuk keperluan komersial, dengan tetap mencantumkan atribusi.

---

## Dibuat oleh

Dikembangkan untuk kebutuhan website instansi pemerintah daerah di Sumatera Barat, Indonesia.  
Terinspirasi dari kebutuhan nyata aksesibilitas digital di lingkungan pendidikan.

---

*Jika widget ini bermanfaat untuk instansi atau project Anda, pertimbangkan memberi ⭐ di GitHub.*
