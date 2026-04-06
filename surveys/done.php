<?php
session_start();

$id = trim($_GET['id'] ?? '');

if ($id === '' || empty($_SESSION['survey_submitted'])) {
    header('Location: /');
    exit;
}

unset($_SESSION['survey_submitted']);

$db_path = __DIR__ . '/../database/database.sqlite';
$db = new PDO('sqlite:' . $db_path);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare('SELECT * FROM surveys WHERE id = ?');
$stmt->execute([$id]);
$survey = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$survey) {
    header('Location: /');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanks for responding — Darn Fine Surveys</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body class="done-body">

<canvas id="confetti-canvas"></canvas>

<div class="done-wrap">
    <div class="done-card">
        <div class="done-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 12.5L9.5 17L19 7.5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h1 class="done-heading">Nice response!</h1>
        <p class="done-subtext">Your answers have been recorded. Results are public — thank you for being part of it.</p>
        <a href="/surveys/results.php?id=<?= htmlspecialchars($id) ?>" class="btn btn-primary done-btn">
            View Results
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 4l3 3-3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
    </div>
</div>

<script>
(function () {
    const canvas = document.getElementById('confetti-canvas');
    const ctx = canvas.getContext('2d');

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const colors = [
        '#C4704A',
        '#E8A87C',
        '#F5C9A8',
        '#D4956A',
        '#E8D4C4',
        '#C4A48A',
        '#A85D3A',
        '#F0D4B8',
    ];

    class Particle {
        constructor() {
            const cx = canvas.width / 2;
            const cy = canvas.height / 2;
            const angle = Math.random() * Math.PI * 2;
            const speed = 4 + Math.random() * 12;
            this.x = cx + (Math.random() - 0.5) * 60;
            this.y = cy + (Math.random() - 0.5) * 30;
            this.vx = Math.cos(angle) * speed;
            this.vy = Math.sin(angle) * speed - 3;
            this.w = 5 + Math.random() * 8;
            this.h = 3 + Math.random() * 4;
            this.rot = Math.random() * Math.PI * 2;
            this.rotV = (Math.random() - 0.5) * 0.25;
            this.color = colors[Math.floor(Math.random() * colors.length)];
            this.alpha = 1;
            this.born = Date.now();
            this.life = 2000 + Math.random() * 1600;
        }
        update() {
            this.vy += 0.2;
            this.vx *= 0.99;
            this.x += this.vx;
            this.y += this.vy;
            this.rot += this.rotV;
            const age = Date.now() - this.born;
            this.alpha = Math.max(0, 1 - age / this.life);
        }
        draw(ctx) {
            ctx.save();
            ctx.globalAlpha = this.alpha;
            ctx.translate(this.x, this.y);
            ctx.rotate(this.rot);
            ctx.fillStyle = this.color;
            ctx.fillRect(-this.w / 2, -this.h / 2, this.w, this.h);
            ctx.restore();
        }
    }

    const particles = [];
    for (let i = 0; i < 180; i++) {
        particles.push(new Particle());
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let i = particles.length - 1; i >= 0; i--) {
            particles[i].update();
            particles[i].draw(ctx);
            if (particles[i].alpha <= 0) particles.splice(i, 1);
        }
        if (particles.length > 0) {
            requestAnimationFrame(animate);
        } else {
            canvas.style.display = 'none';
        }
    }
    animate();
})();
</script>

</body>
</html>
