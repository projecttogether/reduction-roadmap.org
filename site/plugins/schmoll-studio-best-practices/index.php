<?php

require __DIR__ . '/src/BestPracticesSubmission.php';
require __DIR__ . '/src/BestPracticesProjectConversion.php';

use SchmollStudio\BestPractices\BestPracticesSubmission;

Kirby::plugin('schmoll-studio/best-practices', [
  'areas' => [
    'best-practices' => require __DIR__ . '/src/areas/best-practices.php',
  ],
  'routes' => [
    [
      'pattern' => 'best-practices-submission',
      'method' => 'POST',
      'action' => function () {
        $kirby = kirby();
        $data = $kirby->request()->body()->toArray();
        $referer = $kirby->request()->header('referer') ?? $kirby->url('index');
        $redirect = $referer . (str_contains($referer, '?') ? '&' : '?') . 'submission-status=error';

        if (csrf($data['csrf'] ?? '') !== true) return go($redirect);

        try {
          $submission = BestPracticesSubmission::create($data, $kirby);
          $emailSent = false;

          try {
            $emailSent = BestPracticesSubmission::notify($submission, $kirby) === true;
          } catch (\Throwable $e) {
            error_log(sprintf('[Best Practices submission email] %s in %s:%d', $e->getMessage(), $e->getFile(), $e->getLine()));
          }

          $status = $emailSent ? 'success' : 'success-email-error';
          $redirect = $referer . (str_contains($referer, '?') ? '&' : '?') . 'submission-status=' . $status;
        } catch (\Throwable $e) {
          error_log(sprintf('[Best Practices submission] %s in %s:%d', $e->getMessage(), $e->getFile(), $e->getLine()));
          if ($kirby->option('debug') === true) throw $e;
        }

        return go($redirect);
      },
    ],
  ],
]);
