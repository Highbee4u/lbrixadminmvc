<?php
trait AuditFields {
    /**
     * Generate next ID for tables without auto-increment
     */
    protected function getNextId($table, $primaryKey) {
        $result = $this->db->select("SELECT MAX($primaryKey) as max_id FROM $table");
        $maxId = $result[0]['max_id'] ?? 0;
        return $maxId + 1;
    }
    
    /**
     * Get audit fields for create operation
     */
    protected function getCreateAuditFields() {
        $userId = Auth::id();
        $companyId = Auth::companyId();
        
        return [
            'entryby' => $userId,
            'modifyby' => $userId,
            'entrydate' => date('Y-m-d H:i:s'),
            'companyid' => $companyId,
            'isdeleted' => 0
        ];
    }
    
    /**
     * Get audit fields with auto-generated ID for tables without auto-increment
     */
    protected function getCreateAuditFieldsWithId($table, $primaryKey) {
        $auditFields = $this->getCreateAuditFields();
        $auditFields[$primaryKey] = $this->getNextId($table, $primaryKey);
        return $auditFields;
    }
    
    /**
     * Get audit fields for update operation
     */
    protected function getUpdateAuditFields() {
        $userId = Auth::id();
        
        return [
            'modifyby' => $userId,
            'modifydate' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Get audit fields for soft delete operation
     */
    protected function getDeleteAuditFields() {
        $userId = Auth::id();
        
        return [
            'modifyby' => $userId,
            'modifydate' => date('Y-m-d H:i:s'),
            'isdeleted' => -1
        ];
    }
    
    /**
     * Merge data with create audit fields
     */
    protected function withCreateAudit($data) {
        return array_merge($this->getCreateAuditFields(), $data);
    }
    
    /**
     * Merge data with update audit fields
     */
    protected function withUpdateAudit($data) {
        return array_merge($this->getUpdateAuditFields(), $data);
    }
    
    /**
     * Merge data with delete audit fields
     */
    protected function withDeleteAudit($data = []) {
        return array_merge($this->getDeleteAuditFields(), $data);
    }
}
