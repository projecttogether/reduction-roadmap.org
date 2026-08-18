<?php

/**
 * @var array $filters
 * @var array $co2RangeLabels
 */

$filters ??= [];
$co2RangeLabels ??= [];
?>

<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
  <?php foreach ($filters as $key => $filter)
    snippet('best-practices/project-filter', [
      'key'            => $key,
      'filter'         => $filter,
      'co2RangeLabels' => $co2RangeLabels,
    ]) ?>
</div>
