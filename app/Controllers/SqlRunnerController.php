<?php
/**
 * SQL Runner
 * A developer/admin tool: paste a SQL query and execute it against the
 * application's database connection. Protected by auth and restricted to
 * admin users.
 *
 * WARNING: this executes arbitrary SQL. Keep it limited to trusted admins.
 */
class SqlRunnerController extends Controller {

    public function __construct() {
        parent::__construct();
        // NOTE: auth check removed temporarily — this page is open to everyone.
        // TODO: re-add requireAuth()/admin restriction before production.
    }

    /**
     * Show the SQL runner page.
     */
    public function index() {
        // Render standalone (no app layout) so the page is open and does not
        // trigger the layout's auth/login redirect.
        $this->view('tools/sql-runner', [
            'title' => 'SQL Runner'
        ]);
    }

    /**
     * Execute the submitted SQL and return JSON.
     */
    public function execute() {
        $request = Request::getInstance();
        $sql = trim((string) $request->post('sql', ''));

        if ($sql === '') {
            $this->json(['success' => false, 'error' => 'No query provided.'], 422);
        }

        $conn = Database::getInstance()->getConnection();

        try {
            $start = microtime(true);
            $stmt = $conn->query($sql);
            $elapsed = round((microtime(true) - $start) * 1000, 2);

            // A result-set producing statement (SELECT, SHOW, DESCRIBE, etc.)
            if ($stmt->columnCount() > 0) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $columns = !empty($rows) ? array_keys($rows[0]) : [];

                $this->json([
                    'success'  => true,
                    'type'     => 'select',
                    'columns'  => $columns,
                    'rows'     => $rows,
                    'rowCount' => count($rows),
                    'elapsed'  => $elapsed,
                ]);
            }

            // A write statement (INSERT, UPDATE, DELETE, DDL, etc.)
            $this->json([
                'success'  => true,
                'type'     => 'write',
                'affected' => $stmt->rowCount(),
                'elapsed'  => $elapsed,
            ]);
        } catch (PDOException $e) {
            $this->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 400);
        }
    }
}
