# SIMPLE MVC FRAMEWORK - MIGRATION GUIDE

## 🎯 What You Get

A **simple, universal MVC framework** that works on ANY server:
- ✅ Apache (with or without .htaccess)
- ✅ IIS (with or without web.config)
- ✅ Nginx
- ✅ Any shared hosting

**No URL rewriting configuration needed!**

---

## 📦 Framework Structure

```
simple-mvc-framework/
├── index.php                    ← Entry point
├── config/
│   ├── app.php                  ← App settings
│   └── database.php             ← Database config
├── app/
│   ├── Core/
│   │   ├── Router.php           ← Universal router
│   │   ├── Controller.php       ← Base controller
│   │   ├── View.php            ← View handler
│   │   ├── Helpers.php         ← Helper functions
│   │   ├── Database.php        ← Your existing DB class
│   │   ├── Session.php         ← Your existing Session
│   │   ├── Auth.php            ← Your existing Auth
│   │   └── ... (other core files)
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   └── DashboardController.php
│   └── Models/
│       └── BaseModel.php
├── resources/
│   └── views/
│       ├── home/
│       ├── dashboard/
│       └── layouts/
├── public/ or assets/
│   ├── css/
│   ├── js/
│   └── images/
└── storage/
    └── logs/
```

---

## 🚀 HOW TO MIGRATE YOUR EXISTING PROJECT

### Step 1: Copy the Framework Files

1. **Download** all files from the simple-mvc-framework
2. **Upload** to your server (alongside your current project)

### Step 2: Copy Your Existing Files

#### Controllers
Copy all your controllers from `app/Controllers/` to the new framework:
```
YOUR OLD PROJECT:
app/Controllers/AdminController.php
app/Controllers/ListingsController.php
app/Controllers/UsersController.php

COPY TO NEW FRAMEWORK:
simple-mvc-framework/app/Controllers/AdminController.php
simple-mvc-framework/app/Controllers/ListingsController.php
simple-mvc-framework/app/Controllers/UsersController.php
```

**Important:** Make sure each controller extends `Controller`:
```php
class AdminController extends Controller
{
    // Your existing code
}
```

#### Models
Copy all your models:
```
app/Models/*.php → simple-mvc-framework/app/Models/
```

#### Views
Copy all your views:
```
resources/views/*.php → simple-mvc-framework/resources/views/
```

#### Services
Copy your services:
```
app/Services/*.php → simple-mvc-framework/app/Services/
```

#### Core Files (Database, Auth, etc.)
Copy your existing core files:
```
app/Core/Database.php → simple-mvc-framework/app/Core/
app/Core/Auth.php → simple-mvc-framework/app/Core/
app/Core/Session.php → simple-mvc-framework/app/Core/
app/Core/Validator.php → simple-mvc-framework/app/Core/
... (any other core files you need)
```

#### Assets
Copy your assets:
```
assets/* → simple-mvc-framework/assets/
OR
public/assets/* → simple-mvc-framework/assets/
```

### Step 3: Update Your Controllers

In your existing controllers, change how you generate URLs.

**OLD (doesn't work everywhere):**
```php
header('Location: /dashboard');
redirect('/dashboard');
```

**NEW (works everywhere):**
```php
$this->redirect('dashboard');
// OR
redirect('dashboard');
```

**In your views, change links:**

**OLD:**
```html
<a href="/dashboard">Dashboard</a>
<a href="/users/create">Create User</a>
```

**NEW:**
```html
<a href="<?= url('dashboard') ?>">Dashboard</a>
<a href="<?= url('users/create') ?>">Create User</a>
```

**For assets:**
```html
<!-- OLD -->
<link href="/assets/css/style.css" rel="stylesheet">
<script src="/assets/js/app.js"></script>

<!-- NEW -->
<link href="<?= asset('css/style.css') ?>" rel="stylesheet">
<script src="<?= asset('js/app.js') ?>"></script>
```

### Step 4: Update Database Config

Edit `config/database.php`:
```php
$dbConfig = [
    'host' => 'localhost',
    'database' => 'your_actual_database_name',
    'username' => 'your_actual_username',
    'password' => 'your_actual_password',
    'charset' => 'utf8mb4',
];
```

### Step 5: Upload and Test

1. Upload the entire `simple-mvc-framework/` folder to your server
2. Visit: `https://devadmin.lbrix.com/index.php`
3. Test navigation: `https://devadmin.lbrix.com/index.php?url=dashboard`

---

## 🔗 URL Structure

### How URLs Work Now:

**Homepage:**
```
https://devadmin.lbrix.com/index.php
```

**Dashboard:**
```
https://devadmin.lbrix.com/index.php?url=dashboard
```

**Users List:**
```
https://devadmin.lbrix.com/index.php?url=users
```

**Create User:**
```
https://devadmin.lbrix.com/index.php?url=users/create
```

**Edit User (with parameter):**
```
https://devadmin.lbrix.com/index.php?url=users/edit/123
```

### URL Mapping:

```
index.php?url=dashboard
           └─────┬─────┘
                 │
          DashboardController->index()

index.php?url=users/create
           └──┬──┘ └──┬──┘
              │       │
       UsersController->create()

index.php?url=users/edit/123
           └──┬──┘ └┬─┘ └┬┘
              │     │    │
       UsersController->edit($id = 123)
```

---

## 🛠 Helper Functions Available

```php
// Generate URLs
url('dashboard')                    // index.php?url=dashboard
url('users/create')                 // index.php?url=users/create
url()                               // index.php (homepage)

// Generate asset URLs
asset('css/style.css')              // /assets/css/style.css
asset('js/app.js')                  // /assets/js/app.js

// Redirects
redirect('dashboard')               // Redirect to dashboard
redirect('users')                   // Redirect to users

// Authentication
isAuth()                            // Check if logged in
auth()                              // Get current user data

// Flash messages
flash('success', 'User created!')   // Set flash message
flash('success')                    // Get and clear flash message

// Old input (form repopulation)
old('email')                        // Get old input value

// Escape output
e($variable)                        // Escape for XSS protection

// Debug
dd($variable)                       // Dump and die
dump($variable)                     // Just dump

// Views
view('dashboard.index', $data)      // Render view
```

---

## ✅ Advantages of This Framework

1. **Works Everywhere** - No server configuration needed
2. **Simple** - Easy to understand and modify
3. **Compatible** - Works with your existing code
4. **No Dependencies** - Doesn't require URL rewriting
5. **Portable** - Move between servers easily

---

## 🔄 Quick Migration Checklist

- [ ] Download simple-mvc-framework
- [ ] Copy your Controllers to app/Controllers/
- [ ] Copy your Models to app/Models/
- [ ] Copy your Views to resources/views/
- [ ] Copy your Core files (Database, Auth, etc.)
- [ ] Copy your Services to app/Services/
- [ ] Copy your assets to assets/ or public/
- [ ] Update database config in config/database.php
- [ ] Replace all URL generation with url() helper
- [ ] Replace all asset paths with asset() helper
- [ ] Upload to server
- [ ] Test: visit index.php?url=dashboard

---

## 💡 Pro Tips

### Want Pretty URLs Later?

Once it's working, you can OPTIONALLY add .htaccess (Apache) or web.config (IIS) to remove the `index.php?url=` part:

**Apache (.htaccess):**
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

**IIS (web.config):**
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

But the framework works perfectly WITHOUT these!

---

## 🆘 Troubleshooting

### Issue: Page shows index.php source code
**Solution:** PHP is not installed or not configured on server

### Issue: Controllers not found
**Solution:** Make sure controllers extend `Controller` class

### Issue: Views not found
**Solution:** Check view path matches folder structure

### Issue: Database connection failed
**Solution:** Update config/database.php with correct credentials

### Issue: Assets (CSS/JS) not loading
**Solution:** Check assets path and use asset() helper

---

## 📞 Next Steps

1. Download the simple-mvc-framework
2. Start migrating your files
3. Test on your server
4. Let me know if you hit any issues!

This framework is MUCH simpler and will work on your IIS server immediately! 🚀
