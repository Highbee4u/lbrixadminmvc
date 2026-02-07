<?php
/**
 * MVC Routing Diagnostic Script
 * Upload this to your web root and access it via: yourdomain.com/debug.php
 */

echo "<h1>MVC Routing Diagnostics</h1>";
echo "<hr>";

// 1. Check if mod_rewrite is enabled
echo "<h2>1. mod_rewrite Status</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<span style='color:green'>✓ mod_rewrite is ENABLED</span><br>";
    } else {
        echo "<span style='color:red'>✗ mod_rewrite is NOT enabled</span><br>";
        echo "<strong>Solution:</strong> Contact your hosting provider to enable mod_rewrite<br>";
    }
} else {
    echo "<span style='color:orange'>⚠ Cannot detect (apache_get_modules not available)</span><br>";
    echo "This is common on shared hosting. Check your hosting control panel.<br>";
}

echo "<hr>";

// 2. Check .htaccess file
echo "<h2>2. .htaccess File Check</h2>";
if (file_exists('.htaccess')) {
    echo "<span style='color:green'>✓ .htaccess file EXISTS</span><br>";
    echo "<strong>Content:</strong><br>";
    echo "<pre style='background:#f4f4f4;padding:10px;border:1px solid #ddd;'>";
    echo htmlspecialchars(file_get_contents('.htaccess'));
    echo "</pre>";
} else {
    echo "<span style='color:red'>✗ .htaccess file NOT FOUND</span><br>";
    echo "<strong>Solution:</strong> Create .htaccess file in the root directory<br>";
}

echo "<hr>";

// 3. Check URL parameters
echo "<h2>3. URL Request Information</h2>";
echo "<strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Not set') . "<br>";
echo "<strong>QUERY_STRING:</strong> " . ($_SERVER['QUERY_STRING'] ?? 'Not set') . "<br>";
echo "<strong>GET Parameters:</strong><br>";
echo "<pre style='background:#f4f4f4;padding:10px;border:1px solid #ddd;'>";
print_r($_GET);
echo "</pre>";

echo "<strong>SCRIPT_NAME:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'Not set') . "<br>";
echo "<strong>PHP_SELF:</strong> " . ($_SERVER['PHP_SELF'] ?? 'Not set') . "<br>";

echo "<hr>";

// 4. Check directory structure
echo "<h2>4. Directory Structure Check</h2>";
$requiredDirs = ['app', 'config', 'resources', 'vendor', 'storage'];
foreach ($requiredDirs as $dir) {
    if (is_dir($dir)) {
        echo "<span style='color:green'>✓ /$dir/ directory exists</span><br>";
    } else {
        echo "<span style='color:red'>✗ /$dir/ directory NOT FOUND</span><br>";
    }
}

echo "<hr>";

// 5. Check index.php
echo "<h2>5. index.php Check</h2>";
if (file_exists('index.php')) {
    echo "<span style='color:green'>✓ index.php EXISTS</span><br>";
    echo "<strong>First 50 lines:</strong><br>";
    $lines = file('index.php');
    echo "<pre style='background:#f4f4f4;padding:10px;border:1px solid #ddd;max-height:300px;overflow:auto;'>";
    echo htmlspecialchars(implode('', array_slice($lines, 0, 50)));
    echo "</pre>";
} else {
    echo "<span style='color:red'>✗ index.php NOT FOUND</span><br>";
}

echo "<hr>";

// 6. Check critical files
echo "<h2>6. Critical Files Check</h2>";
$criticalFiles = [
    'app/Core/App.php',
    'app/Core/Router.php',
    'app/Core/config.php',
    'vendor/autoload.php'
];

foreach ($criticalFiles as $file) {
    if (file_exists($file)) {
        echo "<span style='color:green'>✓ $file exists</span><br>";
    } else {
        echo "<span style='color:red'>✗ $file NOT FOUND</span><br>";
    }
}

echo "<hr>";

// 7. PHP Version
echo "<h2>7. PHP Environment</h2>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";
echo "<strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "<br>";
echo "<strong>Script Filename:</strong> " . (__FILE__) . "<br>";

echo "<hr>";

// 8. Test rewrite
echo "<h2>8. Rewrite Test</h2>";
echo "Try accessing: <a href='" . ($_SERVER['REQUEST_SCHEME'] ?? 'http') . "://" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "/dashboard'>yourdomain.com/dashboard</a><br>";
echo "If you see this debug page when clicking the link above, .htaccess is NOT working correctly.<br>";
echo "If you get 404, the rewrite is partially working but routing is broken.<br>";

echo "<hr>";
echo "<p><strong>Instructions:</strong></p>";
echo "<ol>";
echo "<li>Save the results from this page</li>";
echo "<li>Delete this debug.php file after testing (security risk to leave it)</li>";
echo "<li>Share the results to get specific help</li>";
echo "</ol>";
?>