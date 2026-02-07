<?php
use App\Traits\HasFileUpload;

class InspectionController extends Controller {
    use HasFileUpload;
    private $inspectionService;

    public function __construct() {
        parent::__construct();
        $this->requireAuth(); // Protect all methods
        $this->inspectionService = new InspectionService();
    }

    // ==================== INSPECTION TASKS ====================
    public function tasks() {
        $request = Request::getInstance();
        
        // Get filter parameters
        $filters = [
            'startdate' => $request->get('startdate'),
            'status' => $request->get('status'),
            'itemid' => $request->get('itemid'),
            'entrydate' => $request->get('entrydate'),
        ];

        // Get current page
        $page = (int)$request->get('page', 1);
        $perPage = 10;

        // Get data
        $inspectionLead = $this->inspectionService->getInspectionLeads();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();
        $itemStatuses = $this->inspectionService->getItemStatuses();
        $items = $this->inspectionService->getItems();
        $tasksList = $this->inspectionService->getInspectionTasksList($filters, $page, $perPage);

        $this->viewWithLayout('inspection/tasks', [
            'inspectionLead' => $inspectionLead,
            'inspectionStatuses' => $inspectionStatuses,
            'itemStatuses' => $itemStatuses,
            'items' => $items,
            'tasksList' => $tasksList,
            'filters' => $filters,
            'title' => 'Inspection Tasks'
        ]);
    }

    // ==================== INSPECTION TASK CRUD ====================
    public function storeInspectionTask() {
        $request = Request::getInstance();
        
        $data = [
            'itemid' => $request->input('itemid'),
            'inspectionlead' => $request->input('inspectionlead'),
            'status' => $request->input('status'),
            'startdate' => $request->input('startdate'),
            'note' => $request->input('note', ''),
            'supervisornote' => $request->input('supervisornote', ''),
        ];

        // Handle file upload if present (uses documents/ folder for inspectiontask.docurl)
        if ($request->hasFile('docurl')) {
            $result = $this->handleFileUpload('docurl', 'documents');
            // $result = uploadFile($request->file('docurl'), 'documents');
            if ($result['success']) {
                $data['docurl'] = $result['path'];
            }
        }

        $response = $this->inspectionService->createInspectionTask($data);
        Response::json($response);
    }

    public function updateInspectionTask($id) {
        $request = Request::getInstance();
        
        $data = [
            'itemid' => $request->input('itemid'),
            'inspectionlead' => $request->input('inspectionlead'),
            'status' => $request->input('status'),
            'startdate' => $request->input('startdate'),
            'note' => $request->input('note', ''),
            'supervisornote' => $request->input('supervisornote', ''),
        ];

        // Handle file upload if present (uses documents/ folder for inspectiontask.docurl)
        if ($request->hasFile('docurl')) {
            $result = $this->handleFileUpload('docurl', 'documents');
            if ($result['success']) {
                $data['docurl'] = $result['path'];
            }
        }

        $response = $this->inspectionService->updateInspectionTask($id, $data);
        Response::json($response);
    }

    public function showInspectionTask($id) {
        $task = $this->inspectionService->getInspectionTaskById($id);
        Response::json(['success' => true, 'task' => $task]);
    }

    public function destroyInspectionTask($id) {
        $response = $this->inspectionService->deleteInspectionTask($id);
        Response::json($response);
    }

    // ==================== INSPECTION TASK TEAM ====================
    public function getInspectionTaskTeam($inspectionTaskId) {
        $teamMembers = $this->inspectionService->getInspectionTaskTeam($inspectionTaskId);
        
            // Render the team members partial view
        ob_start();
        // From app/Controllers to project root, then into resources/views
        include __DIR__ . '/../../resources/views/inspection/tasks/team-members.php';
            $html = ob_get_clean();
            
            echo $html;
    }

    public function storeInspectionTaskTeam() {
        $request = Request::getInstance();
        
        $data = [
            'inspectiontaskid' => $request->input('inspectiontaskid'),
            'userid' => $request->input('userid'),
            'comment' => $request->input('comment', ''),
            'status' => $request->input('status', 0),
        ];

        $response = $this->inspectionService->createInspectionTaskTeam($data);
        Response::json($response);
    }

    public function updateInspectionTaskTeam($id) {
        $request = Request::getInstance();
        
        $data = [
            'comment' => $request->input('comment', ''),
        ];

        $response = $this->inspectionService->updateInspectionTaskTeam($id, $data);
        Response::json($response);
    }

    public function destroyInspectionTaskTeam($id) {
        $response = $this->inspectionService->deleteInspectionTaskTeam($id);
        Response::json($response);
    }

    // ==================== ASSIGN INSPECTION TASK ====================
    public function assignInspectionTask() {
        $request = Request::getInstance();
        
        $data = [
            'inspectiontaskid' => $request->input('inspectiontaskid'),
            'itemstatusid' => $request->input('itemstatusid'),
        ];

        $response = $this->inspectionService->assignInspectionTask($data);
        Response::json($response);
    }

    // ==================== INSPECTION REQUESTS ====================
    public function requests() {
        $request = Request::getInstance();
        
        // Get current page
        $page = (int)$request->get('page', 1);
        $perPage = 10;

        // Get data
        $inspectionRequests = $this->inspectionService->getInspectionRequests($page, $perPage);
        $bidTypes = $this->inspectionService->getBidTypes();
        $users = $this->inspectionService->getUsers();
        $items = $this->inspectionService->getItems();
        // For creating inspection tasks from this page
        $inspectionLead = $this->inspectionService->getInspectionLeads();
        $inspectionStatuses = $this->inspectionService->getInspectionStatuses();

        $this->viewWithLayout('inspection/requests', [
            'inspectionRequests' => $inspectionRequests,
            'bidTypes' => $bidTypes,
            'users' => $users,
            'items' => $items,
            'inspectionLead' => $inspectionLead,
            'inspectionStatuses' => $inspectionStatuses,
            'title' => 'Inspection Requests'
        ]);
    }

    // ==================== INSPECTION REQUEST CRUD ====================
    public function storeInspectionRequest() {
        $request = Request::getInstance();
        
        $data = [
            'itemid' => $request->input('itemid'),
            'inspecteeid' => $request->input('inspecteeid'),
            'inspecteename' => $request->input('inspecteename'),
            'inspecteephone' => $request->input('inspecteephone'),
            'inspecteeemail' => $request->input('inspecteeemail'),
            'attorneyid' => $request->input('attorneyid'),
            'bidtypeid' => $request->input('bidtypeid'),
            'note' => $request->input('note', ''),
            'proposeddate' => $request->input('proposeddate'),
        ];

        $response = $this->inspectionService->createInspectionRequest($data);
        Response::json($response);
    }

    public function showInspectionRequest($id) {
        $inspectionRequest = $this->inspectionService->getInspectionRequestById($id);
        Response::json(['success' => true, 'request' => $inspectionRequest]);
    }

    public function updateInspectionRequest($id) {
        $request = Request::getInstance();
        
        $data = [
            'itemid' => $request->input('itemid'),
            'inspecteeid' => $request->input('inspecteeid'),
            'inspecteename' => $request->input('inspecteename'),
            'inspecteephone' => $request->input('inspecteephone'),
            'inspecteeemail' => $request->input('inspecteeemail'),
            'attorneyid' => $request->input('attorneyid'),
            'bidtypeid' => $request->input('bidtypeid'),
            'note' => $request->input('note', ''),
            'proposeddate' => $request->input('proposeddate'),
        ];

        $response = $this->inspectionService->updateInspectionRequest($id, $data);
        Response::json($response);
    }

    public function destroyInspectionRequest($id) {
        $response = $this->inspectionService->deleteInspectionRequest($id);
        Response::json($response);
    }
}
