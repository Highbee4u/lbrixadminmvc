<?php
class DashboardController extends Controller {
    protected $dashboardService;

    public function __construct() {
        parent::__construct();
        $this->dashboardService = new DashboardService();
    }

    /**
     * Display the dashboard.
     */
    public function index() {
        try {
            // Get summary statistics for properties
            $propertySummary = $this->dashboardService->getPropertySummary();
        } catch (Exception $e) {
            Logger::error('Dashboard property summary error: ' . $e->getMessage());
            $propertySummary = [];
        }

        try {
            // Get summary statistics for projects
            $projectSummary = $this->dashboardService->getProjectSummary();
        } catch (Exception $e) {
            Logger::error('Dashboard project summary error: ' . $e->getMessage());
            $projectSummary = [];
        }

        try {
            // Get recent properties
            $recentProperties = $this->dashboardService->getRecentProperties();
        } catch (Exception $e) {
            Logger::error('Dashboard recent properties error: ' . $e->getMessage());
            $recentProperties = [];
        }

        try {
            // Get recent projects
            $recentProjects = $this->dashboardService->getRecentProjects();
        } catch (Exception $e) {
            Logger::error('Dashboard recent projects error: ' . $e->getMessage());
            $recentProjects = [];
        }

        // Prepare data for view
        $data = [
            'title' => 'Dashboard',
            'pageTitle' => 'Dashboard',

            // Property summaries
            'pendingproperties' => $propertySummary['pendingproperties'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'awaitingproperties' => $propertySummary['awaitingproperties'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'concludedinspproperties' => $propertySummary['concludedinspproperties'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'rejectedproperties' => $propertySummary['rejectedproperties'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'approvedproperties' => $propertySummary['approvedproperties'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'awaitinglistingproperties' => $propertySummary['awaitinglistingproperties'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'listedproperties' => $propertySummary['listedproperties'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'closedproperties' => $propertySummary['closedproperties'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],

            // Project summaries
            'pendingprojects' => $projectSummary['pendingprojects'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'awaitingprojects' => $projectSummary['awaitingprojects'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'concludedinspprojects' => $projectSummary['concludedinspprojects'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'rejectedprojects' => $projectSummary['rejectedprojects'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'approvedprojects' => $projectSummary['approvedprojects'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'awaitinglistingprojects' => $projectSummary['awaitinglistingprojects'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'listedprojects' => $projectSummary['listedprojects'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],
            'closedprojects' => $projectSummary['closedprojects'] ?? (object)['totalnumber' => 0, 'totalamount' => 0],

            // Recent data
            'propertyOffers' => $recentProperties['offers'] ?? [],
            'propertyPending' => $recentProperties['recentPending'] ?? [],
            'propertyAwaiting' => $recentProperties['recentAwaiting'] ?? [],
            'propertyUnderInsp' => $recentProperties['recentUnderInsp'] ?? [],
            'projectOffers' => $recentProjects['offers'] ?? [],
            'projectPending' => $recentProjects['recentPending'] ?? [],
            'projectAwaiting' => $recentProjects['recentAwaiting'] ?? [],
            'projectUnderInsp' => $recentProjects['recentUnderInsp'] ?? [],
        ];

        $this->viewWithLayout('dashboard/index', $data, 'layouts/app');
    }
}