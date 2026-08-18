<?php

namespace SchmollStudio\ContactForm;

use Kirby\Cms\App;
use Kirby\Cms\Page;
use RuntimeException;

class BestPracticesSubmission
{
  public static function validate(array $data): array
  {
    $errors = [];
    $honeypot = trim((string)($data['website'] ?? ''));
    $title = trim((string)($data['title'] ?? ''));
    $name = trim((string)($data['submitterName'] ?? ''));
    $email = trim((string)($data['submitterEmail'] ?? ''));
    $description = trim((string)($data['description'] ?? ''));

    if ($honeypot !== '') $errors['website'] = 'Invalid request.';
    if ($title === '') $errors['title'] = 'Bitte gib einen Projekttitel ein.';
    if ($name === '') $errors['submitterName'] = 'Bitte gib deinen Namen ein.';
    if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      $errors['submitterEmail'] = 'Bitte gib eine gültige E-Mail-Adresse ein.';
    }
    if ($description === '') $errors['description'] = 'Bitte beschreibe das Projekt.';

    return [
      'valid' => $errors === [],
      'errors' => $errors,
    ];
  }

  public static function create(array $data, App $kirby): Page
  {
    $result = static::validate($data);
    if ($result['valid'] !== true) {
      throw new RuntimeException('The Best Practices submission is invalid.');
    }

    $parentId = trim((string)($data['parent'] ?? ''));
    $parent = $parentId !== ''
      ? $kirby->site()->find($parentId)
      : $kirby->site()->find('best-practices');

    if ($parent === null || $parent->template()->name() !== 'best-practices') {
      throw new RuntimeException('The selected Best Practices parent is invalid.');
    }

    $title = trim((string)$data['title']);
    $slug = static::uniqueSlug($parent, $title);
    $submittedAt = date('Y-m-d H:i:s');

    return $parent->createChild([
      'slug' => $slug,
      'template' => 'best-practice-submission',
      'content' => [
        'title' => $title,
        'location' => trim((string)($data['location'] ?? '')),
        'year' => trim((string)($data['year'] ?? '')),
        'area' => trim((string)($data['area'] ?? '')),
        'function' => trim((string)($data['function'] ?? '')),
        'constructionType' => trim((string)($data['constructionType'] ?? '')),
        'co2Range' => trim((string)($data['co2Range'] ?? '')),
        'co2Value' => trim((string)($data['co2Value'] ?? '')),
        'description' => trim((string)$data['description']),
        'sourceUrl' => trim((string)($data['sourceUrl'] ?? '')),
        'submitterName' => trim((string)$data['submitterName']),
        'submitterEmail' => trim((string)$data['submitterEmail']),
        'submittedAt' => $submittedAt,
      ],
    ]);
  }

  public static function notify(Page $submission, App $kirby): bool
  {
    $recipient = trim((string)$kirby->option(
      'schmoll-studio.contact-form.recipient',
      'hello@reduction-roadmap.de'
    ));
    $fromName = trim((string)$kirby->option(
      'schmoll-studio.contact-form.from-name',
      'Reduction Roadmap'
    ));
    $fromEmail = trim((string)$kirby->option(
      'schmoll-studio.contact-form.from-email',
      'noreply@reduction-roadmap.de'
    ));
    $confirmationSubject = trim((string)$kirby->option(
      'schmoll-studio.contact-form.confirmation-subject',
      'Vielen Dank für deine Einreichung'
    ));

    if (filter_var($recipient, FILTER_VALIDATE_EMAIL) === false) {
      throw new RuntimeException('Invalid submission recipient.');
    }
    if (filter_var($fromEmail, FILTER_VALIDATE_EMAIL) === false) {
      throw new RuntimeException('Invalid submission sender.');
    }

    $fields = [
      'Projekt' => $submission->title()->value(),
      'Ort' => $submission->location()->value(),
      'Jahr' => $submission->year()->value(),
      'Fläche' => $submission->area()->value() . ' m²',
      'Funktion' => $submission->function()->value(),
      'Baumaßnahme' => $submission->constructionType()->value(),
      'CO₂-Bereich' => $submission->co2Range()->value(),
      'CO₂-Wert' => $submission->co2Value()->value(),
      'Quelle' => $submission->sourceUrl()->value(),
      'Eingereicht von' => $submission->submitterName()->value(),
      'E-Mail' => $submission->submitterEmail()->value(),
    ];

    $staffText = "Neue Best-Practice-Einreichung\n\n";
    foreach ($fields as $label => $value) {
      if ($value !== '') $staffText .= $label . ': ' . $value . "\n";
    }
    $staffText .= "\nBeschreibung:\n" . $submission->description()->value();

    $staffHtml = '<h1>Neue Best-Practice-Einreichung</h1><dl>';
    foreach ($fields as $label => $value) {
      if ($value !== '') {
        $staffHtml .= '<dt><strong>' . html($label) . '</strong></dt><dd>' . html($value) . '</dd>';
      }
    }
    $staffHtml .= '</dl><p><strong>Beschreibung:</strong></p><p>'
      . nl2br(html($submission->description()->value()), false) . '</p>';

    $email = $kirby->email([
      'from' => $fromEmail,
      'fromName' => $fromName,
      'replyTo' => [$submission->submitterEmail()->value() => $submission->submitterName()->value()],
      'to' => [$recipient],
      'subject' => 'Neue Best-Practice-Einreichung: ' . $submission->title()->value(),
      'body' => ['text' => $staffText, 'html' => $staffHtml],
    ]);

    if ($email->isSent() !== true) return false;

    $name = $submission->submitterName()->value();
    $submitterEmail = $submission->submitterEmail()->value();
    $title = $submission->title()->value();
    $confirmationText = implode("\n", [
      'Hallo ' . $name . ',',
      '',
      'vielen Dank für deine Einreichung von „' . $title . '“.',
      'Wir haben die Informationen erhalten und prüfen das Projekt nun.',
      '',
      'Viele Grüße',
      'Reduction Roadmap',
    ]);
    $confirmationHtml = sprintf(
      '<p>Hallo %s,</p>
       <p>vielen Dank für deine Einreichung von „%s“.</p>
       <p>Wir haben die Informationen erhalten und prüfen das Projekt nun.</p>
       <p>Viele Grüße<br>Reduction Roadmap</p>',
      html($name),
      html($title)
    );

    $confirmation = $kirby->email([
      'from' => $fromEmail,
      'fromName' => $fromName,
      'replyTo' => [$recipient => $fromName],
      'to' => [$submitterEmail => $name],
      'subject' => $confirmationSubject,
      'body' => ['text' => $confirmationText, 'html' => $confirmationHtml],
    ]);

    return $confirmation->isSent() === true;
  }

  protected static function uniqueSlug(Page $parent, string $title): string
  {
    $base = \Kirby\Toolkit\Str::slug($title) ?: 'submission';
    $slug = $base . '-' . date('YmdHis');
    $counter = 1;

    while ($parent->children()->find($slug)) {
      $slug = $base . '-' . date('YmdHis') . '-' . $counter++;
    }

    return $slug;
  }
}
