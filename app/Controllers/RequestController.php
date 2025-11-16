<?php
class RequestController extends Controller {

    private $requestService;

    public function __construct() {
        parent::__construct();
        $this->requestService = new RequestService();
    }

    /**
     * Display property requests (servicetypeid 1 or 2)
     */
    public function properties() {
        $request = Request::getInstance();
        $page = (int)$request->get('page', 1);
        $perPage = 12;
        
        $properties = $this->requestService->getPropertyRequests($page, $perPage);

        $this->viewWithLayout('requests/properties', compact('properties'));
    }

    /**
     * View a single property request
     */
    public function viewProperty() {
        $request = Request::getInstance();
        $id = $request->get('id');

        if (!$id) {
            $this->redirect('/requests/properties');
            return;
        }

        // Handle match/unmatch/close actions
        if ($request->get('confirmitem')) {
            $itemid = $request->get('confirmitem');
            if ($this->requestService->matchRequestToItem($id, $itemid)) {
                $_SESSION['success_message'] = 'Property matched successfully';
            } else {
                $_SESSION['error_message'] = 'Could not match property';
            }
            $this->redirect('/requests/property/view?id=' . $id);
            return;
        }

        if ($request->get('cancelitem')) {
            if ($this->requestService->unmatchRequestFromItem($id)) {
                $_SESSION['success_message'] = 'Property un-matched successfully';
            } else {
                $_SESSION['error_message'] = 'Could not un-match property';
            }
            $this->redirect('/requests/property/view?id=' . $id);
            return;
        }

        if ($request->get('requeststatus')) {
            if ($this->requestService->updateRequestStatus($id, 1)) {
                $_SESSION['success_message'] = 'Properties request closed successfully';
            } else {
                $_SESSION['error_message'] = 'Could not close properties request';
            }
            $this->redirect('/requests/property/view?id=' . $id);
            return;
        }

        $property = $this->requestService->getPropertyRequestById($id);

        if (!$property) {
            $property = $this->requestService->getInvestmentRequestById($id);
        }

        if (!$property) {
            $this->redirect('/requests/properties');
            return;
        }

        // Get matching items
        $matchingItems = $this->requestService->getMatchingItems($id);

        $this->viewWithLayout('requests/view-property', compact('property', 'matchingItems'));
    }

    /**
     * Display investment requests (servicetypeid 3 or 4)
     */
    public function investments() {
        $request = Request::getInstance();
        $page = (int)$request->get('page', 1);
        $perPage = 12;
        
        $investments = $this->requestService->getInvestmentRequests($page, $perPage);

        $this->viewWithLayout('requests/investments', compact('investments'));
    }

    /**
     * View a single investment request
     */
    public function viewInvestment() {
        $request = Request::getInstance();
        $id = $request->get('id');

        if (!$id) {
            $this->redirect('/requests/investments');
            return;
        }

        // Handle match/unmatch/close actions
        if ($request->get('confirmitem')) {
            $itemid = $request->get('confirmitem');
            if ($this->requestService->matchRequestToItem($id, $itemid)) {
                $_SESSION['success_message'] = 'Investment matched successfully';
            } else {
                $_SESSION['error_message'] = 'Could not match investment';
            }
            $this->redirect('/requests/investment/view?id=' . $id);
            return;
        }

        if ($request->get('cancelitem')) {
            if ($this->requestService->unmatchRequestFromItem($id)) {
                $_SESSION['success_message'] = 'Investment un-matched successfully';
            } else {
                $_SESSION['error_message'] = 'Could not un-match investment';
            }
            $this->redirect('/requests/investment/view?id=' . $id);
            return;
        }

        if ($request->get('requeststatus')) {
            if ($this->requestService->updateRequestStatus($id, 1)) {
                $_SESSION['success_message'] = 'Investment request closed successfully';
            } else {
                $_SESSION['error_message'] = 'Could not close investment request';
            }
            $this->redirect('/requests/investment/view?id=' . $id);
            return;
        }

        $investment = $this->requestService->getInvestmentRequestById($id);

        if (!$investment) {
            $this->redirect('/requests/investments');
            return;
        }

        // Get matching items
        $matchingItems = $this->requestService->getMatchingItems($id);

        $this->viewWithLayout('requests/view-investment', compact('investment', 'matchingItems'));
    }
}

