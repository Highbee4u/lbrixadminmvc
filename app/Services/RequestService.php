<?php
class RequestService {
    use AuditFields;

    private $db;
    private $companyId;
    const IS_DELETED = -1;
    const NOT_DELETED = 0;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->companyId = Auth::companyId();
    }

    /**
     * Paginate helper
     */
    private function paginate($baseSql, $countSql, $params, $page = 1, $perPage = 12) {
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

    /**
     * Get property requests (servicetypeid 1 or 2) with requeststatus = 0
     */
    public function getPropertyRequests($page = 1, $perPage = 12) {
        $conditions = [
            'ir.isdeleted = ?',
            'ir.companyid = ?',
            'ir.requeststatus = ?',
            'ir.servicetypeid IN (1, 2)'
        ];
        $params = [self::NOT_DELETED, $this->companyId, 0];
        $where = implode(' AND ', $conditions);

        $baseSql = "
            SELECT 
                ir.*,
                i.title as item_title,
                i.address as item_address,
                i.price as item_price,
                bt.options as bidtype_title,
                it.title as itemtype_title,
                pt.title as projecttype_title,
                io.title as investoption_title,
                s.state as state_title,
                c.country as country_title
            FROM itemsrequest ir
            LEFT JOIN items i ON ir.itemid = i.itemid
            LEFT JOIN bidtype bt ON ir.bidtypeid = bt.bidtypeid
            LEFT JOIN itemtypes it ON ir.itemtypeid = it.itemtypeid
            LEFT JOIN projecttypes pt ON ir.projecttypeid = pt.projecttypeid
            LEFT JOIN investoptions io ON ir.investoptionid = io.investoptionid
            LEFT JOIN states s ON ir.stateid = s.stateid
            LEFT JOIN countries c ON ir.countryid = c.countryid
            WHERE $where
            ORDER BY ir.entrydate DESC
        ";

        $countSql = "SELECT COUNT(*) as total FROM itemsrequest ir WHERE $where";

        return $this->paginate($baseSql, $countSql, $params, $page, $perPage);
    }

    /**
     * Get investment requests (servicetypeid 3 or 4) with requeststatus = 0
     */
    public function getInvestmentRequests($page = 1, $perPage = 12) {
        $conditions = [
            'ir.isdeleted = ?',
            'ir.companyid = ?',
            'ir.requeststatus = ?',
            'ir.servicetypeid IN (3, 4)'
        ];
        $params = [self::NOT_DELETED, $this->companyId, 0];
        $where = implode(' AND ', $conditions);

        $baseSql = "
            SELECT 
                ir.*,
                i.title as item_title,
                i.address as item_address,
                i.price as item_price,
                bt.options as bidtype_title,
                it.title as itemtype_title,
                pt.title as projecttype_title,
                io.title as investoption_title,
                s.state as state_title,
                c.country as country_title
            FROM itemsrequest ir
            LEFT JOIN items i ON ir.itemid = i.itemid
            LEFT JOIN bidtype bt ON ir.bidtypeid = bt.bidtypeid
            LEFT JOIN itemtypes it ON ir.itemtypeid = it.itemtypeid
            LEFT JOIN projecttypes pt ON ir.projecttypeid = pt.projecttypeid
            LEFT JOIN investoptions io ON ir.investoptionid = io.investoptionid
            LEFT JOIN states s ON ir.stateid = s.stateid
            LEFT JOIN countries c ON ir.countryid = c.countryid
            WHERE $where
            ORDER BY ir.entrydate DESC
        ";

        $countSql = "SELECT COUNT(*) as total FROM itemsrequest ir WHERE $where";

        return $this->paginate($baseSql, $countSql, $params, $page, $perPage);
    }

    /**
     * Get a single property request by ID with all related data
     */
    public function getPropertyRequestById($itemrequestid) {
        $sql = "
            SELECT 
                ir.*,
                i.title as item_title,
                i.address as item_address,
                i.price as item_price,
                i.description as item_description,
                bt.options as bidtype_title,
                it.title as itemtype_title,
                pt.title as projecttype_title,
                io.title as investoption_title,
                s.state as state_title,
                c.country as country_title
            FROM itemsrequest ir
            LEFT JOIN items i ON ir.itemid = i.itemid
            LEFT JOIN bidtype bt ON ir.bidtypeid = bt.bidtypeid
            LEFT JOIN itemtypes it ON ir.itemtypeid = it.itemtypeid
            LEFT JOIN projecttypes pt ON ir.projecttypeid = pt.projecttypeid
            LEFT JOIN investoptions io ON ir.investoptionid = io.investoptionid
            LEFT JOIN states s ON ir.stateid = s.stateid
            LEFT JOIN countries c ON ir.countryid = c.countryid
            WHERE ir.itemsrequestid = ?
                AND ir.companyid = ?
                AND ir.isdeleted = ?
            LIMIT 1
        ";

        $result = $this->db->select($sql, [$itemrequestid, $this->companyId, self::NOT_DELETED]);
        return $result[0] ?? null;
    }

    /**
     * Get a single investment request by ID with all related data
     */
    public function getInvestmentRequestById($itemrequestid) {
        $sql = "
            SELECT 
                ir.*,
                i.title as item_title,
                i.address as item_address,
                i.price as item_price,
                i.description as item_description,
                bt.options as bidtype_title,
                it.title as itemtype_title,
                pt.title as projecttype_title,
                io.title as investoption_title,
                s.state as state_title,
                c.country as country_title
            FROM itemsrequest ir
            LEFT JOIN items i ON ir.itemid = i.itemid
            LEFT JOIN bidtype bt ON ir.bidtypeid = bt.bidtypeid
            LEFT JOIN itemtypes it ON ir.itemtypeid = it.itemtypeid
            LEFT JOIN projecttypes pt ON ir.projecttypeid = pt.projecttypeid
            LEFT JOIN investoptions io ON ir.investoptionid = io.investoptionid
            LEFT JOIN states s ON ir.stateid = s.stateid
            LEFT JOIN countries c ON ir.countryid = c.countryid
            WHERE ir.itemsrequestid = ?
                AND ir.companyid = ?
                AND ir.isdeleted = ?
            LIMIT 1
        ";

        $result = $this->db->select($sql, [$itemrequestid, $this->companyId, self::NOT_DELETED]);
        return $result[0] ?? null;
    }

    /**
     * Update request status
     */
    public function updateRequestStatus($itemrequestid, $status) {
        return $this->db->update(
            'itemsrequest',
            [
                'requeststatus' => $status,
                'updateby' => Auth::id(),
                'updatedate' => date('Y-m-d H:i:s')
            ],
            [
                'itemsrequestid' => $itemrequestid,
                'companyid' => $this->companyId,
                'isdeleted' => self::NOT_DELETED
            ]
        );
    }

    /**
     * Match a property/investment request to an item
     */
    public function matchRequestToItem($itemrequestid, $itemid) {
        return $this->db->update(
            'itemsrequest',
            [
                'itemid' => $itemid,
                'updateby' => Auth::id(),
                'updatedate' => date('Y-m-d H:i:s')
            ],
            [
                'itemsrequestid' => $itemrequestid,
                'companyid' => $this->companyId,
                'isdeleted' => self::NOT_DELETED,
                'requeststatus' => 0
            ]
        );
    }

    /**
     * Unmatch a property/investment request from an item
     */
    public function unmatchRequestFromItem($itemrequestid) {
        return $this->db->update(
            'itemsrequest',
            [
                'itemid' => 0,
                'updateby' => Auth::id(),
                'updatedate' => date('Y-m-d H:i:s')
            ],
            [
                'itemsrequestid' => $itemrequestid,
                'companyid' => $this->companyId,
                'isdeleted' => self::NOT_DELETED,
                'requeststatus' => 0
            ]
        );
    }

    /**
     * Get matching items for a request based on servicetype
     */
    public function getMatchingItems($itemrequestid) {
        // Get the request details
        $request = $this->getPropertyRequestById($itemrequestid);
        if (!$request) {
            $request = $this->getInvestmentRequestById($itemrequestid);
        }
        
        if (!$request) {
            return [];
        }

        // Get matching items based on servicetypeid
        $sql = "
            SELECT 
                i.itemid,
                i.title,
                i.price,
                i.description,
                i.address,
                COALESCE(ip.picurl, 'images/No_image.png') as picurl
            FROM items i
            LEFT JOIN itempics ip ON i.itemid = ip.itemid
            WHERE i.companyid = ?
                AND i.isdeleted = ?
                AND i.servicetypeid = ?
            GROUP BY i.itemid
            ORDER BY i.entrydate DESC
        ";

        return $this->db->select($sql, [
            $this->companyId,
            self::NOT_DELETED,
            $request['servicetypeid']
        ]);
    }
}
