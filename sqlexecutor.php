<?php
/**
 * SQL Query Executor
 * Access via: sqlexecutor.php
 * 
 * Warning: Only use this for trusted queries!
 * This is a development tool only.
 */

require_once __DIR__ . '/config/database.php';

$result = null;
$error = null;
$query = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $query = trim($_POST['query']);
    
    if (empty($query)) {
        $error = "Please enter a query";
    } else {
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            
            // Check if it's a SELECT query
            if (stripos(trim($query), 'SELECT') === 0) {
                $stmt = $pdo->query($query);
                $result = $stmt->fetchAll();
                if (empty($result)) {
                    $result = "Query executed successfully. No rows returned.";
                }
            } else {
                // For INSERT, UPDATE, DELETE, CREATE, etc.
                $stmt = $pdo->query($query);
                $result = "Query executed successfully. Affected rows: " . $stmt->rowCount();
            }
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQL Query Executor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        .info {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            font-family: monospace;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
        }
        button {
            background: #2196F3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #1976D2;
        }
        .error {
            background: #ffebee;
            border: 1px solid #ef5350;
            color: #c62828;
            padding: 15px;
            border-radius: 3px;
            margin-top: 20px;
        }
        .success {
            background: #e8f5e9;
            border: 1px solid #66bb6a;
            color: #2e7d32;
            padding: 15px;
            border-radius: 3px;
            margin-top: 20px;
        }
        .result {
            margin-top: 20px;
            background: #fafafa;
            padding: 15px;
            border-radius: 3px;
            border: 1px solid #ddd;
        }
        .result pre {
            margin: 0;
            overflow-x: auto;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background: #f5f5f5;
            font-weight: bold;
        }
        .db-info {
            font-size: 12px;
            color: #666;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>SQL Query Executor</h1>
        
        <div class="info">
            <strong>Database:</strong> <?php echo htmlspecialchars(DB_NAME); ?> 
            | <strong>Host:</strong> <?php echo htmlspecialchars(DB_HOST); ?>
        </div>

        <form method="POST">
            <div class="form-group">
                <label for="query">SQL Query:</label>
                <textarea name="query" id="query" placeholder="Enter your SQL query here..."><?php echo htmlspecialchars($query); ?></textarea>
            </div>
            <button type="submit">Execute Query</button>
        </form>

        <?php if ($error): ?>
            <div class="error">
                <strong>Error:</strong><br>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($result && !$error): ?>
            <div class="result">
                <?php if (is_array($result)): ?>
                    <strong>Results:</strong> (<?php echo count($result); ?> rows)
                    <table>
                        <thead>
                            <tr>
                                <?php if (!empty($result)): ?>
                                    <?php foreach (array_keys(reset($result)) as $column): ?>
                                        <th><?php echo htmlspecialchars($column); ?></th>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row): ?>
                                <tr>
                                    <?php foreach ($row as $value): ?>
                                        <td><?php echo htmlspecialchars($value ?? 'NULL'); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="success">
                        <strong>Success:</strong><br>
                        <?php echo htmlspecialchars($result); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="db-info">
            <h3>Common Queries to Check for Missing Tables:</h3>
            <pre>-- Check if genders table exists
SELECT * FROM genders;

-- Check all tables in database
SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '<?php echo DB_NAME; ?>';

-- Check structure of users table
DESCRIBE users;

-- Count records in users
SELECT COUNT(*) FROM users;</pre>
        </div>
    </div>
</body>
</html>
