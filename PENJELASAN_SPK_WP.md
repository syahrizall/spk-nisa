## Tujuan

Dokumen ini menjelaskan dengan ringkas dan praktis:
- Di mana proses normalisasi dilakukan di kode
- Di mana perhitungan metode Weighted Product (WP) dilakukan
- ERD (Entity Relationship Diagram) dan penjelasan struktur data

Semua penjelasan dibuat agar pembaca yang belum mengenal aplikasi bisa memahami alur kerjanya.

## Ringkasan Alur Aplikasi

1. Data peserta disimpan di `m_peserta` (beserta kategori, data dasar, dan nilai mentah).
2. Kriteria dan bobotnya disimpan di `m_kriteria` (termasuk tipe vektor: benefit `v` atau cost `s`).
3. Nilai referensi untuk `Wiraga/Wirama/Wirasa` disediakan di tabel master masing-masing (`m_wiraga`, `m_wirama`, `m_wirasa`) lalu dikonversi saat perhitungan.
4. Saat pengguna menekan tombol Refresh Ranking, aplikasi:
   - Menghapus hasil perhitungan sebelumnya (`t_data_alternatif`, `t_nilai_akhir`)
   - Normalisasi nilai per kriteria sesuai tipe vektor, pangkatkan dengan bobot
   - Kalikan semua komponen (WP) untuk mendapatkan skor akhir per peserta
   - Simpan hasil ke `t_data_alternatif` dan `t_nilai_akhir`
5. Halaman Ranking menampilkan hasil yang diurutkan dari skor tertinggi ke terendah, dikelompokkan per kategori peserta.

## Lokasi Proses Normalisasi di Kode

- File: `app/Http/Controllers/PerhitunganController.php`
- Fungsi: `normalizeValue($value, $maxValue, $minValue, $vektor)`

```php
private function normalizeValue($value, $maxValue, $minValue, $vektor)
{
    if ($vektor == 'v') {
        // Benefit: xij / max_xj
        return $maxValue > 0 ? $value / $maxValue : 0;
    } else {
        // Cost: min_xj / xij (dengan guard zero-division)
        if ($value <= 0) { $value = 1; }
        if ($minValue <= 0) { $minValue = 1; }
        return $minValue / $value;
    }
}
```

Pendukung normalisasi:
- `getMaxValues()` dan `getMinValues()` menghitung nilai maksimum dan minimum per kriteria dengan mengonversi referensi untuk `Wiraga/Wirama/Wirasa` dan mengambil langsung angka untuk `Pengalaman/Ketidakhadiran`.
- `getVektorKriteria()` mengambil tipe vektor (`v`=benefit, `s`=cost) dari `m_kriteria`.

## Lokasi Perhitungan WP di Kode

- File: `app/Http/Controllers/PerhitunganController.php`
- Per peserta, komponen WP dihitung di:
  - `calculateDataAlternatifData(...)` → menghasilkan komponen per kriteria untuk disimpan ke `t_data_alternatif`
  - `calculateNilaiAkhirData(...)` → mengalikan semua komponen menjadi skor akhir `nilai_akhir` untuk `t_nilai_akhir`

Skema perhitungan:
```php
// Normalisasi lalu pangkatkan bobot wj per kriteria
$wiraga = pow($this->normalizeValue(...), $bobot['Wiraga']);
$wirama = pow($this->normalizeValue(...), $bobot['Wirama']);
$wirasa = pow($this->normalizeValue(...), $bobot['Wirasa']);
$pengalaman = pow($this->normalizeValue(...), $bobot['Pengalaman']);
$ketidakhadiran = pow($this->normalizeValue(...), $bobot['Ketidakhadiran']);

// Weighted Product (skor S_i): hasil kali semua komponen
$nilai_akhir = $wiraga * $wirama * $wirasa * $pengalaman * $ketidakhadiran;
```

Orkestrasi proses (trigger dari tombol Refresh):
- Route: `GET /refresh-ranking` → `PerhitunganController@refreshRanking`
- Mengambil bobot/vektor dari `m_kriteria`, max/min dari seluruh peserta, lalu memproses seluruh peserta dalam 1 loop dan menyimpan hasil secara batch ke `t_data_alternatif` dan `t_nilai_akhir`.

## Rumus yang Dipakai (Ringkas)

- Normalisasi per kriteria j untuk alternatif i:
  - Benefit (vektor `v`): \( r_{ij} = \frac{x_{ij}}{\max(x_j)} \)
  - Cost (vektor `s`): \( r_{ij} = \frac{\min(x_j)}{x_{ij}} \)
- Weighted Product Score per alternatif i:
  - \( S_i = \prod_j (r_{ij})^{w_j} \)
- Aplikasi ini menggunakan \( S_i \) langsung sebagai dasar pengurutan (tidak menghitung \( V_i = \frac{S_i}{\sum_k S_k} \)).

## Struktur Tabel Inti (Singkat)

- `m_peserta`: data peserta + nilai mentah
  - Kolom utama: `id`, `kategori_peserta_id (nullable)`, `wiraga (ref id)`, `wirama (ref id)`, `wirasa (ref id)`, `pengalaman (int)`, `ketidakhadiran (int)`
- `m_kriteria`: master kriteria dan bobot
  - Kolom: `kode`, `nama`, `bobot` (sudah ternormalisasi, total=1), `vektor` (`v` atau `s`)
- `m_wiraga`, `m_wirama`, `m_wirasa`: master referensi skala (kolom `range`, `nilai`)
- `m_pengalaman`, `m_ketidakhadiran`: master skala opsional (tersedia); saat ini perhitungan mengambil angka langsung dari `m_peserta`
- `t_data_alternatif`: komponen hasil normalisasi^bobot per kriteria (per peserta)
- `t_nilai_akhir`: skor akhir WP (`nilai_akhir`) dan komponen yang sama (per peserta)
- `m_kategori_peserta`: kategori peserta (relasi opsional dari peserta)
- `m_event` dan `t_peserta_lomba_per_event`: manajemen event dan keikutsertaan peserta (many-to-many)

## ERD (Mermaid)

```mermaid
erDiagram
  M_KATEGORI_PESERTA ||--o{ M_PESERTA : "kategori_peserta_id"
  M_PESERTA ||--o{ T_DATA_ALTERNATIF : "peserta_id"
  M_PESERTA ||--o{ T_NILAI_AKHIR : "peserta_id"
  M_EVENT ||--o{ T_PESERTA_LOMBA_PER_EVENT : "id"
  M_PESERTA ||--o{ T_PESERTA_LOMBA_PER_EVENT : "id"
  M_WIRAGA ||--o{ M_PESERTA : "wiraga (ref id)"
  M_WIRAMA ||--o{ M_PESERTA : "wirama (ref id)"
  M_WIRASA ||--o{ M_PESERTA : "wirasa (ref id)"

  M_PESERTA {
    bigint id PK
    bigint kategori_peserta_id FK
    string nama_lengkap
    enum jenis_kelamin
    date tanggal_lahir
    string asal_sekolah
    string nomor_hp
    int wiraga  // ref m_wiraga.id
    int wirama  // ref m_wirama.id
    int wirasa  // ref m_wirasa.id
    int pengalaman
    int ketidakhadiran
    timestamps
  }

  M_KRITERIA {
    bigint id PK
    string kode
    string nama
    float bobot
    enum vektor  // 'v' benefit, 's' cost
    text keterangan
    timestamps
  }

  T_DATA_ALTERNATIF {
    bigint id PK
    bigint peserta_id FK
    float wiraga
    float wirama
    float wirasa
    float pengalaman
    float ketidakhadiran
    timestamps
  }

  T_NILAI_AKHIR {
    bigint id PK
    bigint peserta_id FK
    float wiraga
    float wirama
    float wirasa
    float pengalaman
    float ketidakhadiran
    float nilai_akhir
    timestamps
  }

  M_EVENT {
    bigint id PK
    string nama
    int kuota
    date tanggal
    bigint kategori_peserta_id FK
    enum status
    text deskripsi
    string lokasi
    time waktu_mulai
    time waktu_selesai
    timestamps
  }

  T_PESERTA_LOMBA_PER_EVENT {
    bigint id PK
    bigint event_id FK
    bigint peserta_id FK
    timestamps
  }
```

Catatan:
- Kolom hubungan referensi pada `m_peserta` untuk `wiraga/wirama/wirasa` menyimpan ID ke master referensi; saat perhitungan dikonversi menjadi nilai numerik.
- `m_pengalaman` dan `m_ketidakhadiran` tersedia sebagai master skala, namun perhitungan saat ini menggunakan angka langsung dari `m_peserta`.

## Cara Menghasilkan Ranking di Aplikasi

1. Buka menu Data Ranking.
2. Klik tombol "Refresh Data" (route: `GET /refresh-ranking`).
3. Sistem mengkalkulasi ulang dan menampilkan tabel ranking per kategori, urut skor tertinggi.

## Sumber Data & Konfigurasi Bobot

- Bobot dan tipe kriteria:
  - Seeder: `database/seeders/KriteriaSeeder.php`
  - Contoh: `Ketidakhadiran` bertipe cost (`vektor = 's'`), bobot 0.15
- Perhitungan & normalisasi terpusat di: `app/Http/Controllers/PerhitunganController.php`
- Tabel hasil:
  - Komponen per kriteria: `t_data_alternatif`
  - Skor akhir: `t_nilai_akhir`

## Ringkas

- Normalisasi ada di `normalizeValue()`.
- Perhitungan WP ada di `calculateDataAlternatifData()` dan `calculateNilaiAkhirData()`; eksekusi batch saat Refresh Ranking.
- ERD di atas menggambarkan entitas utama dan hubungan antar tabel yang digunakan aplikasi ini.


