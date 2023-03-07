# project-final-frans
Deskripsi:
Backend menggunakan Laravel

Frontend menggunakan Vue.JS

Folder Backend\!Backup digunakan untuk Backup DB dan Collection POSTMan

Login yang digunakan : email dari table user dan password adalah 'password'

Cara menjalankan Backend:
- cd backend
- composer install
- copy .env.example dengan nama .env 
- edit .env ubah setting untuk koneksi, sesuaikan dengan yang akan digunakan
- php artisan key:generate
- php artisan migrate:fresh
- php artisan db:seed
- php artisan serve (localhost:8000)

Cara menjalankan Frontend:
- cd frontend
- npm install
- npm run dev

