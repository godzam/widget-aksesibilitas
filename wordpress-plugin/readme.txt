=== Widget Aksesibilitas Indonesia ===
Contributors: godzam
Tags: accessibility, aksesibilitas, disabilitas, dyslexia, screen reader
Requires at least: 5.0
Tested up to: 6.5
Requires PHP: 7.2
Stable tag: 1.0.0
License: MIT
License URI: https://opensource.org/licenses/MIT

Widget aksesibilitas lengkap untuk website WordPress. 20+ fitur dalam satu plugin ringan tanpa dependensi.

== Description ==

Widget Aksesibilitas Indonesia menyediakan tombol aksesibilitas melayang yang dapat dikonfigurasi
langsung dari halaman Settings WordPress Anda — tanpa menyentuh kode.

**Fitur lengkap:**

= Teks & Keterbacaan =
* Perbesar / perkecil teks
* Spasi teks (letter-spacing & word-spacing)
* Jarak baris
* Font disleksia (OpenDyslexic)
* Panduan baca

= Warna & Kontras =
* Inversi warna
* Latar gelap (dark mode)
* Mode abu-abu (grayscale)
* Filter buta warna: Deuteranopia, Protanopia, Tritanopia

= Navigasi & Motorik =
* Area klik besar (WCAG min 44×44px)
* Kursor besar
* Garis bawah link
* Tombol widget dapat diseret

= Konten & Gangguan =
* Sembunyikan gambar
* Stop GIF & video autoplay
* Mode fokus (sembunyikan sidebar, iklan, widget)
* Stop animasi CSS
* Aktifkan subtitle/CC video

**Konfigurasi via Settings:**
* Pilih warna tombol
* Atur posisi (kiri/kanan, atas/bawah)
* Pilih fitur mana yang ditampilkan
* Preview langsung di halaman settings

**Tetap kompatibel dengan embed manual** — jika Anda sudah menggunakan `window.WAKConfig`
via script manual, plugin ini tidak menimpa konfigurasi tersebut.

== Installation ==

1. Upload folder `widget-aksesibilitas` ke direktori `/wp-content/plugins/`
2. Aktifkan plugin melalui menu 'Plugins' di WordPress
3. Buka **Settings → Aksesibilitas** untuk mengatur tampilan dan fitur
4. Widget akan muncul otomatis di semua halaman website

== Frequently Asked Questions ==

= Apakah plugin ini memperlambat website? =
Tidak. File JS hanya ~23KB, dimuat di footer, dan tidak ada request ke server eksternal
kecuali font OpenDyslexic yang dimuat secara lazy (hanya saat fitur diaktifkan pengguna).

= Bisakah saya menyembunyikan fitur tertentu? =
Ya. Di halaman Settings, toggle setiap fitur on/off sesuai kebutuhan website Anda.

= Apakah bisa dipakai bersamaan dengan script manual? =
Ya. Plugin menggunakan `window.WAKConfig` yang sama dengan script manual.
Halaman settings juga menyediakan kode embed siap salin jika ingin beralih ke script manual.

= Apakah data pengguna tersimpan di server? =
Tidak. Semua preferensi pengguna tersimpan di localStorage browser mereka sendiri.

== Screenshots ==

1. Halaman Settings — konfigurasi warna, posisi, dan fitur
2. Widget aktif di frontend — tombol melayang dengan menu grid
3. Menu aksesibilitas terbuka dengan semua fitur

== Changelog ==

= 1.0.0 =
* Rilis perdana
* 20+ fitur aksesibilitas
* Halaman settings dengan preview langsung
* Kode embed manual di halaman settings
* Kompatibel dengan window.WAKConfig manual

== Upgrade Notice ==

= 1.0.0 =
Rilis perdana.
