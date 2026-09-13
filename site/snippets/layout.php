<?php 

if ($page->layout()->isNotEmpty()): 
  foreach ($page->layout()->toLayouts() as $layout):

    $config        = $layout->attrs();
    $w_max         = $config->w_max()->or('wide');
    $padd_top      = $config->padd_top()->or('md');
    $padd_bottom   = $config->padd_bottom()->or('md');
    $margin_top    = $config->margin_top()->or('none');
    $margin_bottom = $config->margin_bottom()->or('none');
    $backgroundColor = trim($config->backgroundColor()->or('var(--color-off-white)')->value());
    $borderClasses = [
      'borderTop' => ['sm' => 'border-t', 'md' => 'border-t-2', 'lg' => 'border-t-4'],
      'borderRight' => ['sm' => 'border-r', 'md' => 'border-r-2', 'lg' => 'border-r-4'],
      'borderBottom' => ['sm' => 'border-b', 'md' => 'border-b-2', 'lg' => 'border-b-4'],
      'borderLeft' => ['sm' => 'border-l', 'md' => 'border-l-2', 'lg' => 'border-l-4'],
    ];
    $borderClassList = [];
    foreach ($borderClasses as $field => $classes)
      $borderClassList[] = $classes[$config->$field()->value()] ?? '';
    $borderClass = implode(' ', array_filter($borderClassList));

    if ($backgroundColor === '') $backgroundColor = 'var(--color-off-white)';

      // Column setup //
    $colConfigs = $config->colConfigs()->toStructure();
    $colCount   = $layout->columns()->count();
    $blockSpacing = [
      'sm' => 8,
      'md' => 16,
      'lg' => 24,
      'xl' => 48,
      'xxl' => 64,
    ];
    $blockSpacingValue = function ($block, string $property, array $spacing) {
      $preset = $block->{$property}()->value();
      if ($preset === 'manual') {
        $custom = trim((string)$block->{$property . 'Custom'}()->value());
        return preg_match('/^(?:0|(?:\d*\.?\d+)(?:px|rem|em|vh|vw|%|ch|ex|vmin|vmax))$/', $custom) ? $custom : '';
      }
      return isset($spacing[$preset]) ? ($spacing[$preset] / 4) . 'rem' : '';
    };
    ?>
    <section
      data-padd-top="<?= $padd_top ?>"
      class        ="
        max-[1099px]:px-4
        <?= $padd_top == 'sm' ? 'pt-8'  : '' ?>
        <?= $padd_top == 'md' ? 'pt-16' : '' ?>
        <?= $padd_top == 'lg' ? 'pt-24' : '' ?>
        <?= $padd_top == 'xl' ? 'pt-48' : '' ?>
        <?= $padd_top == 'xxl' ? 'pt-64' : '' ?>

        <?= $margin_top == 'sm' ? 'mt-8'  : '' ?>
        <?= $margin_top == 'md' ? 'mt-16' : '' ?>
        <?= $margin_top == 'lg' ? 'mt-24' : '' ?>
        <?= $margin_top == 'xl' ? 'mt-48' : '' ?>
        <?= $margin_top == 'xxl' ? 'mt-64' : '' ?>

        <?= $padd_bottom == 'sm' ? 'pb-8'  : '' ?>
        <?= $padd_bottom == 'md' ? 'pb-16' : '' ?>
        <?= $padd_bottom == 'lg' ? 'pb-24' : '' ?>
        <?= $padd_bottom == 'xl' ? 'pb-48' : '' ?>
        <?= $padd_bottom == 'xxl' ? 'pb-64' : '' ?>

        <?= $margin_bottom == 'sm' ? 'mb-8'  : '' ?>
        <?= $margin_bottom == 'md' ? 'mb-16' : '' ?>
        <?= $margin_bottom == 'lg' ? 'mb-24' : '' ?>
        <?= $margin_bottom == 'xl' ? 'mb-48' : '' ?>
        <?= $margin_bottom == 'xxl' ? 'mb-64' : '' ?>
          "
      style        ="background-color: <?= esc($backgroundColor) ?>;"
    >

      <div
        class="max-w-(--w-max) mx-auto <?= esc($borderClass) ?>"
        style="--w-max: <?= $w_max == 'wide' ? '1100px' : ($w_max == 'narrow' ? '800px' : '100%') ?>;"
      >
        <div class="grid grid-cols-12 lg:gap-12">

          <?php $i_col = 0;
                foreach ($layout->columns() as $col): 
                  $colConfig = $colConfigs->filter(fn($c) => $c->col()->toInt() == $i_col + 1)->first();
                  $justify = $colConfig ? $colConfig->justifyContent()->or('FOO') : 'FOO';
                  ?>
                  <div data-col-index="<?= $i_col ?>"
                       class="col-span-12 lg:col-span-(--span) min-w-0 flex flex-col justify-[var(--justify)] gap-8"
                       style="--span   : <?= $col->span() ?>;
                              justify-content: <?= $justify ?>;">
                    <?php foreach ($col->blocks() as $block):
                      $blockStyles = [];
                      foreach (['Top', 'Right', 'Bottom', 'Left'] as $side) {
                        $padding = $blockSpacingValue($block, 'padding' . $side, $blockSpacing);
                        $margin = $blockSpacingValue($block, 'margin' . $side, $blockSpacing);
                        if ($padding !== '') $blockStyles[] = 'padding-' . strtolower($side) . ': ' . $padding;
                        if ($margin !== '') $blockStyles[] = 'margin-' . strtolower($side) . ': ' . $margin;
                      }
                      $blockStyle = implode('; ', $blockStyles ?? []); ?>
                      <div style="<?= esc($blockStyle) ?>">
                        <?= $block ?>
                      </div>
                    <?php endforeach ?>
                  </div>
          <?php   $i_col++; 
                endforeach ?>

        </div>
      </div>

    </section> <?php

  endforeach;
endif ?>
