# Matnog Tourism Booking System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.1+-blue?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-Database-orange?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5-purple?style=for-the-badge&logo=bootstrap" alt="Bootstrap">
</p>

A comprehensive tourism booking platform for **Matnog, Sorsogon, Philippines**, featuring boat and resort reservations with real-time availability, SMS notifications, and multi-role user management system.

## 🌟 Features

### 🚤 **Boat Booking System**
- Real-time boat availability checking
- Automatic boat assignment based on capacity and schedule
- Dynamic pricing calculation
- Boat owner dashboard for fleet management

### 🏨 **Resort Reservation System**
- Room availability management
- Multi-image gallery for rooms
- Resort owner control panel
- Booking calendar integration

### 👥 **Multi-Role User System**
- **Tourists**: Browse, book, and rate services
- **Boat Owners**: Manage boats and bookings
- **Resort Owners**: Manage properties and reservations
- **Administrators**: Complete system oversight

### 📱 **Communication & Notifications**
- SMS notifications via Semaphore SMS API
- Email notifications for booking confirmations
- Real-time booking status updates
- Rating and review system

### 📊 **Advanced Features**
- Dynamic pricing based on demand and seasonality
- Comprehensive admin dashboard with analytics
- Booking history and management
- User profile management with phone verification

## 🚀 Live Demo

**Visit the live application**: [https://matnogsubictourism.site](https://matnogsubictourism.site)

### Demo Accounts
- **Tourist**: Register directly on the platform
- **Admin**: Contact for demo credentials

## 🛠️ Built With

- **Backend Framework**: Laravel 10.x
- **PHP Version**: 8.1+
- **Database**: MySQL
- **Frontend**: Blade Templates with Bootstrap 5
- **SMS Service**: Semaphore SMS API
- **Hosting**: Hostinger
- **Version Control**: Git & GitHub

## 📱 System Architecture

### Models & Relationships
- **User** (Multi-role: Tourist, Boat Owner, Resort Owner, Admin)
- **Boat** with dynamic assignment system
- **Resort** with room management
- **Booking** with status tracking
- **Rating** system for service quality
- **Notification** system for all user types

### Key Services
- **PricingCalculationService**: Dynamic pricing algorithms
- **SemaphoreSmsService**: SMS notification handling
- **Boat Assignment Logic**: Intelligent boat allocation

## 🏗️ Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL 5.7+
- Node.js & NPM

### Local Development Setup

1. **Clone the repository**
```bash
git clone https://github.com/yourusername/Capstone_Project_Origin.git
cd Capstone_Project_Origin
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node.js dependencies**
```bash
npm install
```

4. **Environment configuration**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Database setup**
```bash
# Configure your database in .env file
php artisan migrate
php artisan db:seed --class=AdminSeeder
```

6. **Build frontend assets**
```bash
npm run build
```

7. **Start development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 🌐 Production Deployment

For detailed deployment instructions on Hostinger, see [HOSTINGER_DEPLOYMENT_GUIDE.md](HOSTINGER_DEPLOYMENT_GUIDE.md).

### Key Deployment Steps
1. Upload files to Hostinger
2. Configure `.env` file with production settings
3. Set up MySQL database
4. Run migrations and seeders
5. Configure SMS API credentials
6. Set proper file permissions

## ⚙️ Configuration

### SMS Service Setup (Semaphore)
```env
SEMAPHORE_API_KEY=your_semaphore_api_key
SEMAPHORE_SENDER_NAME=MATNOG
```

### Database Configuration
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 📊 Project Structure

```
app/
├── Http/Controllers/     # Role-based controllers
├── Models/              # Eloquent models
├── Services/            # Business logic services
├── Notifications/       # SMS and email notifications
└── Middleware/          # Authentication and authorization

resources/views/
├── admin/              # Admin dashboard views
├── tourist/            # Tourist interface
├── boat_owner/         # Boat owner dashboard
├── resort_owner/       # Resort owner dashboard
└── layouts/            # Shared layouts

database/
├── migrations/         # Database schema
└── seeders/           # Sample data
```

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

Key test coverage:
- Boat assignment logic
- Booking status management
- User authentication flows
- API endpoints

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 Documentation

- [Boat Assignment Logic](README_BOAT_ASSIGNMENT.md)
- [Booking Status Management](README_BOOKING_STATUS.md)
- [Boat Assignment Timing](README_BOAT_ASSIGNMENT_TIMING.md)
- [Deployment Guide](HOSTINGER_DEPLOYMENT_GUIDE.md)

## 🏆 Project Highlights

- **Real-world Application**: Solving actual tourism booking challenges in Matnog
- **Scalable Architecture**: Built with Laravel best practices
- **User-Centric Design**: Intuitive interfaces for all user roles
- **SMS Integration**: Professional communication system
- **Production Ready**: Successfully deployed and operational

## 👥 Development Team

- **Lead Developer**: [Your Name]
- **Institution**: [Your School/University]
- **Project Type**: Capstone Project
- **Academic Year**: [Year]

## 📞 Contact & Support

- **Email**: [your.email@example.com]
- **LinkedIn**: [Your LinkedIn Profile]
- **GitHub**: [Your GitHub Profile]
- **Live Demo**: [https://matnogsubictourism.site](https://matnogsubictourism.site)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **Laravel Framework** - Robust PHP framework
- **Bootstrap** - Responsive CSS framework
- **Semaphore SMS** - Reliable SMS service
- **Hostinger** - Web hosting platform
- **Matnog Tourism Industry** - Project inspiration and requirements

---

⭐ **If you find this project helpful, please consider giving it a star!**

**Keywords**: Laravel tourism booking system, PHP boat reservation platform, Matnog Sorsogon tourism, capstone project, booking management system, SMS integration Laravel, multi-role user system
