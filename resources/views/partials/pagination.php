<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-center">
            <?php if (!empty($paginationData) && $paginationData['last_page'] > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if ($paginationData['current_page'] > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $paginationData['current_page'] - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link"><span aria-hidden="true">&laquo;</span></span>
                            </li>
                        <?php endif; ?>

                        <?php 
                            $start = max(1, $paginationData['current_page'] - 2);
                            $end = min($paginationData['last_page'], $paginationData['current_page'] + 2);
                            if ($start > 1): ?>
                            <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
                            <?php if ($start > 2): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?php echo ($i == $paginationData['current_page']) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($end < $paginationData['last_page']): ?>
                            <?php if ($end < $paginationData['last_page'] - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $paginationData['last_page']; ?>"><?php echo $paginationData['last_page']; ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if ($paginationData['current_page'] < $paginationData['last_page']): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?php echo $paginationData['current_page'] + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link"><span aria-hidden="true">&raquo;</span></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
