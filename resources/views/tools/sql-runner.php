<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SQL Runner - Lbrix Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body { background: #f8f9fa; }
        .text-xxs { font-size: 0.65rem; }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>SQL Runner</h6>
                    <p class="text-sm text-secondary mb-0">
                        Paste a query and run it against the application database.
                        <span class="text-danger">Use with care — this executes arbitrary SQL.</span>
                    </p>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <textarea id="sqlInput" class="form-control" rows="8"
                                  placeholder="SELECT * FROM users LIMIT 10;"
                                  style="font-family: monospace; font-size: 0.85rem;"></textarea>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" id="runSqlBtn" class="btn btn-primary btn-sm mb-0">
                            Run Query
                        </button>
                        <span id="sqlStatus" class="text-sm text-secondary ms-3"></span>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Result</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div id="sqlResult" class="table-responsive p-3">
                        <p class="text-sm text-secondary mb-0 px-3">No query run yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const executeUrl = '<?php echo url('tools/sql-runner/execute'); ?>';
    const $btn = $('#runSqlBtn');
    const $status = $('#sqlStatus');
    const $result = $('#sqlResult');

    function escapeHtml(value) {
        if (value === null) return '<span class="text-secondary">NULL</span>';
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    function renderRows(data) {
        if (!data.rowCount) {
            $result.html('<p class="text-sm text-secondary mb-0 px-3">Query returned 0 rows.</p>');
            return;
        }
        let html = '<table class="table align-items-center mb-0"><thead><tr>';
        data.columns.forEach(function (col) {
            html += '<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">' + escapeHtml(col) + '</th>';
        });
        html += '</tr></thead><tbody>';
        data.rows.forEach(function (row) {
            html += '<tr>';
            data.columns.forEach(function (col) {
                html += '<td class="text-sm" style="white-space: nowrap;">' + escapeHtml(row[col]) + '</td>';
            });
            html += '</tr>';
        });
        html += '</tbody></table>';
        $result.html(html);
    }

    function runQuery() {
        const sql = $('#sqlInput').val().trim();
        if (!sql) {
            toastr.warning('Enter a query first.');
            return;
        }

        $btn.prop('disabled', true).text('Running...');
        $status.text('');

        $.ajax({
            url: executeUrl,
            method: 'POST',
            data: { sql: sql },
            dataType: 'json'
        }).done(function (data) {
            if (!data.success) {
                $result.html('<div class="alert alert-danger text-white text-sm mx-3">' + escapeHtml(data.error) + '</div>');
                $status.text('');
                return;
            }
            if (data.type === 'select') {
                $status.text(data.rowCount + ' row(s) · ' + data.elapsed + ' ms');
                renderRows(data);
            } else {
                $status.text(data.affected + ' row(s) affected · ' + data.elapsed + ' ms');
                $result.html('<div class="alert alert-success text-white text-sm mx-3">Query executed. ' + data.affected + ' row(s) affected.</div>');
            }
        }).fail(function (xhr) {
            let msg = 'Request failed.';
            try {
                const res = JSON.parse(xhr.responseText);
                if (res && res.error) msg = res.error;
            } catch (e) {}
            $result.html('<div class="alert alert-danger text-white text-sm mx-3">' + escapeHtml(msg) + '</div>');
            $status.text('');
        }).always(function () {
            $btn.prop('disabled', false).text('Run Query');
        });
    }

    $btn.on('click', runQuery);

    // Ctrl/Cmd + Enter to run
    $('#sqlInput').on('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            runQuery();
        }
    });
})();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>
