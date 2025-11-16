<?php
class OfferService {
    use AuditFields;

    private $db;
    const IS_DELETED = -1;
    const NOT_DELETED = 0;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    private function buildWhereAndParams($filters, $serviceTypeIds, $itemStatusIn = [10, 15], $statusMode = 'in') {
        $where = [
            'ib.isdeleted = ?'
        ];
        $params = [self::NOT_DELETED];

        // Service types filter via items
        if (!empty($serviceTypeIds)) {
            $placeholders = implode(',', array_fill(0, count($serviceTypeIds), '?'));
            $where[] = "i.servicetypeid IN ($placeholders)";
            $params = array_merge($params, $serviceTypeIds);
        }

        // Item status in or not in
        if (!empty($itemStatusIn)) {
            $placeholders = implode(',', array_fill(0, count($itemStatusIn), '?'));
            if ($statusMode === 'in') {
                $where[] = "i.itemstatusid IN ($placeholders)";
            } else {
                $where[] = "i.itemstatusid NOT IN ($placeholders)";
            }
            $params = array_merge($params, $itemStatusIn);
        }

        // Apply filters
        if (!empty($filters['transaction_type'])) {
            $where[] = 'i.bidtypeid = ?';
            $params[] = $filters['transaction_type'];
        }

        if (!empty($filters['email'])) {
            $where[] = 'LOWER(ib.bidderemail) LIKE ?';
            $params[] = '%' . strtolower($filters['email']) . '%';
        }

        if (!empty($filters['phone'])) {
            $where[] = 'ib.bidderphone LIKE ?';
            $params[] = '%' . $filters['phone'] . '%';
        }

        if (!empty($filters['status']) || $filters['status'] === '0') {
            $where[] = 'ib.status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['offerdate'])) {
            $where[] = 'DATE(ib.entrydate) = ?';
            $params[] = $filters['offerdate'];
        }

        if (!empty($filters['attorney'])) {
            $where[] = 'ib.attorneyid = ?';
            $params[] = $filters['attorney'];
        }

        return [implode(' AND ', $where), $params];
    }

    private function mapOfferRow($row) {
        return [
            'itembidid' => $row['itembidid'] ?? null,
            'itemid' => $row['itemid'] ?? null,
            'biddername' => $row['biddername'] ?? null,
            'bidderemail' => $row['bidderemail'] ?? null,
            'bidderphone' => $row['bidderphone'] ?? null,
            'proposedamount' => $row['proposedamount'] ?? null,
            'note' => $row['note'] ?? null,
            'status' => $row['ib_status'] ?? null,
            'serviceduration' => $row['serviceduration'] ?? null,
            'paymentterms' => $row['paymentterms'] ?? null,
            'entrydate' => $row['entrydate'] ?? null,
            'attorneyid' => $row['attorneyid'] ?? null,
            'attorney' => [
                'firstname' => $row['attorney_firstname'] ?? null,
                'lastname' => $row['attorney_lastname'] ?? null,
            ],
            'item' => [
                'itemid' => $row['itemid'] ?? null,
                'title' => $row['item_title'] ?? null,
                'bidType' => [
                    'options' => $row['bidtype_options'] ?? null,
                ],
                'itemStatus' => [
                    'title' => $row['itemstatus_title'] ?? null,
                ],
                'currency' => [
                    'symbol' => $row['currency_symbol'] ?? null,
                ],
            ],
        ];
    }

    private function fetchOffers($filters, $page, $perPage, $serviceTypeIds, $statusMode) {
        list($where, $params) = $this->buildWhereAndParams(
            $filters,
            $serviceTypeIds,
            [10, 15],
            $statusMode
        );

        // Count
        $countSql = "
            SELECT COUNT(*) as total
            FROM itembids ib
            LEFT JOIN items i ON ib.itemid = i.itemid
            WHERE $where
        ";
        $count = $this->db->select($countSql, $params);
        $total = $count[0]['total'] ?? 0;

        // Data
        $offset = ($page - 1) * $perPage;
        $dataSql = "
            SELECT
                ib.*,
                ib.status as ib_status,
                i.title as item_title,
                i.itemid as itemid,
                bt.options as bidtype_options,
                ist.title as itemstatus_title,
                cur.currencysymbol as currency_symbol,
                u.firstname as attorney_firstname,
                u.surname as attorney_lastname
            FROM itembids ib
            LEFT JOIN items i ON ib.itemid = i.itemid
            LEFT JOIN bidtype bt ON i.bidtypeid = bt.bidtypeid
            LEFT JOIN itemstatus ist ON i.itemstatusid = ist.itemstatusid
            LEFT JOIN currency cur ON i.currencyid = cur.currencyid
            LEFT JOIN users u ON ib.attorneyid = u.userid
            WHERE $where
            ORDER BY ib.entrydate DESC
            LIMIT ? OFFSET ?
        ";

        $dataParams = $params;
        $dataParams[] = $perPage;
        $dataParams[] = $offset;
        $rows = $this->db->select($dataSql, $dataParams);

        $mapped = array_map([$this, 'mapOfferRow'], $rows);

        return [
            'data' => $mapped,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => max(1, (int)ceil($total / $perPage)),
        ];
    }

    public function getActiveProperties($filters = [], $page = 1, $perPage = 10) {
        return $this->fetchOffers($filters, $page, $perPage, [1, 2], 'in');
    }

    public function getClosedProperties($filters = [], $page = 1, $perPage = 10) {
        return $this->fetchOffers($filters, $page, $perPage, [1, 2], 'not-in');
    }

    public function getActiveProjects($filters = [], $page = 1, $perPage = 10) {
        return $this->fetchOffers($filters, $page, $perPage, [3, 4], 'in');
    }

    public function getClosedProjects($filters = [], $page = 1, $perPage = 10) {
        return $this->fetchOffers($filters, $page, $perPage, [3, 4], 'not-in');
    }

    public function getBidTypes() {
        return $this->db->select(
            "SELECT * FROM bidtype WHERE isdeleted = ? ORDER BY options ASC",
            [self::NOT_DELETED]
        );
    }

    public function getAttorneys() {
        return $this->db->select(
            "SELECT * FROM users WHERE isdeleted = ? AND usertypeid = 2 ORDER BY surname ASC",
            [self::NOT_DELETED]
        );
    }

    public function getItemBidDetail($itemBidId) {
        // Fetch a single offer with rich item details
        $sql = "
            SELECT
                ib.*, ib.status as ib_status,
                i.itemid, i.title as item_title, i.address, i.price, i.priceunit, i.geolatitude, i.geolongitude,
                bt.bidtypeid as item_bidtypeid, bt.options as bidtype_options,
                ist.itemstatusid as item_itemstatusid, ist.title as itemstatus_title,
                cur.currencysymbol as currency_symbol,
                att.userid as attorney_userid, att.firstname as attorney_firstname, att.surname as attorney_lastname, att.middlename as attorney_middlename, att.phone as attorney_phone, att.email as attorney_email,
                sel.userid as seller_userid, sel.firstname as seller_firstname, sel.surname as seller_lastname, sel.middlename as seller_middlename, sel.phone as seller_phone, sel.email as seller_email
            FROM itembids ib
            LEFT JOIN items i ON ib.itemid = i.itemid
            LEFT JOIN bidtype bt ON i.bidtypeid = bt.bidtypeid
            LEFT JOIN itemstatus ist ON i.itemstatusid = ist.itemstatusid
            LEFT JOIN currency cur ON i.currencyid = cur.currencyid
            LEFT JOIN users att ON ib.attorneyid = att.userid
            LEFT JOIN users sel ON i.sellerid = sel.userid
            WHERE ib.itembidid = ? AND ib.isdeleted = ?
            LIMIT 1
        ";
        $rows = $this->db->select($sql, [$itemBidId, self::NOT_DELETED]);
        if (empty($rows)) { return null; }

        $row = $rows[0];
        // Map to structure expected by the property detail view
        $property = [
            'itemid' => $row['itemid'] ?? null,
            'title' => $row['item_title'] ?? null,
            'address' => $row['address'] ?? null,
            'price' => $row['price'] ?? null,
            'priceunit' => $row['priceunit'] ?? null,
            'geolatitude' => $row['geolatitude'] ?? null,
            'geolongitude' => $row['geolongitude'] ?? null,
            'itemstatusid' => $row['item_itemstatusid'] ?? null,
            'itemStatus' => [
                'title' => $row['itemstatus_title'] ?? null,
            ],
            'bidType' => [
                'bidtypeid' => $row['item_bidtypeid'] ?? null,
                'options' => $row['bidtype_options'] ?? null,
            ],
            'currency' => [
                'symbol' => $row['currency_symbol'] ?? null,
            ],
            'seller' => [
                'firstname' => $row['seller_firstname'] ?? null,
                'surname' => $row['seller_lastname'] ?? null,
                'middlename' => $row['seller_middlename'] ?? null,
                'phone' => $row['seller_phone'] ?? null,
                'email' => $row['seller_email'] ?? null,
            ],
            'attorney' => [
                'firstname' => $row['attorney_firstname'] ?? null,
                'surname' => $row['attorney_lastname'] ?? null,
                'middlename' => $row['attorney_middlename'] ?? null,
                'phone' => $row['attorney_phone'] ?? null,
                'email' => $row['attorney_email'] ?? null,
            ],
            // From the bid row
            'proposedamount' => $row['proposedamount'] ?? null,
            'paymentterms' => $row['paymentterms'] ?? null,
            'serviceduration' => $row['serviceduration'] ?? null,
            'note' => $row['note'] ?? null,
            'itembidid' => $row['itembidid'] ?? null,
        ];

        // Load collections for the item
        if (!empty($property['itemid'])) {
            $itemId = $property['itemid'];
            
            // Load itemProfiles
            $profiles = $this->db->select(
                "SELECT ip.*, po.title as profile_option_title 
                FROM itemprofiles ip 
                LEFT JOIN itemprofileoptions po ON ip.profileoptionid = po.itemprofileoptionid 
                WHERE ip.itemid = ? AND ip.isdeleted = ? 
                ORDER BY ip.entrydate DESC",
                [$itemId, self::NOT_DELETED]
            );
            $property['itemProfiles'] = array_map(function($p){
                return [
                    'itemprofileid' => $p['itemprofileid'] ?? null,
                    'profilevalue' => $p['profilevalue'] ?? null,
                    'basevalue' => $p['basevalue'] ?? null,
                    'showuser' => $p['showuser'] ?? null,
                    'profileOption' => [
                        'title' => $p['profile_option_title'] ?? null,
                    ],
                ];
            }, $profiles);
            
            // Load itemPics
            $pics = $this->db->select(
                "SELECT ip.* FROM itempics ip 
                WHERE ip.itemid = ? AND ip.isdeleted = ? 
                ORDER BY ip.entrydate DESC",
                [$itemId, self::NOT_DELETED]
            );
            $property['itemPics'] = array_map(function($p){
                return [
                    'itempicid' => $p['itempicid'] ?? null,
                    'picurl' => $p['picurl'] ?? null,
                    'pictitle' => $p['pictitle'] ?? null,
                ];
            }, $pics);
            
            // Load itemDocs
            $docs = $this->db->select(
                "SELECT id.*, dt.title as doc_type_title 
                FROM itemdocs id 
                LEFT JOIN itemdoctypes dt ON id.itemdoctypeid = dt.itemdoctypeid 
                WHERE id.itemid = ? AND id.isdeleted = ? 
                ORDER BY id.entrydate DESC",
                [$itemId, self::NOT_DELETED]
            );
            $property['itemDocs'] = array_map(function($d){
                return [
                    'itemdocid' => $d['itemdocid'] ?? null,
                    'docurl' => $d['docurl'] ?? null,
                    'docstatus' => $d['docstatus'] ?? null,
                    'itemDocType' => [
                        'title' => $d['doc_type_title'] ?? null,
                    ],
                ];
            }, $docs);
            
            // Load itemInspections (inspectiontask)
            $inspections = $this->db->select(
                "SELECT it.*, 
                    ist.title as status_title,
                    u.firstname as inspector_firstname, 
                    u.surname as inspector_surname, 
                    u.middlename as inspector_middlename,
                    u.phone as inspector_phone, 
                    u.email as inspector_email 
                FROM inspectiontask it 
                LEFT JOIN inspectionstatus ist ON it.status = ist.inspectionstatusid
                LEFT JOIN users u ON it.inspectionlead = u.userid 
                WHERE it.itemid = ? AND it.isdeleted = ? 
                ORDER BY it.entrydate DESC",
                [$itemId, self::NOT_DELETED]
            );
            $property['itemInspections'] = array_map(function($i){
                return [
                    'inspectiontaskid' => $i['inspectiontaskid'] ?? null,
                    'inspectiondate' => $i['startdate'] ?? null,
                    'note' => $i['note'] ?? null,
                    'supervisornote' => $i['supervisornote'] ?? null,
                    'statusid' => $i['status'] ?? null,
                    'status' => $i['status_title'] ?? null,
                    'inspectby' => [
                        'firstname' => $i['inspector_firstname'] ?? null,
                        'surname' => $i['inspector_surname'] ?? null,
                        'middlename' => $i['inspector_middlename'] ?? null,
                        'phone' => $i['inspector_phone'] ?? null,
                        'email' => $i['inspector_email'] ?? null,
                    ],
                    // Additional fields from view
                    'address' => null,
                    'landmark' => null,
                    'contactperson' => null,
                    'chartinginfo' => null,
                    'titleverified' => null,
                    'geolocation' => null,
                ];
            }, $inspections);
            
            // Load all bids for the item to populate Offers table
            $bids = $this->db->select(
                "SELECT ib.* FROM itembids ib WHERE ib.itemid = ? AND ib.isdeleted = ? ORDER BY ib.entrydate DESC",
                [$itemId, self::NOT_DELETED]
            );
            $property['itemBids'] = array_map(function($b){
                return [
                    'itembidid' => $b['itembidid'] ?? null,
                    'note' => $b['note'] ?? null,
                    'proposedamount' => $b['proposedamount'] ?? null,
                    'serviceduration' => $b['serviceduration'] ?? null,
                    'paymentterms' => $b['paymentterms'] ?? null,
                    'status' => $b['status'] ?? null,
                    'bidder' => [
                        'firstname' => $b['biddername'] ?? null,
                        'surname' => null,
                        'middlename' => null,
                        'phone' => $b['bidderphone'] ?? null,
                        'email' => $b['bidderemail'] ?? null,
                    ],
                ];
            }, $bids);
        } else {
            // Initialize empty arrays if no itemid
            $property['itemProfiles'] = [];
            $property['itemPics'] = [];
            $property['itemDocs'] = [];
            $property['itemInspections'] = [];
            $property['itemBids'] = [];
        }

        return $property;
    }
}
