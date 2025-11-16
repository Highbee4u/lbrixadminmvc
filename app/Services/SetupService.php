<?php
class SetupService {
    use AuditFields;
    
    private $db;
    private $companyId;
    const IS_DELETED = -1;
    const NOT_DELETED = 0;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->companyId = Auth::companyId();
    }

    // ==================== COUNTRIES ====================
    public function getCountries() {
        return $this->db->select("
            SELECT * FROM countries 
            WHERE isdeleted = ? 
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createCountry($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('countries', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create Country failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateCountry($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('countries', $data, 'countryid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update Country failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteCountry($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('countries', $data, 'countryid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete Country failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== STATES ====================
    public function getStates() {
        return $this->db->select("
            SELECT s.*, c.country as country
            FROM states s
            LEFT JOIN countries c ON s.countryid = c.countryid
            WHERE s.isdeleted = ?
            ORDER BY s.entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function getStatesByCountry($countryid) {
        return $this->db->select("
            SELECT stateid, state, countryid
            FROM states
            WHERE countryid = ? AND isdeleted = ?
            ORDER BY state ASC
        ", [$countryid, self::NOT_DELETED]);
    }

    public function createState($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('states', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create State failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateState($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('states', $data, 'stateid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update State failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteState($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('states', $data, 'stateid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete State failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== SUBLOCATIONS ====================
    public function getSublocations() {
        return $this->db->select("
            SELECT sl.*, s.state as state_name, c.country as country_name
            FROM sublocations sl
            LEFT JOIN states s ON sl.stateid = s.stateid
            LEFT JOIN countries c ON sl.countryid = c.countryid
            WHERE sl.isdeleted = ?
            ORDER BY sl.sublocation ASC
        ", [self::NOT_DELETED]);
    }

    public function createSublocation($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('sublocations', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create Sublocation failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateSublocation($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('sublocations', $data, 'sublocationid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update Sublocation failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteSublocation($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('sublocations', $data, 'sublocationid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete Sublocation failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== CURRENCY ====================
    public function getCurrencies() {
        return $this->db->select("
            SELECT * FROM currency
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createCurrency($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('currency', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create Currency failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateCurrency($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('currency', $data, 'currencyid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update Currency failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteCurrency($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('currency', $data, 'currencyid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete Currency failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== ITEM TYPES ====================
    public function getItemTypes() {
        return $this->db->select("
            SELECT * FROM itemtypes
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createItemType($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('itemtypes', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create ItemType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateItemType($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('itemtypes', $data, 'itemtypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update ItemType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteItemType($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('itemtypes', $data, 'itemtypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete ItemType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    public function getItemServiceTypes() {
        return $this->db->select("
            SELECT * FROM itemservicetypes
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createItemServiceType($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('itemservicetypes', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create ItemServiceType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateItemServiceType($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('itemservicetypes', $data, 'itemserviceid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update ItemServiceType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteItemServiceType($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('itemservicetypes', $data, 'itemserviceid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete ItemServiceType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    public function getItemProfileOptions() {
        return $this->db->select("
            SELECT ipo.*, it.title as itemtype_name
            FROM itemprofileoptions ipo
            LEFT JOIN itemtypes it ON ipo.itemtypeid = it.itemtypeid
            WHERE ipo.isdeleted = ?
            ORDER BY ipo.title ASC
        ", [self::NOT_DELETED]);
    }

    public function getItemProfileOptionById($id) {
        $result = $this->db->select("
            SELECT ipo.*, it.title as itemtype_name
            FROM itemprofileoptions ipo
            LEFT JOIN itemtypes it ON ipo.itemtypeid = it.itemtypeid
            WHERE ipo.itemprofileoptionid = ? AND ipo.isdeleted = ?
        ", [$id, self::NOT_DELETED]);
        return !empty($result) ? $result[0] : null;
    }

    public function createItemProfileOption($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('itemprofileoptions', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create ItemProfileOption failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateItemProfileOption($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('itemprofileoptions', $data, 'itemprofileoptionid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update ItemProfileOption failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteItemProfileOption($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('itemprofileoptions', $data, 'itemprofileoptionid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete ItemProfileOption failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== ITEM DOC TYPES ====================
    public function getItemDocTypes() {
        return $this->db->select("
            SELECT * FROM itemdoctypes
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createItemDocType($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('itemdoctypes', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create ItemDocType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateItemDocType($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('itemdoctypes', $data, 'itemdoctypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update ItemDocType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteItemDocType($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('itemdoctypes', $data, 'itemdoctypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete ItemDocType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== ITEM PIC TYPES ====================
    public function getItemPicTypes() {
        return $this->db->select("
            SELECT * FROM itempictypes
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createItemPicType($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('itempictypes', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create ItemPicType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateItemPicType($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('itempictypes', $data, 'itempictypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update ItemPicType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteItemPicType($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('itempictypes', $data, 'itempictypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete ItemPicType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== INSPECT PIC TYPES ====================
    public function getInspectPicTypes() {
        return $this->db->select("
            SELECT * FROM inspectionpictypes
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createInspectPicType($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('inspectionpictypes', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create InspectionPicType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateInspectPicType($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('inspectionpictypes', $data, 'itempictypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update InspectionPicType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteInspectPicType($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('inspectionpictypes', $data, 'itempictypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete InspectionPicType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== PAYMENT TERMS ====================
    public function getPaymentTerms() {
        return $this->db->select("
            SELECT * FROM payterms
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createPaymentTerm($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('payterms', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create PaymentTerm failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updatePaymentTerm($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('payterms', $data, 'paytermid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update PaymentTerm failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deletePaymentTerm($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('payterms', $data, 'paytermid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete PaymentTerm failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== INSPECTION DOC TYPES ====================
    public function getInspectionDocTypes() {
        return $this->db->select("
            SELECT * FROM inspectiondoctypes
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createInspectionDocType($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('inspectiondoctypes', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create InspectionDocType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateInspectionDocType($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('inspectiondoctypes', $data, 'itemdoctypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update InspectionDocType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteInspectionDocType($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('inspectiondoctypes', $data, 'itemdoctypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete InspectionDocType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== OWNERSHIP TYPES ====================
    public function getOwnershipTypes() {
        return $this->db->select("
            SELECT * FROM ownershiptypes
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createOwnershipType($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('ownershiptypes', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create OwnershipType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateOwnershipType($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('ownershiptypes', $data, 'ownershiptypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update OwnershipType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteOwnershipType($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('ownershiptypes', $data, 'ownershiptypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete OwnershipType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== PROJECT TYPES ====================
    public function getProjectTypes() {
        return $this->db->select("
            SELECT * FROM projecttypes
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createProjectType($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('projecttypes', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create ProjectType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateProjectType($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('projecttypes', $data, 'projecttypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update ProjectType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteProjectType($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('projecttypes', $data, 'projecttypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete ProjectType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== LIST TYPES ====================
    public function getListTypes() {
        return $this->db->select("
            SELECT * FROM listtype
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createListType($data) {
        try {
            // Generate the next ID manually since listtypeid is not auto-increment
            $maxId = $this->db->select("SELECT MAX(listtypeid) as maxid FROM listtype");
            $nextId = (!empty($maxId) && isset($maxId[0]['maxid'])) ? $maxId[0]['maxid'] + 1 : 1;
            $data['listtypeid'] = $nextId;
            
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('listtype', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create ListType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateListType($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('listtype', $data, 'listtypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update ListType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteListType($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('listtype', $data, 'listtypeid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete ListType failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== INVESTOR SETUP / INVEST OPTIONS ====================
    public function getInvestOptions() {
        return $this->db->select("
            SELECT * FROM investoptions
            WHERE isdeleted = ?
            ORDER BY entrydate DESC
        ", [self::NOT_DELETED]);
    }

    public function createInvestOption($data) {
        try {
            $data = $this->withCreateAudit($data);
            $id = $this->db->insert('investoptions', $data);
            return ['success' => true, 'message' => 'Successfully created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create InvestOption failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }

    public function updateInvestOption($id, $data) {
        try {
            $data = $this->withUpdateAudit($data);
            $this->db->update('investoptions', $data, 'investoptionid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully updated'];
        } catch (Exception $e) {
            Logger::error('Update InvestOption failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public function deleteInvestOption($id) {
        try {
            $data = $this->withDeleteAudit();
            $this->db->update('investoptions', $data, 'investoptionid = ?', [$id]);
            return ['success' => true, 'message' => 'Successfully deleted'];
        } catch (Exception $e) {
            Logger::error('Delete InvestOption failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Deletion failed'];
        }
    }

    // ==================== ITEM STATUSES ====================
    public function getItemStatuses() {
        return $this->db->select("
            SELECT * FROM itemstatus
            WHERE isdeleted = ? AND companyid = ?
            ORDER BY itemstatusid ASC
        ", [self::NOT_DELETED, $this->companyId]);
    }
}
