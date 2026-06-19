<?php 

if ($page->layout()->isNotEmpty()): 
  foreach ($page->layout()->toLayouts() as $layout):

    $config   = $layout->attrs();
    $w_max    = $config->w_max()->or('wide');
    $padd_top = $config->padd_top()->or('md');
    $colCount = $layout->columns()->count();
    ?>
    <section data-padd-top="<?= $padd_top ?>"
              class="pb-16
                    <?= $padd_top == 'sm' ? 'pt-8'  : '' ?>
                    <?= $padd_top == 'md' ? 'pt-16' : '' ?>
                    <?= $padd_top == 'lg' ? 'pt-24' : '' ?>"

             style="--w-max: <?= $w_max == 'wide' ? '1100px' : ($w_max == 'narrow' ? '800px' : '100%') ?>">

      <div class="max-w-(--w-max) mx-auto">
        <div class="grid grid-cols-12 gap-12">

          <?php foreach ($layout->columns() as $col): ?>
                  <div class="col-span-(--span) min-w-0 flex flex-col gap-8"
                       style="--span: <?= $col->span() ?>;">
                    <?= $col->blocks() ?>
                  </div>
          <?php endforeach ?>

        </div>
      </div>

    </section> <?php

  endforeach;
endif ?>
