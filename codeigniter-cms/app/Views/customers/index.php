<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1>Customers</h1>
<p><a href="/customers/new">+ New Customer</a></p>
<?php if ($customers === []): ?><p>No customers yet.</p><?php else: ?>
<table><tr><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>
<?php foreach ($customers as $c): ?>
<tr><td><?= esc($c['name']) ?></td><td><?= esc($c['email'] ?? '-') ?></td><td><?= esc($c['phone'] ?? '-') ?></td>
<td><a href="/customers/<?= esc($c['id']) ?>/edit">Edit</a>
<form class="inline" method="post" action="/customers/<?= esc($c['id']) ?>/delete" onsubmit="return confirm('Delete?')"><button>Delete</button></form></td></tr>
<?php endforeach; ?></table>
<?php endif; ?>
<?= $this->endSection() ?>
