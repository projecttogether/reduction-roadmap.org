<?php
  $theme = $block->theme()->or('white')->value();
  $bgClass = match($theme) {
    'dark'  => 'bg-dark-green',
    'light' => 'bg-light-bg',
    default => 'bg-off-white',
  };
?>
<section class="<?= $bgClass ?>">
  <?php if ($image = $block->image()->toFile()): ?>
    <img
      class="w-full max-h-[80vh] object-cover block"
      src="<?= $image->url() ?>"
      alt="<?= $block->alt()->or($image->alt())->html() ?>"
      loading="lazy"
    >
  <?php endif ?>
</section>
