<?php

require __DIR__ . '/src/ContactForm.php';
require __DIR__ . '/src/BestPracticesSubmission.php';

use SchmollStudio\ContactForm\BestPracticesSubmission;
use SchmollStudio\ContactForm\ContactForm;

Kirby::plugin('schmoll-studio/contact-form', [
	'routes' => [
		[
			'pattern' => 'best-practices-submission',
			'method' => 'POST',
			'action' => function () {
				$kirby = kirby();
				$request = $kirby->request();
				$data = $request->body()->toArray();
				$referer = $request->header('referer') ?? $kirby->url('index');
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
		[
			'pattern' => 'contact-form',
			'method' => 'POST',
			'action' => function () {
				$kirby = kirby();
				$request = $kirby->request();
				$data = $request->body()->toArray();
				$referer = $request->header('referer') ?? $kirby->url('index');
				$redirect = $referer . (str_contains($referer, '?') ? '&' : '?') . 'status=error';

				if (csrf($data['csrf'] ?? '') !== true) {
					return go($redirect);
				}

				$sent = false;

				try {
          $sent = ContactForm::send($data, $kirby);
        } catch (\Throwable $e) {
          error_log(
            sprintf(
              '[Contact form] %s in %s:%d',
              $e->getMessage(),
              $e->getFile(),
              $e->getLine()
            )
          );

          if ($kirby->option('debug') === true) {
            throw $e;
          }
        }

				$redirect = $referer . (str_contains($referer, '?') ? '&' : '?') . ($sent === true ? 'status=success' : 'status=error');
				return go($redirect);
			},
		],
	],
]);
