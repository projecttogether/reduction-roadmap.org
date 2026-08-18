<?php

/** @var \Kirby\Cms\Block $block */

$status = get('submission-status');
$parent = $block->parent()->toPage() ?? site()->find('best-practices');
$intro = $block->intro()->or(null);
$triggerLabel = $block->triggerLabel()->or('Submit new project');
$submitLabel = $block->submitLabel()->or('Projekt einreichen');

if ($parent === null) return;

$formOpen = $status === 'error';

$args_field_title = [
  'label' => 'Projekttitel',
  'name' => 'title',
  'type' => 'text',
  'autocomplete' => 'off',
  'placeholder' => 'Name des Projekts',
];
$args_field_name = [
  'label' => 'Dein Name',
  'name' => 'submitterName',
  'type' => 'text',
  'autocomplete' => 'name',
  'placeholder' => 'Vor- und Nachname',
];
$args_field_email = [
  'label' => 'E-Mail-Adresse',
  'name' => 'submitterEmail',
  'type' => 'email',
  'autocomplete' => 'email',
  'placeholder' => 'name@beispiel.org',
];
$args_field_location = [
  'label' => 'Ort',
  'name' => 'location',
  'type' => 'text',
  'autocomplete' => 'address-level2',
  'placeholder' => 'Stadt, Land',
  'required' => false,
];
$args_field_year = [
  'label' => 'Jahr',
  'name' => 'year',
  'type' => 'number',
  'autocomplete' => 'off',
  'placeholder' => '2024',
  'required' => false,
];
$args_field_area = [
  'label' => 'Fläche in m²',
  'name' => 'area',
  'type' => 'number',
  'autocomplete' => 'off',
  'placeholder' => '36.000',
  'required' => false,
];
$args_field_function = [
  'label' => 'Funktion',
  'name' => 'function',
  'type' => 'text',
  'autocomplete' => 'off',
  'placeholder' => 'Wohnen, Bildung, Büro',
  'required' => false,
];
$args_field_construction = [
  'label' => 'Baumaßnahme',
  'name' => 'constructionType',
  'type' => 'text',
  'autocomplete' => 'off',
  'placeholder' => 'Neubau, Sanierung, Umbau',
  'required' => false,
];
$args_field_co2_range = [
  'label' => 'CO₂-Bereich',
  'name' => 'co2Range',
  'options' => [
    'below-10' => 'Unter 10 kgCO₂/m²/Jahr',
    '10-20' => '10–20 kgCO₂/m²/Jahr',
    '20-30' => '20–30 kgCO₂/m²/Jahr',
    'above-30' => 'Über 30 kgCO₂/m²/Jahr',
  ],
  'empty' => 'Nicht bekannt',
];
$args_field_co2_value = [
  'label' => 'CO₂-Wert',
  'name' => 'co2Value',
  'type' => 'number',
  'autocomplete' => 'off',
  'placeholder' => '20',
  'required' => false,
];
$args_field_source = [
  'label' => 'Quelle oder Projektwebsite',
  'name' => 'sourceUrl',
  'type' => 'url',
  'autocomplete' => 'url',
  'placeholder' => 'https://',
  'required' => false,
];
$args_field_description = [
  'label' => 'Projektbeschreibung',
  'name' => 'description',
  'rows' => 7,
  'placeholder' => 'Was macht dieses Projekt zu einem Best Practice?',
];
$args_btn = [
  'label' => $submitLabel->html(),
  'is_link' => false,
  'type' => 'submit',
  'size' => 'md',
];
?>

<div
  id="best-practices-submission-<?= esc($block->id()) ?>"
  class="best-practices-submission-form flex flex-col gap-8"
>
  <?php if ($intro && $intro->isNotEmpty()): ?>
    <div class="text-base leading-relaxed text-dark-green/80">
      <?= $intro->kt() ?>
    </div>
  <?php endif ?>

  <?php if ($status === 'success'): ?>
    <?php snippet('notifications/alert', ['type' => 'success', 'message' => 'Vielen Dank! Deine Einreichung wurde übermittelt und wird nun geprüft.']) ?>
  <?php elseif ($status === 'error'): ?>
    <?php snippet('notifications/alert', ['type' => 'error', 'message' => 'Beim Übermitteln ist ein Fehler aufgetreten. Bitte überprüfe deine Angaben und versuche es erneut.']) ?>
  <?php endif ?>

  <?php if (!$formOpen): ?>
    <button
      type="button"
      class="flex w-fit items-center justify-center rounded bg-dark-green px-6 py-3 text-sm font-medium text-off-white transition-colors hover:bg-dark-green/65 focus:outline-none focus:ring-2 focus:ring-dark-green/30"
      data-submission-trigger
      aria-expanded="false"
      aria-controls="best-practices-submission-fields-<?= esc($block->id()) ?>"
    >
      <?= $triggerLabel->html() ?>
    </button>
  <?php endif ?>

  <form
    id="best-practices-submission-fields-<?= esc($block->id()) ?>"
    action="<?= esc(parse_url(url('best-practices-submission'), PHP_URL_PATH)) ?>"
    method="post"
    class="space-y-5"
    <?= $formOpen ? '' : 'hidden' ?>
    novalidate
  >
    <input type="hidden" name="csrf" value="<?= esc(csrf()) ?>">
    <input type="hidden" name="parent" value="<?= esc($parent->id()) ?>">

    <div class="hidden" aria-hidden="true">
      <label for="best-practices-submission-website">Website</label>
      <input id="best-practices-submission-website" name="website" type="text" tabindex="-1" autocomplete="off">
    </div>

    <?php snippet('form-fields/input', $args_field_title) ?>

    <div class="grid gap-5 md:grid-cols-2">
      <?php snippet('form-fields/input', $args_field_name) ?>
      <?php snippet('form-fields/input', $args_field_email) ?>
      <?php snippet('form-fields/input', $args_field_location) ?>
      <?php snippet('form-fields/input', $args_field_year) ?>
      <?php snippet('form-fields/input', $args_field_area) ?>
      <?php snippet('form-fields/input', $args_field_function) ?>
      <?php snippet('form-fields/input', $args_field_construction) ?>
      <?php snippet('form-fields/select', $args_field_co2_range) ?>
      <?php snippet('form-fields/input', $args_field_co2_value) ?>
      <?php snippet('form-fields/input', $args_field_source) ?>
    </div>

    <?php snippet('form-fields/textarea', $args_field_description) ?>

    <div>
      <?php snippet('btn', $args_btn) ?>
    </div>
  </form>
</div>

<?php snippet('best-practices/submission-form-toggle', ['blockId' => $block->id()]) ?>
