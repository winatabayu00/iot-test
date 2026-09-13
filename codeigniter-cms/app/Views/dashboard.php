<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1>Dashboard</h1>
<div class="cards">
<div class="card"><strong><?= esc($totalProducts) ?></strong><br>Products</div>
<div class="card"><strong><?= esc($totalCustomers) ?></strong><br>Customers</div>
<div class="card"><strong><?= esc($totalTransactions) ?></strong><br>Transactions</div>
<div class="card"><strong><?= esc(number_format((float) $totalSales, 2)) ?></strong><br>Total Sales</div>
</div>
<h2>Recent Transactions</h2>
<?php if ($recentTransactions === []): ?><p>No transactions yet.</p><?php else: ?>
<table><tr><th>Number</th><th>Customer</th><th>Total</th><th>Date</th></tr>
<?php foreach ($recentTransactions as $t): ?>
<tr><td><a href="/transactions/<?= esc($t['id']) ?>"><?= esc($t['transaction_number']) ?></a></td><td><?= esc($t['customer_name']) ?></td><td><?= esc(number_format((float) $t['total_amount'], 2)) ?></td><td><?= esc($t['created_at']) ?></td></tr>
<?php endforeach; ?></table>
<?php endif; ?>
<?= $this->endSection() ?>
