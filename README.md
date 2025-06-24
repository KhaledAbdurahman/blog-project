# Laravel Multi-User Blog Platform

A Laravel-based blogging platform that allows multiple users to register, create, edit, and manage their own blog posts. Each user has access only to their own content through a secure and user-friendly dashboard.

## 🚀 Features

- User Registration and Authentication
- Role-based access (Admin & Regular Users)
- Blog CRUD (Create, Read, Update, Delete)
- User Dashboard with personalized blog management
- Public blog listing and post pages
- Optional: Admin panel to manage users and posts

## 🛠️ Tech Stack

- **Backend:** Laravel 10+
- **Frontend:** Blade templating (or optional Vue/React)
- **Authentication:** Laravel Breeze / Fortify / Jetstream
- **Database:** MySQL / PostgreSQL
- **Optional:** Tailwind CSS, Livewire, Spatie Permissions

## 📦 Installation

```bash
git clone https://github.com/yourusername/multi-user-blog.git
cd multi-user-blog
composer install
cp .env.example .env
php artisan key:generate
```

🔧 Configuration
Update .env with your database credentials.

(Optional) Configure mail settings if email verification or notifications are used.

📂 Migrate & Seed Database
```
php artisan migrate --seed
```
This will create the required tables and seed an initial admin user if configured in DatabaseSeeder.php.

🔑 Admin Access
If seeded:

Email: admin@example.com

Password: password

Change credentials after first login.

🧪 Run Development Server
```
php artisan serve
```
Access the app at: http://localhost:8000

📋 Routes Overview
Route	Description
/register	User registration
/login	User login
/dashboard	User's blog dashboard
/blogs	Public blog listing
/blogs/{slug}	View single blog post

✍️ Blog Management
Users can create, edit, and delete only their own posts.

Admins (if enabled) can manage all posts and users.

🧰 Commands
```
php artisan migrate:fresh --seed       # Reset and seed the database
php artisan make:model Blog -mcr       # Create Blog model with migration, controller, resource
```

✅ To-Do / Improvements
 Add WYSIWYG editor for blog content

 Implement search & tag features

 Add user profile pages

 Enable social logins (Google, GitHub)

📄 License
MIT License. Feel free to use and modify.
