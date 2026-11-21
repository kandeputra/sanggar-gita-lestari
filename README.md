# Sanggar Gita Lestari — Web App CMS

Website resmi + CMS Sanggar Gita Lestari, dibangun dengan **Laravel 13**, **Filament 5**, Blade, dan Tailwind CSS 4.

| Komponen | Versi / Pilihan |
|---|---|
| PHP | **8.3+** (wajib, syarat Laravel 13) |
| Laravel | 13.x |
| Filament | 5.x (Livewire 4) |
| Database | MySQL 8 / MariaDB 10.6+ |
| Frontend publik | Blade + Tailwind CSS 4 (sudah di-build di `public/build`) |
| Auth | Session Laravel + Filament Auth |
| Otorisasi | Gates & Policies |

## Fitur

**Website publik** (hanya menampilkan konten berstatus *Published*)
- `/` Beranda — hero aksara Bali, sambutan pimpinan, kegiatan mendatang, karya, seniman, galeri, CTA WhatsApp
- `/profil` Profil — sejarah, visi, misi, pimpinan, peta lokasi
- `/seniman`, `/seniman/{slug}` — daftar & detail seniman beserta karyanya
- `/karya`, `/karya/{slug}` — karya seni, filter kategori + pencarian, embed YouTube
- `/kegiatan`, `/kegiatan/{slug}` — agenda (akan datang / telah berlangsung) + dokumentasi foto
- `/galeri` — galeri foto dengan lightbox

**Dashboard admin** (`/admin`)

| Menu | Super Admin | Admin |
|---|:---:|:---:|
| Profil Sanggar | ✅ | ✅ |
| Seniman, Karya Seni, Kegiatan, Galeri | ✅ | ✅ |
| Pengguna (user & role) | ✅ | ❌ |
| Pengaturan Situs (kontak, sosmed, peta, SEO) | ✅ | ❌ |

Aturan tambahan: Super Admin tidak bisa menghapus/menurunkan role/menonaktifkan akunnya sendiri; akun nonaktif tidak bisa login.

## Arsitektur (Modular Monolith, struktur standar Laravel)

```
app/
├── Enums/                 UserRole, ContentStatus (label & warna dipakai Filament)
├── Models/                SanggarProfile, Artist, Artwork, Event, GalleryItem, User
│   └── Concerns/          HasPublishStatus (scope published), HasSlug, DeletesReplacedFiles
├── Policies/              ContentPolicy (basis) → Artist/Artwork/Event/GalleryItem, UserPolicy
├── Services/              SanggarProfileService (baca + cache + update profil single-record)
├── Http/
│   ├── Controllers/Site/  Controller website publik (tipis: query + view)
│   └── Requests/          ArtworkFilterRequest, EventFilterRequest (validasi query string)
├── Filament/
│   ├── Resources/{Modul}/ Resource + Schemas (form) + Tables + Pages per modul
│   ├── Pages/             Profil Sanggar & Pengaturan Situs (halaman single-record)
│   ├── Widgets/           Statistik konten di dashboard
│   └── Support/           FormFields (komponen form yang dipakai ulang)
└── Providers/             AppServiceProvider (Gates, view composer), Filament/AdminPanelProvider
resources/views/
├── components/            layouts/site, kartu karya/kegiatan/seniman, aksara, ornamen
├── site/                  halaman publik per modul
└── vendor/pagination/     tampilan pagination
```

**ERD**

```
users (id, name, email, password, role[super_admin|admin], is_active)

sanggar_profiles (single record: profil + kontak + sosmed + SEO)

artists (id, name, slug, specialty, bio, photo, sort_order, status)
   └─< artworks (id, artist_id → artists.id [null on delete], title, slug, category,
                 year, excerpt, description, image, video_url, is_featured, status)

events (id, title, slug, excerpt, body, image, location, starts_at, ends_at, status)
   └─< gallery_items (id, event_id → events.id [null on delete], title, image,
                      caption, sort_order, status)
```

Gambar disimpan di disk `public` (`storage/app/public/{artists,artworks,events,gallery,profile}`); file lama otomatis dihapus saat gambar diganti atau data dihapus.

## Instalasi lokal

```bash
cp .env.example .env            # isi DB_* dan ADMIN_PASSWORD
composer install
php artisan key:generate
php artisan migrate --seed      # membuat Super Admin, profil, & contoh konten
php artisan storage:link
php artisan serve               # buka http://localhost:8000 dan /admin
```

Aset CSS/JS sudah ter-build. Bila mengubah tampilan: `npm install && npm run build`.

Jalankan tes: `php artisan test`

## Deploy ke Hostinger Cloud Professional

1. **hPanel → Advanced → PHP Configuration**: pilih **PHP 8.3** (atau lebih baru). Pastikan ekstensi `intl`, `zip`, `fileinfo`, `gd` aktif.
2. **hPanel → Databases → MySQL**: buat database + user, catat nama/user/password.
3. **hPanel → Advanced → SSH Access**: aktifkan SSH, lalu login.
4. Upload project (zip lalu extract, atau `git clone`) ke folder **di luar** `public_html`, misalnya:
   ```bash
   cd ~/domains/namadomain.com
   unzip sanggar-gita-lestari.zip -d sanggar
   cd sanggar
   cp .env.example .env && nano .env
   ```
   Isi `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://namadomain.com`, `DB_HOST=localhost` (atau host dari hPanel), `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `ADMIN_EMAIL`, `ADMIN_PASSWORD`.
5. Pastikan PHP CLI juga 8.3+ (`php -v`). Bila masih versi lama, gunakan path PHP yang benar, mis. `/opt/alt/php83/usr/bin/php`.
6. Install & siapkan:
   ```bash
   composer2 install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan migrate --seed --force
   php artisan storage:link
   php artisan optimize && php artisan filament:optimize
   ```
7. Arahkan web root ke folder `public` (**Opsi A, disarankan**):
   ```bash
   cd ~/domains/namadomain.com
   mv public_html public_html_lama
   ln -s sanggar/public public_html
   ```
   Opsi B (bila symlink tidak diizinkan): lihat `public_html.htaccess.example`.
8. Buka `https://namadomain.com/admin`, login dengan `ADMIN_EMAIL` / `ADMIN_PASSWORD`, **segera ganti password**, lalu isi Profil Sanggar & Pengaturan Situs.

**Update berikutnya:** upload file baru lalu jalankan `bash deploy.sh`.

Catatan: aplikasi tidak memerlukan queue worker, Redis, maupun Node.js di server.
