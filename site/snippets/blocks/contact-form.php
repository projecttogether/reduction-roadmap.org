<?php

/** @var \Kirby\Cms\Block $block */

// Setup //
//////////////////

$b           = $block;
$status      = get('status');
$headline    = $b->headline()->or(null);
$intro       = $b->intro()->or(null);
$subject     = $b->subject()->or(option('schmoll-studio.contact-form.subject', 'New message from the website'));
$submitLabel = $b->submitLabel()->or('Send message');
$recipient   = $b->recipient()->isNotEmpty()
             ? $b->recipient()->value()
             : option('schmoll-studio.contact-form.recipient', 'hello@reduction-roadmap.de');

// Snippet args //
$args_notif_success = ['type' => 'success', 'message' => 'Vielen Dank für deine Nachricht. Wir melden uns so schnell wie möglich bei dir.'];
$args_notif_error   = ['type' => 'error', 'message' => 'Beim Senden deiner Nachricht ist ein Problem aufgetreten. Bitte überprüfe das Formular und versuche es erneut.'];
$args_field_name    = ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'autocomplete' => 'name', 'placeholder' => 'Dein Name'];
$args_field_email   = ['label' => 'E-Mail-Adresse', 'name' => 'email', 'type' => 'email', 'autocomplete' => 'email', 'placeholder' => 'name@beispiel.org'];
$args_field_msg     = ['label' => 'Nachricht','name' => 'message','rows' => 6, 'placeholder' => 'Deine Nachricht an uns'];
$args_btn_submit    = ['label'   => 'Abschicken', 'is_link' => false, 'type' => 'submit', 'size' => 'md'];

// Markup //
////////////////// ?>

<div class="flex flex-col">

  <?php 
  // Hdl. //
  //////////////////

  if ($headline && $headline->isNotEmpty()): ?>
    <h3 class="font-heading text-3xl md:text-4xl font-black text-black-green mb-4">
      <?= $headline->html() ?>
    </h3> <?php
  endif;

  // Intro text //
  //////////////////

  if ($intro && $intro->isNotEmpty()): ?>
    <div class="mb-8 text-base leading-relaxed text-dark-green/80">
      <?= $intro->kt() ?>
    </div> <?php
  endif;

  // Notifs. //
  ////////////////// ?>

  <div class="flex justify-start items-start">
    <?php if     ($status === 'success') snippet('notifications/alert', $args_notif_success);
          elseif ($status === 'error')   snippet('notifications/alert', $args_notif_error); ?>
  </div>
  
  <?php
  // Form //
  ////////////////// ?>

  <form action="<?= esc(parse_url(url('contact-form'), PHP_URL_PATH)) ?>" method="post" class="space-y-5" novalidate>
    <input type="hidden" name="csrf" value="<?= esc(csrf()) ?>">
    <input type="hidden" name="recipient" value="<?= esc($recipient) ?>">

    <div class="hidden" aria-hidden="true">
      <label for="contact-form-website">Website</label>
      <input id="contact-form-website" name="website" type="text" tabindex="-1" autocomplete="off">
    </div>

    <div class="grid gap-5 md:grid-cols-2">
      <?php 
      snippet('form-fields/input', $args_field_name);
      snippet('form-fields/input', $args_field_email); ?>
    </div>

    <?php snippet('form-fields/textarea', $args_field_msg) ?>

    <foto>
      <?php snippet('btn', $args_btn_submit) ?>
     </div>
  </form>
</div>
