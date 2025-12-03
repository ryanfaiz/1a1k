# 1ToAsk1ToKnow - Learning Platform Documentation

A Laravel-based learning platform that combines course materials, Q&A discussions, and user profiles with role-based access control.

## Features

### 1. Authentication & Authorization

-   User registration and login
-   Role-based access control (Admin/User)
-   Admin can manage user roles via dedicated Users page
-   Secure password hashing

### 2. Courses & Materials

-   **Courses**: Admins can create, edit, delete courses
-   **Chapters**: Organize courses into chapters (admin-only create/edit/delete)
-   **Materials**: Upload PDF/document files to chapters
    -   File upload with validation (max 2MB)
    -   Preview PDFs via embedded iframe
    -   Download files
    -   Export chapters as PDF
    -   Edit/delete materials with automatic old file cleanup

### 3. Q&A System

-   **Questions**: Users can ask questions with title and content
-   **Answers**: Users can answer questions
-   Edit/delete own questions and answers
-   User names are clickable links to public profiles
-   Recent Q&A displayed on user profiles

### 4. User Profiles

-   **Private Profile** (`/profile`): User can edit their own profile
    -   Upload/change profile avatar
    -   Add/edit bio (up to 1000 characters)
    -   View their own profile information
-   **Public Profile** (`/users/{id}`): Anyone can view any user's public profile
    -   Avatar (or placeholder using UI-Avatars service)
    -   Bio
    -   Question and Answer counts with badges
    -   Bar chart (Chart.js) showing Q&A statistics
    -   DataTables showing recent 50 questions and answers with pagination
    -   Export Q&A as formatted Excel file (xlsx) with multiple sheets
    -   Export button visible only to the user or admins

### 5. Admin Features

-   **User Management** (`/admin/users`): View all users and change their roles
-   Role management: Promote/demote users between Admin and User roles
-   Self-demotion prevention (admins cannot remove their own admin role)
-   Admin-only buttons hidden from regular users in course/chapter/material management

### 6. Data Export

-   Export user's Q&A as Excel file with two sheets:
    -   **Questions sheet**: ID, Title, Content, Created At
    -   **Answers sheet**: ID, For Question, Content, Created At
-   Uses `maatwebsite/excel` for professional formatting with headers

## Tech Stack

-   **Backend**: Laravel 12 (PHP 8.2+)
-   **Database**: MySQL
-   **Frontend**: Blade Templates, Bootstrap 5
-   **PDF Generation**: barryvdh/laravel-dompdf
-   **Excel Export**: maatwebsite/excel with PHPOffice/PHPSpreadsheet
-   **Charts**: Chart.js (via CDN)
-   **Tables**: DataTables with jQuery (via CDN)
-   **File Storage**: Laravel Storage (local disk with public symlink)
-   **Avatar Service**: UI-Avatars API for placeholder avatars

## Project Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── LoginController.php              # Handle login
│       ├── RegisterController.php           # Handle registration
│       ├── ProfileController.php            # User profile edit (avatar, bio)
│       ├── QuestionController.php           # Q&A questions CRUD
│       ├── AnswerController.php             # Q&A answers CRUD
│       ├── CourseController.php             # Course CRUD (admin)
│       ├── ChapterController.php            # Chapter CRUD (admin)
│       ├── MaterialController.php           # Material/file CRUD (admin)
│       ├── MateriController.php             # Legacy material listing (consolidated)
│       └── UserController.php               # Public profiles & admin user management
├── Models/
│   ├── User.php                             # Avatar, bio, role (admin/user)
│   ├── Course.php                           # Course model
│   ├── Chapter.php                          # Chapter model
│   ├── Material.php                         # Material/file model
│   ├── Question.php                         # Question model
│   └── Answer.php                           # Answer model
└── Exports/
    └── UserQnaExport.php                    # Excel export with 2 sheets

database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── *_create_courses_table.php
│   ├── *_create_chapters_table.php
│   ├── *_create_materials_table.php
│   ├── *_create_questions_table.php
│   ├── *_create_answers_table.php
│   ├── *_add_role_to_users_table.php         # Adds role enum (user/admin)
│   ├── *_add_avatar_to_users_table.php       # Adds avatar column
│   └── *_add_bio_to_users_table.php          # Adds bio text column
└── factories/
    └── UserFactory.php

resources/views/
├── layout/
│   └── main.blade.php                       # Main layout with navbar & @yield('scripts')
├── auth/
│   ├── login.blade.php                      # Login form
│   └── register.blade.php                   # Registration form
├── profile.blade.php                        # Private user profile (edit avatar/bio)
├── users/
│   └── show.blade.php                       # Public user profile with chart & datatables
├── qna/
│   ├── index.blade.php                      # Questions list with clickable names
│   ├── show.blade.php                       # Question detail with answers & clickable names
│   ├── create.blade.php                     # Ask question form
│   └── edit.blade.php                       # Edit question form
├── courses/
│   ├── index.blade.php                      # Courses list
│   ├── create.blade.php                     # Create course form
│   ├── show.blade.php                       # Course detail with chapters
│   └── edit.blade.php                       # Edit course form
├── chapters/
│   ├── create.blade.php                     # Create chapter form
│   ├── show.blade.php                       # Chapter detail with materials
│   └── edit.blade.php                       # Edit chapter form
├── materials/
│   ├── create.blade.php                     # Upload material form
│   ├── edit.blade.php                       # Edit material form
│   ├── preview.blade.php                    # PDF preview via iframe
│   └── pdf.blade.php                        # PDF export view
├── materi/
│   └── index.blade.php                      # Consolidated material listing
└── admin/
    └── users/
        └── index.blade.php                  # User role management

routes/
└── web.php                                  # All application routes

storage/
└── app/
    ├── public/
    │   ├── materials/                       # Uploaded material files
    │   └── avatars/                         # User avatar images
    └── (other storage dirs)

public/
└── storage -> ../storage/app/public         # Symlink for serving files
```

## Installation & Setup

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   MySQL (or other supported database)
-   Node.js & npm (optional, for Vite asset compilation)

### Steps

1. **Navigate to project directory**

    ```powershell
    cd d:\projeklaravel\1a1k
    ```

2. **Install PHP dependencies**

    ```powershell
    composer install
    ```

3. **Environment configuration**

    ```powershell
    copy .env.example .env
    php artisan key:generate
    ```

    Update `.env` with your database credentials:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4. **Run migrations**

    ```powershell
    php artisan migrate
    ```

5. **Create storage symlink** (for serving uploaded files)

    ```powershell
    php artisan storage:link
    ```

6. **Start the development server**
    ```powershell
    php artisan serve
    ```
    Access the app at `http://localhost:8000`

## Usage Guide

### User Registration & Login

-   Navigate to `/register` to create a new account (defaults to "User" role)
-   Login at `/login` with email and password
-   Logout via navbar button

### Accessing Features

#### Courses & Materials (`/courses`)

-   View all courses
-   Admins can click "Tambah Course" to create new course
-   Click course title to view chapters
-   From chapter, click "Tambah Material" to upload files
-   Click "Preview" to view PDF in browser
-   Click "Download" to download file
-   Click "Edit" to modify or delete material

#### Q&A (`/qna`)

-   Click "Buat Pertanyaan" to ask a new question
-   View all questions with clickable user names
-   Click question to view details and answers
-   Add answer with "Tambah Jawaban" form
-   Click user names to view their public profile
-   Edit/delete own questions and answers

#### User Profile

-   **Private** (`/profile`):

    -   Upload profile picture (max 2MB)
    -   Add or edit bio (max 1000 characters)
    -   See your own info

-   **Public** (`/users/{id}`):
    -   View anyone's profile
    -   See their avatar, bio, stats
    -   View their bar chart of Q&A counts
    -   View their recent questions & answers in DataTables
    -   Export their data as Excel (if logged in and authorized)

#### Admin Functions (`/admin/users`)

-   View list of all users with pagination
-   Change user role (user → admin, admin → user)
-   Cannot remove own admin role (self-demotion protection)
-   Admin link only visible in navbar to admin users

### Uploading Materials

1. Go to Courses → select course → select chapter → "Tambah Material"
2. Fill in:
    - Title (required)
    - Description (optional)
    - File (required, max 2MB, any format)
3. Click "Simpan"
4. File stored in `storage/app/public/materials/`
5. To preview: Click "Preview" (PDF shown in iframe)
6. To download: Click "Download"
7. To edit: Click "Edit", change details or replace file
8. Old file auto-deleted when replaced or material deleted

### Exporting Data as Excel

1. Visit any user's public profile (`/users/{id}`)
2. If logged in as that user or admin, "Export CSV" button appears
3. Click to download `.xlsx` file with two sheets:
    - **Questions**: All their questions with timestamps
    - **Answers**: All their answers linked to question titles

## Database Schema

### Users Table

| Column     | Type      | Notes                               |
| ---------- | --------- | ----------------------------------- |
| id         | BIGINT    | Primary key                         |
| name       | STRING    | User's display name                 |
| email      | STRING    | Unique email                        |
| password   | STRING    | Hashed password                     |
| avatar     | STRING    | Nullable path to avatar file        |
| bio        | TEXT      | Nullable bio/about section          |
| role       | ENUM      | 'user' or 'admin' (default: 'user') |
| created_at | TIMESTAMP |                                     |
| updated_at | TIMESTAMP |                                     |

### Courses Table

| Column      | Type      | Notes              |
| ----------- | --------- | ------------------ |
| id          | BIGINT    | Primary key        |
| title       | STRING    | Course name        |
| description | TEXT      | Course description |
| created_at  | TIMESTAMP |                    |
| updated_at  | TIMESTAMP |                    |

### Chapters Table

| Column     | Type      | Notes                  |
| ---------- | --------- | ---------------------- |
| id         | BIGINT    | Primary key            |
| course_id  | BIGINT    | Foreign key to courses |
| title      | STRING    | Chapter name           |
| created_at | TIMESTAMP |                        |
| updated_at | TIMESTAMP |                        |

### Materials Table

| Column      | Type      | Notes                   |
| ----------- | --------- | ----------------------- |
| id          | BIGINT    | Primary key             |
| chapter_id  | BIGINT    | Foreign key to chapters |
| title       | STRING    | Material name           |
| description | TEXT      | Material description    |
| file_path   | STRING    | Path to uploaded file   |
| created_at  | TIMESTAMP |                         |
| updated_at  | TIMESTAMP |                         |

### Questions Table

| Column     | Type      | Notes                |
| ---------- | --------- | -------------------- |
| id         | BIGINT    | Primary key          |
| user_id    | BIGINT    | Foreign key to users |
| title      | STRING    | Question title       |
| content    | TEXT      | Question content     |
| created_at | TIMESTAMP |                      |
| updated_at | TIMESTAMP |                      |

### Answers Table

| Column      | Type      | Notes                    |
| ----------- | --------- | ------------------------ |
| id          | BIGINT    | Primary key              |
| question_id | BIGINT    | Foreign key to questions |
| user_id     | BIGINT    | Foreign key to users     |
| content     | TEXT      | Answer content           |
| created_at  | TIMESTAMP |                          |
| updated_at  | TIMESTAMP |                          |

## Key Features Explained

### Role-Based Access Control

-   **User Role**:
    -   Can ask questions and answer
    -   Can view all courses and materials
    -   Can upload profile avatar and bio
    -   Cannot create/edit/delete courses/chapters/materials
-   **Admin Role**:
    -   All User permissions
    -   Can create/edit/delete courses
    -   Can create/edit/delete chapters
    -   Can upload/edit/delete materials
    -   Can access `/admin/users` to manage user roles
    -   Can export any user's data

### File Storage & Handling

-   Uploaded materials stored in `storage/app/public/materials/`
-   User avatars stored in `storage/app/public/avatars/`
-   Files served via `/storage/` symlink at `public/storage`
-   Old files automatically deleted when:
    -   Material is replaced with new file
    -   Material is deleted
    -   User replaces avatar

### PDF Preview & Download

-   Materials with PDF files can be previewed via embedded iframe
-   No download required to view
-   Download button available for all file types
-   PDF export for chapters combines all materials

### Public Profiles with Analytics

-   Chart.js bar chart shows user's Q&A stats
-   DataTables for recent questions/answers with:
    -   Pagination (5 per page)
    -   Sorting by ID, title, date
    -   Search functionality
-   Excel export uses `maatwebsite/excel` for professional formatting

### Responsive & User-Friendly

-   Built with Bootstrap 5
-   Mobile-friendly layouts
-   DataTables responsive on all screen sizes
-   Placeholder avatars via UI-Avatars API (no image processing overhead)

## Troubleshooting

### Storage Link Issues - Files Return 403 Forbidden

```powershell
php artisan storage:link
php artisan cache:clear
```

### Database Migration Errors

Ensure database exists and credentials in `.env` are correct:

```powershell
php artisan migrate:refresh       # Reset and re-run all migrations
php artisan migrate:reset         # Reset without re-running
php artisan migrate               # Run pending migrations
```

### Excel Export Not Working

Ensure `maatwebsite/excel` is installed:

```powershell
composer require maatwebsite/excel
```

### Chart or DataTables Not Showing

-   Ensure layout has `@yield('scripts')` section
-   Check browser console for JavaScript errors
-   Verify CDN links are accessible

### Can't Upload Files

-   Check file size (max 2MB)
-   Check file format (any format allowed)
-   Verify `storage/app/public/` directory exists and is writable

## Future Enhancement Ideas

-   Full-text search for courses, Q&A
-   Email notifications for new answers
-   Fine-grained permissions via Policies middleware
-   Comment system on answers
-   Rating/voting system for answers
-   Email verification on registration
-   Two-factor authentication for admins
-   Admin analytics dashboard
-   User activity logs
-   Material categories/tags
-   Discussion threads
-   Real-time notifications (WebSocket)

## Project Milestones

### Completed ✅

-   User authentication & registration
-   Role-based access (admin/user)
-   Course/Chapter/Material CRUD with file uploads
-   Q&A system with edit/delete
-   User profiles (private & public)
-   Profile avatars and bio
-   User role management UI
-   Q&A statistics with Chart.js
-   DataTables for user activities
-   Excel export with multiple sheets
-   Clickable user names in Q&A
-   PDF preview and download
-   Material PDF export

### In Progress 🔄

-   Documentation

### Roadmap 📋

-   Search functionality
-   Notifications system
-   Advanced permissions
-   Admin dashboard

## License

This project is open source and available under the MIT License.

---

**Created**: December 3, 2025  
**Last Updated**: December 3, 2025  
**Project Name**: 1ToAsk1ToKnow Learning Platform  
**Location**: `d:\projeklaravel\1a1k`
