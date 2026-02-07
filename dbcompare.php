<?php
/**
 * Database Schema Comparison Tool
 * Access via: dbcompare.php
 * 
 * This shows you which tables exist locally vs on the server
 */

require_once __DIR__ . '/config/database.php';

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
    
    // Get all tables
    $stmt = $pdo->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . DB_NAME . "' ORDER BY TABLE_NAME");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Get genders table structure if it exists
    $gendersExists = in_array('genders', $tables);
    $gendersData = [];
    if ($gendersExists) {
        $stmt = $pdo->query("SELECT * FROM genders");
        $gendersData = $stmt->fetchAll();
    }
    
    // Get users table structure
    $usersStructure = [];
    $stmt = $pdo->query("DESCRIBE users");
    $usersStructure = $stmt->fetchAll();
    
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Common tables that should exist
$expectedTables = [
    'adminroles','bidtype','bitstatus','countries','currency','genders','inspectiondoctypes','inspectionpictypes','inspectionrequest','inspectionstatus','inspectiontask','inspectionteam','investments','investmentstatus','investoptions','investorsprofile','itembids','itembids_bkp_20201_01_20','itemdocs','itemdoctypes','iteminspdocs','iteminspections','iteminspnote','iteminsppics','itemlocations','itempics','itempictypes','itemprofileheaders','itemprofileoptions','itemprofiles','itemrequestprofiles','items','items_bkp','items_bkp','itemservices','itemservicetypes','itemsrequest','itemstatus','itemtypes','itemwishes','listtype','notifications','notificationsettings','optionlist','ownershiptypes','payterms','projecttypes','services','sessions','states','statuslist','subitem','sublocations','titletypes','users','users_backup20230810','users_bkp','userservices','usertypes'
];

$missingTables = array_diff($expectedTables, $tables);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Database Schema Comparison</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
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
        h2 {
            color: #666;
            border-bottom: 2px solid #2196F3;
            padding-bottom: 10px;
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #f5f5f5;
            font-weight: bold;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .exists {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .missing {
            background: #ffebee;
            color: #c62828;
            font-weight: bold;
        }
        .info {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            padding: 15px;
            border-radius: 3px;
            margin: 20px 0;
        }
        .warning {
            background: #fff3e0;
            border: 1px solid #ffb74d;
            padding: 15px;
            border-radius: 3px;
            margin: 20px 0;
        }
        .code {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 3px;
            font-family: monospace;
            margin: 10px 0;
            overflow-x: auto;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        .stat-box {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 3px;
            text-align: center;
        }
        .stat-box h3 {
            margin: 0;
            font-size: 24px;
            color: #2196F3;
        }
        .stat-box p {
            margin: 5px 0 0 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Database Schema Comparison</h1>
        
        <div class="info">
            <strong>Database:</strong> <?php echo htmlspecialchars(DB_NAME); ?><br>
            <strong>Host:</strong> <?php echo htmlspecialchars(DB_HOST); ?>
        </div>

        <div class="stats">
            <div class="stat-box">
                <h3><?php echo count($tables); ?></h3>
                <p>Tables Found</p>
            </div>
            <div class="stat-box">
                <h3><?php echo count($expectedTables); ?></h3>
                <p>Expected Tables</p>
            </div>
            <div class="stat-box">
                <h3><?php echo count($missingTables); ?></h3>
                <p>Missing Tables</p>
            </div>
        </div>

        <?php if (!empty($missingTables)): ?>
            <div class="warning">
                <strong>⚠ WARNING: Missing Tables Found!</strong><br>
                The following tables are missing from your server database:<br>
                <code><?php echo implode(', ', $missingTables); ?></code>
            </div>
        <?php endif; ?>

        <h2>Table Status</h2>
        <table>
            <thead>
                <tr>
                    <th>Table Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expectedTables as $table): ?>
                    <tr class="<?php echo in_array($table, $tables) ? 'exists' : 'missing'; ?>">
                        <td><?php echo $table; ?></td>
                        <td><?php echo in_array($table, $tables) ? '✓ Exists' : '✗ MISSING'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Users Table Structure</h2>
        <table>
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Null</th>
                    <th>Key</th>
                    <th>Default</th>
                    <th>Extra</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usersStructure as $field): ?>
                    <tr>
                        <td><code><?php echo $field['Field']; ?></code></td>
                        <td><?php echo $field['Type']; ?></td>
                        <td><?php echo $field['Null']; ?></td>
                        <td><?php echo $field['Key']; ?></td>
                        <td><?php echo $field['Default'] ?? '—'; ?></td>
                        <td><?php echo $field['Extra']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($gendersExists): ?>
            <h2>Genders Table Data</h2>
            <table>
                <thead>
                    <tr>
                        <?php foreach (array_keys(reset($gendersData) ?? []) as $col): ?>
                            <th><?php echo $col; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gendersData as $row): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="warning">
                <strong>⚠ GENDERS TABLE MISSING!</strong><br>
                This is causing your user pages to fail. Use the SQL Executor to create this table.<br><br>
                <strong>Suggested query:</strong>
                <div class="code">CREATE TABLE genders (
  genderid INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(50) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);</div>
                
                <strong>Then insert sample data:</strong>
                <div class="code">INSERT INTO genders (title) VALUES
('Male'),
('Female'),
('Other');</div>
            </div>
        <?php endif; ?>

        <div class="info" style="margin-top: 30px;">
            <strong>Next Steps:</strong>
            <ol>
                <li>Go to <a href="sqlexecutor.php">SQL Executor</a></li>
                <li>Create the missing tables using the queries provided above</li>
                <li>Come back to this page to verify all tables exist</li>
            </ol>
        </div>
    </div>
</body>
</html>
