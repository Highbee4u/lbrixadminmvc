<?php
class Pagination {
    private $currentPage;
    private $perPage;
    private $total;
    private $lastPage;
    private $data;
    private $from;
    private $to;

    public function __construct($total, $perPage = 15, $currentPage = 1) {
        $this->total = (int) $total;
        $this->perPage = (int) $perPage;
        $this->currentPage = max(1, (int) $currentPage);
        $this->lastPage = max(1, (int) ceil($this->total / $this->perPage));
        
        // Ensure current page doesn't exceed last page
        if ($this->currentPage > $this->lastPage) {
            $this->currentPage = $this->lastPage;
        }

        $this->calculateRange();
    }

    private function calculateRange() {
        $this->from = (($this->currentPage - 1) * $this->perPage) + 1;
        $this->to = min($this->currentPage * $this->perPage, $this->total);

        if ($this->total === 0) {
            $this->from = 0;
            $this->to = 0;
        }
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function getData() {
        return $this->data;
    }

    public function getOffset() {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function getLimit() {
        return $this->perPage;
    }

    public function currentPage() {
        return $this->currentPage;
    }

    public function lastPage() {
        return $this->lastPage;
    }

    public function perPage() {
        return $this->perPage;
    }

    public function total() {
        return $this->total;
    }

    public function hasPages() {
        return $this->lastPage > 1;
    }

    public function hasMorePages() {
        return $this->currentPage < $this->lastPage;
    }

    public function onFirstPage() {
        return $this->currentPage === 1;
    }

    public function onLastPage() {
        return $this->currentPage === $this->lastPage;
    }

    public function previousPageUrl() {
        if ($this->currentPage > 1) {
            return $this->url($this->currentPage - 1);
        }
        return null;
    }

    public function nextPageUrl() {
        if ($this->currentPage < $this->lastPage) {
            return $this->url($this->currentPage + 1);
        }
        return null;
    }

    public function url($page) {
        $query = $_GET;
        $query['page'] = $page;
        
        $baseUrl = strtok($_SERVER['REQUEST_URI'], '?');
        return $baseUrl . '?' . http_build_query($query);
    }

    public function links($onEachSide = 3) {
        if (!$this->hasPages()) {
            return '';
        }

        $html = '<nav aria-label="Page navigation">';
        $html .= '<ul class="pagination">';

        // Previous button
        if ($this->onFirstPage()) {
            $html .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->previousPageUrl() . '">Previous</a></li>';
        }

        // Page numbers
        $start = max(1, $this->currentPage - $onEachSide);
        $end = min($this->lastPage, $this->currentPage + $onEachSide);

        // First page
        if ($start > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->url(1) . '">1</a></li>';
            if ($start > 2) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        // Pages
        for ($page = $start; $page <= $end; $page++) {
            if ($page === $this->currentPage) {
                $html .= '<li class="page-item active"><span class="page-link">' . $page . '</span></li>';
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="' . $this->url($page) . '">' . $page . '</a></li>';
            }
        }

        // Last page
        if ($end < $this->lastPage) {
            if ($end < $this->lastPage - 1) {
                $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->url($this->lastPage) . '">' . $this->lastPage . '</a></li>';
        }

        // Next button
        if ($this->hasMorePages()) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->nextPageUrl() . '">Next</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
        }

        $html .= '</ul>';
        $html .= '</nav>';

        return $html;
    }

    public function simpleLinks() {
        $html = '<nav aria-label="Page navigation">';
        $html .= '<ul class="pagination">';

        // Previous button
        if ($this->onFirstPage()) {
            $html .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->previousPageUrl() . '">Previous</a></li>';
        }

        // Next button
        if ($this->hasMorePages()) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $this->nextPageUrl() . '">Next</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
        }

        $html .= '</ul>';
        $html .= '</nav>';

        return $html;
    }

    public function showing() {
        if ($this->total === 0) {
            return 'Showing 0 results';
        }

        return sprintf(
            'Showing %d to %d of %d results',
            $this->from,
            $this->to,
            $this->total
        );
    }

    public function toArray() {
        return [
            'current_page' => $this->currentPage,
            'data' => $this->data,
            'first_page_url' => $this->url(1),
            'from' => $this->from,
            'last_page' => $this->lastPage,
            'last_page_url' => $this->url($this->lastPage),
            'next_page_url' => $this->nextPageUrl(),
            'per_page' => $this->perPage,
            'prev_page_url' => $this->previousPageUrl(),
            'to' => $this->to,
            'total' => $this->total,
        ];
    }

    public function toJson() {
        return json_encode($this->toArray());
    }
}
