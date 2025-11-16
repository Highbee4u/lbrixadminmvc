# Simple Universal MVC Framework

## 🎯 The Solution to Your Problem

This MVC framework works on **ANY server** without complicated configuration:
- ✅ **Apache** (with or without .htaccess)
- ✅ **IIS** (with or without web.config)  
- ✅ **Nginx**
- ✅ **Any shared hosting**

**No URL rewriting needed!** Just upload and it works.

---

## 🚀 Quick Start

### 1. Upload Files
Upload all files to your web server via FileZilla.

### 2. Configure Database
Edit `config/database.php`:
```php
$dbConfig = [
    'host' => 'localhost',
    'database' => 'your_database',
    'username' => 'your_username',
    'password' => 'your_password',
];
```

### 3. Visit Your Site
```
http://yourdomain.com/index.php
```

That's it! No .htaccess or web.config configuration needed!

---

## 📂 Project Structure

```
project/
├── index.php              # Entry point
├── config/
│   ├── app.php           # Application config
│   └── database.php      # Database config
├── app/
│   ├── Core/             # Framework core files
│   ├── Controllers/      # Your controllers
│   ├── Models/          # Your models
│   └── Services/        # Your services
├── resources/
│   └── views/           # Your view files
├── assets/              # CSS, JS, images
└── storage/             # Logs, uploads, cache
```

---

## 🔗 URL Structure

### Basic URLs
```
Homepage:        index.php
Dashboard:       index.php?url=dashboard
Users:           index.php?url=users
Create User:     index.php?url=users/create
Edit User:       index.php?url=users/edit/123
```

### In Your Views
```php
<!-- Generate URLs -->
<a href="<?= url('dashboard') ?>">Dashboard</a>
<a href="<?= url('users/create') ?>">Create User</a>

<!-- Load Assets -->
<link href="<?= asset('css/style.css') ?>" rel="stylesheet">
<script src="<?= asset('js/app.js') ?>"></script>
```

### In Your Controllers
```php
// Redirect
$this->redirect('dashboard');
redirect('users');

// Load Views
$this->view('dashboard.index', $data);
$this->viewWithLayout('users.index', $data, 'layouts.app');
```

---

## 📝 Creating Controllers

```php
<?php

class UsersController extends Controller
{
    public function index()
    {
        // Your code here
        $users = []; // Get from database
        
        $this->view('users.index', ['users' => $users]);
    }
    
    public function create()
    {
        $this->view('users.create');
    }
    
    public function store()
    {
        // Handle form submission
        // Validate and save
        
        flash('success', 'User created successfully!');
        $this->redirect('users');
    }
    
    public function edit($id)
    {
        // Edit user with ID
        $user = []; // Get from database
        
        $this->view('users.edit', ['user' => $user]);
    }
}
```

---

## 🛠 Helper Functions

```php
// URLs
url('dashboard')                 // Generate URL
asset('css/style.css')          // Asset URL
redirect('users')               // Redirect

// Authentication
isAuth()                        // Check if logged in
auth()                          // Get current user

// Flash Messages
flash('success', 'Saved!')      // Set message
flash('success')                // Get message

// Forms
old('email')                    // Old input value
error('email')                  // Validation error

// Output
e($variable)                    // Escape for safety

// Debug
dd($variable)                   // Dump and die
dump($variable)                 // Just dump
```

---

## 🔐 Authentication Example

```php
// In your LoginController
public function login()
{
    // Validate credentials
    if ($valid) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = $user;
        redirect('dashboard');
    }
}

// In your DashboardController
public function __construct()
{
    parent::__construct();
    $this->requireAuth(); // Protect all methods
}
```

---

## 📋 Migration from Your Current Project

See `MIGRATION-GUIDE.md` for detailed instructions on moving your existing project to this framework.

### Quick Summary:
1. Copy your Controllers → `app/Controllers/`
2. Copy your Models → `app/Models/`
3. Copy your Views → `resources/views/`
4. Copy your Core files → `app/Core/`
5. Update URLs to use `url()` helper
6. Update asset paths to use `asset()` helper
7. Upload and test!

---

## ✨ Features

- ✅ Works on any server (Apache, IIS, Nginx)
- ✅ No URL rewriting configuration required
- ✅ Simple and easy to understand
- ✅ MVC architecture
- ✅ Built-in helpers (url, asset, redirect, etc.)
- ✅ Flash messages
- ✅ Form validation support
- ✅ Authentication helpers
- ✅ View layouts support
- ✅ Database abstraction (use your existing Database class)

---

## 🎨 Optional: Pretty URLs

Once it's working, you can OPTIONALLY add URL rewriting to remove `index.php?url=`:

**Apache** - Create `.htaccess`:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

**IIS** - Create `web.config`:
```xml
<rewrite>
    <rules>
        <rule name="MVC" stopProcessing="true">
            <match url="^(.*)$" />
            <conditions>
                <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
                <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
            </conditions>
            <action type="Rewrite" url="index.php?url={R:1}" />
        </rule>
    </rules>
</rewrite>
```

But it works perfectly WITHOUT these files!

---

## 🆘 Support

This framework is designed to be simple and work everywhere.

If you encounter issues:
1. Check `MIGRATION-GUIDE.md` for common problems
2. Verify your database credentials in `config/database.php`
3. Ensure PHP is enabled on your server
4. Check file paths are correct

---

## 📄 License

Free to use for any purpose.

---

**Built to solve shared hosting deployment headaches! 🚀**
