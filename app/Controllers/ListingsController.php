<?php
class ListingsController extends Controller {

    private $listingService;
    private $inspectionService;
    private $setupService;

    public function __construct() {
        parent::__construct();
        $this->listingService = new ListingService();
        $this->inspectionService = new InspectionService();
        $this->setupService = new SetupService();
    }

    public function dashboard() {
        $stats = $this->listingService->dashboardGetStats();
        $recentPending = $this->listingService->dashboardGetRecentPending();
        $recentAwaiting = $this->listingService->dashboardGetRecentAwaiting();
        $offers = $this->listingService->dashboardGetRecentOffers();

        $this->viewWithLayout('listings/dashboard', [
            'title' => 'Listings Dashboard',
            'stats' => $stats,
            'recentPending' => $recentPending,
            'recentAwaiting' => $recentAwaiting,
            'offers' => $offers,
        ]);
    }

    public function newProperties() {
        $request = Request::getInstance();
        $filters = $request->only(['inspection_status', 'itemtype', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        $pendingProperties = $this->listingService->getAllPendingProperties($filters, $page, $perPage);
        $inspectionLeads = $this->inspectionService->getInspectionLeads();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $itemTypes = $this->setupService->getItemTypes();
        $this->viewWithLayout('listings/new-properties', compact('pendingProperties','inspectionLeads','inspectionStatuses','itemTypes'));
    }

    public function awaitingInspection() {
        $request = Request::getInstance();
        $filters = $request->only(['itemtype', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        $awaitingInspections = $this->listingService->getAllAwaitingInspections($filters, $page, $perPage);
        $inspectionLeads = $this->inspectionService->getInspectionLeads();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $itemTypes = $this->setupService->getItemTypes();
        $this->viewWithLayout('listings/awaiting-inspection', compact('awaitingInspections','inspectionLeads','inspectionStatuses','itemTypes'));
    }

    public function inspectionProgress() {
        $request = Request::getInstance();
        $filters = $request->only(['itemtype', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        $inspectionInprogress = $this->listingService->getAllInspectionInProgress($filters, $page, $perPage);
        $inspectionLeads = $this->inspectionService->getInspectionLeads();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $itemTypes = $this->setupService->getItemTypes();
        $this->viewWithLayout('listings/inspection-progress', compact('inspectionInprogress','inspectionLeads','inspectionStatuses','itemTypes'));
    }

    public function inspectionConcluded() {
        $request = Request::getInstance();
        $filters = $request->only(['itemtype', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        $inspectionConcluded = $this->listingService->getAllInspectionConcluded($filters, $page, $perPage);
        $inspectionLeads = $this->inspectionService->getInspectionLeads();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $itemTypes = $this->setupService->getItemTypes();
        $this->viewWithLayout('listings/inspection-concluded', compact('inspectionConcluded','inspectionLeads','inspectionStatuses','itemTypes'));
    }

    public function inspectionRejected() {
        $request = Request::getInstance();
        $filters = $request->only(['itemtype', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        $rejectedInspections = $this->listingService->getAllInspectionRejected($filters, $page, $perPage);
        $inspectionLeads = $this->inspectionService->getInspectionLeads();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $itemTypes = $this->setupService->getItemTypes();
        $this->viewWithLayout('listings/inspection-rejected', compact('rejectedInspections','inspectionLeads','inspectionStatuses','itemTypes'));
    }

    public function inspectionApproved() {
        $request = Request::getInstance();
        $filters = $request->only(['itemtype', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        $inspectionApproved = $this->listingService->getApprovedInspections($filters, $page, $perPage);
        $inspectionLeads = $this->inspectionService->getInspectionLeads();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $itemTypes = $this->setupService->getItemTypes();
        $this->viewWithLayout('listings/inspection-approved', compact('inspectionApproved','inspectionLeads','inspectionStatuses','itemTypes'));
    }

    public function awaitingListing() {
        $request = Request::getInstance();
        $filters = $request->only(['itemtype', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        $awaitingListings = $this->listingService->getAllAwaitingListings($filters, $page, $perPage);
        $inspectionLeads = $this->inspectionService->getInspectionLeads();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $itemTypes = $this->setupService->getItemTypes();
        $this->viewWithLayout('listings/awaiting-listing', compact('awaitingListings','inspectionLeads','inspectionStatuses','itemTypes'));
    }

    public function listed() {
        $request = Request::getInstance();
        $filters = $request->only(['itemtype', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        $listedProperties = $this->listingService->getAllListedProperties($filters, $page, $perPage);
        $inspectionLeads = $this->inspectionService->getInspectionLeads();
        $itemTypes = $this->setupService->getItemTypes();
        $this->viewWithLayout('listings/listed', compact('listedProperties','inspectionLeads','itemTypes'));
    }

    public function closed() {
        $request = Request::getInstance();
        $filters = $request->only(['itemtype', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        $closedProperties = $this->listingService->getAllClosedProperties($filters, $page, $perPage);
        $inspectionLeads = $this->inspectionService->getInspectionLeads();
        $itemTypes = $this->setupService->getItemTypes();
        $this->viewWithLayout('listings/closed', compact('closedProperties','inspectionLeads','itemTypes'));
    }
  
    // Show add property page
    public function addPropertyPage() {
        $setupService = $this->setupService;
        $itemTypes = $setupService->getItemTypes();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $ownershipTypes = $setupService->getOwnershipTypes();
        $profileOptions = $setupService->getItemProfileOptions();
        $itemDocTypes = $setupService->getItemDocTypes();
        
        // Get users and attorneys
        $usersService = new UsersService();
        $users = $usersService->getUsers();
        $attorneysData = $usersService->getAttorneys(1, 1000); // Get more attorneys without pagination limit
        $attorneys = $attorneysData['data'] ?? [];
        
        // Get item statuses - implement or stub this in SetupService
        $itemStatuses = $setupService->getItemStatuses();
        
        $this->viewWithLayout('listings/add-property', compact('itemTypes','inspectionStatuses','ownershipTypes','users','attorneys','itemStatuses','profileOptions','itemDocTypes'));
    }

    // Save item documents (with file uploads)
    public function saveItemDocs() {
        $request = Request::getInstance();
        if (!$request->isPost()) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            exit;
        }
        $itemId = (int)$request->post('itemid');
        $docs = $request->post('docs', []);
        if (!$itemId) {
            echo json_encode(['success' => false, 'message' => 'Item ID is required']);
            exit;
        }
        if (empty($docs) || !is_array($docs)) {
            echo json_encode(['success' => false, 'message' => 'No documents submitted']);
            exit;
        }
        // Attach files per row from $_FILES structure: $_FILES['docs']['name'][i]['docurl']
        if (isset($_FILES['docs'])) {
            $files = $_FILES['docs'];
            foreach ($docs as $i => &$row) {
                $file = [
                    'name' => $files['name'][$i]['docurl'] ?? null,
                    'type' => $files['type'][$i]['docurl'] ?? null,
                    'tmp_name' => $files['tmp_name'][$i]['docurl'] ?? null,
                    'error' => $files['error'][$i]['docurl'] ?? UPLOAD_ERR_NO_FILE,
                    'size' => $files['size'][$i]['docurl'] ?? 0,
                ];
                $row['__file'] = $file;
            }
            unset($row);
        }
        $result = $this->listingService->saveItemDocs($itemId, $docs);
        if (!empty($result['success'])) {
            echo json_encode(['success' => true, 'message' => 'Documents saved', 'count' => $result['count'] ?? 0]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message'] ?? 'Failed to save documents']);
        }
        exit;
    }

    // Save item pictures (with file uploads)
    public function saveItemPics() {
        $request = Request::getInstance();
        if (!$request->isPost()) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            exit;
        }
        $itemId = (int)$request->post('itemid');
        $pics = $request->post('pics', []);
        if (!$itemId) {
            echo json_encode(['success' => false, 'message' => 'Item ID is required']);
            exit;
        }
        if (empty($pics) || !is_array($pics)) {
            echo json_encode(['success' => false, 'message' => 'No pictures submitted']);
            exit;
        }
        // Attach files per row from $_FILES structure: $_FILES['pics']['name'][i]['picurl']
        if (isset($_FILES['pics'])) {
            $files = $_FILES['pics'];
            foreach ($pics as $i => &$row) {
                $file = [
                    'name' => $files['name'][$i]['picurl'] ?? null,
                    'type' => $files['type'][$i]['picurl'] ?? null,
                    'tmp_name' => $files['tmp_name'][$i]['picurl'] ?? null,
                    'error' => $files['error'][$i]['picurl'] ?? UPLOAD_ERR_NO_FILE,
                    'size' => $files['size'][$i]['picurl'] ?? 0,
                ];
                $row['__file'] = $file;
            }
            unset($row);
        }
        $result = $this->listingService->saveItemPics($itemId, $pics);
        if (!empty($result['success'])) {
            echo json_encode(['success' => true, 'message' => 'Pictures saved', 'count' => $result['count'] ?? 0]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message'] ?? 'Failed to save pictures']);
        }
        exit;
    }

    // Save property layout to subitem table
    public function savePropertyLayout() {
        $request = Request::getInstance();
        if (!$request->isPost()) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            exit;
        }
        $itemId = (int)$request->post('itemid');
        $layouts = $request->post('layouts', []);
        if (!$itemId) {
            echo json_encode(['success' => false, 'message' => 'Item ID is required']);
            exit;
        }
        $result = $this->listingService->savePropertyLayout($itemId, $layouts);
        if (!empty($result['success'])) {
            echo json_encode(['success' => true, 'message' => 'Layout saved', 'count' => $result['count'] ?? 0]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message'] ?? 'Failed to save layout']);
        }
        exit;
    }

    // Handle add property POST
    public function addProperty() {
        $request = Request::getInstance();
        if (!$request->isPost()) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            exit;
        }

        // Validate required fields (entrydate is filled by AuditFields)
        $fields = ['title', 'itemtypeid', 'description', 'address', 'price'];
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = trim($request->post($field, ''));
            if ($data[$field] === '') {
                echo json_encode(['success' => false, 'message' => ucfirst($field) . ' is required.']);
                exit;
            }
        }
        $data['priceunit'] = trim($request->post('priceunit', ''));

        // Handle file upload (optional) - uses documents/ folder
        $docurl = null;
        if (isset($_FILES['docurl']) && $_FILES['docurl']['error'] === UPLOAD_ERR_OK) {
            $result = uploadFile($_FILES['docurl'], 'documents');
            if ($result['success']) {
                // Store only filename, not full path
                $docurl = $result['filename'];
            }
        }
        $data['docurl'] = $docurl;

        // Call service to create property
        $result = $this->listingService->createProperty($data);
        if (!empty($result['success'])) {
            echo json_encode(['success' => true, 'message' => 'Property added successfully.', 'itemid' => $result['id'] ?? null]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message'] ?? 'Failed to add property.']);
        }
        exit;
    }
    
    // Save item profiles (from Item Profile tab)
    public function saveItemProfiles() {
        $request = Request::getInstance();
        if (!$request->isPost()) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            exit;
        }
        $itemId = (int)$request->post('itemid');
        $profiles = $request->post('profiles', []);
        if (!$itemId) {
            echo json_encode(['success' => false, 'message' => 'Item ID is required']);
            exit;
        }
        if (empty($profiles) || !is_array($profiles)) {
            echo json_encode(['success' => false, 'message' => 'No profiles submitted']);
            exit;
        }
        $result = $this->listingService->saveItemProfiles($itemId, $profiles);
        if (!empty($result['success'])) {
            echo json_encode(['success' => true, 'message' => 'Profiles saved', 'count' => $result['count'] ?? 0]);
        } else {
            echo json_encode(['success' => false, 'message' => $result['message'] ?? 'Failed to save profiles']);
        }
        exit;
    }

    // View property detail (basic)
    public function propertyDetail($id) {
        $item = $this->listingService->getPropertyById($id);
        if (!$item) {
            http_response_code(404);
            echo 'Property not found';
            return;
        }
        // Load related lists for generic page consumption
        $profiles = $this->listingService->getItemProfiles($id);
        $docs = $this->listingService->getItemDocs($id);
        $pics = $this->listingService->getItemPics($id);
        $layouts = $this->listingService->getSubItems($id);
        
        // Load inspection tasks for this property
        $inspectionTasksData = $this->inspectionService->getInspectionTasksList(['itemid' => $id], 1, 100);
        $inspectionTasks = $inspectionTasksData['data'] ?? [];
        
        $property = $item;
        $property['itemProfiles'] = $profiles;
        $property['itemDocs'] = $docs;
        $property['itemPics'] = $pics;
        $property['subItems'] = $layouts;
        $property['itemInspections'] = $inspectionTasks;
        $this->viewWithLayout('pages/property-detail', ['property' => $property]);
    }

    // Show edit page
    public function editPropertyPage($id) {
        $item = $this->listingService->getPropertyById($id);
        if (!$item) {
            http_response_code(404);
            echo 'Property not found';
            return;
        }
        $itemTypes = $this->setupService->getItemTypes();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $ownershipTypes = $this->setupService->getOwnershipTypes();
        $usersService = new UsersService();
        $users = $usersService->getUsers();
        $attorneysData = $usersService->getAttorneys(1, 1000); // Get more attorneys without pagination limit
        $attorneys = $attorneysData['data'] ?? [];
        $itemStatuses = $this->setupService->getItemStatuses();
        $profileOptions = $this->setupService->getItemProfileOptions();
        $itemDocTypes = $this->setupService->getItemDocTypes();
        // related lists
        $itemProfiles = $this->listingService->getItemProfiles($id);
        $itemDocs = $this->listingService->getItemDocs($id);
        $itemPics = $this->listingService->getItemPics($id);
        $subItems = $this->listingService->getSubItems($id);
        $this->viewWithLayout('listings/edit-property', compact(
            'item','itemTypes','inspectionStatuses','ownershipTypes','users','attorneys','itemStatuses','profileOptions','itemDocTypes','itemProfiles','itemDocs','itemPics','subItems'
        ));
    }

    // Handle update
    public function updateProperty($id) {
        $request = Request::getInstance();
        if (!$request->isPost()) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            exit;
        }
        $payload = $request->only(['title','itemtypeid','description','address','price','priceunit','ownershiptypeid','ownershiptypetitle','inspectionstatusid','sellerid','attorneyid','itemstatusid']);
        $res = $this->listingService->updateProperty($id, $payload);
        echo json_encode($res);
        exit;
    }

    // Delete property (soft delete)
    public function deleteProperty($id) {
        $res = $this->listingService->deleteProperty($id);
        echo json_encode($res);
        exit;
    }

    // Reject property
    public function rejectProperty($id) {
        $res = $this->listingService->rejectProperty($id);
        echo json_encode($res);
        exit;
    }

    // Approve property (from rejected inspection)
    public function approveProperty($id) {
        $res = $this->listingService->approveProperty($id);
        Response::json($res);
    }

    // Reinspect property (send back for reinspection)
    public function reinspectProperty($id) {
        $res = $this->listingService->reinspectProperty($id);
        Response::json($res);
    }

    // List property (mark as ready for listing)
    public function listProperty($id) {
        $res = $this->listingService->listProperty($id);
        Response::json($res);
    }

    // Keep property for listing (mark for future listing)
    public function keepForListing($id) {
        $res = $this->listingService->keepForListing($id);
        Response::json($res);
    }

    // Close offer (mark offer as closed)
    public function closeOffer($id) {
        $res = $this->listingService->closeOffer($id);
        Response::json($res);
    }

    // Delist property (remove from listing)
    public function delistProperty($id) {
        $res = $this->listingService->delistProperty($id);
        Response::json($res);
    }
}
