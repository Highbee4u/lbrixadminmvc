<?php
class AdminSetupService {
    use AuditFields;
    
    private $db;
    private $companyId;
    const IS_DELETED = -1;
    const NOT_DELETED = 0;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->companyId = Auth::companyId();
    }

    // Admin Roles
    public function getAdminRoles() {
        return $this->db->select("
            SELECT * FROM adminroles 
            WHERE isdeleted = ? 
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createAdminRole($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('adminroles', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create Admin Role failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateAdminRole($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('adminroles', $data, 'adminroleid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update Admin Role failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteAdminRole($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('adminroles', $data, 'adminroleid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete Admin Role failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // Services
    public function getServices() {
        return $this->db->select("
            SELECT * FROM services 
            WHERE isdeleted = ? 
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createService($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('services', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create services failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateService($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            // print_r(["data" => $data, "id" => $id]); exit();
            $this->db->update('services', $data, 'serviceid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update Service failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteService($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('services', $data, 'serviceid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete Service failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // Item Services
    public function getItemServices() {
        return $this->db->select("
            SELECT ist.*, 
                   s.title as service_name,
                   it.title as itemtype_name
            FROM itemservices ist
            LEFT JOIN services s ON ist.serviceid = s.serviceid
            LEFT JOIN itemtypes it ON ist.itemtypeid = it.itemtypeid
            WHERE ist.isdeleted = ?
            ORDER BY ist.entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createItemService($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('itemservices', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create Item Service failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateItemService($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('itemservices', $data, 'itemserviceid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update Item Service failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteItemService($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('itemservices', $data, 'itemserviceid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete Item Service failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // Inspection Status
    public function getInspectionStatuses() {
        return $this->db->select("
            SELECT * FROM inspectionstatus 
            WHERE isdeleted = ? 
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createInspectionStatus($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('inspectionstatus', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create Inspection Status failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateInspectionStatus($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            // print_r(["data" => $data, "id" => $id]); exit();
            $this->db->update('inspectionstatus', $data, 'inspectionstatusid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update Inspection Status failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteInspectionStatus($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('inspectionstatus', $data, 'inspectionstatusid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete Inspection Status failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // Investments
    public function getInvestments() {
        return $this->db->select("
            SELECT * FROM investments 
            WHERE isdeleted = ? 
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createInvestment($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('investments', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create Investment failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateInvestment($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('investments', $data, 'investmentid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update Investment failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteInvestment($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('investments', $data, 'investmentid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete Investment failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // Bid Types
    public function getBidTypes() {
        return $this->db->select("
            SELECT bt.*, 
                   s.title as service_name
            FROM bidtype bt
            LEFT JOIN services s ON bt.serviceid = s.serviceid
            WHERE bt.isdeleted = ?
            ORDER BY bt.entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createBidType($data) {
        try {
            // Generate next ID manually since bidtypeid doesn't have auto-increment
            $data = array_merge(
                $this->getCreateAuditFieldsWithId('bidtype', 'bidtypeid'),
                $data
            );
            $id = $this->db->insert('bidtype', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $data['bidtypeid']];
        } catch (Exception $e) {
            Logger::error('Create Bid Type failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateBidType($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('bidtype', $data, 'bidtypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update Bid Type failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteBidType($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('bidtype', $data, 'bidtypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete Bid Type failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // Helper methods
    public function getItemTypes() {
        return $this->db->select("
            SELECT * FROM itemtypes 
            WHERE isdeleted = ? 
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function getOptionLists() {
        return $this->db->select("
            SELECT * FROM optionlist 
            WHERE isdeleted = ? 
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }
}
