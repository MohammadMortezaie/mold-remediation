<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function load_env(string $path): void
{
    if (!is_file($path) || !is_readable($path)) {
        return;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$name, $value] = array_map('trim', explode('=', $line, 2));
        if ($name === '' || getenv($name) !== false) {
            continue;
        }
        if (strlen($value) >= 2 && (($value[0] === '"' && str_ends_with($value, '"')) || ($value[0] === "'" && str_ends_with($value, "'")))) {
            $value = substr($value, 1, -1);
        }
        putenv($name . '=' . $value);
        $_ENV[$name] = $value;
    }
}

load_env(__DIR__ . '/.env');

function env_value(string $key, string $default = ''): string
{
    $value = getenv($key);
    return $value === false ? $default : trim((string) $value);
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function site_url(string $path = ''): string
{
    $base = rtrim(env_value('SITE_URL', 'https://moldremediationwestvancouver.ca'), '/');
    return $base . ($path === '' ? '/' : '/' . ltrim($path, '/'));
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
    }
    return $_SESSION['csrf_token'];
}

function service_pages(): array
{
    return [
        'mold-testing.php' => 'Mold Testing',
        'mold-detection.php' => 'Mold Detection',
        'black-mold-inspection.php' => 'Black Mold Inspection',
        'attic-mold-inspection.php' => 'Attic Mold Inspection',
        'crawl-space-mold-inspection.php' => 'Crawl Space Mold Inspection',
        'condo-mold-inspection.php' => 'Condo Mold Inspection',
        'commercial-mold-inspection.php' => 'Commercial Mold Inspection',
        'air-quality-testing.php' => 'Air Quality Testing',
    ];
}

function service_areas(): array
{
    return ['Ambleside', 'Dundarave', 'British Properties', 'Caulfeild', 'Horseshoe Bay', 'Eagle Harbour', 'Gleneagles', 'West Bay', 'Sentinel Hill', 'Upper Levels'];
}

function render_lead_form(string $source): void
{
    $status = $_GET['form'] ?? '';
    ?>
    <aside class="lead-card" aria-labelledby="request-help-title">
      <p class="form-kicker">Request a callback</p>
      <h2 id="request-help-title">Tell us what you found</h2>
      <p class="form-intro">Send a few details and we’ll follow up about your West Vancouver property.</p>
      <?php if ($status === 'success'): ?><div class="form-alert success" role="status">Thank you. Your request was sent successfully.</div><?php endif; ?>
      <?php if ($status === 'error'): ?><div class="form-alert error" role="alert">We couldn’t send your request. Please call (604) 800-3900.</div><?php endif; ?>
      <form class="lead-form" action="/form-handler.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="source_page" value="<?= e($source) ?>">
        <input type="hidden" name="recaptcha_token" value="">
        <div class="hp-field" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <label>Full name <span>*</span><input type="text" name="full_name" maxlength="100" autocomplete="name" required></label>
        <div class="form-row">
          <label>Email <span>*</span><input type="email" name="email" maxlength="150" autocomplete="email" required></label>
          <label>Phone number <span>*</span><input type="tel" name="phone" maxlength="30" autocomplete="tel" required></label>
        </div>
        <label>Message <span>*</span><textarea name="message" rows="4" maxlength="2000" required placeholder="Where is the issue and what are you seeing?"></textarea></label>
        <button type="submit">Request an assessment <span aria-hidden="true">→</span></button>
        <p class="form-note">Protected by reCAPTCHA. Google’s Privacy Policy and Terms apply.</p>
      </form>
    </aside>
    <?php
}

function render_faq_schema(array $faqs): string
{
    $entities = [];
    foreach ($faqs as $faq) {
        $entities[] = [
            '@type' => 'Question',
            'name' => $faq[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($faq[1])],
        ];
    }
    return json_encode(['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $entities], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
