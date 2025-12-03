# Program Flow Explanation - 1ToAsk1ToKnow

## Table of Contents

1. [Program Entry Point](#program-entry-point)
2. [Complete User Journey](#complete-user-journey)
3. [Route & Controller Mapping](#route--controller-mapping)
4. [Data Flow Diagrams](#data-flow-diagrams)
5. [Feature Workflows](#feature-workflows)

---

## Program Entry Point

### Starting the Application

**Command:**

```powershell
php artisan serve
```

**What happens:**

1. Laravel starts development server at `http://localhost:8000`
2. User visits homepage → **Route: `GET /`**

### Homepage (`GET /`)

```
User visits localhost:8000
        ↓
    routes/web.php
        ↓
Route::get('/', function () {
    return view('index');
});
        ↓
    resources/views/index.blade.php
        ↓
    Layout: main.blade.php (with navbar)
        ↓
    Display: Welcome message + navigation options
```

**What the homepage shows:**

-   Welcome title: "1ToAsk1ToKnow"
-   Introduction text in Indonesian
-   Navigation bar with:
    -   Logo "1ToAsk1ToKnow" (links to home)
    -   "Materi" link (courses)
    -   "Q&A" link (questions)
    -   Login button (if not logged in)
    -   User name + Logout button (if logged in)
    -   "Users" link (if user is admin)

---

## Complete User Journey

### Scenario 1: New User Registration

```
Homepage
  ↓
User clicks "Login" button or navigates to /login
  ↓
Route: GET /login → LoginController@index
  ↓
Display: resources/views/auth/login.blade.php
  ↓
User clicks "Belum punya akun? Daftar disini"
  ↓
Route: GET /register → RegisterController@index
  ↓
Display: resources/views/auth/register.blade.php
  ↓
User fills form:
  - Name
  - Email
  - Password
  - Confirm Password
  ↓
User clicks "Register" button
  ↓
Route: POST /register → RegisterController@store
  ↓
RegisterController validates & creates user:
  - Hash password
  - Save to users table with role='user' (default)
  ↓
Redirect to /login with success message
  ↓
User logs in with email & password
  ↓
Route: POST /login → LoginController@authenticate
  ↓
LoginController validates credentials & logs in user
  ↓
Redirect to dashboard (after login, typically /profile or /qna)
```

**Database Changes:**

-   New row inserted into `users` table with: name, email, password (hashed), role='user', created_at

---

### Scenario 2: User Exploring Q&A

```
After login → User navigates to /qna
  ↓
Route: GET /qna → QuestionController@index
  ↓
QuestionController:
  $questions = Question::with('user')->get();
  ↓
  Fetch all questions from database with associated user info
  ↓
Display: resources/views/qna/index.blade.php
  ↓
Show: List of questions with:
  - Title
  - Content preview
  - Asked by: [CLICKABLE USER NAME] ← Links to /users/{user_id}
  - Created time (relative)
  - "Lihat detail" (View detail) button
```

**User clicks on a question:**

```
User clicks "Lihat detail" or question title
  ↓
Route: GET /qna/{question} → QuestionController@show
  ↓
QuestionController:
  $question = Question::with(['user', 'answers.user'])->findOrFail($id);
  ↓
  Fetch question with all answers and user info
  ↓
Display: resources/views/qna/show.blade.php
  ↓
Show:
  - Question title & content
  - Asked by: [CLICKABLE USER NAME] → /users/{user_id}
  - All answers with:
    - Answer content
    - Answered by: [CLICKABLE USER NAME] → /users/{user_id}
    - Edit/Delete buttons (if user is author)
  - Form to add new answer (if logged in)
```

**User adds an answer:**

```
User fills answer textarea
  ↓
User clicks "Kirim Jawaban" button
  ↓
Route: POST /answer → AnswerController@store
  ↓
AnswerController:
  Validate content
  Create answer:
    - question_id = current question
    - user_id = auth()->id()
    - content = user input
  Save to answers table
  ↓
Redirect back with success message
```

**Database Changes:**

-   New row in `answers` table: question_id, user_id, content, created_at

---

### Scenario 3: User Asking a Question

```
User clicks "Buat Pertanyaan" button
  ↓
Route: GET /qna/create → QuestionController@create
  ↓
Display: resources/views/qna/create.blade.php
  ↓
Show: Form with fields:
  - Title (required)
  - Content (required)
  ↓
User fills & clicks "Simpan" button
  ↓
Route: POST /qna → QuestionController@store
  ↓
QuestionController:
  Validate title & content
  Create question:
    - user_id = auth()->id()
    - title = user input
    - content = user input
  Save to questions table
  ↓
Redirect to /qna with success message
```

**Database Changes:**

-   New row in `questions` table: user_id, title, content, created_at

---

### Scenario 4: Viewing User Profile (Public)

```
User clicks on any user name in Q&A section
  ↓
Route: GET /users/{user} → UserController@show
  ↓
UserController:
  $questions = $user->questions()->latest()->take(50)->get();
  $answers = $user->answers()->latest()->take(50)->with('question')->get();
  $questionCount = $user->questions()->count();
  $answerCount = $user->answers()->count();
  ↓
  Fetch user's recent Q&A data
  ↓
Display: resources/views/users/show.blade.php
  ↓
Show:
  - Avatar (or placeholder from UI-Avatars API)
  - User name
  - Email
  - Bio (if exists)
  - Badges: "Questions: X" "Answers: Y"
  - Export CSV button (if logged in as that user or admin)
  - Chart.js bar chart showing Q/A counts
  - DataTables:
    - Recent 50 questions (ID, Title, Created)
    - Recent 50 answers (ID, For Question, Created)

  ↓
JavaScript loads:
  - Chart.js library
  - DataTables library & jQuery
  - Initializes chart and sortable tables
```

---

### Scenario 5: Admin Managing Courses

```
Admin user navigates to /courses
  ↓
Route: GET /courses (via Route::resource) → CourseController@index
  ↓
CourseController:
  $courses = Course::all();
  ↓
Display: resources/views/courses/index.blade.php
  ↓
Show:
  - List of all courses
  - (Admin only) "Tambah Course" button at top
  ↓
Admin clicks "Tambah Course"
  ↓
Route: GET /courses/create → CourseController@create
  ↓
Display: resources/views/courses/create.blade.php
  ↓
Show: Form with:
  - Title (required)
  - Description (optional)
  ↓
Admin fills & clicks "Simpan"
  ↓
Route: POST /courses → CourseController@store
  ↓
CourseController:
  Check: if user is not admin → abort(403)
  Validate title
  Create course:
    - title = input
    - description = input
  Save to courses table
  ↓
Redirect to courses.show with new course
```

**Database Changes:**

-   New row in `courses` table: title, description, created_at, updated_at

---

### Scenario 6: Admin Adding Materials to Chapter

```
Admin in course detail → clicks chapter → "Tambah Material" button
  ↓
Route: GET /chapters/{chapter}/materials/create → MaterialController@create
  ↓
Display: resources/views/materials/create.blade.php
  ↓
Show: Form with:
  - Title (required)
  - Description (optional)
  - File upload (max 2MB, required)
  ↓
Admin selects PDF file & fills form
  ↓
User clicks "Simpan"
  ↓
Route: POST /chapters/{chapter}/materials → MaterialController@store
  ↓
MaterialController:
  Check: if user is not admin → abort(403)
  Validate: title, file (max 2MB, required)
  Store file to: storage/app/public/materials/{filename}
  Create material:
    - chapter_id = current chapter
    - title = input
    - description = input
    - file_path = stored path
  Save to materials table
  ↓
Redirect to chapter.show with success
```

**Database Changes:**

-   New row in `materials` table: chapter_id, title, description, file_path, created_at, updated_at

**File System Changes:**

-   PDF file saved to: `storage/app/public/materials/filename.pdf`

---

### Scenario 7: User Viewing Material PDF

```
User in chapter detail → sees materials list
  ↓
User clicks "Preview" button on a material
  ↓
Route: GET /materials/{material}/preview → MaterialController@preview
  ↓
MaterialController:
  Load material from database
  Return view with embedded iframe
  ↓
Display: resources/views/materials/preview.blade.php
  ↓
Show: PDF embedded in iframe at:
  <iframe src="storage/{file_path}"></iframe>
  ↓
User sees PDF in browser (no download needed)
```

**No database changes** (read-only operation)

---

### Scenario 8: Exporting User Data as Excel

```
User visits public profile /users/{user_id}
  ↓
(If logged in as that user or admin)
  ↓
User clicks "Export CSV" button
  ↓
Route: GET /users/{user}/export → UserController@exportCsv
  ↓
UserController:
  Check permission: if user not author & not admin → abort(403)
  Create UserQnaExport with user data
  ↓
UserQnaExport (app/Exports/UserQnaExport.php):
  Uses maatwebsite/excel
  Generate 2 sheets:
    - Questions sheet:
      - Fetch all user's questions
      - Export: ID, Title, Content, Created At
    - Answers sheet:
      - Fetch all user's answers with question titles
      - Export: ID, For Question, Content, Created At
  ↓
Excel::download() streams file to browser
  ↓
Browser downloads: user-{id}-qna-{timestamp}.xlsx
```

**No database changes** (read-only operation)

---

### Scenario 9: Admin Managing User Roles

```
Admin clicks "Users" link in navbar
  ↓
Route: GET /admin/users → UserController@index
  ↓
UserController:
  Check: if not admin → abort(403)
  $users = User::orderBy('id','asc')->paginate(20);
  ↓
Display: resources/views/admin/users/index.blade.php
  ↓
Show:
  - Table of all users (paginated, 20 per page)
  - Columns: ID, Name, Email, Role
  - For each user: dropdown select (user/admin) + "Save" button
  ↓
Admin changes dropdown for a user from "user" to "admin"
  ↓
Admin clicks "Save" button
  ↓
Route: PUT /admin/users/{user}/role → UserController@updateRole
  ↓
UserController:
  Check: if not admin → abort(403)
  Validate: role in [user, admin]
  Check: if trying to demote self → return error
  Update user:
    - role = new role value
    - save()
  ↓
Redirect with success message
```

**Database Changes:**

-   User record updated: role = 'admin' (or 'user')

---

### Scenario 10: User Editing Profile

```
User clicks their name in navbar
  ↓
Route: GET /profile → ProfileController@index
  ↓
Display: resources/views/profile.blade.php
  ↓
Show:
  - Avatar (or placeholder)
  - Name
  - Email
  - Bio (if exists)
  - Form to upload avatar (file input)
  - Form to edit bio (textarea, max 1000 chars)
  ↓
User uploads image (max 2MB, jpg/png/gif/etc)
  ↓
User fills bio text
  ↓
User clicks "Simpan"
  ↓
Route: PUT /profile → ProfileController@update
  ↓
ProfileController:
  If file uploaded:
    - Delete old avatar if exists
    - Store new file to: storage/app/public/avatars/{filename}
    - Save path to user.avatar
  If bio filled:
    - Update user.bio with text
  Save user record
  ↓
Redirect with success message
```

**Database Changes:**

-   User record updated: avatar = path, bio = text

**File System Changes:**

-   Old avatar deleted (if replaced)
-   New avatar saved to: `storage/app/public/avatars/filename`

---

## Route & Controller Mapping

### Authentication Routes

| HTTP | Route       | Controller         | Method       | Description            |
| ---- | ----------- | ------------------ | ------------ | ---------------------- |
| GET  | `/register` | RegisterController | index        | Show registration form |
| POST | `/register` | RegisterController | store        | Process registration   |
| GET  | `/login`    | LoginController    | index        | Show login form        |
| POST | `/login`    | LoginController    | authenticate | Process login          |
| POST | `/logout`   | (Inline)           | -            | Process logout         |

### Public Routes

| HTTP | Route           | Controller     | Method | Description         |
| ---- | --------------- | -------------- | ------ | ------------------- |
| GET  | `/`             | (Inline)       | -      | Show homepage       |
| GET  | `/users/{user}` | UserController | show   | View public profile |

### Protected Routes (Require Login)

#### Profile Routes

| HTTP | Route      | Controller        | Method | Description         |
| ---- | ---------- | ----------------- | ------ | ------------------- |
| GET  | `/profile` | ProfileController | index  | Show user's profile |
| PUT  | `/profile` | ProfileController | update | Update avatar & bio |

#### Q&A Routes

| HTTP   | Route                   | Controller         | Method  | Description               |
| ------ | ----------------------- | ------------------ | ------- | ------------------------- |
| GET    | `/qna`                  | QuestionController | index   | List all questions        |
| GET    | `/qna/create`           | QuestionController | create  | Show create question form |
| POST   | `/qna`                  | QuestionController | store   | Save new question         |
| GET    | `/qna/{question}`       | QuestionController | show    | View question & answers   |
| GET    | `/qna/{question}/edit`  | QuestionController | edit    | Show edit question form   |
| PUT    | `/qna/{question}`       | QuestionController | update  | Update question           |
| DELETE | `/qna/{question}`       | QuestionController | destroy | Delete question           |
| POST   | `/answer`               | AnswerController   | store   | Save new answer           |
| GET    | `/answer/{answer}/edit` | AnswerController   | edit    | Show edit answer form     |
| PUT    | `/answer/{answer}`      | AnswerController   | update  | Update answer             |
| DELETE | `/answer/{answer}`      | AnswerController   | destroy | Delete answer             |

#### Course Routes (Resource)

| HTTP   | Route                    | Controller       | Method  | Description                   |
| ------ | ------------------------ | ---------------- | ------- | ----------------------------- |
| GET    | `/courses`               | CourseController | index   | List all courses              |
| GET    | `/courses/create`        | CourseController | create  | Show create form (admin only) |
| POST   | `/courses`               | CourseController | store   | Save course (admin only)      |
| GET    | `/courses/{course}`      | CourseController | show    | View course                   |
| GET    | `/courses/{course}/edit` | CourseController | edit    | Show edit form (admin only)   |
| PUT    | `/courses/{course}`      | CourseController | update  | Update course (admin only)    |
| DELETE | `/courses/{course}`      | CourseController | destroy | Delete course (admin only)    |

#### Chapter Routes

| HTTP   | Route                               | Controller        | Method  | Description              |
| ------ | ----------------------------------- | ----------------- | ------- | ------------------------ |
| GET    | `/courses/{course}/chapters/create` | ChapterController | create  | Show create form (admin) |
| POST   | `/courses/{course}/chapters`        | ChapterController | store   | Save chapter (admin)     |
| GET    | `/chapters/{chapter}`               | ChapterController | show    | View chapter             |
| GET    | `/chapters/{chapter}/edit`          | ChapterController | edit    | Show edit form (admin)   |
| PUT    | `/chapters/{chapter}`               | ChapterController | update  | Update chapter (admin)   |
| DELETE | `/chapters/{chapter}`               | ChapterController | destroy | Delete chapter (admin)   |

#### Material Routes

| HTTP   | Route                                  | Controller         | Method    | Description                  |
| ------ | -------------------------------------- | ------------------ | --------- | ---------------------------- |
| GET    | `/chapters/{chapter}/materials/create` | MaterialController | create    | Show upload form (admin)     |
| POST   | `/chapters/{chapter}/materials`        | MaterialController | store     | Save material & file (admin) |
| GET    | `/materials/{material}/preview`        | MaterialController | preview   | Preview PDF in iframe        |
| GET    | `/materials/{material}/download`       | MaterialController | download  | Download file                |
| GET    | `/materials/{material}/edit`           | MaterialController | edit      | Show edit form (admin)       |
| PUT    | `/materials/{material}`                | MaterialController | update    | Update material (admin)      |
| DELETE | `/materials/{material}`                | MaterialController | destroy   | Delete material (admin)      |
| GET    | `/chapters/{chapter}/materials/pdf`    | MaterialController | exportPdf | Export chapter as PDF        |

#### Admin Routes

| HTTP | Route                      | Controller     | Method     | Description                   |
| ---- | -------------------------- | -------------- | ---------- | ----------------------------- |
| GET  | `/admin/users`             | UserController | index      | List all users (admin only)   |
| PUT  | `/admin/users/{user}/role` | UserController | updateRole | Change user role (admin only) |
| GET  | `/users/{user}/export`     | UserController | exportCsv  | Export user's Q&A as Excel    |

---

## Data Flow Diagrams

### Registration & Login Flow

```
START (Homepage)
  ↓
USER NOT LOGGED IN?
  ├─ YES → Show "Login" button
  │         ↓
  │         User clicks "Belum punya akun? Daftar"
  │         ↓
  │     [REGISTRATION FORM]
  │         ↓
  │     POST /register
  │         ↓
  │     Create User (role='user')
  │         ↓
  │     Save to Database
  │         ↓
  │     Redirect to /login
  │         ↓
  │     [LOGIN FORM]
  │         ↓
  │     POST /login
  │         ↓
  │     Verify credentials
  │         ↓
  │     Create session
  │         ↓
  │     SET auth()->user()
  │
  └─ NO → Show navbar with:
           - User name (clickable → /profile)
           - Logout button
           - "Users" link (if role='admin')
```

### Content Access Control

```
USER VISITS /courses
  ↓
Middleware: auth (required)
  ├─ NOT LOGGED IN → Redirect to /login
  └─ LOGGED IN → Continue
  ↓
CourseController@index
  ↓
Load courses
  ↓
View displayed with:
  ├─ All users → Can VIEW courses
  │
  └─ Admin only → Can:
      - See "Tambah Course" button
      - Create new course
      - Edit own courses
      - Delete own courses
```

### File Upload & Storage Flow

```
Admin uploads material PDF
  ↓
POST /chapters/{chapter}/materials
  ↓
MaterialController@store
  ↓
Validate:
  - Title required?
  - File exists?
  - File size ≤ 2MB?
  ├─ Validation fails → Return error
  └─ Validation passes → Continue
  ↓
Store file:
  Storage::disk('public')->put(
    'materials/' . $filename,
    $file
  )
  ↓
File saved to:
  storage/app/public/materials/filename
  ↓
Create database record:
  Material::create([
    'chapter_id' => $chapter->id,
    'title' => $title,
    'file_path' => 'materials/filename'
  ])
  ↓
Saved to: storage/app/public/materials/
Symlink at: public/storage/
Access via: /storage/materials/filename
```

### User Profile Public View

```
User clicks name in Q&A
  ↓
GET /users/{user}
  ↓
UserController@show
  ↓
Load data:
  - User record
  - Last 50 questions
  - Last 50 answers
  - Count totals
  ↓
View: resources/views/users/show.blade.php
  ↓
Display:
  - Avatar (from DB or UI-Avatars API)
  - Bio
  - Stats badges
  ↓
Load JavaScript:
  - Chart.js (CDN)
  - jQuery (CDN)
  - DataTables (CDN)
  ↓
Initialize:
  - Bar chart: Questions vs Answers
  - Table 1: Sortable recent questions
  - Table 2: Sortable recent answers
```

---

## Feature Workflows

### Complete Q&A Workflow

```
1. USER ASKS QUESTION
   ├─ GET /qna/create → Form
   └─ POST /qna → Save to DB

2. USER ANSWERS QUESTION
   ├─ GET /qna/{id} → Show Q & A list
   └─ POST /answer → Save to DB

3. USER EDITS ANSWER
   ├─ GET /answer/{id}/edit → Edit form
   └─ PUT /answer/{id} → Update DB

4. USER DELETES ANSWER
   ├─ Click Delete button
   └─ DELETE /answer/{id} → Remove from DB

5. VIEW OTHER USER'S PROFILE
   ├─ Click user name
   ├─ GET /users/{user}
   ├─ See profile with chart
   └─ See their Q&A in tables
```

### Complete Course Management Workflow

```
ADMIN CREATES COURSE
  ├─ GET /courses/create
  ├─ POST /courses → Create course
  └─ Redirect to courses.show

ADMIN ADDS CHAPTER
  ├─ GET /courses/{course}/chapters/create
  ├─ POST /courses/{course}/chapters → Create chapter
  └─ Redirect to chapters.show

ADMIN UPLOADS MATERIAL
  ├─ GET /chapters/{chapter}/materials/create
  ├─ POST /chapters/{chapter}/materials → Upload file + create DB record
  └─ File saved to storage/app/public/materials/

USER ACCESSES MATERIAL
  ├─ GET /materials/{id}/preview → View PDF in iframe
  ├─ GET /materials/{id}/download → Download file
  └─ GET /chapters/{id}/materials/pdf → Export as PDF

ADMIN EDITS MATERIAL
  ├─ GET /materials/{id}/edit
  ├─ PUT /materials/{id} → Update DB & file (old file deleted)
  └─ File replaced in storage

ADMIN DELETES MATERIAL
  ├─ DELETE /materials/{id}
  ├─ File deleted from storage
  └─ Record removed from DB
```

### User Role Management Workflow

```
NEW USER REGISTRATION
  ├─ User signs up
  ├─ role = 'user' (default)
  └─ Cannot access admin features

ADMIN VIEWS USERS
  ├─ GET /admin/users (admin only)
  ├─ Show list of all users
  └─ Display role dropdown for each

ADMIN CHANGES USER ROLE
  ├─ Select "admin" from dropdown
  ├─ Click Save
  ├─ PUT /admin/users/{user}/role
  ├─ role updated in database
  └─ User now sees admin features

ADMIN TRYING TO DEMOTE SELF
  ├─ Change own role to "user"
  ├─ PUT /admin/users/{self}/role
  ├─ Controller checks: if user_id === auth()->id()
  ├─ Return error: "Cannot remove own admin role"
  └─ Update fails, no DB change
```

---

## Complete Application Data Flow

```
┌─────────────────────────────────────────────────────┐
│              BROWSER / USER                          │
└─────────────────┬───────────────────────────────────┘
                  │
                  ↓
         ┌────────────────┐
         │  HTTP REQUEST  │
         │   (Route URL)  │
         └────────┬───────┘
                  │
                  ↓
     ┌────────────────────────┐
     │   routes/web.php       │
     │  Match Route & Check   │
     │  Middleware (auth?)    │
     └────────┬───────────────┘
              │
              ↓
    ┌──────────────────────┐
    │  CONTROLLER ACTION   │
    │  - Validate input    │
    │  - Query database    │
    │  - Process logic     │
    └────────┬─────────────┘
             │
             ├──→ Fetch/Create data
             │
             ↓
    ┌──────────────────────┐
    │   DATABASE (MySQL)   │
    │  - users table       │
    │  - questions table   │
    │  - answers table     │
    │  - courses table     │
    │  - chapters table    │
    │  - materials table   │
    └────────┬─────────────┘
             │
             ↓
    ┌──────────────────────┐
    │   FILE STORAGE       │
    │  - Avatars           │
    │  - Materials (PDFs)  │
    └────────┬─────────────┘
             │
             ↓
    ┌──────────────────────────┐
    │   RENDER BLADE VIEW      │
    │  - Load data             │
    │  - Render HTML           │
    │  - Include CSS/JS        │
    └────────┬─────────────────┘
             │
             ↓
    ┌──────────────────────────┐
    │   HTTP RESPONSE (HTML)   │
    └────────┬─────────────────┘
             │
             ↓
┌────────────────────────────────────────┐
│  BROWSER RECEIVES & RENDERS            │
│  - Display HTML                        │
│  - Load CSS (Bootstrap 5)              │
│  - Load JS (Chart.js, DataTables)      │
│  - Execute CDN scripts                 │
└────────────────────────────────────────┘
```

---

## Key Points Summary

1. **Entry Point**: `GET /` shows homepage with login/navigation
2. **Authentication**: Registration creates users with role='user' by default
3. **Protected Routes**: Most features require login (auth middleware)
4. **Role-Based Access**: Admin features check `auth()->user()->role === 'admin'`
5. **File Uploads**: Stored in `storage/app/public/`, served via symlink
6. **Q&A System**: Questions & Answers linked to users, fully CRUD
7. **Public Profiles**: Anyone can view user profiles, see stats & data
8. **Excel Export**: Uses maatwebsite/excel for formatted multi-sheet exports
9. **Charts & Tables**: Chart.js and DataTables load via CDN on public profile
10. **Relationships**: Users → Questions, Users → Answers, Courses → Chapters → Materials

---

**Document Created**: December 3, 2025  
**For**: 1ToAsk1ToKnow Learning Platform  
**Project Path**: `d:\projeklaravel\1a1k`
