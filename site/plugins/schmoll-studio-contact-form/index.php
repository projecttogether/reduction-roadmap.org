<?php

require __DIR__ . '/src/ContactForm.php';

use SchmollStudio\ContactForm\ContactForm;

Kirby::plugin('schmoll-studio/contact-form', [
	'routes' => [
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
