<?php
class DashboardService {
    private $db;
    private $companyId = 1;
    private $propertyServiceTypeId = 2;
    private $projectServiceTypeId = 4;

    public function __construct() {
        $this->db = Database::getInstance();
        try {
            $this->companyId = Auth::companyId();
        } catch (Exception $e) {
            $this->companyId = 1; // Default company ID
        }
    }

    /**
     * Get the main summary statistics for properties.
     */
    public function getPropertySummary() {
        return $this->getSummary($this->propertyServiceTypeId, 'properties');
    }

    /**
     * Get the main summary statistics for projects.
     */
    public function getProjectSummary() {
        return $this->getSummary($this->projectServiceTypeId, 'projects');
    }

    /**
     * Generic summary method for both properties and projects.
     */
    private function getSummary($serviceTypeId, $prefix) {
        $baseCondition = "companyid = {$this->companyId} 
                         AND servicetypeid = {$serviceTypeId} 
                         AND isdeleted != -1";

        // Pending (itemstatusid <= 1 AND ifnull(inspectionstatusid,0) in (0,1))
        $pending = $this->db->selectOne("
            SELECT count(itemid) as totalnumber, sum(price) as totalamount 
            FROM items 
            WHERE {$baseCondition} 
            AND itemstatusid <= 1 
            AND IFNULL(inspectionstatusid, 0) IN (0, 1)
        ");
        $pending = $pending ? (object)$pending : (object)['totalnumber' => 0, 'totalamount' => 0];

        // Awaiting Inspections (itemstatusid in (2,3) AND inspectionstatusid in (0,3))
        $awaiting = $this->db->selectOne("
            SELECT count(itemid) as totalnumber, sum(price) as totalamount 
            FROM items 
            WHERE {$baseCondition} 
            AND itemstatusid IN (2, 3) 
            AND inspectionstatusid IN (0, 3)
        ");
        $awaiting = $awaiting ? (object)$awaiting : (object)['totalnumber' => 0, 'totalamount' => 0];

        // Concluded - different logic for properties vs projects
        if ($serviceTypeId == $this->propertyServiceTypeId) {
            // Properties: itemstatusid in (2,3) AND inspectionstatusid = 2
            $concluded = $this->db->selectOne("
                SELECT count(itemid) as totalnumber, sum(price) as totalamount 
                FROM items 
                WHERE {$baseCondition} 
                AND itemstatusid IN (2, 3) 
                AND inspectionstatusid = 2
            ");
        } else {
            // Projects: itemstatusid = 3 AND inspectionstatusid = 2
            $concluded = $this->db->selectOne("
                SELECT count(itemid) as totalnumber, sum(price) as totalamount 
                FROM items 
                WHERE {$baseCondition} 
                AND itemstatusid = 3 
                AND inspectionstatusid = 2
            ");
        }
        $concluded = $concluded ? (object)$concluded : (object)['totalnumber' => 0, 'totalamount' => 0];

        // Rejected - different logic for properties vs projects
        if ($serviceTypeId == $this->propertyServiceTypeId) {
            // Properties: itemstatusid = 5
            $rejected = $this->db->selectOne("
                SELECT count(itemid) as totalnumber, sum(price) as totalamount 
                FROM items 
                WHERE {$baseCondition} 
                AND itemstatusid = 5
            ");
        } else {
            // Projects: itemstatusid = 5 AND inspectionstatusid = 5
            $rejected = $this->db->selectOne("
                SELECT count(itemid) as totalnumber, sum(price) as totalamount 
                FROM items 
                WHERE {$baseCondition} 
                AND itemstatusid = 5 
                AND inspectionstatusid = 5
            ");
        }
        $rejected = $rejected ? (object)$rejected : (object)['totalnumber' => 0, 'totalamount' => 0];

        // Approved (itemstatusid = 4 AND inspectionstatusid = 4)
        $approved = $this->db->selectOne("
            SELECT count(itemid) as totalnumber, sum(price) as totalamount 
            FROM items 
            WHERE {$baseCondition} 
            AND itemstatusid = 4 
            AND inspectionstatusid = 4
        ");
        $approved = $approved ? (object)$approved : (object)['totalnumber' => 0, 'totalamount' => 0];

        // Awaiting Listing (itemstatusid = 9)
        $awaitingListing = $this->db->selectOne("
            SELECT count(itemid) as totalnumber, sum(price) as totalamount 
            FROM items 
            WHERE {$baseCondition} 
            AND itemstatusid = 9
        ");
        $awaitingListing = $awaitingListing ? (object)$awaitingListing : (object)['totalnumber' => 0, 'totalamount' => 0];

        // Listed (itemstatusid = 10)
        $listed = $this->db->selectOne("
            SELECT count(itemid) as totalnumber, sum(price) as totalamount 
            FROM items 
            WHERE {$baseCondition} 
            AND itemstatusid = 10
        ");
        $listed = $listed ? (object)$listed : (object)['totalnumber' => 0, 'totalamount' => 0];

        // Closed (itemstatusid = 20)
        $closed = $this->db->selectOne("
            SELECT count(itemid) as totalnumber, sum(price) as totalamount 
            FROM items 
            WHERE {$baseCondition} 
            AND itemstatusid = 20
        ");
        $closed = $closed ? (object)$closed : (object)['totalnumber' => 0, 'totalamount' => 0];

        return [
            "pending{$prefix}" => $pending,
            "awaiting{$prefix}" => $awaiting,
            "concludedinsp{$prefix}" => $concluded,
            "rejected{$prefix}" => $rejected,
            "approved{$prefix}" => $approved,
            "awaitinglisting{$prefix}" => $awaitingListing,
            "listed{$prefix}" => $listed,
            "closed{$prefix}" => $closed,
        ];
    }

    /**
     * Get recent properties (Active Offers, Pending, Awaiting Inspection).
     */
    public function getRecentProperties() {
        return $this->getRecentItems($this->propertyServiceTypeId);
    }

    /**
     * Get recent projects.
     */
    public function getRecentProjects() {
        return $this->getRecentItems($this->projectServiceTypeId);
    }

    /**
     * Generic method to get recent items for a service type.
     */
    private function getRecentItems($serviceTypeId) {
        // Active Offers (itemstatusid = 10)
        $offers = $this->db->select("
            SELECT i.*, 
                   COUNT(ib.itemid) as bidcount, 
                   AVG(ib.proposedamount) as averageoffer,
                   (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
                   (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
                   (SELECT b.options FROM bidtype b WHERE b.bidtypeid = i.bidtypeid AND b.companyid = i.companyid LIMIT 1) as bidtype
            FROM items i
            RIGHT JOIN itembids ib ON i.companyid = ib.companyid AND i.itemid = ib.itemid
            WHERE i.companyid = {$this->companyId}
            AND i.isdeleted != -1
            AND i.servicetypeid = {$serviceTypeId}
            AND i.itemstatusid = 10
            GROUP BY i.itemid
            ORDER BY i.entrydate DESC
            LIMIT 4
        ");

        // Recent Pending (itemstatusid <= 1)
        $recentPending = $this->db->select("
            SELECT i.*,
                   (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
                   (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
                   (SELECT it.startdate FROM inspectiontask it WHERE it.itemid = i.itemid ORDER BY it.inspectiontaskid DESC LIMIT 1) as inspectionstartdate,
                   (SELECT TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) FROM inspectiontask it1 JOIN users u ON it1.inspectionlead=u.userid WHERE it1.itemid = i.itemid ORDER BY it1.inspectiontaskid DESC LIMIT 1) as inspectionlead,
                   (SELECT b.options FROM bidtype b WHERE b.bidtypeid = i.bidtypeid AND b.companyid = i.companyid AND b.serviceid = i.servicetypeid LIMIT 1) as bidtype
            FROM items i
            WHERE i.companyid = {$this->companyId}
            AND i.servicetypeid = {$serviceTypeId}
            AND i.isdeleted != -1
            AND i.itemstatusid <= 1
            ORDER BY i.entrydate DESC
            LIMIT 4
        ");

        // Recent Awaiting Inspection (itemstatusid in (2,3) AND inspectionstatusid in (0,3))
        $recentAwaiting = $this->db->select("
            SELECT i.*,
                   (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
                   (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
                   (SELECT it.startdate FROM inspectiontask it WHERE it.itemid = i.itemid ORDER BY it.inspectiontaskid DESC LIMIT 1) as inspectionstartdate,
                   (SELECT TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) FROM inspectiontask it1 JOIN users u ON it1.inspectionlead=u.userid WHERE it1.itemid = i.itemid ORDER BY it1.inspectiontaskid DESC LIMIT 1) as inspectionlead,
                   (SELECT b.options FROM bidtype b WHERE b.bidtypeid = i.bidtypeid AND b.companyid = i.companyid AND b.serviceid = i.servicetypeid LIMIT 1) as bidtype
            FROM items i
            WHERE i.companyid = {$this->companyId}
            AND i.servicetypeid = {$serviceTypeId}
            AND i.isdeleted != -1
            AND i.itemstatusid IN (2, 3)
            AND i.inspectionstatusid IN (0, 3)
            ORDER BY i.entrydate DESC
            LIMIT 4
        ");

        // Recent Under Inspection (itemstatusid = 3 AND inspectionstatusid = 1)
        $recentUnderInsp = $this->db->select("
            SELECT i.*,
                   (SELECT p.picurl FROM itempics p WHERE p.itemid = i.itemid ORDER BY p.itempicid LIMIT 1) as picurl,
                   (SELECT pp.pictitle FROM itempics pp WHERE pp.itemid = i.itemid ORDER BY pp.itempicid LIMIT 1) as pictitle,
                   (SELECT it.startdate FROM inspectiontask it WHERE it.itemid = i.itemid ORDER BY it.inspectiontaskid DESC LIMIT 1) as inspectionstartdate,
                   (SELECT TRIM(CONCAT(u.surname,' ',u.firstname,' ',u.middlename)) FROM inspectiontask it1 JOIN users u ON it1.inspectionlead=u.userid WHERE it1.itemid = i.itemid ORDER BY it1.inspectiontaskid DESC LIMIT 1) as inspectionlead,
                   (SELECT b.options FROM bidtype b WHERE b.bidtypeid = i.bidtypeid AND b.companyid = i.companyid AND b.serviceid = i.servicetypeid LIMIT 1) as bidtype
            FROM items i
            WHERE i.companyid = {$this->companyId}
            AND i.servicetypeid = {$serviceTypeId}
            AND i.isdeleted != -1
            AND i.itemstatusid = 3
            AND i.inspectionstatusid = 1
            ORDER BY i.entrydate DESC
            LIMIT 4
        ");

        return [
            'offers' => $offers,
            'recentPending' => $recentPending,
            'recentAwaiting' => $recentAwaiting,
            'recentUnderInsp' => $recentUnderInsp,
        ];
    }
}
