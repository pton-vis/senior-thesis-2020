<?php if ($work->work_text()->isNotEmpty()): ?>
  <div class="text">
    <?= $work->work_text()->kt(); ?>
  </div>
<?php endif; ?>
