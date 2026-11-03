<?php

if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === basename(__FILE__)) {
    http_response_code(404);
    exit;
}

function journal_posts(): array
{
    static $posts = null;
    if ($posts === null) {
        $posts = require __DIR__ . '/posts.php';
    }
    return $posts;
}

function journal_sections(): array
{
    return [
        'Food' => 'Markets, kitchens and the things we cook.',
        'Neighborhoods' => 'Lanes, corners and the shape of the city.',
        'People' => 'The hands and voices behind everyday life.',
        'City Life' => 'Weather, work and the rhythm of Dhaka.',
    ];
}

function journal_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function journal_date(string $date): string
{
    $timestamp = strtotime($date);
    return $timestamp ? date('j M Y', $timestamp) : $date;
}

function journal_section_class(string $section): string
{
    return strtolower(preg_replace('/[^a-z0-9]+/i', '-', $section) ?? $section);
}

function journal_header(string $title, string $active = '', string $description = ''): void
{
    $sections = journal_sections();
    $description = $description !== ''
        ? $description
        : 'Lane & Ladle is an independent journal about food, people and everyday city life in Dhaka.';
    ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f3ede2">
  <meta name="description" content="<?= journal_h($description) ?>">
  <title><?= journal_h($title) ?></title>
  <link rel="stylesheet" href="/journal.css">
</head>
<body>
  <a class="skip-link" href="#main">Skip to content</a>

  <div class="utility">
    <div class="shell utility-inner">
      <p>Dhaka, Bangladesh</p>
      <p class="utility-note">Independent journal · Est. 2024</p>
      <p><?= date('l, j F Y') ?></p>
    </div>
  </div>

  <header class="masthead">
    <div class="shell masthead-inner">
      <a class="wordmark" href="/index.php" aria-label="Lane and Ladle home">
        <span>Lane</span><span class="wordmark-amp">&amp;</span><span>Ladle</span>
      </a>
      <p class="tagline">A journal of food and city life</p>
    </div>
    <nav class="site-nav" aria-label="Main navigation">
      <div class="shell nav-inner">
        <a<?= $active === 'Home' ? ' aria-current="page"' : '' ?> href="/index.php">Home</a>
        <?php foreach ($sections as $section => $blurb): ?>
          <a<?= $active === $section ? ' aria-current="page"' : '' ?> href="/index.php?section=<?= urlencode($section) ?>"><?= journal_h($section) ?></a>
        <?php endforeach; ?>
        <a<?= $active === 'About' ? ' aria-current="page"' : '' ?> href="/about.php">About</a>
      </div>
    </nav>
  </header>

  <main id="main">
<?php
}

function journal_footer(): void
{
    $sections = journal_sections();
    ?>
  </main>

  <footer class="site-footer">
    <div class="shell footer-grid">
      <div class="footer-brand">
        <a class="wordmark wordmark--footer" href="/index.php">Lane <span class="wordmark-amp">&amp;</span> Ladle</a>
        <p>A journal of food, people and everyday city life in Dhaka.</p>
      </div>
      <nav class="footer-nav" aria-label="Sections">
        <h2>Sections</h2>
        <?php foreach ($sections as $section => $blurb): ?>
          <a href="/index.php?section=<?= urlencode($section) ?>"><?= journal_h($section) ?></a>
        <?php endforeach; ?>
      </nav>
      <div class="footer-meta">
        <h2>The desk</h2>
        <p>Independent, reader-supported and made in Dhaka.</p>
        <a href="/about.php">About the journal</a>
        <a href="/status.php">Service status</a>
      </div>
    </div>
    <div class="shell footer-bottom">
      <p>© <?= date('Y') ?> Lane &amp; Ladle. Dhaka.</p>
      <a href="#main">Back to top</a>
    </div>
  </footer>
</body>
</html>
<?php
}

function journal_card(array $post, string $class = ''): void
{
    $classes = trim('story-card ' . $class);
    $sectionClass = journal_section_class($post['section']);
    ?>
    <article class="<?= journal_h($classes) ?>">
      <a class="story-card-media" href="/post.php?slug=<?= journal_h($post['slug']) ?>" tabindex="-1" aria-hidden="true">
        <img src="<?= journal_h($post['image']) ?>" alt="<?= journal_h($post['image_alt']) ?>" width="1000" height="750" loading="lazy">
      </a>
      <div class="story-card-body">
        <p class="kicker kicker--<?= journal_h($sectionClass) ?>"><?= journal_h($post['section']) ?></p>
        <h3><a href="/post.php?slug=<?= journal_h($post['slug']) ?>"><?= journal_h($post['title']) ?></a></h3>
        <p class="story-card-dek"><?= journal_h($post['dek']) ?></p>
        <p class="meta"><?= journal_h(journal_date($post['date'])) ?> <span>·</span> <?= journal_h($post['read']) ?></p>
      </div>
    </article>
    <?php
}
