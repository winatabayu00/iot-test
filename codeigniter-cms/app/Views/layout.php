<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title ?? 'Wrapstation CMS') ?></title>
<style>
body{font-family:system-ui,sans-serif;max-width:960px;margin:0 auto;padding:1rem}
nav a{margin-right:1rem}
table{border-collapse:collapse;width:100%}
th,td{border:1px solid #ccc;padding:.4rem .6rem;text-align:left}
.alert{padding:.5rem;margin:.5rem 0;border:1px solid #ccc}
.alert.success{background:#e6ffed}.alert.error{background:#ffe6e6}
form.inline{display:inline}
.cards{display:flex;gap:1rem;flex-wrap:wrap}
.card{border:1px solid #ccc;padding:1rem;min-width:140px}
</style>
</head>
<body>
<nav>
<a href="/">Dashboard</a><a href="/products">Products</a><a href="/customers">Customers</a><a href="/transactions">Transactions</a><a href="/transactions/new">New Transaction</a>
</nav>
<?php if (session('success')): ?><p class="alert success"><?= esc(session('success')) ?></p><?php endif; ?>
<?php if (session('error')): ?><p class="alert error"><?= esc(session('error')) ?></p><?php endif; ?>
<?php if (session('errors')): ?><div class="alert error"><ul><?php foreach (session('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<?= $this->renderSection('content') ?>
</body>
</html>
