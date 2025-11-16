<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Simple MVC') ?></title>
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1><?= e($title) ?></h1>
            <nav>
                <a href="<?= url() ?>">Home</a>
                <a href="<?= url('about') ?>">About</a>
                <a href="<?= url('dashboard') ?>">Dashboard</a>
            </nav>
        </header>

        <main>
            <div class="hero">
                <h2><?= e($message) ?></h2>
                <p>This MVC framework works on:</p>
                <ul>
                    <li>✓ Apache servers (with or without .htaccess)</li>
                    <li>✓ IIS servers (with or without web.config)</li>
                    <li>✓ Nginx servers</li>
                    <li>✓ Any shared hosting</li>
                </ul>
                
                <p>No URL rewriting configuration needed!</p>
                
                <div class="buttons">
                    <a href="<?= url('dashboard') ?>" class="btn btn-primary">Go to Dashboard</a>
                    <a href="<?= url('about') ?>" class="btn btn-secondary">Learn More</a>
                </div>
            </div>
        </main>

        <footer>
            <p>&copy; <?= date('Y') ?> Simple MVC Framework</p>
        </footer>
    </div>
</body>
</html>
