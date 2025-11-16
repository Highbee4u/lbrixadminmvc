<?php
abstract class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function find($id) {
        return $this->db->selectOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function findAll() {
        return $this->db->select("SELECT * FROM {$this->table}");
    }

    public function findWhere($column, $value) {
        return $this->db->select("SELECT * FROM {$this->table} WHERE {$column} = ?", [$value]);
    }

    public function findWhereMultiple($conditions) {
        $where = [];
        $params = [];

        foreach ($conditions as $column => $value) {
            $where[] = "{$column} = ?";
            $params[] = $value;
        }

        $whereString = implode(' AND ', $where);
        return $this->db->select("SELECT * FROM {$this->table} WHERE {$whereString}", $params);
    }

    public function create($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->update($this->table, $data, "id = ?", [$id]);
    }

    public function delete($id) {
        return $this->db->delete($this->table, "id = ?", [$id]);
    }

    public function count() {
        $result = $this->db->selectOne("SELECT COUNT(*) as count FROM {$this->table}");
        return $result['count'];
    }

    public function paginate($page = 1, $perPage = 15) {
        $currentPage = max(1, (int) ($_GET['page'] ?? $page));
        
        // Get total count
        $countResult = $this->db->selectOne("SELECT COUNT(*) as count FROM {$this->table}");
        $total = $countResult['count'] ?? 0;
        
        // Create pagination instance
        $pagination = new Pagination($total, $perPage, $currentPage);
        
        // Get data for current page
        $offset = $pagination->getOffset();
        $limit = $pagination->getLimit();
        $sql = "SELECT * FROM {$this->table} LIMIT {$limit} OFFSET {$offset}";
        $data = $this->db->select($sql);
        
        // Set data and return pagination
        $pagination->setData($data);
        return $pagination;
    }

    public function exists($id) {
        $result = $this->db->selectOne("SELECT COUNT(*) as count FROM {$this->table} WHERE id = ?", [$id]);
        return $result['count'] > 0;
    }
}
?>
