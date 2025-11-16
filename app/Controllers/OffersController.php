<?php
class OffersController extends Controller {
    private $offerService;

    public function __construct() {
        parent::__construct();
        $this->offerService = new OfferService();
    }

    private function getFilters() {
        $request = Request::getInstance();
        return [
            'transaction_type' => $request->get('transaction_type'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'status' => $request->get('status'),
            'offerdate' => $request->get('offerdate'),
            'attorney' => $request->get('attorney'),
        ];
    }

    private function buildPaginationHtml($current, $last) {
        if ($last <= 1) { return ''; }

        // Preserve existing query params except page
        $query = $_GET ?? [];
        unset($query['page']);

        $buildLink = function($page) use ($query) {
            $params = $query;
            $params['page'] = $page;
            $qs = http_build_query($params);
            return '?' . $qs;
        };

        ob_start();
        echo '<nav aria-label="Page navigation"><ul class="pagination">';

        // Prev
        if ($current > 1) {
            echo '<li class="page-item"><a class="page-link" href="' . htmlspecialchars($buildLink($current - 1)) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link"><span aria-hidden="true">&laquo;</span></span></li>';
        }

        $start = max(1, $current - 2);
        $end = min($last, $current + 2);
        if ($start > 1) {
            echo '<li class="page-item"><a class="page-link" href="' . htmlspecialchars($buildLink(1)) . '">1</a></li>';
            if ($start > 2) {
                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        for ($i = $start; $i <= $end; $i++) {
            $active = ($i == $current) ? ' active' : '';
            echo '<li class="page-item' . $active . '"><a class="page-link" href="' . htmlspecialchars($buildLink($i)) . '">' . $i . '</a></li>';
        }

        if ($end < $last) {
            if ($end < $last - 1) {
                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            echo '<li class="page-item"><a class="page-link" href="' . htmlspecialchars($buildLink($last)) . '">' . $last . '</a></li>';
        }

        // Next
        if ($current < $last) {
            echo '<li class="page-item"><a class="page-link" href="' . htmlspecialchars($buildLink($current + 1)) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link"><span aria-hidden="true">&raquo;</span></span></li>';
        }

        echo '</ul></nav>';
        return ob_get_clean();
    }

    public function activeProperty() {
        $request = Request::getInstance();
        $page = (int)$request->get('page', 1);
        $perPage = 10;

        $filters = $this->getFilters();
        $result = $this->offerService->getActiveProperties($filters, $page, $perPage);

        $bidTypes = $this->offerService->getBidTypes();
        $attorneys = $this->offerService->getAttorneys();

        $pagination = $this->buildPaginationHtml($result['current_page'], $result['last_page']);

        $this->viewWithLayout('offers/active-property', [
            'activeProperties' => $result['data'],
            'bidTypes' => $bidTypes,
            'attorneys' => $attorneys,
            'filters' => $filters,
            'pagination' => $pagination,
            'title' => 'Active Property Offers',
        ]);
    }

    public function closedProperty() {
        $request = Request::getInstance();
        $page = (int)$request->get('page', 1);
        $perPage = 10;

        $filters = $this->getFilters();
        $result = $this->offerService->getClosedProperties($filters, $page, $perPage);

        $bidTypes = $this->offerService->getBidTypes();
        $attorneys = $this->offerService->getAttorneys();

        $pagination = $this->buildPaginationHtml($result['current_page'], $result['last_page']);

        $this->viewWithLayout('offers/closed-property', [
            'closedProperties' => $result['data'],
            'bidTypes' => $bidTypes,
            'attorneys' => $attorneys,
            'filters' => $filters,
            'pagination' => $pagination,
            'title' => 'Closed Property Offers',
        ]);
    }

    public function activeProject() {
        $request = Request::getInstance();
        $page = (int)$request->get('page', 1);
        $perPage = 10;

        $filters = $this->getFilters();
        $result = $this->offerService->getActiveProjects($filters, $page, $perPage);

        $bidTypes = $this->offerService->getBidTypes();
        $attorneys = $this->offerService->getAttorneys();

        $pagination = $this->buildPaginationHtml($result['current_page'], $result['last_page']);

        $this->viewWithLayout('offers/active-project', [
            'activeProjects' => $result['data'],
            'bidTypes' => $bidTypes,
            'attorneys' => $attorneys,
            'filters' => $filters,
            'pagination' => $pagination,
            'title' => 'Active Project Offers',
        ]);
    }

    public function closedProject() {
        $request = Request::getInstance();
        $page = (int)$request->get('page', 1);
        $perPage = 10;

        $filters = $this->getFilters();
        $result = $this->offerService->getClosedProjects($filters, $page, $perPage);

        $bidTypes = $this->offerService->getBidTypes();
        $attorneys = $this->offerService->getAttorneys();

        $pagination = $this->buildPaginationHtml($result['current_page'], $result['last_page']);

        $this->viewWithLayout('offers/closed-project', [
            'closedProjects' => $result['data'],
            'bidTypes' => $bidTypes,
            'attorneys' => $attorneys,
            'filters' => $filters,
            'pagination' => $pagination,
            'title' => 'Closed Project Offers',
        ]);
    }

    public function propertyDetail($id) {
        $property = $this->offerService->getItemBidDetail($id);

        if (!$property) {
            // Fallback to a simple 404 view if available
            http_response_code(404);
            return $this->view('errors/404', []);
        }

        $this->viewWithLayout('pages/property-detail', [
            'property' => $property,
            'title' => 'Property Detail',
        ]);
    }
}
