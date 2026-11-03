<?php
require __DIR__ . '/layout.php';
$proofPath = '/u/p.php';
$proofExists = is_file($proofPath);
if ($proofExists) {
    header('Cache-Control: no-store');
    header('Location: /uploads/p.php', true, 302);
    exit;
}
page_start('Live status', 'status', true);
?>
<section class="page-heading">
  <p class="eyebrow">PUBLIC SERVICE · LIVE STATUS</p>
  <h1>Watching the public page</h1>
  <p class="lead">This screen will open the changed page when the site content is replaced.</p>
</section>

<section class="result waiting" role="status" aria-live="polite">
  <p class="eyebrow">CONTENT UNCHANGED</p>
  <h2>Waiting for a page change</h2>
  <p>Leave this page open. It checks again every two seconds.</p>
</section>

<p class="back-link"><a href="/guide.php">Review the four stages →</a></p>
<?php page_end(); ?>
