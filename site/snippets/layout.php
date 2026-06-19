<?php 

if ($page->layout()->isNotEmpty()): 
  foreach ($page->layout()->toLayouts() as $layout):

    $colCount = $layout->columns()->count() ?>
    <section class="py-16 bg-off-white">

      <div class="container">
        <div class="grid grid-cols-12 gap-8">

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
