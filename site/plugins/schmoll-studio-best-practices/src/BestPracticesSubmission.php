<?php

namespace SchmollStudio\BestPractices;

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
    $hasImages = static::hasUploadedImages();

    if ($honeypot !== '') $errors['website'] = 'Invalid request.';
    if ($title === '') $errors['title'] = 'Bitte gib einen Projekttitel ein.';
    if ($name === '') $errors['submitterName'] = 'Bitte gib deinen Namen ein.';
    if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      $errors['submitterEmail'] = 'Bitte gib eine gültige E-Mail-Adresse ein.';
    }
    if ($description === '') $errors['description'] = 'Bitte beschreibe das Projekt.';
    if (str_word_count($description) > 100) $errors['description'] = 'Die Projektbeschreibung darf maximal 100 Wörter enthalten.';
    foreach (['projectSponsor', 'projectStatus', 'location', 'constructionType', 'buildingUse', 'thgTarget', 'areaReference', 'contactPermission'] as $field) {
      if (trim((string)($data[$field] ?? '')) === '') $errors[$field] = 'Dieses Feld ist erforderlich.';
    }
    if (($data['submitPermission'] ?? '') !== 'yes') $errors['submitPermission'] = 'Bitte bestätige die Übermittlung der Angaben.';
    if ($hasImages && ($data['imageRights'] ?? '') !== 'yes') $errors['imageRights'] = 'Bitte bestätige die Bildrechte.';

    return ['valid' => $errors === [], 'errors' => $errors];
  }

  public static function create(array $data, App $kirby): Page
  {
    $result = static::validate($data);
    if ($result['valid'] !== true) {
      throw new RuntimeException('The Best Practices submission is invalid: ' . implode(', ', array_keys($result['errors'])));
    }

    $parentId = trim((string)($data['parent'] ?? ''));
    $parent = $parentId !== '' ? $kirby->site()->find($parentId) : $kirby->site()->find('best-practices');
    if ($parent === null || $parent->intendedTemplate()->name() !== 'best-practices') {
      throw new RuntimeException('The selected Best Practices parent is invalid.');
    }

    $title = trim((string)$data['title']);
    $submission = $parent->createChild([
      'slug' => static::uniqueSlug($parent, $title),
      'template' => 'best-practice-submission',
      'content' => [
        'title' => $title,
        'projectSponsor' => trim((string)($data['projectSponsor'] ?? '')),
        'participatingOrganizations' => trim((string)($data['participatingOrganizations'] ?? '')),
        'projectStatus' => trim((string)($data['projectStatus'] ?? '')),
        'projectPeriod' => trim((string)($data['projectPeriod'] ?? '')),
        'location' => trim((string)($data['location'] ?? '')),
        'buildingUse' => trim((string)($data['buildingUse'] ?? '')),
        'grossFloorArea' => trim((string)($data['grossFloorArea'] ?? '')),
        'constructionType' => trim((string)($data['constructionType'] ?? '')),
        'thgTarget' => trim((string)($data['thgTarget'] ?? '')),
        'thgValue' => trim((string)($data['thgValue'] ?? '')),
        'areaReference' => trim((string)($data['areaReference'] ?? '')),
        'description' => trim((string)$data['description']),
        'sourceUrl' => trim((string)($data['sourceUrl'] ?? '')),
        'submitterName' => trim((string)$data['submitterName']),
        'submitterRole' => trim((string)($data['submitterRole'] ?? '')),
        'submitterOrganization' => trim((string)($data['submitterOrganization'] ?? '')),
        'submitterEmail' => trim((string)$data['submitterEmail']),
        'submitterPhone' => trim((string)($data['submitterPhone'] ?? '')),
        'submitPermission' => trim((string)($data['submitPermission'] ?? '')),
        'imageRights' => trim((string)($data['imageRights'] ?? '')),
        'contactPermission' => trim((string)($data['contactPermission'] ?? '')),
        'internalNotes' => trim((string)($data['internalNotes'] ?? '')),
        'submittedAt' => date('Y-m-d H:i:s'),
      ],
    ]);

    foreach (static::uploadedImages() as $file) {
      $submission->createFile([
        'source' => $file['tmp_name'],
        'filename' => basename($file['name']),
      ]);
    }

    return $submission;
  }

  public static function notify(Page $submission, App $kirby): bool
  {
    $smtpUsername = getenv('MAILERSEND_SMTP_USERNAME') ?: '';
    $smtpPassword = getenv('MAILERSEND_SMTP_PASSWORD') ?: '';
    $recipient = trim((string)$kirby->option('schmoll-studio.contact-form.recipient', 'hello@reduction-roadmap.de'));
    $fromName = trim((string)$kirby->option('schmoll-studio.contact-form.from-name', 'Reduction Roadmap'));
    $fromEmail = trim((string)$kirby->option('schmoll-studio.contact-form.from-email', 'noreply@reduction-roadmap.de'));
    $confirmationSubject = trim((string)$kirby->option('schmoll-studio.contact-form.confirmation-subject', 'Vielen Dank für deine Einreichung'));

    if ($smtpUsername === '' || $smtpPassword === '') {
      throw new RuntimeException('MailerSend SMTP credentials are not configured. Set MAILERSEND_SMTP_USERNAME and MAILERSEND_SMTP_PASSWORD.');
    }
    if (filter_var($recipient, FILTER_VALIDATE_EMAIL) === false) throw new RuntimeException('Invalid submission recipient.');
    if (filter_var($fromEmail, FILTER_VALIDATE_EMAIL) === false) throw new RuntimeException('Invalid submission sender.');

    $fields = [
      'Projekttitel' => $submission->title()->value(),
      'Projektträger:in / Auftraggeber:in' => $submission->projectSponsor()->value(),
      'Beteiligte Organisationen' => $submission->participatingOrganizations()->value(),
      'Projektstatus' => $submission->projectStatus()->value(),
      'Projektzeitraum' => $submission->projectPeriod()->value(),
      'Projektstandort' => $submission->location()->value(),
      'Baumaßnahme' => $submission->constructionType()->value(),
      'Gebäudenutzung' => $submission->buildingUse()->value(),
      'Brutto-Grundfläche' => $submission->grossFloorArea()->value() . ' m²',
      'THG-Zielwert' => $submission->thgTarget()->value(),
      'THG-Kennwert' => $submission->thgValue()->value(),
      'Flächenbezug' => $submission->areaReference()->value(),
      'Projektwebseite / Quelle' => $submission->sourceUrl()->value(),
      'Name' => $submission->submitterName()->value(),
      'Funktion / Bezug' => $submission->submitterRole()->value(),
      'Organisation' => $submission->submitterOrganization()->value(),
      'E-Mail' => $submission->submitterEmail()->value(),
      'Telefon' => $submission->submitterPhone()->value(),
      'Kontaktaufnahme erlaubt' => $submission->contactPermission()->value(),
    ];

    $staffText = "Neue Best-Practice-Einreichung\n\n";
    foreach ($fields as $label => $value) if ($value !== '') $staffText .= $label . ': ' . $value . "\n";
    $staffText .= "\nProjektbeschreibung:\n" . $submission->description()->value();
    $staffText .= "\n\nInterne Hinweise:\n" . $submission->internalNotes()->value();

    $staffHtml = '<h1>Neue Best-Practice-Einreichung</h1><dl>';
    foreach ($fields as $label => $value) if ($value !== '') $staffHtml .= '<dt><strong>' . html($label) . '</strong></dt><dd>' . html($value) . '</dd>';
    $staffHtml .= '</dl><p><strong>Projektbeschreibung:</strong></p><p>' . nl2br(html($submission->description()->value()), false) . '</p><p><strong>Interne Hinweise:</strong></p><p>' . nl2br(html($submission->internalNotes()->value()), false) . '</p>';

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
    $confirmationText = implode("\n", ['Hallo ' . $name . ',', '', 'vielen Dank für deine Einreichung von „' . $title . '“.', 'Wir haben die Informationen erhalten und prüfen das Projekt nun.', '', 'Viele Grüße', 'Reduction Roadmap']);
    $confirmationHtml = sprintf('<p>Hallo %s,</p><p>vielen Dank für deine Einreichung von „%s“.</p><p>Wir haben die Informationen erhalten und prüfen das Projekt nun.</p><p>Viele Grüße<br>Reduction Roadmap</p>', html($name), html($title));
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
    while ($parent->children()->find($slug)) $slug = $base . '-' . date('YmdHis') . '-' . $counter++;
    return $slug;
  }

  protected static function uploadedImages(): array
  {
    $files = $_FILES['projectImages'] ?? [];
    if (!is_array($files) || !is_array($files['name'] ?? null)) return [];

    $uploads = [];
    foreach ($files['name'] as $index => $name) {
      $error = $files['error'][$index] ?? UPLOAD_ERR_NO_FILE;
      if ($error === UPLOAD_ERR_NO_FILE) continue;
      if ($error !== UPLOAD_ERR_OK || !is_uploaded_file($files['tmp_name'][$index] ?? '')) {
        throw new RuntimeException('An uploaded image could not be processed.');
      }
      $mime = mime_content_type($files['tmp_name'][$index]);
      if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'], true)) {
        throw new RuntimeException('Only JPEG, PNG, GIF, and WebP images are allowed.');
      }
      $uploads[] = [
        'name' => (string)$name,
        'tmp_name' => $files['tmp_name'][$index],
      ];
    }

    return $uploads;
  }

  protected static function hasUploadedImages(): bool
  {
    return static::uploadedImages() !== [];
  }
}
