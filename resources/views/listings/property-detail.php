<?php $pageTitle = 'Property Detail'; ?>

<div class="container-fluid py-4">
  <div class="card">
    <div class="card-header"><h6>Property Detail</h6></div>
    <div class="card-body">
      <?php if (!empty($item)): ?>
      <dl class="row">
        <dt class="col-sm-3">Title</dt><dd class="col-sm-9"><?php echo htmlspecialchars($item['title'] ?? ''); ?></dd>
        <dt class="col-sm-3">Description</dt><dd class="col-sm-9"><?php echo nl2br(htmlspecialchars($item['description'] ?? '')); ?></dd>
        <dt class="col-sm-3">Address</dt><dd class="col-sm-9"><?php echo htmlspecialchars($item['address'] ?? ''); ?></dd>
        <dt class="col-sm-3">Price</dt><dd class="col-sm-9"><?php echo isset($item['price']) ? number_format((float)$item['price'],2) : 'N/A'; ?> <?php echo htmlspecialchars($item['priceunit'] ?? ''); ?></dd>
        <dt class="col-sm-3">Entry Date</dt><dd class="col-sm-9"><?php echo !empty($item['entrydate']) ? date('d/m/Y', strtotime($item['entrydate'])) : 'N/A'; ?></dd>
      </dl>
      <?php else: ?>
      <p>Not found.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
