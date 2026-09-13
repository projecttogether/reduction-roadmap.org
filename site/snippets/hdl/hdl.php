<?php

/**
 * @var string $text Pre-escaped heading text.
 * @var string $level Semantic heading level: h1-h6.
 * @var string $size Named size preset.
 * @var string $color Named color preset.
 * @var string $class Additional utility classes.
 */

$text  ??= '';
$level ??= 'h2';
$size  ??= 'lg';
$color ??= 'black-green';
$class ??= '';

$levels = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
$sizes  = [
  'hero' => 'text-[clamp(2.5rem,7vw,5rem)]',
  'fluid-3rem' => 'text-[clamp(2rem,3.43vw,3rem)]',
  'xl'   => 'text-6xl',
  'lg'   => 'text-5xl',
  'md'   => 'text-4xl',
  'sm'   => 'text-3xl',
  'xs'   => 'text-2xl',
];
$colors = [
  'dark-green'  => 'text-dark-green',
  'black-green' => 'text-black-green',
  'off-white'   => 'text-off-white',
];

$level      = in_array($level, $levels, true) ? $level : 'h2';
$sizeClass  = $sizes[$size] ?? $sizes['lg'];
$colorClass = $colors[$color] ?? $colors['black-green'];
?>

<<?= $level ?> class = "font-heading font-black <?= $sizeClass ?> <?= $colorClass ?> leading-[1.25] <?= esc($class) ?>">
  <?= $text ?>
</<?= $level ?>>
