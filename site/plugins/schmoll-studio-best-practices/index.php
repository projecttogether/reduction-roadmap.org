<?php

require __DIR__ . '/src/BestPracticesSubmission.php';
require __DIR__ . '/src/BestPracticeProjectPage.php';

use SchmollStudio\BestPractices\BestPracticesSubmission;
use SchmollStudio\BestPractices\BestPracticeProjectPage;

Kirby::plugin('schmoll-studio/best-practices', [
  'pageModels' => [
    'best-practice-project' => BestPracticeProjectPage::class,
  ],
  'routes' => [
    [
      'pattern' => 'best-practices-submission',
      'method' => 'POST',
      'action' => function () {
        $kirby = kirby();
        $data = $kirby->request()->body()->toArray();
        $referer = $kirby->request()->header('referer') ?? $kirby->url('index');

        // Preserve the scroll position by returning to the form's anchor.
        $anchor = preg_replace('/[^A-Za-z0-9_-]/', '', (string)($data['anchor'] ?? ''));
        $redirectTo = function (string $status) use ($referer, $anchor): string {
          $url = $referer . (str_contains($referer, '?') ? '&' : '?') . 'submission-status=' . $status;
          return $anchor !== '' ? $url . '#' . $anchor : $url;
        };

        if (csrf($data['csrf'] ?? '') !== true) return go($redirectTo('error'));

        $status = 'error';

        try {
          $submission = BestPracticesSubmission::create($data, $kirby);
          $emailSent = false;

          try {
            $emailSent = BestPracticesSubmission::notify($submission, $kirby) === true;
          } catch (\Throwable $e) {
            error_log(sprintf('[Best Practices submission email] %s in %s:%d', $e->getMessage(), $e->getFile(), $e->getLine()));
          }

          $status = $emailSent ? 'success' : 'success-email-error';
        } catch (\Throwable $e) {
          error_log(sprintf('[Best Practices submission] %s in %s:%d', $e->getMessage(), $e->getFile(), $e->getLine()));
          $isValidationError = str_starts_with($e->getMessage(), 'The Best Practices submission is invalid:');
          if ($kirby->option('debug') === true && $isValidationError === false) throw $e;
        }

        return go($redirectTo($status));
      },
    ],
  ],
]);
