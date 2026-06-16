<section class="section section--light section--announcement">
  <div class="container">
    <?php if ($block->headline()->isNotEmpty()): ?>
      <p class="announcement__headline"><?= $block->headline()->html() ?></p>
    <?php endif ?>
  </div>
</section>
