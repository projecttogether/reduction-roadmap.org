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

$recipient = $b->recipient()->isNotEmpty()
  ? $b->recipient()->value()
  : option(
      'schmoll-studio.contact-form.recipient',
      'hello@reduction-roadmap.de'
    );

$args_btn_submit = [
  'label'   => 'Abschicken',
  'is_link' => false,
  'type'    => 'submit',
  'size'    => 'md',
];

// Markup //
////////////////// ?>

<div class="flex flex-col">

  <?php 
  // Hdl. //
  //////////////////

  if ($headline && $headline->isNotEmpty()): ?>
    <h3 class="font-heading text-3xl md:text-4xl font-black text-black-green mb-4">
      <?= $headline->html() ?>
    </h3>
  <?php endif ?>

  <?php 
  // Intro text //
  //////////////////

  if ($intro && $intro->isNotEmpty()): ?>
    <div class="mb-8 text-base leading-relaxed text-dark-green/80">
      <?= $intro->kt() ?>
    </div>
  <?php endif ?>

  <?php 
  // Notifs. //
  //////////////////
  
  if ($status === 'success'): ?>
    <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-900">
      Vielen Dank für deine Nachricht. Wir melden uns so schnell wie möglich bei dir.
    </div>
  <?php elseif ($status === 'error'): ?>
    <div class="mb-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
      Beim Senden deiner Nachricht ist ein Problem aufgetreten. Bitte überprüfe das Formular und versuche es erneut.
    </div>
  <?php endif ?>

  <?php
  // Form //
  ////////////////// ?>

  <form action="<?= url('contact-form') ?>" method="post" class="space-y-5" novalidate>
    <input type="hidden" name="csrf" value="<?= esc(csrf()) ?>">
    <input type="hidden" name="recipient" value="<?= esc($recipient) ?>">

    <div class="hidden" aria-hidden="true">
      <label for="contact-form-website">Website</label>
      <input id="contact-form-website" name="website" type="text" tabindex="-1" autocomplete="off">
    </div>

    <div class="grid gap-5 md:grid-cols-2">
      <label class="block">
        <span class="mb-2 block text-sm font-medium text-dark-green">Name</span>
        <input 
          type="text" name="name" autocomplete="name" required
          class="w-full rounded-md border border-slate-300 bg-off-white px-4 py-3 text-base text-black-green placeholder:text-slate-500 focus:border-dark-green focus:outline-none focus:ring-2 focus:ring-dark-green/20" 
          placeholder="Dein Name">
      </label>

      <label class="block">
        <span class="mb-2 block text-sm font-medium text-dark-green">E-Mail-Adresse</span>
        <input 
          type="email" name="email" autocomplete="email" required
          class="w-full rounded-md border border-slate-300 bg-off-white px-4 py-3 text-base text-black-green placeholder:text-slate-500 focus:border-dark-green focus:outline-none focus:ring-2 focus:ring-dark-green/20" 
          placeholder="name@beispiel.org">
      </label>
    </div>

    <label class="block">
      <span class="mb-2 block text-sm font-medium text-dark-green">Nachricht</span>
      <textarea 
        name="message" rows="6" required 
        class="w-full rounded-md border border-slate-300 bg-off-white px-4 py-3 text-base text-black-green placeholder:text-slate-500 focus:border-dark-green focus:outline-none focus:ring-2 focus:ring-dark-green/20" 
        placeholder="Deine Nachricht an uns"></textarea>
    </label>

    <div>
      <?php snippet('btn', $args_btn_submit) ?>
     </div>
  </form>
</div>
