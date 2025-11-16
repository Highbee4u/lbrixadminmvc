<?php
class Paginator {
    private $totalItems;
    private $itemsPerPage;
    private $currentPage;
    private $totalPages;
    private $data;
    private $url;

    public function __construct($data, $totalItems, $itemsPerPage = 15, $currentPage = 1, $url = '') {
        $this->data = $data;
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = max(1, $currentPage);
        $this->totalPages = max(1, ceil($totalItems / $itemsPerPage));
        $this->url = $url ?: $_SERVER['REQUEST_URI'];
    }

    public static function paginate($query, $perPage = 15, $page = null) {
        $page = $page ?? (int)($_GET['page'] ?? 1);
        $page = max(1, $page);
        
        $db = Database::getInstance();
        
        // Get total count
        $countQuery = preg_replace('/SELECT .* FROM/i', 'SELECT COUNT(*) as total FROM', $query, 1);
        $countResult = $db->selectOne($countQuery);
        $total = $countResult['total'] ?? 0;
        
        // Add LIMIT and OFFSET
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT $perPage OFFSET $offset";
        
        $data = $db->select($query);
        
        return new self($data, $total, $perPage, $page);
    }

    public function items() {
        return $this->data;
    }

    public function total() {
        return $this->totalItems;
    }

    public function perPage() {
        return $this->itemsPerPage;
    }

    public function currentPage() {
        return $this->currentPage;
    }

    public function lastPage() {
        return $this->totalPages;
    }

    public function hasMorePages() {
        return $this->currentPage < $this->totalPages;
    }

    public function hasPages() {
        return $this->totalPages > 1;
    }

    public function onFirstPage() {
        return $this->currentPage <= 1;
    }

    public function onLastPage() {
        return $this->currentPage >= $this->totalPages;
    }

    public function firstItem() {
        if ($this->totalItems === 0) {
            return 0;
        }
        return (($this->currentPage - 1) * $this->itemsPerPage) + 1;
    }

    public function lastItem() {
        if ($this->totalItems === 0) {
            return 0;
        }
        return min($this->currentPage * $this->itemsPerPage, $this->totalItems);
    }

    public function isEmpty() {
        return empty($this->data);
    }

    public function isNotEmpty() {
        return !$this->isEmpty();
    }

    public function count() {
        return count($this->data);
    }

    public function url($page) {
        $url = strtok($this->url, '?');
        $query = parse_url($this->url, PHP_URL_QUERY);
        parse_str($query ?? '', $params);
        $params['page'] = $page;
        return $url . '?' . http_build_query($params);
    }

    public function previousPageUrl() {
        if ($this->currentPage > 1) {
            return $this->url($this->currentPage - 1);
        }
        return null;
    }

    public function nextPageUrl() {
        if ($this->currentPage < $this->totalPages) {
            return $this->url($this->currentPage + 1);
        }
        return null;
    }

    public function links($onEachSide = 3) {
        if ($this->totalPages <= 1) {
            return '';
        }

        $html = '<nav aria-label="Page navigation">';
        $html .= '<ul class="pagination justify-content-center">';

        // Previous button
        if ($this->onFirstPage()) {
            $html .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->previousPageUrl() . '">Previous</a></li>';
        }

        // Page numbers
        $start = max(1, $this->currentPage - $onEachSide);
        $end = min($this->totalPages, $this->currentPage + $onEachSide);

        // First page
        if ($start > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->url(1) . '">1</a></li>';
            if ($start > 2) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        // Middle pages
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $this->currentPage) {
                $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="' . $this->url($i) . '">' . $i . '</a></li>';
            }
        }

        // Last page
        if ($end < $this->totalPages) {
            if ($end < $this->totalPages - 1) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->url($this->totalPages) . '">' . $this->totalPages . '</a></li>';
        }

        // Next button
        if ($this->onLastPage()) {
            $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->nextPageUrl() . '">Next</a></li>';
        }

        $html .= '</ul>';
        $html .= '</nav>';

        return $html;
    }

    public function simpleLinks() {
        if ($this->totalPages <= 1) {
            return '';
        }

        $html = '<nav aria-label="Page navigation">';
        $html .= '<ul class="pagination">';

        if ($this->onFirstPage()) {
            $html .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->previousPageUrl() . '">Previous</a></li>';
        }

        if ($this->onLastPage()) {
            $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->nextPageUrl() . '">Next</a></li>';
        }

        $html .= '</ul>';
        $html .= '</nav>';

        return $html;
    }

    public function info() {
        if ($this->totalItems === 0) {
            return 'No items found';
        }
        return "Showing {$this->firstItem()} to {$this->lastItem()} of {$this->totalItems} items";
    }

    public function toArray() {
        return [
            'current_page' => $this->currentPage,
            'data' => $this->data,
            'first_page_url' => $this->url(1),
            'from' => $this->firstItem(),
            'last_page' => $this->totalPages,
            'last_page_url' => $this->url($this->totalPages),
            'next_page_url' => $this->nextPageUrl(),
            'path' => strtok($this->url, '?'),
            'per_page' => $this->itemsPerPage,
            'prev_page_url' => $this->previousPageUrl(),
            'to' => $this->lastItem(),
            'total' => $this->totalItems,
        ];
    }

    public function toJson() {
        return json_encode($this->toArray());
    }
}
