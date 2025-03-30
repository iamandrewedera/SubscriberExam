# Subscriber Management System

A scalable subscriber management system built with Laravel and Vue.js, designed to handle high-volume subscription requests through queued processing.

## Use Case / Requirements

The system was built to handle the following exam requirements:

- Create an API endpoint for subscriber management that can:
  - Accept subscriber's email and status
  - Handle subscription status ('subscribed' or 'unsubscribed')
  - Process hundreds of thousands of requests per second

### Technical Requirements Met

✅ High-volume processing capabilities through Queue Workers

✅ RESTful API endpoints for subscriber management

✅ Data validation and error handling

✅ Scalable database design

✅ Comprehensive test coverage

## Features

- ✨ High-performance API endpoints for subscriber management
- 🚀 Queue-based processing for handling large volumes of requests
- ⚡ Simple Vue.js frontend interface
- 🧪 Comprehensive test coverage
- 📈 Scalable architecture

## System Requirements

- PHP 8.1 or higher
- Composer
- Node.js 16+ and npm
- Redis (for queue processing)
- MySQL/PostgreSQL

## Project Setup

### Backend Setup

1. Navigate to backend directory:
```bash
cd backend
```

2. Install PHP dependencies:
```bash
composer install
```

3. Configure environment:
```bash
cp .env.example .env
```

4. Set up database credentials in `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=subscriber_exam
DB_USERNAME=root
DB_PASSWORD=
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run database migrations:
```bash
php artisan migrate
```

7. Start the Laravel server:
```bash
php artisan serve
```

8. Start the queue worker:
```bash
php artisan queue:work
```

### Frontend Setup

1. Navigate to frontend directory:
```bash
cd frontend
```

2. Install Node dependencies:
```bash
npm install
```

3. Configure environment:
```bash
cp .env.example .env
```

4. Start development server:
```bash
npm run dev
```

## API Endpoints

### Subscriber Management

```
POST /api/subscriber
PATCH /api/subscriber/unsubscribe
```

#### Request Body (POST /api/subscriber)
```json
{
    "email": "example@domain.com"
}
```

## Architecture Details

### Scalability Features

1. **Queue Implementation**
   - Subscription requests are processed through Laravel's queue system
   - Prevents database bottlenecks during high-volume periods
   - Configurable retry attempts for failed processes

2. **Database Optimization**
   - Indexed fields for faster queries
   - Efficient database schema design

### Security Considerations

- API endpoints currently don't require authentication (JWT/OAuth can be implemented as needed)
- Input validation and sanitization implemented
- CORS enabled for frontend communication

### Testing

The project includes comprehensive tests covering:

- API endpoint functionality
- Queue processing
- Database operations

Run tests using:
```bash
cd backend
php artisan test
```

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Vue 3 + Vite
- **Database**: MySQL/PostgreSQL
- **Queue**: Redis
- **Testing**: PHPUnit

## License

MIT
