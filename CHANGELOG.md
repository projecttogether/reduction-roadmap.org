# Changelog

All notable changes to this project are documented in this file.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and
this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

Content edits made through the panel are committed automatically by Git Content
and are not listed here; this file covers the site itself.

## [Unreleased]

## [1.0.0] - 2026-10-27

First tagged release. The site is live at reduction-roadmap.de and this entry
records the state it reached, rather than its development history.

### Added

#### Site and content model

- Kirby 5 site on PHP 8.2 with a German panel, styled with Tailwind CSS v4.
- Pages are assembled from a layout field: sections hold columns, columns hold
  blocks. Each section carries its own width, padding, margin, background and
  border settings, and every block carries its own spacing and borders.
- Public pages: start page, Roadmap Germany, Methodik, Praxisbeispiele,
  Kontakt, Unterstützen, Impressum, Datenschutz, plus a styled error page.
- Site-wide settings for navigation, branding, social links and a dismissable
  popup that remembers visitors between visits.

#### Blocks

- Nineteen block types available in the layout field, among them page header, hero, heading, text, image,
  full-bleed image, quote, list, button, card grid, slideshow, logo slideshow
  and image marquee.
- Shared border and spacing settings are injected into every block by their own
  plugins, so block blueprints stay focused on content.

#### Best practices

- A Praxisbeispiele collection of building projects, each with location,
  period, floor area, building use, construction type, GHG value, description,
  images and an optional external source.
- A filterable project grid block. Filters for use, construction type and CO₂
  are built from the projects themselves and labelled in German.
- A public submission form. Submissions are validated, stored as drafts for
  editorial review, and confirmed by email to both the team and the submitter
  via MailerSend. Uploads are accepted and consent is recorded.
- A slide-in detail overlay per project, filled from a dedicated layout field
  so editors compose the detail view like any other page. Projects without
  overlay content simply do not offer one.

#### Members

- A Mitglieder/Partner:innen collection, one page per supporting organisation
  with name, logo and website.
- A member wall block rendering a wall of logos followed by a wall of names.
  Organisations with a logo appear as logos, those without as names, so editors
  maintain the member rather than its placement.

#### Editing

- Custom panel previews and German labels throughout the blueprints.
- German hyphenation as a field method, applied to body copy.
- Footnotes via a KirbyTag.

#### Deployment

- Docker image built from php:8.2-apache, deployed to Coolify.
- Content lives on a persistent volume, so editorial changes survive
  redeployments, and is mirrored to the deploy branch by Git Content.
- Content commits are marked so they do not trigger a rebuild; code pushes
  deploy as usual.
- Debug output is enabled only on local development hosts and can be forced
  with KIRBY_DEBUG.

[Unreleased]: https://github.com/joh-sch/reduction-roadmap.org/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/joh-sch/reduction-roadmap.org/releases/tag/v1.0.0
