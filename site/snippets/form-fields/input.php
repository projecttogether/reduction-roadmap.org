<?php

/**
 * @var string $label
 * @var string $name
 * @var string $type
 * @var string $autocomplete
 * @var string $placeholder
 */

$label ??= '';
$name ??= '';
$type ??= 'text';
$autocomplete ??= $name;
$placeholder ??= '';
?>

<label class="block">
  <span class="mb-2 block text-sm font-medium text-dark-green">
    <?= esc($label) ?>
  </span>
  <input
    type="<?= esc($type) ?>"
    name="<?= esc($name) ?>"
    autocomplete="<?= esc($autocomplete) ?>"
    required
    class="w-full rounded-md border border-slate-300 bg-off-white px-4 py-3 text-base text-black-green placeholder:text-slate-500 focus:border-dark-green focus:outline-none focus:ring-2 focus:ring-dark-green/20"
    placeholder="<?= esc($placeholder) ?>"
  >
</label>
