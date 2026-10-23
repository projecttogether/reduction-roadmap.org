<?php

/**
 * Labelled meta values for a project, used on the grid card and in the
 * detail overlay so both stay in the same visual language.
 *
 * @var \SchmollStudio\BestPractices\BestPracticeProjectPage $project
 * @var string|null $class  extra classes for the <dl>
 */

$class ??= '';

// Wording follows the filter bar on the same page, so a tag and the filter
// that selects it read the same.
$metaItems = array_values(array_filter(
  [
    ['label' => 'Funktion',     'value' => $project->buildingUseLabel()],
    ['label' => 'Baumaßnahme',  'value' => $project->constructionTypeLabel()],
    ['label' => 'Fläche (BGF)', 'value' => $project->displayArea()],
    ['label' => 'THG-Zielwert', 'value' => $project->hasThgRange() ? $project->thgRangeLabel() : ''],
  ],
  fn ($item) => trim((string)$item['value']) !== ''
));

if ($metaItems === []) return;
?>

<dl class="flex flex-wrap gap-x-6 gap-y-3 <?= esc($class) ?>">
  <?php foreach ($metaItems as $metaItem): ?>
    <div class="flex flex-col gap-0.5">
      <dt class="text-[10px] uppercase leading-none tracking-wide text-dark-green/70">
        <?= esc($metaItem['label']) ?>
      </dt>
      <dd class="text-xs leading-tight text-dark-green">
        <?= esc($metaItem['value']) ?>
      </dd>
    </div>
  <?php endforeach ?>
</dl>
