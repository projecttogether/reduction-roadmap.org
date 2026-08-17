<?php

/** @var \Kirby\Cms\Block $block */

// Setup //
//////////////////

$b           = $block;
$status      = get('status');
$headline    = $b->headline()->or(null);
$intro       = $b->intro()->or(null);
$recipient   = $b->recipient()->or(option('schmoll-studio.contact-form.recipient', 'hello@example.com'));
$subject     = $b->subject()->or(option('schmoll-studio.contact-form.subject', 'New message from the website'));
$submitLabel = $b->submitLabel()->or('Send message');

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
    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-900">
      Thanks for your message. We will get back to you as soon as possible.
    </div>
  <?php elseif ($status === 'error'): ?>
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
      There was a problem sending your message. Please check the form and try again.
    </div>
  <?php endif ?>

  <?php
  // Form //
  ////////////////// ?>

  <form action="<?= url('contact-form') ?>" method="post" class="space-y-5" novalidate>
    <input type="hidden" name="csrf" value="<?= esc(csrf()) ?>">
    <input type="hidden" name="recipient" value="<?= esc($recipient) ?>">
    <input type="hidden" name="subject" value="<?= esc($subject) ?>">

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
