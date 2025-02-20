# SIARKANTA - Sistem Informasi Arsip dan Stok ATK

**SIARKANTA** adalah aplikasi berbasis web yang digunakan di **Lapas Kelas IIA Kediri** untuk pencatatan nomor surat kedinasan serta manajemen stok alat tulis kantor (ATK). Dikembangkan menggunakan **Laravel**, **Bootstrap**, dan **MySQL**, sistem ini bertujuan untuk meningkatkan efisiensi pengelolaan dokumen dan inventaris barang di lingkungan Lapas.

Dikembangkan oleh **@alan.singgih**, pegawai **Lapas Kelas IIA Kediri**.

---

## 📌 Fitur Utama

### 1️⃣ **Manajemen Nomor Surat**
- Pencatatan nomor surat kedinasan.
- Edit dan revisi nomor surat dengan tampilan modern menggunakan **SweetAlert2**.
- Rekapitulasi nomor surat dalam rentang waktu tertentu.
- Ekspor rekapitulasi ke **Excel**.

### 2️⃣ **Manajemen Stok ATK**
- Input stok barang dengan modal **SweetAlert2**.
- Edit stok barang langsung dari tabel.
- Notifikasi jika stok menipis.
- Rekap pemasukan dan penggunaan stok dalam format **Excel**.

### 3️⃣ **Manajemen Inventaris Barang**
- Pencatatan barang inventaris dengan atribut lengkap seperti **Nomor Registrasi, Jenis, Merek, Kondisi, Tanggal Penerimaan**, dan lain-lain.
- Update kondisi barang, mencatat perubahan dari **Baik → Rusak Sebagian → Rusak Parah**.
- Riwayat perubahan kondisi barang tercatat otomatis.

### 4️⃣ **Hak Akses User**
- **User:** Bisa melihat dan mencatat nomor surat serta stok barang.
- **Admin:** Bisa mengelola stok barang, rekap data, serta melihat inventaris.
- **Super Admin:** Bisa mengelola semua fitur, termasuk manajemen pengguna.

### 5️⃣ **Dashboard Realtime**
- Statistik permintaan nomor surat bulanan.
- Sisa stok barang secara visual.
- Notifikasi barang yang perlu restock.

### 6️⃣ **Keamanan Sistem**
- Autentikasi berbasis **Laravel Authentication**.
- Middleware peran pengguna untuk membatasi akses.
- Penyimpanan data menggunakan **MySQL (phpMyAdmin)**.

---

## 🛠️ Instalasi & Konfigurasi

### **1. Clone Repository**
```bash
git clone https://github.com/username/siarkanta.git
cd siarkanta
```

### **2. Install Dependency Laravel**
```bash
composer install
```

### **3. Konfigurasi .env**
Salin file **.env.example** menjadi **.env**:
```bash
cp .env.example .env
```
Lalu atur konfigurasi database di file **.env**:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siarkanta
DB_USERNAME=root
DB_PASSWORD=
```

### **4. Generate Key & Migrate Database**
```bash
php artisan key:generate
php artisan migrate --seed
```

### **5. Install Frontend Dependencies**
```bash
npm install
npm run dev
```

### **6. Jalankan Server**
```bash
php artisan serve
```
Akses aplikasi di: **http://127.0.0.1:8000**

---

## 📦 Paket yang Digunakan
| Paket         | Versi         | Keterangan                  |
|--------------|--------------|------------------------------|
| Laravel      | 10.x         | Framework utama             |
| Bootstrap    | 5.3.x        | Styling UI                  |
| jQuery       | 3.6.x        | Interaksi UI                |
| SweetAlert2  | 11.x         | Notifikasi interaktif       |
| DataTables   | Latest       | Tabel interaktif            |
| Laravel Excel | Latest      | Ekspor data ke Excel        |

---

## ✨ Kontribusi
Jika ingin berkontribusi, silakan fork repository ini dan buat pull request.

---

## 📢 Kontak & Informasi
Untuk pertanyaan lebih lanjut, hubungi saya di **Instagram: [@alan.singgih](https://www.instagram.com/alan.singgih/)**.

---

🚀 **SIARKANTA - Sistem Informasi Modern untuk Lapas Kelas IIA Kediri**

