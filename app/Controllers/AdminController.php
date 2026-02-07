<?php
class AdminController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->requireAuth(); // Protect all methods
    }
    public function roles() {
        $roleModel = new AdminRole();
        $roles = $roleModel->getActiveRoles();
        $this->viewWithLayout('admin-setup/roles', ['roles' => $roles]);
    }

    public function itemServices() {
        $itemServiceModel = new ItemService();
        $itemServiceList = $itemServiceModel->getAllWithRelations();
        $this->viewWithLayout('admin-setup/item-services', ['itemServiceList' => $itemServiceList]);
    }

    public function services() {
        $serviceModel = new Service();
        $services = $serviceModel->getAllActive();
        $this->viewWithLayout('admin-setup/services', ['services' => $services]);
    }

    public function inspectionStatus() {
        $inspectionStatusModel = new InspectionStatus();
        $inpectionStatusList = $inspectionStatusModel->getAllActive();
        $this->viewWithLayout('admin-setup/inspection-status', ['inpectionStatusList' => $inpectionStatusList]);
    }

    public function investments() {
        $investmentModel = new Investment();
        $investments = $investmentModel->getAllActive();
        $this->viewWithLayout('admin-setup/investments', ['investments' => $investments]);
    }

    public function bidTypes() {
        $bidTypeModel = new BidType();
        $bidTypes = $bidTypeModel->getAllActive();
        $this->viewWithLayout('admin-setup/bid-types', ['bidTypes' => $bidTypes]);
    }
}
