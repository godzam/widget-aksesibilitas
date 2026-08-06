# Widget Aksesibilitas Indonesia 🇮🇩

**Widget aksesibilitas ringan, gratis, dan bebas dependensi untuk semua jenis website.**  
*Lightweight, free, zero-dependency accessibility widget for any website.*

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Ukuran](https://img.shields.io/badge/ukuran-%3C25KB-green)](widget-aksesibilitas.min.js)
[![Dependensi](https://img.shields.io/badge/dependensi-tidak%20ada-brightgreen)](widget-aksesibilitas.js)

---

## Demo

Lihat live: **[godzam.github.io/widget-aksesibilitas](https://godzam.github.io/widget-aksesibilitas/)**

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
| 🖱 Tombol dapat diseret | Pindahkan tombol ke mana saja di layar (mouse & touch) |
| 💾 Simpan preferensi | Pengaturan tersimpan otomatis via localStorage |

---

## Instalasi


### Cara 0 — Plugin WordPress (termudah) ⭐

1. Download **[widget-aksesibilitas.zip](https://github.com/godzam/widget-aksesibilitas/raw/main/wordpress-plugin/widget-aksesibilitas.zip)**
2. WordPress Admin → Plugins → Add New → Upload Plugin
3. Upload ZIP → Install Now → Activate
4. **Settings → Aksesibilitas** — atur warna, posisi, dan fitur via UI

Plugin menyediakan halaman settings lengkap dengan preview tombol langsung.

### Cara 1 — CDN (paling mudah)

```html
<!-- Letakkan sebelum </body> -->
<script>
window.WAKConfig = {
  color: '#1a6fb5'   // sesuaikan warna
};
</script>
<script src="https://cdn.jsdelivr.net/gh/godzam/widget-aksesibilitas@latest/widget-aksesibilitas.min.js" defer></script>
```

### Cara 2 — Self-host (direkomendasikan)

1. Download `widget-aksesibilitas.min.js`
2. Upload ke server Anda
3. Tambahkan sebelum `</body>`:

```html
<script>
window.WAKConfig = { color: '#1a6fb5' };
</script>
<script src="/path/to/widget-aksesibilitas.min.js" defer></script>
```

### Cara 3 — WordPress via WPCode

1. Install plugin **WPCode** (gratis di WordPress.org)
2. WPCode → Add Snippet → HTML Snippet
3. Tempel kode berikut, pilih lokasi **Footer**, Save & Activate:

```html
<script>
window.WAKConfig = {
  color: '#1a6fb5',
  hside: 'right',
  disabled: ['cc']
};
</script>
<script src="https://cdn.jsdelivr.net/gh/godzam/widget-aksesibilitas@latest/widget-aksesibilitas.min.js" defer></script>
```

### Cara 4 — WordPress via `functions.php`

```php
add_action('wp_head', function() { ?>
<script>
window.WAKConfig = { color: '#1a6fb5', cols: 3 };
</script>
<?php });

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script(
        'widget-aksesibilitas',
        get_stylesheet_directory_uri() . '/js/widget-aksesibilitas.min.js',
        [], '1.0', true
    );
});
```

---

## Konfigurasi

Semua konfigurasi dilakukan via `window.WAKConfig` — **harus di-set sebelum tag script widget**.

```html
<script>
window.WAKConfig = {

  // ── Tampilan tombol ─────────────────────────────────────
  color: '#1a6fb5',   // warna tombol utama (hex)
  vside: 'bottom',    // posisi vertikal: 'bottom' atau 'top'
  hside: 'left',      // posisi horizontal: 'left' atau 'right'
  vval:  '24px',      // jarak dari tepi vertikal
  hval:  '24px',      // jarak dari tepi horizontal
  cols:  3,           // kolom grid menu: 2, 3, atau 4

  // ── Fitur yang disembunyikan ─────────────────────────────
  // Hapus komentar (//) pada baris yang ingin disembunyikan
  disabled: [
    // 'fontUp',    // perbesar teks
    // 'fontDn',    // perkecil teks
    // 'spasi',     // spasi teks
    // 'lineH',     // jarak baris
    // 'bigclick',  // area klik besar
    // 'dyslexia',  // font disleksia
    // 'invert',    // inversi warna
    // 'dark',      // latar gelap
    // 'gray',      // abu-abu
    // 'deuter',    // buta warna Deuteranopia
    // 'protan',    // buta warna Protanopia
    // 'tritan',    // buta warna Tritanopia
    // 'ulink',     // garis bawah link
    // 'hideimg',   // sembunyikan gambar
    // 'stopgif',   // stop GIF/video
    // 'focus',     // mode fokus
    // 'cursor',    // kursor besar
    // 'guide',     // panduan baca
    // 'anim',      // stop animasi
    // 'cc',        // aktifkan CC video
    // 'reset',     // reset semua
  ]
};
</script>
```

### Contoh konfigurasi umum

**Website berita / portal:**
```javascript
window.WAKConfig = {
  color: '#c0392b', cols: 3, hside: 'right',
  disabled: ['cc', 'stopgif']
};
```

**Sekolah / pendidikan:**
```javascript
window.WAKConfig = {
  color: '#2563eb', cols: 3,
  disabled: ['deuter', 'protan', 'tritan', 'cc']
};
```

**Minimalis (fitur dasar saja):**
```javascript
window.WAKConfig = {
  color: '#374151', cols: 2,
  disabled: ['deuter','protan','tritan','stopgif','cc','focus','bigclick']
};
```

---

## Cara Kerja

Widget berjalan sepenuhnya di sisi klien (browser). **Tidak ada data yang dikirim ke server manapun.** Semua preferensi disimpan di `localStorage` browser pengguna.

**Font disleksia** (OpenDyslexic) dimuat secara *lazy* via FontFace API — hanya diunduh saat pengguna pertama kali mengaktifkan fitur tersebut.

**Filter buta warna** menggunakan SVG `feColorMatrix` yang diinjeksi ke DOM — tidak butuh library eksternal.

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

Widget ini membantu memenuhi (sebagian) standar:
- **WCAG 2.1** Level AA
- **UU No. 8 Tahun 2016** tentang Penyandang Disabilitas
- **Peraturan Menteri Kominfo No. 5 Tahun 2021**

> ⚠️ Widget aksesibilitas adalah **pelengkap**, bukan pengganti HTML yang aksesibel. Pastikan markup Anda sudah semantik, gambar memiliki `alt`, dan navigasi keyboard berfungsi. Gunakan [axe DevTools](https://www.deque.com/axe/) atau [Lighthouse](https://developer.chrome.com/docs/lighthouse/) untuk audit lengkap.

---

## Pengembangan

```bash
git clone https://github.com/godzam/widget-aksesibilitas.git
cd widget-aksesibilitas
```

Tidak ada build tool yang dibutuhkan. Ditulis dalam vanilla JavaScript ES5 tanpa transpiler.

Struktur:
```
widget-aksesibilitas/
├── widget-aksesibilitas.js       # Source (terbaca, berkommentar)
├── widget-aksesibilitas.min.js   # Produksi (diminifikasi)
├── demo/
│   └── index.html                # Halaman demo
├── LICENSE
└── README.md
```

---

## Kontribusi

Kontribusi sangat disambut:

1. Fork repo ini
2. Buat branch: `git checkout -b fitur/nama-fitur`
3. Commit: `git commit -m 'Tambah fitur: ...'`
4. Push: `git push origin fitur/nama-fitur`
5. Buat Pull Request

Yang bisa dikontribusikan: perbaikan bug, fitur aksesibilitas baru, terjemahan label ke bahasa daerah, integrasi CMS lain (Joomla, Drupal), dan perbaikan dokumentasi.

---

## Lisensi

[MIT License](LICENSE) — bebas digunakan, dimodifikasi, dan didistribusikan termasuk untuk keperluan komersial, dengan tetap mencantumkan atribusi.

---

*Jika widget ini bermanfaat untuk project Anda, pertimbangkan memberi ⭐ di GitHub.*

