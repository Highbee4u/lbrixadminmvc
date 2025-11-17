<?php

use App\Traits\HasFileUpload;

class InvestmentService {
    use AuditFields, HasFileUpload;

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
        if (!empty($filters['ownership_type'])) {
            $conditions[] = 'i.ownershiptypeid = ?';
            $params[] = $filters['ownership_type'];
        }
        if (!empty($filters['entry_date'])) {
            $conditions[] = 'DATE(i.entrydate) = ?';
            $params[] = $filters['entry_date'];
        }
    }

    // ============ Lists ============
    public function getPendingInvestmentList($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid <= 1',
            'COALESCE(i.inspectionstatusid,0) = 0'
        ];
        $params = [self::NOT_DELETED, 4, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        
        // Log the full query with bound parameters
        $logMessage = "getPendingInvestmentList SQL Query:\n";
        $logMessage .= "Base SQL: " . $base . "\n";
        $logMessage .= "Count SQL: " . $count . "\n";
        $logMessage .= "Params: " . json_encode($params) . "\n";
        $logMessage .= "Page: " . $page . ", PerPage: " . $perPage . "\n";
        $logMessage .= "Filters: " . json_encode($filters);
        Logger::info($logMessage);
        
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getAwaitingProjectList($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid IN (2,3)',
            'COALESCE(i.inspectionstatusid,0) IN (0,3)'
        ];
        $params = [self::NOT_DELETED, 4, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getAllInspectionInProgressProject($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid IN (2,3)',
            'i.inspectionstatusid = 1'
        ];
        $params = [self::NOT_DELETED, 4, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getInspectionConcludedList($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid IN (2,3)',
            'i.inspectionstatusid = 2'
        ];
        $params = [self::NOT_DELETED, 4, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getInspectionRejectedList($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid = ?',
            'i.inspectionstatusid = ?'
        ];
        $params = [self::NOT_DELETED, 4, $this->companyId, self::REJECT_STATUS, self::REJECT_STATUS];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getInspectionApprovedList($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid = 4',
            'i.inspectionstatusid = 4'
        ];
        $params = [self::NOT_DELETED, 4, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getAwaitingListingList($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid = 9'
        ];
        $params = [self::NOT_DELETED, 4, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getListedPropertyList($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid = 10'
        ];
        $params = [self::NOT_DELETED, 4, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    public function getClosedProject($filters = [], $page = 1, $perPage = 15) {
        $conditions = [
            'i.isdeleted = ?',
            'i.servicetypeid = ?',
            'i.companyid = ?',
            'i.itemstatusid = 20'
        ];
        $params = [self::NOT_DELETED, 4, $this->companyId];
        $this->whereFilters($conditions, $params, $filters);
        $where = implode(' AND ', $conditions);
        $base = "SELECT i.* FROM items i WHERE $where ORDER BY i.entrydate DESC";
        $count = "SELECT COUNT(*) as total FROM items i WHERE $where";
        return $this->paginate($base, $count, $params, $page, $perPage);
    }

    // ============ Dashboard Stats ============
    public function dashboardGetStats() {
        $stats = [];
        $serviceTypeId = 4;
        
        // Pending Projects (status <= 1, inspection status 0 or 1)
        $sql = "SELECT COUNT(itemid) as totalnumber, SUM(price) as totalamount 
                FROM items 
                WHERE servicetypeid = ? AND isdeleted = ? AND companyid = ? 
                AND itemstatusid <= 1 AND COALESCE(inspectionstatusid, 0) IN (0,1)";
        $result = $this->db->select($sql, [$serviceTypeId, self::NOT_DELETED, $this->companyId]);
        $stats['pendingProjects'] = $result[0] ?? ['totalnumber' => 0, 'totalamount' => 0];

        // Awaiting Projects (status 2,3, inspection status 0,3)
        $sql = "SELECT COUNT(itemid) as totalnumber, SUM(price) as totalamount 
                FROM items 
                WHERE servicetypeid = ? AND isdeleted = ? AND companyid = ? 
                AND itemstatusid IN (2,3) AND COALESCE(inspectionstatusid, 0) IN (0,3)";
        $result = $this->db->select($sql, [$serviceTypeId, self::NOT_DELETED, $this->companyId]);
        $stats['awaitingProjects'] = $result[0] ?? ['totalnumber' => 0, 'totalamount' => 0];

        // Concluded Projects (status 2,3, inspection status 2)
        $sql = "SELECT COUNT(itemid) as totalnumber, SUM(price) as totalamount 
                FROM items 
                WHERE servicetypeid = ? AND isdeleted = ? AND companyid = ? 
                AND itemstatusid IN (2,3) AND inspectionstatusid = 2";
        $result = $this->db->select($sql, [$serviceTypeId, self::NOT_DELETED, $this->companyId]);
        $stats['concludedProjects'] = $result[0] ?? ['totalnumber' => 0, 'totalamount' => 0];

        // Rejected Projects (status 5, inspection status 5)
        $sql = "SELECT COUNT(itemid) as totalnumber, SUM(price) as totalamount 
                FROM items 
                WHERE servicetypeid = ? AND isdeleted = ? AND companyid = ? 
                AND itemstatusid = 5 AND inspectionstatusid = 5";
        $result = $this->db->select($sql, [$serviceTypeId, self::NOT_DELETED, $this->companyId]);
        $stats['rejectedProjects'] = $result[0] ?? ['totalnumber' => 0, 'totalamount' => 0];

        // Approved Projects (status 4, inspection status 4)
        $sql = "SELECT COUNT(itemid) as totalnumber, SUM(price) as totalamount 
                FROM items 
                WHERE servicetypeid = ? AND isdeleted = ? AND companyid = ? 
                AND itemstatusid = 4 AND inspectionstatusid = 4";
        $result = $this->db->select($sql, [$serviceTypeId, self::NOT_DELETED, $this->companyId]);
        $stats['approvedProjects'] = $result[0] ?? ['totalnumber' => 0, 'totalamount' => 0];

        // Awaiting Listing Projects (status 9)
        $sql = "SELECT COUNT(itemid) as totalnumber, SUM(price) as totalamount 
                FROM items 
                WHERE servicetypeid = ? AND isdeleted = ? AND companyid = ? 
                AND itemstatusid = 9";
        $result = $this->db->select($sql, [$serviceTypeId, self::NOT_DELETED, $this->companyId]);
        $stats['awaitingListingProjects'] = $result[0] ?? ['totalnumber' => 0, 'totalamount' => 0];

        // Listed Projects (status 10)
        $sql = "SELECT COUNT(itemid) as totalnumber, SUM(price) as totalamount 
                FROM items 
                WHERE servicetypeid = ? AND isdeleted = ? AND companyid = ? 
                AND itemstatusid = 10";
        $result = $this->db->select($sql, [$serviceTypeId, self::NOT_DELETED, $this->companyId]);
        $stats['listedProjects'] = $result[0] ?? ['totalnumber' => 0, 'totalamount' => 0];

        // Closed Projects (status 20)
        $sql = "SELECT COUNT(itemid) as totalnumber, SUM(price) as totalamount 
                FROM items 
                WHERE servicetypeid = ? AND isdeleted = ? AND companyid = ? 
                AND itemstatusid = 20";
        $result = $this->db->select($sql, [$serviceTypeId, self::NOT_DELETED, $this->companyId]);
        $stats['closedProjects'] = $result[0] ?? ['totalnumber' => 0, 'totalamount' => 0];

        return $stats;
    }

    public function dashboardGetRecentPending($limit = 4) {
        $sql = "SELECT i.*,
                (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
                (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
                (SELECT it.startdate FROM inspectiontask it WHERE it.itemid = i.itemid ORDER BY it.inspectiontaskid DESC LIMIT 1) as inspectionstartdate,
                (SELECT TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) FROM inspectiontask it1 
                 JOIN users u ON it1.inspectionlead=u.userid WHERE it1.itemid = i.itemid ORDER BY it1.inspectiontaskid DESC LIMIT 1) as inspectionlead,
                b.options as bidtype
                FROM items i
                LEFT JOIN bidtype b ON i.companyid = b.companyid AND b.bidtypeid = i.bidtypeid AND b.serviceid = i.servicetypeid
                WHERE i.isdeleted = ? AND i.companyid = ? AND i.servicetypeid = 4 
                AND COALESCE(i.itemstatusid,0) IN (0,1)
                ORDER BY i.entrydate DESC
                LIMIT ?";
        return $this->db->select($sql, [self::NOT_DELETED, $this->companyId, $limit]);
    }

    public function dashboardGetRecentAwaiting($limit = 4) {
        $sql = "SELECT i.*,
                (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
                (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
                (SELECT it.startdate FROM inspectiontask it WHERE it.itemid = i.itemid ORDER BY it.inspectiontaskid DESC LIMIT 1) as inspectionstartdate,
                (SELECT TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) FROM inspectiontask it1 
                 JOIN users u ON it1.inspectionlead=u.userid WHERE it1.itemid = i.itemid ORDER BY it1.inspectiontaskid DESC LIMIT 1) as inspectionlead,
                b.options as bidtype
                FROM items i
                LEFT JOIN bidtype b ON i.companyid = b.companyid AND b.bidtypeid = i.bidtypeid AND b.serviceid = i.servicetypeid
                WHERE i.isdeleted = ? AND i.companyid = ? AND i.servicetypeid = 4 
                AND COALESCE(i.itemstatusid,0) IN (2,3) 
                AND COALESCE(i.inspectionstatusid,0) IN (0,3)
                ORDER BY i.entrydate DESC
                LIMIT ?";
        return $this->db->select($sql, [self::NOT_DELETED, $this->companyId, $limit]);
    }

    public function dashboardGetRecentOffers($limit = 4) {
        $sql = "SELECT i.*,
                COUNT(ib.itemid) as bidcount,
                AVG(ib.proposedamount) as averageoffer,
                (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
                (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
                (SELECT b.options FROM bidtype b WHERE b.companyid = i.companyid AND b.bidtypeid = i.bidtypeid LIMIT 1) as bidtype
                FROM items i
                LEFT JOIN itembids ib ON i.companyid = ib.companyid AND ib.itemid = i.itemid
                WHERE i.isdeleted = ? AND i.companyid = ? AND i.servicetypeid = 4 
                AND i.itemstatusid = 10
                GROUP BY i.itemid
                ORDER BY i.entrydate DESC
                LIMIT ?";
        return $this->db->select($sql, [self::NOT_DELETED, $this->companyId, $limit]);
    }

    public function dashboardGetRecentInspconcluded($limit = 4) {
        $sql = "SELECT i.*,
                (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
                (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
                (SELECT it.startdate FROM inspectiontask it WHERE it.itemid = i.itemid ORDER BY it.inspectiontaskid DESC LIMIT 1) as inspectionstartdate,
                (SELECT TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) FROM inspectiontask it1 
                 JOIN users u ON it1.inspectionlead=u.userid WHERE it1.itemid = i.itemid ORDER BY it1.inspectiontaskid DESC LIMIT 1) as inspectionlead,
                b.options as bidtype
                FROM items i
                LEFT JOIN bidtype b ON i.companyid = b.companyid AND b.bidtypeid = i.bidtypeid AND b.serviceid = i.servicetypeid
                WHERE i.isdeleted = ? AND i.companyid = ? AND i.servicetypeid = 4 
                AND i.itemstatusid IN (2,3) 
                AND i.inspectionstatusid = 2
                ORDER BY i.entrydate DESC
                LIMIT ?";
        return $this->db->select($sql, [self::NOT_DELETED, $this->companyId, $limit]);
    }

    // ============ CRUD Operations ============
    public function createProject($data) {
        try {
            // Prepare project data with required fields
            $payload = [
                'servicetypeid' => $data['servicetypeid'] ?? 4, // Default to 4 for investments
                'title' => trim($data['title'] ?? ''),
                'description' => trim($data['description'] ?? ''),
                'address' => trim($data['address'] ?? ''),
                'itemtypeid' => !empty($data['itemtypeid']) ? (int)$data['itemtypeid'] : null,
                'inspectionstatusid' => !empty($data['inspectionstatusid']) ? (int)$data['inspectionstatusid'] : null,
                'inspectiontaskid' => !empty($data['inspectiontaskid']) ? (int)$data['inspectiontaskid'] : null,
                'ownershiptypeid' => !empty($data['ownershiptypeid']) ? (int)$data['ownershiptypeid'] : null,
                'ownershiptypetitle' => trim($data['ownershiptypetitle'] ?? ''),
                'price' => !empty($data['price']) ? (float)$data['price'] : null,
                'minprice' => !empty($data['minprice']) ? (float)$data['minprice'] : null,
                'maxprice' => !empty($data['maxprice']) ? (float)$data['maxprice'] : null,
                'investunit' => trim($data['investunit'] ?? ''),
                'investreturns' => trim($data['investreturns'] ?? ''),
                'tenure' => trim($data['tenure'] ?? ''),
                'investoptionid' => !empty($data['investoptionid']) ? (int)$data['investoptionid'] : null,
                'investoptiontitle' => trim($data['investoptiontitle'] ?? ''),
                'sellerid' => !empty($data['sellerid']) ? (int)$data['sellerid'] : null,
                'attorneyid' => !empty($data['attorneyid']) ? (int)$data['attorneyid'] : null,
                'projecttypeid' => !empty($data['projecttypeid']) ? (int)$data['projecttypeid'] : null,
                'projecttypetitle' => trim($data['projecttypetitle'] ?? ''),
                'itemstatusid' => !empty($data['itemstatusid']) ? (int)$data['itemstatusid'] : 0,
                'companyid' => $this->companyId,
                'inspectiontaskid' => 0,
                'isdeleted' => self::NOT_DELETED,
            ];

            // Add audit fields
            $payload = $this->withCreateAudit($payload);

            // Insert into database
            $itemId = $this->db->insert('items', $payload);

            Logger::info('Project created successfully', ['itemid' => $itemId, 'title' => $payload['title']]);

            return ['success' => true, 'itemid' => $itemId, 'message' => 'Project created successfully'];
        } catch (Exception $e) {
            Logger::error('Create project failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create project: ' . $e->getMessage()];
        }
    }

    public function updateProject($itemId, $data) {
        try {
            // Prepare update data with required fields
            $payload = [
                'title' => trim($data['title'] ?? ''),
                'description' => trim($data['description'] ?? ''),
                'address' => trim($data['address'] ?? ''),
                'itemtypeid' => !empty($data['itemtypeid']) ? (int)$data['itemtypeid'] : null,
                'inspectionstatusid' => !empty($data['inspectionstatusid']) ? (int)$data['inspectionstatusid'] : null,
                'ownershiptypeid' => !empty($data['ownershiptypeid']) ? (int)$data['ownershiptypeid'] : null,
                'ownershiptypetitle' => trim($data['ownershiptypetitle'] ?? ''),
                'price' => !empty($data['price']) ? (float)$data['price'] : null,
                'minprice' => !empty($data['minprice']) ? (float)$data['minprice'] : null,
                'maxprice' => !empty($data['maxprice']) ? (float)$data['maxprice'] : null,
                'investunit' => trim($data['investunit'] ?? ''),
                'investreturns' => trim($data['investreturns'] ?? ''),
                'tenure' => trim($data['tenure'] ?? ''),
                'investoptionid' => !empty($data['investoptionid']) ? (int)$data['investoptionid'] : null,
                'investoptiontitle' => trim($data['investoptiontitle'] ?? ''),
                'sellerid' => !empty($data['sellerid']) ? (int)$data['sellerid'] : null,
                'attorneyid' => !empty($data['attorneyid']) ? (int)$data['attorneyid'] : null,
                'projecttypeid' => !empty($data['projecttypeid']) ? (int)$data['projecttypeid'] : null,
                'projecttypetitle' => trim($data['projecttypetitle'] ?? ''),
                'itemstatusid' => isset($data['itemstatusid']) ? (int)$data['itemstatusid'] : null,
            ];

            // Remove null values to avoid overwriting with nulls
            $payload = array_filter($payload, function($value) {
                return $value !== null;
            });

            // Add audit fields
            $payload = $this->withUpdateAudit($payload);

            // Build update query
            $setClauses = [];
            $params = [];
            foreach ($payload as $key => $value) {
                $setClauses[] = "$key = ?";
                $params[] = $value;
            }
            
            // Add WHERE clause parameters
            $params[] = $itemId;
            $params[] = self::NOT_DELETED;
            $params[] = $this->companyId;

            $sql = "UPDATE items SET " . implode(', ', $setClauses) . " WHERE itemid = ? AND isdeleted = ? AND companyid = ?";
            $rowCount = $this->db->query($sql, $params)->rowCount();

            if ($rowCount > 0) {
                Logger::info('Project updated successfully', ['itemid' => $itemId, 'title' => $payload['title'] ?? 'N/A']);
                return ['success' => true, 'message' => 'Project updated successfully'];
            } else {
                Logger::warning('No rows updated for project', ['itemid' => $itemId]);
                return ['success' => false, 'message' => 'No changes made or project not found'];
            }
        } catch (Exception $e) {
            Logger::error('Update project failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update project: ' . $e->getMessage()];
        }
    }

    public function deleteAwaitingProject($itemId) {
        $sql = "UPDATE items SET isdeleted = ? WHERE itemid = ? AND isdeleted = ? AND companyid = ?";
        return $this->db->query($sql, [self::IS_DELETED, $itemId, self::NOT_DELETED, $this->companyId])->rowCount();
    }

    public function updateInspectionStatus($itemId, $statusId) {
        $sql = "UPDATE items SET inspectionstatusid = ? WHERE itemid = ? AND isdeleted = ? AND companyid = ?";
        return $this->db->query($sql, [$statusId, $itemId, self::NOT_DELETED, $this->companyId])->rowCount();
    }

    public function updateProjectStatus($itemId, $data) {
        $updates = [];
        $params = [];
        
        if (isset($data['itemstatusid'])) {
            $updates[] = 'itemstatusid = ?';
            $params[] = $data['itemstatusid'];
        }
        
        if (isset($data['inspectionstatusid'])) {
            $updates[] = 'inspectionstatusid = ?';
            $params[] = $data['inspectionstatusid'];
        }
        
        if (empty($updates)) {
            return false;
        }
        
        $sql = "UPDATE items SET " . implode(', ', $updates) . " WHERE itemid = ? AND isdeleted = ? AND companyid = ?";
        $params[] = $itemId;
        $params[] = self::NOT_DELETED;
        $params[] = $this->companyId;
        
        return $this->db->query($sql, $params)->rowCount() > 0;
    }

    public function getProjectById($itemId) {
        $sql = "SELECT i.* FROM items i WHERE i.itemid = ? AND i.isdeleted = ? AND i.companyid = ?";
        $result = $this->db->select($sql, [$itemId, self::NOT_DELETED, $this->companyId]);
        return $result[0] ?? null;
    }

    public function getProjectWithRelations($itemId) {
        
        $project = $this->getProjectById($itemId);
        if (!$project) {
            return null;
        }

        // Get related data
        $project['itemType'] = $this->getItemType($project['itemtypeid'] ?? null);
        $project['inspectionStatus'] = $this->getInspectionStatus($project['inspectionstatusid'] ?? null);
        $project['ownershipType'] = $this->getOwnershipType($project['ownershiptypeid'] ?? null);
        $project['financee'] = $this->getUser($project['sellerid'] ?? null);
        $project['attorney'] = $this->getAttorney($project['attorneyid'] ?? null);
        $project['itemStatus'] = $this->getItemStatus($project['itemstatusid'] ?? null);
        $project['investOption'] = $this->getInvestOption($project['investoptionid'] ?? null);
        $project['projectType'] = $this->getProjectType($project['projecttypeid'] ?? null);
        $project['state'] = $this->getState($project['stateid'] ?? null);
        $project['itemProfiles'] = $this->getItemProfiles($itemId);
        $project['itemDocs'] = $this->getItemDocs($itemId);
        $project['itemPics'] = $this->getItemPics($itemId);
        $project['inspectionTasks'] = $this->getInspectionTasks($itemId);
        $project['itemBids'] = $this->getItemBids($itemId);

        return $project;
    }

    // Helper methods to get related data
    private function getItemType($id) {
        if (!$id) return null;
        $sql = "SELECT * FROM itemtypes WHERE itemtypeid = ?";
        $result = $this->db->select($sql, [$id]);
        return $result[0] ?? null;
    }

    private function getInspectionStatus($id) {
        if (!$id) return null;
        $sql = "SELECT * FROM inspectionstatus WHERE inspectionstatusid = ?";
        $result = $this->db->select($sql, [$id]);
        return $result[0] ?? null;
    }

    private function getOwnershipType($id) {
        if (!$id) return null;
        $sql = "SELECT * FROM ownershiptypes WHERE ownershiptypeid = ?";
        $result = $this->db->select($sql, [$id]);
        return $result[0] ?? null;
    }

    private function getUser($id) {
        if (!$id) return null;
        $sql = "SELECT * FROM users WHERE userid = ?";
        $result = $this->db->select($sql, [$id]);
        return $result[0] ?? null;
    }

    private function getAttorney($id) {
        if (!$id) return null;
        $sql = "SELECT * FROM users WHERE userid = ?";
        $result = $this->db->select($sql, [$id]);
        return $result[0] ?? null;
    }

    private function getItemStatus($id) {
        if (!$id) return null;
        $sql = "SELECT * FROM itemstatus WHERE itemstatusid = ?";
        $result = $this->db->select($sql, [$id]);
        return $result[0] ?? null;
    }

    private function getInvestOption($id) {
        if (!$id) return null;
        $sql = "SELECT * FROM investoptions WHERE investoptionid = ?";
        $result = $this->db->select($sql, [$id]);
        return $result[0] ?? null;
    }

    private function getProjectType($id) {
        if (!$id) return null;
        $sql = "SELECT * FROM projecttypes WHERE projecttypeid = ?";
        $result = $this->db->select($sql, [$id]);
        return $result[0] ?? null;
    }

    private function getState($id) {
        if (!$id) return null;
        $sql = "SELECT * FROM states WHERE stateid = ?";
        $result = $this->db->select($sql, [$id]);
        return $result[0] ?? null;
    }

    private function getItemProfiles($itemId) {
        $sql = "SELECT ip.*, po.title as profileOptionTitle 
                FROM itemprofiles ip 
                LEFT JOIN itemprofileoptions po ON ip.itemprofileid = po.itemprofileoptionid 
                WHERE ip.itemid = ?";
        $profiles = $this->db->select($sql, [$itemId]);
        
        // Transform to match expected structure
        foreach ($profiles as &$profile) {
            $profile['profileOption'] = ['title' => $profile['profileOptionTitle'] ?? 'N/A'];
        }
        return $profiles;
    }

    private function getItemDocs($itemId) {
        $sql = "SELECT id.*, idt.title as itemDocTypeTitle 
                FROM itemdocs id 
                LEFT JOIN itemdoctypes idt ON id.itemdoctypeid = idt.itemdoctypeid 
                WHERE id.itemid = ?  AND id.isdeleted = ?";
        $docs = $this->db->select($sql, [$itemId, self::NOT_DELETED]);
        
        // Transform to match expected structure
        foreach ($docs as &$doc) {
            $doc['itemDocType'] = ['title' => $doc['itemDocTypeTitle'] ?? 'Document'];
        }
        return $docs;
    }

    private function getItemPics($itemId) {
        $sql = "SELECT * FROM itempics WHERE itemid = ? ORDER BY itempicid";
        return $this->db->select($sql, [$itemId]);
    }

    private function getInspectionTasks($itemId) {
        $sql = "SELECT it.*, 
                ist.title as inspectionStatusTitle,
                TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) as inspectionLeadName
                FROM inspectiontask it
                LEFT JOIN inspectionstatus ist ON it.status = ist.inspectionstatusid
                LEFT JOIN users u ON it.inspectionlead = u.userid
                WHERE it.itemid = ?
                ORDER BY it.entrydate DESC";
        $tasks = $this->db->select($sql, [$itemId]);
        
        // Transform to match expected structure and get team members
        foreach ($tasks as &$task) {
            $task['inspectionStatus'] = ['title' => $task['inspectionStatusTitle'] ?? 'N/A'];
            $task['inspectionLead'] = [
                'surname' => '',
                'firstname' => $task['inspectionLeadName'] ?? 'N/A',
                'middlename' => ''
            ];
            
            // Get team members for this task
            $teamSql = "SELECT itt.*, 
                        TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) as userName
                        FROM inspectionteam itt
                        LEFT JOIN users u ON itt.userid = u.userid
                        WHERE itt.inspectiontaskid = ?";
            $team = $this->db->select($teamSql, [$task['inspectiontaskid']]);
            
            foreach ($team as &$member) {
                $member['user'] = [
                    'surname' => '',
                    'firstname' => $member['userName'] ?? 'N/A',
                    'middlename' => ''
                ];
            }
            $task['inspectionTaskTeam'] = $team;
        }
        return $tasks;
    }

    private function getItemBids($itemId) {
        $sql = "SELECT ib.*, 
                TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) as bidderName
                FROM itembids ib
                LEFT JOIN users u ON ib.bidderid = u.userid
                WHERE ib.itemid = ?
                ORDER BY ib.entrydate DESC";
        $bids = $this->db->select($sql, [$itemId]);
        
        // Transform to match expected structure
        foreach ($bids as &$bid) {
            $bid['bidder'] = [
                'surname' => '',
                'firstname' => $bid['bidderName'] ?? 'N/A',
                'middlename' => ''
            ];
        }
        return $bids;
    }

    // ============ Save Item Extras Methods ============
    /**
     * Save item profiles for a given item
     */
    public function saveItemProfiles($itemId, $profiles) {
        try {
            if (!$itemId) {
                return ['success' => false, 'message' => 'Invalid item'];
            }

            // Normalize profiles array and collect option IDs
            $rows = [];
            $optionIds = [];
            foreach ($profiles as $p) {
                $optId = isset($p['profileoptionid']) ? (int)$p['profileoptionid'] : 0;
                if ($optId <= 0) { continue; }
                $optionIds[] = $optId;
                $rows[] = [
                    'profileoptionid' => $optId,
                    'quantity' => is_numeric($p['quantity'] ?? null) ? (float)$p['quantity'] : 0,
                    'unitrate' => is_numeric($p['unitrate'] ?? null) ? (float)$p['unitrate'] : 0,
                ];
            }
            if (empty($rows)) {
                return ['success' => false, 'message' => 'No valid profile rows'];
            }

            // Fetch titles for profile options
            $titles = [];
            $placeholders = implode(',', array_fill(0, count($optionIds), '?'));
            $params = $optionIds;
            $sql = "SELECT profileoptionid, title FROM itemprofileoptions WHERE profileoptionid IN ($placeholders)";
            $opts = $this->db->select($sql, $params);
            foreach ($opts as $o) {
                $titles[(int)$o['profileoptionid']] = $o['title'] ?? '';
            }

            // Insert each profile
            $count = 0;
            foreach ($rows as $r) {
                $payload = [
                    'itemid' => $itemId,
                    'profileoptionid' => $r['profileoptionid'],
                    'quantity' => $r['quantity'],
                    'unitrate' => $r['unitrate'],
                    'companyid' => $this->companyId,
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

            // Preload doc type titles
            $ids = [];
            foreach ($docs as $d) {
                if (!empty($d['itemdoctypeid'])) $ids[] = (int)$d['itemdoctypeid'];
            }
            $titles = [];
            if (!empty($ids)) {
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $sql = "SELECT itemdoctypeid, title FROM itemdoctype WHERE itemdoctypeid IN ($placeholders)";
                $rows = $this->db->select($sql, $ids);
                foreach ($rows as $r) $titles[(int)$r['itemdoctypeid']] = $r['title'] ?? '';
            }

            $count = 0;
            foreach ($docs as $row) {
                $itemdoctypeid = isset($row['itemdoctypeid']) ? (int)$row['itemdoctypeid'] : null;
                $docstatus = isset($row['docstatus']) ? (int)$row['docstatus'] : 1;
                
                // Handle file upload (uses documents/ folder for itemdocs.docurl)
                $docUrl = null;
                if (!empty($row['__file']) && is_array($row['__file'])) {
                    $file = $row['__file'];
                    if (!empty($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {
                        $result = $this->uploadFile($file, 'documents');
                        // $result = uploadFile($file, 'documents');
                        if ($result['success']) {
                            // Store only filename, not full path
                            $docUrl = $result['path'];
                        }
                    }
                }

                $payload = [
                    'itemid' => $itemId,
                    'itemdoctypeid' => $itemdoctypeid,
                    'docurl' => $docUrl,
                    'uploadby' => Auth::id(),
                    'entrydate' => date('Y-m-d H:i:s'),
                    'docstatus' => $docstatus,
                    'companyid' => $this->companyId,
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
            $count = 0;
            foreach ($pics as $row) {
                $pictitle = trim($row['pictitle'] ?? '');
                $picstatus = isset($row['picstatus']) ? (int)$row['picstatus'] : 1;

                // Upload image (uses pictures/ folder for itempics.picurl)
                $picUrl = null;
                if (!empty($row['__file']) && is_array($row['__file'])) {
                    $file = $row['__file'];
                        $result = $this->uploadFile($file, 'pictures');
                        if ($result['success']) {
                            // Store only filename, not full path
                            $picUrl = $result['path'];
                        }
                }

                $payload = [
                    'itemid' => $itemId,
                    'pictitle' => $pictitle,
                    'picurl' => $picUrl,
                    'picstatus' => $picstatus,
                    'uploadby' => Auth::id(),
                    'entrydate' => date('Y-m-d H:i:s'),
                    'companyid' => $this->companyId,
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
     * Save project layout rows into `subitem` table
     */
    public function saveProjectLayout($itemId, $layouts) {
        try {
            if (!$itemId) return ['success' => false, 'message' => 'Invalid item'];
            if (empty($layouts) || !is_array($layouts)) return ['success' => false, 'message' => 'No layouts submitted'];

            $count = 0;
            foreach ($layouts as $row) {
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
                    'companyid' => $this->companyId,
                ];
                $payload = $this->withCreateAudit($payload);
                $this->db->insert('subitem', $payload);
                $count++;
            }
            return ['success' => true, 'count' => $count];
        } catch (Exception $e) {
            Logger::error('Save Project Layout failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Save layout failed'];
        }
    }

    // ==================== DOCUMENT CRUD ====================
    
    public function createDocument($data) {
        try {
            $data['companyid'] = $this->companyId;
            $data = $this->withCreateAudit($data);
            
            $docId = $this->db->insert('itemdocs', $data);
            
            return [
                'success' => true,
                'document' => array_merge($data, ['itemdocid' => $docId])
            ];
        } catch (Exception $e) {
            Logger::error('Create document failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create document'];
        }
    }
    
    public function getDocument($docId) {
        $docs = $this->db->select(
            "SELECT d.*, dt.title as itemDocTypeTitle 
             FROM itemdocs d 
             LEFT JOIN itemdoctypes dt ON d.itemdoctypeid = dt.itemdoctypeid 
             WHERE d.itemdocid = ? AND d.isdeleted = ?",
            [$docId, self::NOT_DELETED]
        );
        return $docs ? $docs[0] : null;
    }
    
    public function updateDocument($docId, $data) {
        try {
            $data = array_filter($data, function($value) {
                return $value !== null && $value !== '';
            });
            
            if (empty($data)) {
                return ['success' => false, 'message' => 'No data to update'];
            }
            
            $data = $this->withUpdateAudit($data);
            
            $this->db->update('itemdocs', $data, ['itemdocid' => $docId]);
            
            return ['success' => true];
        } catch (Exception $e) {
            Logger::error('Update document failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update document'];
        }
    }
    
    public function deleteDocument($docId) {
        try {
            $this->db->update('itemdocs', ['isdeleted' => self::IS_DELETED], ['itemdocid' => $docId]);
            return ['success' => true];
        } catch (Exception $e) {
            Logger::error('Delete document failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete document'];
        }
    }
    
    public function getProjectDocuments($itemId) {
        return $this->db->select(
            "SELECT d.*, dt.title as itemDocTypeTitle 
             FROM itemdocs d 
             LEFT JOIN itemdoctypes dt ON d.itemdoctypeid = dt.itemdoctypeid 
             WHERE d.itemid = ? AND d.isdeleted = ? 
             ORDER BY d.entrydate DESC",
            [$itemId, self::NOT_DELETED]
        );
    }
    
    // ==================== IMAGE CRUD ====================
    
    public function createImage($data) {
        try {
            $data['companyid'] = $this->companyId;
            $data = $this->withCreateAudit($data);
            
            $picId = $this->db->insert('itempics', $data);
            
            return [
                'success' => true,
                'image' => array_merge($data, ['itempicid' => $picId])
            ];
        } catch (Exception $e) {
            Logger::error('Create image failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create image'];
        }
    }
    
    public function getImage($picId) {
        $pics = $this->db->select(
            "SELECT * FROM itempics WHERE itempicid = ? AND isdeleted = ?",
            [$picId, self::NOT_DELETED]
        );
        return $pics ? $pics[0] : null;
    }
    
    public function updateImage($picId, $data) {
        try {
            $data = array_filter($data, function($value) {
                return $value !== null && $value !== '';
            });
            
            if (empty($data)) {
                return ['success' => false, 'message' => 'No data to update'];
            }
            
            $data = $this->withUpdateAudit($data);
            
            $this->db->update('itempics', $data, ['itempicid' => $picId]);
            
            return ['success' => true];
        } catch (Exception $e) {
            Logger::error('Update image failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update image'];
        }
    }
    
    public function deleteImage($picId) {
        try {
            $this->db->update('itempics', ['isdeleted' => self::IS_DELETED], ['itempicid' => $picId]);
            return ['success' => true];
        } catch (Exception $e) {
            Logger::error('Delete image failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete image'];
        }
    }
    
    public function getProjectImages($itemId) {
        $images = $this->db->select(
            "SELECT * FROM itempics WHERE itemid = ? AND isdeleted = ? ORDER BY entrydate DESC",
            [$itemId, self::NOT_DELETED]
        );
        
        // Add full image URLs
        foreach ($images as &$image) {
            if (!empty($image['picurl'])) {
                $image['picurl'] = Helpers::imageUrl($image['picurl']);
            }
        }
        
        return $images;
    }
    
    /**
     * Get all inspections for a project
     */
    public function getProjectInspections($itemId) {
        $inspections = $this->db->select(
            "SELECT 
                i.*,
                u.firstname,
                u.lastname,
                CONCAT(u.firstname, ' ', u.lastname) as inspectorname,
                t.tasktitle,
                CASE 
                    WHEN i.inspectionstatus = 1 THEN 'Approved'
                    WHEN i.inspectionstatus = 0 THEN 'Pending'
                    WHEN i.inspectionstatus = -1 THEN 'Rejected'
                    ELSE 'Unknown'
                END as statustext
            FROM iteminspections i
            LEFT JOIN users u ON i.inspectorid = u.userid
            LEFT JOIN inspectiontasks t ON i.inspectiontaskid = t.inspectiontaskid
            WHERE i.itemid = ? AND i.isdeleted = ?
            ORDER BY i.inspectiondate DESC",
            [$itemId, self::NOT_DELETED]
        );
        
        return $inspections;
    }
    
    /**
     * Get all investor bids for a project
     */
    public function getProjectInvestors($itemId) {
        $investors = $this->db->select(
            "SELECT 
                b.*,
                u.firstname,
                u.lastname,
                CONCAT(u.firstname, ' ', u.lastname) as investorname,
                CASE 
                    WHEN b.bidstatus = 1 THEN 'Accepted'
                    WHEN b.bidstatus = 0 THEN 'Pending'
                    WHEN b.bidstatus = -1 THEN 'Rejected'
                    ELSE 'Unknown'
                END as statustext
            FROM itembids b
            LEFT JOIN users u ON b.userid = u.userid
            WHERE b.itemid = ? AND b.isdeleted = ?
            ORDER BY b.biddate DESC",
            [$itemId, self::NOT_DELETED]
        );
        
        return $investors;
    }
}
