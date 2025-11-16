<?php
class RequestController extends Controller {

    private $requestService;

    public function __construct() {
        parent::__construct();
        $this->requestService = new RequestService();
    }

    /**
     * Handle property requests - both listing and single view
     */
    public function properties($id = null) {
        $request = Request::getInstance();

        // If ID is provided, handle single property request
        if ($id) {
            return $this->handlePropertyRequest($id);
        }

        // Otherwise, display property requests list
        $page = (int)$request->get('page', 1);
        $perPage = 12;

        $properties = $this->requestService->getPropertyRequests($page, $perPage);

        $this->viewWithLayout('requests/properties', compact('properties'));
    }

    /**
     * Handle single property request (view and actions)
     */
    private function handlePropertyRequest($id) {
        $request = Request::getInstance();

        // Handle match/unmatch/close actions
        if ($request->get('confirmitem')) {
            $itemid = $request->get('confirmitem');
            if ($this->requestService->matchRequestToItem($id, $itemid)) {
                $_SESSION['success_message'] = 'Property matched successfully';
            } else {
                $_SESSION['error_message'] = 'Could not match property';
            }
            $this->redirect('requests/properties/' . $id);
            return;
        }

        if ($request->get('cancelitem')) {
            if ($this->requestService->unmatchRequestFromItem($id)) {
                $_SESSION['success_message'] = 'Property un-matched successfully';
            } else {
                $_SESSION['error_message'] = 'Could not un-match property';
            }
            $this->redirect('requests/properties/' . $id);
            return;
        }

        if ($request->get('requeststatus')) {
            if ($this->requestService->updateRequestStatus($id, 1)) {
                $_SESSION['success_message'] = 'Properties request closed successfully';
            } else {
                $_SESSION['error_message'] = 'Could not close properties request';
            }
            $this->redirect('requests/properties/' . $id);
            return;
        }

        $property = $this->requestService->getPropertyRequestById($id);

        if (!$property) {
            $property = $this->requestService->getInvestmentRequestById($id);
        }

        if (!$property) {
            $this->redirect('requests/properties');
            return;
        }

        // Get matching items with pagination
        $page = (int)$request->get('page', 1);
        $perPage = 12;
        $matchingItems = $this->requestService->getMatchingItems($id, $page, $perPage);

        $this->viewWithLayout('requests/view-property', compact('property', 'matchingItems'));
    }


    /**
     * Handle investment requests - both listing and single view
     */
    public function investments($id = null) {
        $request = Request::getInstance();

        // If ID is provided, handle single investment request
        if ($id) {
            return $this->handleInvestmentRequest($id);
        }

        // Otherwise, display investment requests list
        $page = (int)$request->get('page', 1);
        $perPage = 12;

        $investments = $this->requestService->getInvestmentRequests($page, $perPage);

        $this->viewWithLayout('requests/investments', compact('investments'));
    }

    /**
     * Handle single investment request (view and actions)
     */
    private function handleInvestmentRequest($id) {
        $request = Request::getInstance();

        // Handle match/unmatch/close actions
        if ($request->get('confirmitem')) {
            $itemid = $request->get('confirmitem');
            if ($this->requestService->matchRequestToItem($id, $itemid)) {
                $_SESSION['success_message'] = 'Investment matched successfully';
            } else {
                $_SESSION['error_message'] = 'Could not match investment';
            }
            $this->redirect('requests/investments/' . $id);
            return;
        }

        if ($request->get('cancelitem')) {
            if ($this->requestService->unmatchRequestFromItem($id)) {
                $_SESSION['success_message'] = 'Investment un-matched successfully';
            } else {
                $_SESSION['error_message'] = 'Could not un-match investment';
            }
            $this->redirect('requests/investments/' . $id);
            return;
        }

        if ($request->get('requeststatus')) {
            if ($this->requestService->updateRequestStatus($id, 1)) {
                $_SESSION['success_message'] = 'Investment request closed successfully';
            } else {
                $_SESSION['error_message'] = 'Could not close investment request';
            }
            $this->redirect('requests/investments/' . $id);
            return;
        }

        $investment = $this->requestService->getInvestmentRequestById($id);

        if (!$investment) {
            $this->redirect('requests/investments');
            return;
        }

        // Get matching items with pagination
        $page = (int)$request->get('page', 1);
        $perPage = 12;
        $matchingItems = $this->requestService->getMatchingItems($id, $page, $perPage);

        $this->viewWithLayout('requests/view-investment', compact('investment', 'matchingItems'));
    }

}

