<?php
require __DIR__ . '/journal-layout.php';

$posts = journal_posts();
$sections = journal_sections();
$section = isset($_GET['section']) ? trim((string) $_GET['section']) : '';

if ($section !== '' && !array_key_exists($section, $sections)) {
    $section = '';
}

$visible = $section === ''
    ? $posts
    : array_values(array_filter($posts, static fn (array $post): bool => $post['section'] === $section));

$lead = $posts[0];
$gridPosts = $section === ''
    ? array_slice(array_values(array_filter($posts, static fn (array $post): bool => $post['slug'] !== $lead['slug'])), 0, 6)
    : $visible;

$mostRead = array_slice($posts, 1, 4);

$sectionLeads = [];
foreach ($posts as $post) {
    if (!isset($sectionLeads[$post['section']])) {
        $sectionLeads[$post['section']] = $post;
    }
}

$title = $section === ''
    ? 'Lane & Ladle — A journal of food and city life'
    : $section . ' — Lane & Ladle';
$description = $section === ''
    ? 'An independent Dhaka journal about food, neighbourhoods, people and everyday city life.'
    : $sections[$section];

journal_header($title, $section === '' ? 'Home' : $section, $description);
?>

<?php if ($section !== ''): ?>
  <section class="section-intro">
    <p class="kicker">Section</p>
    <h1><?= journal_h($section) ?></h1>
    <p class="section-intro-dek"><?= journal_h($sections[$section]) ?></p>
    <a class="text-link" href="/index.php">All stories</a>
  </section>
<?php else: ?>
  <section class="front">
    <article class="lead">
      <a class="lead-media" href="/post.php?slug=<?= journal_h($lead['slug']) ?>">
        <img src="<?= journal_h($lead['image']) ?>" alt="<?= journal_h($lead['image_alt']) ?>" width="1536" height="1024" fetchpriority="high">
      </a>
      <div class="lead-copy">
        <p class="kicker kicker--<?= journal_h(journal_section_class($lead['section'])) ?>"><?= journal_h($lead['section']) ?></p>
        <h1><a href="/post.php?slug=<?= journal_h($lead['slug']) ?>"><?= journal_h($lead['title']) ?></a></h1>
        <p class="dek"><?= journal_h($lead['dek']) ?></p>
        <p class="byline">By <strong><?= journal_h($lead['author']) ?></strong> <span>·</span> <?= journal_h(journal_date($lead['date'])) ?> <span>·</span> <?= journal_h($lead['read']) ?></p>
        <a class="text-link" href="/post.php?slug=<?= journal_h($lead['slug']) ?>">Read the story</a>
      </div>
    </article>

    <aside class="rail">
      <section class="rail-block">
        <h2>Most read</h2>
        <ol class="rail-list">
          <?php foreach ($mostRead as $index => $post): ?>
            <li>
              <span class="rail-number"><?= $index + 1 ?></span>
              <div>
                <p class="kicker kicker--<?= journal_h(journal_section_class($post['section'])) ?>"><?= journal_h($post['section']) ?></p>
                <a href="/post.php?slug=<?= journal_h($post['slug']) ?>"><?= journal_h($post['title']) ?></a>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
      </section>

      <section class="rail-block rail-about">
        <h2>The journal</h2>
        <p>Lane &amp; Ladle is an independent journal about the food, people and small rituals that make up a city.</p>
        <a class="text-link" href="/about.php">About the journal</a>
      </section>
    </aside>
  </section>
<?php endif; ?>

<section class="latest">
  <div class="section-head">
    <div>
      <p class="kicker"><?= $section === '' ? 'The latest' : 'More in ' . journal_h($section) ?></p>
      <h2><?= $section === '' ? 'Stories from the city' : 'Keep reading' ?></h2>
    </div>
    <p class="section-note"><?= $section === '' ? 'Food, neighbourhoods and the people who keep the city moving.' : 'A slower look at the places and people around us.' ?></p>
  </div>

  <?php if ($gridPosts): ?>
    <div class="story-grid<?= $section !== '' ? ' story-grid--section' : '' ?><?= count($gridPosts) === 1 ? ' story-grid--single' : '' ?>">
      <?php foreach ($gridPosts as $post): ?>
        <?php journal_card($post); ?>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="empty-note">No stories in this section yet.</p>
  <?php endif; ?>
</section>

<section class="sections">
  <div class="section-head">
    <div>
      <p class="kicker">Browse</p>
      <h2>Explore the journal</h2>
    </div>
    <p class="section-note">Four ways into the city.</p>
  </div>

  <div class="section-grid">
    <?php foreach ($sections as $name => $blurb): ?>
      <?php
      $count = count(array_filter($posts, static fn (array $post): bool => $post['section'] === $name));
      $leadPost = $sectionLeads[$name] ?? $lead;
      ?>
      <a class="section-tile section-tile--<?= journal_h(journal_section_class($name)) ?>" href="/index.php?section=<?= urlencode($name) ?>">
        <img src="<?= journal_h($leadPost['image']) ?>" alt="" width="1000" height="750" loading="lazy">
        <span class="section-tile-shade" aria-hidden="true"></span>
        <span class="section-tile-content">
          <span class="section-count"><?= $count ?> <?= $count === 1 ? 'story' : 'stories' ?></span>
          <span class="section-name"><?= journal_h($name) ?></span>
          <span class="section-blurb"><?= journal_h($blurb) ?></span>
          <span class="section-arrow">Read the section</span>
        </span>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<?php if ($section === ''): ?>
  <section class="about-band">
    <div class="about-band-media">
      <img src="/assets/market-aubergine.webp" alt="Fresh aubergines and gourds stacked in a market basket" width="1000" height="750" loading="lazy">
    </div>
    <div class="about-band-copy">
      <p class="kicker">The journal</p>
      <h2>Food is how the city introduces itself.</h2>
      <p>Lane &amp; Ladle is a small, independent journal about Dhaka: the markets before sunrise, the lanes that remember, and the people who make the city feel like a neighbourhood.</p>
      <a class="text-link text-link--light" href="/about.php">More about the journal</a>
    </div>
  </section>
<?php endif; ?>

<?php journal_footer(); ?>
