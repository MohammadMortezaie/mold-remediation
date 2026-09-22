<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method not allowed');
}

function safe_return_path(string $source): string
{
    $allowed = array_merge(['', 'index.php', 'about.php', 'contact.php'], array_keys(service_pages()));
    $source = ltrim(parse_url($source, PHP_URL_PATH) ?: '', '/');
    return in_array($source, $allowed, true) ? '/' . $source : '/';
}

function fail_form(string $returnPath): never
{
    header('Location: ' . ($returnPath === '/' ? '/?form=error#request-help-title' : $returnPath . '?form=error#request-help-title'), true, 303);
    exit;
}

$returnPath = safe_return_path((string) ($_POST['source_page'] ?? ''));

if (!empty($_POST['website'])) {
    header('Location: ' . ($returnPath === '/' ? '/?form=success' : $returnPath . '?form=success'), true, 303);
    exit;
}

$postedCsrf = (string) ($_POST['csrf_token'] ?? '');
if ($postedCsrf === '' || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $postedCsrf)) {
    fail_form($returnPath);
}

$name = trim(str_replace(["\r", "\n"], ' ', strip_tags((string) ($_POST['full_name'] ?? ''))));
$email = filter_var(trim((string) ($_POST['email'] ?? '')), FILTER_VALIDATE_EMAIL);
$phone = trim(preg_replace('/[^0-9+().\-\s]/', '', (string) ($_POST['phone'] ?? '')) ?? '');
$message = trim(strip_tags((string) ($_POST['message'] ?? '')));

if ($name === '' || $email === false || strlen($phone) < 7 || $message === '' || strlen($name) > 100 || strlen($message) > 2000) {
    fail_form($returnPath);
}

$secret = env_value('RECAPTCHA_SECRET_KEY');
$token = (string) ($_POST['recaptcha_token'] ?? '');
$minimumScore = (float) env_value('RECAPTCHA_MIN_SCORE', '0.5');
if ($secret === '' || $token === '') {
    fail_form($returnPath);
}

$verifyPayload = http_build_query(['secret' => $secret, 'response' => $token]);
$verifyResult = false;
if (function_exists('curl_init')) {
    $curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt_array($curl, [CURLOPT_POST => true, CURLOPT_POSTFIELDS => $verifyPayload, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 8, CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded']]);
    $verifyResult = curl_exec($curl);
    curl_close($curl);
} elseif (ini_get('allow_url_fopen')) {
    $context = stream_context_create(['http' => ['method' => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n", 'content' => $verifyPayload, 'timeout' => 8]]);
    $verifyResult = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
}

$verification = is_string($verifyResult) ? json_decode($verifyResult, true) : null;
if (!is_array($verification) || empty($verification['success']) || ($verification['action'] ?? '') !== 'lead_form' || (float) ($verification['score'] ?? 0) < $minimumScore) {
    fail_form($returnPath);
}

$mailTo = filter_var(env_value('MAIL_TO'), FILTER_VALIDATE_EMAIL);
$mailFrom = filter_var(env_value('MAIL_FROM'), FILTER_VALIDATE_EMAIL);
$mailCc = env_value('MAIL_CC');
if ($mailTo === false || $mailFrom === false) {
    fail_form($returnPath);
}

$subject = 'West Vancouver mold website lead: ' . $name;
$body = "New website enquiry\n\nName: {$name}\nEmail: {$email}\nPhone: {$phone}\nSource page: {$returnPath}\n\nMessage:\n{$message}\n";
$headers = [
    'From: West Vancouver Mold Website <' . $mailFrom . '>',
    'Reply-To: ' . $email,
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . PHP_VERSION,
];
if ($mailCc !== '') {
    $validCc = array_filter(array_map('trim', explode(',', $mailCc)), static fn(string $address): bool => filter_var($address, FILTER_VALIDATE_EMAIL) !== false);
    if ($validCc) {
        $headers[] = 'Cc: ' . implode(', ', $validCc);
    }
}

if (!mail((string) $mailTo, $subject, $body, implode("\r\n", $headers))) {
    fail_form($returnPath);
}

unset($_SESSION['csrf_token']);
header('Location: ' . ($returnPath === '/' ? '/?form=success#request-help-title' : $returnPath . '?form=success#request-help-title'), true, 303);
exit;
