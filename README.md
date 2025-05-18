
# 📘 My Blog Training Project

## Overview

The project consists of two main components:  
- The **dashboard** (administrator's control panel)  
- The **website** (public interface)  

It was built using **Laravel 9**, **AdminLTE** for the dashboard, and **Bootstrap** for the front-end.

---

## 🛠️ Dashboard Features

1. Full CRUD operations for categories and posts  
2. Image upload and preview for posts and categories  
3. Role-based access control using [spatie/laravel-permission](https://github.com/spatie/laravel-permission)  
4. User management: create, update, set password, archive, restore, and force delete  
5. Profile viewing, editing, and password change  
6. Search, sort, and pagination for lists  
7. Logs for posts and users (simple monitoring system)  
8. SweetAlert for success messages  
9. Form validation and error handling  

---

## 🌐 Website Features

1. Homepage with a welcome section and a category carousel (latest posts included)  
2. Post listing by category  
3. User authentication: registration, login, logout  
4. Forgot password support using Mailtrap  
5. User profile management with password verification  
6. Comment feature for posts (visible to authenticated users only)

---

## 🚀 Getting Started

Run this project locally by following these steps:

```bash
1. git clone https://github.com/YazanYa10/laravel-blog-project.git
2. cd laravel-blog-project
3. composer install
4. npm install && npm run dev
5. cp .env.example .env
```

Then:

- Create a new database (e.g., `blog_project`)
- Update `.env` file with your DB credentials

```bash
6. php artisan key:generate
7. php artisan migrate --seed
8. php artisan storage:link
9. php artisan serve
```
