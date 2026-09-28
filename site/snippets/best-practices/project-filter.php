<?php

/**
 * @var string $key
 * @var array $filter
 */

$key ??= '';
$filter ??= [];

$label  = $filter['label'] ?? '';
$values = $filter['values'] ?? [];
$labels = $filter['labels'] ?? [];
?>

<label class="flex flex-col gap-2 text-xs uppercase tracking-wide text-dark-green">
  <span><?= esc($label) ?></span>
  <select
    class="min-h-12 w-full appearance-none rounded-none border border-dark-green bg-off-white px-4 text-base normal-case tracking-normal text-black-green focus:outline-none focus:ring-2 focus:ring-dark-green/30"
    data-filter="<?= esc($key) ?>"
    aria-label="Filter by <?= esc($label) ?>"
  >
    <option value="">Alle</option>
    <?php foreach ($values as $value): ?>
      <option value="<?= esc($value) ?>"><?= esc($labels[$value] ?? $value) ?></option>
    <?php endforeach ?>
  </select>
</label>
