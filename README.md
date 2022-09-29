# Simple Blog app
Built with PHP, nodejs, composer, Laravel 8 and Nuxt.js 2. 

## Installation

```bash
git clone https://github.com/aldis-sarja/simple-blog.git
cd simple-blog/backend-laravel
composer install
cd ../frontend-nuxt
npm install
npm run build
```

## Setup for demonstration version
Instead of the production version, you can set up the application for demonstration with a small configuration and ready to go.
The Demo version uses SQLite, so, here you don't need to install, set up an SQL server and do all configuration stuff.
In `backend-laravel` folder rename the file `.env.demo` to `.env`, or make a copy:
```bash
cp .env.demo .env
```

Now initialize database
```bash
php artisan migrate
php artisan app:first-run
```

The `app:first-run` command will make first admin user (with password 'admin') and basic categories.
You can add aditional admin users with command `php artisan add:admin <user_name> <email> <password>`
and regular users with `php artisan add:user <user_name> <email> <password>`.
You can easily populate database with fake users and fake posts - `php artisan bd:seed`.
All fake user's password is 'password'.

To start backend server enter the command `php artisan serve`.

Now enter in front end `frontend-nuxt` directory and launch `npm run start`
and navigate to the address `http://localhost:3000/`.

## Setup for production version
For production version you must edit backend's `.env` file. Uncomment and put your data:
```dosini
DB_CONNECTION=<your-db-server>
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<your-db-name>
DB_USERNAME=<your-db-user-name>
DB_PASSWORD=<your-password>
```
