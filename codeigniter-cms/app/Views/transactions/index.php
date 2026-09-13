<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1>Transactions</h1>
<p><a href="/transactions/new">+ New Transaction</a></p>
<?php if ($transactions === []): ?><p>No transactions yet.</p><?php else: ?>
<table><tr><th>Number</th><th>Customer</th><th>Method</th><th>Total</th><th>Date</th></tr>
<?php foreach ($transactions as $t): ?>
<tr><td><a href="/transactions/<?= esc($t['id']) ?>"><?= esc($t['transaction_number']) ?></a></td><td><?= esc($t['customer_name']) ?></td><td><?= esc($t['payment_method']) ?></td><td><?= esc(number_format((float) $t['total_amount'], 2)) ?></td><td><?= esc($t['created_at']) ?></td></tr>
<?php endforeach; ?></table>
<?php endif; ?>
<?= $this->endSection() ?>
