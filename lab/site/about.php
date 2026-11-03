<?php
require __DIR__ . '/journal-layout.php';

journal_header(
    'About — Lane & Ladle',
    'About',
    'Lane & Ladle is an independent Dhaka journal about food, neighbourhoods, people and everyday city life.'
);
?>

<section class="about-page">
  <div class="about-copy">
    <p class="kicker">About the journal</p>
    <h1>A journal about the city, one meal at a time.</h1>
    <p class="about-lead">Lane &amp; Ladle is a small, independent publication about Dhaka. We write about the food people cook, the streets they walk, and the small rituals that make a city feel like a neighbourhood.</p>
    <p>We are less interested in the polished version of a place than in the ordinary version: the tea stall that opens before sunrise, the vendor who knows your order, the lane that changes character in the rain. The city is full of these details. We try to slow down long enough to notice them.</p>
    <p>Our journal is organised into four sections. <strong>Food</strong> is about markets, kitchens and the things we cook. <strong>Neighborhoods</strong> is about lanes, corners and the shape of the city. <strong>People</strong> is about the hands and voices behind everyday life. <strong>City Life</strong> is about weather, work and the rhythm of Dhaka.</p>
    <p>We publish when we have something worth sharing, not on a fixed schedule. The journal is independent, reader-supported and made in Dhaka.</p>
  </div>

  <figure class="about-figure">
    <img src="/assets/market-aubergine.webp" alt="Fresh aubergines and gourds stacked in a market basket" width="1000" height="750" loading="lazy">
    <figcaption>The market keeps its own calendar.</figcaption>
  </figure>
</section>

<section class="about-sections">
  <div class="section-head">
    <div>
      <p class="kicker">What we cover</p>
      <h2>Four sections</h2>
    </div>
  </div>
  <div class="section-grid section-grid--text">
    <?php $index = 0; ?>
    <?php foreach (journal_sections() as $name => $blurb): ?>
      <?php $index++; ?>
      <a class="section-tile section-tile--text section-tile--<?= journal_h(journal_section_class($name)) ?>" href="/index.php?section=<?= urlencode($name) ?>">
        <span class="section-index" aria-hidden="true"><?= str_pad((string) $index, 2, '0', STR_PAD_LEFT) ?></span>
        <span class="section-tile-content">
          <span class="section-name"><?= journal_h($name) ?></span>
          <span class="section-blurb"><?= journal_h($blurb) ?></span>
          <span class="section-arrow">Read the section</span>
        </span>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="about-contact">
  <div>
    <p class="kicker">The desk</p>
    <h2>Say hello.</h2>
    <p>Story ideas, corrections and long letters about lunch are all welcome.</p>
  </div>
  <a class="text-link" href="mailto:desk@laneandladle.example">desk@laneandladle.example</a>
</section>

<?php journal_footer(); ?>
