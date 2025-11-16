<?php
class BaseModel {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $hidden = [];

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function find($id) {
        return $this->db->selectOne("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id]);
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
        $data = $this->filterFillable($data);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $id = $this->db->insert($this->table, $data);
        return $this->find($id);
    }

    public function update($id, $data) {
        $data = $this->filterFillable($data);
        $data['updated_at'] = date('Y-m-d H:i:s');

        $result = $this->db->update($this->table, $data, "{$this->primaryKey} = ?", [$id]);
        return $result > 0 ? $this->find($id) : false;
    }

    public function delete($id) {
        return $this->db->delete($this->table, "{$this->primaryKey} = ?", [$id]);
    }

    public function count() {
        $result = $this->db->selectOne("SELECT COUNT(*) as count FROM {$this->table}");
        return $result['count'];
    }

    public function paginate($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM {$this->table} LIMIT ? OFFSET ?";
        return $this->db->select($sql, [$perPage, $offset]);
    }

    public function exists($id) {
        $result = $this->db->selectOne("SELECT COUNT(*) as count FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id]);
        return $result['count'] > 0;
    }

    protected function filterFillable($data) {
        if (empty($this->fillable)) {
            return $data;
        }

        return array_intersect_key($data, array_flip($this->fillable));
    }

    public function toArray() {
        $data = [];
        foreach ($this as $key => $value) {
            if (!in_array($key, $this->hidden) && $key !== 'db' && $key !== 'table' && $key !== 'primaryKey' && $key !== 'fillable' && $key !== 'hidden') {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name ?? null;
    }
}