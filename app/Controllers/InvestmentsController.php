<?php
use App\Traits\HasFileUpload;

class InvestmentsController extends Controller {
    use HasFileUpload;

    private $investmentService;
    private $inspectionService;
    private $setupService;
    private $offerService;

    public function __construct() {
        parent::__construct();
        $this->investmentService = new InvestmentService();
        $this->inspectionService = new InspectionService();
        $this->setupService = new SetupService();
        $this->offerService = new OfferService();
    }

    public function dashboard() {
        $stats = $this->investmentService->dashboardGetStats();
        $offers = $this->investmentService->dashboardGetRecentOffers();
        $recentPending = $this->investmentService->dashboardGetRecentPending();
        $recentAwaiting = $this->investmentService->dashboardGetRecentAwaiting();
        $inspconcluded = $this->investmentService->dashboardGetRecentInspconcluded();

        $this->viewWithLayout('investments/dashboard', [
            'title' => 'Investment Dashboard',
            'stats' => $stats,
            'offers' => $offers,
            'recentPending' => $recentPending,
            'recentAwaiting' => $recentAwaiting,
            'inspconcluded' => $inspconcluded,
        ], 'layouts.app');
    }

    public function newProjects() {
        $request = Request::getInstance();
        $filters = $request->only(['ownership_type', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        $investmentList = $this->investmentService->getPendingInvestmentList($filters, $page, $perPage);
        $ownershipTypes = $this->setupService->getOwnershipTypes();
        $inspectionLeads = $this->inspectionService->getInspectionLeads();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();

        $this->viewWithLayout('investments/new-projects', compact('investmentList', 'ownershipTypes', 'inspectionLeads', 'inspectionStatuses'));
    }

    public function awaitingInspection() {
        $request = Request::getInstance();
        $filters = $request->only(['ownership_type', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        $awaitingInvestmentList = $this->investmentService->getAwaitingProjectList($filters, $page, $perPage);
        $ownershipTypes = $this->setupService->getOwnershipTypes();

        $this->viewWithLayout('investments/awaiting-inspection', compact('awaitingInvestmentList', 'ownershipTypes'));
    }

    public function inspectionProgress() {
        $request = Request::getInstance();
        $filters = $request->only(['ownership_type', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        $inspectionInprogessList = $this->investmentService->getAllInspectionInProgressProject($filters, $page, $perPage);
        $ownershipTypes = $this->setupService->getOwnershipTypes();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();

        $this->viewWithLayout('investments/inspection-progress', compact('inspectionInprogessList', 'ownershipTypes', 'inspectionStatuses'));
    }

    public function inspectionConcluded() {
        $request = Request::getInstance();
        $filters = $request->only(['ownership_type', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        $investmentconcludedList = $this->investmentService->getInspectionConcludedList($filters, $page, $perPage);
        $ownershipTypes = $this->setupService->getOwnershipTypes();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();

        $this->viewWithLayout('investments/inspection-concluded', compact('investmentconcludedList', 'ownershipTypes', 'inspectionStatuses'));
    }

    public function inspectionRejected() {
        $request = Request::getInstance();
        $filters = $request->only(['ownership_type', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        $inpectionRejectedList = $this->investmentService->getInspectionRejectedList($filters, $page, $perPage);
        $ownershipTypes = $this->setupService->getOwnershipTypes();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();

        $this->viewWithLayout('investments/inspection-rejected', compact('inpectionRejectedList', 'ownershipTypes', 'inspectionStatuses'));
    }

    public function inspectionApproved() {
        $request = Request::getInstance();
        $filters = $request->only(['ownership_type', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        $inspectionApprovedList = $this->investmentService->getInspectionApprovedList($filters, $page, $perPage);
        $ownershipTypes = $this->setupService->getOwnershipTypes();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();

        $this->viewWithLayout('investments/inspection-approved', compact('inspectionApprovedList', 'ownershipTypes', 'inspectionStatuses'));
    }

    public function awaitingListing() {
        $request = Request::getInstance();
        $filters = $request->only(['ownership_type', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        $awaitingInspectionList = $this->investmentService->getAwaitingListingList($filters, $page, $perPage);
        $ownershipTypes = $this->setupService->getOwnershipTypes();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();

        $this->viewWithLayout('investments/awaiting-listing', compact('awaitingInspectionList', 'ownershipTypes', 'inspectionStatuses'));
    }

    public function listed() {
        $request = Request::getInstance();
        $filters = $request->only(['ownership_type', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        $listedInvestmentList = $this->investmentService->getListedPropertyList($filters, $page, $perPage);
        $ownershipTypes = $this->setupService->getOwnershipTypes();

        $this->viewWithLayout('investments/listed', compact('listedInvestmentList', 'ownershipTypes'));
    }

    public function closed() {
        $request = Request::getInstance();
        $filters = $request->only(['ownership_type', 'entry_date']);
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        $closedProjects = $this->investmentService->getClosedProject($filters, $page, $perPage);
        $ownershipTypes = $this->setupService->getOwnershipTypes();

        $this->viewWithLayout('investments/closed', compact('closedProjects', 'ownershipTypes'));
    }

    public function addProject() {
        $itemTypes = $this->setupService->getItemTypes();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $ownershipTypes = $this->setupService->getOwnershipTypes();
        $investOptions = $this->setupService->getInvestOptions();
        $users = $this->inspectionService->getUsers();
        $attorneys = $this->offerService->getAttorneys();
        $projectTypes = $this->setupService->getProjectTypes();
        $itemStatuses = $this->inspectionService->getItemStatuses();
        $itemDocTypes = $this->setupService->getItemDocTypes();

        $this->viewWithLayout('investments/add-project', compact(
            'itemTypes',
            'inspectionStatuses',
            'ownershipTypes',
            'investOptions',
            'users',
            'attorneys',
            'projectTypes',
            'itemStatuses',
            'itemDocTypes'
        ));
    }

    public function storeProject() {
        $request = Request::getInstance();
        
        try {
            // Validate required fields
            $title = trim($request->post('title', ''));
            $description = trim($request->post('description', ''));
            $address = trim($request->post('address', ''));
            
            if (empty($title)) {
                Response::json(['success' => false, 'message' => 'Project title is required'], 400);
                return;
            }
            
            if (empty($description)) {
                Response::json(['success' => false, 'message' => 'Project description is required'], 400);
                return;
            }
            
            if (empty($address)) {
                Response::json(['success' => false, 'message' => 'Project address is required'], 400);
                return;
            }
            
            // Get all form data
            $data = [
                'servicetypeid' => $request->post('servicetypeid', 4), // Default to 4 for investments
                'title' => $title,
                'description' => $description,
                'address' => $address,
                'itemtypeid' => $request->post('itemtypeid'),
                'inspectionstatusid' => $request->post('inspectionstatusid'),
                'ownershiptypeid' => $request->post('ownershiptypeid'),
                'ownershiptypetitle' => $request->post('ownershiptypetitle'),
                'price' => $request->post('price'),
                'minprice' => $request->post('minprice'),
                'maxprice' => $request->post('maxprice'),
                'investunit' => $request->post('investunit'),
                'investreturns' => $request->post('investreturns'),
                'tenure' => $request->post('tenure'),
                'investoptionid' => $request->post('investoptionid'),
                'sellerid' => $request->post('sellerid'),
                'attorneyid' => $request->post('attorneyid'),
                'projecttypeid' => $request->post('projecttypeid'),
                'itemstatusid' => $request->post('itemstatusid', 0),
            ];
            
            // Create new project
            $result = $this->investmentService->createProject($data);
            
            if ($result['success']) {
                Response::json([
                    'success' => true,
                    'itemid' => $result['itemid'],
                    'message' => $result['message']
                ]);
            } else {
                Response::json(['success' => false, 'message' => $result['message']], 500);
            }
            
        } catch (Exception $e) {
            Logger::error('Store project error: ' . $e->getMessage());
            Response::json(['success' => false, 'message' => 'An error occurred while saving the project'], 500);
        }
    }

    public function updateProjectInfo() {
        $request = Request::getInstance();
        
        try {
            // Get project ID from POST data
            $itemId = $request->post('itemid');
            
            if (!$itemId || empty($itemId)) {
                Response::json(['success' => false, 'message' => 'Project ID is required for update. Received: ' . ($itemId ?? 'null')], 400);
                return;
            }
            
            // Validate required fields
            $title = trim($request->post('title', ''));
            $description = trim($request->post('description', ''));
            $address = trim($request->post('address', ''));
            
            if (empty($title)) {
                Response::json(['success' => false, 'message' => 'Project title is required'], 400);
                return;
            }
            
            if (empty($description)) {
                Response::json(['success' => false, 'message' => 'Project description is required'], 400);
                return;
            }
            
            if (empty($address)) {
                Response::json(['success' => false, 'message' => 'Project address is required'], 400);
                return;
            }
            
            // Get all form data
            $data = [
                'title' => $title,
                'description' => $description,
                'address' => $address,
                'itemtypeid' => $request->post('itemtypeid'),
                'inspectionstatusid' => $request->post('inspectionstatusid'),
                'ownershiptypeid' => $request->post('ownershiptypeid'),
                'ownershiptypetitle' => $request->post('ownershiptypetitle'),
                'price' => $request->post('price'),
                'minprice' => $request->post('minprice'),
                'maxprice' => $request->post('maxprice'),
                'investunit' => $request->post('investunit'),
                'investreturns' => $request->post('investreturns'),
                'tenure' => $request->post('tenure'),
                'investoptionid' => $request->post('investoptionid'),
                'sellerid' => $request->post('sellerid'),
                'attorneyid' => $request->post('attorneyid'),
                'projecttypeid' => $request->post('projecttypeid'),
                'itemstatusid' => $request->post('itemstatusid', 0),
            ];
            
            // Update existing project
            $result = $this->investmentService->updateProject($itemId, $data);

            if ($result['success']) {
                Response::json([
                    'success' => true,
                    'itemid' => $itemId,
                    'message' => $result['message']
                ]);
            } else {
                Response::json(['success' => false, 'message' => $result['message']], 500);
            }
            
        } catch (Exception $e) {
            Logger::error('Update project error: ' . $e->getMessage());
            Response::json(['success' => false, 'message' => 'An error occurred while updating the project'], 500);
        }
    }

    public function editProject($id) {
        $request = Request::getInstance();

        if (!$id) {
            Response::redirect('/investments/new-projects?error=Project ID required');
            return;
        }

        $project = $this->investmentService->getProjectWithRelations($id);
        
        if (!$project) {
            Response::redirect('/investments/new-projects?error=Project not found');
            return;
        }

        // Handle action parameters for pre-filling status
        $action = $request->get('action');
        if ($action === 'close_offer') {
            $project['itemstatusid'] = 20; // Close offer status
        } elseif ($action === 'de_list') {
            $project['itemstatusid'] = 9; // De-list status
        }

        $itemTypes = $this->setupService->getItemTypes();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $ownershipTypes = $this->setupService->getOwnershipTypes();
        $investOptions = $this->setupService->getInvestOptions();
        $users = $this->inspectionService->getUsers();
        $attorneys = $this->offerService->getAttorneys();
        $projectTypes = $this->setupService->getProjectTypes();
        $itemStatuses = $this->inspectionService->getItemStatuses();
        $itemDocTypes = $this->setupService->getItemDocTypes();
        $itempicTypes = $this->setupService->getItemPicTypes();

        $this->viewWithLayout('investments/edit-project', compact(
            'project',
            'itemTypes',
            'inspectionStatuses',
            'ownershipTypes',
            'investOptions',
            'users',
            'attorneys',
            'projectTypes',
            'itemStatuses',
            'itemDocTypes',
            'itempicTypes'
        ));
    }

    public function updateProject($id) {
        $request = Request::getInstance();

        
        if (!$id) {
            Response::json(['success' => false, 'message' => 'Project ID required']);
            return;
        }

        // Get data from POST body
        $data = [];
        if ($request->post('itemstatusid')) {
            $data['itemstatusid'] = $request->post('itemstatusid');
        }
        if ($request->post('inspectionstatusid')) {
            $data['inspectionstatusid'] = $request->post('inspectionstatusid');
        }
        
        if (empty($data)) {
            Response::json(['success' => false, 'message' => 'No data to update']);
            return;
        }
        
        // Update the project with the provided data
        $result = $this->investmentService->updateProjectStatus($id, $data);

        Logger::info('Update Project - ID: ' . $id . ', Data: ' . json_encode($data) . ', Result: ' . ($result ? 'Success' : 'Failure'));
        
        Response::json([
            'success' => $result,
            'message' => $result ? 'Project updated successfully' : 'Failed to update project'
        ]);
    }

    public function destroyProject($id) {
        $request = Request::getInstance();
        
        // Ensure id is a scalar value
        if (is_array($id)) {
            $id = $id[0] ?? null;
        }

        if (!$id) {
            Response::json(['success' => false, 'message' => 'Project ID required'], 400);
            return;
        }

        $result = $this->investmentService->deleteAwaitingProject($id);
        Response::json([
            'success' => $result,
            'message' => $result ? 'Project deleted successfully' : 'Failed to delete project'
        ]);
    }

    public function deleteAwaitingProject($id) {
        $request = Request::getInstance();

        if (!$id) {
            Response::json(['success' => false, 'message' => 'Project ID required']);
            return;
        }

        $result = $this->investmentService->deleteAwaitingProject($id);
        Response::json([
            'success' => $result,
            'message' => $result ? 'Property deleted successfully' : 'Failed to delete property'
        ]);
    }

    public function viewProject($id) {
        $request = Request::getInstance();

        if (!$id) {
            $_SESSION['error_message'] = 'Project ID required';
            Response::redirect('/investments/new-projects');
            return;
        }

        $project = $this->investmentService->getProjectWithRelations($id);
        
        if (!$project) {
            $_SESSION['error_message'] = 'Project not found';
            Response::redirect('/investments/new-projects');
            return;
        }

        // Handle actions
        $message = null;
        $error = null;

        // ACTION 1: Update investment bid status (confirm/reject investor offers)
        $setBidStatus = $request->get('setbidstatus');
        $itemBidId = $request->get('itembidid');
        
        if ($setBidStatus !== null && $itemBidId) {
            if (is_numeric($setBidStatus) && is_numeric($itemBidId)) {
                $result = $this->updateBidStatus($itemBidId, $setBidStatus);
                if ($result) {
                    $_SESSION['success_message'] = 'Investment offer ' . ($setBidStatus == -1 ? 'rejected' : 'confirmed') . ' successfully';
                } else {
                    $_SESSION['error_message'] = 'Could not ' . ($setBidStatus == -1 ? 'reject' : 'confirm') . ' offer';
                }
                Response::redirect('/investments/view-project?id=' . $id);
                return;
            }
        }

        // ACTION 2: Update project status with optional bid selection
        $setStatus = $request->get('setstatus');
        $setBidId = $request->get('setbidid');
        
        if ($setStatus !== null && $setBidId !== null) {
            if (is_numeric($setStatus) && is_numeric($setBidId) && $setStatus != 0) {
                // Update both status and bid
                $result = $this->updateProjectStatusWithBid($id, $setStatus, $setBidId);
                if ($result) {
                    $_SESSION['success_message'] = 'Offer updated successfully';
                } else {
                    $_SESSION['error_message'] = 'Could not update offer';
                }
                Response::redirect('/investments/view-project?id=' . $id);
                return;
            }
        } elseif ($setStatus !== null) {
            // ACTION 3: Update project status only
            if (is_numeric($setStatus) && $setStatus != 0) {
                $result = $this->updateProjectStatus($id, $setStatus);
                if ($result) {
                    $statusMessage = [
                        9 => 'Project kept for listing successfully',
                        10 => 'Project listed successfully',
                        15 => 'Investor confirmed successfully',
                        20 => 'Project closed successfully'
                    ];
                    $_SESSION['success_message'] = $statusMessage[$setStatus] ?? 'Project status updated successfully';
                } else {
                    $_SESSION['error_message'] = 'Could not update project status';
                }
                Response::redirect('/investments/view-project?id=' . $id);
                return;
            }
        }

        // ACTION 4: Approve/reject inspection status (for iteminspections table)
        $approveStatus = $request->get('approvestatus');
        $inspectionId = $request->get('inspectionid');

                Logger::info('View Project - Approve Status: ' . $approveStatus . ', Inspection ID: ' . $inspectionId);

        
        if ($approveStatus !== null && $inspectionId) {
            if (is_numeric($approveStatus) && is_numeric($inspectionId) && $inspectionId >= 0) {
                $result = $this->updateInspectionTableStatus($inspectionId, $approveStatus);
                if ($result) {
                    $_SESSION['success_message'] = 'Inspection updated successfully';
                } else {
                    $_SESSION['error_message'] = 'Could not update inspection';
                }
                Response::redirect('/investments/view-project?id=' . $id);
                return;
            }
        }

        // ACTION 5: Update both project and inspection status together
        $setItemStatus = $request->get('setitemstatus');
        $inspectionStatusId = $request->get('inspectionstatusid');
        
        if ($setItemStatus !== null && $inspectionStatusId !== null) {
            if (is_numeric($setItemStatus) && is_numeric($inspectionStatusId) && $setItemStatus != 0 && $inspectionStatusId >= 0) {
                $result = $this->updateProjectAndInspectionStatus($id, $setItemStatus, $inspectionStatusId);
                if ($result) {
                    $statusMessage = [
                        3 => 'Project set for reinspection successfully',
                        4 => 'Project approved successfully',
                        5 => 'Project rejected successfully'
                    ];
                    $_SESSION['success_message'] = $statusMessage[$setItemStatus] ?? 'Inspection updated successfully';
                } else {
                    $_SESSION['error_message'] = 'Could not update inspection';
                }
                Response::redirect('/investments/view-project?id=' . $id);
                return;
            }
        }

        $this->viewWithLayout('investments/view-project', compact('project'));
    }

    // AJAX Actions
    public function deleteProject($id) {
        $request = Request::getInstance();

        if (!$id) {
            Response::json(['success' => false, 'message' => 'Project ID required']);
            return;
        }

        $result = $this->investmentService->deleteAwaitingProject($id);
        Response::json([
            'success' => $result,
            'message' => $result ? 'Project deleted successfully' : 'Failed to delete project'
        ]);
    }

    public function rejectProject($id) {
        $request = Request::getInstance();
        
        // Ensure id is a scalar value
        if (is_array($id)) {
            $id = $id[0] ?? null;
        }

        if (!$id) {
            Response::json(['success' => false, 'message' => 'Project ID required'], 400);
            return;
        }

        // Update status to rejected (5)
        $result = $this->investmentService->updateInspectionStatus($id, 5);
        $this->updateProjectStatus($id, 5);
        
        Response::json([
            'success' => $result,
            'message' => $result ? 'Project rejected successfully' : 'Failed to reject project'
        ]);
    }

    public function updateInspectionStatus() {
        $request = Request::getInstance();
        $id = $request->post('id');
        $statusId = $request->post('inspectionstatusid');

        if (!$id || !$statusId) {
            Response::json(['success' => false, 'message' => 'Invalid parameters']);
            return;
        }

        $result = $this->investmentService->updateInspectionStatus($id, $statusId);
        Response::json([
            'success' => $result,
            'message' => $result ? 'Inspection status updated successfully' : 'Failed to update inspection status'
        ]);
    }

    // Helper methods
    private function updateProjectStatus($itemId, $statusId) {
        $db = Database::getInstance();
        $sql = "UPDATE items SET itemstatusid = ? WHERE itemid = ? AND companyid = ?";
        return $db->query($sql, [$statusId, $itemId, Auth::companyId()])->rowCount();
    }

    private function updateBidStatus($bidId, $status) {
        $db = Database::getInstance();
        $sql = "UPDATE itembids SET status = ? WHERE itembidid = ? AND companyid = ?";
        return $db->query($sql, [$status, $bidId, Auth::companyId()])->rowCount();
    }

    private function updateProjectStatusWithBid($itemId, $statusId, $bidId) {
        $db = Database::getInstance();
        $sql = "UPDATE items SET itemstatusid = ?, itembidid = ? WHERE itemid = ? AND companyid = ?";
        return $db->query($sql, [$statusId, $bidId, $itemId, Auth::companyId()])->rowCount();
    }

    private function updateInspectionTableStatus($inspectionId, $statusId) {
        $db = Database::getInstance();
        $sql = "UPDATE iteminspections SET statusid = ? WHERE iteminspectionid = ? AND companyid = ?";
        return $db->query($sql, [$statusId, $inspectionId, Auth::companyId()])->rowCount();
    }

    private function updateProjectAndInspectionStatus($itemId, $itemStatusId, $inspectionStatusId) {
        $db = Database::getInstance();
        $sql = "UPDATE items SET itemstatusid = ?, inspectionstatusid = ? WHERE itemid = ? AND companyid = ?";
        return $db->query($sql, [$itemStatusId, $inspectionStatusId, $itemId, Auth::companyId()])->rowCount();
    }

    // Save item extras methods
    public function saveItemProfiles() {
        $request = Request::getInstance();
        if (!$request->isPost()) {
            http_response_code(405);
            Response::json(['success' => false, 'message' => 'Method Not Allowed']);
            return;
        }

        $itemId = (int)$request->post('itemid');
        $profiles = $request->post('profiles', []);

        if (!$itemId) {
            Response::json(['success' => false, 'message' => 'Item ID is required']);
            return;
        }

        if (empty($profiles) || !is_array($profiles)) {
            Response::json(['success' => false, 'message' => 'No profiles submitted']);
            return;
        }

        $result = $this->investmentService->saveItemProfiles($itemId, $profiles);
        Response::json([
            'success' => !empty($result['success']),
            'message' => $result['success'] ? 'Profiles saved' : ($result['message'] ?? 'Failed to save profiles'),
            'count' => $result['count'] ?? 0
        ]);
    }

    public function saveItemDocs() {
        $request = Request::getInstance();
        if (!$request->isPost()) {
            http_response_code(405);
            Response::json(['success' => false, 'message' => 'Method Not Allowed']);
            return;
        }

        $itemId = (int)$request->post('itemid');
        $docs = $request->post('docs', []);

        if (!$itemId) {
            Response::json(['success' => false, 'message' => 'Item ID is required']);
            return;
        }

        if (empty($docs) || !is_array($docs)) {
            Response::json(['success' => false, 'message' => 'No documents submitted']);
            return;
        }

        $result = $this->investmentService->saveItemDocs($itemId, $docs);
        Response::json([
            'success' => !empty($result['success']),
            'message' => $result['success'] ? 'Documents saved' : ($result['message'] ?? 'Failed to save documents'),
            'count' => $result['count'] ?? 0
        ]);
    }

    public function saveItemPics() {
        $request = Request::getInstance();
        if (!$request->isPost()) {
            http_response_code(405);
            Response::json(['success' => false, 'message' => 'Method Not Allowed']);
            return;
        }

        $itemId = (int)$request->post('itemid');
        $pics = $request->post('pics', []);

        if (!$itemId) {
            Response::json(['success' => false, 'message' => 'Item ID is required']);
            return;
        }

        if (empty($pics) || !is_array($pics)) {
            Response::json(['success' => false, 'message' => 'No pictures submitted']);
            return;
        }

        $result = $this->investmentService->saveItemPics($itemId, $pics);
        Response::json([
            'success' => !empty($result['success']),
            'message' => $result['success'] ? 'Pictures saved' : ($result['message'] ?? 'Failed to save pictures'),
            'count' => $result['count'] ?? 0
        ]);
    }

    public function saveProjectLayout() {
        $request = Request::getInstance();
        if (!$request->isPost()) {
            http_response_code(405);
            Response::json(['success' => false, 'message' => 'Method Not Allowed']);
            return;
        }

        $itemId = (int)$request->post('itemid');
        $layouts = $request->post('layouts', []);

        if (!$itemId) {
            Response::json(['success' => false, 'message' => 'Item ID is required']);
            return;
        }

        if (empty($layouts) || !is_array($layouts)) {
            Response::json(['success' => false, 'message' => 'No layouts submitted']);
            return;
        }

        $result = $this->investmentService->saveProjectLayout($itemId, $layouts);
        Response::json([
            'success' => !empty($result['success']),
            'message' => $result['success'] ? 'Layout saved' : ($result['message'] ?? 'Failed to save layout'),
            'count' => $result['count'] ?? 0
        ]);
    }

    // Provide profile options for Project Profile tab
    public function getProfileOptions() {
        $request = Request::getInstance();
        $itemId = (int)$request->get('itemid');
        $itemTypeId = (int)$request->get('itemtypeid');

        // If itemtypeid not provided, try to infer from item
        if (!$itemTypeId && $itemId) {
            $project = $this->investmentService->getProjectWithRelations($itemId);
            if (!empty($project['itemtypeid'])) {
                $itemTypeId = (int)$project['itemtypeid'];
            }
        }

        if (!$itemTypeId) {
            Response::json(['success' => false, 'message' => 'Item type is required']);
            return;
        }

        // Fetch all profile options and filter by itemtypeid
        $allOptions = $this->setupService->getItemProfileOptions();
        $options = array_values(array_filter($allOptions, function ($opt) use ($itemTypeId) {
            return (int)($opt['itemtypeid'] ?? 0) === $itemTypeId;
        }));

        // Map minimal fields expected by the view renderer
        $profileOptions = array_map(function ($opt) {
            return [
                'itemprofileoptionid' => $opt['itemprofileoptionid'] ?? null,
                'title' => $opt['title'] ?? '',
            ];
        }, $options);

        Response::json(['success' => true, 'profileOptions' => $profileOptions]);
    }

    // ==================== DOCUMENT CRUD ====================
    
    public function storeDocument() {
        $request = Request::getInstance();
        
        try {
            $itemId = $request->post('itemid');
            $itemDocTypeId = $request->post('itemdoctypeid');
            
            if (!$itemId || !$itemDocTypeId) {
                Response::json(['success' => false, 'message' => 'Item ID and Document Type are required'], 400);
                return;
            }
            
            $data = [
                'itemid' => $itemId,
                'itemdoctypeid' => $itemDocTypeId,
                'docstatus' => $request->post('docstatus', 1),
                'itemdoctitle' => $request->post('itemdoctitle', ''),
                'uploadby' => Auth::id(),
                'uploaddate' => date('Y-m-d H:i:s'),
            ];
            
            // Handle file upload
            if (isset($_FILES['docurl']) && $_FILES['docurl']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->uploadFile($_FILES['docurl'], 'documents');
                if ($uploadResult['success']) {
                    $data['docurl'] = $uploadResult['path'];
                } else {
                    Response::json(['success' => false, 'message' => $uploadResult['message']], 400);
                    return;
                }
            }
            
            $result = $this->investmentService->createDocument($data);
            
            if ($result['success']) {
                Response::json(['success' => true, 'message' => 'Document uploaded successfully', 'document' => $result['document']]);
            } else {
                Response::json(['success' => false, 'message' => $result['message'] ?? 'Failed to upload document'], 400);
            }
        } catch (Exception $e) {
            Logger::error('Error storing document: ' . $e->getMessage());
            Response::json(['success' => false, 'message' => 'An error occurred while uploading document'], 500);
        }
    }
    
    public function getDocument($docId) {
        $request = Request::getInstance();
        
        // Ensure docId is a scalar value
        if (is_array($docId)) {
            $docId = $docId[0] ?? null;
        }
        
        if (!$docId) {
            Response::json(['success' => false, 'message' => 'Document ID required'], 400);
            return;
        }
        
        $document = $this->investmentService->getDocument($docId);
        
        if ($document) {
            Response::json(['success' => true, 'document' => $document]);
        } else {
            Response::json(['success' => false, 'message' => 'Document not found'], 404);
        }
    }
    
    public function updateDocument($docId) {
        $request = Request::getInstance();

        try {
            if (!$docId) {
                Response::json(['success' => false, 'message' => 'Document ID required'], 400);
                return;
            }
            
            $data = [
                'itemdoctypeid' => $request->post('itemdoctypeid'),
                'docstatus' => $request->post('docstatus', 1),
            ];
            
            // Handle file upload if new file provided
            if (isset($_FILES['docurl']) && $_FILES['docurl']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = uploadFile($_FILES['docurl'], 'documents');
                if ($uploadResult['success']) {
                    $data['docurl'] = $uploadResult['filename'];
                } else {
                    Response::json(['success' => false, 'message' => $uploadResult['message']], 400);
                    return;
                }
            }
            
            $result = $this->investmentService->updateDocument($docId, $data);
            
            if ($result['success']) {
                Response::json(['success' => true, 'message' => 'Document updated successfully']);
            } else {
                Response::json(['success' => false, 'message' => $result['message'] ?? 'Failed to update document'], 400);
            }
        } catch (Exception $e) {
            Logger::error('Error updating document: ' . $e->getMessage());
            Response::json(['success' => false, 'message' => 'An error occurred while updating document'], 500);
        }
    }
    
    public function deleteDocument($docId) {
        $request = Request::getInstance();
        
        try {
            // Ensure docId is a scalar value
            if (is_array($docId)) {
                $docId = $docId[0] ?? null;
            }
            
            if (!$docId) {
                Response::json(['success' => false, 'message' => 'Document ID required'], 400);
                return;
            }
            
            $result = $this->investmentService->deleteDocument($docId);
            
            if ($result['success']) {
                Response::json(['success' => true, 'message' => 'Document deleted successfully']);
            } else {
                Response::json(['success' => false, 'message' => $result['message'] ?? 'Failed to delete document'], 400);
            }
        } catch (Exception $e) {
            Logger::error('Error deleting document: ' . $e->getMessage());
            Response::json(['success' => false, 'message' => 'An error occurred while deleting document'], 500);
        }
    }
    
    public function getProjectDocuments($itemId) {
        $request = Request::getInstance();

        
        if (!$itemId) {
            Response::json(['success' => false, 'message' => 'Project ID required'], 400);
            return;
        }
        
        $documents = $this->investmentService->getProjectDocuments($itemId);
        Response::json(['success' => true, 'documents' => $documents]);
    }
    
    // ==================== IMAGE CRUD ====================
    
    public function storeImage() {
        $request = Request::getInstance();
        
        try {
            $itemId = $request->post('itemid');
            
            if (!$itemId) {
                Response::json(['success' => false, 'message' => 'Item ID is required'], 400);
                return;
            }
            
            $data = [
                'itemid' => $itemId,
                'pictitle' => $request->post('pictitle', ''),
                'pictitleid' => $request->post('pictitleid'),
                'picstatus' => $request->post('picstatus', 1),
            ];
            
            // Handle file upload
            if (isset($_FILES['picurl']) && $_FILES['picurl']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->uploadFile($_FILES['picurl'], 'pictures');
                if ($uploadResult['success']) {
                    $data['picurl'] = $uploadResult['path'];
                } else {
                    Response::json(['success' => false, 'message' => $uploadResult['message']], 400);
                    return;
                }
            } else {
                Response::json(['success' => false, 'message' => 'Image file is required'], 400);
                return;
            }
            
            $result = $this->investmentService->createImage($data);
            
            if ($result['success']) {
                Response::json(['success' => true, 'message' => 'Image uploaded successfully', 'image' => $result['image']]);
            } else {
                Response::json(['success' => false, 'message' => $result['message'] ?? 'Failed to upload image'], 400);
            }
        } catch (Exception $e) {
            Logger::error('Error storing image: ' . $e->getMessage());
            Response::json(['success' => false, 'message' => 'An error occurred while uploading image'], 500);
        }
    }
    
    public function getImage() {
        $request = Request::getInstance();
        $picId = $request->get('id');
        
        // Ensure picId is a scalar value
        if (is_array($picId)) {
            $picId = $picId[0] ?? null;
        }
        
        if (!$picId) {
            Response::json(['success' => false, 'message' => 'Image ID required'], 400);
            return;
        }
        
        $image = $this->investmentService->getImage($picId);
        
        if ($image) {
            Response::json(['success' => true, 'image' => $image]);
        } else {
            Response::json(['success' => false, 'message' => 'Image not found'], 404);
        }
    }
    
    public function updateImage($picId) {
        $request = Request::getInstance();

        try {
            if (!$picId) {
                Response::json(['success' => false, 'message' => 'Image ID required'], 400);
                return;
            }
            
            $data = [
                'pictitle' => $request->post('pictitle', ''),
                'picstatus' => $request->post('picstatus', 1),
            ];
            
            // Handle file upload if new file provided
            if (isset($_FILES['picurl']) && $_FILES['picurl']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = uploadFile($_FILES['picurl'], 'pictures');
                if ($uploadResult['success']) {
                    $data['picurl'] = $uploadResult['filename'];
                } else {
                    Response::json(['success' => false, 'message' => $uploadResult['message']], 400);
                    return;
                }
            }
            
            $result = $this->investmentService->updateImage($picId, $data);
            
            if ($result['success']) {
                Response::json(['success' => true, 'message' => 'Image updated successfully']);
            } else {
                Response::json(['success' => false, 'message' => $result['message'] ?? 'Failed to update image'], 400);
            }
        } catch (Exception $e) {
            Logger::error('Error updating image: ' . $e->getMessage());
            Response::json(['success' => false, 'message' => 'An error occurred while updating image'], 500);
        }
    }
    
    public function deleteImage($picId) {
        $request = Request::getInstance();

        
        try {
            if (!$picId) {
                Response::json(['success' => false, 'message' => 'Image ID required'], 400);
                return;
            }
            
            $result = $this->investmentService->deleteImage($picId);
            
            if ($result['success']) {
                Response::json(['success' => true, 'message' => 'Image deleted successfully']);
            } else {
                Response::json(['success' => false, 'message' => $result['message'] ?? 'Failed to delete image'], 400);
            }
        } catch (Exception $e) {
            Logger::error('Error deleting image: ' . $e->getMessage());
            Response::json(['success' => false, 'message' => 'An error occurred while deleting image'], 500);
        }
    }
    
    public function getProjectImages($itemId) {
        $request = Request::getInstance();
        
        if (!$itemId) {
            Response::json(['success' => false, 'message' => 'Project ID required'], 400);
            return;
        }
        
        $images = $this->investmentService->getProjectImages($itemId);
        Response::json(['success' => true, 'images' => $images]);
    }
    
    // ==================== INSPECTION & INVESTORS ====================
    
    public function getProjectInspections($itemId) {
        
        if (!$itemId) {
            Response::json(['success' => false, 'message' => 'Project ID required'], 400);
            return;
        }
        
        try {
            $inspections = $this->investmentService->getProjectInspections($itemId);
            Response::json(['success' => true, 'inspections' => $inspections]);
        } catch (Exception $e) {
            Logger::error('Error fetching inspections: ' . $e->getMessage());
            Response::json(['success' => false, 'message' => 'An error occurred while fetching inspections'], 500);
        }
    }
    
    public function getProjectInvestors($itemId) {
        
        if (!$itemId) {
            Response::json(['success' => false, 'message' => 'Project ID required'], 400);
            return;
        }
        
        try {
            $investors = $this->investmentService->getProjectInvestors($itemId);
            Response::json(['success' => true, 'investors' => $investors]);
        } catch (Exception $e) {
            Logger::error('Error fetching investors: ' . $e->getMessage());
            Response::json(['success' => false, 'message' => 'An error occurred while fetching investor information'], 500);
        }
    }
}
