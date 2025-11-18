# Employee Management System (EMS)

Sistem manajemen karyawan berbasis web menggunakan Laravel 11, Livewire 3, dan Tailwind CSS.

## 🚀 Features

- ✅ Manajemen Karyawan (CRUD)
- ✅ Manajemen Departemen & Posisi
- ✅ Role & Permission Management (Admin, HR, Manager, Employee)
- ✅ Dashboard dengan statistik
- ✅ Upload foto profil karyawan
- 🚧 Absensi (Coming Soon)
- 🚧 Cuti (Coming Soon)
- 🚧 Payroll (Coming Soon)

## 🛠️ Tech Stack

- **Backend**: Laravel 11.x
- **Frontend**: Livewire 3.x, Tailwind CSS 3.x
- **Database**: SQLite (default), MySQL/PostgreSQL
- **Authentication**: Laravel Breeze + Spatie Permission

## 📦 Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM

### Setup
```bash
# Clone repository
git clone https://github.com/SeptianSamdani/employee-management-system.git
cd employee-management-system

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
touch database/database.sqlite
php artisan migrate --seed

# Build assets
npm run build

# Run server
php artisan serve
```

## 👥 Demo Accounts

| Role     | Email                | Password  |
|----------|---------------------|-----------|
| Admin    | admin@example.com   | password  |
| HR       | hr@example.com      | password  |
| Manager  | manager@example.com | password  |
| Employee | employee@example.com| password  |

## 📁 Project Structure
```
app/
├── Http/
│   ├── Controllers/        # Controllers
│   └── Middleware/         # Custom middleware
├── Livewire/              # Livewire components
│   ├── Employee/
│   ├── Department/
│   └── Position/
└── Models/                # Eloquent models

resources/
├── css/                   # Tailwind styles
├── js/                    # JavaScript files
└── views/
    ├── livewire/         # Livewire views
    └── components/       # Blade components
```

## 🔐 Permissions

- **Admin**: Full access
- **HR**: Manage employees, departments, attendance, leaves, payroll
- **Manager**: View employees, approve/reject leaves
- **Employee**: Check in/out, request leaves

## 🚀 Development Roadmap

- [ ] Implementasi modul Absensi dengan GPS
- [ ] Sistem Cuti dengan approval workflow
- [ ] Perhitungan Payroll otomatis
- [ ] Export data ke Excel/PDF
- [ ] Email notifications
- [ ] API untuk mobile app
- [ ] Multi-language support

## 📝 License

MIT License

## 👨‍💻 Author

Septian Samdani - [septiansamdani05@gmail.com](mailto:septiansamdani05@gmail.com)