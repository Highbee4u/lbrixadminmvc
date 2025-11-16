<?php
class ListingService {
    use AuditFields;

    private $db;
    private $companyId;
    const IS_DELETED = -1;
    const NOT_DELETED = 0;
    const REJECT_STATUS = 5;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->companyId = Auth::companyId();
    }

    // ============ Helpers ============
    private function paginate($baseSql, $countSql, $params, $page = 1, $perPage = 15) {
        $offset = ($page - 1) * $perPage;
        $data = $this->db->select($baseSql . " LIMIT ? OFFSET ?", array_merge($params, [$perPage, $offset]));
        $count = $this->db->select($countSql, $params);
        $total = $count[0]['total'] ?? 0;
        return [
            'data' => $data,
            'total' => (int)$total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => (int)ceil($total / $perPage)
        ];
    }

    private function whereFilters(&$conditions, &$params, $filters) {
        if (!empty($filters['inspection_status'])) {
            $conditions[] = 'i.inspectionstatusid = ?';
            $params[] = $filters['inspection_status'];
        }
        if (!empty($filters['itemtype'])) {
            $conditions[] = 'i.itemtypeid = ?';
            $params[] = $filters['itemtype'];
        }
        if (!empty($filters['entry_date'])) {
            $conditions[] = 'DATE(i.entrydate) = ?';
            $params[] = $filters['entry_date'];
        }
    }

    // ============ Lists ============
    public function getAllPendingProperties($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid <= 1',
            'COALESCE(i.inspectionstatusid,0) = 0'
        ];
        $params = [self::NOT_DELETED, 2, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getAllAwaitingInspections($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid IN (2,3)',
            'COALESCE(i.inspectionstatusid,0) IN (0,3)'
        ];
        $params = [self::NOT_DELETED, 2, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getAllInspectionInProgress($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid IN (1,2,3)',
            'i.inspectionstatusid = 1'
        ];
        $params = [self::NOT_DELETED, 2, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getAllInspectionConcluded($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid IN (2,3)',
            'i.inspectionstatusid = 2'
        ];
        $params = [self::NOT_DELETED, 2, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getAllInspectionRejected($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid = ?','i.inspectionstatusid = ?'
        ];
        $params = [self::NOT_DELETED, 2, $this->companyId, self::REJECT_STATUS, self::REJECT_STATUS];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getAllAwaitingListings($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid = 9'
        ];
        $params = [self::NOT_DELETED, 2, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getAllListedProperties($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid = 10'
        ];
        $params = [self::NOT_DELETED, 2, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getApprovedInspections($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid = 4','i.inspectionstatusid = 4'
        ];
        $params = [self::NOT_DELETED, 2, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getAllClosedProperties($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid = 20'
        ];
        $params = [self::NOT_DELETED, 2, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    // ============ Dashboard ============
    public function dashboardGetStats() {
        return [
            'pendingProperties' => $this->stat("i.itemstatusid <= 1 AND COALESCE(i.inspectionstatusid,0) IN (0,1)"),
            'awaitingProperties' => $this->stat("i.itemstatusid IN (2,3) AND COALESCE(i.inspectionstatusid,0) IN (0,3)"),
            'concludedProperties' => $this->stat("i.itemstatusid IN (2,3) AND i.inspectionstatusid = 2"),
            'rejectedProperties' => $this->stat("i.itemstatusid = 5 AND i.inspectionstatusid = 5"),
            'approvedProperties' => $this->stat("i.itemstatusid = 4 AND i.inspectionstatusid = 4"),
            'awaitingListingProperties' => $this->stat("i.itemstatusid = 9"),
            'listedProperties' => $this->stat("i.itemstatusid = 10"),
            'closedProperties' => $this->stat("i.itemstatusid = 20"),
        ];
    }

    private function stat($whereClause) {
        $sql = "SELECT COUNT(i.itemid) as totalnumber, COALESCE(SUM(i.price),0) as totalamount FROM items i WHERE i.isdeleted = ? AND i.companyid = ? AND i.servicetypeid = ? AND $whereClause";
        $rows = $this->db->select($sql, [self::NOT_DELETED, $this->companyId, 2]);
        return $rows[0] ?? ['totalnumber' => 0, 'totalamount' => 0];
    }

    // ============ CRUD helpers ============
    public function getPropertyById($id) {
        $rows = $this->db->select("SELECT * FROM items WHERE itemid = ? AND companyid = ? AND isdeleted = ?", [(int)$id, $this->companyId, self::NOT_DELETED]);
        return $rows[0] ?? null;
    }

    public function updateProperty($id, $data) {
        try {
            // Validate required fields
            $errors = [];
            if (empty($data['title'])) {
                $errors[] = 'Title is required';
            }
            if (empty($data['itemtypeid'])) {
                $errors[] = 'Property Type is required';
            }
            if (empty($data['address'])) {
                $errors[] = 'Address is required';
            }
            
            if (!empty($errors)) {
                return ['success' => false, 'message' => implode(', ', $errors)];
            }
            
            $allowed = ['title','itemtypeid','description','address','price','priceunit','ownershiptypeid','ownershiptypetitle','inspectionstatusid','sellerid','attorneyid','itemstatusid'];
            $payload = [];
            foreach ($allowed as $k) {
                if (array_key_exists($k, $data)) { 
                    // Convert empty strings to NULL for integer fields that are optional
                    if (in_array($k, ['ownershiptypeid', 'sellerid', 'attorneyid', 'inspectionstatusid', 'itemstatusid']) && $data[$k] === '') {
                        $payload[$k] = null;
                    } else {
                        $payload[$k] = $data[$k];
                    }
                }
            }
            if (empty($payload)) { return ['success' => false, 'message' => 'Nothing to update']; }
            $payload = $this->withUpdateAudit($payload);
            $this->db->update('items', $payload, 'itemid = ? AND companyid = ?', [(int)$id, $this->companyId]);
            return ['success' => true, 'message' => 'Property updated successfully'];
        } catch (Exception $e) {
            Logger::error('Update Property failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Update failed: ' . $e->getMessage()];
        }
    }

    public function deleteProperty($id) {
        try {
            $payload = $this->withDeleteAudit();
            $this->db->update('items', $payload, 'itemid = ? AND companyid = ?', [(int)$id, $this->companyId]);
            return ['success' => true];
        } catch (Exception $e) {
            Logger::error('Delete Property failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Delete failed'];
        }
    }

    public function rejectProperty($id) {
        try {
            $payload = $this->withUpdateAudit(['itemstatusid' => self::REJECT_STATUS, 'inspectionstatusid' => self::REJECT_STATUS]);
            $this->db->update('items', $payload, 'itemid = ? AND companyid = ?', [(int)$id, $this->companyId]);
            return ['success' => true];
        } catch (Exception $e) {
            Logger::error('Reject Property failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Reject failed'];
        }
    }

    public function approveProperty($id) {
        try {
            // Set itemstatusid=4 and inspectionstatusid=4 (approved)
            $payload = $this->withUpdateAudit(['itemstatusid' => 4, 'inspectionstatusid' => 4]);
            $this->db->update('items', $payload, 'itemid = ? AND companyid = ?', [(int)$id, $this->companyId]);
            return ['success' => true, 'message' => 'Property approved successfully'];
        } catch (Exception $e) {
            Logger::error('Approve Property failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Approve failed'];
        }
    }

    public function reinspectProperty($id) {
        try {
            // Set itemstatusid=3 and inspectionstatusid=3 (send back for reinspection)
            $payload = $this->withUpdateAudit(['itemstatusid' => 3, 'inspectionstatusid' => 3]);
            $this->db->update('items', $payload, 'itemid = ? AND companyid = ?', [(int)$id, $this->companyId]);
            return ['success' => true, 'message' => 'Property marked for reinspection successfully'];
        } catch (Exception $e) {
            Logger::error('Reinspect Property failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Reinspect failed'];
        }
    }

    // List property - mark as ready for listing (itemstatusid = 10)
    public function listProperty($id) {
        try {
            $payload = ['itemstatusid' => 10];
            $this->db->update('items', $payload, 'itemid = ? AND companyid = ?', [(int)$id, $this->companyId]);
            
            Logger::info("Property listed successfully: itemid=$id");
            return ['success' => true, 'message' => 'Property listed successfully'];
        } catch (Exception $e) {
            Logger::error('List Property failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'List property failed'];
        }
    }

    // Keep for listing - mark for future listing (itemstatusid = 9)
    public function keepForListing($id) {
        try {
            $payload = ['itemstatusid' => 9];
            $this->db->update('items', $payload, 'itemid = ? AND companyid = ?', [(int)$id, $this->companyId]);
            
            Logger::info("Property kept for listing: itemid=$id");
            return ['success' => true, 'message' => 'Property kept for listing successfully'];
        } catch (Exception $e) {
            Logger::error('Keep for listing failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Keep for listing failed'];
        }
    }

    // Close offer - mark offer as closed (itemstatusid = 20)
    public function closeOffer($id) {
        try {
            $payload = ['itemstatusid' => 20];
            $this->db->update('items', $payload, 'itemid = ? AND companyid = ?', [(int)$id, $this->companyId]);
            
            Logger::info("Offer closed successfully: itemid=$id");
            return ['success' => true, 'message' => 'Offer closed successfully'];
        } catch (Exception $e) {
            Logger::error('Close offer failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Close offer failed'];
        }
    }

    // Delist property - remove from listing (itemstatusid = 9)
    public function delistProperty($id) {
        try {
            $payload = ['itemstatusid' => 9];
            $this->db->update('items', $payload, 'itemid = ? AND companyid = ?', [(int)$id, $this->companyId]);
            
            Logger::info("Property de-listed successfully: itemid=$id");
            return ['success' => true, 'message' => 'Property de-listed successfully'];
        } catch (Exception $e) {
            Logger::error('Delist property failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Delist failed'];
        }
    }

    public function dashboardGetRecentPending($servicetypeid = 2, $itemstatusCond = 'COALESCE(i.itemstatusid,0) IN (0,1)', $limit = 4) {
        $sql = "SELECT i.*, 
            (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
            (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
            (SELECT it.startdate FROM inspectiontask it WHERE it.itemid = i.itemid ORDER BY it.inspectiontaskid DESC LIMIT 1) as inspectionstartdate,
            (SELECT TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) FROM inspectiontask it1 JOIN users u ON it1.inspectionlead=u.userid WHERE it1.itemid = i.itemid ORDER BY it1.inspectiontaskid DESC LIMIT 1) as inspectionlead,
            b.options as bidtype
            FROM items i
            LEFT JOIN bidtype b ON b.bidtypeid = i.bidtypeid AND b.serviceid = i.servicetypeid
            WHERE i.isdeleted = ? AND i.companyid = ? AND i.servicetypeid = ? AND $itemstatusCond
            ORDER BY i.entrydate DESC LIMIT ?";
        return $this->db->select($sql, [self::NOT_DELETED, $this->companyId, $servicetypeid, $limit]);
    }

    public function dashboardGetRecentAwaiting($servicetypeid = 2, $itemstatusCond = 'COALESCE(i.itemstatusid,0) IN (0,1)', $inspstatusCond = 'COALESCE(i.inspectionstatusid,0) IN (0,3)', $limit = 4) {
        $sql = "SELECT i.*, 
            (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
            (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
            (SELECT it.startdate FROM inspectiontask it WHERE it.itemid = i.itemid ORDER BY it.inspectiontaskid DESC LIMIT 1) as inspectionstartdate,
            (SELECT TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) FROM inspectiontask it1 JOIN users u ON it1.inspectionlead=u.userid WHERE it1.itemid = i.itemid ORDER BY it1.inspectiontaskid DESC LIMIT 1) as inspectionlead,
            b.options as bidtype
            FROM items i
            LEFT JOIN bidtype b ON b.bidtypeid = i.bidtypeid AND b.serviceid = i.servicetypeid
            WHERE i.isdeleted = ? AND i.companyid = ? AND i.servicetypeid = ? AND $itemstatusCond AND $inspstatusCond
            ORDER BY i.entrydate DESC LIMIT ?";
        return $this->db->select($sql, [self::NOT_DELETED, $this->companyId, $servicetypeid, $limit]);
    }

    public function dashboardGetRecentOffers($servicetypeid = 2, $itemstatusCond = 'i.itemstatusid = 10', $limit = 4) {
        $sql = "SELECT i.*, 
            (SELECT COUNT(*) FROM itembids ib WHERE ib.itemid = i.itemid AND ib.isdeleted != ?) as bidcount,
            (SELECT AVG(ib2.proposedamount) FROM itembids ib2 WHERE ib2.itemid = i.itemid AND ib2.isdeleted != ?) as averageoffer,
            (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
            (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
            (SELECT b.options FROM bidtype b WHERE b.bidtypeid = i.bidtypeid LIMIT 1) as bidtype
            FROM items i
            WHERE i.isdeleted = ? AND i.companyid = ? AND i.servicetypeid = ? AND $itemstatusCond
            GROUP BY i.itemid
            ORDER BY i.entrydate DESC LIMIT ?";
        return $this->db->select($sql, [self::IS_DELETED, self::IS_DELETED, self::NOT_DELETED, $this->companyId, $servicetypeid, $limit]);
    }

    // ============ Related lists for a single item ============
    public function getItemProfiles($itemId) {
        $sql = "SELECT itemprofileid, profileoptionid, profileoptiontitle, profilevalue, basevalue, showuser, entrydate
                FROM itemprofiles WHERE isdeleted = ? AND companyid = ? AND itemid = ? ORDER BY entrydate DESC";
        return $this->db->select($sql, [self::NOT_DELETED, $this->companyId, (int)$itemId]);
    }

    public function getItemDocs($itemId) {
        $sql = "SELECT itemdocid, itemdoctypeid, itemdoctitle, docurl, docstatus, entrydate
                FROM itemdocs WHERE isdeleted = ? AND companyid = ? AND itemid = ? ORDER BY entrydate DESC";
        $docs = $this->db->select($sql, [self::NOT_DELETED, $this->companyId, (int)$itemId]);
        
        // Build full URL for documents
        foreach ($docs as &$doc) {
            if (!empty($doc['docurl'])) {
                // If docurl doesn't start with http or /, prepend /documents/
                if (strpos($doc['docurl'], 'http') !== 0 && strpos($doc['docurl'], '/') !== 0) {
                    $doc['docurl'] = '/documents/' . $doc['docurl'];
                }
            }
        }
        
        return $docs;
    }

    public function getItemPics($itemId) {
        $sql = "SELECT itempicid, pictitle, picurl, picstatus, entrydate
                FROM itempics WHERE isdeleted = ? AND companyid = ? AND itemid = ? ORDER BY entrydate DESC";
        $pics = $this->db->select($sql, [self::NOT_DELETED, $this->companyId, (int)$itemId]);
        
        // Build full URL for pictures
        foreach ($pics as &$pic) {
            if (!empty($pic['picurl'])) {
                // If picurl doesn't start with http or /, prepend /pictures/
                if (strpos($pic['picurl'], 'http') !== 0 && strpos($pic['picurl'], '/') !== 0) {
                    $pic['picurl'] = '/pictures/' . $pic['picurl'];
                }
            }
        }
        
        return $pics;
    }

    public function getSubItems($itemId) {
        $sql = "SELECT subitemid, floortitle, roomcount, roomlabels, roomsizes, roomprices, entrydate
                FROM subitem WHERE isdeleted = ? AND companyid = ? AND itemid = ? ORDER BY entrydate DESC";
        return $this->db->select($sql, [self::NOT_DELETED, $this->companyId, (int)$itemId]);
    }

    public function createProperty($data) {
        try {
            // Prepare payload with safe defaults for NOT NULL columns
            $payload = [
                'title' => $data['title'] ?? '',
                'displaypics' => $data['displaypics'] ?? null,
                'servicetypeid' => $data['servicetypeid'] ?? 2, // 2 = Properties
                'bidtypeid' => $data['bidtypeid'] ?? 0,
                'itemtypeid' => $data['itemtypeid'] ?? null,
                'ownershiptypeid' => $data['ownershiptypeid'] ?? null,
                'ownershiptypetitle' => $data['ownershiptypetitle'] ?? '',
                'itemtypetitle' => $data['itemtypetitle'] ?? '',
                'description' => $data['description'] ?? '',
                'address' => $data['address'] ?? '',
                'countryid' => $data['countryid'] ?? 0,
                'stateid' => $data['stateid'] ?? 0,
                'sublocationid' => $data['sublocationid'] ?? null,
                'area' => $data['area'] ?? '',
                'price' => $data['price'] ?? 0,
                'minprice' => $data['minprice'] ?? 0,
                'maxprice' => $data['maxprice'] ?? 0,
                'priceunit' => $data['priceunit'] ?? '',
                'signingfee' => $data['signingfee'] ?? 0,
                'currencyid' => $data['currencyid'] ?? 1,
                'exchangerate' => $data['exchangerate'] ?? 1.0000,
                'commission' => $data['commission'] ?? 0,
                'commissionpaid' => $data['commissionpaid'] ?? 0,
                'sellerid' => $data['sellerid'] ?? null,
                'sellername' => $data['sellername'] ?? '',
                'sellerphone' => $data['sellerphone'] ?? '',
                'attorneyid' => $data['attorneyid'] ?? null,
                'itembidid' => 0,
                'geolatitude' => $data['geolatitude'] ?? 0,
                'geolongitude' => $data['geolongitude'] ?? 0,
                'itemstatusid' => $data['itemstatusid'] ?? 0,
                'itemshortstatusid' => $data['itemshortstatusid'] ?? 0,
                'inspectionstatusid' => $data['inspectionstatusid'] ?? null,
                'inspectiontaskid' => 0,
                'deadline' => $data['deadline'] ?? null,
            ];

            // Merge in audit fields (companyid, entryby, modifyby, entrydate, isdeleted)
            $payload = $this->withCreateAudit($payload);

            $id = $this->db->insert('items', $payload);
            return ['success' => true, 'message' => 'Property created', 'id' => $id];
        } catch (Exception $e) {
            Logger::error('Create Property failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Creation failed'];
        }
    }
    
    /**
     * Save item profiles for a given item
     * @param int $itemId
     * @param array $profiles Array of ['profileoptionid','profilevalue','basevalue','showuser']
     * @return array {success: bool, count?: int, message?: string}
     */
    public function saveItemProfiles($itemId, $profiles) {
        try {
            if (!$itemId) {
                return ['success' => false, 'message' => 'Invalid item'];
            }

            // Separate operations by type
            $insertRows = [];
            $updateRows = [];
            $deleteRows = [];
            $optionIds = [];
            
            foreach ($profiles as $p) {
                // Check if this is a delete operation
                if (isset($p['itemprofileid']) && isset($p['isdeleted']) && $p['isdeleted'] == -1) {
                    $deleteRows[] = (int)$p['itemprofileid'];
                    continue;
                }
                
                // Check if this is an update operation
                if (isset($p['itemprofileid']) && (int)$p['itemprofileid'] > 0) {
                    $optId = isset($p['profileoptionid']) ? (int)$p['profileoptionid'] : 0;
                    if ($optId <= 0) { continue; }
                    $optionIds[] = $optId;
                    $updateRows[] = [
                        'itemprofileid' => (int)$p['itemprofileid'],
                        'profileoptionid' => $optId,
                        'profilevalue' => trim($p['profilevalue'] ?? ''),
                        'basevalue' => is_numeric($p['basevalue'] ?? null) ? (float)$p['basevalue'] : 0,
                        'showuser' => !empty($p['showuser']) ? 1 : 0,
                    ];
                    continue;
                }
                
                // Otherwise it's an insert
                $optId = isset($p['profileoptionid']) ? (int)$p['profileoptionid'] : 0;
                if ($optId <= 0) { continue; }
                $optionIds[] = $optId;
                $insertRows[] = [
                    'profileoptionid' => $optId,
                    'profilevalue' => trim($p['profilevalue'] ?? ''),
                    'basevalue' => is_numeric($p['basevalue'] ?? null) ? (float)$p['basevalue'] : 0,
                    'showuser' => !empty($p['showuser']) ? 1 : 0,
                ];
            }
            
            // Must have at least one operation
            if (empty($insertRows) && empty($updateRows) && empty($deleteRows)) {
                return ['success' => false, 'message' => 'No valid profile rows'];
            }

            // Fetch titles for profile options if needed
            $titles = [];
            if (!empty($optionIds)) {
                $placeholders = implode(',', array_fill(0, count($optionIds), '?'));
                $params = array_merge([$this->companyId], $optionIds);
                $sql = "SELECT itemprofileoptionid, title FROM itemprofileoptions WHERE isdeleted = 0 AND companyid = ? AND itemprofileoptionid IN ($placeholders)";
                $opts = $this->db->select($sql, $params);
                foreach ($opts as $o) {
                    $titles[(int)$o['itemprofileoptionid']] = $o['title'] ?? '';
                }
            }

            $count = 0;
            
            // Handle deletes (soft delete)
            foreach ($deleteRows as $profileId) {
                $updateData = ['isdeleted' => -1];
                $updateData = $this->withUpdateAudit($updateData);
                $this->db->update('itemprofiles', $updateData, 'itemprofileid = ?', [$profileId]);
                $count++;
            }
            
            // Handle updates
            foreach ($updateRows as $r) {
                $updateData = [
                    'profileoptionid' => $r['profileoptionid'],
                    'profileoptiontitle' => $titles[$r['profileoptionid']] ?? '',
                    'profilevalue' => $r['profilevalue'],
                    'basevalue' => $r['basevalue'],
                    'showuser' => $r['showuser'],
                ];
                $updateData = $this->withUpdateAudit($updateData);
                $this->db->update('itemprofiles', $updateData, 'itemprofileid = ?', [$r['itemprofileid']]);
                $count++;
            }
            
            // Handle inserts
            foreach ($insertRows as $r) {
                $payload = [
                    'itemid' => $itemId,
                    'profileoptionid' => $r['profileoptionid'],
                    'profileoptiontitle' => $titles[$r['profileoptionid']] ?? '',
                    'profilevalue' => $r['profilevalue'],
                    'basevalue' => $r['basevalue'],
                    'showuser' => $r['showuser'],
                ];
                $payload = $this->withCreateAudit($payload);
                $this->db->insert('itemprofiles', $payload);
                $count++;
            }
            
            return ['success' => true, 'count' => $count];
        } catch (Exception $e) {
            Logger::error('Save Item Profiles failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Save profiles failed'];
        }
    }

    /**
     * Save item documents (handles optional file uploads)
     */
    public function saveItemDocs($itemId, $docs) {
        try {
            if (!$itemId) return ['success' => false, 'message' => 'Invalid item'];

            // Separate operations by type
            $insertRows = [];
            $updateRows = [];
            $deleteRows = [];
            $docTypeIds = [];
            
            foreach ($docs as $row) {
                // Check if this is a delete operation
                if (isset($row['itemdocid']) && isset($row['isdeleted']) && $row['isdeleted'] == -1) {
                    $deleteRows[] = (int)$row['itemdocid'];
                    continue;
                }
                
                // Check if this is an update operation
                if (isset($row['itemdocid']) && (int)$row['itemdocid'] > 0) {
                    $itemdoctypeid = isset($row['itemdoctypeid']) ? (int)$row['itemdoctypeid'] : null;
                    if ($itemdoctypeid) $docTypeIds[] = $itemdoctypeid;
                    $updateRows[] = [
                        'itemdocid' => (int)$row['itemdocid'],
                        'itemdoctypeid' => $itemdoctypeid,
                        'docstatus' => isset($row['docstatus']) ? (int)$row['docstatus'] : 1,
                    ];
                    continue;
                }
                
                // Otherwise it's an insert
                $itemdoctypeid = isset($row['itemdoctypeid']) ? (int)$row['itemdoctypeid'] : null;
                if ($itemdoctypeid) $docTypeIds[] = $itemdoctypeid;
                $insertRows[] = [
                    'itemdoctypeid' => $itemdoctypeid,
                    'docstatus' => isset($row['docstatus']) ? (int)$row['docstatus'] : 1,
                    '__file' => $row['__file'] ?? null,
                ];
            }
            
            // Must have at least one operation
            if (empty($insertRows) && empty($updateRows) && empty($deleteRows)) {
                return ['success' => false, 'message' => 'No valid document rows'];
            }

            // Preload doc type titles
            $titles = [];
            if (!empty($docTypeIds)) {
                $placeholders = implode(',', array_fill(0, count($docTypeIds), '?'));
                $params = array_merge([$this->companyId], $docTypeIds);
                $sql = "SELECT itemdoctypeid, title FROM itemdoctypes WHERE isdeleted = 0 AND companyid = ? AND itemdoctypeid IN ($placeholders)";
                $rows = $this->db->select($sql, $params);
                foreach ($rows as $r) $titles[(int)$r['itemdoctypeid']] = $r['title'] ?? '';
            }

            $count = 0;
            
            // Handle deletes (soft delete)
            foreach ($deleteRows as $docId) {
                $updateData = ['isdeleted' => -1];
                $updateData = $this->withUpdateAudit($updateData);
                $this->db->update('itemdocs', $updateData, 'itemdocid = ?', [$docId]);
                $count++;
            }
            
            // Handle updates
            foreach ($updateRows as $row) {
                $updateData = [
                    'itemdoctypeid' => $row['itemdoctypeid'],
                    'itemdoctitle' => $row['itemdoctypeid'] ? ($titles[$row['itemdoctypeid']] ?? '') : '',
                    'docstatus' => $row['docstatus'],
                ];
                $updateData = $this->withUpdateAudit($updateData);
                $this->db->update('itemdocs', $updateData, 'itemdocid = ?', [$row['itemdocid']]);
                $count++;
            }
            
            // Handle inserts
            foreach ($insertRows as $row) {
                // Handle file upload (uses documents/ folder for itemdocs.docurl)
                $docUrl = null;
                if (!empty($row['__file']) && is_array($row['__file'])) {
                    $file = $row['__file'];
                    if (!empty($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {
                        $result = uploadFile($file, 'documents');
                        if ($result['success']) {
                            // Store only filename, not full path
                            $docUrl = $result['filename'];
                        }
                    }
                }

                $payload = [
                    'itemid' => $itemId,
                    'itemdoctypeid' => $row['itemdoctypeid'],
                    'itemdoctitle' => $row['itemdoctypeid'] ? ($titles[$row['itemdoctypeid']] ?? '') : '',
                    'docurl' => $docUrl,
                    'uploadby' => Auth::id(),
                    'uploaddate' => date('Y-m-d H:i:s'),
                    'docstatus' => $row['docstatus'],
                ];
                $payload = $this->withCreateAudit($payload);
                $this->db->insert('itemdocs', $payload);
                $count++;
            }
            
            return ['success' => true, 'count' => $count];
        } catch (Exception $e) {
            Logger::error('Save Item Docs failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Save documents failed'];
        }
    }

    /**
     * Save item pictures (handles image uploads)
     */
    public function saveItemPics($itemId, $pics) {
        try {
            if (!$itemId) return ['success' => false, 'message' => 'Invalid item'];
            
            // Separate operations by type
            $insertRows = [];
            $updateRows = [];
            $deleteRows = [];
            
            foreach ($pics as $row) {
                // Check if this is a delete operation
                if (isset($row['itempicid']) && isset($row['isdeleted']) && $row['isdeleted'] == -1) {
                    $deleteRows[] = (int)$row['itempicid'];
                    continue;
                }
                
                // Check if this is an update operation
                if (isset($row['itempicid']) && (int)$row['itempicid'] > 0) {
                    $updateRows[] = [
                        'itempicid' => (int)$row['itempicid'],
                        'pictitle' => trim($row['pictitle'] ?? ''),
                        'picstatus' => isset($row['picstatus']) ? (int)$row['picstatus'] : 1,
                    ];
                    continue;
                }
                
                // Otherwise it's an insert
                $insertRows[] = [
                    'pictitle' => trim($row['pictitle'] ?? ''),
                    'picstatus' => isset($row['picstatus']) ? (int)$row['picstatus'] : 1,
                    '__file' => $row['__file'] ?? null,
                ];
            }
            
            // Must have at least one operation
            if (empty($insertRows) && empty($updateRows) && empty($deleteRows)) {
                return ['success' => false, 'message' => 'No valid picture rows'];
            }

            $count = 0;
            
            // Handle deletes (soft delete)
            foreach ($deleteRows as $picId) {
                $updateData = ['isdeleted' => -1];
                $updateData = $this->withUpdateAudit($updateData);
                $this->db->update('itempics', $updateData, 'itempicid = ?', [$picId]);
                $count++;
            }
            
            // Handle updates
            foreach ($updateRows as $row) {
                $updateData = [
                    'pictitle' => $row['pictitle'],
                    'picstatus' => $row['picstatus'],
                ];
                $updateData = $this->withUpdateAudit($updateData);
                $this->db->update('itempics', $updateData, 'itempicid = ?', [$row['itempicid']]);
                $count++;
            }
            
            // Handle inserts
            foreach ($insertRows as $row) {
                // Upload image (uses pictures/ folder for itempics.picurl)
                $picUrl = null;
                if (!empty($row['__file']) && is_array($row['__file'])) {
                    $file = $row['__file'];
                    if (!empty($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {
                        $result = uploadFile($file, 'pictures');
                        if ($result['success']) {
                            // Store only filename, not full path
                            $picUrl = $result['filename'];
                        }
                    }
                }

                $payload = [
                    'itemid' => $itemId,
                    'pictitleid' => 0, // no dropdown in UI; default to 0
                    'pictitle' => $row['pictitle'],
                    'picurl' => $picUrl,
                    'picstatus' => $row['picstatus'],
                    'uploadby' => Auth::id(),
                    'uploaddate' => date('Y-m-d H:i:s'),
                ];
                $payload = $this->withCreateAudit($payload);
                $this->db->insert('itempics', $payload);
                $count++;
            }
            
            return ['success' => true, 'count' => $count];
        } catch (Exception $e) {
            Logger::error('Save Item Pics failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Save pictures failed'];
        }
    }

    /**
     * Save property layout rows into `subitem` table
     */
    public function savePropertyLayout($itemId, $layouts) {
        try {
            if (!$itemId) return ['success' => false, 'message' => 'Invalid item'];
            if (empty($layouts) || !is_array($layouts)) return ['success' => false, 'message' => 'No layouts submitted'];

            $insertCount = 0;
            $updateCount = 0;
            $deleteCount = 0;

            foreach ($layouts as $row) {
                $subitemId = isset($row['subitemid']) && is_numeric($row['subitemid']) ? (int)$row['subitemid'] : 0;
                $isDeleted = isset($row['isdeleted']) && is_numeric($row['isdeleted']) ? (int)$row['isdeleted'] : 0;

                // Handle DELETE operation
                if ($subitemId > 0 && $isDeleted == -1) {
                    $payload = ['isdeleted' => -1];
                    $payload = $this->withUpdateAudit($payload);
                    $this->db->update('subitem', $payload, 'subitemid = ?', [$subitemId]);
                    $deleteCount++;
                    continue;
                }

                // Handle UPDATE operation
                if ($subitemId > 0) {
                    $floortitle = trim($row['floortitle'] ?? '');
                    $roomcount = isset($row['roomcount']) && is_numeric($row['roomcount']) ? (int)$row['roomcount'] : 0;
                    $roomlabels = trim($row['roomlabels'] ?? '');
                    $roomsizes = trim($row['roomsizes'] ?? '');
                    $roomprices = trim($row['roomprices'] ?? '');

                    $payload = [
                        'floortitle' => $floortitle,
                        'roomcount' => $roomcount,
                        'roomlabels' => $roomlabels,
                        'roomsizes' => $roomsizes,
                        'roomprices' => $roomprices,
                    ];
                    $payload = $this->withUpdateAudit($payload);
                    $this->db->update('subitem', $payload, 'subitemid = ?', [$subitemId]);
                    $updateCount++;
                    continue;
                }

                // Handle INSERT operation (new layout)
                $floortitle = trim($row['floortitle'] ?? '');
                $roomcount = isset($row['roomcount']) && is_numeric($row['roomcount']) ? (int)$row['roomcount'] : 0;
                $roomlabels = trim($row['roomlabels'] ?? '');
                $roomsizes = trim($row['roomsizes'] ?? '');
                $roomprices = trim($row['roomprices'] ?? '');

                $payload = [
                    'itemid' => $itemId,
                    'floortitle' => $floortitle,
                    'roomcount' => $roomcount,
                    'roomlabels' => $roomlabels,
                    'roomsizes' => $roomsizes,
                    'roomprices' => $roomprices,
                ];
                $payload = $this->withCreateAudit($payload);
                $this->db->insert('subitem', $payload);
                $insertCount++;
            }
            
            return [
                'success' => true, 
                'inserted' => $insertCount,
                'updated' => $updateCount,
                'deleted' => $deleteCount
            ];
        } catch (Exception $e) {
            Logger::error('Save Property Layout failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Save layout failed'];
        }
    }
}
