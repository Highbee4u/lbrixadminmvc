<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            $host = Config::get('database.host', 'localhost');
            $dbname = Config::get('database.database', 'lbrixtest');
            $username = Config::get('database.username', 'root');
            $password = Config::get('database.password', '');

            // $host = Config::get('database.host', 'localhost');
            // $dbname = Config::get('database.database', 'oyesoft_lbrixdata');
            // $username = Config::get('database.username', 'root');
            // $password = Config::get('database.password', '');
            
            $this->connection = new PDO(
                "mysql:host={$host};dbname={$dbname}",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function select($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function selectOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, $data);

        return $this->connection->lastInsertId();
    }

    public function update($table, $data, $where, $whereParams = []) {
        $set = [];
        $params = [];
        $i = 0;
        
        foreach ($data as $key => $value) {
            $set[] = "{$key} = ?";
            $params[] = $value;
        }
        $setString = implode(', ', $set);

        // Handle where clause - support both string and associative array
        if (is_array($where)) {
            $whereConditions = [];
            foreach ($where as $key => $value) {
                $whereConditions[] = "{$key} = ?";
                $whereParams[] = $value;
            }
            $whereString = implode(' AND ', $whereConditions);
        } else {
            $whereString = $where;
        }

        $sql = "UPDATE {$table} SET {$setString} WHERE {$whereString}";
        $params = array_merge($params, $whereParams);

        return $this->query($sql, $params)->rowCount();
    }

    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        return $this->query($sql, $params)->rowCount();
    }
}
?>
