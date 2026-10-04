<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Cara Run Project ini:
1. Rename file .env.example menjadi .env
2. Hapus tanda Hashtag(#) pada baris 24-28 di dalam file .env tersebut dan ubah nama databasenya (contoh: inventory-system) 
2. Jalankan "php artisan migrate" pada terminal
3. Jalankan "php artisan filament:make-user" pada terminal
4. Masukkan nama, email, dan juga password untuk login
5. Jalankan command "php artisan serve" dan project bisa dijalankan


# Cara cek API:
1. Buat key API pada halaman API Key
2. Kode yang sudah dibuat dapat dipakai didalam software untuk menguji API (contoh:Postman)
3. List untuk routing dapat dilihat dengan cara menjalankan "php artisan route:list" pada terminal
4. Tambahkan key bernama "x-api-key" pada headers dan juga value sesuai API key yang sudah dibuat
