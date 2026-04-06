<?php
session_start();

$db_path = __DIR__ . '/../database/database.sqlite';
$db = new PDO('sqlite:' . $db_path);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = trim($_GET['id'] ?? '');

if ($id === '') {
    header('Location: /');
    exit;
}

$stmt = $db->prepare('SELECT * FROM surveys WHERE id = ?');
$stmt->execute([$id]);
$survey = $stmt->fetch(PDO::FETCH_ASSOC);

$now = time();

if (!$survey || $survey['expires_at'] < $now) {
    http_response_code(404);
    $page_title = 'Survey Not Found';
    $not_found  = true;
} else {
    $not_found = false;

    $stmt = $db->prepare(
        'SELECT * FROM questions WHERE survey_id = ? ORDER BY sort_order'
    );
    $stmt->execute([$id]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $choice_types = ['radio', 'checkbox', 'select'];
    foreach ($questions as &$q) {
        if (in_array($q['type'], $choice_types, true)) {
            $stmt = $db->prepare(
                'SELECT * FROM question_choices WHERE question_id = ? ORDER BY sort_order'
            );
            $stmt->execute([$q['id']]);
            $q['choices'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $q['choices'] = [];
        }
    }
    unset($q);

    $expires_at  = (int)$survey['expires_at'];
    $page_title  = htmlspecialchars($survey['title']) . ' — Darn Fine Surveys';
}

$success = $_SESSION['survey_submitted'] ?? false;
unset($_SESSION['survey_submitted']);

$header_cta = true;
include __DIR__ . '/../components/header.php';
?>

<main>

<?php if ($not_found): ?>

    <div class="not-found">
        <div class="not-found-icon">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none"><path d="M6 6l16 16M22 6L6 22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <h2>Survey Not Found</h2>
        <p>This survey doesn't exist or has already expired and been deleted.</p>
        <a href="/" class="btn btn-primary">Create a New Survey</a>
    </div>

<?php else: ?>

    <div class="survey-hero">
        <h1><?= htmlspecialchars($survey['title']) ?></h1>
        <div class="survey-countdown"
             x-data="countdown(<?= $expires_at ?>)"
             x-init="init()">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="5" stroke="currentColor" stroke-width="1.5"/><path d="M6 3v3.5l2 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            Deletes in <strong x-text="formatted"></strong>
        </div>
    </div>

    <div class="survey-disclaimer">
        <svg class="survey-disclaimer-icon" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1a7 7 0 100 14A7 7 0 008 1zM8 5v3M8 10.5v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        <span>Results are visible to anyone — don't submit private or sensitive information. This link cannot be recovered if lost.</span>
    </div>

    <?php if ($success): ?>
    <div class="alert-success">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8l4 4 6-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Response submitted. Thanks!
    </div>
    <?php endif; ?>

    <form action="/surveys/submit.php" method="POST">
        <input type="hidden" name="survey_id" value="<?= htmlspecialchars($id) ?>">

        <?php foreach ($questions as $qi => $q): ?>
        <div class="question-block"
             x-data="{ answered: false, dimmed: false }"
             x-on:change="answered = true"
             x-on:input="answered = true"
             x-on:mouseleave="if (answered) dimmed = true"
             x-on:mouseenter="dimmed = false"
             :class="{ 'question-dimmed': dimmed }"
             style="animation-delay: <?= $qi * 0.05 ?>s">

            <div class="question-header">
                <span class="question-number">Question <?= $qi + 1 ?></span>
                <?php if ($q['is_required']): ?>
                <span class="required-badge">Required</span>
                <?php endif; ?>
            </div>

            <div class="question-label">
                <?= htmlspecialchars($q['label']) ?>
                <?php if ($q['is_required']): ?><span class="required-star">*</span><?php endif; ?>
            </div>

            <?php if ($q['description'] !== null && $q['description'] !== ''): ?>
            <div class="question-description"><?= htmlspecialchars($q['description']) ?></div>
            <?php endif; ?>

            <?php if ($q['type'] === 'radio'): ?>
                <div class="choices-list">
                    <?php foreach ($q['choices'] as $choice): ?>
                    <label class="choice-option">
                        <input type="radio"
                               name="answers[<?= $q['id'] ?>]"
                               value="<?= htmlspecialchars($choice['label']) ?>"
                               <?= $q['is_required'] ? 'required' : '' ?>>
                        <span><?= htmlspecialchars($choice['label']) ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>

            <?php elseif ($q['type'] === 'checkbox'): ?>
                <div class="choices-list">
                    <?php foreach ($q['choices'] as $choice): ?>
                    <label class="choice-option">
                        <input type="checkbox"
                               name="answers[<?= $q['id'] ?>][]"
                               value="<?= htmlspecialchars($choice['label']) ?>">
                        <span><?= htmlspecialchars($choice['label']) ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>

            <?php elseif ($q['type'] === 'select'): ?>
                <div class="field">
                    <select name="answers[<?= $q['id'] ?>]" <?= $q['is_required'] ? 'required' : '' ?>>
                        <option value="">— Choose one —</option>
                        <?php foreach ($q['choices'] as $choice): ?>
                        <option value="<?= htmlspecialchars($choice['label']) ?>">
                            <?= htmlspecialchars($choice['label']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <?php elseif ($q['type'] === 'text_short'): ?>
                <div class="field">
                    <input type="text"
                           name="answers[<?= $q['id'] ?>]"
                           maxlength="255"
                           placeholder="Your answer"
                           <?= $q['is_required'] ? 'required' : '' ?>>
                </div>

            <?php elseif ($q['type'] === 'text_long'): ?>
                <div class="field">
                    <textarea name="answers[<?= $q['id'] ?>]"
                              maxlength="1000"
                              rows="4"
                              placeholder="Your answer"
                              <?= $q['is_required'] ? 'required' : '' ?>></textarea>
                </div>
            <?php endif; ?>

        </div>
        <?php endforeach; ?>

        <div class="submit-row">
            <button type="submit" class="btn btn-primary btn-lg">
                Submit Response
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 4l3 3-3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </div>

    </form>

    <div style="text-align:center; margin-top:1.5rem;">
        <a href="/surveys/results.php?id=<?= htmlspecialchars($id) ?>" class="btn btn-ghost btn-sm">
            View Results
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </div>

<?php endif; ?>

</main>

<script>
    function countdown(expiresAt) {
        return {
            remaining: expiresAt - Math.floor(Date.now() / 1000),
            get formatted() {
                if (this.remaining <= 0) return 'expired';
                const d = Math.floor(this.remaining / 86400);
                const h = Math.floor((this.remaining % 86400) / 3600);
                const m = Math.floor((this.remaining % 3600) / 60);
                const s = this.remaining % 60;
                if (d > 0) return `${d}d ${h}h ${m}m`;
                if (h > 0) return `${h}h ${m}m ${s}s`;
                return `${m}m ${s}s`;
            },
            init() {
                setInterval(() => { this.remaining = Math.max(0, this.remaining - 1); }, 1000);
            }
        };
    }
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>
