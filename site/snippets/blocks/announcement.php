<section class="py-8 bg-light-bg text-center">
  <div class="container">
    <?php if ($block->headline()->isNotEmpty()): ?>
      <p class="font-heading font-black text-[clamp(1.5rem,3vw,2.5rem)] m-0"><?= $block->headline()->html() ?></p>
    <?php endif ?>
  </div>
</section>
