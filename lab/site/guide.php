<?php
require __DIR__ . '/layout.php';
page_start('How it works', 'guide');
?>
<section class="page-heading">
  <p class="eyebrow">SAHMSEC LAB · THE REQUEST, STEP BY STEP</p>
  <h1>What the PoC changes in memory</h1>
  <p class="lead">The exploit does not use a feature in this demo website. The vulnerable code is in PHP's request handling and cleanup.</p>
</section>

<section class="timeline">
  <article class="step"><span class="step-number">1</span><div><h2>Reach the vulnerable path</h2><p>The client sends multipart HTTP requests. Apache's PHP module parses the body before the page's PHP code runs. A large request exceeds PHP's <code>memory_limit</code> while remaining below the configured POST-size limit.</p></div></article>
  <article class="step"><span class="step-number">2</span><div><h2>Learn this process's addresses</h2><p>Address randomization moves memory each time the worker starts. The first leak finds the PHP heap; the second finds the loaded PHP library. The runner reads the function offsets from the pinned container image.</p></div></article>
  <article class="step"><span class="step-number">3</span><div><h2>Shape data PHP later cleans up</h2><p>The final request places forged PHP data structures where cleanup will use them. The crafted structure directs a function call to PHP's command function.</p></div></article>
  <article class="step"><span class="step-number">4</span><div><h2>See the altered page</h2><p>The fixed command <code>cp /a /u/p.php</code> copies a prepared PHP page into the site's writable uploads folder. The status screen detects the change and opens <a href="/uploads/p.php">/uploads/p.php</a>.</p></div></article>
</section>

<section class="callout"><h2>What to look for in the terminal</h2><p><code>heap address</code> and <code>PHP library address</code> show the two leak stages. The final stage creates the fixed PHP page, which then becomes visible at <code>/uploads/p.php</code>.</p><p>The page is a static defacement-style notice. It has no command input.</p></section>
<?php page_end(); ?>
