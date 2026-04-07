<?php
$page_title       = 'Privacy Policy — Darn Fine Surveys';
$page_description = 'Darn Fine Surveys collects no personal information and uses no tracking or analytics.';
$header_cta       = true;
include __DIR__ . '/components/header.php';
?>

<main>
    <div class="privacy-hero" style="animation: fade-up 0.45s ease both;">
        <div class="hero-eyebrow" style="margin-bottom: 1.5rem;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            Privacy Policy
        </div>
        <h1 style="font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); font-weight: 600; letter-spacing: -0.02em; line-height: 1.15; margin-bottom: 0.85rem;">
            We keep it <em style="font-style: italic; color: var(--accent);">simple.</em>
        </h1>
        <p style="font-size: 1.05rem; color: var(--muted); max-width: 460px; line-height: 1.7; margin: 0 auto 2.5rem auto;">
            No tracking. No accounts. No stored personal data. Just surveys that disappear when they're done.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 3rem; animation: fade-up 0.45s 0.08s ease both;">
        <div class="privacy-pillar">
            <div class="privacy-pillar-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                </svg>
            </div>
            <div class="privacy-pillar-title">No tracking</div>
            <div class="privacy-pillar-body">No analytics, tracking or personal data stored.</div>
        </div>
        <div class="privacy-pillar">
            <div class="privacy-pillar-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/>
                </svg>
            </div>
            <div class="privacy-pillar-title">No personal data</div>
            <div class="privacy-pillar-body">We don't collect names, emails, IP addresses, or any identifying information.</div>
        </div>
        <div class="privacy-pillar">
            <div class="privacy-pillar-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
            </div>
            <div class="privacy-pillar-title">Auto-deleted</div>
            <div class="privacy-pillar-body">Every survey and its responses are permanently deleted when it expires.</div>
        </div>
    </div>

    <div class="form-card" style="max-width: 680px; margin: 0 auto; animation: fade-up 0.45s 0.15s ease both;">

        <section class="privacy-section">
            <h2>What we collect</h2>
            <p>Nothing that could identify you personally. When someone takes a survey, we store only their answers — no names, no email addresses, no IP addresses, no device fingerprints, no session identifiers.</p>
            <p>Survey creators provide a title, questions, and an expiry window. That's it.</p>
        </section>

        <div class="form-divider"></div>

        <section class="privacy-section">
            <h2>Tracking &amp; analytics</h2>
            <p>Darn Fine Surveys uses <strong>no analytics software, no tracking pixels, no advertising scripts, and no third-party cookies.</strong> There is nothing watching you use this site — not us, not anyone else.</p>
        </section>

        <div class="form-divider"></div>

        <section class="privacy-section">
            <h2>Data retention &amp; deletion</h2>
            <p>Every survey is created with an expiry: 1 day, 1 week, or 1 month. When a survey expires, <strong>all of its data is permanently deleted</strong> — the survey itself, every question, and every response. There are no archives, no backups retained beyond that window. Users are free to export the data while the survey is live, but not after.</p>
            <p>Survey responses are visible to anyone with the results link while the survey is live. Once deleted, they are gone for good.</p>
        </section>

        <div class="form-divider"></div>

        <section class="privacy-section">
            <h2>Cookies</h2>
            <p>We don't set any cookies.</p>
        </section>

        <div class="form-divider"></div>

        <section class="privacy-section">
            <h2>Third-party services</h2>
            <p>We load fonts from <strong>Google Fonts</strong> (fonts.googleapis.com). This is a standard CDN request your browser makes; Google may log it per their own privacy policy. We have no control over and no visibility into those logs.</p>
            <p>Everything else — styles, scripts, logic — is served directly from our own server.</p>
        </section>

        <div class="form-divider"></div>

        <section class="privacy-section" style="margin-bottom: 0;">
            <h2>Contact</h2>
            <p>Questions about this policy or about how Darn Fine Surveys handles data? Reach out to <strong>Darn Fine Software</strong>:</p>
            <a href="mailto:hi@thatalexguy.dev" class="privacy-contact-link">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
                hi@thatalexguy.dev
            </a>
        </section>

    </div>

    <p style="text-align: center; font-size: 0.8rem; color: var(--muted-light); margin-top: 2.5rem; animation: fade-up 0.45s 0.2s ease both;">
        Last updated April 2026
    </p>
</main>

<style>
.privacy-hero {
    text-align: center;
    padding: 3.5rem 0 2.5rem;
}

.privacy-pillar {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1.5rem 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    box-shadow: var(--shadow-sm);
    transition: box-shadow 0.2s, transform 0.2s;
}
.privacy-pillar:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.privacy-pillar-icon {
    color: var(--accent);
    margin-bottom: 0.25rem;
}

.privacy-pillar-title {
    font-family: var(--font-display);
    font-weight: 600;
    font-size: 1rem;
    color: var(--text);
}

.privacy-pillar-body {
    font-size: 0.85rem;
    color: var(--muted);
    line-height: 1.6;
}

.privacy-section h2 {
    font-family: var(--font-display);
    font-weight: 600;
    font-size: 1.2rem;
    margin-bottom: 0.65rem;
    color: var(--text);
}

.privacy-section p {
    font-size: 0.925rem;
    color: var(--text-warm);
    line-height: 1.75;
    margin-bottom: 0.75rem;
}
.privacy-section p:last-child { margin-bottom: 0; }

.privacy-section strong {
    color: var(--text);
    font-weight: 600;
}

.privacy-contact-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.85rem;
    color: var(--accent);
    font-size: 0.925rem;
    font-weight: 500;
    text-decoration: none;
    padding: 0.6rem 1rem;
    border: 1.5px solid var(--accent-mid);
    border-radius: var(--radius-sm);
    background: var(--accent-soft);
    transition: background 0.15s, border-color 0.15s;
}
.privacy-contact-link:hover {
    background: var(--accent-mid);
    border-color: var(--accent);
}

@media (max-width: 600px) {
    div[style*="grid-template-columns: 1fr 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    .privacy-hero { padding: 2rem 0 1.5rem; }
}
</style>

<?php include __DIR__ . '/components/footer.php'; ?>
