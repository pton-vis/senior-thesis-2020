<?php snippet('header'); ?>

<div class="layout-wrapper fixed">
  <div class="site__title display">
      <div class="main"><b><?= $site->title(); ?></b></div>
      <div class="secondary"><b><?= $site->title(); ?></b></div>
  </div>
</div>
<div class="student__list__container">
  <ul class="student__list">
    <?php
      $studentList = $site->index()->filterBy('intendedTemplate', 'student')->listed();
      function studentSort($a, $b) {
        return explode(' ', $a['content']['title'])[1] <=> explode(' ', $b['content']['title'])[1];
      }
      $sLA = $studentList->toArray();
      usort($sLA, 'studentSort');
    ?>
    <?php foreach($sLA as $student): ?>
      <?php
        $url = $student['url'];
        if ($student['content']['content_or_url'] == 'url') {
          $url = $student['content']['url_url'];
        }
      ?>
      <ul class="student__list__entry"><a href="<?= $url; ?>"><?= $student['content']['title']; ?></a></ul>
    <?php endforeach; ?>
  </ul>
</div>
<div class="info">
  <a href="#" onclick="toggleInfo()">info</a>
  <a href="http://vis.princeton.edu/">vis</a>
</div>
<div class="info__contents text">
  <div class="info__contents__button"><a href="#" onclick="toggleInfo()">close</a></div>
  <p><b><?=$site->title(); ?></b></p>
  <?= $site->about()->kt(); ?>
</div>

<?php snippet('footer'); ?>
