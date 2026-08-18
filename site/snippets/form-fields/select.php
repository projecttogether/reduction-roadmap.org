<?php

/**
 * @var string $label
 * @var string $name
 * @var array $options
 * @var string $empty
 */

$label ??= '';
$name ??= '';
$options ??= [];
$empty ??= 'Bitte auswählen';
?>

<label class="block">
  <span class="mb-2 block text-sm font-medium text-dark-green">
    <?= esc($label) ?>
  </span>
  <select
    name="<?= esc($name) ?>"
    class="min-h-12 w-full rounded-md border border-slate-300 bg-off-white px-4 py-3 text-base text-black-green focus:border-dark-green focus:outline-none focus:ring-2 focus:ring-dark-green/20"
  >
    <option value=""><?= esc($empty) ?></option>
    <?php foreach ($options as $value => $optionLabel)
      echo '<option value="' . esc($value) . '">' . esc($optionLabel) . '</option>' ?>
  </select>
</label>
