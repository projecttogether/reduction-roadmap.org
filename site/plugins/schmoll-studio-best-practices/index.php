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
          if (BestPracticesSubmission::notify($submission, $kirby) !== true) {
            throw new \RuntimeException('The submission notification could not be sent.');
          }
          $redirect = $referer . (str_contains($referer, '?') ? '&' : '?') . 'submission-status=success';
        } catch (\Throwable $e) {
          error_log(sprintf('[Best Practices submission] %s in %s:%d', $e->getMessage(), $e->getFile(), $e->getLine()));
          if ($kirby->option('debug') === true) throw $e;
        }

        return go($redirect);
      },
    ],
  ],
]);
