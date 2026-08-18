<?php

/**
 * @var string $type
 * @var string $message
 */

$type ??= 'info';
$message ??= '';

$styles = [
  'success' => 'border-green-200 bg-green-50 text-green-900',
  'error'   => 'border-red-200 bg-red-50 text-red-900',
  'warning' => 'border-amber-200 bg-amber-50 text-amber-900',
  'info'    => 'border-blue-200 bg-blue-50 text-blue-900',
];

if ($message === '' || isset($styles[$type]) === false) return;
?>

<div
  class="mb-6 rounded-md border px-4 py-3 text-sm <?= esc($styles[$type]) ?>
         inline-flex"
  role="status"
>
  <?= esc($message) ?>
</div>
