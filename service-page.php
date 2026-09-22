<?php
if (empty($page) || !is_array($page)) {
    http_response_code(500);
    exit('Page configuration missing.');
}

$page_title = $page['title'];
$meta_description = $page['description'];
$canonical_path = $page['path'];
$breadcrumb_name = $page['breadcrumb'];
$hero_image = $page['hero_image'];
$hero_alt = $page['hero_alt'];
$faqs = $page['faqs'];
require __DIR__ . '/header.php';
?>
<section class="hero">
  <img class="hero-image" src="/<?= e($page['hero_image']) ?>" alt="<?= e($page['hero_alt']) ?>" width="1920" height="1080" fetchpriority="high">
  <div class="hero-shade"></div>
  <div class="wrap hero-grid">
    <div class="hero-copy">
      <p class="eyebrow"><?= e($page['eyebrow']) ?></p>
      <h1><?= $page['h1'] ?></h1>
      <p class="lead"><?= e($page['lead']) ?></p>
      <ul class="hero-points"><?php foreach ($page['hero_points'] as $point): ?><li><?= e($point) ?></li><?php endforeach; ?></ul>
    </div>
    <?php render_lead_form($page['path']); ?>
  </div>
</section>

<section class="intro section"><div class="wrap content-grid">
  <div><p class="eyebrow dark"><?= e($page['intro_kicker']) ?></p><h2><?= e($page['intro_heading']) ?></h2></div>
  <div class="prose"><?php foreach ($page['intro_paragraphs'] as $paragraph): ?><p><?= e($paragraph) ?></p><?php endforeach; ?></div>
</div></section>

<section class="section"><div class="wrap">
  <div class="content-grid"><div><p class="eyebrow dark"><?= e($page['concerns_kicker']) ?></p><h2><?= e($page['concerns_heading']) ?></h2></div><div class="prose"><?php foreach ($page['concerns_intro'] as $paragraph): ?><p><?= e($paragraph) ?></p><?php endforeach; ?></div></div>
  <div class="service-cards"><?php foreach ($page['concerns'] as $concern): ?><article class="service-card"><h3><?= e($concern[0]) ?></h3><p><?= e($concern[1]) ?></p></article><?php endforeach; ?></div>
</div></section>

<section class="process-section section"><div class="wrap process-grid">
  <div><p class="eyebrow">A clear local process</p><h2><?= e($page['process_heading']) ?></h2><p><?= e($page['process_intro']) ?></p></div>
  <ol class="steps"><?php foreach ($page['steps'] as $index => $step): ?><li><span><?= $index + 1 ?></span><div><h3><?= e($step[0]) ?></h3><p><?= e($step[1]) ?></p></div></li><?php endforeach; ?></ol>
</div></section>

<section class="image-content">
  <img src="/<?= e($page['secondary_image']) ?>" alt="<?= e($page['secondary_alt']) ?>" width="1920" height="1080" loading="lazy">
  <div class="image-copy"><p class="eyebrow dark"><?= e($page['detail_kicker']) ?></p><h2><?= e($page['detail_heading']) ?></h2><?php foreach ($page['detail_paragraphs'] as $paragraph): ?><p><?= e($paragraph) ?></p><?php endforeach; ?><ul class="check-list"><?php foreach ($page['detail_points'] as $point): ?><li><?= e($point) ?></li><?php endforeach; ?></ul></div>
</section>

<?php if (!empty($page['related_services'])): ?>
<section class="section"><div class="wrap">
  <div class="content-grid"><div><p class="eyebrow dark">Choose the right assessment</p><h2>Specialized mold inspection services</h2></div><div class="prose"><p>Different building areas create different moisture patterns. Explore the inspection service that best matches your concern.</p></div></div>
  <div class="service-cards"><?php foreach ($page['related_services'] as $service): ?><article class="service-card"><h3><?= e($service[0]) ?></h3><p><?= e($service[1]) ?></p><p><a href="/<?= e($service[2]) ?>">View <?= e(strtolower($service[0])) ?> →</a></p></article><?php endforeach; ?></div>
</div></section>
<?php endif; ?>

<section class="area-section section" id="service-areas"><div class="wrap area-grid">
  <div><p class="eyebrow dark">West Vancouver coverage</p><h2><?= e($page['local_heading']) ?></h2><?php foreach ($page['local_paragraphs'] as $paragraph): ?><p><?= e($paragraph) ?></p><?php endforeach; ?></div>
  <ul class="areas" aria-label="West Vancouver service neighbourhoods"><li>Ambleside</li><li>Dundarave</li><li>British Properties</li><li>Caulfeild</li><li>Horseshoe Bay</li><li>Eagle Harbour</li><li>Gleneagles</li><li>West Bay</li><li>Sentinel Hill</li><li>Upper Levels</li></ul>
</div></section>

<section class="section"><div class="wrap faq-grid">
  <div><p class="eyebrow dark">Questions from property owners</p><h2><?= e($page['faq_heading']) ?></h2></div>
  <div class="faq-list"><?php foreach ($page['faqs'] as $faq): ?><details><summary><?= e($faq[0]) ?><span>+</span></summary><p><?= e($faq[1]) ?></p></details><?php endforeach; ?></div>
</div></section>
<?php require __DIR__ . '/footer.php'; ?>
