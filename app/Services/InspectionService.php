<?php
class InspectionService {
    use AuditFields;
    
    private $db;
    private $companyId;
    const IS_DELETED = -1;
    const NOT_DELETED = 0;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->companyId = Auth::companyId();
    }

    // ==================== INSPECTION LEADS ====================
    public function getInspectionLeads() {
        return $this->db->select("
            SELECT u.* 
            FROM users u
            WHERE u.isdeleted = ? 
            AND u.usertypeid = 3
            AND u.userid > 100
            AND u.userid IN (
                SELECT userid FROM userservices 
                WHERE serviceid = 6 AND isdeleted != ?
            )
            ORDER BY u.entrydate DESC
        ", [self::NOT_DELETED, self::IS_DELETED]);
    }

    // ==================== ITEM STATUSES ====================
    public function getItemStatuses() {
        return $this->db->select("
            SELECT * FROM itemstatus
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    // ==================== INSPECTION STATUSES ====================
    public function getInspectionStatuses() {
        return $this->db->select("
            SELECT * FROM inspectionstatus
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    // ==================== ITEMS ====================
    public function getItems() {
        return $this->db->select("
            SELECT * FROM items
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    // ==================== INSPECTION TASKS ====================
    public function getInspectionTasksList($filters = [], $page = 1, $perPage = 10) {
        $conditions = ["it.isdeleted = ?"];
        $params = [self::NOT_DELETED];

        // Apply filters
        if (!empty($filters['startdate'])) {
            $conditions[] = "DATE(it.startdate) = ?";
            $params[] = $filters['startdate'];
        }

        if (!empty($filters['status'])) {
            $conditions[] = "it.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['itemid'])) {
            $conditions[] = "it.itemid = ?";
            $params[] = $filters['itemid'];
        }

        if (!empty($filters['entrydate'])) {
            $conditions[] = "DATE(it.entrydate) = ?";
            $params[] = $filters['entrydate'];
        }

        $whereClause = implode(' AND ', $conditions);

        // Get total count
        $countSql = "
            SELECT COUNT(*) as total
            FROM inspectiontask it
            WHERE {$whereClause}
        ";
        $countResult = $this->db->select($countSql, $params);
        $total = $countResult[0]['total'] ?? 0;

        // Get paginated data
        $offset = ($page - 1) * $perPage;
        $sql = "
            SELECT it.*, 
                   ins.title as inspection_status_name,
                   i.title as item_title,
                   i.itemid,
                   u.firstname as lead_firstname,
                   u.middlename as lead_lastname
            FROM inspectiontask it
            LEFT JOIN inspectionstatus ins ON it.status = ins.inspectionstatusid
            LEFT JOIN items i ON it.itemid = i.itemid
            LEFT JOIN users u ON it.inspectionlead = u.userid
            WHERE {$whereClause}
            ORDER BY it.entrydate DESC
            LIMIT ? OFFSET ?
        ";
        
        $params[] = $perPage;
        $params[] = $offset;
        
        $data = $this->db->select($sql, $params);

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage)
        ];
    }

    public function createInspectionTask($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('inspectiontask', $data);
            return ['success' => true, 'message' => 'Inspection task created successfully', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create Inspection Task failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateInspectionTask($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('inspectiontask', $data, 'inspectiontaskid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update Inspection Task failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function getInspectionTaskById($id) {
        $result = $this->db->select("
            SELECT it.*, 
                   i.title as item_title,
                   i.description as item_description,
                   i.address as item_address,
                   i.price as item_price,
                   i.itemstatusid as item_itemstatusid,
                   ist.title as item_status_title
            FROM inspectiontask it
            LEFT JOIN items i ON it.itemid = i.itemid
            LEFT JOIN itemstatus ist ON i.itemstatusid = ist.itemstatusid
            WHERE it.inspectiontaskid = ? AND it.isdeleted = ?
        ", [$id, self::NOT_DELETED]);

        return !empty($result) ? $result[0] : null;
    }

    public function deleteInspectionTask($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('inspectiontask', $data, 'inspectiontaskid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete Inspection Task failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== INSPECTION TASK TEAM ====================
    public function getInspectionTaskTeam($inspectionTaskId) {
        return $this->db->select("
            SELECT itt.*, 
                   u.firstname,
                   u.middlename,
                   u.email
            FROM inspectionteam itt
            LEFT JOIN users u ON itt.userid = u.userid
            WHERE itt.inspectiontaskid = ? AND itt.isdeleted = ?
            ORDER BY itt.entrydate DESC
        ", [$inspectionTaskId, self::NOT_DELETED]);
    }

    public function createInspectionTaskTeam($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('inspectionteam', $data);
            return ['success' => true, 'message' => 'Team member added successfully', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Add Team Member failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Addition failed'];
        }
    }

    public function updateInspectionTaskTeam($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('inspectionteam', $data, 'inspectionteamid = ?', [$id]);
            return ['success' => true, 'message' => 'Team member updated successfully'];
        } catch (Exception $e) {
            Logger::error('Update Team Member failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteInspectionTaskTeam($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('inspectionteam', $data, 'inspectionteamid = ?', [$id]);
            return ['success' => true, 'message' => 'Team member removed successfully'];
        } catch (Exception $e) {
            Logger::error('Remove Team Member failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Removal failed'];
        }
    }

    // ==================== ASSIGN INSPECTION TASK ====================
    public function assignInspectionTask($data) {
        try {
            // Get the inspection task to find the itemid
            $task = $this->getInspectionTaskById($data['inspectiontaskid']);
            
            if (!$task) {
                return ['success' => false, 'message' => 'Inspection task not found'];
            }

            // Update the item status
            $updateData = [
                'itemstatusid' => $data['itemstatusid']
            ];
            $updateData = $this->withUpdateAudit($updateData);
            
            $this->db->update('items', $updateData, 'itemid = ?', [$task['itemid']]);
            
            return ['success' => true, 'message' => 'Task assigned successfully'];
        } catch (Exception $e) {
            Logger::error('Assign Inspection Task failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Assignment failed'];
        }
    }

    // ==================== INSPECTION REQUESTS ====================
    public function getInspectionRequests($page = 1, $perPage = 10) {
        // Get total count
        $countSql = "
            SELECT COUNT(*) as total
            FROM inspectionrequest
            WHERE isdeleted = ?
        ";
        $countResult = $this->db->select($countSql, [self::NOT_DELETED]);
        $total = $countResult[0]['total'] ?? 0;

        // Get paginated data
        $offset = ($page - 1) * $perPage;
        $sql = "
            SELECT ir.*,
                   i.title as item_title,
                   ins.title as status_name,
                   u1.surname as requested_by_surname,
                   u1.firstname as requested_by_firstname,
                   u2.surname as attorney_surname,
                   u2.firstname as attorney_firstname,
                   bt.options as bid_type_name
            FROM inspectionrequest ir
            LEFT JOIN items i ON ir.itemid = i.itemid
            LEFT JOIN inspectionstatus ins ON ir.status = ins.inspectionstatusid
            LEFT JOIN users u1 ON ir.inspecteeid = u1.userid
            LEFT JOIN users u2 ON ir.attorneyid = u2.userid
            LEFT JOIN bidtype bt ON ir.bidtypeid = bt.bidtypeid
            WHERE ir.isdeleted = ?
            ORDER BY ir.entrydate DESC
            LIMIT ? OFFSET ?
        ";
        
        $data = $this->db->select($sql, [self::NOT_DELETED, $perPage, $offset]);

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage)
        ];
    }

    public function getBidTypes() {
        return $this->db->select("
            SELECT * FROM bidtype
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function getUsers() {
        return $this->db->select("
            SELECT * FROM users
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createInspectionRequest($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('inspectionrequest', $data);
            return ['success' => true, 'message' => 'Inspection request created successfully', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create Inspection Request failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function getInspectionRequestById($id) {
        $result = $this->db->select("
            SELECT ir.*,
                   i.title as item_title,
                   ins.title as status_name
            FROM inspectionrequest ir
            LEFT JOIN items i ON ir.itemid = i.itemid
            LEFT JOIN inspectionstatus ins ON ir.status = ins.inspectionstatusid
            WHERE ir.inspectionrequestid = ? AND ir.isdeleted = ?
        ", [$id, self::NOT_DELETED]);

        return !empty($result) ? $result[0] : null;
    }

    public function updateInspectionRequest($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('inspectionrequest', $data, 'inspectionrequestid = ?', [$id]);
            return ['success' => true, 'message' => 'Inspection request updated successfully'];
        } catch (Exception $e) {
            Logger::error('Update Inspection Request failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteInspectionRequest($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('inspectionrequest', $data, 'inspectionrequestid = ?', [$id]);
            return ['success' => true, 'message' => 'Inspection request deleted successfully'];
        } catch (Exception $e) {
            Logger::error('Delete Inspection Request failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }
}
