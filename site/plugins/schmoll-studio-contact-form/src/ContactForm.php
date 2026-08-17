<?php

namespace SchmollStudio\ContactForm;

use Kirby\Cms\App;
use RuntimeException;

class ContactForm
{
  public static function validate(array $data): array
  {
    $errors   = [];
    $name     = trim((string)($data['name'] ?? ''));
    $email    = trim((string)($data['email'] ?? ''));
    $message  = trim((string)($data['message'] ?? ''));
    $honeypot = trim((string)($data['website'] ?? ''));

    if ($honeypot !== '') {
      $errors['website'] = 'Invalid request.';
    }

    if ($name === '') {
      $errors['name'] = 'Bitte gib deinen Namen ein.';
    }

    if (
      $email === '' ||
      filter_var($email, FILTER_VALIDATE_EMAIL) === false
    ) {
      $errors['email'] = 'Bitte gib eine gültige E-Mail-Adresse ein.';
    }

    if ($message === '') {
      $errors['message'] = 'Bitte gib eine Nachricht ein.';
    }

    return [
      'valid'  => $errors === [],
      'errors' => $errors,
    ];
  }

  public static function send(array $data, App $kirby): bool
  {
    $result = static::validate($data);

    if ($result['valid'] !== true) return false;

    $name    = trim((string)$data['name']);
    $email   = trim((string)$data['email']);
    $message = trim((string)$data['message']);

    /*
     * Do not take the recipient from the submitted form.
     * Hidden form fields can be changed by visitors.
     */

    $defaultRecipient = trim((string)$kirby->option(
      'schmoll-studio.contact-form.recipient',
      'hello@reduction-roadmap.de'
    ));
    $submittedRecipient = trim((string)($data['recipient'] ?? ''));
    $recipient          = $submittedRecipient !== '' ? $submittedRecipient : $defaultRecipient;

    $staffSubject = trim((string)$kirby->option(
      'schmoll-studio.contact-form.subject',
      'Neue Nachricht über reduction-roadmap.de'
    ));

    $confirmationSubject = trim((string)$kirby->option(
      'schmoll-studio.contact-form.confirmation-subject',
      'Vielen Dank für deine Nachricht'
    ));

    $fromName = trim((string)$kirby->option(
      'schmoll-studio.contact-form.from-name',
      'Reduction Roadmap'
    ));

    $fromEmail = trim((string)$kirby->option(
      'schmoll-studio.contact-form.from-email',
      'noreply@reduction-roadmap.de'
    ));

    if (filter_var($recipient, FILTER_VALIDATE_EMAIL) === false) {
      throw new RuntimeException('Invalid contact form recipient.');
    }

    if (filter_var($fromEmail, FILTER_VALIDATE_EMAIL) === false) {
      throw new RuntimeException('Invalid contact form sender.');
    }

    /*
     * Staff notification
     */
    $staffText = implode("\n", [
      'Neue Nachricht über das Kontaktformular',
      '',
      'Name: ' . $name,
      'E-Mail: ' . $email,
      '',
      'Nachricht:',
      $message,
    ]);

    $staffHtml = sprintf(
      '<h1>Neue Nachricht über das Kontaktformular</h1>
       <p>
         <strong>Name:</strong> %s<br>
         <strong>E-Mail:</strong> %s
       </p>
       <p><strong>Nachricht:</strong></p>
       <p>%s</p>',
      html($name),
      html($email),
      nl2br(html($message), false)
    );

    $staffEmail = $kirby->email([
      'from'     => $fromEmail,
      'fromName' => $fromName,
      'replyTo'  => [$email => $name],
      'to'       => [$recipient],
      'subject'  => $staffSubject,
      'body'     => [
        'text' => $staffText,
        'html' => $staffHtml,
      ],
    ]);

    if ($staffEmail->isSent() !== true) {
      throw new RuntimeException(
        'The staff notification could not be sent.'
      );
    }

    /*
     * Confirmation email to the visitor
     */
    $confirmationText = implode("\n", [
      'Hallo ' . $name . ',',
      '',
      'vielen Dank für deine Nachricht.',
      'Wir haben sie erhalten und melden uns so bald wie möglich bei dir.',
      '',
      'Deine Nachricht:',
      $message,
      '',
      'Viele Grüße',
      'Reduction Roadmap',
    ]);

    $confirmationHtml = sprintf(
      '<p>Hallo %s,</p>
       <p>
         vielen Dank für deine Nachricht. Wir haben sie erhalten und
         melden uns so bald wie möglich bei dir.
       </p>
       <p><strong>Deine Nachricht:</strong></p>
       <blockquote style="margin: 16px 0; padding-left: 16px; border-left: 3px solid #cccccc;">
         %s
       </blockquote>
       <p>Viele Grüße<br>Reduction Roadmap</p>',
      html($name),
      nl2br(html($message), false)
    );

    $confirmationEmail = $kirby->email([
      'from'     => $fromEmail,
      'fromName' => $fromName,
      'replyTo'  => [$recipient => $fromName],
      'to'       => [$email => $name],
      'subject'  => $confirmationSubject,
      'body'     => [
        'text' => $confirmationText,
        'html' => $confirmationHtml,
      ],
    ]);

    if ($confirmationEmail->isSent() !== true) {
      throw new RuntimeException(
        'The confirmation email could not be sent.'
      );
    }

    return true;
  }
}