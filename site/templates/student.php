<?php snippet('header'); ?>

<?php
  function getEmbedUrl($vidURL) {
    $parsedURL = parse_url($vidURL);
    $embedSrc = '';

    if (strpos($parsedURL['host'], 'youtube.com') !== false) {
      preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $vidURL, $match);
      $youtube_id = $match[1];
      $embedSrc = 'https://www.youtube.com/embed/' . $youtube_id . '?rel=0&amp;controls=1&amp;showinfo=1&amp;autoplay=0&amp;modestbranding=1&amp;autohide=1';
    } else if (strpos($parsedURL['host'], 'vimeo.com') !== false) {
      $regs = array();
      $vimeo_id = '';
      if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $vidURL, $regs)) {
        $vimeo_id = $regs[3];
      }
      $embedSrc = 'https://player.vimeo.com/video/' . $vimeo_id;
    }

    return $embedSrc;
  }

  $hasBgImg = $page->background_image_or_color() == 'image';
  $hasBgColor = $page->background_image_or_color() == 'color';
?>
<?php if ($page->content_or_url() == 'content'): ?>
  <div
    class="
      student__work__container
      layout-wrapper
      with-color
    "
    style="
      --text-color: <?= $page->text_color(); ?>;
      "
    >
    <?php if($page->main_content()->isNotEmpty()): ?>
      <div class="student__work__statement text">
        <?= $page->main_content()->kt(); ?>
      </div>
    <?php endif; ?>
    <ul class="student__work">
      <?php foreach($page->main_works()->toStructure() as $work): ?>
        <?php $workType = $work->type_of_work(); ?>
        <li
          class="
            student__work__item
            <?= $workType; ?>
            "
          style="
            --height: <?= rand(30, 60); ?>vh;
            --margin-left: <?= rand(10, 40); ?>vw;
            --margin-top: <?= rand(0, 30); ?>vh;
            "
          >
          <?php if($workType == 'upload'): ?>
            <?php $workFile = $work->work_upload()->toFile(); ?>

            <?php if ($workFile->type() == 'image'): ?>
              <a href="<?=$workFile->resize(2000)->url(); ?>" target="_blank">
                <img src="<?=$workFile->resize(1000)->url(); ?>" loading="lazy">
              </a>
              <?php snippet('caption', ['work' => $work]); ?>

            <?php elseif ($workFile->type() == 'video'): ?>
              <div class="ratio-container">
                <video class="ratio-contained" autoplay controls playsinline loop controlslist="nodownload">
                  <source src="<?= $workFile->url(); ?>" type="<?= $workFile->mime(); ?>">
                </video>
              </div>
              <?php snippet('caption', ['work' => $work]); ?>

            <?php else: ?>
              <a href="<?=$workFile->url(); ?>">
                <?php if ($work->work_text()->isNotEmpty()): ?>
                  <?php snippet('caption', ['work' => $work]); ?>
                <?php else: ?>
                  <div class="text">
                    <?=$workFile->filename(); ?>
                  </div>
                <?php endif; ?>
              </a>

            <?php endif; ?>
          <?php elseif($workType == 'embed'): ?>
            <div class="ratio-container">
              <iframe class="ratio-contained" src="<?= getEmbedUrl($work->work_embed()); ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
            <?php snippet('caption', ['work' => $work]); ?>

          <?php else: ?>
            <?php snippet('caption', ['work' => $work]); ?>

          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>

  </div>
  <div
    class="
      student__background
      fixed
      <?= ($hasBgImg) ? 'with-background-image' : '' ?>
      <?= ($hasBgColor) ? 'with-background-color' : '' ?>
      "
    style="
      <?= ($hasBgImg) ? '--background-image: url(' . $page->background_image()->toFile()->resize(2000)->url() . ');' : '' ?>
      <?= ($hasBgColor) ? '--background-color: ' . $page->background_color() . ';' : '' ?>
      "
    >
  </div>
<?php else: ?>
  <iframe class="student__work__iframe" src="<?= $page->url_url(); ?>"></iframe>
<?php endif; ?>
<div class="student__name display with-color" style="--text-color: <?= $page->text_color(); ?>;">
  <?= $page->title(); ?>
</div>
<div class="info with-color" style="--text-color: <?= $page->text_color(); ?>;">
  <?php foreach($page->links()->toStructure() as $link): ?>
    <?php if (($link->link_access()->toBool() && $kirby->user()) || $link->link_access()->toBool() == false): ?>
      <a href="<?=$link->link_url(); ?>"><?= $link->link_text(); ?></a>
    <?php endif; ?>
  <?php endforeach; ?>
  <a href="/">home</a>
</div>

<?php snippet('footer'); ?>
