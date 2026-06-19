<?php 

////// Doc. //////
//////////////////

/**
 * ...
 */

///// Setup //////
//////////////////

$b = $block;

$args_btn = [
  'label'  => $b->text(),
  'url'    => $b->link()->toUrl(),
  'size'   => $b->size()->or('sm'),
  'target' => $b->is_external()->isTrue() ? '_blank' : null,
];

///// Markup /////
////////////////// ?>

<div class="flex justify-start items-start">
  <?php snippet('btn', $args_btn); ?>
</div>