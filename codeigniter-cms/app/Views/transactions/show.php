<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h1><?= esc($trx['transaction_number']) ?></h1>
<p>Customer: <?= esc($trx['customer_name']) ?> (<?= esc($trx['customer_email'] ?? '-') ?>)<br>
Method: <?= esc($trx['payment_method']) ?><br>
Date: <?= esc($trx['created_at']) ?></p>
<table><tr><th>Product</th><th>Qty</th><th>Unit Price</th><th>Subtotal</th></tr>
<?php foreach ($items as $i): ?>
<tr><td><?= esc($i['product_name']) ?></td><td><?= esc($i['quantity']) ?></td><td><?= esc(number_format((float) $i['unit_price'], 2)) ?></td><td><?= esc(number_format((float) $i['subtotal'], 2)) ?></td></tr>
<?php endforeach; ?></table>
<p><strong>Grand Total: <?= esc(number_format((float) $trx['total_amount'], 2)) ?></strong></p>
<?= $this->endSection() ?>
