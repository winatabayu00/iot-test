<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1>Products</h1>
<p><a href="/products/new">+ New Product</a></p>
<?php if ($products === []): ?><p>No products yet.</p><?php else: ?>
<table><tr><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th></tr>
<?php foreach ($products as $p): ?>
<tr><td><?= esc($p['name']) ?></td><td><?= esc(number_format((float) $p['price'], 2)) ?></td><td><?= esc($p['stock']) ?></td>
<td><a href="/products/<?= esc($p['id']) ?>/edit">Edit</a>
<form class="inline" method="post" action="/products/<?= esc($p['id']) ?>/delete" onsubmit="return confirm('Delete?')"><button>Delete</button></form></td></tr>
<?php endforeach; ?></table>
<?php endif; ?>
<?= $this->endSection() ?>
