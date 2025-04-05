# RestoBladi - Restaurant Management System

## Overview
RestoBladi is a comprehensive restaurant management system designed to streamline operations for a Moroccan cuisine restaurant. The system handles menu management, order processing, reservation systems, and customer management.

## Features
- **Menu Management**: Create, update and categorize food items
- **Order Processing**: Take orders, manage kitchen tickets, and handle billing
- **Reservation System**: Allow customers to book tables online
- **User Management**: Separate interfaces for admins, staff, and customers
- **Inventory Control**: Track ingredient usage and stock levels
- **Analytics Dashboard**: View sales reports, popular dishes, and customer trends

## Technologies Used
- **Backend**: PHP framework
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL/PostgreSQL
- **Authentication**: Built-in auth system
- **Markdown Support**: League CommonMark library for content rendering

## Installation

### Prerequisites
- PHP 8.0 or higher
- Composer
- MySQL or PostgreSQL
- Web server (Apache/Nginx)

### Setup Instructions
1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/RestoBladi.git
   cd RestoBladi
   ```

2. Install dependencies
   ```bash
   composer install
   ```

3. Set up environment
   ```bash
   cp .env.example .env
   # Edit .env file with your database credentials
   ```

4. Run migrations and seed data
   ```bash
   php artisan migrate --seed
   ```

5. Start the development server
   ```bash
   php artisan serve
   ```

## Usage
- **Admin Dashboard**: Access via `/admin` with admin credentials
- **Staff Interface**: Access via `/staff` with staff credentials
- **Customer Portal**: Primary website interface for customers

## Screenshots
![Dashboard](screenshots/dashboard.png)
![Menu Management](screenshots/menu-management.png)
![Reservation System](screenshots/reservation.png)

## API Documentation
API endpoints are available for integration with other systems:
- `GET /api/menu` - Retrieve menu items
- `POST /api/reservations` - Create a reservation
- `GET /api/orders` - Fetch orders

For full API documentation, visit `/api/docs` after installation.

## Contributing
Contributions are welcome! Please feel free to submit a Pull Request.

## License
This project is licensed under the MIT License - see the LICENSE file for details.

## Contact
For any inquiries, please contact [ayoub.labite@gmail.com](mailto:your-email@example.com)
