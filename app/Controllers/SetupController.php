<?php
class SetupController extends Controller {
    private $setupService;

    public function __construct() {
        parent::__construct();
        $this->requireAuth(); // Protect all methods
        $this->setupService = new SetupService();
    }

    // ==================== COUNTRIES ====================
    public function countries() {
        $countries = $this->setupService->getCountries();
        $this->viewWithLayout('setup/countries', [
            'countries' => $countries,
            'title' => 'Countries'
        ]);
    }

    // ==================== STATES ====================
    public function states() {
        $states = $this->setupService->getStates();
        $countries = $this->setupService->getCountries();
        $this->viewWithLayout('setup/states', [
            'states' => $states,
            'countries' => $countries,
            'title' => 'States'
        ]);
    }

    public function getStatesByCountry($countryid) {
        $states = $this->setupService->getStatesByCountry($countryid);
        Response::json(['success' => true, 'states' => $states]);
    }

    // ==================== SUBLOCATIONS ====================
    public function sublocations() {
        $sublocations = $this->setupService->getSublocations();
        $states = $this->setupService->getStates();
        $countries = $this->setupService->getCountries();
        $this->viewWithLayout('setup/sublocations', [
            'sublocations' => $sublocations,
            'states' => $states,
            'countries' => $countries,
            'title' => 'Sub-locations'
        ]);
    }

    // ==================== CURRENCY ====================
    public function currency() {
        $currencies = $this->setupService->getCurrencies();
        $countries = $this->setupService->getCountries();
        $this->viewWithLayout('setup/currency', [
            'currencies' => $currencies,
            'countries' => $countries,
            'title' => 'Currency'
        ]);
    }

    // ==================== ITEM TYPES ====================
    public function itemTypes() {
        $itemTypes = $this->setupService->getItemTypes();
        $itemServiceTabList = $this->setupService->getItemServiceTypes();
        $itemProfileOptionsList = $this->setupService->getItemProfileOptions();

        $this->viewWithLayout('setup/item-types', [
            'itemTypes' => $itemTypes,
            'itemServiceTabList' => $itemServiceTabList,
            'itemProfileOptionsList' => $itemProfileOptionsList,
            'title' => 'Item Types'
        ]);
    }

    // ==================== ITEM DOC TYPES ====================
    public function itemDocTypes() {
        $itemDocTypes = $this->setupService->getItemDocTypes();
        $this->viewWithLayout('setup/item-doc-types', [
            'itemdoctypes' => $itemDocTypes,
            'title' => 'Item Document Types'
        ]);
    }

    // ==================== ITEM PIC TYPES ====================
    public function itemPicTypes() {
        $itemPicTypes = $this->setupService->getItemPicTypes();
        $this->viewWithLayout('setup/item-pic-types', [
            'itempicypes' => $itemPicTypes,
            'title' => 'Item Picture Types'
        ]);
    }

    // ==================== INSPECT PIC TYPES ====================
    public function inspectPicTypes() {
        $inspectPicTypes = $this->setupService->getInspectPicTypes();
        $this->viewWithLayout('setup/inspect-pic-types', [
            'inspectionpictypelist' => $inspectPicTypes,
            'title' => 'Inspection Picture Types'
        ]);
    }

    // ==================== PAYMENT TERMS ====================
    public function paymentTerms() {
        $paymentTerms = $this->setupService->getPaymentTerms();
        $this->viewWithLayout('setup/payment-terms', [
            'paymentterms' => $paymentTerms,
            'title' => 'Payment Terms'
        ]);
    }

    // ==================== INSPECTION DOC TYPES ====================
    public function inspectionDocTypes() {
        $inspectionDocTypes = $this->setupService->getInspectionDocTypes();
        $this->viewWithLayout('setup/inspection-doc-types', [
            'inspectiondoctypes' => $inspectionDocTypes,
            'title' => 'Inspection Document Types'
        ]);
    }

    // ==================== OWNERSHIP TYPES ====================
    public function ownershipTypes() {
        $ownershipTypes = $this->setupService->getOwnershipTypes();
        $this->viewWithLayout('setup/ownership-types', [
            'ownershiptypes' => $ownershipTypes,
            'title' => 'Ownership Types'
        ]);
    }

    // ==================== PROJECT TYPES ====================
    public function projectTypes() {
        $projectTypes = $this->setupService->getProjectTypes();
        $this->viewWithLayout('setup/project-types', [
            'projecttypes' => $projectTypes,
            'title' => 'Project Types'
        ]);
    }

    // ==================== LIST TYPES ====================
    public function listTypes() {
        $listTypes = $this->setupService->getListTypes();
        $this->viewWithLayout('setup/list-types', [
            'listtypes' => $listTypes,
            'title' => 'List Types'
        ]);
    }

    // ==================== INVESTOR SETUP ====================
    public function investorSetup() {
        $investOptions = $this->setupService->getInvestOptions();
        $this->viewWithLayout('setup/investor-setup', [
            'investoptions' => $investOptions,
            'title' => 'Investor Setup'
        ]);
    }

    // ==================== ACTIONS: COUNTRIES ====================
    public function storeCountry() {
        $request = Request::getInstance();
        $data = [
            'country' => $request->input('country'),
            'countrycode' => $request->input('countrycode'),
        ];
        $result = $this->setupService->createCountry($data);
        Response::json($result);
    }

    public function updateCountry($id) {
        $request = Request::getInstance();
        $data = [
            'country' => $request->input('country'),
            'countrycode' => $request->input('countrycode'),
        ];
        $result = $this->setupService->updateCountry($id, $data);
        Response::json($result);
    }

    public function destroyCountry($id) {
        $result = $this->setupService->deleteCountry($id);
        Response::json($result);
    }

    // ==================== ACTIONS: STATES ====================
    public function storeState() {
        $request = Request::getInstance();
        $data = [
            'countryid' => $request->input('countryid'),
            'state' => $request->input('state'),
        ];
        $result = $this->setupService->createState($data);
        Response::json($result);
    }

    public function updateState($id) {
        $request = Request::getInstance();
        $data = [
            'countryid' => $request->input('countryid'),
            'state' => $request->input('state'),
        ];
        $result = $this->setupService->updateState($id, $data);
        Response::json($result);
    }

    public function destroyState($id) {
        $result = $this->setupService->deleteState($id);
        Response::json($result);
    }

    // ==================== ACTIONS: SUBLOCATIONS ====================
    public function storeSublocation() {
        $request = Request::getInstance();
        $data = [
            'countryid' => $request->input('countryid'),
            'stateid' => $request->input('stateid'),
            'sublocation' => $request->input('sublocation'),
        ];
        $result = $this->setupService->createSublocation($data);
        Response::json($result);
    }

    public function updateSublocation($id) {
        $request = Request::getInstance();
        $data = [
            'countryid' => $request->input('countryid'),
            'stateid' => $request->input('stateid'),
            'sublocation' => $request->input('sublocation'),
        ];
        $result = $this->setupService->updateSublocation($id, $data);
        Response::json($result);
    }

    public function destroySublocation($id) {
        $result = $this->setupService->deleteSublocation($id);
        Response::json($result);
    }

    // ==================== ACTIONS: CURRENCY ====================
    public function storeCurrency() {
        $request = Request::getInstance();
        $data = [
            'currency' => $request->input('currency'),
            'currencycode' => $request->input('currencycode'),
            'currencysymbol' => $request->input('currencysymbol'),
            'exchangerate' => $request->input('exchangerate'),
        ];
        $result = $this->setupService->createCurrency($data);
        Response::json($result);
    }

    public function updateCurrency($id) {
        $request = Request::getInstance();
        $data = [
            'currency' => $request->input('currency'),
            'currencycode' => $request->input('currencycode'),
            'currencysymbol' => $request->input('currencysymbol'),
            'exchangerate' => $request->input('exchangerate'),
        ];
        $result = $this->setupService->updateCurrency($id, $data);
        Response::json($result);
    }

    public function destroyCurrency($id) {
        $result = $this->setupService->deleteCurrency($id);
        Response::json($result);
    }

    // ==================== ACTIONS: ITEM TYPES ====================
    public function storeItemType() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createItemType($data);
        Response::json($result);
    }

    public function updateItemType($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updateItemType($id, $data);
        Response::json($result);
    }

    public function destroyItemType($id) {
        $result = $this->setupService->deleteItemType($id);
        Response::json($result);
    }

    // ==================== ACTIONS: ITEM SERVICE TYPES ====================
    public function storeItemServiceType() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createItemServiceType($data);
        Response::json($result);
    }

    public function updateItemServiceType($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updateItemServiceType($id, $data);
        Response::json($result);
    }

    public function destroyItemServiceType($id) {
        $result = $this->setupService->deleteItemServiceType($id);
        Response::json($result);
    }

    // ==================== ACTIONS: ITEM PROFILE OPTIONS ====================
    public function getItemProfileOption($id) {
        $option = $this->setupService->getItemProfileOptionById($id);
        Response::json(['success' => true, 'data' => $option]);
    }

    public function storeItemProfileOption() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
            'basetitle' => $request->input('basetitle'),
            'listtype' => $request->input('listtype'),
            'listmenu' => $request->input('listmenu'),
            'itemtypeid' => $request->input('itemtypeid'),
        ];
        $result = $this->setupService->createItemProfileOption($data);
        Response::json($result);
    }

    public function updateItemProfileOption($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
            'basetitle' => $request->input('basetitle'),
            'listtype' => $request->input('listtype'),
            'listmenu' => $request->input('listmenu'),
            'itemtypeid' => $request->input('itemtypeid'),
        ];
        $result = $this->setupService->updateItemProfileOption($id, $data);
        Response::json($result);
    }

    public function destroyItemProfileOption($id) {
        $result = $this->setupService->deleteItemProfileOption($id);
        Response::json($result);
    }

    // ==================== ACTIONS: ITEM DOC TYPES ====================
    public function storeItemDocType() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createItemDocType($data);
        Response::json($result);
    }

    public function updateItemDocType($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updateItemDocType($id, $data);
        Response::json($result);
    }

    public function destroyItemDocType($id) {
        $result = $this->setupService->deleteItemDocType($id);
        Response::json($result);
    }

    // ==================== ACTIONS: ITEM PIC TYPES ====================
    public function storeItemPicType() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createItemPicType($data);
        Response::json($result);
    }

    public function updateItemPicType($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updateItemPicType($id, $data);
        Response::json($result);
    }

    public function destroyItemPicType($id) {
        $result = $this->setupService->deleteItemPicType($id);
        Response::json($result);
    }

    // ==================== ACTIONS: INSPECT PIC TYPES ====================
    public function storeInspectPicType() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createInspectPicType($data);
        Response::json($result);
    }

    public function updateInspectPicType($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updateInspectPicType($id, $data);
        Response::json($result);
    }

    public function destroyInspectPicType($id) {
        $result = $this->setupService->deleteInspectPicType($id);
        Response::json($result);
    }

    // ==================== ACTIONS: PAYMENT TERMS ====================
    public function storePaymentTerm() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createPaymentTerm($data);
        Response::json($result);
    }

    public function updatePaymentTerm($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updatePaymentTerm($id, $data);
        Response::json($result);
    }

    public function destroyPaymentTerm($id) {
        $result = $this->setupService->deletePaymentTerm($id);
        Response::json($result);
    }

    // ==================== ACTIONS: INSPECTION DOC TYPES ====================
    public function storeInspectionDocType() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createInspectionDocType($data);
        Response::json($result);
    }

    public function updateInspectionDocType($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updateInspectionDocType($id, $data);
        Response::json($result);
    }

    public function destroyInspectionDocType($id) {
        $result = $this->setupService->deleteInspectionDocType($id);
        Response::json($result);
    }

    // ==================== ACTIONS: OWNERSHIP TYPES ====================
    public function storeOwnershipType() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createOwnershipType($data);
        Response::json($result);
    }

    public function updateOwnershipType($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updateOwnershipType($id, $data);
        Response::json($result);
    }

    public function destroyOwnershipType($id) {
        $result = $this->setupService->deleteOwnershipType($id);
        Response::json($result);
    }

    // ==================== ACTIONS: PROJECT TYPES ====================
    public function storeProjectType() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createProjectType($data);
        Response::json($result);
    }

    public function updateProjectType($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updateProjectType($id, $data);
        Response::json($result);
    }

    public function destroyProjectType($id) {
        $result = $this->setupService->deleteProjectType($id);
        Response::json($result);
    }

    // ==================== ACTIONS: LIST TYPES ====================
    public function storeListType() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createListType($data);
        Response::json($result);
    }

    public function updateListType($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updateListType($id, $data);
        Response::json($result);
    }

    public function destroyListType($id) {
        $result = $this->setupService->deleteListType($id);
        Response::json($result);
    }

    // ==================== ACTIONS: INVEST OPTIONS ====================
    public function storeInvestOption() {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->createInvestOption($data);
        Response::json($result);
    }

    public function updateInvestOption($id) {
        $request = Request::getInstance();
        $data = [
            'title' => $request->input('title'),
        ];
        $result = $this->setupService->updateInvestOption($id, $data);
        Response::json($result);
    }

    public function destroyInvestOption($id) {
        $result = $this->setupService->deleteInvestOption($id);
        Response::json($result);
    }
}
