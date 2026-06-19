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
  'label' => $b->text(),
  'url'   => $b->link()->or(null),
  'size'  => $b->size()->or('sm'),
];

///// Markup /////
////////////////// ?>

<div class="flex justify-start items-start">
  <?php snippet('btn', $args_btn); ?>
</div>