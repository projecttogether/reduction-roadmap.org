<?php

/**
 * Wall of member logos followed by a wall of member names.
 *
 * Members are kept as pages in a "members" collection. Whether an entry lands
 * in the logo wall or the text wall follows from the logo: an organisation
 * with a logo is shown as a logo, one without is shown as a name.
 *
 * @var \Kirby\Cms\Block $block
 */

// Setup //
//////////////////

$source = $block->source()->toPage() ?? site()->find('members');
if ($source === null) return;

$members = $source->children()->filterBy('template', 'member')->listed();
if ($members->isEmpty()) return;

$withLogo    = $members->filter(fn ($m) => $m->logo()->toFile() !== null);
$withoutLogo = $members->filter(fn ($m) => $m->logo()->toFile() === null);

$showLogoWall  = $block->showLogoWall()->toBool(true) && $withLogo->isNotEmpty();
$textWallScope = $block->textWallScope()->or('without-logo')->value();
$textMembers   = match ($textWallScope) {
  'all'  => $members,
  'none' => null,
  default => $withoutLogo,
};

$headline = $block->headline();
$intro    = $block->intro();
$columns  = (int)$block->columns()->or(6)->value();
$gridCols = [
  4 => 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-4',
  5 => 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-5',
  6 => 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-6',
  7 => 'grid-cols-2 sm:grid-cols-4 lg:grid-cols-7',
][$columns] ?? 'grid-cols-2 sm:grid-cols-3 lg:grid-cols-6';

// Markup //
////////////////// ?>

<section class="members-wall flex flex-col gap-10">

  <?php if ($headline->isNotEmpty() || $intro->isNotEmpty()): ?>
    <header class="flex flex-col gap-5 text-center">
      <?php if ($headline->isNotEmpty()): ?>
        <h2 class="font-heading text-3xl font-black leading-tight text-dark-green md:text-5xl">
          <?= $headline->html() ?>
        </h2>
      <?php endif ?>
      <?php if ($intro->isNotEmpty()): ?>
        <div class="mx-auto max-w-3xl text-base leading-relaxed text-dark-green">
          <?= $intro->kt() ?>
        </div>
      <?php endif ?>
    </header>
  <?php endif ?>

  <?php if ($showLogoWall): ?>
    <ul class="grid <?= $gridCols ?> items-center gap-x-10 gap-y-12 border-t border-dark-green/30 pt-12">
      <?php foreach ($withLogo as $member): ?>
        <?php
          $logo    = $member->logo()->toFile();
          $website = $member->website();
          $alt     = $logo->alt()->or($member->title())->value();
        ?>
        <li class="flex items-center justify-center">
          <?php if ($website->isNotEmpty()): ?>
            <a
              href="<?= esc($website->toUrl()) ?>"
              target="_blank"
              rel="noopener noreferrer"
              class="flex items-center justify-center transition-opacity hover:opacity-70"
              title="<?= esc($member->title()->value()) ?>"
            >
          <?php endif ?>

          <img
            src="<?= esc($logo->url()) ?>"
            alt="<?= esc($alt) ?>"
            loading="lazy"
            class="max-h-16 w-auto max-w-full object-contain"
          >

          <?php if ($website->isNotEmpty()): ?></a><?php endif ?>
        </li>
      <?php endforeach ?>
    </ul>
  <?php endif ?>

  <?php if ($textMembers !== null && $textMembers->isNotEmpty()): ?>
    <div class="border-t border-dark-green/30 pt-12">
      <p class="text-center text-base leading-relaxed text-dark-green md:text-lg">
        <?php $last = $textMembers->count() - 1; $i = 0; ?>
        <?php foreach ($textMembers as $member): ?>
          <?php $website = $member->website(); ?>
          <?php if ($website->isNotEmpty()): ?>
            <a href="<?= esc($website->toUrl()) ?>" target="_blank" rel="noopener noreferrer" class="underline decoration-dark-green/30 underline-offset-4 transition-colors hover:decoration-dark-green"><?= $member->title()->html() ?></a>
          <?php else: ?>
            <?= $member->title()->html() ?>
          <?php endif ?>
          <?= $i < $last ? '<span class="text-dark-green/40"> · </span>' : '' ?>
          <?php $i++; ?>
        <?php endforeach ?>
      </p>
    </div>
  <?php endif ?>

</section>
