<?php

/**
 * Member pages hold the data for the member wall and are not destinations in
 * themselves. Send visitors to the organisation's own site when one is known,
 * otherwise back to the parent page.
 *
 * The field is called "website" rather than "url" on purpose: a content field
 * named url is shadowed by Kirby's Page::url() method.
 */

go($page->website()->isNotEmpty() ? $page->website()->toUrl() : $page->parent()->url());
