<?php
class AdminSetupController extends Controller {
    private $adminSetupService;

    public function __construct() {
        parent::__construct();
        $this->requireAuth(); // Protect all methods
        $this->adminSetupService = new AdminSetupService();
    }

    // ==================== ADMIN ROLES ====================
    public function roles() {
        $roles = $this->adminSetupService->getAdminRoles();
        $this->viewWithLayout('admin-setup/roles', [
            'roles' => $roles,
            'title' => 'Admin Roles'
        ]);
    }

    public function storeRole() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
            'adminrank' => $request->input('adminrank'),
            'status' => $request->input('status', 1),
        ];
        
        $result = $this->adminSetupService->createAdminRole($data);
        Response::json($result);
    }

    public function updateRole($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
            'adminrank' => $request->input('adminrank'),
            'status' => $request->input('status'),
        ];
        
        $result = $this->adminSetupService->updateAdminRole($id, $data);
        Response::json($result);
    }

    public function destroyRole($id) {
        $result = $this->adminSetupService->deleteAdminRole($id);
        Response::json($result);
    }

    // ==================== SERVICES ====================
    public function services() {
        $services = $this->adminSetupService->getServices();
        $this->viewWithLayout('admin-setup/services', [
            'services' => $services,
            'title' => 'Services'
        ]);
    }

    public function createService() {
        $request = Request::getInstance();
        $data = [
            'code' => $request->input('code'),
            'title' => $request->input('title'),
            'isadmin' => $request->input('isadmin', 0),
            'isparticipant' => $request->input('isparticipant', 0),
        ];
        
        $result = $this->adminSetupService->createService($data);
        Response::json($result);
    }

    public function updateService($id) {
        $request = Request::getInstance();
        $data = [
            'code' => $request->input('code'),
            'title' => $request->input('title'),
            'isadmin' => $request->input('isadmin', 0),
            'isparticipant' => $request->input('isparticipant', 0),
        ];
        
        $result = $this->adminSetupService->updateService($id, $data);
        Response::json($result);
    }

    public function deleteService($id) {
        $result = $this->adminSetupService->deleteService($id);
        Response::json($result);
    }

    // ==================== ITEM SERVICES ====================
    public function itemServices() {
        $itemServices = $this->adminSetupService->getItemServices();
        $services = $this->adminSetupService->getServices();
        $itemTypes = $this->adminSetupService->getItemTypes();
        
        $this->viewWithLayout('admin-setup/item-services', [
            'itemServiceList' => $itemServices,
            'servicelist' => $services,
            'itemTypelist' => $itemTypes,
            'title' => 'Item Services'
        ]);
    }

    public function storeItemService() {
        $request = Request::getInstance();
        $data = [
            'serviceid' => $request->input('serviceid'),
            'itemtypeid' => $request->input('itemtypeid'),
        ];
        
        $result = $this->adminSetupService->createItemService($data);
        Response::json($result);
    }

    public function updateItemService($id) {
        $request = Request::getInstance();
        $data = [
            'serviceid' => $request->input('serviceid'),
            'itemtypeid' => $request->input('itemtypeid'),
        ];
        
        $result = $this->adminSetupService->updateItemService($id, $data);
        Response::json($result);
    }

    public function deleteItemService($id) {
        $result = $this->adminSetupService->deleteItemService($id);
        Response::json($result);
    }

    // ==================== INSPECTION STATUS ====================
    public function inspectionStatus() {
        $statuses = $this->adminSetupService->getInspectionStatuses();
        $this->viewWithLayout('admin-setup/inspection-status', [
            'inpectionStatusList' => $statuses,
            'title' => 'Inspection Status'
        ]);
    }

    public function storeInspectionStatus() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        
        $result = $this->adminSetupService->createInspectionStatus($data);
        Response::json($result);
    }

    public function updateInspectionStatus($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        
        $result = $this->adminSetupService->updateInspectionStatus($id, $data);
        Response::json($result);
    }

    public function deleteInspectionStatus($id) {
        $result = $this->adminSetupService->deleteInspectionStatus($id);
        Response::json($result);
    }

    // ==================== INVESTMENTS ====================
    public function investments() {
        $investments = $this->adminSetupService->getInvestments();
        $optionLists = $this->adminSetupService->getOptionLists();
        $inspectionStatusList = $this->adminSetupService->getInspectionStatuses();
        
        $this->viewWithLayout('admin-setup/investments', [
            'investments' => $investments,
            'optionLists' => $optionLists,
            'inspectionStatusList' => $inspectionStatusList,
            'title' => 'Investments'
        ]);
    }

    public function storeInvestment() {
        $request = Request::getInstance();
        $startdate = $request->input('startdate');
        $data = [
            'title' => $request->input('title'),
            'amount' => $request->input('amount'),
            'jointstatus' => $request->input('jointstatus'),
            'status' => $request->input('status'),
            'startdate' => !empty($startdate) ? $startdate : null,
        ];
        
        $result = $this->adminSetupService->createInvestment($data);
        Response::json($result);
    }

    public function updateInvestment($id) {
        $request = Request::getInstance();
        $startdate = $request->input('startdate');
        $data = [
            'title' => $request->input('title'),
            'amount' => $request->input('amount'),
            'jointstatus' => $request->input('jointstatus'),
            'status' => $request->input('status'),
            'startdate' => !empty($startdate) ? $startdate : null,
        ];
        
        $result = $this->adminSetupService->updateInvestment($id, $data);
        Response::json($result);
    }

    public function deleteInvestment($id) {
        $result = $this->adminSetupService->deleteInvestment($id);
        Response::json($result);
    }

    // ==================== BID TYPES ====================
    public function bidTypes() {
        $bidTypes = $this->adminSetupService->getBidTypes();
        $services = $this->adminSetupService->getServices();
        
        $this->viewWithLayout('admin-setup/bid-types', [
            'bidTypes' => $bidTypes,
            'services' => $services,
            'title' => 'Bid Types'
        ]);
    }

    public function storeBidType() {
        $request = Request::getInstance();
        $data = [
            'serviceid' => $request->input('serviceid'),
            'options' => $request->input('title'),
        ];
        
        $result = $this->adminSetupService->createBidType($data);
        Response::json($result);
    }

    public function updateBidType($id) {
        $request = Request::getInstance();
        $data = [
            'serviceid' => $request->input('serviceid'),
            'options' => $request->input('title'),
        ];
        
        $result = $this->adminSetupService->updateBidType($id, $data);
        Response::json($result);
    }

    public function deleteBidType($id) {
        $result = $this->adminSetupService->deleteBidType($id);
        Response::json($result);
    }
}
