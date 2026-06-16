<?php /** @var \Kirby\Cms\Block $block */ ?>
<div class="text-6xl font-heading">
  <<?= $level = $block->level()->or('h2') ?>><?= $block->text() ?></<?= $level ?>>
</div>