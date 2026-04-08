<?php
header('Content-Type: application/json');

$db_path = __DIR__ . '/../database/database.sqlite';
$db = new PDO('sqlite:' . $db_path);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = trim($_GET['id'] ?? '');

if ($id === '') {
    echo json_encode([]);
    exit;
}

$stmt = $db->prepare('SELECT id, expires_at FROM surveys WHERE id = ?');
$stmt->execute([$id]);
$survey = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$survey || $survey['expires_at'] < time()) {
    echo json_encode([]);
    exit;
}

$stmt = $db->prepare('SELECT COUNT(*) FROM submissions WHERE survey_id = ?');
$stmt->execute([$id]);
$submission_count = (int)$stmt->fetchColumn();

$stmt = $db->prepare('SELECT * FROM questions WHERE survey_id = ? ORDER BY sort_order');
$stmt->execute([$id]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Populate text_answers for text questions (needed by insight_text_terms)
foreach ($questions as &$q) {
    if (in_array($q['type'], ['text_short', 'text_long'], true)) {
        $stmt = $db->prepare(
            'SELECT a.value FROM answers a
             JOIN submissions s ON s.id = a.submission_id
             WHERE a.question_id = ?'
        );
        $stmt->execute([$q['id']]);
        $q['text_answers'] = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'value');
    }
}
unset($q);

$tz_offset = (int)($_GET['tz_offset'] ?? 0);

require __DIR__ . '/insights.php';

// Wrap insight_time_of_day so it receives the caller's timezone offset.
$generators = array_map(function ($g) use ($tz_offset) {
    if ($g === 'insight_time_of_day') {
        return fn($questions, $db, $n) => insight_time_of_day($questions, $db, $n, $tz_offset);
    }
    return $g;
}, $generators);

$insights = compute_insights($questions, $db, $submission_count, $generators);

echo json_encode(array_map(fn($i) => ['text' => $i['text']], $insights));
