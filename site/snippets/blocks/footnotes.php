<?php

///// Setup /////
/////////////////

$notes = $block->notes()->toStructure();

if ($notes->isEmpty()) return;

///// Markup /////
////////////////// ?>

<ol class="list-none m-0 p-0 text-sm space-y-1">
  <?php foreach ($notes as $note): ?>
    <li class="flex gap-6 leading-snug">
      <span class="shrink-0 font-medium"><?= $note->number()->html() ?>.</span>
      <span><?= $note->text()->kt() ?></span>
    </li>
  <?php endforeach ?>
</ol>
