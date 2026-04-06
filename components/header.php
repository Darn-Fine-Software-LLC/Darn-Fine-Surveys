<?php
/**
 * Shared site header component.
 * Usage: include __DIR__ . '/components/header.php';
 *
 * Expected variables (set before including):
 *   - $page_title (string, optional) — defaults to 'Darn Fine Surveys'
 *   - $page_description (string, optional)
 *   - $og_type (string, optional) — defaults to 'website'
 *   - $header_cta (bool) — whether to show "Create your own" CTA, default false
 *   - $survey (array, optional) — pass a survey array for survey-specific pages
 */
$page_title       = $page_title       ?? 'Darn Fine Surveys';
$page_description = $page_description ?? 'Simple surveys that auto-delete. No account needed.';
$og_type         = $og_type         ?? 'website';
$header_cta      = $header_cta      ?? false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <?php if ($page_description): ?>
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
    <?php endif; ?>
    <meta property="og:type" content="<?= htmlspecialchars($og_type) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <a href="/" class="logo">
            <svg class="logo-mark" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="28" height="28" rx="7" fill="var(--accent)"/>
                <path d="M8 9h12M8 14h8M8 19h10" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span class="logo-text">Darn Fine Surveys</span>
        </a>
        <?php if ($header_cta): ?>
        <a href="/" class="btn btn-primary btn-sm">Create Survey</a>
        <?php endif; ?>
    </div>
</header>
