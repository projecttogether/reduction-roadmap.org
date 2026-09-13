<?php

///// Setup /////
/////////////////

$notes = $block->notes()->toStructure();

if ($notes->isEmpty()) return;

///// Markup /////
////////////////// ?>

<ol class="list-none m-0 p-0 text-sm space-y-2.5">
  <?php foreach ($notes as $note): ?>
    <li id="footnote-<?= esc($note->number()) ?>" class="flex gap-2 leading-snug">
      <span class="shrink-0 text-fließtext-xs"><?= $note->number()->html() ?>.</span>
      <span class="min-w-0 [&_p]:inline">
        <?= $note->text()->kt() ?>
        <?php if ($link = $note->link()->toUrl()): ?>
          <a
            href   ="<?= esc($link) ?>"
            class  ="ml-2 inline-flex whitespace-nowrap underline underline-offset-2 hover:no-underline"
            target ="_blank"
            rel    ="noopener noreferrer"
          >Mehr erfahren</a>
        <?php endif ?>
      </span>
    </li>
  <?php endforeach ?>
</ol>
