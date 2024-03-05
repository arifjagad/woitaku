# Tentang Woitaku

Woitaku merupakan sebuah website pengelolaan tiket event jejepangan atau acara festival budaya Jepang yang ada di Indonesia. Website ini memiliki 3 aktor utama yaitu Member, Event Organizer, dan Admin.

- Member dapat menggunakan website ini untuk mencari tiket event, melakukan transaksi, dan hal lain sebagainya.
- Event Organizer dapat menggunakan website ini untuk mengelola event yang ingin dibuat. Dengan persetujuan admin, event yang dibuat dapat dipublikasikan di website woitaku.
- Admin dapat menggunakan website ini untuk verifikasi event yang dibuat oleh Event Organizer.

## Fitur Utama

### Member
- Melakukan registrasi, login, forgot password, reset password, dan update profile.
- Melihat event, perlombaan, dan booth.
- Melakukan transaksi untuk pembelian tiket event, pendaftaran perlombaan dan penyewaan booth.
- Jika transaksi tidak diselesaikan dalam waktu 24 jam, maka transaksi akan batal secara otomatis.
- Member akan mendapatkan tiket jika transaksi berhasil.
- Member dapat mengelola booth-nya jika dia melakukan transaksi untuk penyewaan booth.

### Event Organizer
- Melakukan registrasi, login, forgot password, reset password, dan update profile.
- Mengelola data event, perlombaan, booth, metode pembayaran, peserta, dan transaksi.
- Dapat menerima atau menolak transaksi yang dilakukan oleh Member.

### Admin
- Melakukan login, forgot password, preset password, dan update profile.
- Mengelola data event, perlombaan, booth, member, dan event organizer.
- Dapat menerima, me-review, dan menolak event yang diajukan oleh Event Organizer.
- Dapat menambahkan Admin lainnya untuk mempermudah pengerjaan Admin.

## Cara Menggunakan dan Mengakses Woitaku Di Local Anda

### Instalasi Dasar

Website Woitaku dibangun menggunakan bahasa pemrograman PHP dengan menggunakan framework Laravel, serta menggunakan MySQL sebagai manajemen basis datanya. 

Gunakan Laragaon untuk mempermudah Anda dalam memproses website Woitaku. Anda dapat menginstallnya di sini: https://laragon.org/index.html.

Jika sudah maka install phpmyadmin di Laragon Anda. Tujuannya untuk mempermudah dalam mengelola database MySQL yang ada. Anda dapat melihat tutorialnya di sini: https://amperakoding.com/article/cara-install-phpmyadmin-di-laragon.

Gunakan VSCode untuk mempermudah Anda dalam pengkodean program ini. Anda dapat menginstallnya melalui website: https://code.visualstudio.com/

### Penempatan Folder

Clone Woitaku melalui github: https://github.com/arifjagad/woitaku.git.

Jika Anda sudah meng-clone, maka letakkan ke dalam file Laragon Anda. Directory/laragon/www. Jika sudah, Anda bisa membuka VSCode dan melakukan konfigurasi awal yaitu:

1. Melakukan instalasi package dan update package dengan cara
```bash
npm i
npm u
```
2. Upload database pada directory woitaku-main/database/database_woitaku ke dalam phpmyadmin
3. Atur file .env untuk menyesuaikan databasenya
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=woitakudb (nama database yang ingin dibuat)
DB_USERNAME=root
DB_PASSWORD=
```
4. Atur kembali file .env untuk menyesuaikan email verifikasinya
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=woitaku@gmail.com (email Anda)
MAIL_PASSWORD=tqryrdmspkyttmmp (password Anda)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@gmail.com
MAIL_FROM_NAME="Woitaku" (nama pengirim)
```
Untuk melakukan konfigurasi email bisa lihat tutorial: https://www.youtube.com/watch?v=kTcmbZqNiGw

## Akun Demo

Untuk akun Member dan Event Organizer, Anda bisa langsung membuat akunnya sendiri. Sedangkan untuk demo akun Admin adalah:
```
Demo akun Admin,
Username: admin@gmail.com
Password: admin
```

## License

[MIT](https://choosealicense.com/licenses/mit/)
