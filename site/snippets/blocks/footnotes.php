<?php

///// Setup /////
/////////////////

$notes = $block->notes()->toStructure();

if ($notes->isEmpty()) return;

///// Markup /////
////////////////// ?>

<ol class="list-none m-0 p-0 text-sm space-y-2.5">
  <?php foreach ($notes as $note): ?>
    <li id="footnote-<?= esc($note->number()) ?>" class="flex gap-6 leading-snug">
      <span class="shrink-0 text-fließtext-xs"><?= $note->number()->html() ?>.</span>
      <span><?= $note->text()->kt() ?></span>
    </li>
  <?php endforeach ?>
</ol>
