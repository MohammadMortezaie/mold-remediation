<?php
require_once __DIR__ . '/functions.php';
$page_title = $page_title ?? 'Mold Remediation West Vancouver - (604) 800-3900';
$meta_description = $meta_description ?? 'Mold remediation services in West Vancouver. Call (604) 800-3900.';
$canonical_path = $canonical_path ?? '';
$hero_image = $hero_image ?? 'image/inspecting-mold.webp';
$hero_alt = $hero_alt ?? 'Mold remediation specialist in West Vancouver';
$schema_type = $schema_type ?? 'HomeAndConstructionBusiness';
$recaptcha_site_key = env_value('RECAPTCHA_SITE_KEY');
$services = service_pages();
$areas = service_areas();
$current_page = basename((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
$business_schema = [
    '@context' => 'https://schema.org',
    '@type' => $schema_type,
    '@id' => site_url() . '#business',
    'name' => 'Mold Remediation West Vancouver',
    'url' => site_url(),
    'telephone' => '+1-604-800-3900',
    'logo' => site_url('image/west-vancouver-mold-logo.svg'),
    'image' => site_url('image/inspecting-mold.webp'),
    'description' => 'Mold assessment, testing, inspection and remediation support for residential and commercial properties in West Vancouver, British Columbia.',
    'areaServed' => ['@type' => 'City', 'name' => 'West Vancouver'],
];
?>
<!doctype html>
<html lang="en-CA">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($page_title) ?></title>
  <meta name="description" content="<?= e($meta_description) ?>">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <link rel="canonical" href="<?= e(site_url($canonical_path)) ?>">
  <link rel="icon" href="/image/west-vancouver-mold-logo.svg" type="image/svg+xml">
  <link rel="stylesheet" href="/style.css?v=2">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_CA">
  <meta property="og:site_name" content="Mold Remediation West Vancouver">
  <meta property="og:title" content="<?= e($page_title) ?>">
  <meta property="og:description" content="<?= e($meta_description) ?>">
  <meta property="og:url" content="<?= e(site_url($canonical_path)) ?>">
  <meta property="og:image" content="<?= e(site_url($hero_image)) ?>">
  <meta property="og:image:alt" content="<?= e($hero_alt) ?>">
  <meta name="twitter:card" content="summary_large_image">
  <script type="application/ld+json"><?= json_encode($business_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
  <?php if (array_key_exists($canonical_path, service_pages())): ?>
  <script type="application/ld+json"><?= json_encode(['@context'=>'https://schema.org','@type'=>'Service','name'=>service_pages()[$canonical_path] . ' in West Vancouver','url'=>site_url($canonical_path),'description'=>$meta_description,'serviceType'=>service_pages()[$canonical_path],'areaServed'=>['@type'=>'City','name'=>'West Vancouver'],'provider'=>['@id'=>site_url() . '#business']], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
  <?php endif; ?>
  <?php if (!empty($faqs)): ?><script type="application/ld+json"><?= render_faq_schema($faqs) ?></script><?php endif; ?>
  <?php if (!empty($breadcrumb_name)): ?>
  <script type="application/ld+json"><?= json_encode(['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>[['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>site_url()],['@type'=>'ListItem','position'=>2,'name'=>$breadcrumb_name,'item'=>site_url($canonical_path)]]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
  <?php endif; ?>
</head>
<body data-recaptcha-site-key="<?= e($recaptcha_site_key) ?>">
  <a class="skip" href="#main">Skip to content</a>
  <header class="site-header">
    <div class="topline">Same day mold inspection in Vancouver</div>
    <div class="nav wrap">
      <a class="brand" href="/" aria-label="West Vancouver Mold Services home">
        <img src="/image/west-vancouver-mold-logo.svg" alt="" width="64" height="64">
        <span class="brand-copy"><strong>West Vancouver Mold</strong><span>Inspection • Testing • Remediation</span></span>
      </a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-navigation" aria-label="Open navigation">☰</button>
      <nav class="nav-links" id="main-navigation" aria-label="Main navigation">
        <a href="/"<?= $current_page === 'index.php' ? ' aria-current="page"' : '' ?>>Home</a>
        <details class="nav-menu"><summary>Services</summary><div class="nav-dropdown"><?php foreach ($services as $url => $label): ?><a href="/<?= e($url) ?>"<?= $current_page === $url ? ' aria-current="page"' : '' ?>><?= e($label) ?></a><?php endforeach; ?></div></details>
        <details class="nav-menu"><summary>Areas</summary><div class="nav-dropdown areas-dropdown"><?php foreach ($areas as $area): ?><a href="/#service-areas"><?= e($area) ?></a><?php endforeach; ?></div></details>
        <a href="/about.php"<?= $current_page === 'about.php' ? ' aria-current="page"' : '' ?>>About</a>
        <a href="/contact.php"<?= $current_page === 'contact.php' ? ' aria-current="page"' : '' ?>>Contact</a>
      </nav>
      <a class="phone phone-header" href="tel:+16048003900"><span>Call for help</span><strong>(604) 800-3900</strong></a>
    </div>
  </header>
  <section class="trust-strip" aria-label="Credentials and service benefits"><div class="wrap trust-grid">
    <div class="trust-item"><img src="/image/IICRCLogo-certificate.webp" alt="IICRC certificate logo"><span>IICRC Certified</span></div>
    <div class="trust-item"><img src="/image/VRCALogo-certificate.webp" alt="VRCA certificate logo"><span>VRCA Certificate</span></div>
    <div class="trust-item"><span class="trust-icon" aria-hidden="true">CA</span><span>Proudly Canadian</span></div>
    <div class="trust-item"><span class="trust-icon" aria-hidden="true">✓</span><span>Fast Response</span></div>
    <div class="trust-item"><span class="trust-icon" aria-hidden="true">✓</span><span>Clear Reports</span></div>
    <div class="trust-item"><span class="trust-icon" aria-hidden="true">✓</span><span>Local Team</span></div>
  </div></section>
  <?php if ($canonical_path !== ''): ?><div class="breadcrumbs"><div class="wrap"><a href="/">Home</a> <span aria-hidden="true">›</span> <?= e($breadcrumb_name ?? $page_title) ?></div></div><?php endif; ?>
  <main id="main">
