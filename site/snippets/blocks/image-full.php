<?php
  $theme = $block->theme()->or('white')->value();
  $themeClass = 'section--' . $theme;
?>
<section class="section section--image-full <?= $themeClass ?>">
  <?php if ($image = $block->image()->toFile()): ?>
    <img
      class="image-full__img"
      src="<?= $image->url() ?>"
      alt="<?= $block->alt()->or($image->alt())->html() ?>"
      loading="lazy"
    >
  <?php endif ?>
</section>
