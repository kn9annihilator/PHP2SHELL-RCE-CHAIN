<?php
require __DIR__ . '/journal-layout.php';

$posts = journal_posts();
$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
$post = null;

foreach ($posts as $candidate) {
    if ($candidate['slug'] === $slug) {
        $post = $candidate;
        break;
    }
}

if ($post === null) {
    http_response_code(404);
    journal_header('Story not found — Lane & Ladle', '', 'The story you are looking for is not here.');
    ?>
    <section class="not-found">
      <p class="kicker">404</p>
      <h1>That story is not here.</h1>
      <p>The link may be old, or the story may have moved. The rest of the journal is still waiting.</p>
      <a class="text-link" href="/index.php">Back to all stories</a>
    </section>
    <?php
    journal_footer();
    exit;
}

$related = array_values(array_filter(
    $posts,
    static fn (array $candidate): bool => $candidate['section'] === $post['section'] && $candidate['slug'] !== $post['slug']
));

if (count($related) < 3) {
    foreach ($posts as $candidate) {
        if ($candidate['slug'] === $post['slug']) {
            continue;
        }
        $alreadyAdded = false;
        foreach ($related as $existing) {
            if ($existing['slug'] === $candidate['slug']) {
                $alreadyAdded = true;
                break;
            }
        }
        if (!$alreadyAdded) {
            $related[] = $candidate;
        }
        if (count($related) >= 3) {
            break;
        }
    }
}

$related = array_slice($related, 0, 3);

journal_header($post['title'] . ' — Lane & Ladle', $post['section'], $post['dek']);
?>

<nav class="breadcrumbs" aria-label="Breadcrumb">
  <a href="/index.php">Home</a>
  <span aria-hidden="true">/</span>
  <a href="/index.php?section=<?= urlencode($post['section']) ?>"><?= journal_h($post['section']) ?></a>
</nav>

<article class="post">
  <header class="post-header">
    <p class="kicker kicker--<?= journal_h(journal_section_class($post['section'])) ?>"><?= journal_h($post['section']) ?></p>
    <h1><?= journal_h($post['title']) ?></h1>
    <p class="post-dek"><?= journal_h($post['dek']) ?></p>
    <p class="byline">By <strong><?= journal_h($post['author']) ?></strong> <span>·</span> <?= journal_h(journal_date($post['date'])) ?> <span>·</span> <?= journal_h($post['read']) ?></p>
  </header>

  <figure class="post-hero">
    <img src="<?= journal_h($post['image']) ?>" alt="<?= journal_h($post['image_alt']) ?>" width="1000" height="750" fetchpriority="high">
    <figcaption><?= journal_h($post['image_alt']) ?></figcaption>
  </figure>

  <div class="post-body">
    <?php foreach ($post['body'] as $index => $paragraph): ?>
      <p><?= journal_h($paragraph) ?></p>
      <?php if (!empty($post['quote']) && $index === 1): ?>
        <blockquote>
          <p><?= journal_h($post['quote']) ?></p>
        </blockquote>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <footer class="post-footer">
    <p>Filed under <a href="/index.php?section=<?= urlencode($post['section']) ?>"><?= journal_h($post['section']) ?></a></p>
    <a class="text-link" href="/index.php">Back to all stories</a>
  </footer>
</article>

<?php if ($related): ?>
  <section class="related">
    <div class="section-head">
      <div>
        <p class="kicker">Keep reading</p>
        <h2>More from the journal</h2>
      </div>
    </div>
    <div class="story-grid">
      <?php foreach ($related as $item): ?>
        <?php journal_card($item); ?>
      <?php endforeach; ?>
    </div>
  </section>
<?php endif; ?>

<?php journal_footer(); ?>
