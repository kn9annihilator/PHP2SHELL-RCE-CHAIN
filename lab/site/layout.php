<?php
function page_start(string $title, string $active, bool $refresh = false): void
{
    $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php if ($refresh): ?><meta http-equiv="refresh" content="2"><?php endif; ?>
  <title><?= $safeTitle ?> · SAHMSEC PHP2Shell lab</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <header class="topbar">
    <a class="brand" href="/index.php"><span class="brand-mark">S</span> SAHMSEC · PHP2Shell lab</a>
    <nav aria-label="Main navigation">
      <a<?= $active === 'home' ? ' aria-current="page"' : '' ?> href="/index.php">Overview</a>
      <a<?= $active === 'guide' ? ' aria-current="page"' : '' ?> href="/guide.php">How it works</a>
      <a<?= $active === 'status' ? ' aria-current="page"' : '' ?> href="/status.php">Live proof</a>
    </nav>
  </header>
  <main class="wrap">
<?php
}

function page_end(): void
{
    ?>
  </main>
  <footer class="footer">SAHMSEC classroom lab · PHP 8.4.26 · isolated Docker target</footer>
</body>
</html>
<?php
}
