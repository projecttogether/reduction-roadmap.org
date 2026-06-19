<?php 

if ($page->layout()->isNotEmpty()): 
  foreach ($page->layout()->toLayouts() as $layout):

    $config   = $layout->attrs();
    $w_max     = $config->w_max()->or('wide');
    $colCount = $layout->columns()->count();
    
    
    ?>
    <section class="py-16 bg-off-white"
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
