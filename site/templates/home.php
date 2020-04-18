<?php snippet('header'); ?>

<div class="layout-wrapper fixed">
  <div class="site__title display">
      <div class="main"><?= $site->title(); ?></div>
      <div class="secondary"><?= $site->title(); ?></div>
  </div>
</div>
<div class="student__list__container">
  <ul class="student__list">
    <?php
      $studentList = $site->index()->filterBy('intendedTemplate', 'student')->listed();
      function studentSort($a, $b) {
        $aExploded = explode(' ', $a['content']['title']);
        $bExploded = explode(' ', $b['content']['title']);
        return end($aExploded) <=> end($bExploded);
      }
      $sLA = $studentList->toArray();
      usort($sLA, 'studentSort');
    ?>
    <?php foreach($sLA as $student): ?>
      <li class="student__list__entry"><a href="<?= $student['url']; ?>"><?= $student['content']['title']; ?></a></li>
    <?php endforeach; ?>
  </ul>
</div>
<div class="info">
  <a href="#" onclick="toggleInfo()">info</a>
  <a href="http://vis.princeton.edu/">vis</a>
  <?php if ($kirby->user()): ?>
    <a href="/panel/logout">logout</a>
  <?php else: ?>
    <a href="/panel/login">login</a>
  <?php endif; ?>
</div>
<div class="info__contents text">
  <div class="info__contents__button"><a href="#" onclick="toggleInfo()">close</a></div>
  <p><b><?=$site->title(); ?></b></p>
  <?= $site->about()->kt(); ?>
</div>

<?php snippet('footer'); ?>
